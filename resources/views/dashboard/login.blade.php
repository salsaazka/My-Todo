@extends('layout')
{{-- untuk memanggil file layout  --}}

@section('content')
    <section class="vh-100">
        <div class="container py-5 h-100">
          {{-- saat berhasil login --}}
          @if (Session::get('success'))
              <div class="alert alert-success w-100">
                 {{ Session::get('success') }}
              </div>  
          @endif

          {{-- saat password salah --}}
          @if (Session::get('fail'))
          <div class="alert alert-danger w-100">
             {{ Session::get('fail') }}
          </div>  
           @endif
 
          {{-- dari isLogin --}}
             @if (Session::get('notAllowed'))
          <div class="alert alert-danger w-100">
             {{ Session::get('notAllowed') }}
          </div>  
           @endif
           
       @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
          </ul>
        </div>
      @endif

          <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-6 col-xl-5 d-flex justify-content-center">    
              <img src="{{ asset('assets/img/Login.png') }}"
                class="img-fluid" alt="This Login" width="375px" style="padding-top: 10px">
            </div>
            
            <div class="col-md-8 col-lg-5 col-xl-6 offset-xl-1">
              
                <div class="d-flex justify-content-center mt-3">
                  <h1 style="color: #062568"> Login</h1>
                </div>

               <form action="{{ route('login.auth') }}" method="POST" class="">
               @method('POST')
                @csrf
                
                 <!-- Email input -->
                 <div class="form-outline mt-4 mb-4">
                  <label class="form-label" >Username</label>
                  <input type="text" name="username" class="form-control form-control-lg" />
                </div>
      
                <!-- Password input -->
                <div class="form-outline mb-4">
                  <label class="form-label" >Password</label>
                  <input type="password" name="password" class="form-control form-control-lg" />
                </div>
      
                <div class="d-flex justify-content-around align-items-center mb-4">
                  <!-- Checkbox -->
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="form1Example3" checked />
                    <label class="form-check-label" for="form1Example3"> Remember me </label>
                  </div>
                  <a href="/register">Create Account?</a>
                </div>
      
                <!-- Submit button -->
                <center>
                  <button type="submit" class="btn btn-primary btn-lg btn-block ">Sign in</button>
                </center>
               </form>

            </div>
          </div>
        </div>
      </section>
      @endsection('content')
   