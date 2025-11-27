@extends('layouts.app')

@section('title', 'Agregar Artículo - Depósito')
@section('page-title', 'Laboratorio de Físico Química')
@section('page-subtitle', 'Nuevo artículo de depósito')

@section('content')
<div class="modern-inventory-container">
    <div class="card mb-6 modern-card">
        <div class="card-header modern-header">
            <h2 class="text-xl font-semibold text-gray-900">Agregar Artículo</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('fisicoquimica.deposito.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del artículo</label>
                        <input type="text" name="nombre_item" class="modern-input" required>
                    </div>
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                        <input type="number" name="cantidad" class="modern-input">
                    </div>
                    <div class="filter-group">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Unidad</label>
                        <input type="text" name="unidad" class="modern-input">
                    </div>
                    <div class="filter-group md:col-span-2 lg:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Detalle</label>
                        <textarea name="detalle" rows="3" class="modern-input"></textarea>
                    </div>
                </div>

                <div class="mt-6 flex gap-2">
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <a href="{{ route('fisicoquimica.deposito.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


