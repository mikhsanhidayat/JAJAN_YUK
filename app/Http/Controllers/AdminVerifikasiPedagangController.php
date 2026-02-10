<?php

namespace App\Http\Controllers;

use App\Models\Pedagang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminVerifikasiPedagangController extends Controller
{
    /**
     * Middleware: Hanya admin yang bisa akses
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware(function ($request, $next) {
            if ($request->user()->role !== 'admin') {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
            return $next($request);
        });
    }

    /**
     * Tampilkan list pedagang yang menunggu verifikasi
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
     * Tampilkan detail pedagang untuk verifikasi
     */
    public function show(Pedagang $pedagang): View
    {
        abort_if($pedagang->admin_status !== 'pending', 404);

        return view('admin.verifikasi-detail', compact('pedagang'));
    }

    /**
     * Approve pedagang - ubah status menjadi approved dan paid
     */
    public function approve(Pedagang $pedagang): RedirectResponse
    {
        abort_if($pedagang->admin_status !== 'pending', 403);

        $pedagang->update([
            'payment_status' => 'paid',
            'admin_status' => 'approved',
            'is_active' => true, // Otomatis aktif
        ]);

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', "Pedagang '{$pedagang->nama_toko}' berhasil diverifikasi dan sekarang aktif.");
    }

    /**
     * Reject pedagang dengan alasan
     */
    public function reject(Request $request, Pedagang $pedagang): RedirectResponse
    {
        abort_if($pedagang->admin_status !== 'pending', 403);

        $validated = $request->validate([
            'reject_reason' => ['required', 'string', 'max:500'],
        ]);

        // Hapus file bukti pembayaran jika ditolak (opsional)
        if ($pedagang->bukti_pembayaran && Storage::disk('public')->exists($pedagang->bukti_pembayaran)) {
            Storage::disk('public')->delete($pedagang->bukti_pembayaran);
        }

        $pedagang->update([
            'payment_status' => 'pending',
            'admin_status' => 'rejected',
            'is_active' => false,
            'bukti_pembayaran' => null, // Clear bukti pembayaran
        ]);

        // Bisa add note/reason ke tabel notes atau kirim email ke pedagang
        // Untuk sekarang cukup update status

        return redirect()
            ->route('admin.verifikasi.index')
            ->with('success', "Pendaftaran '{$pedagang->nama_toko}' ditolak.");
    }

    /**
     * Deactivate pedagang yang sudah aktif
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
     * Reactivate pedagang yang sudah dinonaktifkan
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
