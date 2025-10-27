@extends('layouts.app')

@section('title', 'Lab. Biotecnologia Vegetal')
@section('page-title', 'Lab. Biotecnologia Vegetal')
@section('page-subtitle', 'Gestiona el inventario del laboratorio - módulo Biotecnologia')

@section('content')
    @include('inventario.index', ['items' => $items])

    
    
    
@endsection


