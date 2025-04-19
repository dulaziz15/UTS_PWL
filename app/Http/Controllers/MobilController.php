<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\DetailMobil;
use App\Models\Kategori;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MobilController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar mobil',
            'list' => ['Data Master', 'mobil']
        ];
        

        $page = (object) [
            'title' => 'Daftar mobil yang terdaftar dalam sistem'
        ];

        $activeMenu = 'mobil';

        $kategori = Kategori::all();

        return view('mobil.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function data(Request $request)
    {
        $mobils = Mobil::with(['kategori', 'detail']);

        if ($request->kategori_id) {
            $mobils->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($mobils)
            ->addIndexColumn() // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($mobil) {
                $btn = '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->mobil_id .
                    '') . '\')" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> Show</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->mobil_id .
                    '/edit') . '\')" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i> Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mobil/' . $mobil->mobil_id .
                    '/delete') . '\')" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button> ';

                return $btn;
            })
            ->addColumn('spesifikasi', function ($mobil) {
                $btn = '<button onclick="modalAction(\'' . url('/mobil/spesifikasi/' . $mobil->mobil_id .
                    '') . '\')" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> Show</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/mobil/spesifikasi/' . $mobil->detail->detail_mobil_id .
                    '/edit') . '\')" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i> Edit</button> ';
                return $btn;
            })
            ->rawColumns(['aksi', 'spesifikasi'])
            ->make(true);
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('mobil.create', ['kategori' => $kategori]);
    }

    public function store(Request $request)
    {
        // Cek apakah request menggunakan AJAX atau JSON
        if ($request->ajax() || $request->wantsJson()) {

            // Validasi Data Mobil
            $mobilRules = [
                'merk' => 'required|string|max:100',
                'tahun' => 'required|integer',
                'harga' => 'required|integer',
                'type' => 'required|string|max:50',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'kategori_id' => 'required|exists:kategori,kategori_id', // pastikan kategori_id ada di tabel kategori
            ];

            // Validasi Data Detail Mobil
            $detailMobilRules = [
                'usia' => 'required|integer',
                'kilometer' => 'required|integer',
                'cylinder' => 'required|integer',
                'no_mesin' => 'required|string|max:100',
                'transmisi' => 'required|string|max:50',
                'hp' => 'required|integer',
                'warna' => 'required|string|max:50',
            ];

            // Gabungkan keduanya untuk validasi
            $rules = array_merge($mobilRules, $detailMobilRules);

            // Validasi request
            $validator = Validator::make($request->all(), $rules);

            // Jika validasi gagal
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('uploads/mobil', $imageName, 'public');
            }

            // Simpan Data Mobil
            $mobil = Mobil::create([
                'merk' => $request->merk,
                'tahun' => $request->tahun,
                'harga' => $request->harga,
                'type' => $request->type,
                'image' => $imagePath,
                'status' => StatusEnum::tersedia,
                'kategori_id' => $request->kategori_id,
            ]);

            // Simpan Data Detail Mobil
            DetailMobil::create([
                'mobil_id' => $mobil->mobil_id,
                'usia' => $request->usia,
                'kilometer' => $request->kilometer,
                'cylinder' => $request->cylinder,
                'no_mesin' => $request->no_mesin,
                'transmisi' => $request->transmisi,
                'hp' => $request->hp,
                'warna' => $request->warna,
            ]);

            // Response sukses
            return response()->json([
                'status' => true,
                'message' => 'Data mobil dan detail mobil berhasil disimpan',
            ]);
        }

        // Jika bukan request AJAX/JSON, alihkan ke halaman utama
        return redirect('/');
    }


    public function show(string $id)
    {

        $mobil = Mobil::with(['kategori', 'detail'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail mobil',
            'list' => ['Home', 'mobil', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail mobil'

        ];

        $activeMenu = 'mobil'; // set menu yang sedang aktif

        return view('mobil.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'mobil' => $mobil, 'activeMenu' => $activeMenu]);
    }

    public function showSpesifikasi(string $id)
    {

        $mobil = Mobil::find($id)->with(['kategori', 'detail'])->first();

        $breadcrumb = (object) [
            'title' => 'Detail mobil',
            'list' => ['Home', 'mobil', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail mobil'

        ];

        $activeMenu = 'mobil'; // set menu yang sedang aktif

        return view('mobil.spesifikasi', ['breadcrumb' => $breadcrumb, 'page' => $page, 'mobil' => $mobil, 'activeMenu' => $activeMenu]);
    }

    public function editSpesifikasi($id)
    {
        $spesifikasi = DetailMobil::find($id);
        // dd($kategori);
        return view('mobil.editSpesifikasi', ['spesifikasi' => $spesifikasi]);
    }

    public function showImg(string $id)
    {

        $mobil = Mobil::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail mobil',
            'list' => ['Home', 'mobil', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail mobil'

        ];

        $activeMenu = 'mobil'; // set menu yang sedang aktif

        return view('mobil.showImg', ['breadcrumb' => $breadcrumb, 'page' => $page, 'mobil' => $mobil, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $mobil = Mobil::find($id);
        $kategori = Kategori::all();
        // dd($kategori);
        return view('mobil.edit', ['mobil' => $mobil, 'kategori' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'merk' => 'required|string|max:100',
                'tahun' => 'required|integer',
                'harga' => 'required|integer',
                'type' => 'required|string|max:50',
                'kategori_id' => 'required|exists:kategori,kategori_id',
            ];

            // Kalau TIDAK ADA ID (berarti tambah baru), atau kalau ada file image baru diupload → wajib validasi image
            if (!$id || $request->hasFile('image')) {
                $rules['image'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $mobil = Mobil::find($id);

            if ($mobil) {
                $dataUpdate = $request->except('image'); // Semua input kecuali gambar

                // Kalau ada gambar baru diupload
                if ($request->hasFile('image')) {
                    // Hapus gambar lama
                    if ($mobil->image) {
                        Storage::delete('public/storage/' . $mobil->image);
                    }
                    // Simpan gambar baru
                    $path = $request->file('image')->store('uploads/mobil', 'public');
                    $dataUpdate['image'] = $path;
                }

                $mobil->update($dataUpdate);

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan.'
                ]);
            }
        }

        return redirect('/');
    }

    public function updateSpesifikasi(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // aturan validasi
            $rules = [
                'usia' => 'required|numeric',
                'kilometer' => 'required|numeric',
                'cylinder' => 'required|numeric',
                'no_mesin' => 'required|string|max:255',
                'transmisi' => 'required|string|max:255',
                'hp' => 'required|numeric',
                'warna' => 'required|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = DetailMobil::find($id);

            if ($check) {
                $check->update($request->only([
                    'usia',
                    'kilometer',
                    'cylinder',
                    'no_mesin',
                    'transmisi',
                    'hp',
                    'warna'
                ]));

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
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

    public function confirm(string $id)
    {
        $mobil = Mobil::find($id);

        return view('mobil.confirm', ['mobil' => $mobil]);
    }

    public function delete(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mobil = Mobil::find($id);

            if ($mobil) {
                // Hapus semua detail mobil yang terkait
                DetailMobil::where('mobil_id', $id)->delete();

                // Hapus mobil
                $mobil->delete();

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
