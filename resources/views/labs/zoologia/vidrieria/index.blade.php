@extends('layouts.app')

@section('title', 'Vidriería - Zoología y Botánica')
@section('page-title', 'Laboratorio de Zoología y Botánica')
@section('page-subtitle', 'Gestión de vidriería del laboratorio')

@section('content')

<div class="modern-inventory-container">
    <div class="card mb-6 modern-card">
        <div class="card-header modern-header">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-900">Lista de Vidriería</h2>
                <a href="{{ route('zoologia.vidrieria.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i> Agregar Item
                </a>
            </div>
        </div>

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
                                    oninput="document.getElementById('filterForm').submit()">
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

        <div class="table-container">
            <div class="overflow-x-auto modern-table-wrapper">
                <table class="modern-table" style="min-width: 1000px;">
                    <thead>
                        <tr>
                            <th class="table-header" style="width: 80px;">#</th>
                            <th class="table-header" style="width: 250px;">Nombre del Artículo</th>
                            <th class="table-header" style="width: 150px;">Volumen</th>
                            <th class="table-header" style="width: 150px;">Cantidad</th>
                            <th class="table-header" style="width: 150px;">Unidad</th>
                            <th class="table-header" style="width: 200px;">Detalle</th>
                            <th class="table-header" style="width: 250px;">Fecha de Registro</th>
                            <th class="table-header sticky-column" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="table-row">
                                <td class="table-cell">{{ $loop->iteration }}</td>
                                <td class="table-cell font-semibold text-gray-800">{{ $item->descripcion_elemento ?? $item->desc_sku }}</td>
                                <td class="table-cell">{{ $item->volumen ?? '-' }}</td>
                                <td class="table-cell">{{ $item->cantidad ?? '-' }}</td>
                                <td class="table-cell">{{ $item->unidad ?? '-' }}</td>
                                <td class="table-cell">{{ $item->atributos ?? '-' }}</td>
                                <td class="table-cell">{{ $item->created_at?->format('d/m/Y H:i') ?? '-' }}</td>
                                <td class="table-cell sticky-column">
                                    <div class="action-buttons d-flex align-items-center gap-2">
                                        <a href="{{ route('zoologia.vidrieria.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('zoologia.vidrieria.destroy', $item->id) }}" method="POST" class="d-inline">
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
                                <td colspan="8" class="empty-state">
                                    <div class="empty-state-content">
                                        <i class="fas fa-box-open"></i>
                                        <h3>No hay artículos de vidriería registrados</h3>
                                        <p>Agrega un nuevo artículo</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

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

@push('styles')
<style>
/* ========================================
   VARIABLES CSS
   ======================================== */
::root {
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

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(30px); }
    to { opacity: 1; transform: translateX(0); }
}

.modern-inventory-container { animation: fadeInUp 0.6s ease-out; }
.modern-card { background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-radius: 16px; box-shadow: var(--shadow-lg); border: 1px solid var(--gray-200); overflow: hidden; }
.modern-header { background: linear-gradient(135deg, #f8fafc, #f1f5f9); border-bottom: 1px solid var(--gray-200); padding: 1.5rem; }

.grid { display: grid; }
.grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
.md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
.lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
.gap-4 { gap: 1rem; }
.flex { display: flex; }
.justify-between { justify-content: space-between; }
.items-center { align-items: center; }
.text-xl { font-size: 1.25rem; line-height: 1.75rem; }
.font-semibold { font-weight: 600; }
.text-gray-900 { color: var(--gray-900); }

.modern-filters { animation: slideInRight 0.8s ease-out; }
.filter-group { position: relative; }
.search-input-container { position: relative; display: flex; align-items: center; }
.search-icon { position: absolute; left: 1rem; color: var(--gray-400); z-index: 1; }
.modern-input { width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 2px solid var(--gray-200); border-radius: 12px; background: white; font-size: 0.875rem; transition: all 0.3s ease; box-shadow: var(--shadow-sm); }
.modern-input:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(59,130,246,0.1); transform: translateY(-1px); }

.modern-btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; border: none; cursor: pointer; position: relative; overflow: hidden; }
.modern-btn::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,.2), transparent); transition: left .5s ease; }
.modern-btn:hover::before { left: 100%; }
.modern-btn-primary { background: linear-gradient(135deg, var(--primary-color), #60a5fa); color: #fff; box-shadow: var(--shadow-sm); }
.modern-btn-primary:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

.table-container { position: relative; }
.modern-table-wrapper { border-radius: 12px; overflow: hidden; box-shadow: var(--shadow-sm); overflow-x: auto; max-width: 100%; -webkit-overflow-scrolling: touch; scrollbar-width: thin; scrollbar-color: #3b82f6 #f3f4f6; }
.modern-table-wrapper::-webkit-scrollbar { height: 6px; }
.modern-table-wrapper::-webkit-scrollbar-thumb { background: linear-gradient(90deg, #3b82f6, #10b981); border-radius: 3px; }

.modern-table { width: 100%; min-width: 1200px; border-collapse: collapse; background: white; font-size: 0.813rem; line-height: 1.4; }
.table-header { background: linear-gradient(135deg, #f8fafc, #f1f5f9); padding: 0.65rem 0.5rem; text-align: left; font-weight: 600; font-size: 0.75rem; color: var(--gray-700); border-bottom: 2px solid var(--gray-200); position: relative; text-transform: uppercase; letter-spacing: .025em; }
.table-row { transition: all .2s ease; border-bottom: 1px solid var(--gray-100); }
.table-row:hover { background: linear-gradient(135deg, #f8fafc, #f1f5f9); transform: scale(1.005); box-shadow: var(--shadow-sm); }
.table-cell { padding: 0.65rem 0.5rem; color: var(--gray-900); vertical-align: middle; font-size: 0.813rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sticky-column { position: sticky !important; right: 0 !important; background: #fff !important; z-index: 10 !important; box-shadow: -3px 0 10px rgba(0,0,0,.08) !important; }

.status-badge { display: inline-flex; align-items: center; gap: .35rem; padding: .35rem .7rem; border-radius: 14px; font-size: .688rem; transition: all .3s ease; }
.status-good { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #166534; border: 1px solid #bbf7d0; }
.status-regular { background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; border: 1px solid #fde68a; }
.status-bad { background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border: 1px solid #fecaca; }

.pagination-container { margin-top: 1.5rem; padding: 1.25rem; background: #fff; border-radius: 12px; border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm); }
.pagination .page-link { min-width: 38px; height: 38px; padding: .5rem .85rem; border: 2px solid var(--gray-200); border-radius: 8px; background: #fff; color: var(--gray-700); font-weight: 500; transition: all .3s ease; box-shadow: var(--shadow-sm); }
.pagination .page-link:hover { border-color: var(--primary-color); background: linear-gradient(135deg, #eff6ff, #dbeafe); color: var(--primary-color); transform: translateY(-2px); box-shadow: var(--shadow-md); }
</style>
@endpush

@endsection


