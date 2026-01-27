@extends('layouts.app')

@section('title', 'Login - JU Event Management')
@section('page-title', 'Login')
@section('page-subtitle', 'Access your account')

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Login</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="ju-card">
            <div class="ju-card-header">
                <h5 class="ju-card-title mb-0"><i class="fas fa-sign-in-alt me-2"></i>Login to Your Account</h5>
            </div>
            <div class="ju-card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Enter your email" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" placeholder="Enter your password" required>
                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                <i class="fas fa-eye"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-ju btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="mb-2">Don't have an account? 
                            <a href="{{ route('register') }}" class="text-ju text-decoration-none">Register here</a>
                        </p>
                        <p class="mb-0">
                            <a href="#" class="text-decoration-none">Forgot your password?</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted">
                <small>By logging in, you agree to our Terms of Service and Privacy Policy</small>
            </p>
        </div>
    </div>
</div>
@endsection