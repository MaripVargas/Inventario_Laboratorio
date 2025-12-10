@extends('layouts.app')

@section('title', 'Agregar Artículo - Área de Balanzas')
@section('page-title', 'Laboratorio de Físico Química')
@section('page-subtitle', 'Nuevo artículo de área de balanzas')

@section('content')
<div class="max-w-4xl mx-auto modern-form-container">
    <div class="card modern-form-card">
        <div class="card-header modern-form-header flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Nuevo artículo - Área de Balanzas</h2>
            <a href="{{ route('fisicoquimica.area_balanzas.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('fisicoquimica.area_balanzas.store') }}" class="modern-form space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label class="form-label">Nombre del artículo <span class="required">*</span></label>
                        <div class="input-container">
                            <i class="fas fa-vial input-icon"></i>
                            <input type="text" name="nombre_item" class="form-input" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cantidad</label>
                        <div class="input-container">
                            <i class="fas fa-sort-numeric-up input-icon"></i>
                            <input type="number" name="cantidad" class="form-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unidad</label>
                        <div class="input-container">
                            <i class="fas fa-balance-scale input-icon"></i>
                            <input type="text" name="unidad" class="form-input">
                        </div>
                    </div>
                    <div class="form-group md:col-span-2">
                        <label class="form-label">Detalle</label>
                        <div class="textarea-container">
                            <i class="fas fa-align-left textarea-icon"></i>
                            <textarea name="detalle" rows="3" class="form-textarea"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('fisicoquimica.area_balanzas.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.modern-form-container{max-width:64rem;margin:2rem auto;background:linear-gradient(135deg,#ffffff,#f8fafc);border-radius:20px;box-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1);border:1px solid #e5e7eb;padding:2rem;}
.modern-form-card{border:none;background:transparent;}
.modern-form-header{border-bottom:2px solid #e5e7eb;padding-bottom:1rem;margin-bottom:1.5rem;}
.form-group{display:flex;flex-direction:column;gap:.5rem;}
.form-label{font-weight:600;color:#374151;}
.input-container,.textarea-container{position:relative;display:flex;align-items:center;}
.input-icon{position:absolute;left:1rem;color:#9ca3af;font-size:0.95rem;}
.form-input,.form-textarea{width:100%;padding:0.9rem 1rem 0.9rem 2.8rem;border:2px solid #e5e7eb;border-radius:12px;background:#fff;transition:all .3s ease;}
.form-textarea{min-height:120px;}
.form-input:focus,.form-textarea:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.12);outline:none;}
.textarea-icon{position:absolute;left:1rem;color:#9ca3af;font-size:0.95rem;align-self:flex-start;margin-top:.9rem;}
.form-actions{display:flex;gap:1rem;flex-wrap:wrap;margin-top:1rem;}
.modern-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.9rem 1.4rem;border-radius:12px;border:none;cursor:pointer;transition:transform .2s ease;}
.modern-btn-primary{background:linear-gradient(135deg,#3b82f6,#60a5fa);color:#fff;box-shadow:0 10px 15px -10px rgba(59,130,246,.6);}
.modern-btn-secondary{background:linear-gradient(135deg,#6b7280,#9ca3af);color:#fff;}
.modern-btn:hover{transform:translateY(-2px);}
.required{color:#ef4444;}
@media(max-width:640px){.form-actions{flex-direction:column;}}
</style>
@endpush
