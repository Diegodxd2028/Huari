<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Rol</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 min-h-screen flex items-center justify-center px-4">

    <main class="bg-white p-10 rounded-2xl shadow-lg w-full max-w-md text-center">
        <div class="mb-6">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/cd/Municipalidad_Provincial_de_Huari.svg/603px-Municipalidad_Provincial_de_Huari.svg.png"
                 alt="Escudo de Huari" class="h-16 mx-auto mb-4">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Bienvenido</h1>
            <p class="text-gray-600">Selecciona tu tipo de acceso para continuar</p>
        </div>

        <div class="flex flex-col space-y-4 mt-6">
            <a href="{{ route('login.form.usuario') }}"
               class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                Ingresar como Usuario
            </a>

            <a href="{{ route('login.form.admin') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                Ingresar como Administrador
            </a>
        </div>

        <div class="mt-8 text-sm text-gray-500">
            Municipalidad Provincial de Huari © {{ date('Y') }}
        </div>
    </main>

</body>
</html>
