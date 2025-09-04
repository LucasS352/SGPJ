<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGPJ')</title>

    {{-- Tailwind CSS via CDN (responsividade e estilo moderno) --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    {{-- Navbar simples --}}
    <nav class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-lg font-bold">SGPJ</a>
        <div class="space-x-4">
            <a href="{{ url('/folders') }}" class="hover:underline">Pastas</a>
            <a href="{{ url('/processos') }}" class="hover:underline">Processos</a>
        </div>
    </nav>

    {{-- Conteúdo principal --}}
    <main class="container mx-auto p-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white text-center py-4 mt-10">
        <p>&copy; {{ date('Y') }} SGPJ - Todos os direitos reservados</p>
    </footer>

</body>
</html>