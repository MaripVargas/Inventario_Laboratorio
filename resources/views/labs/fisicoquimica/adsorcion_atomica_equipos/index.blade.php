@extends('layouts.app')

@section('title', 'Equipos de Adsorción Atómica - Físico Química')
@section('page-title', 'Lab. Físico Química')
@section('page-subtitle', 'Gestión de equipos de adsorción atómica')

@section('content')
<div class="modern-inventory-container">
    <div class="card mb-6 modern-card">
        <div class="card-header modern-header">
            <div class="flex justify-between items-center flex-wrap gap-3">
                <h2 class="text-xl font-semibold text-gray-900">Equipos de Adsorción Atómica</h2>
                <div class="flex gap-2">
                    <a href="{{ route('fisicoquimica.adsorcion.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a Adsorción Atómica
                    </a>
                    <a href="{{ route('fisicoquimica.adsorcion_equipos.create') }}" class="modern-btn modern-btn-primary">
                        <i class="fas fa-plus"></i> Agregar Equipo
                    </a>
                </div>
            </div>
        </div>

        @include('components.export-buttons', [
            'pdfRoute' => 'fisicoquimica.adsorcion_equipos.export.pdf',
            'excelRoute' => 'fisicoquimica.adsorcion_equipos.export.excel'
        ])

        <div class="card-body">
            <form method="GET" action="{{ url()->current() }}" id="filterEquiposForm">
                <div class="mb-6 modern-filters">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="filter-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                            <div class="search-input-container">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Nombre, placa o responsable..." class="modern-input search-input" oninput="document.getElementById('filterEquiposForm').submit()">
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
                <table class="modern-table" style="min-width: 1200px;">
                    <thead>
                        <tr>
                            <th class="table-header" style="width: 60px;">#</th>
                            <th class="table-header" style="width: 220px;">Nombre</th>
                            <th class="table-header" style="width: 120px;">Cantidad</th>
                            <th class="table-header" style="width: 120px;">Unidad</th>
                            <th class="table-header" style="width: 200px;">Detalle</th>
                            <th class="table-header" style="width: 160px;">No. Placa</th>
                            <th class="table-header" style="width: 150px;">Fecha Adq.</th>
                            <th class="table-header" style="width: 150px;">Valor</th>
                            <th class="table-header" style="width: 200px;">Responsable</th>
                            <th class="table-header" style="width: 140px;">Cédula</th>
                            <th class="table-header" style="width: 160px;">Vinculación</th>
                            <th class="table-header" style="width: 150px;">Fecha Registro</th>
                            <th class="table-header" style="width: 160px;">Usuario Registra</th>
                            <th class="table-header sticky-column" style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="table-row">
                                <td class="table-cell">{{ $loop->iteration }}</td>
                                <td class="table-cell font-semibold text-gray-800">{{ $item->nombre }}</td>
                                <td class="table-cell">{{ $item->cantidad ?? '-' }}</td>
                                <td class="table-cell">{{ $item->unidad ?? '-' }}</td>
                                <td class="table-cell">{{ $item->detalle ?? '-' }}</td>
                                <td class="table-cell">{{ $item->no_placa ?? '-' }}</td>
                                <td class="table-cell">{{ $item->fecha_adq?->format('d/m/Y') ?? '-' }}</td>
                                <td class="table-cell">{{ $item->valor ? '$'.number_format($item->valor, 2) : '-' }}</td>
                                <td class="table-cell">{{ $item->nombre_responsable ?? '-' }}</td>
                                <td class="table-cell">{{ $item->cedula ?? '-' }}</td>
                                <td class="table-cell">{{ $item->vinculacion ?? '-' }}</td>
                                <td class="table-cell">{{ $item->fecha_registro?->format('d/m/Y') ?? '-' }}</td>
                                <td class="table-cell">{{ $item->usuario_registra ?? '-' }}</td>
                                <td class="table-cell sticky-column">
                                    <div class="action-buttons d-flex align-items-center gap-2">
                                        <a href="{{ route('fisicoquimica.adsorcion_equipos.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('fisicoquimica.adsorcion_equipos.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm action-btn-delete" title="Eliminar" onclick="return confirm('¿Eliminar este equipo?')"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="empty-state">
                                    <div class="empty-state-content">
                                        <i class="fas fa-box-open"></i>
                                        <h3>No hay equipos registrados</h3>
                                        <p>Agrega un nuevo equipo de Adsorción Atómica</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
::root {
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
.modern-inventory-container { animation: fadeInUp 0.6s ease-out; }
.modern-card {	background: linear-gradient(135deg,#ffffff 0%,#f8fafc 100%); border-radius:16px; box-shadow:var(--shadow-lg); border:1px solid var(--gray-200); }
.modern-header {	background: linear-gradient(135deg,#f8fafc,#f1f5f9); border-bottom:1px solid var(--gray-200); padding:1.5rem; }
.modern-btn { display:inline-flex; align-items:center; gap:.5rem; padding:.75rem 1.5rem; border-radius:12px; font-weight:500; text-decoration:none; transition:all .3s ease; border:none; cursor:pointer; position:relative; overflow:hidden; }
@keyframes fadeInUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
@keyframes slideInRight { from { opacity:0; transform:translateX(30px); } to { opacity:1; transform:translateX(0); } }
.modern-inventory-container { animation: fadeInUp 0.6s ease-out; }
.modern-card {	background: linear-gradient(135deg,#ffffff 0%,#f8fafc 100%); border-radius:16px; box-shadow:var(--shadow-lg); border:1px solid var(--gray-200); }
.modern-header {	background: linear-gradient(135deg,#f8fafc,#f1f5f9); border-bottom:1px solid var(--gray-200); padding:1.5rem; }
.modern-btn { display:inline-flex; align-items:center; gap:.5rem; padding:.75rem 1.5rem; border-radius:12px; font-weight:500; text-decoration:none; transition:all .3s ease; border:none; cursor:pointer; position:relative; overflow:hidden; }
.modern-btn::before { content:''; position:absolute; top:0; left:-100%; width:100%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,.2),transparent); transition:left .5s ease; }
.modern-btn:hover::before { left:100%; }
.modern-btn-primary { background:linear-gradient(135deg,var(--primary-color),#60a5fa); color:#fff; box-shadow:var(--shadow-sm); }
.modern-btn-secondary { background:linear-gradient(135deg,#6b7280,#9ca3af); color:#fff; box-shadow:var(--shadow-sm); }
.modern-filters { animation: slideInRight 0.8s ease-out; }
.modern-input { width:100%; padding:.75rem 1rem .75rem 2.5rem; border:2px solid var(--gray-200); border-radius:12px; background:#fff; font-size:.875rem; transition:all .3s ease; box-shadow:var(--shadow-sm); }
.modern-input:focus { outline:none; border-color:var(--primary-color); box-shadow:0 0 0 3px rgba(59,130,246,.1); transform:translateY(-1px); }
.table-container { position:relative; }
.modern-table-wrapper { border-radius:12px; overflow:hidden; box-shadow:var(--shadow-sm); overflow-x:auto; max-width:100%; -webkit-overflow-scrolling:touch; scrollbar-width:thin; scrollbar-color:#3b82f6 #f3f4f6; }
.modern-table { width:100%; border-collapse:collapse; background:#fff; font-size:.813rem; line-height:1.4; }
.table-header { background:linear-gradient(135deg,#f8fafc,#f1f5f9); padding:.65rem .5rem; text-align:left; font-weight:600; font-size:.75rem; color:var(--gray-700); border-bottom:2px solid var(--gray-200); text-transform:uppercase; letter-spacing:.025em; }
.table-row { transition:all .2s ease; border-bottom:1px solid var(--gray-100); }
.table-row:hover { background:linear-gradient(135deg,#f8fafc,#f1f5f9); transform:scale(1.005); box-shadow:var(--shadow-sm); }
.table-cell { padding:.65rem .5rem; color:var(--gray-900); vertical-align:middle; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.sticky-column { position:sticky !important; right:0 !important; background:#fff !important; z-index:10 !important; box-shadow:-3px 0 10px rgba(0,0,0,.08) !important; }
.action-buttons .btn { display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:8px; }
.empty-state { text-align:center; padding:3rem 1rem; }
.empty-state-content i { font-size:4rem; color:var(--gray-300); margin-bottom:1rem; }
@media (max-width: 640px){ .modern-btn { width:100%; justify-content:center; } }
</style>
@endpush
@endsection


