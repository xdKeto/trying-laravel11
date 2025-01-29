@extends('layout.app')
@section('title', 'Forgor')


@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card p-4">
            <h1>Reset Password</h1>
            <form action="{{ route('forgor.post') }}" method="post">
                @csrf
                @include('layout.notif')
                <div class="mb-2">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" value="{{ old('email') }}">
                </div>
                {{-- <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div> --}}
                <div class="d-inline">
                    <button type="submit" class="btn btn-primary">Kirim Email</button>
                    <a href="{{ route('login') }}" class="btn btn-primary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection