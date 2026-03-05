<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - JU Event Management</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(10, 25, 41, 0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, #0a1929 0%, #0d2b4b 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 1.5rem;
        }
        
        .card-header h5 {
            color: white;
            margin: 0;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .input-group-text {
            border-radius: 8px 0 0 8px;
            border: 1px solid #ced4da;
            border-right: none;
            background-color: #e9ecef;
        }
        
        .form-control, .form-select {
            border-radius: 0 8px 8px 0;
            border: 1px solid #ced4da;
            padding: 0.6rem 0.75rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #0d2b4b;
            box-shadow: 0 0 0 0.2rem rgba(13, 43, 75, 0.25);
        }
        
        .btn-outline-secondary {
            border-radius: 0 8px 8px 0;
            border: 1px solid #ced4da;
            border-left: none;
            background-color: #fff;
        }
        
        .btn-outline-secondary:hover {
            background-color: #0d2b4b;
            color: white;
            border-color: #0d2b4b;
        }
        
        .btn-outline-secondary:hover i {
            color: white !important;
        }
        
        .form-check-input:checked {
            background-color: #0d2b4b;
            border-color: #0d2b4b;
        }
        
        .form-check-input {
            border: 2px solid #0d2b4b;
            cursor: pointer;
        }
        
        .form-check-label {
            cursor: pointer;
        }
        
        .section-title h6 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: #0d2b4b;
        }
        
        hr {
            margin-top: 0.25rem;
            margin-bottom: 0.5rem;
            border-color: #0d2b4b;
            opacity: 0.2;
        }
        
        .text-danger {
            color: #dc3545;
        }
        
        .text-muted {
            color: #6c757d;
        }
        
        a {
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        a:hover {
            color: #1a3a5f !important;
            text-decoration: underline !important;
        }
        
        .alert-info {
            border-left: 4px solid #0d2b4b !important;
            background-color: #f8f9fa;
            border: none;
        }
        
        .btn[style*="gradient"] {
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.3s ease;
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
            color: white;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .card-body {
                padding: 1.5rem !important;
            }
            
            .form-control, .btn {
                font-size: 0.95rem;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <!-- Logo/Brand for mobile -->
                <div class="text-center mb-4">
                    <div class="d-inline-block p-3 rounded-circle" style="background: linear-gradient(135deg, #0a1929 0%, #0d2b4b 100%);">
                        <i class="fas fa-graduation-cap fa-3x text-white"></i>
                    </div>
                    <h3 class="mt-3 fw-bold" style="color: #0a1929;">JU Event Management</h3>
                    <p class="text-muted">Join Jimma University Event Management System</p>
                </div>
                
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header" style="background: linear-gradient(135deg, #0a1929 0%, #0d2b4b 100%);">
                        <h5 class="mb-0 text-white py-2"><i class="fas fa-user-plus me-2"></i>Create New Account</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Personal Information Section -->
                            <div class="section-title mb-4">
                                <h6 class="fw-bold" style="color: #0d2b4b;">
                                    <i class="fas fa-user-circle me-2"></i>Personal Information
                                </h6>
                                <hr class="mt-1">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" 
                                               placeholder="Enter your full name" required>
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" 
                                               placeholder="Enter your email" required>
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone') }}" 
                                               placeholder="e.g., +251 911 234 567" required>
                                    </div>
                                    @error('phone')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label fw-semibold">Date of Birth <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                                               required>
                                    </div>
                                    @error('date_of_birth')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Professional Information Section -->
                            <div class="section-title mb-4 mt-4">
                                <h6 class="fw-bold" style="color: #0d2b4b;">
                                    <i class="fas fa-briefcase me-2"></i>Professional Information
                                </h6>
                                <hr class="mt-1">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expertise" class="form-label fw-semibold">I am a <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user-tag" style="color: #0d2b4b;"></i>
                                        </span>
                                        <select class="form-select @error('expertise') is-invalid @enderror" 
                                                id="expertise" name="expertise" required>
                                            <option value="" selected disabled>Select your status</option>
                                            <option value="student" {{ old('expertise') == 'student' ? 'selected' : '' }}>Student</option>
                                            <option value="employee" {{ old('expertise') == 'employee' ? 'selected' : '' }}>Employee</option>
                                            <option value="faculty" {{ old('expertise') == 'faculty' ? 'selected' : '' }}>Faculty Member</option>
                                            <option value="staff" {{ old('expertise') == 'staff' ? 'selected' : '' }}>University Staff</option>
                                            <option value="alumni" {{ old('expertise') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                                            <option value="guest" {{ old('expertise') == 'guest' ? 'selected' : '' }}>Guest</option>
                                            <option value="other" {{ old('expertise') == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    @error('expertise')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3" id="student-id-field" style="display: none;">
                                    <label for="student_id" class="form-label fw-semibold">Student ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-id-card" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="text" class="form-control" 
                                               id="student_id" name="student_id" value="{{ old('student_id') }}" 
                                               placeholder="Enter your student ID">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="department" class="form-label fw-semibold">Department/Unit <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-building" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="text" class="form-control @error('department') is-invalid @enderror" 
                                               id="department" name="department" value="{{ old('department') }}" 
                                               placeholder="e.g., Computer Science, HR" required>
                                    </div>
                                    @error('department')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="faculty" class="form-label fw-semibold">Faculty/College</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-university" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="text" class="form-control" 
                                               id="faculty" name="faculty" value="{{ old('faculty') }}" 
                                               placeholder="e.g., Faculty of Computing">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3" id="year-of-study-field" style="display: none;">
                                    <label for="year_of_study" class="form-label fw-semibold">Year of Study</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-graduation-cap" style="color: #0d2b4b;"></i>
                                        </span>
                                        <select class="form-select" id="year_of_study" name="year_of_study">
                                            <option value="" selected disabled>Select year</option>
                                            <option value="1" {{ old('year_of_study') == '1' ? 'selected' : '' }}>1st Year</option>
                                            <option value="2" {{ old('year_of_study') == '2' ? 'selected' : '' }}>2nd Year</option>
                                            <option value="3" {{ old('year_of_study') == '3' ? 'selected' : '' }}>3rd Year</option>
                                            <option value="4" {{ old('year_of_study') == '4' ? 'selected' : '' }}>4th Year</option>
                                            <option value="5" {{ old('year_of_study') == '5' ? 'selected' : '' }}>5th Year</option>
                                            <option value="graduate" {{ old('year_of_study') == 'graduate' ? 'selected' : '' }}>Graduate</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3" id="employee-id-field" style="display: none;">
                                    <label for="employee_id" class="form-label fw-semibold">Employee ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-id-badge" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="text" class="form-control" 
                                               id="employee_id" name="employee_id" value="{{ old('employee_id') }}" 
                                               placeholder="Enter your employee ID">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3" id="position-field" style="display: none;">
                                    <label for="position" class="form-label fw-semibold">Position/Job Title</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-briefcase" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="text" class="form-control" 
                                               id="position" name="position" value="{{ old('position') }}" 
                                               placeholder="e.g., Lecturer, Administrator">
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="profile_photo" class="form-label fw-semibold">Profile Photo</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-camera" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="file" class="form-control" 
                                               id="profile_photo" name="profile_photo" accept="image/*">
                                    </div>
                                    <small class="text-muted">Optional: JPG, PNG, max 2MB</small>
                                </div>
                            </div>
                            
                            <!-- Account Security Section -->
                            <div class="section-title mb-4 mt-4">
                                <h6 class="fw-bold" style="color: #0d2b4b;">
                                    <i class="fas fa-shield-alt me-2"></i>Account Security
                                </h6>
                                <hr class="mt-1">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" placeholder="Create a strong password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Minimum 8 characters with letters and numbers</small>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock" style="color: #0d2b4b;"></i>
                                        </span>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" 
                                               placeholder="Confirm your password" required>
                                        <button class="btn btn-outline-secondary toggle-password" type="button">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Terms and Conditions -->
                            <div class="alert alert-info bg-light border-0" style="border-left: 4px solid #0d2b4b !important;" class="mb-4">
                                <i class="fas fa-info-circle me-2" style="color: #0d2b4b;"></i>
                                <span class="small">After registration, your account will be reviewed and assigned appropriate permissions. You'll receive a confirmation email once your account is activated.</span>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('terms') is-invalid @enderror" 
                                           type="checkbox" id="terms" name="terms" required
                                           style="border-color: #0d2b4b;">
                                    <label class="form-check-label small" for="terms">
                                        I agree to the <a href="#" style="color: #0d2b4b; text-decoration: none;">Terms of Service</a> 
                                        and <a href="#" style="color: #0d2b4b; text-decoration: none;">Privacy Policy</a> <span class="text-danger">*</span>
                                    </label>
                                    @error('terms')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter"
                                           style="border-color: #0d2b4b;">
                                    <label class="form-check-label small" for="newsletter">
                                        Subscribe to our newsletter for event updates
                                    </label>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg" 
                                        style="background: linear-gradient(135deg, #0a1929 0%, #0d2b4b 100%); color: white; border: none; padding: 12px;">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </button>
                            </div>
                            
                            <div class="text-center mt-3">
                                <p class="mb-0 small">Already have an account? 
                                    <a href="{{ route('login') }}" style="color: #0d2b4b; text-decoration: none; font-weight: 500;">Login here</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="text-center mt-4">
                    <span class="badge" style="background-color: #e9ecef; color: #0a1929; padding: 0.5rem 1rem;">
                        <i class="fas fa-graduation-cap me-1" style="color: #0d2b4b;"></i>
                        JU Event Management System
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                    
                    // Add animation
                    this.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                    
                    // Add animation
                    this.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                }
                
                input.focus();
            });
        });
        
        // Conditional fields based on expertise
        const expertiseSelect = document.getElementById('expertise');
        const studentIdField = document.getElementById('student-id-field');
        const yearOfStudyField = document.getElementById('year-of-study-field');
        const employeeIdField = document.getElementById('employee-id-field');
        const positionField = document.getElementById('position-field');
        
        if (expertiseSelect) {
            expertiseSelect.addEventListener('change', function() {
                const value = this.value;
                
                // Hide all conditional fields first
                studentIdField.style.display = 'none';
                yearOfStudyField.style.display = 'none';
                employeeIdField.style.display = 'none';
                positionField.style.display = 'none';
                
                // Show relevant fields based on selection
                if (value === 'student') {
                    studentIdField.style.display = 'block';
                    yearOfStudyField.style.display = 'block';
                } else if (value === 'employee' || value === 'faculty' || value === 'staff') {
                    employeeIdField.style.display = 'block';
                    positionField.style.display = 'block';
                }
            });
            
            // Trigger change event on page load if old value exists
            if (expertiseSelect.value) {
                expertiseSelect.dispatchEvent(new Event('change'));
            }
        }
        
        // Smooth scroll to error if any
        const errorInput = document.querySelector('.is-invalid');
        if (errorInput) {
            errorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
    </script>
</body>
</html>