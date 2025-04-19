<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use App\Enums\TransaksiEnum;
use App\Models\Mobil;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Halaman Transaksi',
            'list' => ['Transaksi']
        ];

        $page = (object) [
            'title' => 'Halaman Transaksi Jual Beli'
        ];

        $acticeMenu = 'transaksi';

        return view('transaksi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $acticeMenu]);
    }

    public function data(Request $request)
    {
        $transaksis = Transaksi::with(['mobil', 'user']);

        if (Auth::user()->role != RoleEnum::admin) {
            $transaksis->where('user_id', Auth::user()->user_id);
        }

        $transaksis = $transaksis->get();

        return DataTables::of($transaksis)
            ->addIndexColumn() // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($transaksi) {
                $btn = ' <button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->transaksi_id .
                    '') . '\')" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> Detail</button>';
                $btn .= ' <button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->transaksi_id .
                    '/edit') . '\')" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i> Edit</button>  ';
                $btn .= ' <button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->transaksi_id .
                    '/delete') . '\')" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>  ';

                return $btn;
            })
            ->addColumn('pembayaran', function ($transaksi) {
                if ($transaksi->status != TransaksiEnum::lunas) {
                    return '<button onclick="modalAction(\'' . url('/transaksi/' . $transaksi->transaksi_id .
                        '/pelunasan') . '\')" class="btn btn-outline-success btn-sm">
                                <i class="fa fa-check"></i> Pelunasan
                            </button>';
                } else {
                    return '<span class="badge bg-success">Lunas</span>';
                }
            })
            ->rawColumns(['aksi', 'pembayaran'])
            ->make(true);
    }

    public function create()
    {
        $mobil = Mobil::where('status', StatusEnum::tersedia)->get();
        return view('transaksi.create', ['mobil' => $mobil]);
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'mobil_id' => 'required',
                'keterangan' => 'required',
                'pembeli' => 'required',
                'telp_pembeli' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Data yang akan disimpan
            $data = $request->all();
            $data['mobil_id'] = $request->mobil_id;
            $data['user_id'] = Auth::user()->user_id; // tambahkan user_id
            $data['status'] = $request->keterangan; // mungkin kamu mau status = keterangan?
            $data['pembeli'] = $request->pembeli;
            $data['telp_pembeli'] = $request->telp_pembeli;

            // Simpan ke database
            $createTransaksi = Transaksi::create($data);
            if ($createTransaksi) {
                $status = StatusEnum::tersedia; // Default

                if ($request->keterangan == TransaksiEnum::lunas) {
                    $status = StatusEnum::sold;
                } elseif ($request->keterangan == TransaksiEnum::booking) {
                    $status = StatusEnum::booking;
                }

                Mobil::where('mobil_id', $request->mobil_id)
                    ->update([
                        'status' => $status
                    ]);
            }


            return response()->json([
                'status' => true,
                'message' => 'Data transaksi berhasil disimpan'
            ]);
        }

        return redirect('/');
    }

    public function show(string $id)
    {

        $transaksi = Transaksi::find($id)->with(['mobil', 'user'])->first();
        // dd($mobil);

        return view('transaksi.detail', ['transaksi' => $transaksi]);
    }

    public function edit($id)
    {
        $transaksi = Transaksi::find($id);
        $mobil = Mobil::with(['kategori'])->get();
        // dd($kategori);
        return view('transaksi.edit', compact('transaksi', 'mobil'));
    }

    public function update(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'mobil_id' => 'required',
                'pembeli' => 'required',
                'telp_pembeli' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            // Cari transaksi yang mau diupdate
            $transaksi = Transaksi::find($id);

            if (!$transaksi) {
                return response()->json([
                    'status' => false,
                    'message' => 'Transaksi tidak ditemukan',
                ]);
            }

            // Update data
            $transaksi->mobil_id = $request->mobil_id;
            $transaksi->pembeli = $request->pembeli;
            $transaksi->telp_pembeli = $request->telp_pembeli;
            $transaksi->save();

            return response()->json([
                'status' => true,
                'message' => 'Data transaksi berhasil diupdate'
            ]);
        }

        return redirect('/');
    }

    public function confirmPelunasan(string $id)
    {
        $transaksi = Transaksi::with(['user', 'mobil'])->find($id);

        return view('transaksi.confirmPelunasan', ['transaksi' => $transaksi]);
    }

    public function lunas($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json([
                'status' => false,
                'message' => 'Transaksi tidak ditemukan',
            ]);
        }

        // Update status transaksi ke 'lunas'
        $transaksi->status = TransaksiEnum::lunas;
        $transaksi->save();

        // Update status mobil jadi 'sold'
        $mobil = Mobil::where('mobil_id', $transaksi->mobil_id)->first();
        if ($mobil) {
            $mobil->update([
                'status' => StatusEnum::sold,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Transaksi berhasil dilunasi dan mobil terjual',
        ]);
    }

    public function confirmDelete(string $id)
    {
        $transaksi = Transaksi::with(['user', 'mobil'])->find($id);

        return view('transaksi.confirmDelete', ['transaksi' => $transaksi]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $transaksi = Transaksi::find($id);
            $mobil = Mobil::find($transaksi->mobil_id);
            if ($transaksi) {

                // Hapus mobil
                $mobil->update([
                    'status' => StatusEnum::tersedia
                ]);

                $transaksi->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }

        return redirect('/');
    }
}
