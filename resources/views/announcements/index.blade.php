@extends('layouts.app')

@section('title', 'Announcements - Jimma University')
@section('page-title', 'Announcements')
@section('page-subtitle', 'University Updates & Important Notices')

@section('breadcrumb-items')
    <li class="breadcrumb-item active">
        <span class="fw-semibold" style="color: var(--ju-blue-dark);">Announcements</span>
    </li>
@endsection

@section('content')
<style>
    /* ============================================
           PREMIUM JIMMA UNIVERSITY ANNOUNCEMENTS
           DARK BLUE & GOLD Color Scheme - OFFICIAL
           VIBRANT COLORFUL STAT CARDS
           3 CARDS PER ROW - HORIZONTAL GRID
        ============================================ */
    
    :root {
        /* DARK BLUE - Official Jimma University Primary Color */
        --ju-blue: #0a2c6e;
        --ju-blue-dark: #041c47;
        --ju-blue-darker: #021230;
        --ju-blue-light: #1e4a8a;
        --ju-blue-lighter: #3a6ab0;
        --ju-blue-soft: rgba(10, 44, 110, 0.08);
        --ju-blue-glow: rgba(10, 44, 110, 0.2);
        --ju-blue-gradient: linear-gradient(145deg, #0a2c6e, #041c47);
        
        /* Ethiopian Gold Accents - Official */
        --ju-gold: #c4a747;
        --ju-gold-dark: #a5862e;
        --ju-gold-light: #d8be6e;
        --ju-gold-soft: rgba(196, 167, 71, 0.12);
        --ju-gold-gradient: linear-gradient(145deg, #c4a747, #a5862e);
        
        /* VIBRANT COLORS for Stat Cards - BOLD & COLORFUL */
        --ju-total: #4361ee;        /* Vibrant Blue */
        --ju-total-dark: #3a56d4;
        --ju-published: #10b981;     /* Vibrant Green */
        --ju-published-dark: #059669;
        --ju-active: #8b5cf6;        /* Vibrant Purple */
        --ju-active-dark: #7c3aed;
        --ju-views: #f59e0b;         /* Vibrant Orange/Gold */
        --ju-views-dark: #d97706;
        
        /* Announcement Type Colors */
        --ju-event: #3498db;
        --ju-campus: #2ecc71;
        --ju-general: #9b59b6;
        --ju-urgent: #e74c3c;
        --ju-urgent-soft: rgba(231, 76, 60, 0.12);
        
        /* Semantic Colors */
        --ju-success: #10b981;
        --ju-success-dark: #059669;
        --ju-success-soft: rgba(16, 185, 129, 0.12);
        --ju-warning: #f59e0b;
        --ju-warning-dark: #d97706;
        --ju-warning-soft: rgba(245, 158, 11, 0.12);
        --ju-danger: #dc2626;
        --ju-danger-dark: #b91c1c;
        --ju-danger-soft: rgba(220, 38, 38, 0.12);
        --ju-info: #0a2c6e;
        --ju-info-soft: rgba(10, 44, 110, 0.08);
        
        /* Neutral Colors */
        --ju-white: #ffffff;
        --ju-offwhite: #f8fafc;
        --ju-gray-50: #f9fbfd;
        --ju-gray-100: #f1f5f9;
        --ju-gray-200: #e9edf2;
        --ju-gray-300: #dee4e9;
        --ju-gray-400: #b8c2cc;
        --ju-gray-500: #8f9aa8;
        --ju-gray-600: #64748b;
        --ju-gray-700: #475569;
        --ju-gray-800: #334155;
        --ju-gray-900: #1e293b;
        
        /* Shadows */
        --shadow-sm: 0 4px 12px rgba(0,0,0,0.05);
        --shadow: 0 8px 20px rgba(0,0,0,0.08);
        --shadow-lg: 0 16px 32px rgba(0,0,0,0.12);
        --shadow-gold: 0 8px 20px rgba(196,167,71,0.2);
        
        /* Border Radius */
        --radius-sm: 8px;
        --radius: 12px;
        --radius-md: 16px;
        --radius-lg: 20px;
        --radius-xl: 24px;
        --radius-2xl: 28px;
        --radius-full: 9999px;
        
        /* Transitions */
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-bounce: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        --transition-elastic: all 0.6s cubic-bezier(0.68, -0.6, 0.32, 1.6);
    }

    /* ============================================
           VIBRANT COLORFUL STAT CARDS - BOLD & PREMIUM
           EXACTLY LIKE NOTIFICATIONS PAGE
        ============================================ */
    .premium-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    @media (max-width: 1200px) {
        .premium-stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .premium-stats-grid { grid-template-columns: 1fr; }
    }

    .premium-stat-card {
        border-radius: var(--radius-xl);
        padding: 28px;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-bounce);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        height: 100%;
        color: white;
    }

    .premium-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
        opacity: 0;
        transition: var(--transition);
        pointer-events: none;
    }

    .premium-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .premium-stat-card:hover::before {
        opacity: 1;
    }

    /* VIBRANT CARD COLORS - BOLD & BEAUTIFUL */
    .premium-stat-card.total {
        background: linear-gradient(145deg, #4361ee, #3a56d4);
    }
    .premium-stat-card.published {
        background: linear-gradient(145deg, #10b981, #059669);
    }
    .premium-stat-card.active {
        background: linear-gradient(145deg, #8b5cf6, #7c3aed);
    }
    .premium-stat-card.views {
        background: linear-gradient(145deg, #f59e0b, #d97706);
    }

    .premium-stat-icon {
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin-bottom: 16px;
        transition: var(--transition-bounce);
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .premium-stat-card:hover .premium-stat-icon {
        transform: scale(1.1) rotate(8deg);
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .premium-stat-number {
        font-size: 2.8rem;
        font-weight: 800;
        color: white;
        margin-bottom: 4px;
        line-height: 1;
        font-family: 'Montserrat', sans-serif;
        text-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .premium-stat-label {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.95);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }

    .premium-stat-subtext {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 500;
    }

    /* ============================================
           PREMIUM HEADER FILTERS - Clean & Compact
        ============================================ */
    .premium-filters-header {
        background: white;
        border-radius: var(--radius-xl);
        padding: 20px 28px;
        margin-bottom: 32px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--ju-gray-200);
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        position: relative;
    }

    .premium-filters-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--ju-blue), var(--ju-gold), var(--ju-blue));
        border-radius: var(--radius-xl) var(--radius-xl) 0 0;
    }

    .premium-filter-groups {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 24px;
    }

    .premium-filter-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .premium-filter-label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--ju-gray-700);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .premium-filter-label i {
        color: var(--ju-gold);
    }

    .premium-filter-badges {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
    }

    .premium-filter-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        background: var(--ju-gray-100);
        border: 1px solid var(--ju-gray-200);
        border-radius: var(--radius-full);
        color: var(--ju-gray-700);
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: var(--transition-bounce);
    }

    .premium-filter-badge:hover {
        background: var(--ju-blue);
        color: white;
        border-color: var(--ju-blue);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(10,44,110,0.2);
    }

    .premium-filter-badge.active {
        background: var(--ju-blue);
        color: white;
        border-color: var(--ju-blue);
        box-shadow: 0 8px 16px rgba(10,44,110,0.2);
    }

    .premium-filter-badge.active i {
        color: var(--ju-gold);
    }

    .premium-header-actions-compact {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .premium-header-btn-sm {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 8px 20px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: var(--transition-bounce);
        border: none;
        cursor: pointer;
    }

    .premium-header-btn-sm-primary {
        background: var(--ju-blue-gradient);
        color: white;
        box-shadow: 0 8px 16px rgba(10,44,110,0.2);
    }

    .premium-header-btn-sm-primary:hover {
        background: var(--ju-blue-dark);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(10,44,110,0.3);
    }

    .premium-header-btn-sm-outline {
        background: transparent;
        color: var(--ju-blue);
        border: 2px solid var(--ju-blue);
    }

    .premium-header-btn-sm-outline:hover {
        background: var(--ju-blue);
        color: white;
        transform: translateY(-2px);
    }

    /* ============================================
           PREMIUM ANNOUNCEMENTS HEADER
        ============================================ */
    .premium-announcements-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .premium-header-title h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--ju-blue);
        margin-bottom: 6px;
    }

    .premium-header-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--ju-gray-600);
        font-size: 0.95rem;
    }

    .premium-active-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        background: var(--ju-active-soft);
        color: var(--ju-active-dark);
        border-radius: var(--radius-full);
        font-weight: 700;
        font-size: 0.8rem;
        border: 1px solid rgba(139,92,246,0.3);
    }

    /* ============================================
           PREMIUM ANNOUNCEMENTS GRID - 3 CARDS PER ROW
           HORIZONTAL LAYOUT - EXACTLY LIKE NOTIFICATIONS
        ============================================ */
    .premium-announcements-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }

    @media (max-width: 1200px) {
        .premium-announcements-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .premium-announcements-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Premium Announcement Card - Horizontal Grid Card */
    .premium-announcement-card {
        background: white;
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--ju-gray-200);
        transition: var(--transition-bounce);
        height: 100%;
        display: flex;
        flex-direction: column;
        position: relative;
        border-left: 4px solid transparent;
        width: 100%;
    }

    .premium-announcement-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow);
        border-color: var(--ju-blue-soft);
    }

    .premium-announcement-card.event { border-left-color: var(--ju-event); }
    .premium-announcement-card.campus { border-left-color: var(--ju-campus); }
    .premium-announcement-card.general { border-left-color: var(--ju-general); }
    .premium-announcement-card.urgent { 
        border-left-color: var(--ju-urgent); 
        border-left-width: 6px;
        animation: premium-pulse 2s infinite;
    }

    @keyframes premium-pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(231, 76, 60, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(231, 76, 60, 0.1); }
    }

    .premium-card-header {
        padding: 24px 24px 16px;
        text-align: center;
    }

    .premium-card-icon {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin: 0 auto 16px;
        transition: var(--transition-bounce);
    }

    .premium-card-icon.event { background: linear-gradient(145deg, #3498db, #2980b9); }
    .premium-card-icon.campus { background: linear-gradient(145deg, #2ecc71, #27ae60); }
    .premium-card-icon.general { background: linear-gradient(145deg, #9b59b6, #8e44ad); }
    .premium-card-icon.urgent { background: linear-gradient(145deg, #e74c3c, #c0392b); }

    .premium-announcement-card:hover .premium-card-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .premium-card-body {
        padding: 0 24px 16px;
        flex: 1;
    }

    .premium-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--ju-gray-800);
        margin-bottom: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 50px;
    }

    .premium-card-title a {
        color: inherit;
        text-decoration: none;
        transition: var(--transition);
    }

    .premium-card-title a:hover {
        color: var(--ju-blue);
    }

    .premium-card-excerpt {
        color: var(--ju-gray-600);
        font-size: 0.85rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 16px;
        min-height: 60px;
    }

    .premium-card-meta {
        padding: 16px 24px;
        border-top: 1px solid var(--ju-gray-200);
        background: linear-gradient(180deg, var(--ju-gray-50), white);
    }

    .premium-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .premium-audience-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 700;
        background: var(--ju-info-soft);
        color: var(--ju-blue);
        border: 1px solid rgba(10,44,110,0.3);
    }

    .premium-views-count {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--ju-gray-500);
        font-size: 0.8rem;
    }

    .premium-views-count i {
        color: var(--ju-gold);
    }

    .premium-card-actions {
        display: flex;
        gap: 8px;
    }

    .premium-action-btn {
        width: 36px;
        height: 36px;
        border-radius: var(--radius);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: 1px solid var(--ju-gray-200);
        color: var(--ju-gray-600);
        transition: var(--transition-bounce);
        cursor: pointer;
        text-decoration: none;
    }

    .premium-action-btn:hover {
        background: var(--ju-blue);
        color: white;
        border-color: var(--ju-blue);
        transform: scale(1.1);
    }

    .premium-action-btn.warning:hover {
        background: var(--ju-warning);
        border-color: var(--ju-warning);
    }

    .premium-action-btn.danger:hover {
        background: var(--ju-danger);
        border-color: var(--ju-danger);
    }

    .card-status-badge {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 10;
    }

    .premium-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .premium-status-badge.draft {
        background: var(--ju-warning-soft);
        color: var(--ju-warning-dark);
        border: 1px solid rgba(245,158,11,0.3);
    }

    .premium-status-badge.expired {
        background: var(--ju-gray-200);
        color: var(--ju-gray-700);
        border: 1px solid var(--ju-gray-300);
    }

    .premium-expiration {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        color: var(--ju-gray-500);
        margin-top: 8px;
    }

    .premium-expiration i {
        color: var(--ju-gold);
    }

    /* ============================================
           LIST VIEW STYLES
        ============================================ */
    .premium-list-view {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .premium-list-item {
        background: white;
        border-radius: var(--radius-xl);
        padding: 24px;
        border: 1px solid var(--ju-gray-200);
        border-left: 4px solid transparent;
        transition: var(--transition-bounce);
    }

    .premium-list-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow);
        border-left-width: 6px;
    }

    .premium-list-item.event { border-left-color: var(--ju-event); }
    .premium-list-item.campus { border-left-color: var(--ju-campus); }
    .premium-list-item.general { border-left-color: var(--ju-general); }
    .premium-list-item.urgent { 
        border-left-color: var(--ju-urgent); 
        border-left-width: 6px;
        animation: premium-pulse 2s infinite;
    }

    .premium-list-row {
        display: flex;
        gap: 20px;
    }

    .premium-list-icon {
        width: 64px;
        height: 64px;
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: white;
        flex-shrink: 0;
    }

    .premium-list-icon.event { background: linear-gradient(145deg, #3498db, #2980b9); }
    .premium-list-icon.campus { background: linear-gradient(145deg, #2ecc71, #27ae60); }
    .premium-list-icon.general { background: linear-gradient(145deg, #9b59b6, #8e44ad); }
    .premium-list-icon.urgent { background: linear-gradient(145deg, #e74c3c, #c0392b); }

    .premium-list-content {
        flex: 1;
    }

    .premium-list-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--ju-gray-800);
        margin-bottom: 8px;
    }

    .premium-list-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        color: var(--ju-gray-500);
        font-size: 0.85rem;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .premium-list-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .premium-list-meta-item i {
        color: var(--ju-gold);
    }

    .premium-list-excerpt {
        color: var(--ju-gray-600);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    /* ============================================
           VIEW TOGGLE BUTTONS
        ============================================ */
    .premium-view-toggle {
        display: flex;
        gap: 8px;
    }

    .premium-view-btn {
        width: 44px;
        height: 44px;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--ju-gray-100);
        border: 1px solid var(--ju-gray-200);
        color: var(--ju-gray-600);
        transition: var(--transition-bounce);
        cursor: pointer;
    }

    .premium-view-btn.active {
        background: var(--ju-blue);
        color: white;
        border-color: var(--ju-blue);
    }

    .premium-view-btn:hover:not(.active) {
        background: var(--ju-blue-soft);
        color: var(--ju-blue);
        border-color: var(--ju-blue);
    }

    /* ============================================
           PREMIUM EMPTY STATE
        ============================================ */
    .premium-empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 40px;
        background: linear-gradient(145deg, white, var(--ju-gray-50));
        border-radius: var(--radius-xl);
        border: 2px dashed var(--ju-blue-soft);
    }

    .premium-empty-icon {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 24px;
    }

    .premium-empty-circle {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: rgba(10,44,110,0.08);
        animation: pulse-circle 2s infinite;
    }

    .premium-empty-icon i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 3rem;
        color: var(--ju-blue);
        z-index: 10;
    }

    @keyframes pulse-circle {
        0%, 100% { transform: scale(1); opacity: 0.3; }
        50% { transform: scale(1.1); opacity: 0.6; }
    }

    .premium-empty-title {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--ju-blue);
        margin-bottom: 12px;
    }

    .premium-empty-message {
        color: var(--ju-gray-600);
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto 24px;
    }

    .premium-empty-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 14px 32px;
        background: var(--ju-blue-gradient);
        color: white;
        border-radius: var(--radius-full);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition-bounce);
        box-shadow: 0 8px 20px rgba(10,44,110,0.25);
    }

    .premium-empty-btn:hover {
        background: var(--ju-blue-dark);
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(10,44,110,0.35);
    }

    /* ============================================
           PREMIUM PAGINATION
        ============================================ */
    .premium-pagination {
        padding: 24px 28px;
        border-top: 1px solid var(--ju-gray-200);
        background: linear-gradient(180deg, var(--ju-gray-50), white);
        margin-top: 32px;
        border-radius: var(--radius-xl);
    }

    .premium-pagination .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin: 0;
    }

    .premium-pagination .page-link {
        padding: 12px 20px;
        border: 2px solid var(--ju-gray-200);
        border-radius: var(--radius);
        color: var(--ju-gray-700);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        background: white;
        transition: var(--transition);
    }

    .premium-pagination .page-item.active .page-link {
        background: var(--ju-blue);
        color: white;
        border-color: var(--ju-blue);
        box-shadow: 0 8px 16px rgba(10,44,110,0.2);
    }

    .premium-pagination .page-link:hover:not(.active) {
        background: rgba(10,44,110,0.08);
        border-color: var(--ju-blue);
        color: var(--ju-blue);
        transform: translateY(-2px);
    }

    /* ============================================
           PREMIUM TOAST NOTIFICATIONS
        ============================================ */
    .premium-toast {
        position: fixed;
        bottom: 32px;
        right: 32px;
        padding: 16px 24px;
        background: white;
        border-left: 4px solid;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 16px;
        z-index: 9999;
        animation: slideInRight 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        border: 1px solid var(--ju-gray-200);
    }

    .premium-toast-success {
        border-left-color: var(--ju-published);
    }

    .premium-toast-info {
        border-left-color: var(--ju-blue);
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* ============================================
           RESPONSIVE ADJUSTMENTS
        ============================================ */
    @media (max-width: 992px) {
        .premium-filters-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .premium-filter-groups {
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }
        
        .premium-filter-group {
            width: 100%;
            flex-wrap: wrap;
        }
        
        .premium-header-actions-compact {
            width: 100%;
            justify-content: flex-start;
        }

        .premium-list-row {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid">
    <!-- ============================================
           VIBRANT COLORFUL STAT CARDS - BOLD & PREMIUM
           EXACTLY LIKE NOTIFICATIONS PAGE
        ============================================ -->
    @if(auth()->check() && auth()->user()->hasPermission('view_announcement_stats'))
    <div class="premium-stats-grid" data-aos="fade-up" data-aos-duration="800">
        <!-- Total Announcements - VIBRANT BLUE -->
        <div class="premium-stat-card total" data-aos="zoom-in" data-aos-delay="100">
            <div class="premium-stat-icon">
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="premium-stat-number">{{ $stats['totalAnnouncements'] }}</div>
            <div class="premium-stat-label">Total Announcements</div>
            <div class="premium-stat-subtext">All time</div>
        </div>
        
        <!-- Published - VIBRANT GREEN -->
        <div class="premium-stat-card published" data-aos="zoom-in" data-aos-delay="200">
            <div class="premium-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="premium-stat-number">{{ $stats['publishedAnnouncements'] }}</div>
            <div class="premium-stat-label">Published</div>
            <div class="premium-stat-subtext">{{ $stats['totalAnnouncements'] > 0 ? round(($stats['publishedAnnouncements'] / $stats['totalAnnouncements']) * 100) : 0 }}% of total</div>
        </div>
        
        <!-- Active - VIBRANT PURPLE -->
        <div class="premium-stat-card active" data-aos="zoom-in" data-aos-delay="300">
            <div class="premium-stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="premium-stat-number">{{ $stats['activeAnnouncements'] }}</div>
            <div class="premium-stat-label">Active</div>
            <div class="premium-stat-subtext">Currently available</div>
        </div>
        
        <!-- Total Views - VIBRANT GOLD/ORANGE -->
        <div class="premium-stat-card views" data-aos="zoom-in" data-aos-delay="400">
            <div class="premium-stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="premium-stat-number">{{ number_format($stats['totalViews']) }}</div>
            <div class="premium-stat-label">Total Views</div>
            <div class="premium-stat-subtext">Across all announcements</div>
        </div>
    </div>
    @endif

    <!-- ============================================
           PREMIUM HEADER FILTERS - Clean & Compact
        ============================================ -->
    <div class="premium-filters-header" data-aos="fade-up" data-aos-duration="800">
        <div class="premium-filter-groups">
            <!-- Search Filter -->
            <div class="premium-filter-group">
                <span class="premium-filter-label">
                    <i class="fas fa-search"></i>
                    Search:
                </span>
                <div class="premium-filter-badges">
                    <div style="position: relative;">
                        <input type="text" id="premiumSearchInput" class="form-control" 
                               placeholder="Search announcements..." 
                               value="{{ request('search') }}"
                               style="width: 200px; padding: 6px 16px; border: 1px solid var(--ju-gray-200); border-radius: var(--radius-full); font-size: 0.85rem;">
                        <i class="fas fa-search" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: var(--ju-gray-400);"></i>
                    </div>
                </div>
            </div>

            <!-- Type Filter - Compact with Icons -->
            <div class="premium-filter-group">
                <span class="premium-filter-label">
                    <i class="fas fa-tag"></i>
                    Type:
                </span>
                <div class="premium-filter-badges">
                    <a href="{{ request()->fullUrlWithQuery(['type' => '', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ !request('type') ? 'active' : '' }}">
                        All
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['type' => 'general', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('type') == 'general' ? 'active' : '' }}">
                        <i class="fas fa-bullhorn"></i>
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['type' => 'event', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('type') == 'event' ? 'active' : '' }}">
                        <i class="fas fa-calendar"></i>
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['type' => 'campus', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('type') == 'campus' ? 'active' : '' }}">
                        <i class="fas fa-university"></i>
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['type' => 'urgent', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('type') == 'urgent' ? 'active' : '' }}">
                        <i class="fas fa-exclamation-triangle"></i>
                    </a>
                </div>
            </div>

            <!-- Audience Filter - For Admins -->
            @if(auth()->check() && auth()->user()->hasPermission('manage_announcements'))
            <div class="premium-filter-group">
                <span class="premium-filter-label">
                    <i class="fas fa-users"></i>
                    Audience:
                </span>
                <div class="premium-filter-badges">
                    <a href="{{ request()->fullUrlWithQuery(['audience' => '', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ !request('audience') ? 'active' : '' }}">
                        All
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['audience' => 'all', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('audience') == 'all' ? 'active' : '' }}">
                        Everyone
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['audience' => 'students', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('audience') == 'students' ? 'active' : '' }}">
                        Students
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['audience' => 'faculty', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('audience') == 'faculty' ? 'active' : '' }}">
                        Faculty
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['audience' => 'staff', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('audience') == 'staff' ? 'active' : '' }}">
                        Staff
                    </a>
                </div>
            </div>
            @endif

            <!-- Status Filter - For Admins -->
            @if(auth()->check() && auth()->user()->hasPermission('manage_announcements'))
            <div class="premium-filter-group">
                <span class="premium-filter-label">
                    <i class="fas fa-flag"></i>
                    Status:
                </span>
                <div class="premium-filter-badges">
                    <a href="{{ request()->fullUrlWithQuery(['status' => '', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ !request('status') ? 'active' : '' }}">
                        All
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'published', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('status') == 'published' ? 'active' : '' }}">
                        Published
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'draft', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('status') == 'draft' ? 'active' : '' }}">
                        Draft
                    </a>
                </div>
            </div>
            @endif

            <!-- Expiration Filter - Compact -->
            <div class="premium-filter-group">
                <span class="premium-filter-label">
                    <i class="fas fa-clock"></i>
                    Expiration:
                </span>
                <div class="premium-filter-badges">
                    <a href="{{ request()->fullUrlWithQuery(['expired' => '', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ !request('expired') ? 'active' : '' }}">
                        All
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['expired' => 'no', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('expired') == 'no' ? 'active' : '' }}">
                        Active
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['expired' => 'yes', 'page' => 1]) }}" 
                       class="premium-filter-badge {{ request('expired') == 'yes' ? 'active' : '' }}">
                        Expired
                    </a>
                </div>
            </div>
        </div>

        <!-- Compact Action Buttons -->
        <div class="premium-header-actions-compact">
            @if(request()->hasAny(['search', 'type', 'audience', 'status', 'expired']))
            <a href="{{ route('announcements.index') }}" class="premium-header-btn-sm premium-header-btn-sm-outline">
                <i class="fas fa-times"></i>
                <span>Clear</span>
            </a>
            @endif
            
            @can('create_announcements')
            <a href="{{ route('announcements.create') }}" class="premium-header-btn-sm premium-header-btn-sm-primary">
                <i class="fas fa-plus-circle"></i>
                <span>Create</span>
            </a>
            @endcan
        </div>
    </div>

    <!-- ============================================
           PREMIUM ANNOUNCEMENTS HEADER
        ============================================ -->
    <div class="premium-announcements-header" data-aos="fade-left" data-aos-duration="800">
        <div class="premium-header-title">
            <h3>All Announcements</h3>
            <div class="premium-header-meta">
                <span>Showing <strong>{{ $announcements->firstItem() }}-{{ $announcements->lastItem() }}</strong> of <strong>{{ $announcements->total() }}</strong> announcements</span>
                @if(isset($stats['activeAnnouncements']) && $stats['activeAnnouncements'] > 0)
                <span class="premium-active-badge">
                    <i class="fas fa-circle"></i> {{ $stats['activeAnnouncements'] }} active
                </span>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2">
            <!-- View Toggle -->
            <div class="premium-view-toggle">
                <button type="button" class="premium-view-btn active" id="gridViewBtn" title="Grid View">
                    <i class="fas fa-th-large"></i>
                </button>
                <button type="button" class="premium-view-btn" id="listViewBtn" title="List View">
                    <i class="fas fa-list"></i>
                </button>
            </div>

            <!-- Sort Dropdown -->
            <div class="dropdown">
                <button class="premium-header-btn-sm premium-header-btn-sm-outline dropdown-toggle" type="button"
                        data-bs-toggle="dropdown">
                    <i class="fas fa-sort me-1"></i>Sort
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest First</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}">Oldest First</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'views']) }}">Most Viewed</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'urgent']) }}">Urgent First</a></li>
                </ul>
            </div>

            @can('view_announcement_stats')
            <a href="{{ route('announcements.statistics') }}" class="premium-header-btn-sm premium-header-btn-sm-outline">
                <i class="fas fa-chart-bar"></i>
            </a>
            @endcan

            @if(auth()->check() && auth()->user()->hasPermission('manage_announcements'))
            <button class="premium-header-btn-sm premium-header-btn-sm-outline" onclick="exportAnnouncements()">
                <i class="fas fa-download"></i>
            </button>
            @endif
        </div>
    </div>

    <!-- ============================================
           PREMIUM ANNOUNCEMENTS GRID
           3 CARDS PER ROW - HORIZONTAL LAYOUT
           EXACTLY LIKE NOTIFICATIONS PAGE
        ============================================ -->
    <div id="premiumAnnouncementsContainer">
        @if($announcements->count() > 0)
        <div class="premium-announcements-grid">
            @foreach($announcements as $announcement)
            <div class="premium-announcement-card {{ $announcement->type }}"
                 data-aos="fade-up" 
                 data-aos-delay="{{ ($loop->index % 3) * 50 }}"
                 data-aos-duration="600">
                
                @if(!$announcement->is_published)
                <div class="card-status-badge">
                    <span class="premium-status-badge draft">
                        <i class="fas fa-clock"></i> Draft
                    </span>
                </div>
                @endif

                @if($announcement->expires_at && $announcement->expires_at->isPast())
                <div class="card-status-badge">
                    <span class="premium-status-badge expired">
                        <i class="fas fa-history"></i> Expired
                    </span>
                </div>
                @endif

                <div class="premium-card-header">
                    <div class="premium-card-icon {{ $announcement->type }}">
                        @switch($announcement->type)
                        @case('event')
                        <i class="fas fa-calendar-alt"></i>
                        @break
                        @case('campus')
                        <i class="fas fa-university"></i>
                        @break
                        @case('urgent')
                        <i class="fas fa-exclamation-triangle"></i>
                        @break
                        @default
                        <i class="fas fa-bullhorn"></i>
                        @endswitch
                    </div>
                </div>

                <div class="premium-card-body">
                    <h5 class="premium-card-title">
                        <a href="{{ route('announcements.show', $announcement) }}">
                            {{ Str::limit($announcement->title, 60) }}
                        </a>
                    </h5>
                    
                    <p class="premium-card-excerpt">
                        {{ strip_tags(Str::limit($announcement->content, 100)) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="premium-audience-badge">
                            <i class="fas fa-users"></i>
                            {{ $announcement->getAudienceLabel() }}
                        </span>
                        <span class="premium-views-count">
                            <i class="fas fa-eye"></i> {{ number_format($announcement->views) }}
                        </span>
                    </div>
                </div>

                <div class="premium-card-meta">
                    <div class="premium-card-footer">
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>
                                {{ $announcement->creator->name ?? 'System' }}
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $announcement->created_at->format('M d, Y') }}
                            </small>
                        </div>

                        <div class="premium-card-actions">
                            <a href="{{ route('announcements.show', $announcement) }}" 
                               class="premium-action-btn" 
                               title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            @can('update', $announcement)
                            <a href="{{ route('announcements.edit', $announcement) }}" 
                               class="premium-action-btn warning" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan

                            @can('delete', $announcement)
                            <form action="{{ route('announcements.destroy', $announcement) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="premium-action-btn danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>

                    @if($announcement->expires_at)
                    <div class="premium-expiration">
                        <i class="fas fa-clock"></i>
                        Expires: {{ $announcement->expires_at->format('M d, Y') }}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Premium Empty State -->
        <div class="premium-empty-state" data-aos="zoom-in" data-aos-duration="600">
            <div class="premium-empty-icon">
                <div class="premium-empty-circle"></div>
                <i class="fas fa-bullhorn"></i>
            </div>
            <h4 class="premium-empty-title">No Announcements Found</h4>
            <p class="premium-empty-message">
                @if(request()->hasAny(['search', 'type', 'audience', 'status', 'expired']))
                Try adjusting your filters or search terms.
                @else
                There are no announcements available at the moment.
                @endif
            </p>
            @can('create_announcements')
            <a href="{{ route('announcements.create') }}" class="premium-empty-btn">
                <i class="fas fa-plus-circle"></i>
                <span>Create First Announcement</span>
            </a>
            @endcan
        </div>
        @endif
    </div>

    <!-- ============================================
           PREMIUM PAGINATION
        ============================================ -->
    @if($announcements->hasPages())
    <div class="premium-pagination">
        {{ $announcements->withQueryString()->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
    </div>
    @endif
</div>

<!-- Export Modal -->
@if(auth()->check() && auth()->user()->hasPermission('manage_announcements'))
<div class="modal fade" id="premiumExportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: var(--radius-xl); border: none; box-shadow: var(--shadow-lg);">
            <div class="modal-header" style="background: linear-gradient(145deg, var(--ju-blue), var(--ju-blue-dark)); border-bottom: none; padding: 20px 24px;">
                <h5 class="modal-title text-white">
                    <i class="fas fa-download me-2"></i>Export Announcements
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 28px;">
                <div class="alert alert-info d-flex align-items-center gap-3 mb-4" style="background: var(--ju-info-soft); border: 1px solid rgba(10,44,110,0.15); border-radius: var(--radius-lg);">
                    <i class="fas fa-info-circle fa-lg" style="color: var(--ju-gold);"></i>
                    <div>
                        <strong style="color: var(--ju-blue);">Export feature coming soon!</strong><br>
                        <span style="color: var(--ju-gray-600);">This feature is currently under development. You can view statistics from the Statistics page.</span>
                    </div>
                </div>
                <div class="text-center">
                    <a href="{{ route('announcements.statistics') }}" class="premium-header-btn-sm premium-header-btn-sm-primary" style="padding: 12px 28px;">
                        <i class="fas fa-chart-bar me-2"></i>View Statistics
                    </a>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--ju-gray-200); padding: 20px 24px;">
                <button type="button" class="premium-header-btn-sm premium-header-btn-sm-outline" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Premium Toast Container -->
<div id="premiumToastContainer" style="position: fixed; bottom: 32px; right: 32px; z-index: 9999;"></div>

<!-- AOS Animation Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // ============================================
    // PREMIUM ANNOUNCEMENT FUNCTIONS
    // ============================================
    
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true,
        offset: 20,
        easing: 'ease-in-out-cubic'
    });

    // View Toggle
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const container = document.getElementById('premiumAnnouncementsContainer');
    let currentAnnouncements = @json($announcements->items());

    function setGridView() {
        // Show grid view
        container.innerHTML = '<div class="premium-announcements-grid"></div>';
        const gridContainer = container.querySelector('.premium-announcements-grid');
        
        currentAnnouncements.forEach((announcement, index) => {
            const card = createGridCard(announcement, index);
            gridContainer.appendChild(card);
        });
        
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
        localStorage.setItem('announcementView', 'grid');
        showToast('Switched to grid view', 'info');
    }

    function setListView() {
        // Show list view
        container.innerHTML = '<div class="premium-list-view"></div>';
        const listContainer = container.querySelector('.premium-list-view');
        
        currentAnnouncements.forEach((announcement, index) => {
            const item = createListItem(announcement, index);
            listContainer.appendChild(item);
        });
        
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
        localStorage.setItem('announcementView', 'list');
        showToast('Switched to list view', 'info');
    }

    function createGridCard(announcement, index) {
        const card = document.createElement('div');
        card.className = `premium-announcement-card ${announcement.type}`;
        card.setAttribute('data-aos', 'fade-up');
        card.setAttribute('data-aos-delay', (index % 3) * 50);
        card.setAttribute('data-aos-duration', '600');
        
        let statusBadge = '';
        if (!announcement.is_published) {
            statusBadge = `<div class="card-status-badge"><span class="premium-status-badge draft"><i class="fas fa-clock"></i> Draft</span></div>`;
        } else if (announcement.expires_at && new Date(announcement.expires_at) < new Date()) {
            statusBadge = `<div class="card-status-badge"><span class="premium-status-badge expired"><i class="fas fa-history"></i> Expired</span></div>`;
        }
        
        let icon = 'fa-bullhorn';
        if (announcement.type === 'event') icon = 'fa-calendar-alt';
        else if (announcement.type === 'campus') icon = 'fa-university';
        else if (announcement.type === 'urgent') icon = 'fa-exclamation-triangle';
        
        let audienceLabel = 'Everyone';
        if (announcement.audience === 'students') audienceLabel = 'Students';
        else if (announcement.audience === 'faculty') audienceLabel = 'Faculty';
        else if (announcement.audience === 'staff') audienceLabel = 'Staff';
        
        let expirationHtml = '';
        if (announcement.expires_at) {
            expirationHtml = `<div class="premium-expiration"><i class="fas fa-clock"></i> Expires: ${new Date(announcement.expires_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</div>`;
        }
        
        card.innerHTML = `
            ${statusBadge}
            <div class="premium-card-header">
                <div class="premium-card-icon ${announcement.type}">
                    <i class="fas ${icon}"></i>
                </div>
            </div>
            <div class="premium-card-body">
                <h5 class="premium-card-title">
                    <a href="/announcements/${announcement.id}">${announcement.title.length > 60 ? announcement.title.substring(0, 60) + '...' : announcement.title}</a>
                </h5>
                <p class="premium-card-excerpt">${announcement.content.replace(/<[^>]*>/g, '').substring(0, 100)}...</p>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="premium-audience-badge">
                        <i class="fas fa-users"></i> ${audienceLabel}
                    </span>
                    <span class="premium-views-count">
                        <i class="fas fa-eye"></i> ${announcement.views.toLocaleString()}
                    </span>
                </div>
            </div>
            <div class="premium-card-meta">
                <div class="premium-card-footer">
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i> ${announcement.creator?.name || 'System'}
                        </small>
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i> ${new Date(announcement.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                        </small>
                    </div>
                    <div class="premium-card-actions">
                        <a href="/announcements/${announcement.id}" class="premium-action-btn" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        @can('update', $announcement)
                        <a href="/announcements/${announcement.id}/edit" class="premium-action-btn warning" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endcan
                        @can('delete', $announcement)
                        <form action="/announcements/${announcement.id}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="premium-action-btn danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
                ${expirationHtml}
            </div>
        `;
        
        return card;
    }

    function createListItem(announcement, index) {
        const item = document.createElement('div');
        item.className = `premium-list-item ${announcement.type}`;
        
        let icon = 'fa-bullhorn';
        if (announcement.type === 'event') icon = 'fa-calendar-alt';
        else if (announcement.type === 'campus') icon = 'fa-university';
        else if (announcement.type === 'urgent') icon = 'fa-exclamation-triangle';
        
        let audienceLabel = 'Everyone';
        if (announcement.audience === 'students') audienceLabel = 'Students';
        else if (announcement.audience === 'faculty') audienceLabel = 'Faculty';
        else if (announcement.audience === 'staff') audienceLabel = 'Staff';
        
        let statusBadge = '';
        if (!announcement.is_published) {
            statusBadge = `<span class="premium-status-badge draft"><i class="fas fa-clock"></i> Draft</span>`;
        } else if (announcement.expires_at && new Date(announcement.expires_at) < new Date()) {
            statusBadge = `<span class="premium-status-badge expired"><i class="fas fa-history"></i> Expired</span>`;
        }
        
        let expirationHtml = '';
        if (announcement.expires_at) {
            expirationHtml = `<span class="premium-expiration"><i class="fas fa-clock"></i> Expires: ${new Date(announcement.expires_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</span>`;
        }
        
        item.innerHTML = `
            <div class="premium-list-row">
                <div class="premium-list-icon ${announcement.type}">
                    <i class="fas ${icon}"></i>
                </div>
                <div class="premium-list-content">
                    <div class="premium-announcement-header">
                        <div class="premium-announcement-title-wrapper">
                            <h5 class="premium-list-title">
                                <a href="/announcements/${announcement.id}">${announcement.title}</a>
                            </h5>
                            ${statusBadge}
                        </div>
                    </div>
                    <div class="premium-list-meta">
                        <span class="premium-list-meta-item">
                            <i class="fas fa-user"></i> ${announcement.creator?.name || 'System'}
                        </span>
                        <span class="premium-list-meta-item">
                            <i class="fas fa-calendar"></i> ${new Date(announcement.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                        </span>
                        <span class="premium-views-count">
                            <i class="fas fa-eye"></i> ${announcement.views.toLocaleString()} views
                        </span>
                        <span class="premium-audience-badge">
                            <i class="fas fa-users"></i> ${audienceLabel}
                        </span>
                    </div>
                    <div class="premium-list-excerpt">
                        ${announcement.content.replace(/<[^>]*>/g, '').substring(0, 200)}...
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        ${expirationHtml}
                        <div class="premium-card-actions">
                            <a href="/announcements/${announcement.id}" class="premium-action-btn" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('update', $announcement)
                            <a href="/announcements/${announcement.id}/edit" class="premium-action-btn warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('delete', $announcement)
                            <form action="/announcements/${announcement.id}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="premium-action-btn danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        return item;
    }

    gridViewBtn.addEventListener('click', setGridView);
    listViewBtn.addEventListener('click', setListView);

    // Load saved view preference
    const savedView = localStorage.getItem('announcementView');
    if (savedView === 'list') {
        setListView();
    }

    // Search functionality with debounce
    const searchInput = document.getElementById('premiumSearchInput');
    let searchTimeout;

    function performSearch() {
        const params = new URLSearchParams(window.location.search);
        const searchTerm = searchInput.value.trim();
        
        if (searchTerm) {
            params.set('search', searchTerm);
        } else {
            params.delete('search');
        }
        params.delete('page');
        
        window.location.href = window.location.pathname + '?' + params.toString();
    }

    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 500);
    });

    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            clearTimeout(searchTimeout);
            performSearch();
        }
    });

    // Export function
    function exportAnnouncements() {
        const exportModal = new bootstrap.Modal(document.getElementById('premiumExportModal'));
        exportModal.show();
    }

    // Show Toast
    function showToast(message, type = 'success') {
        const container = document.getElementById('premiumToastContainer');
        const toast = document.createElement('div');
        toast.className = `premium-toast premium-toast-${type}`;
        
        let icon = 'check-circle';
        if (type === 'info') icon = 'info-circle';
        
        toast.innerHTML = `
            <div class="premium-toast-icon" style="color: ${type === 'success' ? 'var(--ju-published)' : 'var(--ju-blue)'}">
                <i class="fas fa-${icon}"></i>
            </div>
            <div class="premium-toast-content">
                ${message}
            </div>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.transition = 'all 0.3s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Filter button active state persistence
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.premium-filter-badge');
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                const parent = this.closest('.premium-filter-badges');
                if (parent) {
                    parent.querySelectorAll('.premium-filter-badge').forEach(b => {
                        b.classList.remove('active');
                    });
                }
                this.classList.add('active');
            });
        });
    });
</script>

<!-- Add AOS CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endsection

@push('styles')
<style>
    /* Override any remaining old styles */
    .ju-card, .ju-card-header, .ju-card-body, .ju-card-title,
    .ju-card-footer, .stat-card, .filter-sidebar,
    .btn-outline-primary, .btn-outline-secondary, .btn-outline-warning, .btn-outline-info, .btn-outline-danger,
    .announcement-card, .announcement-meta, .status-badge, .audience-badge {
        display: none !important;
    }
    
    .notification-filter, .filter-sidebar {
        display: none !important;
    }

    .dropdown-menu {
        border: 1px solid var(--ju-gray-200);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow);
        padding: 8px;
    }

    .dropdown-item {
        border-radius: var(--radius);
        padding: 10px 16px;
        font-size: 0.9rem;
        color: var(--ju-gray-700);
        transition: var(--transition);
    }

    .dropdown-item:hover {
        background: var(--ju-blue-soft);
        color: var(--ju-blue);
    }

    .dropdown-item i {
        color: var(--ju-gold);
        margin-right: 8px;
    }

    .dropdown-toggle::after {
        display: none;
    }

    .form-control:focus {
        border-color: var(--ju-blue);
        box-shadow: 0 0 0 4px rgba(10,44,110,0.1);
        outline: none;
    }
</style>
@endpush