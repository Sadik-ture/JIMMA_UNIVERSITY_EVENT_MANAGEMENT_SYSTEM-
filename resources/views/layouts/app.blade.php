<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Jimma University | Event Management System')</title>

    <!-- Meta Tags -->
    <meta name="description" content="Jimma University Event Management System - Professional platform for managing university events, registrations, and venue bookings.">
    <meta name="author" content="Jimma University">
    <meta name="keywords" content="Jimma University, Events, Management System, Ethiopia, Higher Education">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts - Montserrat & Open Sans (JU Official Fonts) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- OFFICIAL JIMMA UNIVERSITY DESIGN SYSTEM -->
    <style>
        /* ============================================
           OFFICIAL JIMMA UNIVERSITY DESIGN SYSTEM
           Colors extracted from https://ju.edu.et
        ============================================ */

        :root {
            /* OFFICIAL JIMMA UNIVERSITY PRIMARY COLORS */
            --ju-blue: #0a2c6e;        /* Official JU Dark Blue - Header background */
            --ju-blue-dark: #06204d;    /* Darker JU Blue - For hover states */
            --ju-blue-light: #1e3a8a;   /* Lighter JU Blue - For accents */
            --ju-blue-soft: #e6edf7;    /* Soft JU Blue - For backgrounds */
            
            /* OFFICIAL JIMMA UNIVERSITY SECONDARY COLORS */
            --ju-green: #006838;        /* Official JU Green - From website */
            --ju-green-dark: #004d2b;   /* Darker JU Green */
            --ju-green-light: #1a8c4a;  /* Lighter JU Green */
            --ju-green-soft: #e8f3e9;   /* Soft JU Green - For backgrounds */
            
            /* Neutral Colors */
            --ju-white: #ffffff;        /* Pure White */
            --ju-offwhite: #f9f9f9;     /* Off White */
            --ju-gray: #f0f0f0;         /* Light Gray */
            --ju-gray-dark: #333333;    /* Dark Gray - For text */
            --ju-black: #1a1a1a;        /* Nearly Black */
            
            /* ACCENT COLORS */
            --ju-gold: #c4a747;         /* Gold accent */
            --ju-gold-light: #e5d6a6;   /* Light Gold */
            --ju-gold-dark: #b8960f;    /* Dark Gold */
            --ju-red: #dc3545;          /* Red for errors */
            
            /* SEMANTIC COLORS */
            --success: #28a745;
            --success-light: #d4edda;
            --info: var(--ju-blue);
            --info-light: var(--ju-blue-soft);
            --warning: #ffc107;
            --warning-light: #fff3cd;
            --danger: #dc3545;
            --danger-light: #f8d7da;
            
            /* Professional Gradients - JU Official */
            --gradient-primary: linear-gradient(145deg, var(--ju-blue) 0%, var(--ju-blue-dark) 100%);
            --gradient-primary-light: linear-gradient(145deg, var(--ju-blue-light) 0%, var(--ju-blue) 100%);
            --gradient-green: linear-gradient(145deg, var(--ju-green) 0%, var(--ju-green-dark) 100%);
            --gradient-gold: linear-gradient(145deg, var(--ju-gold) 0%, #b8960f 100%);
            --gradient-sidebar: linear-gradient(180deg, #0a2c6e 0%, #041a3a 100%);
            
            /* Background Gradients */
            --bg-gradient-light: linear-gradient(135deg, var(--ju-offwhite) 0%, #f5f5f5 50%, var(--ju-offwhite) 100%);
            --bg-gradient-blue: linear-gradient(135deg, #e6edf7 0%, #d4e1f0 50%, #e6edf7 100%);
            
            /* Enhanced Shadows - JU Style */
            --shadow-xs: 0 2px 4px rgba(10,44,110,0.02);
            --shadow-sm: 0 4px 6px rgba(10,44,110,0.04);
            --shadow: 0 6px 12px rgba(10,44,110,0.06);
            --shadow-md: 0 8px 24px rgba(10,44,110,0.08);
            --shadow-lg: 0 16px 32px rgba(10,44,110,0.1);
            --shadow-xl: 0 24px 48px rgba(10,44,110,0.12);
            --shadow-2xl: 0 32px 64px rgba(10,44,110,0.15);
            --shadow-sidebar: 8px 0 25px rgba(0,0,0,0.15);
            
            /* Typography - JU Official Fonts */
            --font-primary: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            --font-secondary: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            
            /* Spacing */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            --space-16: 4rem;
            
            /* Border Radius */
            --radius-sm: 0.25rem;
            --radius: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.25rem;
            --radius-full: 9999px;
            
            /* Transitions - Smooth AF */
            --transition-fast: 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            --transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-bounce: 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            --transition-elastic: 0.6s cubic-bezier(0.68, -0.6, 0.32, 1.6);
            
            /* Z-index layers */
            --z-header: 1000;
            --z-sidebar: 999;
            --z-modal: 1050;
            --z-dropdown: 1020;
            --z-toast: 1060;
        }

        /* ============================================
           BASE STYLES
        ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
            touch-action: manipulation;
            height: 100%;
        }

        body {
            font-family: var(--font-primary);
            font-weight: 400;
            line-height: 1.6;
            color: var(--ju-gray-dark);
            background: var(--ju-offwhite);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
            position: relative;
        }

        /* ============================================
           INHERITED HOVER ANIMATIONS SYSTEM
        ============================================ */

        /* Base Hover Class */
        .hover-effect {
            transition: all var(--transition);
            position: relative;
            overflow: hidden;
        }

        /* 1. Scale Up Animation */
        .hover-scale {
            transition: transform var(--transition-bounce), box-shadow var(--transition);
        }
        .hover-scale:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
            z-index: 10;
        }

        /* 2. Lift Up Animation */
        .hover-lift {
            transition: transform var(--transition-bounce), box-shadow var(--transition);
        }
        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-xl);
        }

        /* 3. Glow Animation */
        .hover-glow {
            transition: box-shadow var(--transition);
        }
        .hover-glow:hover {
            box-shadow: 0 0 0 4px rgba(255,255,255,0.2), 0 0 20px rgba(255,255,255,0.3);
        }

        /* 4. Border Animation */
        .hover-border {
            position: relative;
        }
        .hover-border::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--ju-white);
            transition: width var(--transition);
        }
        .hover-border:hover::after {
            width: 100%;
        }

        /* 5. Pulse Animation */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .hover-pulse:hover {
            animation: pulse 1.5s infinite;
        }

        /* 6. Shake Animation */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .hover-shake:hover {
            animation: shake 0.5s ease-in-out;
        }

        /* 7. Rotate Animation */
        .hover-rotate {
            transition: transform var(--transition-elastic);
        }
        .hover-rotate:hover {
            transform: rotate(8deg);
        }

        /* 8. Flip Animation */
        .hover-flip {
            transition: transform var(--transition-elastic);
        }
        .hover-flip:hover {
            transform: perspective(400px) rotateY(10deg);
        }

        /* 9. Shine Animation */
        .hover-shine {
            position: relative;
            overflow: hidden;
        }
        .hover-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }
        .hover-shine:hover::before {
            left: 100%;
        }

        /* 10. Bounce Animation */
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .hover-bounce:hover {
            animation: bounce 0.8s ease;
        }

        /* 11. Shadow Pulse */
        @keyframes shadowPulse {
            0% { box-shadow: 0 4px 10px rgba(10,44,110,0.1); }
            50% { box-shadow: 0 8px 25px rgba(10,44,110,0.3); }
            100% { box-shadow: 0 4px 10px rgba(10,44,110,0.1); }
        }
        .hover-shadow-pulse:hover {
            animation: shadowPulse 1.5s infinite;
        }

        /* 12. Slide Up */
        .hover-slide-up {
            transition: transform var(--transition-bounce);
        }
        .hover-slide-up:hover {
            transform: translateY(-8px);
        }

        /* 13. Grow Shadow */
        .hover-grow-shadow {
            transition: transform var(--transition), box-shadow var(--transition);
        }
        .hover-grow-shadow:hover {
            transform: scale(1.03);
            box-shadow: 0 20px 40px rgba(10,44,110,0.15);
        }

        /* 14. Icon Spin */
        .hover-icon-spin i {
            transition: transform var(--transition-bounce);
        }
        .hover-icon-spin:hover i {
            transform: rotate(360deg);
        }

        /* 15. Underline From Center */
        .hover-underline-center {
            position: relative;
        }
        .hover-underline-center::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--ju-white);
            transition: all var(--transition);
            transform: translateX(-50%);
        }
        .hover-underline-center:hover::after {
            width: 80%;
        }

        /* 16. Background Highlight */
        .hover-bg-highlight {
            transition: background-color var(--transition);
        }
        .hover-bg-highlight:hover {
            background-color: var(--ju-blue-soft);
        }

        /* 17. Border Color */
        .hover-border-color {
            transition: border-color var(--transition);
        }
        .hover-border-color:hover {
            border-color: var(--ju-blue);
        }

        /* 18. Text Color */
        .hover-text-color {
            transition: color var(--transition);
        }
        .hover-text-color:hover {
            color: var(--ju-blue);
        }

        /* 19. Zoom In */
        .hover-zoom {
            transition: transform var(--transition-elastic);
        }
        .hover-zoom:hover {
            transform: scale(1.1);
        }

        /* 20. Fade In */
        .hover-fade {
            transition: opacity var(--transition);
            opacity: 0.9;
        }
        .hover-fade:hover {
            opacity: 1;
        }

        /* ============================================
           OFFICIAL JIMMA UNIVERSITY HEADER - COMPLETE BLUE BACKGROUND
        ============================================ */
        .ju-header {
            background: var(--ju-blue);
            border-bottom: 3px solid var(--ju-gold);
            box-shadow: var(--shadow-lg);
            position: sticky;
            top: 0;
            z-index: var(--z-header);
            height: 80px;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 var(--space-6);
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--space-6);
        }

        /* Enhanced Brand - JU Official with White Text on Blue */
        .ju-brand {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            text-decoration: none;
            padding: var(--space-2);
            border-radius: var(--radius);
            min-height: 48px;
        }
        .ju-brand.hover-scale:hover {
            transform: scale(1.02);
        }

        .ju-logo {
            width: 50px;
            height: 50px;
            background: var(--ju-white);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ju-blue);
            font-size: 1.6rem;
            font-weight: 800;
            box-shadow: var(--shadow);
            transition: all var(--transition-bounce);
        }
        .ju-brand:hover .ju-logo {
            transform: rotate(-5deg) scale(1.1);
            box-shadow: var(--shadow-xl);
        }

        .ju-title-container {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .ju-main-title {
            font-family: var(--font-secondary);
            font-size: 1.4rem;
            font-weight: 800;
            margin: 0;
            color: var(--ju-white);
            letter-spacing: -0.5px;
        }

        .ju-subtitle {
            font-size: 0.7rem;
            color: var(--ju-white);
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 0;
            opacity: 0.9;
        }

        /* Enhanced Search - On Blue Background */
        .header-search {
            flex: 1;
            max-width: 500px;
            position: relative;
        }

        .header-search input {
            width: 100%;
            padding: var(--space-3) var(--space-4) var(--space-3) var(--space-12);
            border: none;
            border-radius: 40px;
            font-size: 0.9rem;
            color: var(--ju-gray-dark);
            background: var(--ju-white);
            transition: all var(--transition);
            box-shadow: var(--shadow-md);
            min-height: 48px;
        }
        .header-search input:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(255,255,255,0.3);
            transform: translateY(-1px);
        }
        .header-search input.hover-glow:hover {
            box-shadow: 0 0 0 4px rgba(255,255,255,0.2);
        }

        .header-search i {
            position: absolute;
            left: var(--space-4);
            top: 50%;
            transform: translateY(-50%);
            color: var(--ju-gray-dark);
            font-size: 1.1rem;
            transition: color var(--transition);
            pointer-events: none;
        }

        /* User Menu - On Blue Background */
        .user-menu-container {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        /* Notification Bell - On Blue Background */
        .notification-bell {
            position: relative;
            background: rgba(255,255,255,0.15);
            border: none;
            color: var(--ju-white);
            font-size: 1.25rem;
            cursor: pointer;
            padding: var(--space-2);
            border-radius: 50%;
            transition: all var(--transition);
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        }
        .notification-bell.hover-rotate:hover {
            transform: rotate(15deg);
            background: rgba(255,255,255,0.25);
            color: var(--ju-white);
        }

        .notification-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            background: var(--danger);
            color: var(--ju-white);
            font-size: 0.65rem;
            font-weight: 700;
            min-width: 20px;
            height: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2px solid var(--ju-white);
            box-shadow: var(--shadow-sm);
            animation: pulse 2s infinite;
        }

        /* User Profile - On Blue Background */
        .user-profile {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-2) var(--space-3);
            border-radius: 40px;
            transition: all var(--transition-bounce);
            cursor: pointer;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            min-height: 48px;
            backdrop-filter: blur(5px);
        }
        .user-profile.hover-lift:hover {
            background: rgba(255,255,255,0.25);
            border-color: var(--ju-white);
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--ju-white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ju-blue);
            font-weight: 700;
            font-size: 1rem;
            box-shadow: var(--shadow-sm);
            transition: all var(--transition);
        }
        .user-profile:hover .user-avatar {
            transform: scale(1.15);
            box-shadow: var(--shadow-md);
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ju-white);
            white-space: nowrap;
        }

        .user-role {
            font-size: 0.7rem;
            color: var(--ju-white);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        /* Auth Buttons - On Blue Background */
        .guest-nav {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .auth-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-6);
            border-radius: 40px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-bounce);
            border: none;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            min-height: 48px;
            min-width: 120px;
            box-shadow: var(--shadow-md);
        }

        .auth-btn-login {
            background: var(--ju-white);
            color: var(--ju-blue);
        }
        .auth-btn-login.hover-shine:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }

        .auth-btn-register {
            background: transparent;
            color: var(--ju-white);
            border: 2px solid var(--ju-white);
        }
        .auth-btn-register.hover-scale:hover {
            background: var(--ju-white);
            color: var(--ju-blue);
            transform: scale(1.05);
        }

        .logout-btn {
            background: rgba(255,255,255,0.15);
            color: var(--ju-white);
            border: 2px solid rgba(255,255,255,0.3);
            padding: var(--space-2) var(--space-5);
            border-radius: 40px;
            font-size: 0.9rem;
            font-weight: 600;
            min-height: 44px;
            transition: all var(--transition-bounce);
            backdrop-filter: blur(5px);
        }
        .logout-btn.hover-shake:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: var(--ju-white);
            animation: shake 0.5s ease-in-out;
        }

        /* ============================================
           DISTINCT SIDEBAR - DARK BLUE WITH GOLD ACCENTS
           Complete differentiation from main content
        ============================================ */
        .main-layout {
            display: flex;
            flex: 1;
            min-height: calc(100vh - 80px);
            position: relative;
            z-index: 1;
        }

        .ju-sidebar {
            width: 300px;
            background: linear-gradient(180deg, #0a2c6e 0%, #041a3a 100%);
            border-right: 3px solid var(--ju-gold);
            position: sticky;
            top: 80px;
            height: calc(100vh - 80px);
            overflow-y: auto;
            flex-shrink: 0;
            padding: var(--space-6) 0;
            box-shadow: 8px 0 25px rgba(0,0,0,0.2);
            z-index: var(--z-sidebar);
        }

        /* Custom Scrollbar for Sidebar */
        .ju-sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .ju-sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
        }
        .ju-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            transition: all var(--transition);
        }
        .ju-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.4);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* Menu Header - Gold text with gold accent bar */
        .menu-header {
            padding: var(--space-4) var(--space-6) var(--space-2);
            color: var(--ju-gold);
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: var(--space-6);
            position: relative;
            display: flex;
            align-items: center;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .menu-header::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 16px;
            background: var(--ju-gold);
            margin-right: var(--space-2);
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(196,167,71,0.4);
        }

        /* Menu Items */
        .menu-item {
            margin: 4px var(--space-3);
            position: relative;
        }

        /* Menu Links - White text on dark blue */
        .menu-link {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-4);
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.25s ease;
            border-radius: var(--radius);
            position: relative;
            overflow: hidden;
            min-height: 48px;
            border-left: 3px solid transparent;
            background: transparent;
        }

        /* Hover State - Light blue overlay */
        .menu-link:hover {
            color: var(--ju-white);
            background: rgba(255,255,255,0.1);
            border-left-color: var(--ju-gold);
            transform: translateX(5px);
        }

        /* Active State - Gold accent */
        .menu-link.active {
            color: var(--ju-white);
            background: rgba(196,167,71,0.15);
            border-left: 3px solid var(--ju-gold);
            font-weight: 600;
            box-shadow: inset 0 0 20px rgba(196,167,71,0.1);
        }

        /* Menu Icons - Gold color */
        .menu-icon {
            width: 24px;
            text-align: center;
            font-size: 1.1rem;
            color: var(--ju-gold);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }
        .menu-link:hover .menu-icon,
        .menu-link.active .menu-icon {
            transform: scale(1.15);
            color: var(--ju-gold-light);
        }

        /* Menu Title - White text */
        .menu-title {
            flex: 1;
            position: relative;
            z-index: 1;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* Menu Badge - Enhanced for dark background */
        .menu-badge {
            background: var(--danger);
            color: var(--ju-white);
            font-size: 0.65rem;
            padding: 3px 8px;
            border-radius: 20px;
            font-weight: 700;
            box-shadow: 0 4px 8px rgba(220,53,69,0.4);
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255,255,255,0.2);
            letter-spacing: 0.5px;
        }

        /* Collapsible Menu Arrow */
        .menu-arrow {
            position: absolute;
            right: var(--space-4);
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
            transition: all 0.3s ease;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            z-index: 1;
        }
        .menu-link:hover .menu-arrow,
        .menu-collapse[aria-expanded="true"] .menu-arrow {
            transform: rotate(90deg);
            color: var(--ju-gold);
            background: rgba(255,255,255,0.1);
        }

        /* Sub-menu Container - Distinct dark background with gold border */
        .sub-menu {
            list-style: none;
            padding: 0.5rem 0;
            margin: 0.25rem 0 0.5rem calc(var(--space-6) + 10px);
            background: rgba(0,0,0,0.25);
            border-left: 2px solid var(--ju-gold);
            border-radius: 0 var(--radius) var(--radius) 0;
            position: relative;
            backdrop-filter: blur(2px);
        }

        .sub-menu .nav-link {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: 0.6rem var(--space-4) 0.6rem var(--space-6);
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 400;
            transition: all 0.25s ease;
            border-left: 2px solid transparent;
            min-height: 40px;
            position: relative;
        }

        .sub-menu .nav-link i {
            color: var(--ju-gold);
            font-size: 0.85rem;
            width: 18px;
            text-align: center;
            filter: drop-shadow(0 2px 2px rgba(0,0,0,0.2));
        }

        .sub-menu .nav-link:hover {
            color: var(--ju-white);
            background: rgba(255,255,255,0.08);
            border-left-color: var(--ju-gold);
            transform: translateX(3px);
        }

        .sub-menu .nav-link.active {
            color: var(--ju-white);
            background: rgba(196,167,71,0.12);
            border-left-color: var(--ju-gold);
            font-weight: 600;
        }

        /* Sidebar overlay for mobile */
        .ju-sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 998;
            backdrop-filter: blur(3px);
        }

        /* ============================================
           MAIN CONTENT AREA - LIGHT BACKGROUND
           Clear visual separation from sidebar
        ============================================ */
        .ju-main-content {
            flex: 1;
            padding: var(--space-8);
            background: var(--ju-offwhite);
            min-height: calc(100vh - 80px);
            overflow-y: auto;
            position: relative;
            z-index: 1;
        }

        /* Content Header */
        .content-header {
            margin-bottom: var(--space-8);
            padding-bottom: var(--space-6);
            border-bottom: 2px solid var(--ju-blue);
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: var(--space-4);
            background: transparent;
        }

        .page-title {
            font-family: var(--font-secondary);
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--ju-blue);
            margin-bottom: var(--space-2);
            letter-spacing: -1px;
        }

        .page-subtitle {
            color: var(--ju-gray-dark);
            font-size: 1.1rem;
            font-weight: 400;
            max-width: 700px;
        }

        /* Breadcrumb */
        .breadcrumb-nav {
            padding: var(--space-2) var(--space-4);
            background: var(--ju-white);
            border-radius: 40px;
            box-shadow: var(--shadow-sm);
        }
        .breadcrumb-item a {
            color: var(--ju-blue);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition);
        }
        .breadcrumb-item a.hover-underline-center:hover {
            color: var(--ju-blue-dark);
        }

        /* ============================================
           ULTRA-ENHANCED CARDS - JU OFFICIAL
        ============================================ */
        .ju-card {
            background: var(--ju-white);
            border: 1px solid var(--ju-gray);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow);
            transition: all var(--transition-bounce);
            overflow: hidden;
            position: relative;
            margin-bottom: var(--space-6);
        }
        .ju-card.hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
            border-color: var(--ju-blue);
        }

        .ju-card-header {
            padding: var(--space-6);
            border-bottom: 1px solid var(--ju-gray);
            background: linear-gradient(180deg, var(--ju-white) 0%, var(--ju-offwhite) 100%);
        }

        .ju-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--ju-blue);
            margin: 0;
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }

        .ju-card-body {
            padding: var(--space-6);
        }

        /* Stat Cards - JU Official */
        .stat-card {
            color: var(--ju-white);
            border-radius: var(--radius-lg);
            padding: var(--space-8);
            text-align: center;
            transition: all var(--transition-bounce);
            border: none;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .stat-card.hover-grow-shadow:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: var(--shadow-2xl);
        }

        .stat-card-primary { background: var(--gradient-primary); }
        .stat-card-green { background: var(--gradient-green); }
        .stat-card-gold { background: var(--gradient-gold); }
        .stat-card-success { background: var(--success); }
        .stat-card-warning { background: var(--warning); color: var(--ju-black); }
        .stat-card-danger { background: var(--danger); }

        .stat-icon {
            font-size: 2.8rem;
            margin-bottom: var(--space-4);
            opacity: 0.9;
            filter: drop-shadow(0 8px 12px rgba(0,0,0,0.2));
            transition: all var(--transition);
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.2) rotate(5deg);
        }

        .stat-number {
            font-size: 3.2rem;
            font-weight: 800;
            margin-bottom: var(--space-2);
            font-family: var(--font-secondary);
            text-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .stat-label {
            font-size: 1rem;
            opacity: 0.95;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* ============================================
           ENHANCED BUTTONS - JU OFFICIAL
        ============================================ */
        .ju-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-6);
            border-radius: 40px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all var(--transition-bounce);
            border: none;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            min-height: 44px;
            box-shadow: var(--shadow-sm);
        }

        .ju-btn-primary {
            background: var(--gradient-primary);
            color: var(--ju-white);
        }
        .ju-btn-primary.hover-shine:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
        }

        .ju-btn-outline {
            background: transparent;
            color: var(--ju-blue);
            border: 2px solid var(--ju-blue);
        }
        .ju-btn-outline.hover-scale:hover {
            background: var(--ju-blue);
            color: var(--ju-white);
            transform: scale(1.05);
        }

        .ju-btn-success {
            background: var(--success);
            color: var(--ju-white);
        }
        .ju-btn-warning {
            background: var(--warning);
            color: var(--ju-black);
        }
        .ju-btn-danger {
            background: var(--danger);
            color: var(--ju-white);
        }

        /* Action Buttons */
        .action-btn {
            width: 38px;
            height: 38px;
            border: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all var(--transition-bounce);
            box-shadow: var(--shadow-sm);
            color: var(--ju-white);
            margin: 0 2px;
        }
        .action-btn-view { background: var(--ju-blue); }
        .action-btn-edit { background: var(--warning); color: var(--ju-black); }
        .action-btn-delete { background: var(--danger); }
        .action-btn-approve { background: var(--success); }
        .action-btn-reject { background: var(--danger); }
        
        .action-btn.hover-rotate:hover {
            transform: rotate(15deg) scale(1.15);
            box-shadow: var(--shadow-lg);
        }

        /* ============================================
           ENHANCED TABLES
        ============================================ */
        .ju-table {
            width: 100%;
            margin-bottom: 0;
        }
        .ju-table thead th {
            background: var(--ju-blue-soft);
            color: var(--ju-blue-dark);
            font-weight: 700;
            padding: var(--space-4);
            border-bottom: 2px solid var(--ju-blue);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .ju-table tbody td {
            padding: var(--space-4);
            border-bottom: 1px solid var(--ju-gray);
            color: var(--ju-gray-dark);
            vertical-align: middle;
        }
        .ju-table tbody tr {
            transition: all var(--transition);
        }
        .ju-table tbody tr:hover td {
            background: var(--ju-blue-soft);
            transform: translateX(2px);
        }

        /* ============================================
           ENHANCED FOOTER - JU OFFICIAL BLUE
        ============================================ */
        .ju-footer {
            background: var(--ju-blue-dark);
            color: var(--ju-white);
            padding: var(--space-8) 0;
            margin-top: auto;
            position: relative;
            border-top: 3px solid var(--ju-gold);
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 var(--space-6);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: var(--space-6);
        }

        .footer-copyright {
            color: var(--ju-white);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: var(--space-2);
            opacity: 0.9;
        }

        .footer-links {
            display: flex;
            gap: var(--space-6);
            flex-wrap: wrap;
        }

        .footer-link {
            color: var(--ju-white);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all var(--transition);
            position: relative;
            padding: var(--space-1) 0;
            opacity: 0.9;
        }
        .footer-link.hover-underline-center:hover {
            color: var(--ju-gold);
            opacity: 1;
        }
        .footer-link.hover-underline-center:hover::after {
            width: 80%;
            background: var(--ju-gold);
        }

        /* ============================================
           NOTIFICATION TOASTS
        ============================================ */
        .toast-container {
            position: fixed;
            top: 90px;
            right: var(--space-6);
            z-index: var(--z-toast);
            max-width: 400px;
            width: 100%;
        }

        .ju-toast {
            background: var(--ju-white);
            border-left: 4px solid;
            border-radius: var(--radius);
            box-shadow: var(--shadow-xl);
            padding: var(--space-4);
            margin-bottom: var(--space-3);
            animation: slideInRight 0.3s ease-out;
            transition: all var(--transition);
        }
        .ju-toast-success { border-left-color: var(--success); }
        .ju-toast-error { border-left-color: var(--danger); }
        .ju-toast-warning { border-left-color: var(--warning); }
        .ju-toast-info { border-left-color: var(--ju-blue); }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        /* ============================================
           RESPONSIVE DESIGN
        ============================================ */
        @media (max-width: 1400px) {
            .ju-sidebar { width: 280px; }
            .page-title { font-size: 2rem; }
        }

        @media (max-width: 1200px) {
            .ju-sidebar { width: 260px; }
            .ju-main-content { padding: var(--space-6); }
            .page-title { font-size: 1.8rem; }
        }

        @media (max-width: 992px) {
            .main-layout { flex-direction: column; }
            .ju-sidebar {
                width: 100%;
                height: auto;
                max-height: 400px;
                position: static;
                border-right: none;
                border-bottom: 3px solid var(--ju-gold);
                padding: var(--space-4) 0;
                box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            }
            .sidebar-menu {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: var(--space-2);
                padding: 0 var(--space-4);
            }
            .menu-header { grid-column: 1 / -1; }
            .menu-link { margin: 2px; border-left: none; border-bottom: 3px solid transparent; }
            .menu-link.active { border-left: none; border-bottom-color: var(--ju-gold); }
            .page-title { font-size: 1.6rem; }
            .stat-number { font-size: 2.5rem; }
        }

        @media (max-width: 768px) {
            .ju-header { height: auto; padding: var(--space-3) 0; }
            .header-container { flex-wrap: wrap; height: auto; padding: var(--space-3); }
            .ju-brand { order: 1; }
            .user-menu-container { order: 2; width: 100%; justify-content: flex-end; }
            .header-search { order: 3; max-width: 100%; margin-top: var(--space-3); }
            .ju-main-content { padding: var(--space-4); }
            .page-title { font-size: 1.4rem; }
            .guest-nav { flex-direction: column; width: 100%; }
            .auth-btn { width: 100%; }
            .user-profile .user-details { display: none; }
            .footer-container { flex-direction: column; text-align: center; }
            .stat-card { padding: var(--space-6); min-height: 160px; }
            .stat-number { font-size: 2rem; }
        }

        @media (max-width: 576px) {
            .page-title { font-size: 1.2rem; }
            .ju-btn { padding: var(--space-2) var(--space-4); }
            .action-btn { width: 34px; height: 34px; }
        }

        /* Print Styles */
        @media print {
            .ju-header, .ju-sidebar, .ju-footer, .toast-container {
                display: none !important;
            }
            .ju-main-content {
                padding: 0 !important;
                margin: 0 !important;
            }
            .ju-card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Official Jimma University Header - COMPLETE BLUE BACKGROUND -->
    <header class="ju-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="ju-brand hover-scale">
                <div class="ju-logo">
                    <i class="fas fa-university"></i>
                </div>
                <div class="ju-title-container">
                    <h1 class="ju-main-title">Jimma University</h1>
                    <p class="ju-subtitle">Event Management System</p>
                </div>
            </a>

            <!-- Enhanced Search with Hover -->
            <div class="header-search d-none d-lg-block">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search events, announcements, or users..." id="globalSearch" class="hover-glow">
            </div>

            <div class="user-menu-container">
                @auth
                <!-- Notification Bell -->
                <div class="dropdown notification-dropdown-container">
                    <button class="notification-bell hover-rotate dropdown-toggle" type="button"
                        id="notificationDropdown" data-bs-toggle="dropdown"
                        aria-expanded="false" onclick="loadNotifications()">
                        <i class="fas fa-bell"></i>
                        @php
                        $unreadCount = auth()->user()->unreadNotificationsCount ?? 0;
                        @endphp
                        @if($unreadCount > 0)
                        <span class="notification-badge">{{ $unreadCount }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu notification-dropdown" aria-labelledby="notificationDropdown">
                        <div class="notification-header" style="background: var(--gradient-primary);">
                            <h6 class="notification-title mb-0 text-white">
                                <i class="fas fa-bell me-2"></i>Notifications
                            </h6>
                            @if(auth()->user()->unreadNotificationsCount > 0)
                            <button class="btn btn-sm btn-light" onclick="markAllAsRead()">
                                <i class="fas fa-check-double me-1"></i>Mark all as read
                            </button>
                            @endif
                        </div>
                        <div class="notification-body" id="notificationList">
                            <div class="text-center py-4">
                                <div class="spinner-border text-white" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="notification-footer">
                            <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-light w-100">
                                <i class="fas fa-list me-1"></i>View All Notifications
                            </a>
                        </div>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="user-profile hover-lift">
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
                    <i class="fas fa-chevron-down ml-2" style="font-size: 0.75rem; color: var(--ju-white);"></i>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="d-inline" id="logoutForm">
                    @csrf
                    <button type="submit" class="btn logout-btn hover-shake">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
                @else
                <!-- Auth Buttons -->
                <div class="guest-nav">
                    <a href="{{ route('login') }}" class="auth-btn auth-btn-login hover-shine">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Login</span>
                    </a>
                    <a href="{{ route('register') }}" class="auth-btn auth-btn-register hover-scale">
                        <i class="fas fa-user-plus"></i>
                        <span>Register</span>
                    </a>
                </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Toast Container -->
    <div class="toast-container">
        @if(session('success'))
        <div class="ju-toast ju-toast-success animate__animated animate__fadeInRight" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle fa-lg text-success"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="fw-bold mb-1">Success!</div>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" onclick="this.closest('.ju-toast').remove()"></button>
            </div>
        </div>
        @endif
        
        @if(session('error'))
        <div class="ju-toast ju-toast-error animate__animated animate__fadeInRight" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle fa-lg text-danger"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="fw-bold mb-1">Error!</div>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" onclick="this.closest('.ju-toast').remove()"></button>
            </div>
        </div>
        @endif
        
        @if(session('info'))
        <div class="ju-toast ju-toast-info animate__animated animate__fadeInRight" role="alert">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle fa-lg text-info"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="fw-bold mb-1">Information</div>
                    <div>{{ session('info') }}</div>
                </div>
                <button type="button" class="btn-close" onclick="this.closest('.ju-toast').remove()"></button>
            </div>
        </div>
        @endif
    </div>

    <!-- Main Layout -->
    <div class="main-layout">
        @auth
        <!-- DISTINCT SIDEBAR - Dark Blue with Gold Accents -->
        <nav class="ju-sidebar">
            <ul class="sidebar-menu">
                <!-- DASHBOARD -->
                @if(auth()->user()->hasPermission('view_dashboard'))
                <li class="menu-header">Dashboard</li>
                <li class="menu-item">
                    <a href="{{ route('dashboard') }}" class="menu-link hover-slide-up {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-tachometer-alt"></i>
                        <span class="menu-title">Admin Dashboard</span>
                    </a>
                </li>
                @endif

                <!-- EVENT MANAGEMENT -->
                <li class="menu-header">Events</li>

                <!-- Browse Events -->
                <li class="menu-item">
                    <a href="{{ route('home') }}" class="menu-link hover-slide-up {{ request()->routeIs('home') || request()->routeIs('events.guest.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-calendar-alt"></i>
                        <span class="menu-title">Browse Events</span>
                    </a>
                </li>

                <!-- Register for Events -->
                <li class="menu-item">
                    <a href="{{ route('event-registration.index') }}" class="menu-link hover-slide-up {{ request()->routeIs('event-registration.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-user-plus"></i>
                        <span class="menu-title">Register for Events</span>
                    </a>
                </li>

                <!-- My Registrations -->
                <li class="menu-item">
                    <a href="{{ route('my-events.index') }}" class="menu-link hover-slide-up {{ request()->routeIs('my-events.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-calendar-check"></i>
                        <span class="menu-title">My Registrations</span>
                        @php
                        $myRegistrationsCount = auth()->user()
                        ? \App\Models\EventRegistration::where('user_id', auth()->id())
                        ->whereIn('status', ['confirmed', 'pending'])
                        ->count()
                        : 0;
                        @endphp
                        @if($myRegistrationsCount > 0)
                        <span class="menu-badge hover-pulse">{{ $myRegistrationsCount }}</span>
                        @endif
                    </a>
                </li>

                <!-- Create Event Request -->
                <li class="menu-item">
                    <a href="{{ route('event-requests.create') }}" class="menu-link hover-slide-up {{ request()->routeIs('event-requests.create') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-plus-circle"></i>
                        <span class="menu-title">Create Event Request</span>
                    </a>
                </li>

                <!-- My Event Requests -->
                <li class="menu-item">
                    <a href="{{ route('event-requests.my-requests') }}" class="menu-link hover-slide-up {{ request()->routeIs('event-requests.my-requests') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-clipboard-list"></i>
                        <span class="menu-title">My Event Requests</span>
                        @php
                        $myPendingRequestsCount = auth()->user()
                        ? \App\Models\EventRequest::where('user_id', auth()->id())
                        ->where('status', 'pending')
                        ->count()
                        : 0;
                        @endphp
                        @if($myPendingRequestsCount > 0)
                        <span class="menu-badge hover-pulse">{{ $myPendingRequestsCount }}</span>
                        @endif
                    </a>
                </li>

                <!-- FEEDBACK SECTION -->
                <li class="menu-header">Feedback</li>

                <!-- Submit Feedback -->
                <li class="menu-item">
                    <a href="{{ route('feedback.create') }}" class="menu-link hover-slide-up {{ request()->routeIs('feedback.create') || request()->routeIs('feedback.store') || request()->routeIs('feedback.thankyou') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-comment-dots"></i>
                        <span class="menu-title">Submit Feedback</span>
                    </a>
                </li>

                <!-- View Testimonials -->
                <li class="menu-item">
                    <a href="{{ route('feedback.testimonials') }}" class="menu-link hover-slide-up {{ request()->routeIs('feedback.testimonials') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-star"></i>
                        <span class="menu-title">View Testimonials</span>
                    </a>
                </li>

                <!-- NOTIFICATIONS -->
                <li class="menu-header">Notifications</li>
                <li class="menu-item">
                    <a href="{{ route('notifications.index') }}" class="menu-link hover-slide-up {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-bell"></i>
                        <span class="menu-title">My Notifications</span>
                        @php
                        $unreadCount = auth()->user()->unread_notifications_count ?? 0;
                        @endphp
                        @if($unreadCount > 0)
                        <span class="menu-badge hover-pulse">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>

                <!-- ANNOUNCEMENTS -->
                <li class="menu-header">Announcements</li>
                <li class="menu-item">
                    <a href="{{ route('announcements.index') }}" class="menu-link hover-slide-up {{ request()->routeIs('announcements.index') && !request()->routeIs('announcements.create') && !request()->routeIs('announcements.edit') && !request()->routeIs('announcements.statistics') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-bullhorn"></i>
                        <span class="menu-title">Announcements</span>
                    </a>
                </li>

                <!-- ADMINISTRATION SECTION -->
                @if(auth()->user()->hasAnyPermission(['manage_events', 'manage_venues', 'manage_users', 'view_event_requests', 'manage_feedback', 'manage_announcements']))
                <li class="menu-header">Administration</li>

                <!-- VENUE MANAGEMENT -->
                @if(auth()->user()->hasPermission('manage_venues'))
                <li class="menu-item">
                    <a class="menu-link menu-collapse hover-slide-up {{ request()->routeIs('admin.campuses.*') || request()->routeIs('admin.buildings.*') || request()->routeIs('admin.venues.*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#venueManagement" role="button" aria-expanded="{{ request()->routeIs('admin.campuses.*') || request()->routeIs('admin.buildings.*') || request()->routeIs('admin.venues.*') ? 'true' : 'false' }}">
                        <i class="menu-icon fas fa-map-marked-alt"></i>
                        <span class="menu-title">Venue Management</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.campuses.*') || request()->routeIs('admin.buildings.*') || request()->routeIs('admin.venues.*') ? 'show' : '' }}" id="venueManagement">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('admin.campuses.*') ? 'active' : '' }}"
                                    href="{{ route('admin.campuses.index') }}">
                                    <i class="fas fa-university me-2"></i>
                                    <span>Campuses</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('admin.buildings.*') ? 'active' : '' }}"
                                    href="{{ route('admin.buildings.index') }}">
                                    <i class="fas fa-building me-2"></i>
                                    <span>Buildings</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('admin.venues.*') ? 'active' : '' }}"
                                    href="{{ route('admin.venues.index') }}">
                                    <i class="fas fa-door-closed me-2"></i>
                                    <span>Venues & Halls</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                <!-- EVENT ADMINISTRATION -->
                @if(auth()->user()->hasPermission('manage_events') || auth()->user()->hasPermission('view_event_requests'))
                <li class="menu-item">
                    <a class="menu-link menu-collapse hover-slide-up {{ request()->routeIs('admin.events.*') || request()->routeIs('event-requests.index') || request()->routeIs('speakers.*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#eventAdmin" role="button" aria-expanded="{{ request()->routeIs('admin.events.*') || request()->routeIs('event-requests.index') || request()->routeIs('speakers.*') ? 'true' : 'false' }}">
                        <i class="menu-icon fas fa-calendar-plus"></i>
                        <span class="menu-title">Event Administration</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('admin.events.*') || request()->routeIs('event-requests.index') || request()->routeIs('speakers.*') ? 'show' : '' }}" id="eventAdmin">
                        <ul class="nav flex-column sub-menu">
                            @if(auth()->user()->hasPermission('manage_events'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('admin.events.index') ? 'active' : '' }}"
                                    href="{{ route('admin.events.index') }}">
                                    <i class="fas fa-calendar me-2"></i>
                                    <span>All Events</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('create_events'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('admin.events.create') ? 'active' : '' }}"
                                    href="{{ route('admin.events.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    <span>Create Event</span>
                                </a>
                            </li>
                            @endif

                            @if(class_exists('App\Models\Speaker') && auth()->user()->hasPermission('manage_speakers'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('speakers.*') ? 'active' : '' }}"
                                    href="{{ route('speakers.index') }}">
                                    <i class="fas fa-microphone-alt me-2"></i>
                                    <span>Speakers</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_event_requests'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('event-requests.index') ? 'active' : '' }}"
                                    href="{{ route('event-requests.index') }}">
                                    <i class="fas fa-clipboard-list me-2"></i>
                                    <span>All Event Requests</span>
                                    @php
                                    $pendingRequests = \App\Models\EventRequest::where('status', 'pending')->count();
                                    @endphp
                                    @if($pendingRequests > 0)
                                    <span class="menu-badge hover-pulse">{{ $pendingRequests }}</span>
                                    @endif
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- USER ADMINISTRATION -->
                @if(auth()->user()->hasAnyPermission(['view_users', 'create_users', 'view_roles', 'view_permissions']))
                <li class="menu-item">
                    <a class="menu-link menu-collapse hover-slide-up {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#userAdmin" role="button" aria-expanded="{{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'true' : 'false' }}">
                        <i class="menu-icon fas fa-users-cog"></i>
                        <span class="menu-title">User Administration</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'show' : '' }}" id="userAdmin">
                        <ul class="nav flex-column sub-menu">
                            @if(auth()->user()->hasPermission('view_users'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('users.index') ? 'active' : '' }}"
                                    href="{{ route('users.index') }}">
                                    <i class="fas fa-users me-2"></i>
                                    <span>All Users</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('create_users'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('users.create') ? 'active' : '' }}"
                                    href="{{ route('users.create') }}">
                                    <i class="fas fa-user-plus me-2"></i>
                                    <span>Add User</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_roles'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                                    href="{{ route('roles.index') }}">
                                    <i class="fas fa-user-tag me-2"></i>
                                    <span>Roles</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_permissions'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('permissions.*') ? 'active' : '' }}"
                                    href="{{ route('permissions.index') }}">
                                    <i class="fas fa-key me-2"></i>
                                    <span>Permissions</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>
                @endif

                <!-- FEEDBACK ADMINISTRATION -->
                @if(auth()->user()->hasPermission('manage_feedback'))
                <li class="menu-item">
                    <a class="menu-link menu-collapse hover-slide-up {{ request()->routeIs('feedback.index') || request()->routeIs('feedback.analytics') || request()->routeIs('feedback.admin.*') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#feedbackAdmin" role="button" aria-expanded="{{ request()->routeIs('feedback.index') || request()->routeIs('feedback.analytics') || request()->routeIs('feedback.admin.*') ? 'true' : 'false' }}">
                        <i class="menu-icon fas fa-comments"></i>
                        <span class="menu-title">Feedback Management</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('feedback.index') || request()->routeIs('feedback.analytics') || request()->routeIs('feedback.admin.*') ? 'show' : '' }}" id="feedbackAdmin">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('feedback.index') || request()->routeIs('feedback.admin.index') ? 'active' : '' }}"
                                    href="{{ route('feedback.index') }}">
                                    <i class="fas fa-list me-2"></i>
                                    <span>All Feedback</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('feedback.analytics') || request()->routeIs('feedback.admin.analytics') ? 'active' : '' }}"
                                    href="{{ route('feedback.analytics') }}">
                                    <i class="fas fa-chart-pie me-2"></i>
                                    <span>Analytics</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif

                <!-- ANNOUNCEMENT ADMINISTRATION -->
                @if(auth()->user()->hasAnyPermission(['manage_announcements', 'create_announcements', 'view_announcement_stats']))
                <li class="menu-item">
                    <a class="menu-link menu-collapse hover-slide-up {{ request()->routeIs('announcements.create') || request()->routeIs('announcements.edit') || request()->routeIs('announcements.statistics') ? '' : 'collapsed' }}"
                        data-bs-toggle="collapse" href="#announcementAdmin" role="button" aria-expanded="{{ request()->routeIs('announcements.create') || request()->routeIs('announcements.edit') || request()->routeIs('announcements.statistics') ? 'true' : 'false' }}">
                        <i class="menu-icon fas fa-bullhorn"></i>
                        <span class="menu-title">Announcement Admin</span>
                        <i class="menu-arrow fas fa-chevron-right"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('announcements.create') || request()->routeIs('announcements.edit') || request()->routeIs('announcements.statistics') ? 'show' : '' }}" id="announcementAdmin">
                        <ul class="nav flex-column sub-menu">
                            @if(auth()->user()->hasPermission('view_announcements'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('announcements.index') && !request()->routeIs('announcements.create') && !request()->routeIs('announcements.edit') && !request()->routeIs('announcements.statistics') ? 'active' : '' }}"
                                    href="{{ route('announcements.index') }}">
                                    <i class="fas fa-list me-2"></i>
                                    <span>All Announcements</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('create_announcements'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('announcements.create') ? 'active' : '' }}"
                                    href="{{ route('announcements.create') }}">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    <span>Create New</span>
                                </a>
                            </li>
                            @endif

                            @if(auth()->user()->hasPermission('view_announcement_stats'))
                            <li class="nav-item">
                                <a class="nav-link hover-border {{ request()->routeIs('announcements.statistics') ? 'active' : '' }}"
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
                @endif

                <!-- SYSTEM SECTION -->
                <li class="menu-header">System</li>
                <li class="menu-item">
                    <a href="#" class="menu-link hover-slide-up">
                        <i class="menu-icon fas fa-cog"></i>
                        <span class="menu-title">System Settings</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link hover-slide-up">
                        <i class="menu-icon fas fa-question-circle"></i>
                        <span class="menu-title">Help Center</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#" class="menu-link hover-slide-up">
                        <i class="menu-icon fas fa-book"></i>
                        <span class="menu-title">Documentation</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endauth

        <!-- Main Content Area - Light Background -->
        <main class="ju-main-content">
            <!-- Content Header -->
            <div class="content-header">
                <div>
                    <h1 class="page-title">@yield('page-title', 'Jimma University Events')</h1>
                    <p class="page-subtitle">@yield('page-subtitle', 'We are in the Community!')</p>
                </div>

                @auth
                <!-- Breadcrumb -->
                <nav class="breadcrumb-nav">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="hover-underline-center"><i class="fas fa-home me-1"></i>Dashboard</a></li>
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

    <!-- Official Jimma University Footer - BLUE THEME -->
    <footer class="ju-footer">
        <div class="footer-container">
            <div class="footer-copyright">
                <i class="fas fa-copyright me-1"></i> {{ date('Y') }} Jimma University. All rights reserved.
                <span class="mx-2 d-none d-sm-inline">|</span>
                <span class="d-block d-sm-inline mt-2 mt-sm-0 fw-bold">"We are in the Community!"</span>
            </div>
            <div class="footer-links">
                <a href="#" class="footer-link hover-underline-center">About</a>
                <a href="#" class="footer-link hover-underline-center">Contact</a>
                <a href="#" class="footer-link hover-underline-center">Privacy</a>
                <a href="#" class="footer-link hover-underline-center">Terms</a>
                <a href="#" class="footer-link hover-underline-center">Support</a>
            </div>
        </div>
    </footer>

    <!-- Approve/Reject Modal -->
    <div class="modal fade" id="approveRejectModal" tabindex="-1" aria-labelledby="approveRejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: var(--gradient-primary); color: white;">
                    <h5 class="modal-title" id="approveRejectModalLabel">
                        <i class="fas fa-check-circle me-2"></i>
                        <span id="modalActionText">Approve Request</span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="approveRejectForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Event Request:</label>
                            <div id="requestTitle" class="p-3 bg-light rounded">
                                <strong id="modalEventTitle">Loading...</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reviewNotes" class="form-label fw-bold">
                                <i class="fas fa-edit me-1"></i>Review Notes
                            </label>
                            <textarea
                                class="form-control"
                                id="reviewNotes"
                                name="review_notes"
                                rows="4"
                                placeholder="Add any comments or notes about this decision..."></textarea>
                            <div class="form-text">These notes will be visible to the requester.</div>
                        </div>
                        <input type="hidden" id="modalRequestId" name="request_id">
                        <input type="hidden" id="modalAction" name="action" value="approve">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-success" id="modalSubmitBtn">
                            <i class="fas fa-check me-1"></i>
                            <span id="submitBtnText">Approve Request</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div class="ju-sidebar-overlay" onclick="document.querySelector('.ju-sidebar').classList.remove('mobile-open')"></div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Initialize AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        // Set CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            initNotificationSystem();
            initSidebar();
            initSearch();
            initTooltips();
            initSelect2();
            initDataTables();
            initModals();
            initMobileSidebar();
        });

        // Notification System
        function initNotificationSystem() {
            if (document.querySelector('.notification-bell')) {
                setTimeout(() => {
                    if (!document.querySelector('#notificationDropdown').classList.contains('show')) {
                        checkNewNotifications();
                    }
                }, 1000);
                setInterval(checkNewNotifications, 30000);
            }
        }

        function loadNotifications() {
            const notificationList = document.getElementById('notificationList');
            if (!notificationList) return;

            notificationList.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-white" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-white">Loading notifications...</p>
                </div>
            `;

            $.ajax({
                url: '{{ route("notifications.index") }}?ajax=1',
                method: 'GET',
                success: function(response) {
                    notificationList.innerHTML = response;
                    initNotificationActions();
                },
                error: function() {
                    notificationList.innerHTML = `
                        <div class="empty-notifications text-center py-5">
                            <i class="fas fa-exclamation-circle text-white fa-3x mb-3"></i>
                            <h6 class="fw-bold text-white">Failed to load notifications</h6>
                            <button class="btn btn-sm btn-outline-light mt-2" onclick="loadNotifications()">
                                <i class="fas fa-sync-alt me-1"></i> Retry
                            </button>
                        </div>
                    `;
                }
            });
        }

        function checkNewNotifications() {
            $.ajax({
                url: '{{ route("notifications.unread-count") }}',
                method: 'GET',
                success: function(response) {
                    const badge = document.querySelector('.notification-badge');
                    if (response.count > 0) {
                        if (!badge) {
                            const bell = document.querySelector('.notification-bell');
                            if (bell) {
                                const newBadge = document.createElement('span');
                                newBadge.className = 'notification-badge';
                                newBadge.textContent = response.count;
                                bell.appendChild(newBadge);
                                bell.classList.add('new');
                            }
                        } else {
                            badge.textContent = response.count;
                        }
                    } else {
                        if (badge) badge.remove();
                    }
                }
            });
        }

        function markAsRead(notificationId) {
            $.ajax({
                url: `{{ url('notifications') }}/${notificationId}/read`,
                method: 'PATCH',
                success: function() {
                    const item = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                    if (item) {
                        item.classList.remove('unread');
                        item.classList.add('read');
                    }
                    checkNewNotifications();
                }
            });
        }

        function markAllAsRead() {
            $.ajax({
                url: '{{ route("notifications.mark-all-read") }}',
                method: 'PATCH',
                success: function() {
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                        item.classList.add('read');
                    });
                    const badge = document.querySelector('.notification-badge');
                    if (badge) badge.remove();
                }
            });
        }

        function viewNotification(notificationId) {
            markAsRead(notificationId);
            window.location.href = `{{ url('notifications') }}/${notificationId}`;
        }

        function initNotificationActions() {
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    if (!e.target.closest('.notification-actions') && !e.target.closest('button')) {
                        const notificationId = this.dataset.id;
                        markAsRead(notificationId);
                    }
                });
            });
        }

        // Sidebar
        function initSidebar() {
            document.querySelectorAll('.menu-link.active').forEach(link => {
                const collapse = link.closest('.collapse');
                if (collapse) {
                    const parentMenu = document.querySelector(`[href="#${collapse.id}"]`);
                    if (parentMenu) {
                        parentMenu.classList.remove('collapsed');
                        parentMenu.setAttribute('aria-expanded', 'true');
                        collapse.classList.add('show');
                    }
                }
            });
        }

        // Mobile Sidebar
        function initMobileSidebar() {
            // You can add a hamburger menu button here if needed
            const sidebar = document.querySelector('.ju-sidebar');
            if (window.innerWidth <= 992) {
                sidebar.classList.add('mobile-closed');
            }
        }

        // Search
        function initSearch() {
            const searchInput = document.getElementById('globalSearch');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const query = this.value.trim();
                        if (query) {
                            window.location.href = `{{ route('home') }}?search=${encodeURIComponent(query)}`;
                        }
                    }
                });
            }
        }

        // Tooltips
        function initTooltips() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        // Select2
        function initSelect2() {
            if ($.fn.select2) {
                $('.select2').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: 'Select an option',
                    allowClear: true
                });
            }
        }

        // DataTables
        function initDataTables() {
            if ($.fn.DataTable) {
                $('.data-table').DataTable({
                    responsive: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search...",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        paginate: {
                            first: '<i class="fas fa-angle-double-left"></i>',
                            last: '<i class="fas fa-angle-double-right"></i>',
                            next: '<i class="fas fa-chevron-right"></i>',
                            previous: '<i class="fas fa-chevron-left"></i>'
                        }
                    }
                });
            }
        }

        // Modals
        function initModals() {
            window.openApproveModal = function(requestId, title) {
                document.getElementById('modalRequestId').value = requestId;
                document.getElementById('modalEventTitle').textContent = title;
                document.getElementById('modalActionText').textContent = 'Approve Request';
                document.getElementById('submitBtnText').textContent = 'Approve Request';
                document.getElementById('modalSubmitBtn').className = 'btn btn-success';
                document.getElementById('modalAction').value = 'approve';
                const modal = new bootstrap.Modal(document.getElementById('approveRejectModal'));
                modal.show();
            };
            
            window.openRejectModal = function(requestId, title) {
                document.getElementById('modalRequestId').value = requestId;
                document.getElementById('modalEventTitle').textContent = title;
                document.getElementById('modalActionText').textContent = 'Reject Request';
                document.getElementById('submitBtnText').textContent = 'Reject Request';
                document.getElementById('modalSubmitBtn').className = 'btn btn-danger';
                document.getElementById('modalAction').value = 'reject';
                const modal = new bootstrap.Modal(document.getElementById('approveRejectModal'));
                modal.show();
            };
        }

        // Auto-hide toasts
        setTimeout(function() {
            document.querySelectorAll('.ju-toast').forEach(toast => {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 500);
            });
        }, 5000);

        // Window resize handler
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                const sidebar = document.querySelector('.ju-sidebar');
                if (sidebar) sidebar.classList.remove('mobile-closed');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>