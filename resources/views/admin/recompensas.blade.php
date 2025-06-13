@extends('layouts.plantilla_admin')

@section('title', 'Agregar Recompensa')

@section('content')
<div class="container mx-auto p-6 max-w-2xl">
    <h1 class="text-2xl font-bold mb-6">Agregar Nueva Recompensa</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.recompensas.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium mb-1">Título:</label>
            <input type="text" name="Titulo" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-medium mb-1">Descripción:</label>
            <textarea name="Descripcion" class="w-full border p-2 rounded" rows="3" required></textarea>
        </div>

        <div>
            <label class="block font-medium mb-1">Puntos necesarios:</label>
            <input type="number" name="PuntosNecesarios" class="w-full border p-2 rounded" min="0" required>
        </div>

        <div>
            <label class="block font-medium mb-1">Stock:</label>
            <input type="number" name="Stock" class="w-full border p-2 rounded" min="1" required>
        </div>

        <div>
            <label class="block font-medium mb-1">¿Es temporal?</label>
            <select name="EsTemporal" class="w-full border p-2 rounded" id="esTemporalSelect">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>

        <div id="fechasTemporales" style="display: none;">
            <div>
                <label class="block font-medium mb-1">Fecha de inicio:</label>
                <input type="date" name="FechaInicio" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block font-medium mb-1">Fecha de fin:</label>
                <input type="date" name="FechaFin" class="w-full border p-2 rounded">
            </div>
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
            Guardar Recompensa
        </button>
    </form>
</div>

<script>
    const esTemporalSelect = document.getElementById('esTemporalSelect');
    const fechasTemporales = document.getElementById('fechasTemporales');

    esTemporalSelect.addEventListener('change', () => {
        fechasTemporales.style.display = esTemporalSelect.value == "1" ? "block" : "none";
    });
</script>
@endsection
