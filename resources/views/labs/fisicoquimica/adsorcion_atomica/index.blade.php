@extends('layouts.app')

@section('title', 'Adsorción Atómica - Físico Química')
@section('page-title', 'Laboratorio de Físico Química')
@section('page-subtitle', 'Gestión de adsorción atómica')

@section('content')

<div class="modern-inventory-container">
    <div class="card mb-6 modern-card">
        <div class="card-header modern-header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Adsorción Atómica</h2>
                <a href="{{ route('fisicoquimica.adsorcion.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i> Agregar Artículo
                </a>
            </div>
        </div>

        @include('components.export-buttons', [
            'pdfRoute' => 'fisicoquimica.adsorcion.export.pdf',
            'excelRoute' => 'fisicoquimica.adsorcion.export.excel'
        ])

        {{-- FILTRO DE BÚSQUEDA --}}
        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}" id="filterForm">
                <div class="mb-6 modern-filters">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="filter-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar por nombre</label>
                            <div class="search-input-container">
                                <i class="fas fa-search search-icon"></i>
                                <input 
                                    type="text" 
                                    name="buscar" 
                                    value="{{ request('buscar') }}" 
                                    placeholder="Ej: Equipo, muestra..."
                                    class="modern-input search-input"
                                    id="buscarInput">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex gap-2 flex-wrap">
                        <a href="{{ url()->current() }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                        <a href="{{ route('fisicoquimica.adsorcion_equipos.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="fas fa-tools"></i> Equipos
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- TABLA DE ITEMS --}}
        <div class="table-container">
            <div class="overflow-x-auto modern-table-wrapper">
                <table class="modern-table" style="min-width: 1000px;">
                    <thead>
                        <tr>
                            <th class="table-header" style="width: 80px;">#</th>
                            <th class="table-header" style="width: 250px;">Nombre del Artículo</th>
                            <th class="table-header" style="width: 150px;">Cantidad</th>
                            <th class="table-header" style="width: 150px;">Unidad</th>
                            <th class="table-header" style="width: 180px;">Detalle</th>
                            <th class="table-header" style="width: 250px;">Fecha de Registro</th>
                            <th class="table-header sticky-column" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="table-row">
                                <td class="table-cell">{{ $loop->iteration }}</td>
                                <td class="table-cell font-semibold text-gray-800">{{ $item->nombre_item }}</td>
                                <td class="table-cell">{{ $item->cantidad ?? '-' }}</td>
                                <td class="table-cell">{{ $item->unidad ?? '-' }}</td>
                                <td class="table-cell">{{ $item->detalle ?? '-' }}</td>
                                <td class="table-cell">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</td>
                                <td class="table-cell sticky-column">
                                    <div class="action-buttons d-flex align-items-center gap-2">
                                        <a href="#" class="btn btn-warning btn-sm btn-edit" data-id="{{ $item->id }}" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('fisicoquimica.adsorcion.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm action-btn-delete" title="Eliminar"
                                                onclick="return confirm('¿Eliminar este artículo?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <div class="empty-state-content">
                                        <i class="fas fa-box-open"></i>
                                        <h3>No hay artículos registrados</h3>
                                        <p>Agrega un nuevo artículo</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINACIÓN --}}
        @if(method_exists($items, 'links'))
            <div class="pagination-container">
                <div class="flex justify-between items-center flex-wrap gap-4">
                    <div class="text-sm font-medium text-gray-700">
                        Mostrando {{ $items->firstItem() ?? 0 }} a {{ $items->lastItem() ?? 0 }} de {{ $items->total() ?? count($items) }} resultados
                    </div>
                    {{ $items->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
</div>

{{-- MENSAJES DE SESIÓN --}}
@push('scripts')
<script>
$(document).ready(function() {
    let debounceTimer;

    $('#buscarInput').on('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            $('#filterForm').submit();
        }, 1500);
    });
});
</script>
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: '¡Éxito!',
    text: '{{ session('success') }}',
    confirmButtonColor: '#28a745',
    timer: 2500
});
@endif

@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: '{{ session('error') }}',
    confirmButtonColor: '#dc3545'
});
@endif
</script>
@endpush

{{-- MODAL DE EDICIÓN MODERNO --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit"></i> Editar Artículo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div id="loadingSpinner">
                    <div class="spinner-border" role="status"></div>
                    <p>Cargando...</p>
                </div>
                <form id="editForm" style="display:none;" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombre_item">Nombre del artículo</label>
                            <input type="text" name="nombre_item" id="nombre_item" class="modern-input">
                        </div>
                        <div>
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidad" id="cantidad" class="modern-input">
                        </div>
                        <div>
                            <label for="unidad">Unidad</label>
                            <input type="text" name="unidad" id="unidad" class="modern-input">
                        </div>
                        <div>
                            <label for="detalle">Detalle</label>
                            <textarea name="detalle" id="detalle" rows="3" class="modern-input"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-guardar" form="editForm">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* ========================================
   VARIABLES CSS
   ======================================== */
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

/* ========================================
   ANIMACIONES
   ======================================== */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% { transform: translate3d(0, 0, 0); }
    40%, 43% { transform: translate3d(0, -8px, 0); }
    70% { transform: translate3d(0, -4px, 0); }
    90% { transform: translate3d(0, -2px, 0); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideInUp {
    from { opacity: 0; transform: translateY(-50%) translateY(30px); }
    to { opacity: 1; transform: translateY(-50%) translateY(0); }
}

/* ========================================
   LAYOUT BASE
   ======================================== */
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

/* ========================================
   SISTEMA DE GRID Y UTILIDADES
   ======================================== */
.grid { display: grid; }
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
.px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
.px-4 { padding-left: 1rem; padding-right: 1rem; }
.text-left { text-align: left; }
.text-center { text-align: center; }
.text-sm { font-size: 0.875rem; line-height: 1.25rem; }
.text-xs { font-size: 0.75rem; line-height: 1rem; }
.text-xl { font-size: 1.25rem; line-height: 1.75rem; }
.font-medium { font-weight: 500; }
.font-semibold { font-weight: 600; }
.font-bold { font-weight: 700; }
.text-gray-700 { color: var(--gray-700); }
.text-gray-900 { color: var(--gray-900); }
.text-blue-600 { color: var(--primary-color); }
.w-full { width: 100%; }
.block { display: block; }
.flex { display: flex; }
.justify-between { justify-content: space-between; }
.items-center { align-items: center; }
.flex-wrap { flex-wrap: wrap; }
.overflow-x-auto { overflow-x: auto; }

@media (min-width: 768px) {
    .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
@media (min-width: 1024px) {
    .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
}

/* ========================================
   FILTROS MODERNOS
   ======================================== */
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

/* ========================================
   BOTONES MODERNOS
   ======================================== */
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
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
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

/* ========================================
   TABLA COMPACTA Y MODERNA
   ======================================== */
.table-container {
    position: relative;
}

.modern-table-wrapper {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    overflow-x: auto;
    max-width: 100%;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: #3b82f6 #f3f4f6;
}

.modern-table-wrapper::-webkit-scrollbar {
    height: 6px;
}

.modern-table-wrapper::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 3px;
}

.modern-table-wrapper::-webkit-scrollbar-thumb {
    background: linear-gradient(90deg, #3b82f6, #10b981);
    border-radius: 3px;
}

.modern-table {
    width: 100%;
    min-width: 1000px;
    border-collapse: collapse;
    background: white;
    font-size: 0.813rem;
    line-height: 1.4;
}

.table-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 0.65rem 0.5rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.75rem;
    color: var(--gray-700);
    border-bottom: 2px solid var(--gray-200);
    position: relative;
    text-transform: uppercase;
    letter-spacing: 0.025em;
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
    transform: scale(1.005);
    box-shadow: var(--shadow-sm);
}

.table-cell {
    padding: 0.65rem 0.5rem;
    color: var(--gray-900);
    vertical-align: middle;
    font-size: 0.813rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.table-row:hover .table-cell {
    font-weight: 500;
}

/* ========================================
   BOTONES DE ACCIÓN
   ======================================== */
.action-buttons {
    display: flex;
    gap: 0.3rem;
    justify-content: center;
}

.action-btn {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 0.75rem;
}

.action-btn:hover {
    transform: scale(1.1);
}

.action-btn-delete {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: var(--danger-color);
}

.action-btn-delete:hover {
    background: linear-gradient(135deg, #fecaca, #fca5a5);
    box-shadow: var(--shadow-md);
}

/* ========================================
   COLUMNA STICKY (ACCIONES)
   ======================================== */
.sticky-column {
    position: sticky !important;
    right: 0 !important;
    background: white !important;
    z-index: 10 !important;
    box-shadow: -3px 0 10px rgba(0, 0, 0, 0.08) !important;
}

.table-row:hover .sticky-column {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9) !important;
}

/* ========================================
   ESTADO VACÍO
   ======================================== */
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

/* ========================================
   PAGINACIÓN MODERNA
   ======================================== */
.pagination-container {
    margin-top: 1.5rem;
    padding: 1.25rem;
    background: white;
    border-radius: 12px;
    border: 1px solid var(--gray-200);
    box-shadow: var(--shadow-sm);
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination .page-item {
    list-style: none;
}

.pagination .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0.5rem 0.85rem;
    border: 2px solid var(--gray-200);
    border-radius: 8px;
    background: white;
    color: var(--gray-700);
    font-weight: 500;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: var(--shadow-sm);
}

.pagination .page-link:hover {
    border-color: var(--primary-color);
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    color: var(--primary-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary-color), #60a5fa);
    border-color: var(--primary-color);
    color: white;
    box-shadow: var(--shadow-md);
    font-weight: 600;
}

/* ========================================
   MODAL DE EDICIÓN MODERNO
   ======================================== */
#editModal .modal-content {
    border-radius: 16px;
    overflow: hidden;
    border: none;
    box-shadow: var(--shadow-xl);
    animation: fadeInUp 0.5s ease-out;
}

#editModal .modal-header {
    background: linear-gradient(135deg, var(--danger-color), #f87171);
    color: white;
    padding: 1rem 1.25rem;
    border-bottom: none;
}

#editModal .modal-title {
    font-weight: 600;
    font-size: 1.125rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

#editModal .btn-close {
    filter: invert(1);
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

#editModal .btn-close:hover {
    opacity: 1;
}

#editModal .modal-body {
    background: var(--gray-50);
    padding: 1.5rem;
    max-height: 75vh;
    overflow-y: auto;
}

#editModal #loadingSpinner {
    text-align: center;
    padding: 3rem 0;
}

#editModal #loadingSpinner .spinner-border {
    width: 3rem;
    height: 3rem;
    color: var(--danger-color);
}

#editModal #loadingSpinner p {
    margin-top: 1rem;
    color: var(--gray-500);
    font-size: 0.875rem;
}

#editModal form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1rem;
}

#editModal label {
    font-weight: 600;
    font-size: 0.875rem;
    color: var(--gray-700);
    margin-bottom: 0.35rem;
}

#editModal input,
#editModal select,
#editModal textarea {
    width: 100%;
    border: 2px solid var(--gray-200);
    border-radius: 10px;
    padding: 0.65rem 0.85rem;
    background: white;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

#editModal input:focus,
#editModal select:focus,
#editModal textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    transform: translateY(-1px);
}

#editModal .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    border-top: 1px solid var(--gray-200);
    background: #fff;
}

#editModal .btn-cancelar {
    background: var(--gray-100);
    color: var(--gray-700);
    font-weight: 500;
    border-radius: 10px;
    padding: 0.6rem 1.25rem;
    border: none;
    transition: all 0.3s ease;
}

#editModal .btn-cancelar:hover {
    background: var(--gray-200);
    transform: translateY(-1px);
}

#editModal .btn-guardar {
    background: linear-gradient(135deg, var(--success-color), #34d399);
    color: white;
    font-weight: 600;
    border-radius: 10px;
    padding: 0.6rem 1.25rem;
    border: none;
    transition: all 0.3s ease;
}

#editModal .btn-guardar:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    const editForm = document.getElementById('editForm');
    const loadingSpinner = document.getElementById('loadingSpinner');

    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const itemId = this.dataset.id;

            loadingSpinner.style.display = 'block';
            editForm.style.display = 'none';
            editModal.show();

            fetch(`/fisicoquimica/adsorcion-atomica/${itemId}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('nombre_item').value = data.nombre_item || '';
                    document.getElementById('cantidad').value = data.cantidad || '';
                    document.getElementById('unidad').value = data.unidad || '';
                    document.getElementById('detalle').value = data.detalle || '';
                    editForm.action = `/fisicoquimica/adsorcion-atomica/${itemId}`;
                    loadingSpinner.style.display = 'none';
                    editForm.style.display = 'grid';
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar los datos',
                        confirmButtonColor: '#dc3545'
                    });
                    editModal.hide();
                });
        });
    });
});
</script>
@endpush

@endsection

