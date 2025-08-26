<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Site')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'dark-bg': '#0D0D0D',     // Fundo escuro principal (um pouco mais profundo)
                        'primary': '#00ff9c',     // Verde neon
                        'secondary': '#141414',   // Painéis e sidebar (um pouco mais claro que o fundo)
                        'border-color': '#262626', // Bordas sutis
                        'accent': '#00ff9c',      // Mesma cor vibrante para links
                        'text-main': '#e5e5e5',   // Branco suave
                        'text-light': '#a3a3a3',  // Cinza claro
                        'text-dark': '#141414'
                    }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #141414; }
        ::-webkit-scrollbar-thumb { background: #262626; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #333; }
    </style>
</head>
<body class="bg-dark-bg text-text-main font-sans antialiased">

<div class="flex h-screen">
    <aside class="w-64 bg-secondary flex-shrink-0 border-r border-border-color p-6 flex flex-col justify-between">
        <div>
            <a href="{{ route('movies.dashboard') }}" class="text-3xl font-bold text-primary mb-12 block">
                Site
            </a>

            <nav class="space-y-4">
                <a href="{{ route('movies.dashboard') }}"
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors duration-200
                          {{ request()->routeIs('movies.dashboard') ? 'bg-primary text-text-dark font-semibold' : 'text-text-light hover:bg-border-color hover:text-text-main' }}">
                    <i class="fa-solid fa-house-chimney w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('movies.index') }}"
                   class="flex items-center gap-4 px-4 py-3 rounded-lg transition-colors duration-200
                          {{ request()->routeIs('movies.index') ? 'bg-primary text-text-dark font-semibold' : 'text-text-light hover:bg-border-color hover:text-text-main' }}">
                    <i class="fa-solid fa-film w-5 text-center"></i>
                    <span>Todos os Filmes</span>
                </a>
            </nav>
        </div>

        <div class="space-y-4">
            <a href="#" class="flex items-center gap-4 px-4 py-3 text-text-light hover:text-text-main rounded-lg transition-colors duration-200">
                <i class="fa-solid fa-gear w-5 text-center"></i>
                <span>Configurações</span>
            </a>
            <a href="#" class="flex items-center gap-4 px-4 py-3 text-text-light hover:text-text-main rounded-lg transition-colors duration-200">
                <i class="fa-solid fa-circle-question w-5 text-center"></i>
                <span>Suporte</span>
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="bg-secondary/80 backdrop-blur-sm border-b border-border-color flex-shrink-0">
            <div class="w-full mx-auto px-6 py-4 flex justify-between items-center">
                <div class="relative w-full max-w-md">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-text-light"></i>
                    <input type="text" placeholder="Filmes, séries, shows..."
                           class="w-full bg-border-color/50 border border-transparent focus:border-primary focus:ring-2 focus:ring-primary/50 rounded-full py-2.5 pl-12 pr-4 transition-all duration-300 placeholder:text-text-light">
                </div>

                <div class="flex items-center gap-6">
                    <button class="text-text-light hover:text-primary transition-colors">
                        <i class="fa-solid fa-bell fa-lg"></i>
                    </button>

                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                            <div class="h-10 w-10 rounded-full bg-primary text-black flex items-center justify-center font-bold ring-2 ring-offset-2 ring-offset-secondary ring-primary/50">
                                {{ strtoupper(substr(Auth::user()->name ?? 'AT', 0, 2)) }}
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-sm font-semibold text-text-main">{{ Auth::user()->name ?? 'Usuário' }}</p>
                                <p class="text-xs text-text-light">Premium</p>
                            </div>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-48 bg-secondary rounded-md shadow-lg py-1 border border-border-color"
                             style="display: none;">

                            <form method="post" action="{{ route('user.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-text-light hover:bg-border-color hover:text-text-main transition-colors duration-150 flex items-center gap-3">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-5"></i>
                                    <span>Finalizar Sessão</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </main>
    </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
@yield('scripts')

</body>
</html>
