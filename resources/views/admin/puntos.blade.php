@extends('layouts.plantilla_admin')

@section('title', 'Añadir Puntos')

@section('content')
<div class="container mx-auto p-6 max-w-xl">
    <h1 class="text-2xl font-bold mb-6">Añadir Puntos a un Usuario</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Mostrar errores de validación --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.puntos') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium mb-1">DNI del Usuario:</label>
            <input type="text" name="dni" class="w-full border p-2 rounded" required value="{{ old('dni') }}">
        </div>

        <div>
            <label class="block font-medium mb-1">Tipo de Residuo:</label>
            <select name="tipo_residuo" id="tipo_residuo" class="w-full border p-2 rounded" required>
                <option value="">Selecciona una opción</option>
                <option value="papel">Papel y Cartón</option>
                <option value="plastico">Botellas de Plástico</option>
                <option value="lata">Latas</option>
            </select>
        </div>

        <div>
            <label class="block font-medium mb-1">Cantidad (en kilos):</label>
            <input type="number" name="kilos" id="kilos" class="w-full border p-2 rounded" min="1" required>
        </div>

        {{-- Campo oculto para los puntos calculados --}}
        <input type="hidden" name="puntos" id="puntos">

        <div id="puntos-preview" class="text-gray-700 font-semibold"></div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Añadir Puntos
        </button>
    </form>
</div>

<script>
    document.getElementById('tipo_residuo').addEventListener('change', calcularPuntos);
    document.getElementById('kilos').addEventListener('input', calcularPuntos);

    function calcularPuntos() {
        const tipo = document.getElementById('tipo_residuo').value;
        const kilos = parseFloat(document.getElementById('kilos').value);
        let puntos = 0;

        if (!isNaN(kilos)) {
            switch (tipo) {
                case 'papel':
                    puntos = kilos * 5;
                    break;
                case 'plastico':
                    puntos = kilos * 10;
                    break;
                case 'lata':
                    puntos = kilos * 50;
                    break;
            }
        }

        document.getElementById('puntos').value = puntos;
        document.getElementById('puntos-preview').innerText = puntos > 0 ? `Puntos a asignar: ${puntos}` : '';
    }
</script>
@endsection
