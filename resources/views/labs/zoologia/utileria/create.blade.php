@extends('layouts.app')

@section('title', 'Agregar Artículo de Utilería')
@section('page-title', 'Laboratorio de Zoología')
@section('page-subtitle', 'Registrar nuevo artículo de utilería')

@section('content')
<div class="max-w-4xl mx-auto modern-form-container">
    <div class="card modern-form-card">
        <div class="card-header modern-form-header flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Nuevo Artículo de Utilería</h2>
            <a href="{{ route('zoologia.utileria.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('zoologia.utileria.store') }}" method="POST" class="modern-form space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Nombre del Artículo <span class="required">*</span></label>
                        <div class="input-container">
                            <i class="fas fa-box input-icon"></i>
                            <input type="text" name="nombre_item" required class="form-input" placeholder="Ej: Pipeta, Microscopio..." value="{{ old('nombre_item') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Cantidad</label>
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-up input-icon"></i>
                            <input type="number" name="cantidad" class="form-input" placeholder="Ej: 10" value="{{ old('cantidad') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Unidad</label>
                        <div class="input-container">
                            <i class="fas fa-balance-scale input-icon"></i>
                            <input type="text" name="unidad" class="form-input" placeholder="Ej: unidades, piezas..." value="{{ old('unidad') }}">
                        </div>
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label">Detalle</label>
                        <div class="textarea-container">
                            <i class="fas fa-align-left textarea-icon"></i>
                            <textarea name="detalle" rows="3" class="form-textarea" placeholder="Detalles o características del artículo...">{{ old('detalle') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('zoologia.utileria.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i> Guardar Artículo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* === ESTILOS FORMULARIO UTILERÍA === */
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
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
}

/* --- contenedor general --- */
.modern-form-container {
    max-width: 60rem;
    margin: 2rem auto;
    background: linear-gradient(135deg, #ffffff, #f8fafc);
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--gray-200);
    padding: 2rem;
}

/* --- encabezado --- */
.modern-form-header {
    border-bottom: 2px solid var(--gray-200);
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;
}
.modern-form-header h2 {
    font-size: 1.5rem;
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
    margin-bottom: 0.5rem;
    display: block;
}
.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    background: white;
    transition: all 0.3s ease;
}
.form-input:focus,
.form-textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

/* --- botones --- */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}
.modern-btn-primary {
    background: linear-gradient(135deg, var(--primary-color), #60a5fa);
    color: white;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    border: none;
    cursor: pointer;
}
.modern-btn-secondary {
    background: linear-gradient(135deg, var(--gray-500), #9ca3af);
    color: white;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    border: none;
    cursor: pointer;
}
</style>

@endsection
