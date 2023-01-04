@extends('layout')

@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
		 
        <div class="col-12 col-md-5 col-sm-12 col-xs-12"> 
            <div class="card card-create p-3 p-md-4"> 
				{{-- untuk menampilkan data dinamis atau data yang diambil dari databse harus menggunakan { {}} nama var sama dengan nama yang dikirim di compact    --}}
                <h6 class="bold mb-4" id="head1">NEW TASK in {{ $project['name'] }} PROJECT</h6>
		@if ($errors->any())
		<div class="alert alert-danger">
		  <ul>
			@foreach ($errors->all() as $error)
			  <li>{{ $error }}</li>
		   @endforeach
		  </ul>
		 </div>
		 @endif

                <form method="POST" action="{{ route('task.store', $project['id']) }}">
					{{-- ngirim data input ke controller, di controller diambil lewat Request $request --}}
					@csrf
                	<div class="form-group">
                		<label>Name</label>
                		<input type="text" name="name" class="form-control">
                	</div>
                	<div class="d-flex justify-content-between mt-4">
                		<a href="/task/{{ $project['id'] }}" class="btn btn-secondary col-6 col-md-4">Back</a>
                		<button type="submit" class="btn btn-submit text-white btn-sm col-6 col-md-4 p-2 px-0 py-md-2">Submit</button>
                	</div>
                </form>
           	</div>
        </div>
    </div>
</div>
@endsection