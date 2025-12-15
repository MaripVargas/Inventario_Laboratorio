@extends('layouts.app')

@section('title', 'Agregar Vidriería')
@section('page-title', 'Laboratorio de Fisico Química')
@section('page-subtitle', 'Registrar nuevo material de vidriería')

@section('content')
<div class="max-w-4xl mx-auto modern-form-container">
    <div class="card modern-form-card">
        <div class="card-header modern-form-header flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Nueva Vidriería</h2>
            <a href="{{ route('fisicoquimica.vidrieria.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('fisicoquimica.vidrieria.store') }}" method="POST" class="modern-form space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Nombre del Artículo <span class="required">*</span></label>
                        <div class="input-container">
                            <i class="fas fa-vial input-icon"></i>
                            <input type="text" name="nombre_item" required class="form-input" placeholder="Ej: Probeta, Matraz..." value="{{ old('nombre_item') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Volumen</label>
                        <div class="input-container">
                            <i class="fas fa-fill-drip input-icon"></i>
                            <input type="text" name="volumen" class="form-input" placeholder="Ej: 500 mL" value="{{ old('volumen') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Cantidad</label>
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-up input-icon"></i>
                            <input type="number" name="cantidad" class="form-input" placeholder="Ej: 8" value="{{ old('cantidad') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Unidad</label>
                        <div class="input-container">
                            <i class="fas fa-balance-scale input-icon"></i>
                            <input type="text" name="unidad" class="form-input" placeholder="Ej: piezas, unidades..." value="{{ old('unidad') }}">
                        </div>
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label">Detalle</label>
                        <div class="textarea-container">
                            <i class="fas fa-align-left textarea-icon"></i>
                            <textarea name="detalle" rows="3" class="form-textarea" placeholder="Observaciones o descripción del material...">{{ old('detalle') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('fisicoquimica.vidrieria.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i> Guardar Vidriería
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* === ESTILOS FORMULARIO VIDRIERÍA === */
:root {
    --primary-color: #8b5cf6;
    --success-color: #10b981;
    --danger-color: #ef4444;
    --gray-200: #e5e7eb;
    --gray-700: #374151;
    --gray-900: #111827;
}

/* --- contenedor --- */
.modern-form-container {
    max-width: 60rem;
    margin: 2rem auto;
    padding: 2rem;
    background: linear-gradient(135deg, #ffffff, #faf5ff);
    border: 1px solid var(--gray-200);
    border-radius: 20px;
    box-shadow: 0 10px 15px -3px rgba(139, 92, 246, 0.1);
}

/* --- encabezado --- */
.modern-form-header {
    border-bottom: 2px solid var(--gray-200);
    margin-bottom: 1.5rem;
}
.modern-form-header h2 {
    color: var(--gray-900);
    font-weight: 600;
}

/* --- campos --- */
.form-group {
    margin-bottom: 1.5rem;
}
.form-label {
    font-weight: 500;
    color: var(--gray-700);
}
.form-input,
.form-textarea {
    width: 100%;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    padding: 0.875rem 1rem;
    transition: all 0.3s ease;
}
.form-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(139,92,246,0.1);
}

/* --- botones --- */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}
.modern-btn-primary {
    background: linear-gradient(135deg, var(--primary-color), #a78bfa);
    color: white;
    border-radius: 12px;
    padding: 0.75rem 1.25rem;
    border: none;
}
.modern-btn-secondary {
    background: linear-gradient(135deg, var(--gray-500), #9ca3af);
    color: white;
    border-radius: 12px;
    padding: 0.75rem 1.25rem;
    border: none;
}
</style>

@endsection
