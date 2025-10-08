@extends('layouts.app')

@section('title', 'Inventario')
@section('page-title', 'Inventario')
@section('page-subtitle', 'Gestiona el inventario del laboratorio')

@section('content')
<div class="modern-inventory-container">
    <div class="card mb-6 modern-card">
        <div class="card-header modern-header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Lista de Items</h2>
                <a href="{{ route('inventario.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Agregar Item
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filtros -->
            <div class="mb-6 modern-filters">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                        <div class="search-input-container">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" placeholder="Buscar por IR ID, SKU o descripción..." 
                                   class="modern-input search-input">
                        </div>
                    </div>
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gestión</label>
                        <div class="select-container">
                            <i class="fas fa-calendar-alt select-icon"></i>
                            <select class="modern-select">
                                <option value="">Todas las gestiones</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                            </select>
                        </div>
                    </div>
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                        <div class="select-container">
                            <i class="fas fa-filter select-icon"></i>
                            <select class="modern-select">
                                <option value="">Todos los estados</option>
                                <option value="bueno">Bueno</option>
                                <option value="regular">Regular</option>
                                <option value="malo">Malo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Items -->
            <div class="overflow-x-auto modern-table-wrapper">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th class="table-header">IR ID</th>
                            <th class="table-header">IV ID</th>
                            <th class="table-header">Desc. SKU</th>
                            <th class="table-header">Descripción</th>
                            <th class="table-header">No. Placa</th>
                            <th class="table-header">Valor</th>
                            <th class="table-header">Estado</th>
                            <th class="table-header">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                        <tr class="table-row" data-item-id="{{ $item->id }}">
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
                            <td colspan="8" class="empty-state">
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

        <!-- Paginación -->
        <div class="mt-6 flex justify-between items-center">
            <div class="text-sm text-gray-700">
                Mostrando {{ $items->firstItem() ?? 0 }} a {{ $items->lastItem() ?? 0 }} de {{ $items->total() }} resultados
            </div>
            <div class="flex space-x-2">
                @if($items->hasPages())
                    {{ $items->links() }}
                @endif
            </div>
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
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-700: #374151;
    --gray-900: #111827;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* Animaciones */
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

/* Layout */
.modern-inventory-container {
    animation: fadeInUp 0.6s ease-out;
}

.modern-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
    overflow: hidden;
}

.modern-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-bottom: 1px solid var(--gray-200);
    padding: 1.5rem;
}

/* Grid System */
.grid {
    display: grid;
}

.grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
.grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

.gap-4 { gap: 1rem; }
.gap-6 { gap: 1.5rem; }
.mb-2 { margin-bottom: 0.5rem; }
.mb-4 { margin-bottom: 1rem; }
.mb-6 { margin-bottom: 1.5rem; }
.mt-6 { margin-top: 1.5rem; }
.py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
.py-8 { padding-top: 2rem; padding-bottom: 2rem; }
.px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
.px-4 { padding-left: 1rem; padding-right: 1rem; }
.py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
.px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
.text-left { text-align: left; }
.text-center { text-align: center; }
.text-sm { font-size: 0.875rem; line-height: 1.25rem; }
.text-xs { font-size: 0.75rem; line-height: 1rem; }
.text-xl { font-size: 1.25rem; line-height: 1.75rem; }
.text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
.font-medium { font-weight: 500; }
.font-semibold { font-weight: 600; }
.text-gray-700 { color: var(--gray-700); }
.text-gray-900 { color: var(--gray-900); }
.text-gray-500 { color: var(--gray-500); }
.text-blue-600 { color: var(--primary-color); }
.text-blue-800 { color: #1e40af; }
.text-green-800 { color: #166534; }
.text-red-600 { color: var(--danger-color); }
.text-red-800 { color: #991b1b; }
.text-yellow-800 { color: #92400e; }
.bg-blue-100 { background-color: #dbeafe; }
.bg-green-100 { background-color: #dcfce7; }
.bg-yellow-100 { background-color: #fef3c7; }
.bg-gray-50 { background-color: var(--gray-50); }
.max-w-xs { max-width: 20rem; }
.truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.border { border-width: 1px; }
.border-b { border-bottom-width: 1px; }
.border-gray-100 { border-color: var(--gray-100); }
.border-gray-200 { border-color: var(--gray-200); }
.border-gray-300 { border-color: var(--gray-300); }
.rounded-md { border-radius: 0.375rem; }
.rounded-full { border-radius: 9999px; }
.w-full { width: 100%; }
.overflow-x-auto { overflow-x: auto; }
.hover\:bg-gray-50:hover { background-color: var(--gray-50); }
.hover\:text-blue-800:hover { color: #1e40af; }
.hover\:text-red-800:hover { color: #991b1b; }
.focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
.focus\:ring-2:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
.focus\:ring-blue-500:focus { --tw-ring-color: #3b82f6; }
.block { display: block; }
.flex { display: flex; }
.justify-between { justify-content: space-between; }
.items-center { align-items: center; }
.space-x-2 > * + * { margin-left: 0.5rem; }

/* Modern Filters */
.modern-filters {
    animation: slideInRight 0.8s ease-out;
}

.filter-group {
    position: relative;
}

.search-input-container,
.select-container {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon,
.select-icon {
    position: absolute;
    left: 1rem;
    color: var(--gray-400);
    z-index: 1;
    transition: color 0.3s ease;
}

.modern-input,
.modern-select {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    background: white;
    font-size: 0.875rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.modern-input:focus,
.modern-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

.modern-input:focus + .search-icon,
.modern-select:focus + .select-icon {
    color: var(--primary-color);
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

.modern-btn-primary {
    background: linear-gradient(135deg, var(--primary-color), #60a5fa);
    color: white;
    box-shadow: var(--shadow-sm);
}

.modern-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

/* Modern Table */
.modern-table-wrapper {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    margin-top: 1rem;
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

/* Pagination */
.pagination-container {
    margin-top: 1.5rem;
    padding: 1rem;
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-radius: 12px;
    border: 1px solid var(--gray-200);
}

/* Responsive Design */
@media (min-width: 768px) {
    .md\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
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
// Add interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Table row hover effects
    const tableRows = document.querySelectorAll('.table-row');
    
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.01)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.table-row');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                    row.style.animation = 'fadeInUp 0.3s ease-out';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Filter functionality
    const filterSelects = document.querySelectorAll('.modern-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Add loading animation
            const wrapper = this.closest('.modern-table-wrapper');
            wrapper.style.opacity = '0.7';
            
            setTimeout(() => {
                wrapper.style.opacity = '1';
                // Here you would implement actual filtering logic
            }, 300);
        });
    });
});
</script>
@endsection
