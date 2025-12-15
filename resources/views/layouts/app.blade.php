<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Inventario')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1a202c;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            margin-right: 1rem;
        }

        .user-info h3 {
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .user-role {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            color: white;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .user-dropdown {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 0.5rem;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-dropdown:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #10b981;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            background: #f8fafc;
        }

        .content-header {
            background: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .content-body {
            padding: 2rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 0.9rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-icon {
            margin-right: 0.5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .bg-green-100 {
            background-color: #dcfce7;
        }

        .bg-red-100 {
            background-color: #fee2e2;
        }

        .border-green-400 {
            border-color: #4ade80;
        }

        .border-red-400 {
            border-color: #f87171;
        }

        .text-green-700 {
            color: #15803d;
        }

        .text-red-700 {
            color: #b91c1c;
        }

        .list-disc {
            list-style-type: disc;
        }

        .list-inside {
            list-style-position: inside;
        }

        /* ========================================
           ESTILOS PARA EL MODAL
           ======================================== */
        
        /* Asegurar que el modal esté por encima de todo */
        .modal {
            z-index: 9999 !important;
        }
        
        .modal-backdrop {
            z-index: 9998 !important;
        }
        
        /* Estilos del modal */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px 12px 0 0;
            padding: 1.25rem 1.5rem;
        }
        
        .modal-header .btn-close {
            opacity: 1;
        }
        
        .modal-body {
            padding: 1.5rem;
            max-height: 70vh;
            overflow-y: auto;
        }
        
        /* Scrollbar personalizado para el modal */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }
        
        .modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .modal-body::-webkit-scrollbar-thumb {
            background: #dc3545;
            border-radius: 10px;
        }
        
        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #c82333;
        }
        
        /* Estilos para los inputs del formulario */
        .form-control, .form-select {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.6rem 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
            outline: none;
        }
        
        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .invalid-feedback {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }
        
        /* Estilos para labels */
        .form-label {
            margin-bottom: 0.5rem;
            color: #495057;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .form-label .text-danger {
            font-weight: bold;
        }
        
        /* Botones dentro del modal */
        .modal .btn {
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }
        
        .modal .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            color: white;
        }
        
        .modal .btn-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            box-shadow: 0 6px 16px rgba(220, 53, 69, 0.4);
            transform: translateY(-2px);
        }
        
        .modal .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .modal .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        /* Alert de información */
        .alert-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border: 1px solid #b8daff;
            border-radius: 8px;
            color: #0c5460;
        }
        
        /* Spinner de carga */
        .spinner-border {
            width: 3rem;
            height: 3rem;
            border-width: 0.3rem;
        }
        
        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal.show .modal-dialog {
            animation: fadeIn 0.3s ease-out;
        }

        /* ========================================
   SUBMENÚ DESPLEGABLE
   ======================================== */
/* ========================================
   SUBMENÚ DESPLEGABLE
   ======================================== */
.menu-item-wrapper {
    position: relative;
}

.submenu-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.submenu-arrow {
    margin-left: auto;
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}

.submenu-toggle.open .submenu-arrow {
    transform: rotate(180deg);
}

/* Contenedor del submenú */
.submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background-color: rgba(0, 0, 0, 0.1);
}

.submenu.open {
    max-height: 500px; /* Aumentado para acomodar todos los items */
}

/* Items del submenú */
.submenu-item {
    display: flex;
    align-items: center;
    padding: 10px 20px 10px 50px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.submenu-item:hover {
    background-color: rgba(255, 255, 255, 0.05);
    color: #fff;
    padding-left: 55px;
}

.submenu-item.active {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
    border-left: 3px solid #10b981;
}

.submenu-icon {
    margin-right: 10px;
    font-size: 1rem;
}

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
            
            .modal-dialog {
                margin: 0.5rem;
            }
            
            .modal-body {
                padding: 1rem;
                max-height: 60vh;
            }



/* Toggle del submenú */
.submenu-toggle {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.submenu-arrow {
    margin-left: auto;
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}

.submenu-toggle.open .submenu-arrow {
    transform: rotate(180deg);
}

/* Contenedor del submenú */
.submenu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
    background-color: rgba(0, 0, 0, 0.1);
}

.submenu.open {
    max-height: 300px;
}

/* Items del submenú */
.submenu-item {
    display: flex;
    align-items: center;
    padding: 10px 20px 10px 50px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.submenu-item:hover {
    background-color: rgba(255, 255, 255, 0.05);
    color: #fff;
    padding-left: 55px;
}

.submenu-item.active {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
    border-left: 3px solid #fff;
}

.submenu-icon {
    margin-right: 10px;
    font-size: 1rem;
}
        }


    </style>

    @stack('styles')
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <div class="user-profile">
            
           
        </div>
       
        <div class="user-dropdown">
           
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="sidebar-menu">

        <a href="{{ route('dashboard') }}" 
           class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fas fa-home"></i>
            </div>
            Inicio
        </a>

        <!-- 🔹 Zoología y Botánica (con submenu) -->
        <div class="menu-item-wrapper">
            <a href="#"
               class="menu-item submenu-toggle {{ request()->routeIs('inventario.*') || request()->routeIs('zoologia.*') ? 'active' : '' }}"
               onclick="toggleSubmenu(event, 'submenuZoologia')">
                <div class="menu-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                Lab. Zoología y Botánica
                <i class="fas fa-chevron-down submenu-arrow"></i>
            </a>
            <div id="submenuZoologia" class="submenu">
                <a href="{{ route('inventario.index') }}"
                   class="submenu-item {{ request()->routeIs('inventario.index') ? 'active' : '' }}">
                    <span class="submenu-icon">📦</span>
                    Equipos y Muebles
                </a>
               <a href="{{route('zoologia.utileria.index')}}" class="submenu-item">
            <span class="submenu-icon">🧰</span>
            Utilería
        </a>
        <a href="{{ route('zoologia.vidrieria.index') }}" class="submenu-item">
            <span class="submenu-icon">⚗️</span>
            Vidriería
        </a>
        <a href="{{ route('zoologia.reactivos.index') }}" class="submenu-item">
            <span class="submenu-icon">🧪</span>
            Reactivos
        </a>
            </div>
        </div>

<!-- Menú desplegable de Biotecnología -->
<div class="menu-item-wrapper">
    <a href="#" 
       class="menu-item submenu-toggle {{ request()->routeIs('biotecnologia.*') ? 'active' : '' }}"
       onclick="toggleSubmenu(event, 'submenuBiotec')">
        <div class="menu-icon">
            <i class="fas fa-leaf"></i>
        </div>
        Lab. Biotecnología Vegetal
        <i class="fas fa-chevron-down submenu-arrow"></i>
    </a>

    <div id="submenuBiotec" class="submenu">
        <a href="{{ route('biotecnologia.index') }}" 
           class="submenu-item {{ request()->routeIs('biotecnologia.index') ? 'active' : '' }}">
            <span class="submenu-icon">📦</span>
             Equipos y Muebles
        </a>
        <a href="{{route ('biotecnologia.utileria.index')}}" class="submenu-item">
            <span class="submenu-icon">🧰</span>
            Utilería
        </a>
        <a href="{{ route('biotecnologia.vidrieria.index') }}" class="submenu-item">
            <span class="submenu-icon">⚗️</span>
            Vidriería
        </a>
        <a href="{{ route('biotecnologia.reactivos.index') }}" class="submenu-item">
            <span class="submenu-icon">🧪</span>
            Reactivos
        </a>
        <a href="{{ route('biotecnologia.siembra.index') }}" class="submenu-item">
            <span class="submenu-icon">🌱</span>
            Siembra
        </a>
        <a href="{{ route('biotecnologia.incubacion.index') }}" class="submenu-item">
            <span class="submenu-icon">🥚</span>
            Incubación
        </a>
    </div>
</div>


       <div class="menu-item-wrapper">
    <a href="#"
       class="menu-item submenu-toggle {{ request()->routeIs('fisicoquimica.*') ? 'active' : '' }}"
       onclick="toggleSubmenu(event, 'submenuFisico')">
        <div class="menu-icon">
            <i class="fas fa-flask"></i>
        </div>
        Lab. Fisico Química
        <i class="fas fa-chevron-down submenu-arrow"></i>
    </a>
    <div id="submenuFisico" class="submenu">
        <a href="{{ route('fisicoquimica.index') }}"
           class="submenu-item {{ request()->routeIs('fisicoquimica.index') ? 'active' : '' }}">
            <span class="submenu-icon">📦</span>
            Equipos y Muebles
        </a>
        <a href="{{ route('fisicoquimica.adsorcion.index') }}" class="submenu-item">
            <span class="submenu-icon">🧪</span>
            Adsorción atómica
        </a>
        <a href="{{ route('fisicoquimica.secado_suelos.index') }}" class="submenu-item">
            <span class="submenu-icon">🌾</span>
            Secado de suelos
        </a>
        <a href="{{ route('fisicoquimica.area_administrativa.index') }}" class="submenu-item">
            <span class="submenu-icon">🏢</span>
            Área administrativa
        </a>
        <a href="{{ route('fisicoquimica.deposito.index') }}" class="submenu-item">
            <span class="submenu-icon">📥</span>
            Depósito
        </a>
        <a href="{{ route('fisicoquimica.area_balanzas.index') }}" class="submenu-item">
            <span class="submenu-icon">⚖️</span>
            Área de balanzas
        </a>
        <a href="{{ route('fisicoquimica.laboratorio_analisis.index') }}" class="submenu-item">
            <span class="submenu-icon">🧬</span>
            Laboratorio de análisis
        </a>
        <a href="{{ route('fisicoquimica.vidrieria.index') }}" class="submenu-item">
            <span class="submenu-icon">⚗️</span>
            Vidriería
        </a>
    </div>
</div>

       <div class="menu-item-wrapper">
    <a href="#" 
       class="menu-item submenu-toggle {{ request()->routeIs('microbiologia.*') ? 'active' : '' }}"
       onclick="toggleSubmenu(event, 'submenuMicrobiologia')">
        <div class="menu-icon">
            <i class="fas fa-leaf"></i>
        </div>
        Lab. Microbiología
        <i class="fas fa-chevron-down submenu-arrow"></i>
    </a>
        <div id="submenuMicrobiologia" class="submenu">
                <a href="{{ route('microbiologia.index') }}"
                   class="submenu-item {{ request()->routeIs('microbiologia.index') ? 'active' : '' }}">
                    <span class="submenu-icon">📦</span>
                    Equipos y Muebles
                </a>
               <a href="{{route('microbiologia.utileria.index')}}" class="submenu-item">
            <span class="submenu-icon">🧰</span>
            Utilería
        </a>
        <a href="{{ route('microbiologia.vidrieria.index') }}" class="submenu-item">
            <span class="submenu-icon">⚗️</span>
            Vidriería
        </a>
        <a href="{{ route('microbiologia.reactivos.index') }}" class="submenu-item">
            <span class="submenu-icon">🧪</span>
            Reactivos
        </a>
            </div>
        </div>
    </nav>
</div>


    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            <p class="page-subtitle">@yield('page-subtitle', 'Bienvenido al sistema de inventario')</p>
        </div>

        <div class="content-body">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- jQuery (opcional pero recomendado) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap 5 JS Bundle (IMPORTANTE: incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para verificar que Bootstrap está cargado -->
    <script>
        // Verificar que Bootstrap se haya cargado correctamente
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap === 'undefined') {
                console.error('⚠️ Bootstrap no se ha cargado correctamente');
            } else {
                console.log('✅ Bootstrap cargado correctamente');
                console.log('✅ Versión de Bootstrap:', bootstrap.Modal ? 'Modal disponible' : 'Modal NO disponible');
            }
            
            if (typeof Swal === 'undefined') {
                console.error('⚠️ SweetAlert2 no se ha cargado correctamente');
            } else {
                console.log('✅ SweetAlert2 cargado correctamente');
            }
        });

   function toggleSubmenu(event, submenuId) {
    event.preventDefault();
    
    const submenu = document.getElementById(submenuId);
    const toggle = event.currentTarget;
    
    submenu.classList.toggle('open');
    toggle.classList.toggle('open');
}

    </script>

   


    @stack('scripts')

    <!-- Modal global para ver imágenes en grande -->
    <div id="imageModal" class="image-modal" style="display:none" onclick="closeImageModal()">
        <div class="image-modal-content" onclick="event.stopPropagation()">
            <span class="image-modal-close" onclick="closeImageModal()">&times;</span>
            <img id="modalImage" src="" alt="Imagen">
            <div class="image-modal-info">
                <p id="modalImageInfo">Vista previa</p>
            </div>
        </div>
    </div>

    <style>
    .image-modal{position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background-color:rgba(0,0,0,.9);backdrop-filter:blur(5px);display:none}
    .image-modal-content{position:relative;margin:auto;padding:20px;width:90%;max-width:800px;top:50%;transform:translateY(-50%);background:#fff;border-radius:12px;box-shadow:0 25px 50px -12px rgba(0,0,0,.25)}
    .image-modal-close{position:absolute;top:15px;right:20px;color:#999;font-size:28px;font-weight:bold;cursor:pointer;z-index:1001}
    .image-modal-content img{width:100%;height:auto;max-height:70vh;object-fit:contain;border-radius:8px}
    .image-modal-info{text-align:center;margin-top:12px;padding:10px;background:#f8f9fa;border-radius:8px}
    </style>

    <script>
    // Apertura/cierre del modal de imágenes (global)
    function openImageModal(src, infoText = 'Vista previa') {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');
        const info = document.getElementById('modalImageInfo');
        img.src = src;
        info.textContent = infoText;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Delegación: hacer clic sobre cualquier .table-image para abrir el modal
    document.addEventListener('click', function (e) {
        const img = e.target.closest('.table-image');
        if (img) {
            openImageModal(img.src, img.alt || 'Vista previa');
        }
    });

    // Cerrar con ESC
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeImageModal();
    });
    </script>
</body>
</html>