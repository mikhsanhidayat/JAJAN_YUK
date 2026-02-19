<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
// Import yang dibutuhkan untuk middleware Laravel 11
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminVerifikasiPedagangController extends Controller implements HasMiddleware
{
    /**
     * Middleware: Menggantikan __construct di Laravel 11
     * Menangani keamanan akses hanya untuk Admin yang sudah login.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            new Middleware('verified'),
            // Fungsi penengah untuk cek role admin secara langsung
            function ($request, $next) {
                if ($request->user()->role !== 'admin') {
                    abort(403, 'Anda tidak memiliki akses ke halaman ini.');
                }
                return $next($request);
            },
        ];
    }

    /**
     * Tampilkan list pedagang yang menunggu verifikasi dan yang sudah disetujui
     */
    public function index(): View
    {
        $pedagangsWaiting = Pedagang::where('admin_status', 'pending')
            ->with('user')
            ->paginate(10);

        $pedagangsApproved = Pedagang::where('admin_status', 'approved')
            ->with('user')
            ->paginate(10);

        return view('admin.verifikasi-pedagang', compact('pedagangsWaiting', 'pedagangsApproved'));
    }

    /**
     * Tampilkan detail pedagang untuk verifikasi (cek foto bukti bayar, lokasi, dll)
     */
    public function show(Pedagang $pedagang): View
    {
        // Hanya bisa verifikasi pedagang yang statusnya masih pending
        abort_if($pedagang->admin_status !== 'pending', 404);

        return view('admin.verifikasi-detail', compact('pedagang'));
    }

    /**
     * Approve pedagang - Mengaktifkan toko agar muncul di peta JajanYuk
     */
    public function approve(Pedagang $pedagang): RedirectResponse
    {
        abort_if($pedagang->admin_status !== 'pending', 403);

        $pedagang->update([
            'payment_status' => 'paid',
            'admin_status' => 'approved',
            'is_active' => true, // Sekarang toko muncul di peta dashboard
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', "Pedagang '{$pedagang->nama_toko}' berhasil diverifikasi dan sekarang aktif.");
    }

    /**
     * Reject pedagang - Menolak dengan alasan tertentu
     */
    public function reject(Request $request, Pedagang $pedagang): RedirectResponse
    {
        abort_if($pedagang->admin_status !== 'pending', 403);

        $request->validate([
            'reject_reason' => ['required', 'string', 'max:500'],
        ]);

        // Hapus file bukti pembayaran yang salah/palsu agar storage tidak penuh
        if ($pedagang->bukti_pembayaran && Storage::disk('public')->exists($pedagang->bukti_pembayaran)) {
            Storage::disk('public')->delete($pedagang->bukti_pembayaran);
        }

        $pedagang->update([
            'payment_status' => 'pending',
            'admin_status' => 'rejected',
            'is_active' => false,
            'bukti_pembayaran' => null, 
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', "Pendaftaran '{$pedagang->nama_toko}' ditolak.");
    }

    /**
     * Nonaktifkan pedagang (Banned atau tutup sementara)
     */
    public function deactivate(Pedagang $pedagang): RedirectResponse
    {
        abort_if($pedagang->admin_status !== 'approved', 403);

        $pedagang->update([
            'is_active' => false,
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', "Pedagang '{$pedagang->nama_toko}' berhasil dinonaktifkan.");
    }

    /**
     * Aktifkan kembali pedagang
     */
    public function reactivate(Pedagang $pedagang): RedirectResponse
    {
        abort_if($pedagang->admin_status !== 'approved', 403);

        $pedagang->update([
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', "Pedagang '{$pedagang->nama_toko}' berhasil diaktifkan kembali.");
    }
}