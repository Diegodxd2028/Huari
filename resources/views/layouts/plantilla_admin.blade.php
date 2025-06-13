<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Panel Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md hidden md:flex flex-col">
        <div class="p-6 text-xl font-bold border-b text-blue-700">
            Admin Huari
        </div>
        <nav class="flex-1 mt-4">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-6 py-3 hover:bg-blue-100 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-200' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.canjes') }}"
               class="block px-6 py-3 hover:bg-blue-100 {{ request()->routeIs('admin.canjes') ? 'bg-blue-200' : '' }}">
                Historial de Canjes
            </a>
            <a href="{{ route('admin.mensajes') }}"
               class="block px-6 py-3 hover:bg-blue-100 {{ request()->routeIs('admin.mensajes') ? 'bg-blue-200' : '' }}">
                Mensajes de Usuarios
            </a>
            <a href="{{ route('admin.puntos') }}"
               class="block px-6 py-3 hover:bg-blue-100 {{ request()->routeIs('admin.puntos') ? 'bg-blue-200' : '' }}">
                Añadir Puntos
            </a>
            <a href="{{ route('admin.recompensas.create') }}"
               class="block px-6 py-3 hover:bg-blue-100 {{ request()->routeIs('admin.recompensas.create') ? 'bg-blue-200' : '' }}">
                Agregar Recompensa
            </a>
        </nav>
        <div class="p-6 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-600 hover:underline">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenido principal -->
    <main class="flex-1 p-6">
        <!-- Header Admin -->
        @include('layouts.partials.header_admin')

        <h1 class="text-2xl font-semibold text-gray-800 mt-6 mb-4">@yield('title')</h1>

        @yield('content')

        <!-- Footer Admin -->
        @include('layouts.partials.footer_admin')
    </main>

</body>
</html>
