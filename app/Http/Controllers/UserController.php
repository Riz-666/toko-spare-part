<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::get();
        return view('admin.user.user',[
            'user' => $user,
            'judul' => "Kelola User"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.add',[
            'judul' => "Tambah User"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|max:255|email|unique:user',
            'password' => 'required|min:4',
            'role' => 'required',
            'alamat' => 'required',
            'telepon' => 'required|max:13',
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:2048',
        ],$messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 2048 KB.',
        ]);

        $filePath = public_path('/storage/user-img');
        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $fileName = time() . $request->file('foto')->getClientOriginalName();
            $file->move($filePath,$fileName);
        }
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'foto' => $fileName,
            'role' => $request->role,
        ]);


        return redirect()->route('kelola.user')->with('success','Data Berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit',[
            'user' => $user,
            'judul' => 'Edit User'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $rules = [
            'nama' => 'required|max:255',
            'role' => 'required',
            'telepon' => 'required|max:13',
            'password' => 'required|min:4',
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif|file|max:2048',
        ];
        $messages = [
            'foto.image' => 'Format gambar gunakan file dengan ekstensi jpeg, jpg, png atau gif.',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 2048 KB.',
        ];
        if ($request->email != $user->email) {
            $rules['email'] = 'required|max:255|email|unique:user';
        }
        $validatedData = $request->validate($rules, $messages);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->role = $request->role;
        $user->telepon = $request->telepon;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if($request->hasFile('foto')){
            $dir = public_path('storage/user-img/');
            $file = $request->file('foto');
            $filename = time() . $file->getClientOriginalName();
            $file->move($dir,$filename);
            if(!is_null($user->foto)){
                $oldImagePath = public_path('storage/user-img/'.$user->foto);
                if(file_exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }
            $user->foto = $filename;

        }
            $result = $user->save($validatedData);
            return redirect()->route('kelola.user')->with('success','Data Berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->foto) {
            $oldImagePath = public_path('storage/user-img/') . $user->foto;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $user->delete();
        return redirect()->route('kelola.user')->with('success');
    }
}
