@extends('layouts.app')

@section('title', 'Reactivos - Biotecnología')
@section('page-title', 'Laboratorio de Biotecnología')
@section('page-subtitle', 'Gestión de reactivos del laboratorio')

@section('content')

<div class="modern-inventory-container">
    <div class="card mb-6 modern-card">
        <div class="card-header modern-header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Lista de Reactivos</h2>
                <a href="{{ route('biotecnologia.reactivos.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i> Agregar Reactivo
                </a>
            </div>
        </div>

    
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
                            placeholder="Ej: Matraz, Probeta, Pipeta..."
                            class="modern-input search-input"
                            id="buscarInput">
                    </div>
                </div>
            </div>

            <div class="mt-4 flex gap-2">
                <a href="{{ url()->current() }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Limpiar
                </a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    let debounceTimer;

    $('#buscarInput').on('input', function() {
        clearTimeout(debounceTimer); // Reinicia el contador
        debounceTimer = setTimeout(() => {
            $('#filterForm').submit(); // Envía el formulario después de 2 segundos sin escribir
        }, 1500)// 00 ms = 2 segundos
    });
});
</script>
@endpush

        {{-- TABLA DE ITEMS --}}
        <div class="table-container">
            <div class="overflow-x-auto modern-table-wrapper">
                <table class="modern-table" style="min-width: 1000px;">
                    <thead>
                        <tr>
                            <th class="table-header" style="width: 80px;">#</th>
                            <th class="table-header" style="width: 250px;">Nombre del Reactivo</th>
                            <th class="table-header" style="width: 150px;">Cantidad</th>
                            <th class="table-header" style="width: 150px;">Unidad</th>
                            <th class="table-header" style="width: 180px;">Concentración</th>
                            <th class="table-header" style="width: 250px;">Detalle</th>
                            <th class="table-header" style="width: 250px;">Fecha de Registro</th>
                            <th class="table-header sticky-column" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="table-row">
                                <td class="table-cell">{{ $loop->iteration }}</td>
                                <td class="table-cell font-semibold text-gray-800">{{ $item->nombre_reactivo }}</td>
                                <td class="table-cell">{{ $item->cantidad ?? '-' }}</td>
                                <td class="table-cell">{{ $item->unidad ?? '-' }}</td>
                                <td class="table-cell">{{ $item->concentracion ?? '-' }}</td>
                                <td class="table-cell">{{ $item->detalle ?? '-' }}</td>
                                <td class="table-cell">{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="table-cell sticky-column">
                                    <div class="action-buttons d-flex align-items-center gap-2">
                                        <a href="{{ route('biotecnologia.reactivos.edit', $item->id) }}" 
                                           class="btn btn-warning btn-sm btn-edit" 
                                           data-id="{{ $item->id }}" title="Editar">
                                           <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('biotecnologia.reactivos.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm action-btn-delete" title="Eliminar"
                                                onclick="return confirm('¿Eliminar este reactivo?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    <div class="empty-state-content">
                                        <i class="fas fa-box-open"></i>
                                        <h3>No hay reactivos registrados</h3>
                                        <p>Agrega un nuevo reactivo químico</p>
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

<!-- Modal Bootstrap para Editar -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit me-2"></i>Editar Item
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="editModalBody">
                <div class="text-center py-5" id="loadingSpinner">
                    <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-3 text-muted">Cargando formulario...</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Mensajes de sesión con SweetAlert
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

    // Modal editar
    $('.btn-edit').click(function(e) {
        e.preventDefault();
        let url = $(this).attr('href');  
        let modalBody = $('#editModalBody');

        // Mostrar spinner
        modalBody.html($('#loadingSpinner').clone());
        $('#editModal').modal('show');

        // AJAX GET
        $.get(url, function(data) {
            let formHtml = `
                <form method="POST" action="${url.replace('/edit','')}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="${data.nombre_reactivo ? 'nombre_reactivo' : 'nombre_item'}" 
                               value="${data.nombre_reactivo ?? data.nombre_item}" class="form-control" required />
                    </div>
                    ${data.cantidad !== undefined ? `<div class="mb-3">
                        <label>Cantidad</label>
                        <input type="number" name="cantidad" value="${data.cantidad ?? ''}" class="form-control" />
                    </div>` : ''}
                    ${data.unidad !== undefined ? `<div class="mb-3">
                        <label>Unidad</label>
                        <input type="text" name="unidad" value="${data.unidad ?? ''}" class="form-control" />
                    </div>` : ''}
                    ${data.concentracion !== undefined ? `<div class="mb-3">
                        <label>Concentración</label>
                        <input type="text" name="concentracion" value="${data.concentracion ?? ''}" class="form-control" />
                    </div>` : ''}
                    ${data.volumen !== undefined ? `<div class="mb-3">
                        <label>Volumen</label>
                        <input type="text" name="volumen" value="${data.volumen ?? ''}" class="form-control" />
                    </div>` : ''}
                    ${data.detalle !== undefined ? `<div class="mb-3">
                        <label>Detalle</label>
                        <textarea name="detalle" class="form-control">${data.detalle ?? ''}</textarea>
                    </div>` : ''}
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            `;
            modalBody.html(formHtml);
        });
    });
});
</script>
@endpush




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

.table-scroll-indicator {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border: 1px solid #bfdbfe;
    border-radius: 6px;
    margin-bottom: 0.75rem;
    font-size: 0.75rem;
    color: #1e40af;
}

.table-scroll-indicator i {
    font-size: 0.875rem;
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
    min-width: 2400px;
    border-collapse: collapse;
    background: white;
    font-size: 0.813rem; /* 13px */
    line-height: 1.4;
   
}

.table-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 0.65rem 0.5rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.75rem; /* 12px */
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
    font-size: 0.813rem; /* 13px */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.table-row:hover .table-cell {
    font-weight: 500;
}

/* Fuente monoespaciada para números */
.table-cell:nth-child(1),  /* IR ID */
.table-cell:nth-child(2),  /* IV ID */
.table-cell:nth-child(3),  /* Código Regional */
.table-cell:nth-child(4),  /* Código Centro */
.table-cell:nth-child(6),  /* No. Placa */
.table-cell:nth-child(7),  /* Consecutivo */
.table-cell:nth-child(21)  /* Cédula */
{
    font-family: 'Courier New', Courier, monospace;
    font-weight: 500;
}

/* Descripciones largas */
.table-description-full {
    max-width: 300px;
    word-wrap: break-word;
    white-space: normal !important;
    line-height: 1.3;
    max-height: 70px;
    overflow-y: auto;
    font-size: 0.75rem; /* 12px */
}

/* ========================================
   IMÁGENES EN TABLA
   ======================================== */
.table-image-container {
    width: 55px;
    height: 55px;
    border-radius: 6px;
    overflow: hidden;
    border: 2px solid var(--gray-200);
    transition: all 0.3s ease;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
}

.table-image-container:hover {
    border-color: var(--primary-color);
    transform: scale(1.08);
    box-shadow: var(--shadow-md);
}

.table-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.table-image:hover {
    transform: scale(1.1);
}

.no-image {
    width: 55px;
    height: 55px;
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    border: 2px dashed var(--gray-300);
    border-radius: 6px;
    color: var(--gray-500);
    font-size: 0.625rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.no-image i {
    font-size: 1.1rem;
    margin-bottom: 0.15rem;
}

.no-image span {
    font-size: 0.563rem; /* 9px */
}

/* ========================================
   BADGES DE ESTADO
   ======================================== */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.7rem;
    border-radius: 14px;
    font-size: 0.688rem; /* 11px */
    font-weight: 500;
    transition: all 0.3s ease;
}

.status-badge:hover {
    transform: scale(1.05);
}

.status-badge i {
    font-size: 0.688rem;
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

/* ========================================
   VALORES MONETARIOS
   ======================================== */
.table-value {
    font-weight: 600;
    color: var(--success-color);
    font-size: 0.813rem;
    font-family: 'Courier New', monospace;
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

.pagination .page-item.disabled .page-link {
    background: var(--gray-100);
    border-color: var(--gray-200);
    color: var(--gray-400);
    cursor: not-allowed;
    opacity: 0.6;
}

.pagination .page-item.disabled .page-link:hover {
    transform: none;
    box-shadow: var(--shadow-sm);
    background: var(--gray-100);
}

.pagination .page-item:first-child .page-link::before {
    content: "← ";
    margin-right: 0.25rem;
}

.pagination .page-item:last-child .page-link::after {
    content: " →";
    margin-left: 0.25rem;
}

/* ========================================
   MODAL DE IMAGEN
   ======================================== */
.image-modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    backdrop-filter: blur(5px);
    animation: fadeIn 0.3s ease;
}

.image-modal-content {
    position: relative;
    margin: auto;
    padding: 20px;
    width: 90%;
    max-width: 800px;
    top: 50%;
    transform: translateY(-50%);
    background: white;
    border-radius: 12px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: slideInUp 0.3s ease;
}

.image-modal-close {
    position: absolute;
    top: 15px;
    right: 20px;
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    z-index: 1001;
    transition: color 0.3s ease;
}

.image-modal-close:hover {
    color: #000;
}

.image-modal-content img {
    width: 100%;
    height: auto;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 8px;
}

.image-modal-info {
    text-align: center;
    margin-top: 15px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
}

.image-modal-info p {
    margin: 0;
    color: #6b7280;
    font-weight: 500;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 1400px) {
    .modern-table {
        font-size: 0.75rem;
    }
    
    .table-header {
        font-size: 0.688rem;
        padding: 0.5rem 0.35rem;
    }
    
    .table-cell {
        padding: 0.5rem 0.35rem;
        font-size: 0.75rem;
    }
}

@media (max-width: 640px) {
    .pagination .page-link {
        min-width: 34px;
        height: 34px;
        padding: 0.35rem 0.65rem;
        font-size: 0.813rem;
    }
    
    .pagination-container {
        padding: 1rem;
    }
    
    .pagination-container .text-sm {
        font-size: 0.75rem;
    }
}

/* ========================================
   SCROLLBAR GLOBAL
   ======================================== */
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
@endpush




