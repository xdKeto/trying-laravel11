@extends('layout.app')
@section('title', 'Reset Password')

{{-- @section('navbar')
  @include('layout.navbar')
@endsection --}}

@section('content')
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <div class="card p-4">
        <h1>Reset Password</h1>
        <form action="{{ route('forgor.reset.post') }}" method="post">
          {{-- hidden ga perlu csrf?? --}}
          <input type="hidden" name="token" value="{{ $token }}">
          @csrf
          @include('layout.notif')
          <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            {{-- <div class="form-text">Silahkan masukkan password yang baru</div> --}}
            <input type="password" class="form-control" name="password" id="password">
          </div>
          <div class="d-inline">
            <div class="mb-2">
              <label for="passwordC" class="form-label">Konfirmasi Password</label>
              <input type="password" class="form-control" name="passwordC" id="passwordC">
            </div>
            <div class="d-inline">
              <button type="submit" class="btn btn-primary">Reset Password</button>
              {{-- <a href="">Belum Punya Akun? Silakan Register</a> --}}
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
