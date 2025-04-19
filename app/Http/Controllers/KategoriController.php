<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar kategori',
            'list' => ['Data Master', 'kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $acticeMenu = 'kategori';

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $acticeMenu]);
    }

    public function data(Request $request)
    {
        $kategoris = Kategori::all();

        return DataTables::of($kategoris)
            ->addIndexColumn() // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($kategoris) {
                $btn = '<button onclick="modalAction(\'' . url('/kategori/' . $kategoris->kategori_id .
                    '') . '\')" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> Show</button>  ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategoris->kategori_id .
                    '/edit') . '\')" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i> Edit</button>  ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategoris->kategori_id .
                    '/delete') . '\')" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>  ';

                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_kategori' => 'required|string|min:3|unique:kategori,kode_kategori',
                'nama_kategori' => 'required|string|max: 100|', 
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            Kategori::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function show(string $id)
    {

        $kategori = Kategori::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail kategori',
            'list' => ['Home', 'kategori', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail kategori'

        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit($id) {
        $kategori = Kategori::find($id);
        // dd($kategori);
        return view('kategori.edit', ['kategori' => $kategori]);
    }

    public function update(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_kategori' => 'required|string|min:3|unique:kategori,kode_kategori,' . $id . ',kategori_id',
                'nama_kategori' => 'required|string|max: 100|', 
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = Kategori::find($id);
            if ($check) {
                $check->update($request->all());
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
        return redirect('/kategori');
    }

    public function confirm(string $id)
    {
        $kategori = Kategori::find($id);

        return view('kategori.confirm', ['kategori' => $kategori]);
    }

    public function delete(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $kategori = Kategori::find($id);
            if ($kategori) {
                $kategori->delete();
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

        return redirect('/kategori');
    }
}
