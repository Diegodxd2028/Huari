@extends('layouts.plantilla_admin')

@section('title', 'Historial de Canjes')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Historial de Canjes</h1>

        @if($canjes->isEmpty())
            <p class="text-gray-600">No se han registrado canjes todavía.</p>
        @else
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Usuario</th>
                        <th class="border p-2">Recompensa</th>
                        <th class="border p-2">Cantidad</th>
                        <th class="border p-2">Puntos utilizados</th>
                        <th class="border p-2">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($canjes as $canje)
                        <tr>
                            <td class="border p-2">
                                {{ optional($canje->usuario)->name }} {{ optional($canje->usuario)->apellido_paterno }} {{ optional($canje->usuario)->apellido_materno }}
                            </td>
                            <td class="border p-2">{{ optional($canje->recompensa)->Titulo ?? 'Recompensa eliminada' }}</td>
                            <td class="border p-2">{{ $canje->Cantidad }}</td>
                            <td class="border p-2">{{ $canje->PuntosUtilizados }}</td>
                            <td class="border p-2">{{ $canje->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
