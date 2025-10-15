@extends('layouts.app')

@section('title', 'Agregar Item - Microbiologia')
@section('page-title', 'Agregar Item - Microbiologia')
@section('page-subtitle', 'Registra un nuevo item para Microbiologia')

@section('content')
    @include('inventario.create', [
        'backRouteName' => 'microbiologia.index',
        'storeRouteName' => 'inventario.store',
        'labModule' => 'microbiologia',
        'responsables' => $responsables
    ])
@endsection


