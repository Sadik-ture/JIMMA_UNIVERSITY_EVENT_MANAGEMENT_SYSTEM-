<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Jimma University | Event Management System')</title>

    <!-- Meta Tags for Professional SEO -->
    <meta name="description" content="Jimma University Event Management System - Professional platform for managing university events, registrations, and venue bookings.">
    <meta name="author" content="Jimma University">
    <meta name="keywords" content="Jimma University, Events, Management System, Ethiopia, Higher Education">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 Pro Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts - Inter & Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    <!-- Animate.css for smooth animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- AOS (Animate on Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <!-- CSRF Token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Perfect Layout Styles -->
    <style>
        /* ============================================
           JIMMA UNIVERSITY ENHANCED DESIGN SYSTEM
        ============================================ */

        :root {
            /* Official Jimma University Color Palette - Enhanced */
            --ju-primary: #006400;
            /* Official Dark Green - Primary */
            --ju-primary-dark: #004d00;
            /* Darker Green for hover states */
            --ju-primary-light: #228B22;
            /* Forest Green for accents */
            --ju-primary-lighter: #d4edda;
            /* Light green for backgrounds */
            --ju-secondary: #FFD700;
            /* Gold - Secondary & Accents */
            --ju-secondary-dark: #B8860B;
            /* Dark Gold */
            --ju-accent: #8B4513;
            /* Saddle Brown - Traditional Accent */
            --ju-accent-light: #F8F9FA;
            /* Light accent */

            /* Professional Neutral Palette */
            --ju-white: #FFFFFF;
            --ju-light: #F8F9FA;
            --ju-gray-50: #F9FAFB;
            --ju-gray-100: #F5F7FA;
            --ju-gray-200: #E4E7EB;
            --ju-gray-300: #CBD2D9;
            --ju-gray-400: #9AA5B1;
            --ju-gray-500: #7B8794;
            --ju-gray-600: #616E7C;
            --ju-gray-700: #3E4C59;
            --ju-gray-800: #323F4B;
            --ju-gray-900: #1F2933;
            --ju-black: #000000;

            /* Semantic Colors - Enhanced */
            --ju-success: #10B981;
            --ju-success-light: #D1FAE5;
            --ju-info: #3B82F6;
            --ju-info-light: #DBEAFE;
            --ju-warning: #F59E0B;
            --ju-warning-light: #FEF3C7;
            --ju-danger: #EF4444;
            --ju-danger-light: #FEE2E2;
            --ju-purple: #8B5CF6;
            --ju-pink: #EC4899;

            /* Gradient Definitions - Enhanced */
            --ju-gradient-primary: linear-gradient(135deg, var(--ju-primary) 0%, var(--ju-primary-dark) 100%);
            --ju-gradient-secondary: linear-gradient(135deg, var(--ju-secondary) 0%, var(--ju-secondary-dark) 100%);
            --ju-gradient-success: linear-gradient(135deg, var(--ju-success) 0%, #059669 100%);
            --ju-gradient-info: linear-gradient(135deg, var(--ju-info) 0%, #1D4ED8 100%);
            --ju-gradient-warning: linear-gradient(135deg, var(--ju-warning) 0%, #D97706 100%);
            --ju-gradient-danger: linear-gradient(135deg, var(--ju-danger) 0%, #DC2626 100%);
            --ju-gradient-light: linear-gradient(135deg, var(--ju-light) 0%, #E8F5E9 100%);
            --ju-gradient-dark: linear-gradient(135deg, var(--ju-gray-800) 0%, var(--ju-gray-900) 100%);

            /* Shadow System - Enhanced */
            --ju-shadow-xs: 0 1px 2px 0 rgba(0, 100, 0, 0.05);
            --ju-shadow-sm: 0 1px 3px 0 rgba(0, 100, 0, 0.1), 0 1px 2px -1px rgba(0, 100, 0, 0.1);
            --ju-shadow-md: 0 4px 6px -1px rgba(0, 100, 0, 0.1), 0 2px 4px -2px rgba(0, 100, 0, 0.1);
            --ju-shadow-lg: 0 10px 15px -3px rgba(0, 100, 0, 0.1), 0 4px 6px -4px rgba(0, 100, 0, 0.1);
            --ju-shadow-xl: 0 20px 25px -5px rgba(0, 100, 0, 0.1), 0 8px 10px -6px rgba(0, 100, 0, 0.1);
            --ju-shadow-2xl: 0 25px 50px -12px rgba(0, 100, 0, 0.25);

            /* Spacing Scale */
            --ju-spacing-xs: 0.25rem;
            --ju-spacing-sm: 0.5rem;
            --ju-spacing-md: 1rem;
            --ju-spacing-lg: 1.5rem;
            --ju-spacing-xl: 2rem;
            --ju-spacing-2xl: 3rem;
            --ju-spacing-3xl: 4rem;

            /* Border Radius - Enhanced */
            --ju-radius-sm: 0.375rem;
            --ju-radius-md: 0.5rem;
            --ju-radius-lg: 0.75rem;
            --ju-radius-xl: 1rem;
            --ju-radius-2xl: 1.5rem;
            --ju-radius-full: 9999px;

            /* Typography - Enhanced */
            --ju-font-primary: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --ju-font-secondary: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --ju-font-mono: 'SF Mono', Monaco, 'Cascadia Mono', 'Segoe UI Mono', monospace;

            /* Transitions - Enhanced */
            --ju-transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --ju-transition-normal: 250ms cubic-bezier(0.4, 0, 0.2, 1);
            --ju-transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);
            --ju-transition-bounce: 500ms cubic-bezier(0.68, -0.55, 0.265, 1.55);

            /* Z-index System */
            --ju-z-dropdown: 1000;
            --ju-z-sticky: 1020;
            --ju-z-fixed: 1030;
            --ju-z-modal-backdrop: 1040;
            --ju-z-modal: 1050;
            --ju-z-popover: 1060;
            --ju-z-tooltip: 1070;
            --ju-z-toast: 1080;
        }

        /* ============================================
           BASE STYLES & RESET
        ============================================ */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
            height: 100%;
        }

        body {
            font-family: var(--ju-font-primary);
            font-weight: 400;
            line-height: 1.6;
            color: var(--ju-gray-800);
            background: linear-gradient(135deg, var(--ju-gray-50) 0%, #E8F5E9 30%, var(--ju-gray-100) 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* ============================================
           PREMIUM GLASSMORPHISM HEADER
        ============================================ */

        .ju-header {
            background: rgba(0, 100, 0, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            color: var(--ju-white);
            padding: 0;
            box-shadow: var(--ju-shadow-lg);
            position: sticky;
            top: 0;
            z-index: var(--ju-z-sticky);
            border-bottom: 3px solid var(--ju-secondary);
            transition: all var(--ju-transition-normal);
        }

        .ju-header.scrolled {
            background: rgba(0, 100, 0, 0.98);
            backdrop-filter: blur(30px) saturate(200%);
            -webkit-backdrop-filter: blur(30px) saturate(200%);
            box-shadow: var(--ju-shadow-xl);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 var(--ju-spacing-xl);
            height: 70px;
            gap: var(--ju-spacing-lg);
        }

        .ju-brand {
            display: flex;
            align-items: center;
            gap: var(--ju-spacing-md);
            cursor: pointer;
            transition: all var(--ju-transition-normal);
            text-decoration: none;
            flex-shrink: 0;
        }

        .ju-brand:hover {
            transform: translateY(-2px);
        }

        .ju-logo {
            width: 52px;
            height: 52px;
            background: var(--ju-white);
            border-radius: var(--ju-radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: var(--ju-primary);
            font-size: 1.75rem;
            box-shadow: var(--ju-shadow-md);
            border: 3px solid var(--ju-secondary);
            transition: all var(--ju-transition-bounce);
            position: relative;
            overflow: hidden;
        }

        .ju-logo::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: translateX(-100%);
        }

        .ju-brand:hover .ju-logo {
            transform: rotate(5deg) scale(1.1);
            box-shadow: var(--ju-shadow-lg);
        }

        .ju-brand:hover .ju-logo::before {
            animation: shine 1.5s ease-out;
        }

        @keyframes shine {
            100% {
                transform: translateX(100%);
            }
        }

        .ju-title-container {
            display: flex;
            flex-direction: column;
        }

        .ju-main-title {
            font-family: var(--ju-font-secondary);
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
            line-height: 1.2;
            letter-spacing: -0.3px;
            background: linear-gradient(135deg, var(--ju-white) 0%, var(--ju-secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .ju-subtitle {
            font-size: 0.75rem;
            font-weight: 600;
            margin: 0;
            color: rgba(255, 255, 255, 0.9);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            opacity: 0.9;
        }

        /* Premium User Menu - Glassmorphism */
        .user-menu-container {
            display: flex;
            align-items: center;
            gap: var(--ju-spacing-md);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: var(--ju-spacing-md);
            padding: var(--ju-spacing-sm) var(--ju-spacing-md);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: var(--ju-radius-full);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all var(--ju-transition-normal);
            cursor: pointer;
            position: relative;
        }

        .user-profile:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
            box-shadow: var(--ju-shadow-md);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            background: var(--ju-gradient-secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ju-primary);
            font-weight: 700;
            font-size: 1.1rem;
            border: 2px solid var(--ju-white);
            box-shadow: var(--ju-shadow-sm);
            transition: all var(--ju-transition-bounce);
            position: relative;
            overflow: hidden;
        }

        .user-avatar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: translateX(-100%);
        }

        .user-profile:hover .user-avatar {
            transform: scale(1.15) rotate(5deg);
            box-shadow: var(--ju-shadow-md);
        }

        .user-profile:hover .user-avatar::before {
            animation: shine 1.5s ease-out;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--ju-white);
            white-space: nowrap;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: var(--ju-white);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.6rem 1.2rem;
            border-radius: var(--ju-radius-full);
            font-size: 0.85rem;
            font-weight: 600;
            transition: all var(--ju-transition-normal);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: var(--ju-shadow-md);
            border-color: rgba(255, 255, 255, 0.4);
            color: var(--ju-white);
        }

        /* Guest Navigation */
        .guest-nav {
            display: flex;
            gap: var(--ju-spacing-md);
        }

        /* Header Search Bar - Enhanced */
        .header-search {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .header-search input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--ju-radius-full);
            color: var(--ju-white);
            font-size: 0.9rem;
            transition: all var(--ju-transition-normal);
        }

        .header-search input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .header-search input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        .header-search i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
        }

        /* ============================================
           ENHANCED MAIN LAYOUT
        ============================================ */

        .main-layout {
            display: flex;
            flex: 1;
            max-width: 1600px;
            margin: var(--ju-spacing-xl) auto;
            width: 100%;
            padding: 0 var(--ju-spacing-xl);
            gap: var(--ju-spacing-xl);
            min-height: calc(100vh - 140px);
        }

        /* ============================================
           PREMIUM GLASS SIDEBAR
        ============================================ */

        .ju-sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: var(--ju-radius-2xl);
            box-shadow: var(--ju-shadow-xl);
            padding: var(--ju-spacing-lg) 0;
            position: sticky;
            top: 94px;
            height: calc(100vh - 114px);
            overflow-y: auto;
            flex-shrink: 0;
            border: 1px solid rgba(0, 100, 0, 0.1);
            transition: all var(--ju-transition-normal);
            animation: sidebarSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes sidebarSlideIn {
            from {
                opacity: 0;
                transform: translateX(-30px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        .ju-sidebar:hover {
            box-shadow: var(--ju-shadow-2xl);
            border-color: rgba(0, 100, 0, 0.2);
            transform: translateY(-2px);
        }

        /* Premium Scrollbar */
        .ju-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .ju-sidebar::-webkit-scrollbar-track {
            background: rgba(0, 100, 0, 0.05);
            border-radius: var(--ju-radius-full);
        }

        .ju-sidebar::-webkit-scrollbar-thumb {
            background: var(--ju-primary);
            border-radius: var(--ju-radius-full);
            transition: background var(--ju-transition-normal);
        }

        .ju-sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--ju-primary-dark);
        }

        /* Sidebar Menu System - Enhanced */
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .menu-header {
            padding: var(--ju-spacing-md) var(--ju-spacing-xl) var(--ju-spacing-xs);
            color: var(--ju-gray-600);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: var(--ju-spacing-lg);
            position: relative;
            background: linear-gradient(to right, transparent, rgba(0, 100, 0, 0.05), transparent);
            border-radius: var(--ju-radius-md);
            margin: var(--ju-spacing-md) var(--ju-spacing-xl);
        }

        .menu-header::before {
            content: '';
            position: absolute;
            left: var(--ju-spacing-xl);
            right: var(--ju-spacing-xl);
            bottom: -1px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--ju-primary), transparent);
            border-radius: var(--ju-radius-full);
        }

        .menu-item {
            padding: 0;
            margin: 0;
            position: relative;
            opacity: 0;
            animation: menuItemFadeIn 0.6s ease forwards;
        }

        @keyframes menuItemFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Create staggered animation */
        .menu-item:nth-child(1) {
            animation-delay: 0.1s;
            transform: translateY(10px);
        }

        .menu-item:nth-child(2) {
            animation-delay: 0.2s;
            transform: translateY(10px);
        }

        .menu-item:nth-child(3) {
            animation-delay: 0.3s;
            transform: translateY(10px);
        }

        .menu-item:nth-child(4) {
            animation-delay: 0.4s;
            transform: translateY(10px);
        }

        .menu-item:nth-child(5) {
            animation-delay: 0.5s;
            transform: translateY(10px);
        }

        .menu-item:nth-child(6) {
            animation-delay: 0.6s;
            transform: translateY(10px);
        }

        .menu-item:nth-child(7) {
            animation-delay: 0.7s;
            transform: translateY(10px);
        }

        .menu-item:nth-child(8) {
            animation-delay: 0.8s;
            transform: translateY(10px);
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: var(--ju-spacing-md);
            padding: var(--ju-spacing-md) var(--ju-spacing-xl);
            color: var(--ju-gray-700);
            text-decoration: none;
            transition: all var(--ju-transition-normal);
            border-left: 4px solid transparent;
            font-weight: 500;
            font-size: 0.9rem;
            position: relative;
            margin: 2px var(--ju-spacing-xl);
            border-radius: var(--ju-radius-lg);
            overflow: hidden;
        }

        .menu-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, rgba(0, 100, 0, 0.08) 0%, rgba(0, 100, 0, 0.02) 100%);
            transition: width var(--ju-transition-normal);
            z-index: 0;
        }

        .menu-link::after {
            content: '';
            position: absolute;
            left: -10px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            background: var(--ju-primary);
            border-radius: 50%;
            opacity: 0;
            transition: all var(--ju-transition-bounce);
            z-index: 1;
        }

        .menu-link:hover {
            color: var(--ju-primary);
            transform: translateX(6px);
            background: linear-gradient(90deg, rgba(0, 100, 0, 0.05) 0%, rgba(0, 100, 0, 0.02) 100%);
        }

        .menu-link:hover::before {
            width: 100%;
        }

        .menu-link:hover::after {
            opacity: 1;
            left: 10px;
            transform: translateY(-50%) scale(1.2);
        }

        .menu-link.active {
            background: linear-gradient(90deg, rgba(0, 100, 0, 0.1) 0%, rgba(0, 100, 0, 0.05) 100%);
            color: var(--ju-primary);
            border-left-color: var(--ju-primary);
            font-weight: 600;
            box-shadow: inset 4px 0 12px rgba(0, 100, 0, 0.1);
            transform: translateX(4px);
        }

        .menu-link.active::before {
            width: 100%;
        }

        .menu-link.active::after {
            opacity: 1;
            left: 10px;
            background: var(--ju-secondary);
            box-shadow: 0 0 8px rgba(255, 215, 0, 0.4);
            transform: translateY(-50%) scale(1.3);
        }

        .menu-icon {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            color: var(--ju-gray-600);
            transition: all var(--ju-transition-normal);
            position: relative;
            z-index: 2;
            flex-shrink: 0;
        }

        .menu-link:hover .menu-icon,
        .menu-link.active .menu-icon {
            color: var(--ju-primary);
            transform: scale(1.15);
        }

        .menu-title {
            position: relative;
            z-index: 2;
            flex: 1;
            font-weight: inherit;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .menu-badge {
            background: var(--ju-gradient-danger);
            color: var(--ju-white);
            font-size: 0.65rem;
            padding: 3px 9px;
            border-radius: var(--ju-radius-full);
            font-weight: 700;
            position: relative;
            z-index: 2;
            box-shadow: var(--ju-shadow-sm);
            animation: pulse 2s infinite;
            flex-shrink: 0;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: var(--ju-shadow-sm);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
            }
        }

        /* Enhanced Collapsible Menu */
        .menu-collapse {
            cursor: pointer;
            position: relative;
        }

        .menu-arrow {
            position: absolute;
            right: var(--ju-spacing-xl);
            transition: transform var(--ju-transition-bounce);
            font-size: 0.8rem;
            color: var(--ju-gray-500);
            z-index: 2;
        }

        .menu-collapse:hover .menu-arrow {
            color: var(--ju-primary);
        }

        .menu-collapse[aria-expanded="true"] .menu-arrow {
            transform: rotate(90deg);
            color: var(--ju-primary);
        }

        /* Premium Sub-menu - Enhanced */
        .sub-menu {
            list-style: none;
            padding: 0;
            background: rgba(0, 100, 0, 0.03);
            border-left: 3px solid var(--ju-primary-light);
            margin-left: calc(var(--ju-spacing-xl) + 20px);
            border-radius: 0 var(--ju-radius-lg) var(--ju-radius-lg) 0;
            animation: subMenuSlideDown 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        @keyframes subMenuSlideDown {
            from {
                opacity: 0;
                max-height: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                max-height: 500px;
                transform: translateY(0);
            }
        }

        .sub-menu::before {
            content: '';
            position: absolute;
            left: -3px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, transparent, var(--ju-primary-light), transparent);
        }

        .sub-menu .nav-link {
            padding: var(--ju-spacing-sm) var(--ju-spacing-xl) var(--ju-spacing-sm) calc(var(--ju-spacing-xl) + 20px);
            color: var(--ju-gray-600);
            font-size: 0.85rem;
            font-weight: 400;
            position: relative;
            transition: all var(--ju-transition-normal);
            border-radius: 0 var(--ju-radius-md) var(--ju-radius-md) 0;
        }

        .sub-menu .nav-link::before {
            content: '';
            position: absolute;
            left: calc(var(--ju-spacing-xl) - 6px);
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            background: var(--ju-gray-400);
            border-radius: 50%;
            transition: all var(--ju-transition-normal);
        }

        .sub-menu .nav-link:hover {
            color: var(--ju-primary);
            background: rgba(0, 100, 0, 0.05);
            padding-left: calc(var(--ju-spacing-xl) + 30px);
            transform: translateX(4px);
        }

        .sub-menu .nav-link:hover::before {
            background: var(--ju-primary);
            transform: translateY(-50%) scale(1.3);
            box-shadow: 0 0 8px rgba(0, 100, 0, 0.3);
        }

        .sub-menu .nav-link.active {
            color: var(--ju-primary);
            font-weight: 500;
            background: rgba(0, 100, 0, 0.08);
            padding-left: calc(var(--ju-spacing-xl) + 30px);
        }

        .sub-menu .nav-link.active::before {
            background: var(--ju-primary);
            box-shadow: 0 0 10px rgba(0, 100, 0, 0.4);
            transform: translateY(-50%) scale(1.5);
        }

        /* ============================================
           PREMIUM GLASS CARDS - ENHANCED
        ============================================ */

        .ju-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: var(--ju-radius-2xl);
            box-shadow: var(--ju-shadow-lg);
            border: 1px solid rgba(0, 100, 0, 0.1);
            margin-bottom: var(--ju-spacing-xl);
            transition: all var(--ju-transition-bounce);
            position: relative;
            overflow: hidden;
        }

        .ju-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--ju-gradient-primary);
            opacity: 0;
            transition: opacity var(--ju-transition-normal);
        }

        .ju-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: var(--ju-shadow-2xl);
            border-color: rgba(0, 100, 0, 0.2);
        }

        .ju-card:hover::before {
            opacity: 1;
        }

        /* Card Header - Enhanced */
        .ju-card-header {
            background: linear-gradient(135deg, rgba(248, 249, 250, 0.8) 0%, rgba(255, 255, 255, 0.9) 100%);
            color: var(--ju-primary);
            padding: var(--ju-spacing-xl);
            border-bottom: 1px solid rgba(0, 100, 0, 0.1);
            position: relative;
            border-radius: var(--ju-radius-2xl) var(--ju-radius-2xl) 0 0;
        }

        .ju-card-header::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: var(--ju-spacing-xl);
            right: var(--ju-spacing-xl);
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--ju-primary), transparent);
            border-radius: var(--ju-radius-full);
        }

        .ju-card-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: var(--ju-spacing-sm);
            color: var(--ju-primary);
            line-height: 1.3;
        }

        .ju-card-title i {
            font-size: 1.3rem;
            color: var(--ju-primary-light);
        }

        /* Card Body - Enhanced */
        .ju-card-body {
            padding: var(--ju-spacing-2xl);
            position: relative;
        }

        .ju-card-body p {
            color: var(--ju-gray-700);
            margin-bottom: var(--ju-spacing-md);
            line-height: 1.7;
            font-size: 1rem;
        }

        .ju-card-body .lead {
            font-size: 1.2rem;
            color: var(--ju-gray-800);
            font-weight: 500;
            margin-bottom: var(--ju-spacing-xl);
        }

        .ju-card-body .text-muted {
            color: var(--ju-gray-600) !important;
            font-size: 0.95rem;
        }

        /* Card Footer - Enhanced */
        .ju-card-footer {
            background: rgba(248, 249, 250, 0.8);
            padding: var(--ju-spacing-lg) var(--ju-spacing-xl);
            border-top: 1px solid rgba(0, 100, 0, 0.1);
            border-radius: 0 0 var(--ju-radius-2xl) var(--ju-radius-2xl);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Enhanced Stat Cards */
        .stat-card {
            background: var(--ju-gradient-primary);
            color: var(--ju-white);
            border-radius: var(--ju-radius-2xl);
            padding: var(--ju-spacing-2xl);
            text-align: center;
            transition: all var(--ju-transition-bounce);
            position: relative;
            overflow: hidden;
            box-shadow: var(--ju-shadow-lg);
            border: none;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: translateX(-100%);
        }

        .stat-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: var(--ju-shadow-2xl);
        }

        .stat-card:hover::before {
            animation: shine 1.5s ease-out;
        }

        .stat-icon {
            font-size: 3.5rem;
            margin-bottom: var(--ju-spacing-md);
            opacity: 0.9;
            position: relative;
            z-index: 2;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: var(--ju-spacing-xs);
            position: relative;
            z-index: 2;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            font-family: var(--ju-font-secondary);
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.95;
            font-weight: 600;
            position: relative;
            z-index: 2;
            letter-spacing: 0.5px;
        }

        /* Alternative Stat Card Colors */
        .stat-card-success {
            background: var(--ju-gradient-success);
        }

        .stat-card-warning {
            background: var(--ju-gradient-warning);
        }

        .stat-card-info {
            background: var(--ju-gradient-info);
        }

        .stat-card-danger {
            background: var(--ju-gradient-danger);
        }

        .stat-card-purple {
            background: linear-gradient(135deg, var(--ju-purple) 0%, #7C3AED 100%);
        }

        .stat-card-pink {
            background: linear-gradient(135deg, var(--ju-pink) 0%, #DB2777 100%);
        }

        /* Table Cards - Enhanced */
        .table-card {
            min-height: 500px;
            display: flex;
            flex-direction: column;
        }

        .table-card .ju-card-body {
            padding: 0;
            flex: 1;
        }

        .table-card .table-responsive {
            padding: var(--ju-spacing-md);
        }

        .table-card table {
            margin: 0;
            width: 100%;
        }

        .table-card table th {
            background: rgba(0, 100, 0, 0.05);
            color: var(--ju-primary);
            font-weight: 700;
            padding: var(--ju-spacing-lg);
            border-bottom: 3px solid var(--ju-primary-light);
            white-space: nowrap;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-card table td {
            padding: var(--ju-spacing-lg);
            border-bottom: 1px solid rgba(0, 100, 0, 0.1);
            vertical-align: middle;
            color: var(--ju-gray-700);
            font-size: 0.95rem;
        }

        .table-card table tr:hover td {
            background: rgba(0, 100, 0, 0.03);
        }

        .table-card table tr:last-child td {
            border-bottom: none;
        }

        /* ============================================
           PREMIUM MAIN CONTENT AREA - GLASS EFFECT
        ============================================ */

        .ju-main-content {
            flex: 1;
            padding: var(--ju-spacing-2xl);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: var(--ju-radius-2xl);
            box-shadow: var(--ju-shadow-xl);
            min-height: calc(100vh - 114px);
            overflow-y: auto;
            position: relative;
            animation: contentFadeIn 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
            border: 1px solid rgba(0, 100, 0, 0.1);
        }

        @keyframes contentFadeIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Content Header - Enhanced */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--ju-spacing-2xl);
            padding-bottom: var(--ju-spacing-xl);
            border-bottom: 2px solid rgba(0, 100, 0, 0.1);
            position: relative;
        }

        .content-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100px;
            height: 3px;
            background: var(--ju-gradient-primary);
            border-radius: var(--ju-radius-full);
            animation: titleUnderline 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes titleUnderline {
            from {
                width: 0;
            }

            to {
                width: 100px;
            }
        }

        .page-title-container {
            flex: 1;
        }

        .page-title {
            font-family: var(--ju-font-secondary);
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--ju-primary);
            margin: 0;
            line-height: 1.2;
            position: relative;
            display: inline-block;
            background: linear-gradient(135deg, var(--ju-primary) 0%, var(--ju-primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: var(--ju-gray-600);
            margin: var(--ju-spacing-sm) 0 0;
            font-size: 1.1rem;
            font-weight: 400;
            max-width: 700px;
            line-height: 1.6;
        }

        /* Breadcrumb - Enhanced */
        .breadcrumb-nav {
            background: rgba(0, 100, 0, 0.05);
            backdrop-filter: blur(10px);
            border-radius: var(--ju-radius-lg);
            padding: var(--ju-spacing-md) var(--ju-spacing-lg);
            box-shadow: var(--ju-shadow-sm);
            border: 1px solid rgba(0, 100, 0, 0.1);
        }

        .breadcrumb {
            margin: 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--ju-primary);
            text-decoration: none;
            font-weight: 600;
            transition: all var(--ju-transition-fast);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .breadcrumb-item a:hover {
            color: var(--ju-primary-dark);
            transform: translateX(2px);
        }

        .breadcrumb-item.active {
            color: var(--ju-gray-700);
            font-weight: 600;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: var(--ju-gray-400);
            font-weight: bold;
        }

        /* ============================================
           PREMIUM TOAST NOTIFICATION SYSTEM
        ============================================ */

        .toast-container {
            position: fixed;
            top: 90px;
            right: var(--ju-spacing-xl);
            z-index: var(--ju-z-toast);
            max-width: 400px;
            animation: toastSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes toastSlideIn {
            from {
                opacity: 0;
                transform: translateX(100%) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        .ju-toast {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: none;
            border-radius: var(--ju-radius-xl);
            padding: var(--ju-spacing-lg);
            margin-bottom: var(--ju-spacing-md);
            box-shadow: var(--ju-shadow-xl);
            border-left: 4px solid;
            animation: toastPulse 2s infinite;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        @keyframes toastPulse {

            0%,
            100% {
                box-shadow: var(--ju-shadow-xl);
            }

            50% {
                box-shadow: 0 0 25px currentColor;
            }
        }

        .ju-toast::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: currentColor;
            opacity: 0.3;
        }

        .ju-toast-success {
            border-left-color: var(--ju-success);
            color: var(--ju-success);
        }

        .ju-toast-error {
            border-left-color: var(--ju-danger);
            color: var(--ju-danger);
        }

        .ju-toast-warning {
            border-left-color: var(--ju-warning);
            color: var(--ju-warning);
        }

        .ju-toast-info {
            border-left-color: var(--ju-info);
            color: var(--ju-info);
        }

        /* ============================================
           PREMIUM FOOTER - GLASS EFFECT
        ============================================ */

        .ju-footer {
            background: rgba(0, 100, 0, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            color: var(--ju-white);
            padding: var(--ju-spacing-2xl) 0 var(--ju-spacing-xl);
            margin-top: auto;
            border-top: 3px solid var(--ju-secondary);
            position: relative;
        }

        .ju-footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        }

        .footer-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 var(--ju-spacing-xl);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--ju-spacing-xl);
        }

        .footer-copyright {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: var(--ju-spacing-sm);
        }

        .footer-links {
            display: flex;
            gap: var(--ju-spacing-xl);
            flex-wrap: wrap;
        }

        .footer-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all var(--ju-transition-normal);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .footer-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--ju-secondary);
            transition: width var(--ju-transition-normal);
            border-radius: var(--ju-radius-full);
        }

        .footer-link:hover {
            color: var(--ju-secondary);
            transform: translateY(-2px);
        }

        .footer-link:hover::after {
            width: 100%;
        }

        /* ============================================
           ENHANCED PREMIUM BUTTONS
        ============================================ */

        .btn-ju {
            background: var(--ju-gradient-primary);
            color: var(--ju-white);
            border: none;
            padding: 0.875rem 1.75rem;
            border-radius: var(--ju-radius-lg);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all var(--ju-transition-bounce);
            box-shadow: var(--ju-shadow-md);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.5px;
            cursor: pointer;
        }

        .btn-ju::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left var(--ju-transition-slow);
        }

        .btn-ju:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: var(--ju-shadow-lg);
        }

        .btn-ju:hover::before {
            left: 100%;
        }

        .btn-ju-outline {
            background: transparent;
            color: var(--ju-primary);
            border: 2px solid var(--ju-primary);
            padding: 0.75rem 1.5rem;
            transition: all var(--ju-transition-bounce);
            position: relative;
            overflow: hidden;
            font-weight: 600;
            border-radius: var(--ju-radius-lg);
            cursor: pointer;
        }

        .btn-ju-outline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--ju-primary);
            transition: width var(--ju-transition-normal);
            z-index: 1;
        }

        .btn-ju-outline span {
            position: relative;
            z-index: 2;
        }

        .btn-ju-outline:hover {
            color: var(--ju-white);
            transform: translateY(-3px) scale(1.05);
            box-shadow: var(--ju-shadow-md);
            border-color: transparent;
        }

        .btn-ju-outline:hover::before {
            width: 100%;
        }

        /* Button Variants */
        .btn-ju-success {
            background: var(--ju-gradient-success);
        }

        .btn-ju-warning {
            background: var(--ju-gradient-warning);
        }

        .btn-ju-danger {
            background: var(--ju-gradient-danger);
        }

        .btn-ju-info {
            background: var(--ju-gradient-info);
        }

        /* ============================================
           ENHANCED RESPONSIVE DESIGN SYSTEM
        ============================================ */

        @media (max-width: 1400px) {

            .header-container,
            .main-layout,
            .footer-container {
                padding: 0 var(--ju-spacing-lg);
            }

            .ju-main-content {
                padding: var(--ju-spacing-xl);
            }

            .ju-card-body {
                padding: var(--ju-spacing-xl);
            }

            .stat-card {
                padding: var(--ju-spacing-xl);
            }
        }

        @media (max-width: 1200px) {
            .main-layout {
                gap: var(--ju-spacing-lg);
            }

            .ju-sidebar {
                width: 260px;
            }

            .stat-number {
                font-size: 3rem;
            }

            .page-title {
                font-size: 2.25rem;
            }
        }

        @media (max-width: 992px) {
            .main-layout {
                flex-direction: column;
                gap: var(--ju-spacing-lg);
            }

            .ju-sidebar {
                width: 100%;
                height: auto;
                position: static;
                min-height: auto;
                max-height: 60vh;
            }

            .sidebar-menu {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: var(--ju-spacing-sm);
            }

            .menu-header {
                grid-column: 1 / -1;
                margin: var(--ju-spacing-sm);
            }

            .menu-link {
                margin: 2px var(--ju-spacing-sm);
            }

            .sub-menu {
                position: static;
                background: rgba(0, 100, 0, 0.05);
                border-left: none;
                margin-left: 0;
                border-radius: var(--ju-radius-lg);
                margin-top: var(--ju-spacing-xs);
            }

            .ju-main-content {
                min-height: auto;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .stat-icon {
                font-size: 2.8rem;
            }

            .header-search {
                max-width: 300px;
            }
        }

        @media (max-width: 768px) {
            html {
                font-size: 15px;
            }

            .header-container {
                flex-direction: column;
                gap: var(--ju-spacing-md);
                height: auto;
                padding: var(--ju-spacing-md) var(--ju-spacing-lg);
            }

            .ju-brand {
                width: 100%;
                justify-content: center;
            }

            .user-menu-container {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .content-header {
                flex-direction: column;
                gap: var(--ju-spacing-md);
                text-align: center;
            }

            .page-title::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-container {
                flex-direction: column;
                gap: var(--ju-spacing-lg);
                text-align: center;
            }

            .footer-links {
                justify-content: center;
            }

            .ju-card-body {
                padding: var(--ju-spacing-lg);
            }

            .stat-card {
                padding: var(--ju-spacing-lg);
            }

            .stat-number {
                font-size: 2.2rem;
            }

            .stat-icon {
                font-size: 2.5rem;
            }

            .header-search {
                max-width: 100%;
                order: 3;
                margin-top: var(--ju-spacing-md);
            }
        }

        @media (max-width: 576px) {
            .sidebar-menu {
                grid-template-columns: 1fr;
            }

            .ju-main-content {
                padding: var(--ju-spacing-lg);
            }

            .ju-card-header {
                padding: var(--ju-spacing-lg);
            }

            .stat-card {
                min-height: 140px;
                padding: var(--ju-spacing-md);
            }

            .stat-number {
                font-size: 2rem;
            }

            .stat-icon {
                font-size: 2.2rem;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .breadcrumb-nav {
                padding: var(--ju-spacing-sm);
            }
        }

        /* ============================================
           ENHANCED UTILITY CLASSES
        ============================================ */

        .text-ju-primary {
            color: var(--ju-primary);
        }

        .text-ju-secondary {
            color: var(--ju-secondary);
        }

        .text-ju-success {
            color: var(--ju-success);
        }

        .text-ju-danger {
            color: var(--ju-danger);
        }

        .text-ju-warning {
            color: var(--ju-warning);
        }

        .text-ju-info {
            color: var(--ju-info);
        }

        .bg-ju-primary {
            background: var(--ju-gradient-primary);
        }

        .bg-ju-light {
            background: var(--ju-gradient-light);
        }

        .bg-ju-dark {
            background: var(--ju-gradient-dark);
        }

        .border-ju-primary {
            border-color: var(--ju-primary);
        }

        .border-ju-light {
            border-color: var(--ju-gray-200);
        }

        .shadow-ju {
            box-shadow: var(--ju-shadow-lg);
        }

        .shadow-ju-lg {
            box-shadow: var(--ju-shadow-xl);
        }

        /* Loading Spinner - Enhanced */
        .ju-spinner {
            width: 3.5rem;
            height: 3.5rem;
            border: 4px solid rgba(0, 100, 0, 0.1);
            border-top-color: var(--ju-primary);
            border-radius: 50%;
            animation: ju-spin 1s linear infinite;
            position: relative;
        }

        .ju-spinner::after {
            content: '';
            position: absolute;
            top: -4px;
            left: -4px;
            right: -4px;
            bottom: -4px;
            border: 4px solid transparent;
            border-top-color: var(--ju-secondary);
            border-radius: 50%;
            animation: ju-spin 1.5s linear infinite reverse;
        }

        @keyframes ju-spin {
            to {
                transform: rotate(360deg);
            }
        }


        /* Add this to your style section */
        .ju-sidebar {
            animation: none !important;
            transition: none !important;
            opacity: 1 !important;
            transform: none !important;
            visibility: visible !important;
        }

        /* Disable AOS animations */
        [data-aos] {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        /* Skeleton Loading - Enhanced */
        .ju-skeleton {
            background: linear-gradient(90deg,
                    rgba(0, 100, 0, 0.1) 25%,
                    rgba(0, 100, 0, 0.2) 50%,
                    rgba(0, 100, 0, 0.1) 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s ease-in-out infinite;
            border-radius: var(--ju-radius-md);
        }

        @keyframes skeleton-loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Glass Morphism Utility */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Gradient Text */
        .gradient-text {
            background: var(--ju-gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Floating Animation */
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Pulse Animation */
        .pulse-animation {
            animation: pulse 2s infinite;
        }

        /* Shine Effect */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .shine-effect:hover::before {
            left: 100%;
        }

        /* Card Hover Effects */
        .card-hover-3d {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover-3d:hover {
            transform: perspective(1000px) rotateX(5deg) rotateY(5deg) scale(1.02);
            box-shadow: var(--ju-shadow-2xl);
        }

        /* Badge Styles */
        .ju-badge {
            padding: 0.35rem 0.75rem;
            border-radius: var(--ju-radius-full);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ju-badge-primary {
            background: var(--ju-gradient-primary);
            color: white;
        }

        .ju-badge-success {
            background: var(--ju-gradient-success);
            color: white;
        }

        .ju-badge-warning {
            background: var(--ju-gradient-warning);
            color: white;
        }

        .ju-badge-danger {
            background: var(--ju-gradient-danger);
            color: white;
        }

        /* Avatar Styles */
        .ju-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 1rem;
            background: var(--ju-gradient-primary);
        }

        .ju-avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 0.85rem;
        }

        .ju-avatar-lg {
            width: 56px;
            height: 56px;
            font-size: 1.25rem;
        }

        .ju-avatar-xl {
            width: 80px;
            height: 80px;
            font-size: 1.5rem;
        }

        /* Timeline */
        .ju-timeline {
            position: relative;
            padding-left: 30px;
        }

        .ju-timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--ju-primary);
        }

        .ju-timeline-item {
            position: relative;
            margin-bottom: var(--ju-spacing-xl);
        }

        .ju-timeline-item::before {
            content: '';
            position: absolute;
            left: -20px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--ju-primary);
            border: 2px solid white;
            box-shadow: 0 0 0 3px var(--ju-primary-light);
        }

        /* Progress Bar */
        .ju-progress {
            height: 8px;
            background: rgba(0, 100, 0, 0.1);
            border-radius: var(--ju-radius-full);
            overflow: hidden;
        }

        .ju-progress-bar {
            height: 100%;
            background: var(--ju-gradient-primary);
            border-radius: var(--ju-radius-full);
            transition: width 0.6s ease;
        }

        /* Tooltip */
        .ju-tooltip {
            position: relative;
            display: inline-block;
        }

        .ju-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: var(--ju-spacing-sm) var(--ju-spacing-md);
            background: var(--ju-gray-800);
            color: white;
            font-size: 0.85rem;
            border-radius: var(--ju-radius-md);
            white-space: nowrap;
            z-index: var(--ju-z-tooltip);
            margin-bottom: 5px;
            box-shadow: var(--ju-shadow-md);
        }

        .ju-tooltip:hover::before {
            content: '';
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: var(--ju-gray-800);
            margin-bottom: -5px;
            z-index: var(--ju-z-tooltip);
        }

        /* Modal Fixes */
        .modal-backdrop {
            z-index: var(--ju-z-modal-backdrop);
        }

        .modal {
            z-index: var(--ju-z-modal);
        }

        /* Fix for form buttons inside modals */
        .modal-footer .btn {
            margin: 0;
        }

        /* Fix for modal form submission */
        .modal form {
            margin: 0;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Premium Glassmorphism Header -->
    <header class="ju-header" id="mainHeader">
        <div class="header-container">
            <a href="{{ route('home') }}" class="ju-brand">
                <div class="ju-logo">
                    <i class="fas fa-university"></i>
                </div>
                <div class="ju-title-container">
                    <h1 class="ju-main-title">Jimma University</h1>
                    <p class="ju-subtitle">Event Management System</p>
                </div>
            </a>

            <!-- Search Bar -->
            <div class="header-search d-none d-lg-block">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search events, announcements, or users..." id="globalSearch">
            </div>

            <div class="user-menu-container">
                @auth
                <!-- Premium User Profile -->
                <div class="user-profile" onclick="toggleUserMenu()">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">
                            @if(auth()->user()->role)
                            {{ auth()->user()->role->name }}
                            @else
                            User
                            @endif
                        </div>
                    </div>
                    <i class="fas fa-chevron-down ms-2" style="font-size: 0.8rem;"></i>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="d-inline" id="logoutForm">
                    @csrf
                    <button type="submit" class="btn logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
                @else
                <!-- Guest Navigation -->
                <div class="guest-nav">
                    <a href="{{ route('login') }}" class="btn btn-ju">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-ju-outline">Register</a>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Floating Toast Container -->
    <div class="toast-container">
        @if(session('success'))
        <div class="ju-toast ju-toast-success animate__animated animate__fadeInRight" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="fw-bold mb-1">Success!</div>
                    <div class="toast-message">{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="ju-toast ju-toast-error animate__animated animate__fadeInRight" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="fw-bold mb-1">Error!</div>
                    <div class="toast-message">{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if(session('warning'))
        <div class="ju-toast ju-toast-warning animate__animated animate__fadeInRight" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="fw-bold mb-1">Warning!</div>
                    <div class="toast-message">{{ session('warning') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif

        @if(session('info'))
        <div class="ju-toast ju-toast-info animate__animated animate__fadeInRight" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle fa-2x"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="fw-bold mb-1">Info!</div>
                    <div class="toast-message">{{ session('info') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>

    <!-- Main Layout -->
    <div class="main-layout">
        @auth
        <!-- Premium Glass Sidebar -->
        <nav class="ju-sidebar">

            <ul class="sidebar-menu">
                <!-- DASHBOARD -->
                @if(auth()->user()->hasPermission('view_dashboard'))
                <li class="menu-header">Dashboard</li>
                <li class="menu-item">
                    <a href="{{ route('dashboard') }}" class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-tachometer-alt"></i>
                        <span class="menu-title">Admin Dashboard</span>
                    </a>
                </li>
                @endif

                <!-- EVENT MANAGEMENT -->
                <li class="menu-header">Event Management</li>

                <li class="menu-item">
                    <a href="{{ route('home') }}" class="menu-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-calendar-alt"></i>
                        <span class="menu-title">Browse Events</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('my-events.index') }}" class="menu-link {{ request()->routeIs('my-events.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-calendar-check"></i>
                        <span class="menu-title">My Registrations</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('event-registration.index') }}" class="menu-link {{ request()->routeIs('event-registration.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-user-plus"></i>
                        <span class="menu-title">Event Registration</span>
                    </a>
                </li>


                <!-- Feedback -->
                <li class="menu-item">
                    <a href="{{ route('feedback.create') }}"
                        class="menu-link {{ request()->routeIs('feedback.create') || request()->routeIs('feedback.store') || request()->routeIs('feedback.thankyou') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-comment-dots"></i>
                        <span class="menu-title">Submit Feedback</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('feedback.testimonials') }}"
                        class="menu-link {{ request()->routeIs('feedback.testimonials') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-star"></i>
                        <span class="menu-title">View Testimonials</span>
                    </a>
                </li>

                <!-- Event Requests -->
                <li class="menu-item">
                    <a href="{{ route('event-requests.create') }}"
                        class="menu-link {{ request()->routeIs('event-requests.create') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-plus-circle"></i>
                        <span class="menu-title">Create Request</span>
                    </a>
                </li>


                <!-- Announcements -->
                <li class="menu-item">
                    <a href="{{ route('announcements.index') }}"
                        class="menu-link {{ request()->routeIs('announcements.*') && !request()->routeIs('announcements.create') && !request()->routeIs('announcements.edit') && !request()->routeIs('announcements.statistics') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-bullhorn"></i>
                        <span class="menu-title">Announcements</span>
                    </a>
                </li>

                <!-- Create Announcement (for all authenticated users) -->
                <!-- @auth
<li class="menu-item">
    <a href="{{ route('announcements.create') }}" 
       class="menu-link {{ request()->routeIs('announcements.create') ? 'active' : '' }}">
        <i class="menu-icon fas fa-plus-square"></i>
        <span class="menu-title">Create Announcement</span>
    </a>
</li>
@endauth -->


                <!-- ADMINISTRATION -->
                @if(auth()->user()->hasAnyPermission(['manage_events', 'manage_venues', 'manage_users']))
                <li class="menu-header">Administration</li>

                <!-- Venue Management -->
                @if(auth()->user()->hasPermission('manage_venues'))
                <li class="menu-item">
                    <a class="menu-link menu-collapse" data-bs-toggle="collapse" href="#venueManagement" role="button">
                        <i class="menu-icon fas fa-map-marked-alt"></i>
                        <span class="menu-title">Venue Management</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse" id="venueManagement">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.campuses.*') ? 'active' : '' }}" href="{{ route('admin.campuses.index') }}">
                                    <i class="fas fa-university me-2"></i>
                                    <span>Campuses</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.buildings.*') ? 'active' : '' }}" href="{{ route('admin.buildings.index') }}">
                                    <i class="fas fa-building me-2"></i>
                                    <span>Buildings</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.venues.*') ? 'active' : '' }}" href="{{ route('admin.venues.index') }}">
                                    <i class="fas fa-door-closed me-2"></i>
                                    <span>Venues & Halls</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                <!-- Event Administration -->
                @if(auth()->user()->hasPermission('manage_events'))
                <li class="menu-item">
                    <a class="menu-link menu-collapse" data-bs-toggle="collapse" href="#eventAdmin" role="button">
                        <i class="menu-icon fas fa-calendar-plus"></i>
                        <span class="menu-title">Event Administration</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse" id="eventAdmin">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
                                    <i class="fas fa-calendar me-2"></i>
                                    <span>All Events</span>
                                </a>
                            </li>

                            @if(auth()->user()->hasPermission('create_events'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.events.create') ? 'active' : '' }}" href="{{ route('admin.events.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    <span>Create Event</span>
                                </a>
                            </li>
                            @endif

                            @if(class_exists('App\Models\Speaker'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('speakers.*') ? 'active' : '' }}" href="{{ route('speakers.index') }}">
                                    <i class="fas fa-microphone-alt me-2"></i>
                                    <span>Speakers</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_event_requests'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('event-requests.*') ? 'active' : '' }}" href="{{ route('event-requests.index') }}">
                                    <i class="fas fa-clipboard-list me-2"></i>
                                    <span>Event Requests</span>
                                    @php
                                    $pendingRequests = 0;
                                    if (auth()->check() && auth()->user()->hasPermission('approve_event_requests')) {
                                    try {
                                    if (class_exists('App\Models\EventRequest')) {
                                    $pendingRequests = \App\Models\EventRequest::where('status', 'pending')->count();
                                    }
                                    } catch (\Exception $e) {
                                    $pendingRequests = 0;
                                    }
                                    }
                                    @endphp
                                    @if($pendingRequests > 0)
                                    <span class="menu-badge">{{ $pendingRequests }}</span>
                                    @endif
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- User Administration -->
                @if(auth()->user()->hasAnyPermission(['view_users', 'create_users', 'view_roles', 'view_permissions']))
                <li class="menu-item">
                    <a class="menu-link menu-collapse" data-bs-toggle="collapse" href="#userAdmin" role="button">
                        <i class="menu-icon fas fa-users-cog"></i>
                        <span class="menu-title">User Administration</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse" id="userAdmin">
                        <ul class="nav flex-column sub-menu">
                            @if(auth()->user()->hasPermission('view_users'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <i class="fas fa-users me-2"></i>
                                    <span>All Users</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('create_users'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.create') ? 'active' : '' }}" href="{{ route('users.create') }}">
                                    <i class="fas fa-user-plus me-2"></i>
                                    <span>Add User</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_roles'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                    <i class="fas fa-user-tag me-2"></i>
                                    <span>Roles</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_permissions'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('permissions.*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                                    <i class="fas fa-key me-2"></i>
                                    <span>Permissions</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif
                @endif

                <!-- FEEDBACK & NOTIFICATIONS ADMIN -->
                @if(auth()->user()->hasAnyPermission(['manage_notifications', 'manage_feedback']))
                <li class="menu-header">Feedback & Notifications</li>

                 <!-- Notifications -->
                @if(auth()->user()->hasPermission('view_notifications'))
                <li class="menu-item">
                    <a class="menu-link menu-collapse" data-bs-toggle="collapse" href="#notificationMenu" role="button">
                        <i class="menu-icon fas fa-bell"></i>
                        <span class="menu-title">Notifications</span>
                        @php
                        $unreadCount = 0;
                        if (class_exists('App\Models\UserNotification')) {
                        $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                        ->where('read', false)
                        ->count();
                        }
                        @endphp
                        @if($unreadCount > 0)
                        <span class="menu-badge notification-badge">{{ $unreadCount }}</span>
                        @endif
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse" id="notificationMenu">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}"
                                    href="{{ route('notifications.index') }}">
                                    <i class="fas fa-inbox me-2"></i>
                                    <span>My Notifications</span>
                                    @if($unreadCount > 0)
                                    <span class="badge bg-danger rounded-pill float-end">{{ $unreadCount }}</span>
                                    @endif
                                </a>
                            </li>

                            @if(auth()->user()->can('send_notifications'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('notifications.send-custom') ? 'active' : '' }}"
                                    href="{{ route('notifications.send-custom') }}">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    <span>Send Notification</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->can('manage_notifications'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('notifications.statistics') ? 'active' : '' }}"
                                    href="{{ route('notifications.statistics') }}">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    <span>Statistics</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                @if(auth()->user()->hasPermission('manage_feedback'))
                <li class="menu-item">
                    <a class="menu-link menu-collapse" data-bs-toggle="collapse" href="#feedbackAdmin" role="button">
                        <i class="menu-icon fas fa-comments"></i>
                        <span class="menu-title">Feedback Management</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse" id="feedbackAdmin">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('feedback.index') ? 'active' : '' }}"
                                    href="{{ route('feedback.index') }}">
                                    <i class="fas fa-list me-2"></i>
                                    <span>All Feedback</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('feedback.analytics') ? 'active' : '' }}"
                                    href="{{ route('feedback.analytics') }}">
                                    <i class="fas fa-chart-pie me-2"></i>
                                    <span>Analytics</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @endif

                <!-- Announcement Administration --><!-- Announcement Administration -->
                @if(auth()->user()->hasAnyPermission(['manage_announcements', 'create_announcements', 'view_announcement_stats']))
                <li class="menu-item">
                    <a class="menu-link menu-collapse" data-bs-toggle="collapse" href="#announcementAdmin" role="button">
                        <i class="menu-icon fas fa-bullhorn"></i>
                        <span class="menu-title">Announcement Admin</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse" id="announcementAdmin">
                        <ul class="nav flex-column sub-menu">
                            <!-- View All Announcements -->
                            @if(auth()->user()->hasPermission('view_announcements'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('announcements.index') && !request()->routeIs('announcements.create') && !request()->routeIs('announcements.edit') && !request()->routeIs('announcements.statistics') ? 'active' : '' }}"
                                    href="{{ route('announcements.index') }}">
                                    <i class="fas fa-list me-2"></i>
                                    <span>All Announcements</span>
                                </a>
                            </li>
                            @endif

                            <!-- Create Announcement -->
                            <!-- FIXED: Allow all authenticated users to create announcements -->
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('announcements.create') ? 'active' : '' }}"
                                    href="{{ route('announcements.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    <span>Create New</span>
                                </a>
                            </li>

                            <!-- Announcement Statistics -->
                            @if(auth()->user()->hasPermission('view_announcement_stats'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('announcements.statistics') ? 'active' : '' }}"
                                    href="{{ route('announcements.statistics') }}">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    <span>Statistics</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- SYSTEM -->
                <li class="menu-header">System</li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="menu-icon fas fa-cog"></i>
                        <span class="menu-title">System Settings</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="menu-icon fas fa-question-circle"></i>
                        <span class="menu-title">Help Center</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link">
                        <i class="menu-icon fas fa-book"></i>
                        <span class="menu-title">Documentation</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endauth

        <!-- Main Content Area -->
        <main class="ju-main-content" data-aos="fade-up" data-aos-duration="800">
            <!-- Content Header -->
            <div class="content-header">
                <div class="page-title-container">
                    <h1 class="page-title">@yield('page-title', 'Jimma University Events')</h1>
                    <p class="page-subtitle">@yield('page-subtitle', 'Professional Event Management Platform')</p>
                </div>

                @auth
                <!-- Premium Breadcrumb -->
                <nav class="breadcrumb-nav">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                        @yield('breadcrumb-items')
                    </ol>
                </nav>
                @endauth
            </div>

            <!-- Main Content -->
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Premium Glass Footer -->
    <footer class="ju-footer" data-aos="fade-up" data-aos-duration="800">
        <div class="footer-container">
            <div class="footer-copyright">
                <i class="fas fa-copyright"></i> {{ date('Y') }} Jimma University. All Rights Reserved.
                <span class="ms-2">v2.0.0</span>
            </div>
            <div class="footer-links">
                <a href="#" class="footer-link"><i class="fas fa-info-circle"></i> About</a>
                <a href="#" class="footer-link"><i class="fas fa-envelope"></i> Contact</a>
                <a href="#" class="footer-link"><i class="fas fa-shield-alt"></i> Privacy</a>
                <a href="#" class="footer-link"><i class="fas fa-file-contract"></i> Terms</a>
                <a href="#" class="footer-link"><i class="fas fa-question-circle"></i> Support</a>
            </div>
        </div>
    </footer>

    <!-- Approve/Reject Modal (Added Here) -->
    <div class="modal fade" id="approveRejectModal" tabindex="-1" aria-labelledby="approveRejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ju-card">
                <form id="approveRejectForm" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header ju-card-header">
                        <h5 class="modal-title" id="approveRejectModalLabel">
                            <i class="fas fa-check-circle me-2"></i>
                            <span id="modalActionText">Approve Request</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body ju-card-body">
                        <div class="mb-3">
                            <label for="requestTitle" class="form-label fw-bold">Event Request:</label>
                            <div id="requestTitle" class="p-3 bg-light rounded">
                                <strong id="modalEventTitle">Loading...</strong>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reviewNotes" class="form-label">
                                <i class="fas fa-edit me-1"></i>Review Notes (Optional)
                            </label>
                            <textarea
                                class="form-control ju-input"
                                id="reviewNotes"
                                name="review_notes"
                                rows="4"
                                placeholder="Add any comments or notes about this decision..."></textarea>
                        </div>

                        <!-- Hidden fields -->
                        <input type="hidden" id="modalRequestId" name="request_id">
                        <input type="hidden" id="modalAction" name="action" value="approve">
                    </div>

                    <div class="modal-footer ju-card-footer">
                        <button type="button" class="btn btn-ju-outline" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-ju" id="modalSubmitBtn">
                            <i class="fas fa-check me-1"></i>
                            <span id="submitBtnText">Approve Request</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <!-- jQuery must come first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <!-- Premium Custom Scripts -->
    <script>
        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.addEventListener('DOMContentLoaded', function() {

            setTimeout(function() {
                const sidebar = document.querySelector('.ju-sidebar');
                if (sidebar) {
                    sidebar.style.opacity = '1';
                    sidebar.style.visibility = 'visible';
                    sidebar.style.transform = 'translateX(0)';

                    // Remove AOS attributes
                    sidebar.removeAttribute('data-aos');
                    sidebar.removeAttribute('data-aos-duration');
                    sidebar.removeAttribute('data-aos-delay');
                }
            }, 100); // 100ms delay

            // Initialize AOS
            AOS.init({
                duration: 800,
                once: true,
                offset: 100
            });

            // Initialize Bootstrap components
            initBootstrapComponents();

            // Auto-dismiss toasts after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.ju-toast').forEach(toast => {
                    const bsToast = bootstrap.Toast.getOrCreateInstance(toast);
                    bsToast.hide();
                });
            }, 5000);

            // Add active state to current menu item
            highlightCurrentMenuItem();

            // Fix text visibility on cards
            fixTextVisibility();

            // Header scroll effect
            window.addEventListener('scroll', handleHeaderScroll);

            // Global search functionality
            initGlobalSearch();

            // Initialize tooltips
            initTooltips();

            // Initialize DataTables
            initDataTables();

            // Initialize Select2
            initSelect2();

            // Initialize FullCalendar
            initFullCalendar();

            // Initialize Approve/Reject Modal
            initApproveRejectModal();
        });

        function initBootstrapComponents() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });

            // Initialize collapse components
            var collapseElementList = [].slice.call(document.querySelectorAll('.collapse'));
            var collapseList = collapseElementList.map(function(collapseEl) {
                return new bootstrap.Collapse(collapseEl, {
                    toggle: false
                });
            });

            // Initialize modals that are already in the DOM
            var modalElements = document.querySelectorAll('.modal');
            modalElements.forEach(function(modalEl) {
                // Bootstrap automatically initializes modals when shown
                console.log('Modal element available:', modalEl.id || 'unnamed');
            });

            // Initialize toast notifications
            var toastElList = [].slice.call(document.querySelectorAll('.ju-toast'));
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000
                });
            });

            // Show all toasts
            toastList.forEach(toast => toast.show());
        }

        // ============================================
        // APPROVE/REJECT MODAL FUNCTIONALITY - FIXED
        // ============================================

        let approveRejectModal = null;

        function initApproveRejectModal() {
            const modalElement = document.getElementById('approveRejectModal');
            if (modalElement) {
                approveRejectModal = new bootstrap.Modal(modalElement);

                // Initialize form submission
                const form = document.getElementById('approveRejectForm');
                if (form) {
                    form.addEventListener('submit', handleApproveRejectSubmit);
                }

                console.log('Approve/Reject modal initialized');
            }
        }

        // Function to open modal for approval
        function openApproveModal(requestId, eventTitle) {
            document.getElementById('modalActionText').textContent = 'Approve Request';
            document.getElementById('submitBtnText').textContent = 'Approve Request';
            document.getElementById('modalAction').value = 'approve';
            document.getElementById('modalSubmitBtn').className = 'btn btn-ju-success';
            document.getElementById('modalEventTitle').textContent = eventTitle;
            document.getElementById('modalRequestId').value = requestId;
            document.getElementById('reviewNotes').value = '';

            // Set form action
            const form = document.getElementById('approveRejectForm');
            form.action = `/event-requests/${requestId}/approve`;

            // Show modal
            if (approveRejectModal) {
                approveRejectModal.show();
            }
        }

        // Function to open modal for rejection
        function openRejectModal(requestId, eventTitle) {
            document.getElementById('modalActionText').textContent = 'Reject Request';
            document.getElementById('submitBtnText').textContent = 'Reject Request';
            document.getElementById('modalAction').value = 'reject';
            document.getElementById('modalSubmitBtn').className = 'btn btn-ju-danger';
            document.getElementById('modalEventTitle').textContent = eventTitle;
            document.getElementById('modalRequestId').value = requestId;
            document.getElementById('reviewNotes').value = '';

            // Set form action
            const form = document.getElementById('approveRejectForm');
            form.action = `/event-requests/${requestId}/reject`;

            // Show modal
            if (approveRejectModal) {
                approveRejectModal.show();
            }
        }

        // Function to open modal for cancellation
        function openCancelModal(requestId, eventTitle) {
            document.getElementById('modalActionText').textContent = 'Cancel Request';
            document.getElementById('submitBtnText').textContent = 'Cancel Request';
            document.getElementById('modalAction').value = 'cancel';
            document.getElementById('modalSubmitBtn').className = 'btn btn-ju-warning';
            document.getElementById('modalEventTitle').textContent = eventTitle;
            document.getElementById('modalRequestId').value = requestId;
            document.getElementById('reviewNotes').value = '';

            // Set form action
            const form = document.getElementById('approveRejectForm');
            form.action = `/event-requests/${requestId}/cancel`;

            // Show modal
            if (approveRejectModal) {
                approveRejectModal.show();
            }
        }

        // Handle form submission with AJAX
        async function handleApproveRejectSubmit(event) {
            event.preventDefault();

            const form = event.target;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('modalSubmitBtn');
            const originalBtnText = submitBtn.innerHTML;

            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Processing...';

            try {
                const response = await fetch(form.action, {
                    method: 'PUT',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    // Show success message
                    showToast(result.message || 'Request processed successfully!', 'success');

                    // Close modal
                    if (approveRejectModal) {
                        approveRejectModal.hide();
                    }

                    // Reload page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);

                } else {
                    throw new Error(result.message || 'An error occurred');
                }

            } catch (error) {
                // Show error message
                showToast(error.message || 'Failed to process request. Please try again.', 'error');

                // Restore button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }

        // Function to approve/reject request directly (without modal)
        function quickAction(requestId, action) {
            showConfirm(
                `Are you sure you want to ${action} this request?`,
                async function() {
                    try {
                        const response = await fetch(`/event-requests/${requestId}/${action}`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });

                        const result = await response.json();

                        if (response.ok) {
                            showToast(result.message || `Request ${action}d successfully!`, 'success');
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            throw new Error(result.message || `Failed to ${action} request`);
                        }
                    } catch (error) {
                        showToast(error.message, 'error');
                    }
                }
            );
        }

        // Add click handlers for approve/reject buttons
        document.addEventListener('click', function(e) {
            // Check if it's an approve button
            if (e.target.closest('[data-action="approve"]')) {
                const btn = e.target.closest('[data-action="approve"]');
                const requestId = btn.dataset.requestId;
                const eventTitle = btn.dataset.eventTitle;
                openApproveModal(requestId, eventTitle);
                e.preventDefault();
            }

            // Check if it's a reject button
            if (e.target.closest('[data-action="reject"]')) {
                const btn = e.target.closest('[data-action="reject"]');
                const requestId = btn.dataset.requestId;
                const eventTitle = btn.dataset.eventTitle;
                openRejectModal(requestId, eventTitle);
                e.preventDefault();
            }

            // Check if it's a cancel button
            if (e.target.closest('[data-action="cancel"]')) {
                const btn = e.target.closest('[data-action="cancel"]');
                const requestId = btn.dataset.requestId;
                const eventTitle = btn.dataset.eventTitle;
                openCancelModal(requestId, eventTitle);
                e.preventDefault();
            }
        });

        // ============================================
        // END OF APPROVE/REJECT MODAL FUNCTIONALITY
        // ============================================

        function initDataTables() {
            if ($.fn.DataTable) {
                $('.data-table').DataTable({
                    "pageLength": 25,
                    "responsive": true,
                    "language": {
                        "search": "<i class='fas fa-search me-2'></i>Search:",
                        "lengthMenu": "<i class='fas fa-list me-2'></i>Show _MENU_ entries",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "infoEmpty": "No entries available",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "first": "<i class='fas fa-angle-double-left'></i>",
                            "last": "<i class='fas fa-angle-double-right'></i>",
                            "next": "<i class='fas fa-angle-right'></i>",
                            "previous": "<i class='fas fa-angle-left'></i>"
                        },
                        "loadingRecords": "<div class='ju-spinner mx-auto'></div>",
                        "processing": "<div class='ju-spinner'></div> Processing..."
                    },
                    "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end"f>>' +
                        '<"row"<"col-sm-12"tr>>' +
                        '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
                });
            }
        }

        function initSelect2() {
            if ($.fn.select2) {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: 'Select an option',
                    allowClear: true,
                    dropdownParent: $('body')
                });
            }
        }

        function initFullCalendar() {
            if (typeof FullCalendar !== 'undefined') {
                const calendarEl = document.getElementById('calendar');
                if (calendarEl) {
                    const calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        events: '/api/events',
                        eventClick: function(info) {
                            window.location.href = '/events/' + info.event.id;
                        }
                    });
                    calendar.render();
                }
            }
        }

        function createRippleEffect(element, event) {
            const rect = element.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;

            const ripple = document.createElement('span');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(255, 255, 255, 0.6)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s linear';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';

            element.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        }

        function highlightCurrentMenuItem() {
            const currentPath = window.location.pathname;
            let activeFound = false;

            document.querySelectorAll('.menu-link').forEach(link => {
                if (link.href) {
                    const linkPath = new URL(link.href).pathname;
                    const isActive = currentPath === linkPath ||
                        (currentPath.startsWith(linkPath) && linkPath !== '/');

                    if (isActive) {
                        link.classList.add('active');
                        activeFound = true;

                        // Expand parent collapse if in sub-menu
                        const collapse = link.closest('.collapse');
                        if (collapse) {
                            const collapseBtn = document.querySelector('[href="#' + collapse.id + '"]');
                            if (collapseBtn) {
                                const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapse);
                                bsCollapse.show();
                            }
                        }
                    } else {
                        link.classList.remove('active');
                    }
                }
            });

            // If no active found, check for dashboard
            if (!activeFound && currentPath === '/dashboard') {
                // Check if route exists before using it
                const dashboardLink = document.querySelector('a[href*="dashboard"]');
                if (dashboardLink) {
                    dashboardLink.classList.add('active');
                }
            }

            function fixTextVisibility() {
                // Ensure all text elements are visible
                document.querySelectorAll('.ju-card, .menu-link, .nav-link, .page-title, .page-subtitle, .ju-card-title, .ju-card-body p, .breadcrumb-item').forEach(el => {
                    el.style.overflow = 'visible';
                    el.style.textOverflow = 'clip';
                    el.style.whiteSpace = 'normal';
                });
            }

            function handleHeaderScroll() {
                const header = document.getElementById('mainHeader');
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            }

            function initGlobalSearch() {
                const searchInput = document.getElementById('globalSearch');
                if (searchInput) {
                    searchInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            const query = this.value.trim();
                            if (query) {
                                // Implement global search functionality
                                window.location.href = '/search?q=' + encodeURIComponent(query);
                            }
                        }
                    });
                }
            }

            function initTooltips() {
                // Already initialized in initBootstrapComponents
            }

            function toggleUserMenu() {
                // Implement user dropdown menu
                console.log('User menu clicked');
            }

            // Utility functions for modals
            window.showModal = function(modalId) {
                const modalElement = document.getElementById(modalId);
                if (modalElement) {
                    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
                    modal.show();
                }
            };

            window.hideModal = function(modalId) {
                const modalElement = document.getElementById(modalId);
                if (modalElement) {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                }
            };

            window.showToast = function(message, type = 'success') {
                const toastContainer = document.querySelector('.toast-container');
                const toast = document.createElement('div');
                toast.className = `ju-toast ju-toast-${type} animate__animated animate__fadeInRight`;
                toast.setAttribute('role', 'alert');

                const icon = type === 'success' ? 'fa-check-circle' :
                    type === 'error' ? 'fa-exclamation-circle' :
                    type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';

                toast.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="fas ${icon} fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <div class="fw-bold mb-1">${type.charAt(0).toUpperCase() + type.slice(1)}!</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" onclick="this.closest('.ju-toast').remove()"></button>
                </div>
            `;

                toastContainer.appendChild(toast);

                // Initialize and show the toast
                const bsToast = new bootstrap.Toast(toast, {
                    autohide: true,
                    delay: 5000
                });
                bsToast.show();

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 5000);
            };

            window.showConfirm = function(message, callback) {
                const modalId = 'confirmModal' + Date.now();
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.id = modalId;
                modal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content ju-card">
                        <div class="modal-header ju-card-header">
                            <h5 class="modal-title">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body ju-card-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer ju-card-footer">
                            <button type="button" class="btn btn-ju-outline" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-ju" id="confirmBtn">Confirm</button>
                        </div>
                    </div>
                </div>
            `;

                document.body.appendChild(modal);
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();

                document.getElementById('confirmBtn').onclick = function() {
                    callback();
                    modalInstance.hide();
                };

                modal.addEventListener('hidden.bs.modal', function() {
                    modal.remove();
                });
            };

            // Add ripple effect to buttons on click
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-ju') || e.target.classList.contains('btn-ju-outline')) {
                    createRippleEffect(e.target, e);
                }
            });

            // Add CSS for ripple effect
            const style = document.createElement('style');
            style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            /* Ensure text stays visible on hover */
            .ju-card:hover .ju-card-body * {
                color: inherit !important;
                opacity: 1 !important;
            }
            
            /* Floating animation for elements with class float-animation */
            .float-animation {
                animation: float 3s ease-in-out infinite;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
            
            /* Pulse animation for notifications */
            .pulse-animation {
                animation: pulse 2s infinite;
            }
            
            @keyframes pulse {
                0%, 100% { 
                    transform: scale(1); 
                    box-shadow: var(--ju-shadow-sm);
                }
                50% { 
                    transform: scale(1.05); 
                    box-shadow: 0 0 20px currentColor;
                }
            }
            
            /* Shine effect for buttons and cards */
            .shine-effect:hover::before {
                left: 100%;
                transition: left 0.5s;
            }
            
            /* 3D card hover effect */
            .card-hover-3d {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            
            .card-hover-3d:hover {
                transform: perspective(1000px) rotateX(5deg) rotateY(5deg) scale(1.02);
                box-shadow: var(--ju-shadow-2xl);
            }
            
            /* Fix modal backdrop */
            .modal-backdrop.show {
                opacity: 0.5;
            }
            
            /* Fix for form buttons */
            form .btn {
                cursor: pointer;
            }
        `;
            document.head.appendChild(style);
    </script>

    @stack('scripts')
</body>

</html>