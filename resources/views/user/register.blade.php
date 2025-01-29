@extends('layout.app')
@section('title', 'Register')



@section('content')
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card p-4">
        <h1>Register</h1>
        <form action="{{ route('register.post') }}" method="post">
          @csrf
          @include('layout.notif')
          <div class="mb-2">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                   value="{{ old('email') }}">
            {{-- <div class="form-text text-danger">* Email tidak bisa diganti</div> --}}
          </div>
          <div class="mb-2">
            <label for="name" class="form-label">Name</label>
            <input type="name" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                   value="{{ old('name') }}">
          </div>
          <h3>Password</h3>
          {{-- <div class="form-text">Silahkan masukkan password yang baru</div> --}}
          <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password">
          </div>
          <div class="d-inline">
            <div class="mb-2">
              <label for="passwordC" class="form-label">Konfirmasi Password</label>
              <input type="password" class="form-control" name="passwordC" id="passwordC">
            </div>
            <div class="d-inline">
              <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
              <button type="submit" class="btn btn-primary">Register</button>
              {{-- <a href="">Belum Punya Akun? Silakan Register</a> --}}
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
