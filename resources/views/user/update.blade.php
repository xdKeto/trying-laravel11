@extends('layout.app')
@section('title', 'Update Data')

@section('navbar')
  @include('layout.navbar')
@endsection

@section('content')
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card p-4">
        <h1>Update Data</h1>
        <form action="{{ route('user.update.post') }}" method="post">
          @csrf
          @include('layout.notif')
          <div class="mb-2">
            <label for="email" class="form-label">Email address</label>
            <input type="email" disabled class="form-control" id="email" name="email" aria-describedby="emailHelp"
            value="{{ Auth::user()->email }}">
            <div class="form-text text-danger">* Email tidak bisa diganti</div>
          </div>
          <div class="mb-2">
            <label for="name" class="form-label">Name</label>
            <input type="name" class="form-control" id="name" name="name" aria-describedby="nameHelp"
                   value="{{ old('name') ? old('name') : Auth::user()->name }}">
          </div>
          <h3>Password</h3>
          <div class="form-text">Silahkan masukkan password yang baru</div>
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
              <button type="submit" class="btn btn-primary">Save</button>
              {{-- <a href="">Belum Punya Akun? Silakan Register</a> --}}
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
