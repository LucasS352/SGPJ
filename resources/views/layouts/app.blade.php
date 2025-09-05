<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SGPJ')</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Bootstrap (necessário para o header e dropdowns) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Iconify --}}
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    {{-- ApexCharts (para os gráficos) --}}
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body class="bg-gray-100 text-gray-900 flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white shadow-md h-screen fixed">
        <div class="p-4 border-b flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center">
                <img src="{{ asset('assets/images/logos/logo.svg') }}" alt="Logo" class="h-8 mr-2" />
                <span class="text-xl font-bold">SGPJ</span>
            </a>
        </div>

        <nav class="mt-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ url('/pastas') }}"
                       class="flex items-center px-4 py-2 hover:bg-gray-100 {{ request()->is('pastas*') ? 'bg-blue-100 font-bold' : '' }}">
                        <iconify-icon icon="solar:folder-line-duotone" class="mr-2"></iconify-icon>
                        Pastas
                    </a>
                </li>
                <li>
                    <a href="{{ url('/processos') }}"
                       class="flex items-center px-4 py-2 hover:bg-gray-100 {{ request()->is('processos*') ? 'bg-blue-100 font-bold' : '' }}">
                        <iconify-icon icon="solar:document-line-duotone" class="mr-2"></iconify-icon>
                        Processos
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    {{-- Conteúdo principal --}}
    <main class="ml-64 w-full">

        {{-- HEADER --}}
        <header class="app-header bg-white shadow-sm">
            <nav class="navbar navbar-expand-lg navbar-light px-4">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    {{-- Notificações --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link position-relative" href="#" id="drop1" data-bs-toggle="dropdown">
                            <iconify-icon icon="solar:bell-linear" class="fs-5"></iconify-icon>
                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-primary border rounded-circle"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="drop1">
                            <li><a class="dropdown-item" href="#">Nenhuma notificação</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="ms-auto d-flex align-items-center">
                    <li class="nav-item dropdown list-unstyled">
                        <a class="nav-link" href="#" id="drop2" data-bs-toggle="dropdown">
                            <img src="{{ asset('assets/images/profile/user1.jpg') }}" alt="User"
                                 width="35" height="35" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="drop2">
                            <a class="dropdown-item" href="#">Meu Perfil</a>
                            <a class="dropdown-item" href="#">Minha Conta</a>
                            <a class="dropdown-item" href="#">Minhas Tarefas</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">Sair</button>
                            </form>
                        </div>
                    </li>
                </div>
            </nav>
        </header>

        {{-- Área de conteúdo --}}
        <section class="p-6">
            @yield('content')
        </section>
    </main>
</body>
</html>
