<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Enums\TransaksiEnum;
use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'Laporan',
            'list' => ['Laporan']
        ];

        $page = (object) [
            'title' => 'Laporan Penjualan atau Transaksi'
        ];

        $activeMenu = 'laporan';

        $transaksi = Transaksi::with(['mobil', 'user']);

        if (Auth::user()->role != RoleEnum::admin) {
            $transaksi->where('user_id', Auth::user()->user_id);
        }

        $transaksi = $transaksi->get();

        $jumlahTersedia = Mobil::where('status', StatusEnum::tersedia)->count();
        $jumlahBooking = Mobil::where('status', StatusEnum::booking)->count();
        $jumlahSold = Mobil::where('status', StatusEnum::sold)->count();

        if (Auth::user()->role == RoleEnum::admin) {
            $totalUangDihasilkan = Mobil::where('status', StatusEnum::sold)
                ->sum('harga');
        } else {
            $totalUangDihasilkan = Mobil::where('status', StatusEnum::sold)
                ->whereHas('transaksi', function ($query) {
                    $query->where('user_id', Auth::user()->user_id);
                })
                ->sum('harga');
        }

        return view('laporan.index', compact('transaksi', 'breadcrumb', 'page', 'activeMenu', 'jumlahSold', 'jumlahBooking', 'jumlahTersedia', 'totalUangDihasilkan'));
    }

    public function data(Request $request)
    {
        $query = Transaksi::with(['mobil', 'user']);

        if (Auth::user()->role != RoleEnum::admin) {
            $query->where('user_id', Auth::user()->user_id);
        }

        // Filter berdasarkan status yang dikirim dari AJAX
        if ($request->has('status')) {
            if ($request->status == 'Tersedia') {
                $query->whereHas('mobil', function ($q) {
                    $q->where('status', StatusEnum::tersedia);
                });
            } elseif ($request->status == 'Booking') {
                $query->where('status', TransaksiEnum::booking);
            } elseif ($request->status == 'Sold') {
                $query->where('status', TransaksiEnum::lunas);
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('status', function ($transaksi) {
                // Menampilkan status dengan badge
                if ($transaksi->status == TransaksiEnum::booking) {
                    return '<span class="badge bg-warning">Booking</span>';
                } elseif ($transaksi->status == TransaksiEnum::lunas) {
                    return '<span class="badge bg-success">Lunas</span>';
                } else {
                    return '<span class="badge bg-secondary">Tersedia</span>';
                }
            })
            ->addColumn('pembeli', function ($transaksi) {
                return $transaksi->pembeli ?? '-';
            })
            ->addColumn('telp_pembeli', function ($transaksi) {
                return $transaksi->telp_pembeli ?? '-';
            })
            ->rawColumns(['status']) // biar HTML badge jalan
            ->make(true);
    }
}
