<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Comet') - Sistem Peminjaman Ruangan</title>
    
    <!-- CSS Files -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #39C5BB;
            --secondary-color: #1A3A5C;
            --accent-color: #78E3DC;
            --accent-light: #A8E6E3;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #2e3440;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 70px;
            --star-color: #FFD700;
            --text-light: #F5F3F0;
            --card-bg: rgba(255, 255, 255, 0.95);
            --border-color: rgba(57, 197, 187, 0.15);
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Noto Sans JP', sans-serif;
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            font-size: 0.9rem;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            color: var(--dark-color);
        }

        /* Subtle Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(57, 197, 187, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(120, 227, 220, 0.03) 0%, transparent 50%);
            z-index: -1;
        }

        /* Minimal Stars */
        .stars-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        }

        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--star-color);
            border-radius: 50%;
            opacity: 0.2;
            animation: twinkle 4s infinite;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.4; }
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar .sidebar-brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar .sidebar-brand h3 {
            color: var(--text-light);
            font-weight: 600;
            margin: 0;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .sidebar .sidebar-brand h3::before {
            content: '⭐';
            font-size: 0.9rem;
        }

        .sidebar.collapsed .sidebar-brand h3 span {
            display: none;
        }

        .sidebar .nav-section {
            padding: 0.5rem 0;
        }

        .sidebar .nav-section-title {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.5rem 1.5rem;
            margin-top: 1rem;
            font-weight: 600;
        }

        .sidebar .nav-item {
            margin: 0.125rem 0.75rem;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            font-weight: 500;
            text-decoration: none;
            border-radius: 0.5rem;
        }

        .sidebar .nav-link:hover {
            color: var(--text-light);
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(3px);
        }

        .sidebar .nav-link.active {
            color: var(--text-light);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: inset 3px 0 0 var(--accent-color);
        }

        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 0.75rem;
            transition: transform 0.2s ease;
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 0.75rem;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .sidebar.collapsed .nav-link span,
        .sidebar.collapsed .nav-section-title {
            display: none;
        }

        /* User Section */
        .sidebar .user-section {
            margin-top: auto;
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .user-info {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }

        .sidebar .user-info:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--accent-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 0.75rem;
            font-size: 0.875rem;
        }

        .sidebar .user-details {
            flex: 1;
        }

        .sidebar .user-name {
            color: var(--text-light);
            font-weight: 500;
            font-size: 0.875rem;
            margin: 0;
        }

        .sidebar .user-role {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            margin: 0;
        }

        .sidebar.collapsed .user-info {
            justify-content: center;
        }

        .sidebar.collapsed .user-details {
            display: none;
        }

        .sidebar .logout-btn {
            width: 100%;
            padding: 0.5rem;
            background: rgba(231, 74, 59, 0.1);
            border: 1px solid rgba(231, 74, 59, 0.2);
            color: rgba(255, 255, 255, 0.8);
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .sidebar .logout-btn:hover {
            background: rgba(231, 74, 59, 0.2);
            color: white;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top Bar */
        .topbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 999;
            border-bottom: 1px solid var(--border-color);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--secondary-color);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .topbar .sidebar-toggle:hover {
            background-color: var(--light-color);
            color: var(--primary-color);
        }

        .breadcrumb-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--secondary-color);
            font-size: 0.875rem;
        }

        .breadcrumb-container .breadcrumb-separator {
            color: var(--secondary-color);
            opacity: 0.5;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .topbar .user-info {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            background: var(--light-color);
            border-radius: 2rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .topbar .user-info:hover {
            background: var(--border-color);
        }

        .topbar .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 0.75rem;
            font-size: 0.875rem;
        }

        .topbar .user-details {
            text-align: right;
        }

        .topbar .user-name {
            font-weight: 600;
            font-size: 0.875rem;
            margin: 0;
            line-height: 1.2;
        }

        .topbar .user-role {
            color: var(--secondary-color);
            font-size: 0.75rem;
            margin: 0;
            text-transform: capitalize;
        }

        /* Content Area */
        .content {
            padding: 2rem;
            flex: 1;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-title::before {
            content: '';
            width: 4px;
            height: 28px;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--accent-color) 100%);
            border-radius: 2px;
        }

        .page-subtitle {
            color: var(--secondary-color);
            opacity: 0.7;
            margin: 0;
            font-size: 0.95rem;
        }

        /* Card Styles */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.2s ease;
            background: white;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--light-color) 0%, white 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--secondary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.375rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.2s ease;
        }
        
        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }
        
        .status-menunggu { 
            background: rgba(246, 194, 62, 0.1); 
            color: #856404; 
            border: 1px solid rgba(246, 194, 62, 0.2);
        }
        .status-disetujui { 
            background: rgba(28, 200, 138, 0.1); 
            color: #0a5d3a; 
            border: 1px solid rgba(28, 200, 138, 0.2);
        }
        .status-ditolak { 
            background: rgba(231, 74, 59, 0.1); 
            color: #8b2618; 
            border: 1px solid rgba(231, 74, 59, 0.2);
        }
        .status-selesai { 
            background: rgba(57, 197, 187, 0.1); 
            color: #0a5d3a; 
            border: 1px solid rgba(57, 197, 187, 0.2);
        }

        /* Button Styles */
        .btn {
            border-radius: 0.375rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .btn-outline-primary {
            background: transparent;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: 0.75rem;
            box-shadow: var(--shadow-sm);
        }

        .table {
            margin-bottom: 0;
            min-width: 800px;
        }

        .table thead th {
            border-top: none;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
            color: var(--secondary-color);
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            padding: 1rem 0.75rem;
            background: var(--light-color);
            white-space: nowrap;
        }

        .table tbody td {
            padding: 0.875rem 0.75rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: var(--light-color);
        }

        /* Form Styles */
        .form-control, .form-select {
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 0.625rem 0.875rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(57, 197, 187, 0.15);
        }

        .form-label {
            font-weight: 500;
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 0.5rem;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: rgba(28, 200, 138, 0.1);
            color: #0a5d3a;
            border: 1px solid rgba(28, 200, 138, 0.2);
        }

        .alert-danger {
            background: rgba(231, 74, 59, 0.1);
            color: #8b2618;
            border: 1px solid rgba(231, 74, 59, 0.2);
        }

        /* Stat Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
            position: relative;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--accent-color) 100%);
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-icon.primary {
            background: rgba(57, 197, 187, 0.1);
            color: var(--primary-color);
        }

        .stat-icon.success {
            background: rgba(28, 200, 138, 0.1);
            color: var(--success-color);
        }

        .stat-icon.warning {
            background: rgba(246, 194, 62, 0.1);
            color: var(--warning-color);
        }

        .stat-icon.danger {
            background: rgba(231, 74, 59, 0.1);
            color: var(--danger-color);
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--secondary-color);
            margin: 0;
        }

        .stat-label {
            color: var(--secondary-color);
            opacity: 0.7;
            font-size: 0.875rem;
            margin: 0.25rem 0 0 0;
        }

        /* Mobile Sidebar Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .content {
                padding: 1.5rem;
            }
            .page-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .content {
                padding: 1rem;
            }
            
            .topbar {
                padding: 0.75rem 1rem;
            }
            
            .breadcrumb-container {
                display: none;
            }
            
            .topbar .user-details {
                display: none;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .page-title {
                font-size: 1.25rem;
            }
            
            .card-header {
                padding: 0.75rem 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .table thead th {
                font-size: 0.75rem;
                padding: 0.75rem 0.5rem;
            }
            
            .table tbody td {
                font-size: 0.8125rem;
                padding: 0.75rem 0.5rem;
            }
            
            .btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.8125rem;
            }
            
            .form-control, .form-select {
                padding: 0.5rem 0.75rem;
                font-size: 0.8125rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .stat-value {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .topbar .sidebar-toggle {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
            }
            
            .topbar .user-avatar {
                width: 32px;
                height: 32px;
                margin-right: 0.5rem;
            }
            
            .status-badge {
                padding: 0.25rem 0.5rem;
                font-size: 0.6875rem;
            }
            
            .page-header {
                margin-bottom: 1.5rem;
            }
            
            .page-title {
                font-size: 1.125rem;
            }
            
            .page-subtitle {
                font-size: 0.875rem;
            }
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid var(--border-color);
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Utilities */
        .text-muted {
            color: var(--secondary-color) !important;
            opacity: 0.7 !important;
        }

        .mb-0 { margin-bottom: 0 !important; }
        .mt-3 { margin-top: 1rem !important; }
        .mt-4 { margin-top: 1.5rem !important; }
    </style>
</head>
<body>
    <!-- Minimal Stars Background -->
    <div class="stars-container" id="starsContainer"></div>
    
    @auth
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <h3><span>COMET</span></h3>
            </div>
            
            <ul class="nav flex-column">
                <!-- Main Navigation -->
                <div class="nav-section">
                    <div class="nav-section-title">Menu Utama</div>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Data Peminjaman</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('jadwal.index') ? 'active' : '' }}" href="{{ route('jadwal.index') }}">
                            <i class="fas fa-calendar-week"></i>
                            <span>Jadwal</span>
                        </a>
                    </li>
                </div>

                <!-- Admin/Petugas Navigation -->
                @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                    <div class="nav-section">
                        <div class="nav-section-title">Manajemen</div>
                        
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <i class="fas fa-users-cog"></i>
                                    <span>Manajemen User</span>
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('ruangan.*') ? 'active' : '' }}" href="{{ route('ruangan.index') }}">
                                <i class="fas fa-door-closed"></i>
                                <span>Data Ruangan</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('jadwal_reguler.*') ? 'active' : '' }}" href="{{ route('jadwal_reguler.index') }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Jadwal Reguler</span>
                            </a>
                        </li>
                        
                        @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                                    <i class="fas fa-file-excel"></i>
                                    <span>Laporan</span>
                                </a>
                            </li>
                        @endif
                    </div>
                @endif

                <!-- User Actions -->
                @if(auth()->user()->isPeminjam())
                    <div class="nav-section">
                        <div class="nav-section-title">Aksi</div>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('peminjaman.create') ? 'active' : '' }}" href="{{ route('peminjaman.create') }}">
                                <i class="fas fa-plus-circle"></i>
                                <span>Ajukan Peminjaman</span>
                            </a>
                        </li>
                    </div>
                @endif
            </ul>

            <!-- User Section -->
            <div class="user-section">
                <div class="user-info">
                    <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div class="user-details">
                        <p class="user-name">{{ auth()->user()->name }}</p>
                        <p class="user-role">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content" id="main-content">
            <!-- Top Bar -->
            <div class="topbar">
                <div class="topbar-left">
                    <button class="sidebar-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="breadcrumb-container">
                        <span>Dashboard</span>
                        <span class="breadcrumb-separator">/</span>
                        <span>{{ request()->route()->getName() }}</span>
                    </div>
                </div>
                <div class="topbar-right">
                    <div class="user-info">
                        <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                        <div class="user-details">
                            <p class="user-name">{{ auth()->user()->name }}</p>
                            <p class="user-role">{{ ucfirst(auth()->user()->role) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    @else
        @yield('content')
    @endauth

    <!-- JavaScript Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 600,
            once: true,
            offset: 100
        });
        
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        // Function to handle sidebar toggle for desktop
        function toggleSidebarDesktop() {
            if (window.innerWidth > 768) {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            } else {
                toggleSidebarMobile();
            }
        }
        
        // Function to handle sidebar toggle for mobile
        function toggleSidebarMobile() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }
        
        // Event listener for sidebar toggle
        sidebarToggle.addEventListener('click', toggleSidebarDesktop);
        
        // Event listener for sidebar overlay click
        sidebarOverlay.addEventListener('click', toggleSidebarMobile);
        
        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
        
        // Create Minimal Stars
        const starsContainer = document.getElementById('starsContainer');
        for (let i = 0; i < 30; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            star.style.left = `${Math.random() * 100}%`;
            star.style.top = `${Math.random() * 100}%`;
            star.style.animationDelay = `${Math.random() * 4}s`;
            starsContainer.appendChild(star);
        }
        
        // Make tables responsive
        document.addEventListener('DOMContentLoaded', () => {
            const tables = document.querySelectorAll('.table');
            tables.forEach(table => {
                const container = document.createElement('div');
                container.className = 'table-container';
                table.parentNode.insertBefore(container, table);
                container.appendChild(table);
            });
        });
    </script>
    @yield('scripts')
</body>
</html>