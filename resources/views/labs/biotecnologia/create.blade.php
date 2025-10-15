@extends('layouts.app')

@section('title', 'Agregar Item - Biotecnologia')
@section('page-title', 'Agregar Item - Biotecnologia Vegetal')
@section('page-subtitle', 'Registra un nuevo item para Biotecnologia Vegetal')

@section('content')
    @include('inventario.create', [
        'backRouteName' => 'biotecnologia.index',
        'storeRouteName' => 'inventario.store'
    ])
@endsection


