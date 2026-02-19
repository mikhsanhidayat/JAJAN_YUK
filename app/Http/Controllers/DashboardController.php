<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard with all available menus
     */
    public function index()
    {
        // Ambil semua menu dari semua pedagang yang aktif
        $menus = Menu::with(['pedagang', 'pedagang.user'])
                    ->whereHas('pedagang', function ($query) {
                        $query->where('is_active', true)
                              ->where('admin_status', 'approved');
                    })
                    ->latest()
                    ->get();

        return view('dashboard', compact('menus'));
    }
}
