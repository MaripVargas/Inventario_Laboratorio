@extends('layouts.app')

@section('title', 'Agregar Reactivo')
@section('page-title', 'Laboratorio de Zoología')
@section('page-subtitle', 'Registrar nuevo reactivo químico')

@section('content')
<div class="max-w-4xl mx-auto modern-form-container">
    <div class="card modern-form-card">
        <div class="card-header modern-form-header flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Nuevo Reactivo</h2>
            <a href="{{ route('zoologia.reactivos.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('zoologia.reactivos.store') }}" method="POST" class="modern-form space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Nombre del Reactivo <span class="required">*</span></label>
                        <div class="input-container">
                            <i class="fas fa-flask input-icon"></i>
                            <input type="text" name="nombre_reactivo" required class="form-input" placeholder="Ej: Ácido clorhídrico" value="{{ old('nombre_reactivo') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Cantidad</label>
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-up input-icon"></i>
                            <input type="number" name="cantidad" class="form-input" placeholder="Ej: 2" value="{{ old('cantidad') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Unidad</label>
                        <div class="input-container">
                            <i class="fas fa-balance-scale input-icon"></i>
                            <input type="text" name="unidad" class="form-input" placeholder="Ej: L, mL, tarro..." value="{{ old('unidad') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Concentración</label>
                        <div class="input-container">
                            <i class="fas fa-percent input-icon"></i>
                            <input type="text" name="concentracion" class="form-input" placeholder="Ej: 45%" value="{{ old('concentracion') }}">
                        </div>
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label">Detalle</label>
                        <div class="textarea-container">
                            <i class="fas fa-align-left textarea-icon"></i>
                            <textarea name="detalle" rows="3" class="form-textarea" placeholder="Detalles sobre el reactivo, condiciones, precauciones...">{{ old('detalle') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('zoologia.reactivos.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i> Guardar Reactivo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
/* === ESTILOS FORMULARIO REACTIVOS === */
:root {
    --primary-color: #059669;
    --success-color: #16a34a;
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
    background: linear-gradient(135deg, #ffffff, #ecfdf5);
    border-radius: 20px;
    border: 1px solid var(--gray-200);
    box-shadow: 0 10px 15px -3px rgba(16,185,129,0.1);
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
    box-shadow: 0 0 0 3px rgba(5,150,105,0.1);
}

/* --- botones --- */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}
.modern-btn-primary {
    background: linear-gradient(135deg, var(--primary-color), #34d399);
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
