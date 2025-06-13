<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mensaje;
use App\Models\Canje;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function mensajes()
    {
        $mensajes = Mensaje::with('usuario')->latest()->get();
        return view('admin.mensajes', compact('mensajes'));
    }

    public function canjes()
    {
        $canjes = Canje::with('recompensa', 'usuario')->get();
        return view('admin.canjes', compact('canjes'));
    }

    public function mostrarFormularioPuntos()
    {
        $usuarios = User::where('rol', 'usuario')->get();
        return view('admin.puntos', compact('usuarios'));
    }

    public function asignarPuntos(Request $request)
    {
        $request->validate([
            'dni' => 'required|exists:users,DNI',
            'puntos' => 'required|integer|min:1',
        ], [
            'dni.exists' => 'El usuario con ese DNI no existe.',
        ]);

        $usuario = User::where('DNI', $request->dni)->first();
        $usuario->Puntos += $request->puntos;
        $usuario->save();

        return redirect()->back()->with('success', 'Puntos asignados correctamente.');
    }
}
