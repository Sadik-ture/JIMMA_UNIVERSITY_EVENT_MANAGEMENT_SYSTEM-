@extends('layouts.app')

@section('title', 'Login - JU Event Management')
@section('page-title', 'Welcome Back')
@section('page-subtitle', 'Access your account to manage events')

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Login</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="ju-card border-0 shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <div class="ju-card-header" style="background: linear-gradient(135deg, #0a1929 0%, #0d2b4b 100%); padding: 1.5rem;">
                <h5 class="ju-card-title mb-0 text-white"><i class="fas fa-sign-in-alt me-2"></i>Login to Your Account</h5>
            </div>
            <div class="ju-card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label fw-semibold" style="color: #0a1929;">
                            <i class="fas fa-envelope me-2" style="color: #0d2b4b;"></i>Email Address
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" style="background-color: #f8f9fa; border-color: #dee2e6; border-right: none;">
                                <i class="fas fa-envelope" style="color: #0d2b4b;"></i>
                            </span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror border-start-0" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Enter your email address" required autofocus
                                   style="border-color: #dee2e6; padding: 0.75rem;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold" style="color: #0a1929;">
                            <i class="fas fa-lock me-2" style="color: #0d2b4b;"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text" style="background-color: #f8f9fa; border-color: #dee2e6; border-right: none;">
                                <i class="fas fa-lock" style="color: #0d2b4b;"></i>
                            </span>
                            <input type="password" class="form-control @error('password') is-invalid @enderror border-start-0" 
                                   id="password" name="password" placeholder="Enter your password" required
                                   style="border-color: #dee2e6; padding: 0.75rem;">
                            <button class="btn btn-outline-secondary toggle-password" type="button" 
                                    style="border-color: #dee2e6; border-left: none; background-color: #f8f9fa;">
                                <i class="fas fa-eye" style="color: #0d2b4b;"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember"
                                   style="border-color: #0d2b4b; cursor: pointer;">
                            <label class="form-check-label" for="remember" style="color: #495057; cursor: pointer;">
                                Remember me on this device
                            </label>
                        </div>
                        
                        <a href="#" class="text-decoration-none" style="color: #0d2b4b; font-size: 0.9rem;">
                            <i class="fas fa-question-circle me-1"></i>Forgot password?
                        </a>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-lg" 
                                style="background: linear-gradient(135deg, #0a1929 0%, #0d2b4b 100%); color: white; border: none; padding: 0.75rem; border-radius: 10px; font-weight: 500;">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Dashboard
                        </button>
                        
                        <div class="text-center position-relative my-3">
                            <hr style="border-color: #dee2e6; opacity: 0.3;">
                            <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white" 
                                  style="color: #6c757d; font-size: 0.9rem;">or</span>
                        </div>
                        
                        <a href="#" class="btn btn-outline-secondary" 
                           style="border-color: #dee2e6; color: #495057; padding: 0.75rem; border-radius: 10px;">
                            <i class="fab fa-google me-2" style="color: #0d2b4b;"></i>Continue with Google
                        </a>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="mb-2" style="color: #495057;">
                            Don't have an account yet? 
                            <a href="{{ route('register') }}" style="color: #0d2b4b; font-weight: 500; text-decoration: none;">
                                Create account <i class="fas fa-arrow-right ms-1" style="font-size: 0.8rem;"></i>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <p class="text-muted small">
                <i class="fas fa-shield-alt me-1" style="color: #0d2b4b;"></i>
                By logging in, you agree to our 
                <a href="#" style="color: #0d2b4b; text-decoration: none;">Terms of Service</a> 
                and <a href="#" style="color: #0d2b4b; text-decoration: none;">Privacy Policy</a>
            </p>
            
            <div class="mt-3">
                <span class="badge" style="background-color: #e9ecef; color: #0a1929; padding: 0.5rem 1rem;">
                    <i class="fas fa-graduation-cap me-1" style="color: #0d2b4b;"></i>
                    JU Event Management System
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Dark Blue Color Scheme */
    :root {
        --dark-blue-1: #0a1929;
        --dark-blue-2: #0d2b4b;
        --dark-blue-3: #1a3a5f;
        --dark-blue-4: #2c4b73;
    }
    
    /* Card Enhancements */
    .ju-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(10, 25, 41, 0.15);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .ju-card:hover {
        box-shadow: 0 15px 40px rgba(10, 25, 41, 0.25);
    }
    
    /* Form Controls */
    .form-control {
        border-radius: 0 8px 8px 0;
        border-left: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    
    .form-control:focus {
        border-color: #0d2b4b;
        box-shadow: 0 0 0 0.2rem rgba(13, 43, 75, 0.25);
        outline: none;
    }
    
    .input-group-text {
        border-radius: 8px 0 0 8px;
        border-right: none;
        transition: border-color 0.2s ease;
    }
    
    .input-group:focus-within .input-group-text {
        border-color: #0d2b4b;
    }
    
    /* Password Toggle Button */
    .toggle-password {
        border-radius: 0 8px 8px 0;
        border-left: none;
        transition: all 0.2s ease;
        background-color: #f8f9fa;
    }
    
    .toggle-password:hover {
        background-color: #0d2b4b;
        border-color: #0d2b4b;
    }
    
    .toggle-password:hover i {
        color: white !important;
    }
    
    /* Checkbox Styling */
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.15em;
        border: 2px solid #0d2b4b;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }
    
    .form-check-input:checked {
        background-color: #0d2b4b;
        border-color: #0d2b4b;
    }
    
    .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 43, 75, 0.25);
        border-color: #0d2b4b;
    }
    
    /* Links */
    a {
        transition: color 0.2s ease;
    }
    
    a:hover {
        color: #1a3a5f !important;
        text-decoration: underline !important;
    }
    
    /* Button Hover Effects */
    .btn[style*="gradient"] {
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .btn[style*="gradient"]::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #0d2b4b 0%, #1a3a5f 100%);
        transition: left 0.3s ease;
        z-index: -1;
    }
    
    .btn[style*="gradient"]:hover::before {
        left: 0;
    }
    
    .btn[style*="gradient"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 43, 75, 0.4);
    }
    
    /* Alternative login button */
    .btn-outline-secondary {
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary:hover {
        background-color: #0d2b4b;
        border-color: #0d2b4b !important;
        color: white !important;
    }
    
    .btn-outline-secondary:hover i {
        color: white !important;
    }
    
    /* Badge styling */
    .badge {
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    /* Animation for form */
    .ju-card-body {
        animation: slideIn 0.5s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 576px) {
        .ju-card-body {
            padding: 1.5rem !important;
        }
        
        .form-control, .btn {
            font-size: 0.95rem;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #0d2b4b;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #0a1929;
    }
    
    /* Success animation for remember me */
    .form-check-input:checked {
        animation: checkPulse 0.3s ease;
    }
    
    @keyframes checkPulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }
    
    /* Focus visible outline for accessibility */
    .form-check-input:focus-visible,
    .btn:focus-visible,
    a:focus-visible {
        outline: 2px solid #0d2b4b;
        outline-offset: 2px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced password visibility toggle
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                
                // Add a subtle animation
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                
                // Add a subtle animation
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);
            }
            
            // Focus back on input after toggle
            input.focus();
        });
    });
    
    // Optional: Show password strength indicator on focus
    const passwordInput = document.getElementById('password');
    
    if (passwordInput) {
        passwordInput.addEventListener('focus', function() {
            this.parentElement.style.boxShadow = '0 0 0 3px rgba(13, 43, 75, 0.1)';
        });
        
        passwordInput.addEventListener('blur', function() {
            this.parentElement.style.boxShadow = 'none';
        });
    }
    
    // Add floating label effect
    const inputs = document.querySelectorAll('.form-control');
    
    inputs.forEach(input => {
        // Check if input has value on page load
        if (input.value) {
            input.parentElement.previousElementSibling?.classList.add('floating');
        }
        
        input.addEventListener('focus', function() {
            this.parentElement.previousElementSibling?.classList.add('floating');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.previousElementSibling?.classList.remove('floating');
            }
        });
    });
    
    // Smooth scroll to error if any
    const errorInput = document.querySelector('.is-invalid');
    if (errorInput) {
        errorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});
</script>
@endpush