@extends('layouts.app')

@section('title', 'Áreas')
@section('page-title', 'Áreas del Laboratorio')
@section('page-subtitle', 'Explora las áreas disponibles y accede a cada módulo')

@section('content')
<div class="card mb-8">
    <div class="card-header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-900">Áreas disponibles</h2>
            <span class="badge bg-primary">Total: {{ $totalAreas }}</span>
        </div>
    </div>
    <div class="card-body">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($areas as $area)
                <a href="{{ $area['ruta'] }}" class="action-card action-card-purple">
                    <div class="action-card-icon">
                        <i class="{{ $area['icono'] }}"></i>
                    </div>
                    <div class="action-card-content">
                        <h3>{{ $area['nombre'] }}</h3>
                        <p>Ingresar al módulo</p>
                    </div>
                    <div class="action-card-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
 </div>
@endsection


