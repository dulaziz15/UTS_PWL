<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Data Master', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $acticeMenu = 'user';

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $acticeMenu]);
    }

    public function data(Request $request)
    {
        $users = User::select('user_id', 'username', 'email', 'password', 'telp', 'alamat', 'tempat_lahir', 'tanggal_lahir', 'role');

        if ($request->role) {
            $users->where('role', $request->role);
        }

        return DataTables::of($users)
            ->addIndexColumn() // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($user) {
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '') . '\')" class="btn btn-outline-primary btn-sm"><i class="fa fa-eye"></i> Detail</button>  ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/edit') . '\')" class="btn btn-outline-warning btn-sm"><i class="fa fa-edit"></i> Edit</button>  ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/delete') . '\')" class="btn btn-outline-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>  ';

                return $btn;
            })
            ->rawColumns(['aksi']) // Memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'username' => 'required|string|min:3|unique:users,username',
                'email' => 'required|string|max:100|unique:users,email', // perbaiki typo: max:100 (tanpa spasi)
                'password' => 'required|min:5',
                'telp' => 'required',
                'alamat' => 'required|string|max:200',
                'tempat_lahir' => 'required|string|max:40',
                'tanggal_lahir' => 'required|date', // lebih baik tambahkan validasi date
                'role' => 'required'
            ];
        
            $validator = Validator::make($request->all(), $rules);
        
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
        
            $data = $request->all();
            $data['password'] = bcrypt($request->password); // bcrypt password-nya
        
            User::create($data);
        
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        
        return redirect('/'); // ini biarin aja
        
    }

    public function show(string $id)
    {

        $user = User::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail user'

        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function edit($id) {
        $user = User::find($id);
        // dd($user);
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'username' => 'required|string|min:3|unique:users,username,' . $id . ',user_id',
                'email' => 'required|string|max: 100|unique:users,email,' . $id . ',user_id', // nama harus diisi, berupa string, dan maksimal 100 karakter
                'password' => 'required|min:5',
                'telp' => 'required',
                'alamat' => 'required|string|max: 200',
                'tempat_lahir' => 'required|string|max: 40',
                'tanggal_lahir' => 'required',
                'role' => 'required'
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
            $check = User::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari

                    $request->request->remove('password');
                }
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
        return redirect('/user');
    }

    public function confirm(string $id)
    {
        $user = User::find($id);

        return view('user.confirm', ['user' => $user]);
    }

    public function delete(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $user = User::find($id);
            if ($user) {
                $user->delete();
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

        return redirect('/user');
    }

}