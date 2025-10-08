@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Bienvenido al sistema de inventario del laboratorio')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Card de Resumen -->
    <div class="stats-card stats-card-blue">
        <div class="card-body">
            <div class="flex items-center">
                <div class="stats-icon stats-icon-blue">
                    <i class="fas fa-boxes text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Total de Items</h3>
                    <p class="text-3xl font-bold text-blue-600 counter" data-target="{{ $stats['total_items'] }}">0</p>
                </div>
            </div>
            <div class="stats-progress">
                <div class="stats-progress-bar stats-progress-blue" style="width: 85%"></div>
            </div>
        </div>
    </div>

    <!-- Card de Categorías -->
    <div class="stats-card stats-card-green">
        <div class="card-body">
            <div class="flex items-center">
                <div class="stats-icon stats-icon-green">
                    <i class="fas fa-tags text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Gestiones</h3>
                    <p class="text-3xl font-bold text-green-600 counter" data-target="{{ $stats['gestiones'] }}">0</p>
                </div>
            </div>
            <div class="stats-progress">
                <div class="stats-progress-bar stats-progress-green" style="width: 70%"></div>
            </div>
        </div>
    </div>

    <!-- Card de Stock Bajo -->
    <div class="stats-card stats-card-red">
        <div class="card-body">
            <div class="flex items-center">
                <div class="stats-icon stats-icon-red">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Estado Malo</h3>
                    <p class="text-3xl font-bold text-red-600 counter" data-target="{{ $stats['estado_malo'] }}">0</p>
                </div>
            </div>
            <div class="stats-progress">
                <div class="stats-progress-bar stats-progress-red" style="width: 30%"></div>
            </div>
        </div>
    </div>
</div>

<!-- Acciones Rápidas -->
<div class="card mb-8 action-cards-container">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-900">Acciones Rápidas</h2>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('inventario.create') }}" class="action-card action-card-primary">
                <div class="action-card-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="action-card-content">
                    <h3>Agregar Item</h3>
                    <p>Crear nuevo elemento</p>
                </div>
                <div class="action-card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            <a href="{{ route('inventario.index') }}" class="action-card action-card-success">
                <div class="action-card-icon">
                    <i class="fas fa-list"></i>
                </div>
                <div class="action-card-content">
                    <h3>Ver Inventario</h3>
                    <p>Gestionar elementos</p>
                </div>
                <div class="action-card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </a>
            <button class="action-card action-card-warning" onclick="exportData()">
                <div class="action-card-icon">
                    <i class="fas fa-download"></i>
                </div>
                <div class="action-card-content">
                    <h3>Exportar</h3>
                    <p>Descargar datos</p>
                </div>
                <div class="action-card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </button>
            <button class="action-card action-card-purple" onclick="showReports()">
                <div class="action-card-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="action-card-content">
                    <h3>Reportes</h3>
                    <p>Ver estadísticas</p>
                </div>
                <div class="action-card-arrow">
                    <i class="fas fa-arrow-right"></i>
                </div>
            </button>
        </div>
    </div>
</div>

<!-- Tabla Completa de Inventario -->
<div class="card mb-8 modern-table-container">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Inventario Completo</h2>
            <a href="{{ route('inventario.index') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-list"></i>
                Ver Todo
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Tabla de Items -->
        <div class="overflow-x-auto modern-table-wrapper">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="table-header">ID</th>
                        <th class="table-header">IR ID</th>
                        <th class="table-header">IV ID</th>
                        <th class="table-header">Desc. SKU</th>
                        <th class="table-header">Descripción</th>
                        <th class="table-header">No. Placa</th>
                        <th class="table-header">Valor</th>
                        <th class="table-header">Estado</th>
                        <th class="table-header">Gestión</th>
                        <th class="table-header">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventario as $item)
                    <tr class="table-row" data-item-id="{{ $item->id }}">
                        <td class="table-cell">{{ $item->id }}</td>
                        <td class="table-cell">{{ $item->ir_id }}</td>
                        <td class="table-cell">{{ $item->iv_id ?? '-' }}</td>
                        <td class="table-cell">{{ $item->desc_sku }}</td>
                        <td class="table-cell">
                            <div class="table-description" title="{{ $item->descripcion_elemento }}">
                                {{ $item->descripcion_elemento }}
                            </div>
                        </td>
                        <td class="table-cell">{{ $item->no_placa }}</td>
                        <td class="table-cell table-value">${{ number_format($item->valor_adq, 2) }}</td>
                        <td class="table-cell">
                            @if($item->estado == 'bueno')
                                <span class="status-badge status-good">
                                    <i class="fas fa-check-circle"></i>
                                    Bueno
                                </span>
                            @elseif($item->estado == 'regular')
                                <span class="status-badge status-regular">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Regular
                                </span>
                            @else
                                <span class="status-badge status-bad">
                                    <i class="fas fa-times-circle"></i>
                                    Malo
                                </span>
                            @endif
                        </td>
                        <td class="table-cell">{{ $item->gestion }}</td>
                        <td class="table-cell">
                            <div class="action-buttons">
                                <a href="{{ route('inventario.edit', $item->id) }}" class="action-btn action-btn-edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('inventario.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-delete" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este item?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <!-- Mensaje cuando no hay items -->
                    <tr>
                        <td colspan="10" class="empty-state">
                            <div class="empty-state-content">
                                <i class="fas fa-box-open"></i>
                                <h3>No hay items en el inventario</h3>
                                <p>Comienza agregando tu primer item</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Actividad Reciente -->
<div class="card">
    <div class="card-header">
        <h2 class="text-xl font-semibold text-gray-900">Actividad Reciente</h2>
    </div>
    <div class="card-body">
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-inbox text-4xl mb-4"></i>
            <p>No hay actividad reciente</p>
            <p class="text-sm">Las acciones que realices aparecerán aquí</p>
        </div>
    </div>
</div>

<style>
/* Variables CSS */
:root {
    --primary-color: #3b82f6;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --purple-color: #8b5cf6;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-500: #6b7280;
    --gray-700: #374151;
    --gray-900: #111827;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* Animaciones base */
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

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translate3d(0,0,0);
    }
    40%, 43% {
        transform: translate3d(0, -8px, 0);
    }
    70% {
        transform: translate3d(0, -4px, 0);
    }
    90% {
        transform: translate3d(0, -2px, 0);
    }
}

@keyframes shimmer {
    0% {
        background-position: -200px 0;
    }
    100% {
        background-position: calc(200px + 100%) 0;
    }
}

/* Grid System */
.grid {
    display: grid;
    animation: fadeInUp 0.6s ease-out;
}

.grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
.grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

.gap-4 { gap: 1rem; }
.gap-6 { gap: 1.5rem; }
.mb-4 { margin-bottom: 1rem; }
.mb-8 { margin-bottom: 2rem; }
.ml-4 { margin-left: 1rem; }
.p-3 { padding: 0.75rem; }
.py-8 { padding-top: 2rem; padding-bottom: 2rem; }
.text-center { text-align: center; }
.text-gray-500 { color: var(--gray-500); }
.text-gray-900 { color: var(--gray-900); }
.text-blue-600 { color: var(--primary-color); }
.text-green-600 { color: var(--success-color); }
.text-red-600 { color: var(--danger-color); }
.text-xl { font-size: 1.25rem; line-height: 1.75rem; }
.text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
.text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
.text-lg { font-size: 1.125rem; line-height: 1.75rem; }
.text-sm { font-size: 0.875rem; line-height: 1.25rem; }
.font-semibold { font-weight: 600; }
.font-bold { font-weight: 700; }
.flex { display: flex; }
.items-center { align-items: center; }
.justify-between { justify-content: space-between; }

/* Stats Cards */
.stats-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--gray-200);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.6s ease-out;
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--success-color));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.stats-card:hover::before {
    transform: scaleX(1);
}

.stats-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.stats-card-blue:hover { border-color: var(--primary-color); }
.stats-card-green:hover { border-color: var(--success-color); }
.stats-card-red:hover { border-color: var(--danger-color); }

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    position: relative;
}

.stats-icon::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 16px;
    background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stats-card:hover .stats-icon::before {
    opacity: 1;
}

.stats-icon-blue {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: var(--primary-color);
}

.stats-icon-green {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: var(--success-color);
}

.stats-icon-red {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: var(--danger-color);
}

.stats-card:hover .stats-icon {
    transform: scale(1.1) rotate(5deg);
}

.stats-progress {
    margin-top: 1rem;
    height: 4px;
    background: var(--gray-200);
    border-radius: 2px;
    overflow: hidden;
}

.stats-progress-bar {
    height: 100%;
    border-radius: 2px;
    transition: width 1.5s ease-out;
    position: relative;
}

.stats-progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: shimmer 2s infinite;
}

.stats-progress-blue { background: linear-gradient(90deg, var(--primary-color), #60a5fa); }
.stats-progress-green { background: linear-gradient(90deg, var(--success-color), #34d399); }
.stats-progress-red { background: linear-gradient(90deg, var(--danger-color), #f87171); }

/* Counter Animation */
.counter {
    background: linear-gradient(135deg, currentColor, currentColor);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Action Cards */
.action-cards-container {
    animation: slideInRight 0.8s ease-out;
}

.action-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    gap: 1rem;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.5s ease;
}

.action-card:hover::before {
    left: 100%;
}

.action-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
}

.action-card-primary:hover { border-color: var(--primary-color); }
.action-card-success:hover { border-color: var(--success-color); }
.action-card-warning:hover { border-color: var(--warning-color); }
.action-card-purple:hover { border-color: var(--purple-color); }

.action-card-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: all 0.3s ease;
}

.action-card-primary .action-card-icon {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: var(--primary-color);
}

.action-card-success .action-card-icon {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: var(--success-color);
}

.action-card-warning .action-card-icon {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: var(--warning-color);
}

.action-card-purple .action-card-icon {
    background: linear-gradient(135deg, #e9d5ff, #ddd6fe);
    color: var(--purple-color);
}

.action-card:hover .action-card-icon {
    transform: scale(1.1);
}

.action-card-content h3 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    color: var(--gray-900);
}

.action-card-content p {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin: 0;
}

.action-card-arrow {
    margin-left: auto;
    color: var(--gray-400);
    transition: all 0.3s ease;
}

.action-card:hover .action-card-arrow {
    transform: translateX(4px);
    color: var(--gray-600);
}

/* Modern Table */
.modern-table-container {
    animation: fadeInUp 1s ease-out;
}

.modern-table-wrapper {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
}

.table-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--gray-700);
    border-bottom: 2px solid var(--gray-200);
    position: relative;
}

.table-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary-color), var(--success-color));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.modern-table:hover .table-header::after {
    transform: scaleX(1);
}

.table-row {
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--gray-100);
}

.table-row:hover {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    transform: scale(1.01);
    box-shadow: var(--shadow-sm);
}

.table-cell {
    padding: 1rem;
    color: var(--gray-900);
    vertical-align: middle;
}

.table-description {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.table-value {
    font-weight: 600;
    color: var(--success-color);
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.status-badge:hover {
    transform: scale(1.05);
}

.status-good {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #166534;
    border: 1px solid #bbf7d0;
}

.status-regular {
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    color: #92400e;
    border: 1px solid #fde68a;
}

.status-bad {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #991b1b;
    border: 1px solid #fecaca;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 0.875rem;
}

.action-btn:hover {
    transform: scale(1.1);
}

.action-btn-edit {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: var(--primary-color);
}

.action-btn-edit:hover {
    background: linear-gradient(135deg, #bfdbfe, #93c5fd);
    box-shadow: var(--shadow-md);
}

.action-btn-delete {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: var(--danger-color);
}

.action-btn-delete:hover {
    background: linear-gradient(135deg, #fecaca, #fca5a5);
    box-shadow: var(--shadow-md);
}

/* Modern Buttons */
.modern-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.modern-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.modern-btn:hover::before {
    left: 100%;
}

.modern-btn-success {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
    box-shadow: var(--shadow-sm);
}

.modern-btn-success:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state-content {
    animation: fadeInUp 0.6s ease-out;
}

.empty-state-content i {
    font-size: 4rem;
    color: var(--gray-300);
    margin-bottom: 1rem;
    animation: bounce 2s infinite;
}

.empty-state-content h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

.empty-state-content p {
    color: var(--gray-500);
    font-size: 0.875rem;
}

/* Responsive Design */
@media (min-width: 768px) {
    .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .md\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
}

@media (min-width: 1024px) {
    .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
}

/* Loading Animation */
.loading {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200px 100%;
    animation: shimmer 1.5s infinite;
}

/* Scrollbar Styling */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: var(--gray-100);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, var(--primary-color), var(--success-color));
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #2563eb, #059669);
}
</style>

<script>
// Counter Animation
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        // Start animation when element is in viewport
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
});

// Export and Reports functions
function exportData() {
    // Add loading animation
    const btn = event.target.closest('button');
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exportando...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
        // Here you would implement actual export functionality
        alert('Función de exportación en desarrollo');
    }, 2000);
}

function showReports() {
    // Add loading animation
    const btn = event.target.closest('button');
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cargando...';
    btn.disabled = true;
    
    setTimeout(() => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
        // Here you would implement actual reports functionality
        alert('Función de reportes en desarrollo');
    }, 2000);
}

// Add hover effects to table rows
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('.table-row');
    
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});
</script>
@endsection
