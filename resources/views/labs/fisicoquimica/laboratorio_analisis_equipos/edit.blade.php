@extends('layouts.app')

@section('title', 'Editar Equipo de Laboratorio de Análisis')
@section('page-title', 'Lab. Físico Química')
@section('page-subtitle', 'Actualizar equipo de Laboratorio de Análisis')

@section('content')
<div class="max-w-5xl mx-auto modern-form-container">
    <div class="card modern-form-card">
        <div class="card-header modern-form-header flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Editar Equipo de Laboratorio de Análisis</h2>
            <a href="{{ route('fisicoquimica.laboratorio_analisis_equipos.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('fisicoquimica.laboratorio_analisis_equipos.update', $item->id) }}" method="POST" class="modern-form space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Nombre <span class="required">*</span></label>
                        <div class="input-container">
                            <i class="fas fa-tag input-icon"></i>
                            <input type="text" name="nombre" class="form-input" value="{{ old('nombre', $item->nombre) }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cantidad</label>
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-up input-icon"></i>
                            <input type="number" name="cantidad" class="form-input" value="{{ old('cantidad', $item->cantidad) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unidad</label>
                        <div class="input-container">
                            <i class="fas fa-balance-scale input-icon"></i>
                            <input type="text" name="unidad" class="form-input" value="{{ old('unidad', $item->unidad) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. Placa</label>
                        <div class="input-container">
                            <i class="fas fa-hashtag input-icon"></i>
                            <input type="text" name="no_placa" class="form-input" value="{{ old('no_placa', $item->no_placa) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fecha de Adquisición</label>
                        <div class="input-container">
                            <i class="fas fa-calendar input-icon"></i>
                            <input type="date" name="fecha_adq" class="form-input" value="{{ old('fecha_adq', $item->fecha_adq?->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Valor (COP)</label>
                        <div class="input-container">
                            <i class="fas fa-dollar-sign input-icon"></i>
                            <input type="number" step="0.01" name="valor" class="form-input" value="{{ old('valor', $item->valor) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nombre del Responsable</label>
                        <div class="input-container">
                            <i class="fas fa-user input-icon"></i>
                            <select name="nombre_responsable" id="nombre_responsable_select" class="form-input custom-select">
                                <option value="">Seleccionar responsable</option>
                                @php $currentResponsable = old('nombre_responsable', $item->nombre_responsable); @endphp
                                @foreach(($catalogos['responsables'] ?? []) as $responsable)
                                    <option value="{{ $responsable['nombre'] }}"
                                        data-cedula="{{ $responsable['cedula'] ?? '' }}"
                                        {{ $currentResponsable === $responsable['nombre'] ? 'selected' : '' }}>
                                        {{ $responsable['nombre'] }}
                                    </option>
                                @endforeach
                                @if($currentResponsable && !collect($catalogos['responsables'])->pluck('nombre')->contains($currentResponsable))
                                    <option value="{{ $currentResponsable }}" data-cedula="{{ old('cedula', $item->cedula) }}" selected>{{ $currentResponsable }}</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cédula</label>
                        <div class="input-container">
                            <i class="far fa-id-card input-icon"></i>
                            <input type="text" name="cedula" id="cedula_input" class="form-input" value="{{ old('cedula', $item->cedula) }}" list="cedulasList">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Vinculación</label>
                        <div class="input-container">
                            <i class="fas fa-briefcase input-icon"></i>
                            <select name="vinculacion" class="form-input custom-select" id="vinculacion_select">
                                <option value="">Seleccionar vinculación</option>
                                @foreach(($catalogos['vinculaciones'] ?? []) as $vinculacion)
                                    <option value="{{ $vinculacion }}" {{ old('vinculacion', $item->vinculacion) == $vinculacion ? 'selected' : '' }}>
                                        {{ $vinculacion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fecha Registro</label>
                        <div class="input-container">
                            <i class="fas fa-calendar-check input-icon"></i>
                            <input type="date" name="fecha_registro" class="form-input" value="{{ old('fecha_registro', $item->fecha_registro?->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Usuario que Registra</label>
                        <div class="input-container">
                            <i class="fas fa-user-check input-icon"></i>
                            <input type="text" name="usuario_registra" class="form-input" value="{{ old('usuario_registra', $item->usuario_registra) }}" list="usuariosList">
                        </div>
                    </div>
                    <div class="form-group md:col-span-2">
                        <label class="form-label">Detalle</label>
                        <div class="textarea-container">
                            <i class="fas fa-align-left textarea-icon"></i>
                            <textarea name="detalle" rows="3" class="form-textarea">{{ old('detalle', $item->detalle) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('fisicoquimica.laboratorio_analisis_equipos.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i> Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.modern-form-container{max-width:62rem;margin:2rem auto;background:linear-gradient(135deg,#ffffff,#f8fafc);border-radius:20px;box-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1);border:1px solid #e5e7eb;padding:2rem;}
.modern-form-card{border:none;background:transparent;}
.modern-form-header{border-bottom:2px solid #e5e7eb;padding-bottom:1rem;margin-bottom:1.5rem;}
.form-group{display:flex;flex-direction:column;gap:.5rem;}
.form-label{font-weight:600;color:#374151;}
.input-container,.textarea-container{position:relative;display:flex;align-items:center;}
.input-icon{position:absolute;left:1rem;color:#9ca3af;font-size:0.95rem;}
.form-input,.form-textarea{width:100%;padding:0.875rem 1rem 0.875rem 2.75rem;border:2px solid #e5e7eb;border-radius:12px;background:#fff;transition:all .3s ease;}
.custom-select{-webkit-appearance:none;-moz-appearance:none;appearance:none;background-color:#fff;padding-right:2.75rem;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath fill='%239ca3af' d='M5 6L0 .75h10z'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:calc(100% - 1rem) center;background-size:10px;}
.form-textarea{min-height:120px;}
.form-input:focus,.form-textarea:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12);outline:none;}
.form-actions{display:flex;justify-content:flex-end;gap:1rem;margin-top:1.5rem;flex-wrap:wrap;}
.modern-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.85rem 1.5rem;border-radius:12px;border:none;cursor:pointer;transition:transform .2s ease;}
.modern-btn-primary{background:linear-gradient(135deg,#3b82f6,#60a5fa);color:#fff;box-shadow:0 10px 15px -10px rgba(59,130,246,.6);}
.modern-btn-secondary{background:linear-gradient(135deg,#6b7280,#9ca3af);color:#fff;}
.modern-btn:hover{transform:translateY(-2px);}
.required{color:#ef4444;}
@media(max-width:640px){.form-actions{flex-direction:column;align-items:stretch;}}
</style>
@endpush

@push('scripts')
<datalist id="cedulasList">
    @foreach(($catalogos['cedulas'] ?? []) as $value)
        <option value="{{ $value }}">
    @endforeach
</datalist>
<datalist id="usuariosList">
    @foreach(($catalogos['usuarios'] ?? []) as $value)
        <option value="{{ $value }}">
    @endforeach
</datalist>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('nombre_responsable_select');
    const cedulaInput = document.getElementById('cedula_input');

    if (select && cedulaInput) {
        const fillCedula = () => {
            const option = select.selectedOptions[0];
            if (option && option.dataset.cedula) {
                cedulaInput.value = option.dataset.cedula;
            }
        };
        select.addEventListener('change', fillCedula);
        fillCedula();
    }
});
</script>
@endpush

