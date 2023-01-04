@extends('layout')

@section('content')

<div class="container task mt-5">
    <div class="row d-flex justify-content-center ">
        <div class="col-md-6">
            <div class="card">
                <div class="d-flex justify-content-between mb-3">
                    <a href="/project" class="btn btn-primary new"><i class="fas fa-backward"></i> Back</a>
                    {{--  --}}
                    <a href="/task/{{ $dataProject['id'] }}" class="btn btn-primary new"> Refresh</a>
                    <a href="/task/{{ $dataProject['id'] }}/create" class="btn btn-primary new">
                        <i class="fa fa-plus"></i> New</a>
                </div>
                 {{-- pengambilan pemberitahuan with bisa dengan 2 cara session() atau Session::get() --}}
                @if(Session::get('addTask'))
                    <div class="alert alert-success">
                        {{ Session::get('addTask') }}
                    </div>
                @endif
                @if(Session::get('updateTask'))
                    <div class="alert alert-success">
                        {{ Session::get('updateTask') }}
                    </div>
                @endif
                @if(Session::get('deleteTask'))
                <div class="alert alert-warning">
                    {{ Session::get('deleteTask') }}
                </div>
            @endif

                <form method="GET" action="" class="input-box">
                    <input type="text" name="search_task" class="form-control">
                    <button type="submit" class="btn btn-outline-none fa fa-search" style="padding: 0 !important"></button>
               
                </form>
                
            {{-- karena task datanya banyak jadi perlu perulangan nama variabel awalnya sama dengan nama compact untuk as nya apa saja untuk mewakilkan --}}
                @foreach ($dataTask as $task )
                <div class="list border-bottom">
                    <i class="fas fa-thumbtack"></i>
                    <div class="d-flex flex-column ml-3">
                      {{-- jumlah path dinamis menyesuaikan jumlah web.php pengisian dengan {{  }} --}}
                        <a class="text-dark" style="text-decoration: none" href="/task/{{ $dataProject['id'] }}/edit/{{ $task['id'] }}">{{ $task['name'] }}</a> 

                        {{-- carbon itu package laravel untuk mengelola hal-hal yang berhubungan dengan date, nantinya format date yang angka diubah ke nama bulan 25 November 2022 --}}

                        <small>created {{ \Carbon\Carbon::parse($task['created_at'])->format('j F, Y') }}</small>
                        {{-- fitur delete selalu pakai form --}}

                        <form method="POST" action="/task/{{ $dataProject['id'] }}/delete/{{ $task['id'] }}">
                            @csrf
                            {{-- menimpa method post agar menjadi delete, menyesuaikan dengan method route web.php --}}
                            @method('DELETE')
                            <button type="submit" class="btn-outline-none btn" style="font-size: 0.7rem; padding: 0 !important; color: red;">Hapus</button>
                        </form>
                    </div>                   
                </div>  
             @endforeach
             <div class="d-flex justify-content-end mt-4">
                {{ $dataTask->links() }}
             </div>
          </div>
      </div>
    </div>
</div>
@endsection