@extends('master.guest.layout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="col-12 row border rounded-5 shadow-sm">
            <div class="col-6 d-none d-md-flex align-items-center justify-center p-5">
                <img src="{{ asset('assets/images/auth.png') }}" alt="Login Image" class="img-fluid object-fit-cover">
            </div>
            <div class="col-12 col-md-6 px-4 py-5">
                <h2 class="mb-4 fw-bold">Register</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('register.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name..." value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email..." value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="num" placeholder="Enter your NIM..." value="{{ old('num') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password..." required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Enter your password again..." required>
                        </div>
                    </div>
                    <p>Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a></p>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill py-2">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection