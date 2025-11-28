@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Inventario')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Vista general del inventario de laboratorios')

@section('content')
<div class="dashboard-container">
    {{-- HERO SECTION --}}
    <div class="dashboard-hero">
        <div class="hero-content">
            <h1 class="hero-title">
                <i class="fas fa-chart-line"></i>
                Sistema de Inventario de Laboratorios
            </h1>
            <p class="hero-subtitle">
                Gestión integral de inventarios de Biotecnología, Físico Química, Zoología y Microbiología
            </p>
            <div class="hero-stats-mini">
                <div class="mini-stat">
                    <span class="mini-stat-value">{{ number_format($stats['totales']['general']) }}</span>
                    <span class="mini-stat-label">Items Totales</span>
                </div>
                <div class="mini-stat-divider"></div>
                <div class="mini-stat">
                    <span class="mini-stat-value">{{ $stats['totales']['laboratorios'] }}</span>
                    <span class="mini-stat-label">Laboratorios</span>
                </div>
                <div class="mini-stat-divider"></div>
                <div class="mini-stat">
                    <span class="mini-stat-value">24</span>
                    <span class="mini-stat-label">Módulos Activos</span>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN STATS CARDS --}}
    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon">
                <i class="fas fa-boxes"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-label">Inventario General</h3>
                <p class="stat-card-value counter" data-target="{{ $stats['inventario']['total'] }}">0</p>
                <div class="stat-card-footer">
                    <span class="stat-card-change positive">
                        <i class="fas fa-chart-line"></i>
                        {{ $stats['inventario']['gestiones'] }} gestiones
                    </span>
                </div>
            </div>
            <div class="stat-card-progress">
                <div class="progress-bar" style="width: {{ min(($stats['inventario']['total'] / max($stats['totales']['general'], 1)) * 100, 100) }}%"></div>
            </div>
        </div>

        <div class="stat-card stat-card-success">
            <div class="stat-card-icon">
                <i class="fas fa-seedling"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-label">Biotecnología Vegetal</h3>
                <p class="stat-card-value counter" data-target="{{ $stats['biotecnologia']['total'] }}">0</p>
                <div class="stat-card-footer">
                    <span class="stat-card-change">
                        <i class="fas fa-flask"></i>
                        6 módulos
                    </span>
                </div>
            </div>
            <div class="stat-card-progress">
                <div class="progress-bar" style="width: {{ min(($stats['biotecnologia']['total'] / max($stats['totales']['general'], 1)) * 100, 100) }}%"></div>
            </div>
        </div>

        <div class="stat-card stat-card-info">
            <div class="stat-card-icon">
                <i class="fas fa-flask"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-label">Físico Química</h3>
                <p class="stat-card-value counter" data-target="{{ $stats['fisicoquimica']['total'] }}">0</p>
                <div class="stat-card-footer">
                    <span class="stat-card-change">
                        <i class="fas fa-cube"></i>
                        11 módulos
                    </span>
                </div>
            </div>
            <div class="stat-card-progress">
                <div class="progress-bar" style="width: {{ min(($stats['fisicoquimica']['total'] / max($stats['totales']['general'], 1)) * 100, 100) }}%"></div>
            </div>
        </div>

        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon">
                <i class="fas fa-leaf"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-label">Zoología y Botánica</h3>
                <p class="stat-card-value counter" data-target="{{ $stats['zoologia']['total'] }}">0</p>
                <div class="stat-card-footer">
                    <span class="stat-card-change">
                        <i class="fas fa-layer-group"></i>
                        3 módulos
                    </span>
                </div>
            </div>
            <div class="stat-card-progress">
                <div class="progress-bar" style="width: {{ min(($stats['zoologia']['total'] / max($stats['totales']['general'], 1)) * 100, 100) }}%"></div>
            </div>
        </div>

        <div class="stat-card stat-card-purple">
            <div class="stat-card-icon">
                <i class="fas fa-microscope"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-label">Microbiología</h3>
                <p class="stat-card-value counter" data-target="{{ $stats['microbiologia']['total'] }}">0</p>
                <div class="stat-card-footer">
                    <span class="stat-card-change">
                        <i class="fas fa-vial"></i>
                        3 módulos
                    </span>
                </div>
            </div>
            <div class="stat-card-progress">
                <div class="progress-bar" style="width: {{ min(($stats['microbiologia']['total'] / max($stats['totales']['general'], 1)) * 100, 100) }}%"></div>
            </div>
        </div>

        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-card-content">
                <h3 class="stat-card-label">Estado Malo</h3>
                <p class="stat-card-value counter" data-target="{{ $stats['inventario']['malo'] }}">0</p>
                <div class="stat-card-footer">
                    <span class="stat-card-change negative">
                        <i class="fas fa-percentage"></i>
                        {{ $stats['porcentajes']['malo'] }}% del total
                    </span>
                </div>
            </div>
            <div class="stat-card-progress">
                <div class="progress-bar" style="width: {{ $stats['porcentajes']['malo'] }}%"></div>
            </div>
        </div>
    </div>

    {{-- CHARTS AND DETAILS SECTION --}}
    <div class="dashboard-grid">
        {{-- CHART: Distribución por Laboratorio --}}
        <div class="dashboard-card chart-card">
            <div class="card-header-modern">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    Distribución por Laboratorio
                </h3>
            </div>
        <div class="card-body">
                <canvas id="labDistributionChart" class="dashboard-chart"></canvas>
                </div>
                </div>

        {{-- DETAILED STATS: Biotecnología --}}
        <div class="dashboard-card detail-card">
            <div class="card-header-modern">
                <h3 class="card-title">
                    <i class="fas fa-seedling"></i>
                    Lab. Biotecnología Vegetal
                </h3>
                <a href="{{ route('biotecnologia.index') }}" class="card-link">
                    Ver todo <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="module-stats-list">
                    <div class="module-stat-item">
                        <span class="module-icon">🔧</span>
                        <div class="module-info">
                            <span class="module-name">Utilería</span>
                            <span class="module-count">{{ $stats['biotecnologia']['utileria'] }} items</span>
            </div>
                        <a href="{{ route('biotecnologia.utileria.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="module-stat-item">
                        <span class="module-icon">🧪</span>
                        <div class="module-info">
                            <span class="module-name">Vidriería</span>
                            <span class="module-count">{{ $stats['biotecnologia']['vidrieria'] }} items</span>
                        </div>
                        <a href="{{ route('biotecnologia.vidrieria.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="module-stat-item">
                        <span class="module-icon">⚗️</span>
                        <div class="module-info">
                            <span class="module-name">Reactivos</span>
                            <span class="module-count">{{ $stats['biotecnologia']['reactivos'] }} items</span>
                        </div>
                        <a href="{{ route('biotecnologia.reactivos.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="module-stat-item">
                        <span class="module-icon">🌱</span>
                        <div class="module-info">
                            <span class="module-name">Siembra</span>
                            <span class="module-count">{{ $stats['biotecnologia']['siembra'] }} items</span>
                        </div>
                        <a href="{{ route('biotecnologia.siembra.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="module-stat-item">
                        <span class="module-icon">🔬</span>
                        <div class="module-info">
                            <span class="module-name">Equipos Siembra</span>
                            <span class="module-count">{{ $stats['biotecnologia']['equipos'] }} items</span>
                        </div>
                        <a href="{{ route('biotecnologia.siembra_equipos.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="module-stat-item">
                        <span class="module-icon">🥚</span>
                        <div class="module-info">
                            <span class="module-name">Incubación</span>
                            <span class="module-count">{{ $stats['biotecnologia']['incubacion'] }} items</span>
                        </div>
                        <a href="{{ route('biotecnologia.incubacion.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
        </div>
    </div>

        {{-- DETAILED STATS: Físico Química --}}
        <div class="dashboard-card detail-card">
            <div class="card-header-modern">
                <h3 class="card-title">
                    <i class="fas fa-flask"></i>
                    Lab. Físico Química
                </h3>
                <a href="{{ route('fisicoquimica.index') }}" class="card-link">
                    Ver todo <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        <div class="card-body">
                <div class="module-stats-list">
                    <div class="module-stat-item">
                        <span class="module-icon">🧪</span>
                        <div class="module-info">
                            <span class="module-name">Adsorción Atómica</span>
                            <span class="module-count">{{ $stats['fisicoquimica']['adsorcion'] }} items</span>
                </div>
                        <a href="{{ route('fisicoquimica.adsorcion.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                </div>
                    <div class="module-stat-item">
                        <span class="module-icon">🌾</span>
                        <div class="module-info">
                            <span class="module-name">Secado de Suelos</span>
                            <span class="module-count">{{ $stats['fisicoquimica']['secado'] }} items</span>
            </div>
                        <a href="{{ route('fisicoquimica.secado_suelos.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
            </div>
                    <div class="module-stat-item">
                        <span class="module-icon">🏢</span>
                        <div class="module-info">
                            <span class="module-name">Área Administrativa</span>
                            <span class="module-count">{{ $stats['fisicoquimica']['admin'] }} items</span>
                        </div>
                        <a href="{{ route('fisicoquimica.area_administrativa.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="module-stat-item">
                        <span class="module-icon">📥</span>
                        <div class="module-info">
                            <span class="module-name">Depósito</span>
                            <span class="module-count">{{ $stats['fisicoquimica']['deposito'] }} items</span>
                        </div>
                        <a href="{{ route('fisicoquimica.deposito.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="module-stat-item">
                        <span class="module-icon">⚖️</span>
                        <div class="module-info">
                            <span class="module-name">Área de Balanzas</span>
                            <span class="module-count">{{ $stats['fisicoquimica']['balanzas'] }} items</span>
                        </div>
                        <a href="{{ route('fisicoquimica.area_balanzas.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="module-stat-item">
                        <span class="module-icon">🧬</span>
                        <div class="module-info">
                            <span class="module-name">Laboratorio de Análisis</span>
                            <span class="module-count">{{ $stats['fisicoquimica']['lab_analisis'] }} items</span>
                        </div>
                        <a href="{{ route('fisicoquimica.laboratorio_analisis.index') }}" class="module-link">
                            <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                    <div class="module-stat-item highlight">
                        <span class="module-icon">🔧</span>
                        <div class="module-info">
                            <span class="module-name">Equipos (Total)</span>
                            <span class="module-count">{{ $stats['fisicoquimica']['equipos'] }} items</span>
                        </div>
                    </div>
                </div>
        </div>
    </div>

        {{-- QUICK ACTIONS --}}
        <div class="dashboard-card actions-card">
            <div class="card-header-modern">
                <h3 class="card-title">
                    <i class="fas fa-bolt"></i>
                    Accesos Rápidos
                </h3>
            </div>
        <div class="card-body">
                <div class="quick-actions-grid">
                    <a href="{{ route('biotecnologia.index') }}" class="quick-action-btn action-biotec">
                        <i class="fas fa-seedling"></i>
                        <span>Biotecnología</span>
                    </a>
                    <a href="{{ route('fisicoquimica.index') }}" class="quick-action-btn action-fisico">
                        <i class="fas fa-flask"></i>
                        <span>Físico Química</span>
                    </a>
                    <a href="{{ route('zoologia.utileria.index') }}" class="quick-action-btn action-zoo">
                        <i class="fas fa-leaf"></i>
                        <span>Zoología</span>
                    </a>
                    <a href="{{ route('microbiologia.utileria.index') }}" class="quick-action-btn action-micro">
                        <i class="fas fa-microscope"></i>
                        <span>Microbiología</span>
                    </a>
                    <a href="{{ route('inventario.index') }}" class="quick-action-btn action-inventario">
                        <i class="fas fa-boxes"></i>
                        <span>Inventario General</span>
                    </a>
                    <a href="{{ route('areas.index') }}" class="quick-action-btn action-areas">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Áreas</span>
                    </a>
                </div>
                </div>
            </div>
            </div>

    {{-- TREND STATISTICS --}}
    <div class="trend-stats-grid">
        <div class="trend-stat-card trend-today">
            <div class="trend-stat-icon">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div class="trend-stat-content">
                <h4 class="trend-stat-label">Agregados Hoy</h4>
                <p class="trend-stat-value counter" data-target="{{ $itemsToday }}">0</p>
        </div>
    </div>

        <div class="trend-stat-card trend-week">
            <div class="trend-stat-icon">
                <i class="fas fa-calendar-week"></i>
            </div>
            <div class="trend-stat-content">
                <h4 class="trend-stat-label">Esta Semana</h4>
                <p class="trend-stat-value counter" data-target="{{ $itemsThisWeek }}">0</p>
            </div>
        </div>
        
        <div class="trend-stat-card trend-month">
            <div class="trend-stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="trend-stat-content">
                <h4 class="trend-stat-label">Este Mes</h4>
                <p class="trend-stat-value counter" data-target="{{ $itemsThisMonth }}">0</p>
            </div>
        </div>
        
        <div class="trend-stat-card trend-value">
            <div class="trend-stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="trend-stat-content">
                <h4 class="trend-stat-label">Valor Total</h4>
                <p class="trend-stat-value">${{ number_format($totalValue, 2, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- TREND CHART AND TOP MODULES --}}
    <div class="dashboard-grid">
        {{-- TREND CHART --}}
        <div class="dashboard-card chart-card">
            <div class="card-header-modern">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i>
                    Tendencias de Ingreso (Últimos 6 Meses)
                </h3>
            </div>
        <div class="card-body">
                <canvas id="trendChart" class="dashboard-chart"></canvas>
                </div>
                </div>

        {{-- TOP MODULES --}}
        <div class="dashboard-card top-modules-card">
            <div class="card-header-modern">
                <h3 class="card-title">
                    <i class="fas fa-trophy"></i>
                    Módulos con Más Items
                </h3>
            </div>
            <div class="card-body">
                <div class="top-modules-list">
                    @foreach($topModules as $index => $module)
                    <div class="top-module-item">
                        <div class="top-module-rank">
                            <span class="rank-number">{{ $index + 1 }}</span>
                            <div class="rank-medal">
                                @if($index === 0)
                                    <i class="fas fa-medal" style="color: #fbbf24;"></i>
                                @elseif($index === 1)
                                    <i class="fas fa-medal" style="color: #9ca3af;"></i>
                                @elseif($index === 2)
                                    <i class="fas fa-medal" style="color: #cd7f32;"></i>
                                @endif
            </div>
        </div>
                        <div class="top-module-icon" style="background: linear-gradient(135deg, {{ $module['color'] }}20, {{ $module['color'] }}10);">
                            <i class="{{ $module['icon'] }}" style="color: {{ $module['color'] }};"></i>
                        </div>
                        <div class="top-module-info">
                            <h4 class="top-module-name">{{ $module['name'] }}</h4>
                            <p class="top-module-count">{{ number_format($module['count']) }} items</p>
                        </div>
                        <a href="{{ $module['route'] }}" class="top-module-link">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
</div>

    {{-- ALERTS AND NOTIFICATIONS --}}
    @if($itemsNeedingAttention > 0)
    <div class="dashboard-card alert-card">
        <div class="card-header-modern alert-header">
            <h3 class="card-title">
                <i class="fas fa-exclamation-circle"></i>
                Alertas y Notificaciones
            </h3>
            <span class="alert-badge">{{ $itemsNeedingAttention }}</span>
        </div>
        <div class="card-body">
            <div class="alert-item alert-warning">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="alert-content">
                    <h4 class="alert-title">Items con Estado Malo</h4>
                    <p class="alert-message">
                        Hay <strong>{{ $itemsNeedingAttention }}</strong> item(s) que requieren atención inmediata debido a su estado.
                    </p>
                    <a href="{{ route('inventario.index') }}?estado=malo" class="alert-action">
                        Ver Items <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- RECENT ACTIVITY --}}
    @if($recentItems && $recentItems->count() > 0)
    <div class="dashboard-card recent-card">
        <div class="card-header-modern">
            <h3 class="card-title">
                <i class="fas fa-clock"></i>
                Items Recientes
            </h3>
            <a href="{{ route('inventario.index') }}" class="card-link">
                Ver todos <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        <div class="card-body">
            <div class="recent-items-list">
                @foreach($recentItems as $item)
                <div class="recent-item">
                    <div class="recent-item-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="recent-item-content">
                        <h4 class="recent-item-title">{{ $item->nombre_item ?? $item->nombre ?? ($item->descripcion_elemento ?? 'Sin nombre') }}</h4>
                        <p class="recent-item-meta">
                            <span class="badge badge-{{ $item->estado ?? 'default' }}">
                                {{ ucfirst($item->estado ?? 'N/A') }}
                            </span>
                            <span class="recent-item-date">
                                {{ $item->created_at->diffForHumans() }}
                            </span>
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- QUICK STATS SUMMARY --}}
    <div class="dashboard-card summary-card">
        <div class="card-header-modern">
            <h3 class="card-title">
                <i class="fas fa-info-circle"></i>
                Resumen del Sistema
            </h3>
        </div>
        <div class="card-body">
            <div class="summary-grid">
                <div class="summary-item">
                    <i class="fas fa-database summary-icon"></i>
                    <div class="summary-text">
                        <span class="summary-label">Total de Registros</span>
                        <span class="summary-value">{{ number_format($stats['totales']['general']) }}</span>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="fas fa-building summary-icon"></i>
                    <div class="summary-text">
                        <span class="summary-label">Laboratorios Activos</span>
                        <span class="summary-value">{{ $stats['totales']['laboratorios'] }}</span>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="fas fa-layer-group summary-icon"></i>
                    <div class="summary-text">
                        <span class="summary-label">Módulos Configurados</span>
                        <span class="summary-value">{{ $stats['totales']['modulos'] }}</span>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="fas fa-check-circle summary-icon"></i>
                    <div class="summary-text">
                        <span class="summary-label">Items en Buen Estado</span>
                        <span class="summary-value">{{ number_format($stats['inventario']['bueno']) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css" rel="stylesheet">
<style>
/* ========================================
   DASHBOARD STYLES - PROFESIONAL & MODERNO
   ======================================== */
:root {
    --primary: #3b82f6;
    --primary-dark: #2563eb;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #06b6d4;
    --purple: #8b5cf6;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1rem;
    animation: fadeIn 0.6s ease-out;
}

/* Hero Section */
.dashboard-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 24px;
    padding: 3rem 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-xl);
    position: relative;
    overflow: hidden;
}

.dashboard-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.hero-content {
    position: relative;
    z-index: 1;
    color: white;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.hero-title i {
    font-size: 2rem;
    opacity: 0.9;
}

.hero-subtitle {
    font-size: 1.125rem;
    opacity: 0.95;
    margin-bottom: 2rem;
}

.hero-stats-mini {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.mini-stat {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.mini-stat-value {
    font-size: 2rem;
    font-weight: 700;
    line-height: 1;
}

.mini-stat-label {
    font-size: 0.875rem;
    opacity: 0.9;
}

.mini-stat-divider {
    width: 1px;
    height: 40px;
    background: rgba(255, 255, 255, 0.3);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--gray-200);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--success));
    transform: scaleX(0);
    transition: transform 0.5s ease;
}

.stat-card:hover::before {
    transform: scaleX(1);
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.stat-card-primary::before { background: linear-gradient(90deg, var(--primary), #60a5fa); }
.stat-card-success::before { background: linear-gradient(90deg, var(--success), #34d399); }
.stat-card-info::before { background: linear-gradient(90deg, var(--info), #22d3ee); }
.stat-card-warning::before { background: linear-gradient(90deg, var(--warning), #fbbf24); }
.stat-card-purple::before { background: linear-gradient(90deg, var(--purple), #a78bfa); }
.stat-card-danger::before { background: linear-gradient(90deg, var(--danger), #f87171); }

.stat-card-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.stat-card-primary .stat-card-icon {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: var(--primary);
}

.stat-card-success .stat-card-icon {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: var(--success);
}

.stat-card-info .stat-card-icon {
    background: linear-gradient(135deg, #cffafe, #a5f3fc);
    color: var(--info);
}

.stat-card-warning .stat-card-icon {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: var(--warning);
}

.stat-card-purple .stat-card-icon {
    background: linear-gradient(135deg, #e9d5ff, #ddd6fe);
    color: var(--purple);
}

.stat-card-danger .stat-card-icon {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: var(--danger);
}

.stat-card:hover .stat-card-icon {
    transform: scale(1.1) rotate(5deg);
}

.stat-card-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-600);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-card-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--gray-900);
    line-height: 1;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--gray-900), var(--gray-700));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.stat-card-footer {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.stat-card-change {
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
    color: var(--gray-500);
}

.stat-card-change.positive {
    color: var(--success);
}

.stat-card-change.negative {
    color: var(--danger);
}

.stat-card-progress {
    margin-top: 1rem;
    height: 6px;
    background: var(--gray-100);
    border-radius: 10px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--primary), var(--success));
    border-radius: 10px;
    transition: width 1.5s ease-out;
    position: relative;
}

.progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: shimmer 2s infinite;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.dashboard-card {
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    animation: fadeInUp 0.8s ease-out;
}

.chart-card {
    grid-column: span 2;
    max-width: 900px;
    margin: 0 auto;
    width: 100%;
}

@media (max-width: 1024px) {
    .chart-card {
        grid-column: span 1;
    }
}

.card-header-modern {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chart-card .card-header-modern {
    padding: 0.75rem 1rem;
    margin-bottom: 0;
    border-bottom: 1px solid var(--gray-200);
}

.chart-card .card-title {
    font-size: 1.125rem;
    margin: 0;
}

.chart-card .card-title i {
    font-size: 1rem;
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-900);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-title i {
    color: var(--primary);
}

.card-link {
    font-size: 0.875rem;
    color: var(--primary);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.card-link:hover {
    gap: 0.75rem;
    color: var(--primary-dark);
}

.card-body {
    padding: 1.5rem;
}

.chart-card {
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-width: 900px;
    margin: 0 auto;
    width: 100%;
}

.chart-card .card-body {
    padding: 0.75rem 1rem 1rem 1rem !important;
    min-height: auto;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.dashboard-chart {
    width: 100% !important;
    height: 220px !important;
    max-height: 220px !important;
    display: block;
    margin: 0 auto;
    padding: 0;
}

/* Module Stats List */
.module-stats-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.module-stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    background: var(--gray-50);
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.module-stat-item:hover {
    background: white;
    border-color: var(--gray-200);
    box-shadow: var(--shadow-sm);
    transform: translateX(4px);
}

.module-stat-item.highlight {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-color: var(--primary);
}

.module-icon {
    font-size: 1.5rem;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: white;
    box-shadow: var(--shadow-sm);
}

.module-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.module-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 0.9375rem;
}

.module-count {
    font-size: 0.875rem;
    color: var(--gray-500);
}

.module-link {
    color: var(--gray-400);
    transition: all 0.3s ease;
    text-decoration: none;
}

.module-stat-item:hover .module-link {
    color: var(--primary);
    transform: scale(1.2);
}

/* Quick Actions */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem;
}

.quick-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 1.5rem 1rem;
    border-radius: 16px;
    text-decoration: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.quick-action-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.quick-action-btn:hover::before {
    width: 300px;
    height: 300px;
}

.quick-action-btn i {
    font-size: 2rem;
    position: relative;
    z-index: 1;
}

.quick-action-btn span {
    position: relative;
    z-index: 1;
    font-size: 0.875rem;
}

.action-biotec { background: linear-gradient(135deg, var(--success), #34d399); }
.action-fisico { background: linear-gradient(135deg, var(--info), #22d3ee); }
.action-zoo { background: linear-gradient(135deg, var(--warning), #fbbf24); }
.action-micro { background: linear-gradient(135deg, var(--purple), #a78bfa); }
.action-inventario { background: linear-gradient(135deg, var(--primary), #60a5fa); }
.action-areas { background: linear-gradient(135deg, #f59e0b, #fbbf24); }

.quick-action-btn:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

/* Recent Items */
.recent-card {
    animation: fadeInUp 1s ease-out;
}

.recent-items-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.recent-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    background: var(--gray-50);
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.recent-item:hover {
    background: white;
    border-color: var(--gray-200);
    box-shadow: var(--shadow-sm);
}

.recent-item-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary), var(--success));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.recent-item-content {
    flex: 1;
}

.recent-item-title {
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
    font-size: 0.9375rem;
}

.recent-item-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.875rem;
}

.recent-item-date {
    color: var(--gray-500);
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-bueno {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #166534;
}

.badge-regular {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
}

.badge-malo {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
}

.badge-default {
    background: var(--gray-200);
    color: var(--gray-700);
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shimmer {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

/* Trend Stats Grid */
.trend-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.trend-stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--gray-200);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.trend-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, var(--primary), var(--success));
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.trend-stat-card:hover::before {
    transform: scaleY(1);
}

.trend-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.trend-today::before { background: linear-gradient(180deg, var(--success), #34d399); }
.trend-week::before { background: linear-gradient(180deg, var(--info), #22d3ee); }
.trend-month::before { background: linear-gradient(180deg, var(--warning), #fbbf24); }
.trend-value::before { background: linear-gradient(180deg, var(--purple), #a78bfa); }

.trend-stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.trend-today .trend-stat-icon { background: linear-gradient(135deg, var(--success), #34d399); }
.trend-week .trend-stat-icon { background: linear-gradient(135deg, var(--info), #22d3ee); }
.trend-month .trend-stat-icon { background: linear-gradient(135deg, var(--warning), #fbbf24); }
.trend-value .trend-stat-icon { background: linear-gradient(135deg, var(--purple), #a78bfa); }

.trend-stat-content {
    flex: 1;
}

.trend-stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-600);
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.trend-stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-900);
    line-height: 1;
}

/* Top Modules */
.top-modules-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.top-module-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    border-radius: 14px;
    background: var(--gray-50);
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.top-module-item:hover {
    background: white;
    border-color: var(--gray-200);
    box-shadow: var(--shadow-sm);
    transform: translateX(4px);
}

.top-module-rank {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
    min-width: 50px;
}

.rank-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-700);
}

.rank-medal i {
    font-size: 1.25rem;
}

.top-module-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.top-module-info {
    flex: 1;
}

.top-module-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.25rem;
}

.top-module-count {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0;
}

.top-module-link {
    color: var(--gray-400);
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 1.25rem;
}

.top-module-item:hover .top-module-link {
    color: var(--primary);
    transform: translateX(4px);
}

/* Alert Card */
.alert-card {
    border-left: 4px solid var(--warning);
    animation: pulse 2s infinite;
}

.alert-header {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
}

.alert-badge {
    background: var(--danger);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 700;
}

.alert-item {
    display: flex;
    gap: 1rem;
    padding: 1.25rem;
    border-radius: 12px;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border: 1px solid #fbbf24;
}

.alert-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--warning);
    flex-shrink: 0;
}

.alert-content {
    flex: 1;
}

.alert-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
}

.alert-message {
    font-size: 0.9375rem;
    color: var(--gray-700);
    margin-bottom: 0.75rem;
    line-height: 1.5;
}

.alert-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--warning);
    font-weight: 600;
    text-decoration: none;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.alert-action:hover {
    gap: 0.75rem;
    color: var(--danger);
}

/* Summary Card */
.summary-card {
    margin-top: 2rem;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border: 1px solid var(--gray-200);
    transition: all 0.3s ease;
}

.summary-item:hover {
    background: white;
    box-shadow: var(--shadow-sm);
    transform: translateY(-2px);
}

.summary-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary), var(--success));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.summary-text {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.summary-label {
    font-size: 0.875rem;
    color: var(--gray-600);
    font-weight: 500;
}

.summary-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-900);
    line-height: 1;
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 1.75rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
    
    .quick-actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .trend-stats-grid {
        grid-template-columns: 1fr;
    }
    
    .summary-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target')) || 0;
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.floor(current).toLocaleString();
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString();
            }
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(counter);
    });

    // Chart: Distribución por Laboratorio
    const ctx = document.getElementById('labDistributionChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Inventario General', 'Biotecnología', 'Físico Química', 'Zoología', 'Microbiología'],
                datasets: [{
                    data: [
                        {{ $stats['inventario']['total'] }},
                        {{ $stats['biotecnologia']['total'] }},
                        {{ $stats['fisicoquimica']['total'] }},
                        {{ $stats['zoologia']['total'] }},
                        {{ $stats['microbiologia']['total'] }}
                    ],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(6, 182, 212, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(139, 92, 246, 0.8)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(6, 182, 212)',
                        'rgb(245, 158, 11)',
                        'rgb(139, 92, 246)'
                    ],
                    borderWidth: 2,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 2,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 8,
                            font: {
                                size: 10,
                                weight: '600'
                            },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 10,
                            boxHeight: 10
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value.toLocaleString()} items (${percentage}%)`;
                            }
                        }
                    }
                },
                layout: {
                    padding: 0
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    // Trend Chart: Tendencias de Ingreso
    const trendCtx = document.getElementById('trendChart');
    if (trendCtx) {
        const monthlyData = @json($monthlyStats);
        
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: monthlyData.map(item => item.label),
                datasets: [
                    {
                        label: 'Inventario General',
                        data: monthlyData.map(item => item.inventario),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1.5,
                    },
                    {
                        label: 'Biotecnología',
                        data: monthlyData.map(item => item.biotecnologia),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: 'rgb(16, 185, 129)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1.5,
                    },
                    {
                        label: 'Físico Química',
                        data: monthlyData.map(item => item.fisicoquimica),
                        borderColor: 'rgb(6, 182, 212)',
                        backgroundColor: 'rgba(6, 182, 212, 0.1)',
                        tension: 0.4,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: 'rgb(6, 182, 212)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1.5,
                    },
                    {
                        label: 'Zoología',
                        data: monthlyData.map(item => item.zoologia),
                        borderColor: 'rgb(245, 158, 11)',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.4,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: 'rgb(245, 158, 11)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1.5,
                    },
                    {
                        label: 'Microbiología',
                        data: monthlyData.map(item => item.microbiologia),
                        borderColor: 'rgb(139, 92, 246)',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: false,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: 'rgb(139, 92, 246)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 1.5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                aspectRatio: 2.5,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 8,
                            font: {
                                size: 10,
                                weight: '600'
                            },
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 10,
                            boxHeight: 10
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.parsed.y} items`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                size: 8
                            },
                            padding: 2,
                            maxTicksLimit: 5
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 8
                            },
                            padding: 2
                        },
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                },
                layout: {
                    padding: 0
                },
                animation: {
                    duration: 1500,
                    easing: 'easeOutQuart'
                }
            }
        });
    }
});
</script>
@endpush
@endsection
