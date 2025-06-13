@extends('layouts.plantilla_admin')

@section('title', 'Panel de Administración')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Bienvenido, Administrador</h1>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <a href="{{ route('admin.canjes') }}" class="bg-blue-500 text-white p-6 rounded-lg shadow text-center hover:bg-blue-600">
                Ver Historial de Canjes
            </a>
            <a href="{{ route('admin.mensajes') }}" class="bg-green-500 text-white p-6 rounded-lg shadow text-center hover:bg-green-600">
                Ver Mensajes de Atención al Usuario
            </a>
            <a href="{{ route('admin.puntos') }}" class="bg-purple-500 text-white p-6 rounded-lg shadow text-center hover:bg-purple-600">
                Añadir Puntos a Usuario
            </a>
            <a href="{{ route('admin.recompensas.create') }}" class="bg-yellow-500 text-white p-6 rounded-lg shadow text-center hover:bg-yellow-600">
                Agregar Nueva Recompensa
            </a>
        </div>
    </div>

@endsection
