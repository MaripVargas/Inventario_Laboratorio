@extends('layouts.app')

@section('title', 'Lab. microbiologia')
@section('page-title', 'Lab. microbiologia')
@section('page-subtitle', 'Gestiona el inventario del laboratorio - módulo Microbiologia')

@section('content')
    @include('inventario.index', [
        'items' => $items,
    ])
@endsection


