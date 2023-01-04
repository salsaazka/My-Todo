<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;

class ProjectController extends Controller
{


    //index 
    public function index(Request $request)
    {
        //ngambil semua data dr table projects project::all()
        //ambil data dari table tasks
        //data table tasks dikelompokkan berdasarkan project_id nya (foreign key)
        //misal : 1 baris project id nya 1 -> didalamnya mengambil data dr table tasks yang punya project_id 1
        //id: 1 , name: laravel, created, updated, + tasks : array data dr table tasks yang punya project_id 1 (karena pakai with bertambahk tasks yang tipenya array)
        //sesuaikan dengan public function 
        //simplePaginate fungsinya membatasi jumlah data yang ditampilkan disimpan didalam parameter
        //minimal data yang ditampilkan disimpan didalam parameter
        //paginate() dan simplePaginate() sama beda ditampilan
        //karena di dalam index ada fitur search yang akan kembali ke method index, jadi sebelum ambil data pakai where. $request->search_project diambil dari input yang name nya search_project
        // % didepan -> data huruf awal
        // % dibelakang -> data huruf akhir
        // % didepan & belakang -> data huruf awal atau depan
        $data = Project::where([
            ['user_id', '=', Auth::user()->id],
            ['name', 'LIKE', '%'.$request->search_project.'%']
            ])->with('tasks')->simplePaginate(2);
        $no = 1;

        //tampilin halaman dengan data
        return view('project.index', compact('data', 'no'));

        //compact sesuain dama nama var
    }

    public function create()
    {
      return view('project.create');
    }
    

    public function store(Request $request)
    {
        //validasi
        $request->validate([
            'name' => 'required|min:4',
        ]);

        //input data ke database
        Project::create([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
        ]);

        //path
        return redirect('/')->with('success','Berhasil menambahkan project baru');

        //redirect name
        // return redirect()->route('home')->with('success','Berhasil menambahkan project baru');
    }

    public function createPDF()
    {
         // retreive all records from db
      $data = Project::all();
      // share data to view
      view()->share('projects',$data);
      $pdf = PDF::loadView('dashboard.project_view', $data);
      // download PDF file with download method
      return $pdf->download('todo.pdf');
    }
    public function show(Project $project)
    {
        //
    }

   
    public function edit($id)
    {
        $data = Project::where('id', $id)->first();
        // dd($data);

        //compact ngirim data dari controller ke blade
         return view('project.edit', compact('data'));
    }

    
    public function update(Request $request, $id)
    {
      //validasi
      $request->validate([
        'name' => 'required|min:4',
       ]);
        //update ke db
        Project::where('id', $id)->update([
            'name' => $request->name,
            'user_id' => Auth::user()->id,
        ]);

        //redirect
        return redirect('/')->with('success_edit', 'Berhasil mengubah data project');

    }

    public function destroy($id)
    {
        Project::where('id', $id)->delete();
        return redirect('/')->with('deleted', 'Berhasil menghapus data project ');
    }

    //login
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
            return redirect()->route('project.index');
        } else {
            return redirect('/')->with('fail', 'Gagal login, silahkan periksa dan coba lagi!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
