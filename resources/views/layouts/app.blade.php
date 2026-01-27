<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Jimma University Event Management')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Jimma University Theme Styles -->
    <style>
        :root {
            --ju-green: #006400;     /* Jimma University Green */
            --ju-gold: #FFD700;      /* Jimma University Gold */
            --ju-dark-green: #004d00; /* Darker Green */
            --ju-light-green: #e8f5e9; /* Light Green */
            --ju-light-gray: #f8f9fa;
            --ju-dark-gray: #343a40;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Header Styles */
        .ju-header {
            background: linear-gradient(135deg, var(--ju-green) 0%, var(--ju-dark-green) 100%);
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .ju-logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .ju-logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--ju-green);
            font-size: 24px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }
        
        .ju-title {
            display: flex;
            flex-direction: column;
        }
        
        .ju-main-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }
        
        .ju-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin: 0;
        }
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--ju-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ju-dark-green);
            font-weight: bold;
        }
        
        /* Main Layout */
        .main-container {
            display: flex;
            flex: 1;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            padding: 0 20px;
        }
        
        /* Sidebar Styles */
        .ju-sidebar {
            width: 250px;
            background: white;
            min-height: calc(100vh - 90px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
            padding: 20px 0;
            position: sticky;
            top: 90px;
            height: calc(100vh - 90px);
            overflow-y: auto;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .menu-header {
            padding: 10px 20px;
            color: #666;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }
        
        .menu-item {
            padding: 0;
        }
        
        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #555;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .menu-link:hover {
            background: var(--ju-light-green);
            color: var(--ju-green);
            border-left-color: var(--ju-green);
        }
        
        .menu-link.active {
            background: var(--ju-light-green);
            color: var(--ju-green);
            border-left-color: var(--ju-green);
            font-weight: 500;
        }
        
        .menu-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }
        
        /* Main Content Styles */
        .ju-main-content {
            flex: 1;
            padding: 25px;
            background: white;
            min-height: calc(100vh - 90px);
            overflow-y: auto;
        }
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--ju-light-green);
        }
        
        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--ju-green);
            margin: 0;
        }
        
        .page-subtitle {
            color: #666;
            margin: 5px 0 0 0;
            font-size: 1rem;
        }
        
        /* Card Styles */
        .ju-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 25px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .ju-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
        }
        
        .ju-card-header {
            background: linear-gradient(135deg, var(--ju-green) 0%, var(--ju-dark-green) 100%);
            color: white;
            padding: 15px 20px;
            border-bottom: none;
        }
        
        .ju-card-title {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }
        
        .ju-card-body {
            padding: 20px;
        }
        
        /* Button Styles */
        .btn-ju {
            background: linear-gradient(135deg, var(--ju-green) 0%, var(--ju-dark-green) 100%);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-ju:hover {
            background: linear-gradient(135deg, var(--ju-dark-green) 0%, var(--ju-green) 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 100, 0, 0.2);
        }
        
        .btn-ju-outline {
            background: transparent;
            color: var(--ju-green);
            border: 2px solid var(--ju-green);
            padding: 8px 20px;
        }
        
        .btn-ju-outline:hover {
            background: var(--ju-green);
            color: white;
        }
        
        /* Table Styles */
        .table-ju {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .table-ju thead th {
            background: var(--ju-light-green);
            color: var(--ju-green);
            font-weight: 600;
            padding: 12px 15px;
            border: none;
            border-bottom: 2px solid var(--ju-green);
        }
        
        .table-ju tbody tr {
            transition: background 0.3s;
        }
        
        .table-ju tbody tr:hover {
            background: var(--ju-light-green);
        }
        
        .table-ju td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        
        /* Badge Styles */
        .badge-ju {
            background: var(--ju-light-green);
            color: var(--ju-green);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        /* Alert Styles */
        .alert-ju {
            border-left: 4px solid var(--ju-green);
            border-radius: 5px;
            background: var(--ju-light-green);
        }
        
        /* Footer Styles */
        .ju-footer {
            background: var(--ju-dark-gray);
            color: white;
            padding: 30px 0 20px;
            margin-top: auto;
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .footer-copyright {
            color: #aaa;
            font-size: 0.9rem;
        }
        
        .footer-links {
            display: flex;
            gap: 20px;
        }
        
        .footer-links a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--ju-gold);
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
            }
            
            .ju-sidebar {
                width: 100%;
                height: auto;
                position: static;
                min-height: auto;
            }
            
            .sidebar-menu {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
            }
            
            .menu-item {
                flex: 1;
                min-width: 200px;
            }
            
            .menu-link {
                justify-content: center;
                text-align: center;
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .ju-logo-container {
                flex-direction: column;
                text-align: center;
            }
            
            .user-menu {
                width: 100%;
                justify-content: center;
            }
            
            .content-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
        
        /* Utility Classes */
        .text-ju {
            color: var(--ju-green);
        }
        
        .bg-ju {
            background-color: var(--ju-green);
        }
        
        .border-ju {
            border-color: var(--ju-green);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="ju-header">
        <div class="header-container">
            <div class="ju-logo-container">
                <div class="ju-logo">JU</div>
                <div class="ju-title">
                    <h1 class="ju-main-title">Jimma University</h1>
                    <p class="ju-subtitle">Event Management System</p>
                </div>
            </div>
            
            <div class="user-menu">
                @auth
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight: 500;">{{ auth()->user()->name }}</div>
                        <small style="opacity: 0.8;">
                            @if(auth()->user()->role)
                                {{ auth()->user()->role->name }}
                            @else
                                No Role
                            @endif
                        </small>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-ju-outline">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
                @endauth
                
                @guest
                <div>
                    <a href="{{ route('login') }}" class="btn btn-ju me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-ju-outline">Register</a>
                </div>
                @endguest
            </div>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="main-container">
        @auth
        <!-- Sidebar -->
        <nav class="ju-sidebar">
            <ul class="sidebar-menu">
                <li class="menu-header">MAIN NAVIGATION</li>
                
                <li class="menu-item">
                    <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                @if(auth()->user()->hasPermission('view_users') || auth()->user()->hasPermission('create_users'))
                <li class="menu-header">USER MANAGEMENT</li>
                
                @if(auth()->user()->hasPermission('view_users'))
                <li class="menu-item">
                    <a href="{{ route('users.index') }}" class="menu-link {{ request()->routeIs('users.*') && !request()->routeIs('users.create') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                @endif
                
                @if(auth()->user()->hasPermission('create_users'))
                <li class="menu-item">
                    <a href="{{ route('users.create') }}" class="menu-link {{ request()->routeIs('users.create') ? 'active' : '' }}">
                        <i class="fas fa-user-plus"></i>
                        <span>Add User</span>
                    </a>
                </li>
                @endif
                @endif
                
                @if(auth()->user()->hasPermission('view_roles'))
                <li class="menu-item">
                    <a href="{{ route('roles.index') }}" class="menu-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tag"></i>
                        <span>Roles</span>
                    </a>
                </li>
                @endif
                
                @if(auth()->user()->hasPermission('view_permissions'))
                <li class="menu-item">
                    <a href="{{ route('permissions.index') }}" class="menu-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
                        <i class="fas fa-key"></i>
                        <span>Permissions</span>
                    </a>
                </li>
                @endif
                
                <li class="menu-header">EVENTS</li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Calendar</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fas fa-list"></i>
                        <span>Event List</span>
                    </a>
                </li>
                
                <li class="menu-header">SYSTEM</li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="fas fa-question-circle"></i>
                        <span>Help & Support</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endauth
        
        <!-- Main Content -->
        <main class="ju-main-content">
            <!-- Content Header -->
            <div class="content-header">
                <div>
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="page-subtitle">@yield('page-subtitle', 'Welcome to Jimma University Event Management System')</p>
                </div>
                
                <div class="breadcrumb">
                    @hasSection('breadcrumb')
                        @yield('breadcrumb')
                    @else
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                @yield('breadcrumb-items')
                            </ol>
                        </nav>
                    @endif
                </div>
            </div>
            
            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show alert-ju" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show alert-ju" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show alert-ju" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show alert-ju" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            <!-- Main Content Area -->
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="ju-footer">
        <div class="footer-content">
            <div class="footer-copyright">
                &copy; {{ date('Y') }} Jimma University. All Rights Reserved.
            </div>
            <div class="footer-links">
                <a href="#"><i class="fas fa-info-circle me-1"></i> About</a>
                <a href="#"><i class="fas fa-envelope me-1"></i> Contact</a>
                <a href="#"><i class="fas fa-shield-alt me-1"></i> Privacy</a>
                <a href="#"><i class="fas fa-file-contract me-1"></i> Terms</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
            
            // Confirm delete actions
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
            
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>