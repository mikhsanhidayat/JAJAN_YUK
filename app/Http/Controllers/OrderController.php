<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for the buyer.
     */
    public function index()
    {
        $orders = Order::with(['pedagang', 'details.menu'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', compact('orders'));
    }

    /**
     * Display orders for the merchant.
     */
    public function merchantOrders()
    {
        $pedagang = Auth::user()->pedagang;
        
        if (!$pedagang) {
            return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar sebagai pedagang.');
        }

        $orders = Order::with(['user', 'details.menu'])
            ->where('pedagang_id', $pedagang->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pedagang.orders', compact('orders'));
    }

     /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pedagang_id' => 'required|exists:pedagangs,id',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:menus,id',
            'items.*.qty' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'waktu_pengambilan' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $externalId = 'ORD-' . time() . '-' . strtoupper(Str::random(5));
            $kodePengambilan = 'JY-' . strtoupper(Str::random(3));

            $totalHarga = 0;
            $orderDetailsData = [];

            foreach ($request->items as $item) {
                $menu = Menu::find($item['id']);
                $subtotal = $menu->harga_minimal * $item['qty'];
                $totalHarga += $subtotal;

                $orderDetailsData[] = [
                    'menu_id' => $menu->id,
                    'nama_produk_history' => $menu->nama_produk,
                    'jumlah' => $item['qty'],
                    'harga_satuan' => $menu->harga_minimal,
                    'subtotal' => $subtotal,
                ];
            }

            // --- INTEGRASI XENDIT ---
            Configuration::setXenditKey(config('services.xendit.key'));
            
            $apiInstance = new InvoiceApi();

            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id' => $externalId,
                'amount' => (double) $totalHarga,
                'payer_email' => Auth::user()->email,
                'description' => 'Pembayaran Pesanan Jajan Yuk - ' . $externalId,
                'invoice_duration' => 86400,
                'currency' => 'IDR',
                'reminder_time' => 1,
                'success_redirect_url' => route('payment.success'),
                'failure_redirect_url' => route('dashboard'),
            ]);

            $xenditInvoice = $apiInstance->createInvoice($createInvoiceRequest);
            $checkoutLink = $xenditInvoice['invoice_url'];
            // --- END INTEGRASI XENDIT ---

            $order = Order::create([
                'user_id' => Auth::id(),
                'pedagang_id' => $request->pedagang_id,
                'external_id' => $externalId,
                'total_harga' => $totalHarga,
                'payment_status' => 'pending',
                'checkout_link' => $checkoutLink,
                'catatan' => $request->catatan,
                'waktu_pengambilan' => $request->waktu_pengambilan,
                'kode_pengambilan' => $kodePengambilan,
                'order_status' => 'menunggu_pembayaran',
            ]);

            foreach ($orderDetailsData as $detail) {
                $order->details()->create($detail);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat! Silakan lanjut ke pembayaran.',
                'checkout_link' => $checkoutLink,
                'order' => $order
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating order: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Update the status of an order (for merchant).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:menunggu_pembayaran,diproses,siap_diambil,selesai,dibatalkan'
        ]);

        // Pastikan order milik pedagang yang sedang login
        if ($order->pedagang_id !== Auth::user()->pedagang->id) {
            return back()->with('error', 'Akses ditolak.');
        }

        $order->update([
            'order_status' => $request->order_status
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Callback for Xendit payment notification.
     */
    public function xenditCallback(Request $request)
    {
        Log::info('Xendit Callback Received:', $request->all());

        $externalId = $request->external_id;
        $status = $request->status;

        $order = Order::where('external_id', $externalId)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order tidak ditemukan'
            ], 404);
        }

        if ($status === 'PAID') {
            $order->update([
                'payment_status' => 'paid',
                'order_status' => 'diproses' // Pesanan otomatis diproses setelah bayar
            ]);
            Log::info("Order $externalId marked as PAID.");
        } elseif ($status === 'EXPIRED') {
            $order->update([
                'payment_status' => 'expired',
                'order_status' => 'dibatalkan'
            ]);
            Log::info("Order $externalId marked as EXPIRED.");
        }

        return response()->json([
            'success' => true,
            'message' => 'Callback berhasil diproses'
        ]);
    }

    public function checkStatus($externalId)
    {
        $order = Order::where('external_id', $externalId)->firstOrFail();
        return response()->json([
            'status' => $order->payment_status
        ]);
    }
}
