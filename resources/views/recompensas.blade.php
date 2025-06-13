@extends('layouts.plantilla_usuario')

@section('title', 'Recompensas')

@section('content')
<main class="container mx-auto px-4 py-8">

    {{-- Mensajes flash --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6 border border-green-300">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded mb-6 border border-red-300">
            {{ session('error') }}
        </div>
    @endif

    <!-- Card de Bienvenida -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 mb-8 border-l-4 border-green-500">
        <div class="md:flex md:items-center md:justify-between">
            <div class="md:w-2/3">
                <h1 class="text-2xl font-bold text-gray-800">
                    ¡Bienvenido, <span class="text-green-600">{{ $nombreCompleto }}</span>!
                </h1>
                <p class="mt-2 text-gray-600">Descubre las recompensas disponibles para ti</p>
            </div>
            <div class="mt-4 md:mt-0 md:w-1/3">
                <div class="bg-gray-50 rounded-lg p-4 text-center shadow-inner">
                    <p class="text-sm font-medium text-gray-500">TUS PUNTOS</p>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($puntos) }}</p>
                    <span class="text-xs text-gray-400">puntos acumulados</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Recompensas -->
    <section class="mb-12">
        <h2 class="text-xl font-semibold text-gray-800 border-b pb-2 mb-6">Recompensas Disponibles</h2>

        <!-- Grid de Recompensas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($recompensas as $r)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="h-48 bg-green-100 flex items-center justify-center relative">
                        <img src="{{ asset($r->imagen) }}" alt="Imagen de {{ $r->titulo }}" class="object-cover h-full w-full">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-2">{{ $r->Titulo }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $r->Descripcion }}</p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-green-600">{{ number_format($r->PuntosNecesarios) }} pts</span>

                            @if($r->PuntosNecesarios > $puntos || $r->Stock <= 0)
                                <button class="px-4 py-2 bg-gray-300 text-white text-sm rounded opacity-50 cursor-not-allowed" disabled>
                                    No disponible
                                </button>
                            @else
                                <form action="{{ route('canjes.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="CodRecom" value="{{ $r->CodRecom }}">
                                    <input type="hidden" name="Cantidad" value="1">
                                    <button type="submit" onclick="return confirm('¿Canjear esta recompensa?')" class="px-4 py-2 bg-green-500 text-white text-sm rounded hover:bg-green-600 transition">
                                        Canjear
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 col-span-3 text-center">No hay recompensas disponibles por el momento.</p>
            @endforelse
        </div>
    </section>

    <!-- Sección de Puntos -->
    <section class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">¿Cómo ganar más puntos?</h2>
        <ul class="space-y-3">
            <li class="flex items-start">
                <div class="flex-shrink-0 h-6 w-6 text-green-500 mr-2">✓</div>
                <p class="text-gray-700">+10 puntos por cada kg de material reciclado</p>
            </li>
            <li class="flex items-start">
                <div class="flex-shrink-0 h-6 w-6 text-green-500 mr-2">✓</div>
                <p class="text-gray-700">+50 puntos por participar en eventos</p>
            </li>
            <li class="flex items-start">
                <div class="flex-shrink-0 h-6 w-6 text-green-500 mr-2">✓</div>
                <p class="text-gray-700">+5 puntos por día al registrar actividad</p>
            </li>
        </ul>
    </section>
</main>
@endsection
