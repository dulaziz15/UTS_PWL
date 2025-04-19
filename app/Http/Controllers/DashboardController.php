<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Models\Mobil;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Dashboard']
        ];


        $page = (object) [
            'title' => 'Dashboard'
        ];

        $activeMenu = 'dashboard';

        if (Auth::user()->role == RoleEnum::admin) {
            $transaksi = Transaksi::all();
        } else {
            $transaksi = Transaksi::where('user_id', Auth::user()->user_id);
        }
        $jumlahTersedia = Mobil::where('status', StatusEnum::tersedia)->count();
        $jumlahBooking = Mobil::where('status', StatusEnum::booking)->count();
        $jumlahSales = User::where('role', RoleEnum::user)->count();

        // membedakan data yang ditampilkan antara admin dan sales
        if (Auth::user()->role == RoleEnum::admin) {
            $totalUangDihasilkan = Mobil::where('status', StatusEnum::sold)
                ->sum('harga');

            $jumlahSold = Mobil::where('status', StatusEnum::sold)->count();
        } else {
            $totalUangDihasilkan = Mobil::where('status', StatusEnum::sold)
                ->whereHas('transaksi', function ($query) {
                    $query->where('user_id', Auth::user()->user_id);
                })
                ->sum('harga');

            $jumlahSold = Mobil::where('status', StatusEnum::sold)
                ->whereHas('transaksi', function ($query) {
                    $query->where('user_id', Auth::user()->user_id);
                })
                ->count();
        }

        return view('dashboard', compact('transaksi', 'breadcrumb', 'page', 'activeMenu', 'jumlahSold', 'jumlahBooking', 'jumlahTersedia', 'totalUangDihasilkan', 'jumlahSales'));
    }
}
