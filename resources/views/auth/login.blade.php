@extends('master.guest.layout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center mt-5">
        <div class="col-12 row border rounded-5 shadow-sm">
            <div class="col-6 d-none d-md-flex align-items-center justify-center p-5">
                <img src="{{ asset('assets/images/auth.png') }}" alt="Login Image" class="img-fluid object-fit-cover">
            </div>
            <div class="col-12 col-md-6 px-4 py-5">
                <h2 class="mb-4 fw-bold">Login</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('login.authenticate') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                            id="email" name="email" placeholder="Enter email..." value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                            id="password" name="password" placeholder="Enter password..." required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <p>Don't have an account yet? <a href="{{ route('register') }}" class="text-primary">Register</a></p>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill py-2">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection