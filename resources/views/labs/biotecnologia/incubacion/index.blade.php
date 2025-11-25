@extends('layouts.app')

@section('title', 'Incubación - Biotecnología')
@section('page-title', 'Laboratorio de Biotecnología')
@section('page-subtitle', 'Gestión de incubación')

@section('content')

<div class="modern-inventory-container">
    <div class="card mb-6 modern-card">
        <div class="card-header modern-header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Lista de Items - Incubación</h2>
                <a href="{{ route('biotecnologia.incubacion.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i> Agregar Item
                </a>
            </div>
        </div>

            @include('components.export-buttons', [
                'pdfRoute' => 'biotecnologia.incubacion.export.pdf',
                'excelRoute' => 'biotecnologia.incubacion.export.excel'
            ])

        {{-- FILTRO DE BÚSQUEDA --}}
        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}" id="filterForm">
                <div class="mb-6 modern-filters">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Buscar -->
                        <div class="filter-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                            <div class="search-input-container">
                                <i class="fas fa-search search-icon"></i>
                                <input 
                                    type="text" 
                                    name="buscar" 
                                    value="{{ request('buscar') }}" 
                                    placeholder="Buscar por IR ID, SKU o descripción..."
                                    class="modern-input search-input"
                                    id="buscarInput">
                            </div>
                        </div>

                        <!-- Filtro por Placa -->
                        <div class="filter-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Placa</label>
                            <div class="search-input-container">
                                <i class="fas fa-hashtag search-icon"></i>
                                <input 
                                    type="text" 
                                    name="no_placa" 
                                    value="{{ request('no_placa') }}" 
                                    placeholder="Buscar por número de placa..."
                                    class="modern-input search-input"
                                    id="placaInput">
                            </div>
                        </div>

                        <!-- Tipo de Material -->
                        <div class="filter-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Material</label>
                            <div class="select-container">
                                <i class="fas fa-cubes select-icon"></i>
                                <select 
                                    name="tipo_material" 
                                    class="modern-select" 
                                    onchange="this.closest('form').submit()">
                                    <option value="">Todos los tipos</option>
                                    <option value="Equipos" {{ request('tipo_material') == 'Equipos' ? 'selected' : '' }}>Equipos</option>
                                    <option value="Muebles" {{ request('tipo_material') == 'Muebles' ? 'selected' : '' }}>Muebles</option>
                                    <option value="Vidriería" {{ request('tipo_material') == 'Vidriería' ? 'selected' : '' }}>Vidriería</option>
                                </select>
                            </div>
                        </div>

                        <!-- Cuentadante -->
                        <div class="filter-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filtrar por Cuentadante</label>
                            <div class="select-container">
                                <i class="fas fa-user-tie select-icon"></i>
                                <select 
                                    name="nombre_responsable" 
                                    class="modern-select" 
                                    onchange="this.closest('form').submit()">
                                    <option value="">Todos los cuentadantes</option>
                                    @php
                                        $responsables = \App\Models\BiotecnologiaIncubacion::select('nombre_responsable')
                                            ->whereNotNull('nombre_responsable')
                                            ->where('nombre_responsable', '!=', '')
                                            ->groupBy('nombre_responsable')
                                            ->orderBy('nombre_responsable')
                                            ->get();
                                    @endphp
                                    @foreach($responsables as $r)
                                        <option value="{{ $r->nombre_responsable }}" 
                                            {{ request('nombre_responsable') == $r->nombre_responsable ? 'selected' : '' }}>
                                            {{ $r->nombre_responsable }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-4 flex gap-2 flex-wrap">
                        <a href="{{ url()->current() }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>


        {{-- TABLA DE ITEMS --}}
        <div class="table-container">
            <div class="overflow-x-auto modern-table-wrapper">
                <table class="modern-table" style="min-width: 2700px; table-layout: fixed;">
                    <thead>
                        <tr>
                            <th class="table-header" style="width: 100px;">IR ID</th>
                            <th class="table-header" style="width: 100px;">IV ID</th>
                            <th class="table-header" style="width: 120px;">Código Regional</th>
                            <th class="table-header" style="width: 120px;">Código Centro</th>
                            <th class="table-header" style="width: 150px;">Desc. Almacén</th>
                            <th class="table-header" style="width: 110px;">No. Placa</th>
                            <th class="table-header" style="width: 110px;">Consecutivo</th>
                            <th class="table-header" style="width: 150px;">Desc. SKU</th>
                            <th class="table-header" style="width: 100px;">Serial</th>
                            <th class="table-header" style="width: 200px;">Descripción Completa</th>
                            <th class="table-header" style="width: 150px;">Atributos</th>
                            <th class="table-header" style="width: 100px;">Imagen</th>
                            <th class="table-header" style="width: 120px;">Fecha Adq.</th>
                            <th class="table-header" style="width: 130px;">Valor</th>
                            <th class="table-header" style="width: 110px;">Estado</th>
                            <th class="table-header" style="width: 130px;">Tipo de Material</th>
                            <th class="table-header" style="width: 130px;">Gestión</th>
                            <th class="table-header" style="width: 120px;">Uso</th>
                            <th class="table-header" style="width: 120px;">Contrato</th>
                            <th class="table-header" style="width: 180px;">Nombre Responsable</th>
                            <th class="table-header" style="width: 130px;">Cédula</th>
                            <th class="table-header" style="width: 150px;">Vinculación</th>
                            <th class="table-header" style="width: 120px;">Fecha Registro</th>
                            <th class="table-header" style="width: 180px;">Usuario Registra</th>
                            <th class="table-header sticky-column" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="table-row" data-item-id="{{ $item->id }}">
                                <td class="table-cell">{{ $item->ir_id }}</td>
                                <td class="table-cell">{{ $item->iv_id ?? '-' }}</td>
                                <td class="table-cell">{{ $item->cod_regional ?? '-' }}</td>
                                <td class="table-cell">{{ $item->cod_centro ?? '-' }}</td>
                                <td class="table-cell">{{ $item->desc_almacen ?? '-' }}</td>
                                <td class="table-cell">{{ $item->no_placa }}</td>
                                <td class="table-cell">{{ $item->consecutivo ?? '-' }}</td>
                                <td class="table-cell">{{ $item->desc_sku }}</td>
                                <td class="table-cell">{{ $item->serial ?? '-' }}</td>
                                <td class="table-cell">
                                    <div class="table-description-full" title="{{ $item->descripcion_elemento }}">
                                        {{ $item->descripcion_elemento }}
                                    </div>
                                </td>
                                <td class="table-cell">
                                    <div class="table-description-full" title="{{ $item->atributos }}">
                                        {{ $item->atributos ?? '-' }}
                                    </div>
                                </td>
                                <td class="table-cell">
                                    @if($item->foto)
                                        <div class="table-image-container">
                                            <img src="{{ asset('uploads/biotecnologia_incubacion/' . $item->foto) }}"
                                                alt="Imagen del item" class="table-image"
                                                onclick="openImageModal('{{ asset('uploads/biotecnologia_incubacion/' . $item->foto) }}')">
                                        </div>
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-image"></i>
                                            <span>Sin imagen</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="table-cell">{{ $item->fecha_adq ? $item->fecha_adq->format('d/m/Y') : '-' }}</td>
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
                                <td class="table-cell">{{ $item->tipo_material ?? '-' }}</td>
                                <td class="table-cell">{{ $item->gestion ?? 'SIN GESTIONAR' }}</td>
                                <td class="table-cell">{{ $item->uso ?? '-' }}</td>
                                <td class="table-cell">{{ $item->contrato ?? '-' }}</td>
                                <td class="table-cell">{{ $item->nombre_responsable ?? '-' }}</td>
                                <td class="table-cell">{{ $item->cedula ?? '-' }}</td>
                                <td class="table-cell">{{ $item->vinculacion ?? '-' }}</td>
                                <td class="table-cell">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</td>
                                <td class="table-cell">{{ $item->usuario_registra ?? '-' }}</td>
                                <td class="table-cell sticky-column">
                                    <div class="action-buttons d-flex align-items-center gap-2">
                                        <a href="{{ route('biotecnologia.incubacion.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('biotecnologia.incubacion.destroy', $item->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm action-btn action-btn-delete"
                                                title="Eliminar" onclick="return confirm('¿Eliminar este item?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="25" class="empty-state">
                                    <div class="empty-state-content">
                                        <i class="fas fa-box-open"></i>
                                        <h3>No hay items registrados</h3>
                                        <p>Agrega un nuevo item de incubación</p>
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

@push('scripts')
<script>
$(document).ready(function() {
    // Debounce para búsqueda
    let debounceTimer;

    $('#buscarInput').on('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            $('#filterForm').submit();
        }, 1500);
    });

    $('#placaInput').on('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            $('#filterForm').submit();
        }, 1500);
    });

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
});
</script>
@endpush

@push('styles')
<style>
/* Estilos para la vista de incubación - basados en inventario */
:root {
    --primary-color: #3b82f6;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
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
}

.modern-inventory-container {
    animation: fadeInUp 0.6s ease-out;
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

.modern-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
}

.modern-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-bottom: 1px solid var(--gray-200);
    padding: 1.5rem;
}

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

.modern-filters {
    animation: slideInRight 0.8s ease-out;
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

.modern-input, .modern-select {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    background: white;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.modern-input:focus, .modern-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.search-input-container, .select-container {
    position: relative;
}

.search-icon, .select-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    z-index: 1;
}

.table-container {
    position: relative;
}

.table-scroll-indicator {
    text-align: center;
    padding: 0.5rem;
    background: var(--gray-100);
    color: var(--gray-600);
    font-size: 0.75rem;
    border-radius: 8px 8px 0 0;
}

.modern-table-wrapper {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    font-size: 0.813rem;
}

.table-header {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    padding: 0.65rem 0.5rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.75rem;
    color: var(--gray-700);
    border-bottom: 2px solid var(--gray-200);
    text-transform: uppercase;
    letter-spacing: 0.025em;
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
}

.sticky-column {
    position: sticky !important;
    right: 0 !important;
    background: #fff !important;
    z-index: 10 !important;
    box-shadow: -3px 0 10px rgba(0,0,0,0.08) !important;
}

.table-image-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.table-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.table-image:hover {
    transform: scale(1.1);
}

.no-image {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: var(--gray-400);
    font-size: 0.75rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-good {
    background: #dcfce7;
    color: #166534;
}

.status-regular {
    background: #fef3c7;
    color: #92400e;
}

.status-bad {
    background: #fee2e2;
    color: #991b1b;
}

.table-value {
    font-weight: 600;
    color: var(--success-color);
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state-content i {
    font-size: 4rem;
    color: var(--gray-300);
    margin-bottom: 1rem;
}

.action-buttons .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
}

.pagination-container {
    padding: 1.5rem;
    background: var(--gray-50);
    border-top: 1px solid var(--gray-200);
}

.filter-group {
    margin-bottom: 0;
}

.mb-6 {
    margin-bottom: 1.5rem;
}

.mt-4 {
    margin-top: 1rem;
}

.flex {
    display: flex;
}

.gap-2 {
    gap: 0.5rem;
}

.flex-wrap {
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 0.875rem;
}

.btn-secondary {
    background: var(--gray-500);
    color: white;
}

.btn-secondary:hover {
    background: var(--gray-600);
    transform: translateY(-1px);
}

.grid {
    display: grid;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
}

.gap-4 {
    gap: 1rem;
}

@media (min-width: 768px) {
    .md\:grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (min-width: 1024px) {
    .lg\:grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

.btn-warning {
    background: var(--warning-color);
    color: white;
}

.btn-danger {
    background: var(--danger-color);
    color: white;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
}

.text-gray-600 {
    color: var(--gray-600);
}
</style>
@endpush
@endsection


