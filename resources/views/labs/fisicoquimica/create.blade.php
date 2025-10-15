@extends('layouts.app')

@section('title', 'Agregar Item - Fisico Quimica')
@section('page-title', 'Agregar Item - Fisico Quimica')
@section('page-subtitle', 'Registra un nuevo item para Fisico Quimica')

@section('content')
    @include('inventario.create', [
        'backRouteName' => 'fisicoquimica.index',
        'storeRouteName' => 'inventario.store'
    ])
@endsection


