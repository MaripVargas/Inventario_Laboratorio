@extends('layouts.app')

@section('title', 'Agregar Siembra')
@section('page-title', 'Laboratorio de Biotecnología')
@section('page-subtitle', 'Registrar nueva siembra')

@section('content')
<div class="max-w-4xl mx-auto modern-form-container">
    <div class="card modern-form-card">
        <div class="card-header modern-form-header flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Nueva Siembra</h2>
            <a href="{{ route('biotecnologia.siembra.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form action="{{ route('biotecnologia.siembra.store') }}" method="POST" class="modern-form space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Nombre  <spa class="required">*</span></label>
                        <div class="input-container">
                            <i class="fas fa-seedling input-icon"></i>
                            <input type="text" name="nombre_siembra" required class="form-input" placeholder="Ej: Explante de..." value="{{ old('nombre_siembra') }}">
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
                            <input type="text" name="unidad" class="form-input" placeholder="Ej: frascos, placas..." value="{{ old('unidad') }}">
                        </div>
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label">Detalle</label>
                        <div class="textarea-container">
                            <i class="fas fa-align-left textarea-icon"></i>
                            <textarea name="detalle" rows="3" class="form-textarea" placeholder="Detalle de la siembra...">{{ old('detalle') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('biotecnologia.siembra.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.modern-form-container{max-width:60rem;margin:2rem auto;background:linear-gradient(135deg,#ffffff,#f8fafc);border-radius:20px;box-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1);border:1px solid #e5e7eb;padding:2rem;}
.form-input,.form-textarea{width:100%;padding:0.875rem 1rem;border:2px solid #e5e7eb;border-radius:12px;background:#fff;transition:all .3s ease;}
.form-input:focus,.form-textarea:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1);}
.modern-btn-primary{background:linear-gradient(135deg,#3b82f6,#60a5fa);color:#fff;padding:.75rem 1.25rem;border-radius:12px;border:none;cursor:pointer;}
.modern-btn-secondary{background:linear-gradient(135deg,#6b7280,#9ca3af);color:#fff;padding:.75rem 1.25rem;border-radius:12px;border:none;cursor:pointer;}
</style>
@endsection


