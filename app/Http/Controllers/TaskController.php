<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class TaskController extends Controller
{
    public function login()
    {
        return view('dashboard.login');
    }

    public function register()
    {
        return view('dashboard.register');
    }

    public function inputRegister(Request$request)
    {
        //validasi
        $request->validate([
            'name' => 'required|min:3|max:50',
            'username' => 'required|min:3|max:10',
            'email' => 'required',
            'password' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/')->with('success', 'Selamat, anda berhasil membuat akun!');
    }

    public function auth(Request$request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ],
        [
            'username.exists' => "Username ini tidak tersedia"
        ]);

        $user = $request->only('username', 'password');
        if (Auth::attempt($user)) {
            return redirect()->route('task.index');
        } else {
            return redirect('/')->with('fail', 'Gagal login, silahkan periksa dan coba lagi!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function index(Request $request, $project)
    {
        $dataProject = Project::where('id', $project)->first();
    
        //get ambil banyak data, sedangkan first 1 data
        //kalau data where ada dua atau lebih filternya pakai array multidimensi []
        $dataTask = Task::where([
            ['user_id', '=', Auth::user()->id],
            ['project_id', $project],
            ['name','LIKE', '%'.$request->search_task.'%'],
            ])->simplePaginate(5);

        //compact bisa lebih dari 1 variable pemisahnya koma
        return view('task.index', compact('dataProject', 'dataTask'));
    }

    
    public function create($project)
    {
        //ambil data dari database yang punya id project yang baris datanya punya id sama dengan id project dikirim ke path dinamis
        $project = Project::where('id', 'user_id',  $project)->first();
        $project = Project::where($project)->first();
        //ngirim data yang diambil agar bisa dipakai diblade dengan compact yang harus sama dengan nama var
        return view('task.create', compact('project'));
    }

    public function store(Request $request, $project)
    {
        //Validate
        $request->validate([
            'name' => 'required|min:3'
        ]);
        //tampilkan pesan error validasi di halaman create blade nya
        //kirim data ke database melalui model
        Task::create([
            'name' => $request->name,
            'project_id' => Auth::user()->id,
            'user_id' => Auth::user()->id,
        ]);
        //menentukan halaman redirect apabila berhasil menambahkan data dengan pesan
        //data pertama yang di '' name routenya
        //data kedua isian path dinamis
        return redirect()->route('task.index', $project)->with('addTask', 'Berhasil menambahkan task baru pada project!');
    }

   
    public function show(Task $task)
    {
        //
    }

   
    public function edit($project, $id)
    {
        //ambil data dari file dinamis project
        $dataProject = Project::where('id', $project)->first();
        //ambil data dari path dinamis id
        $task = Task::where('id', $id)->first();
        return view('task.edit', compact('dataProject', 'task'));
    }

  
    public function update(Request $request, $project, $id)
    {
        //validasi
        $request->validate([
            'name' => 'required|min:3',
        ]);
        //kirim pembaruan data ke databse melalui model
        //kalau mau update harus cari data yang mau diubahnya dulu (data mana yang mau diperbarui)
        //pertama ambil data dulu lewat where (ketika ada baris data yang isi column id nya sama dengan data id yang dikirim path dinamis, maka datanya akan diambil)
        // lalu update data yang diambil sama where tadi dengan data baru
        Task::where('id', $id)->update([
            'name' => $request->name,
            'project_id' => Auth::user()->id,
            'user_id' => Auth::user()->id,
            ]);
        //tentuin halaman redirect 
        return redirect()->route('task.index', $project)->with('updateTask', 'Berhasil memperbarui data task pada project!');
    }

   
    public function destroy( $project, $id)
    {
        //hapus data dari databasenya
        //sebelum dihapus, dicari data mana yang where dari id path dinamisnya
        Task::where('id', $id)->delete();
        //kalau berhasil, arahin ke halaman task awal 
        return redirect()->route('task.index', $project)->with('deleteTask', 'Berhasil menghapus data task pada project!');
    }
}
