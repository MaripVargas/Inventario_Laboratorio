@extends('layouts.app')

@section('title', 'Lab. Fisico Quimica')
@section('page-title', 'Lab. Fisico Quimica')
@section('page-subtitle', 'Gestiona el inventario del laboratorio - módulo Fisico Quimica')

@section('content')
    @include('inventario.index', [
        'items' => $items,
    ])
    
@endsection


