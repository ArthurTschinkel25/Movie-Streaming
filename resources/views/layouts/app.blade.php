<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StreamFlix')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                        'dark-bg': '#0D0D0D',
                        'primary': '#00ff9c',
                        'secondary': '#141414',
                        'border-color': '#262626',
                        'accent': '#00ff9c',
                        'text-main': '#e5e5e5',
                        'text-light': '#a3a3a3',
                        'text-dark': '#141414',
                        'navbar': 'rgba(20, 20, 20, 0.95)'
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

        body {
            background: linear-gradient(to bottom, #0D0D0D 0%, #1a1a1a 100%);
            min-height: 100vh;
        }

        .gradient-overlay {
            background: linear-gradient(to top, rgba(13,13,13,0.95) 0%, rgba(13,13,13,0.7) 30%, rgba(13,13,13,0.4) 70%, transparent 100%);
        }

        .navbar-blur {
            background: rgba(20, 20, 20, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(0, 255, 156, 0.15);
        }

        .swiper-slide {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .featured-slide {
            transition: all 0.5s ease;
        }

        .modal-fade-in {
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .play-button-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 255, 156, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(0, 255, 156, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 255, 156, 0); }
        }

        .nav-item {
            position: relative;
            padding-bottom: 4px;
            transition: all 0.3s ease;
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #00ff9c;
            border-radius: 2px;
        }

        .sidebar-item {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-item:hover, .sidebar-item.active {
            border-left-color: #00ff9c;
            background-color: rgba(0, 255, 156, 0.05);
        }
    </style>
</head>
<body class="text-text-main font-sans antialiased">

<div class="flex min-h-screen">
    <aside class="w-20 lg:w-64 bg-secondary border-r border-border-color/30 flex flex-col flex-shrink-0">
        <div class="p-5 border-b border-border-color/30 flex items-center justify-center lg:justify-start">
            <a href="{{ route('movies.dashboard') }}" class="text-2xl font-bold text-primary flex items-center">
                <i class="fas fa-play-circle"></i>
                <span class="hidden lg:block ml-2">StreamFlix</span>
            </a>
        </div>

        <nav class="flex-1 py-6">
            <div class="space-y-1 px-2">
                <a href="{{ route('movies.dashboard') }}" class="sidebar-item flex items-center px-4 py-3 text-sm rounded-r-lg {{ request()->routeIs('movies.dashboard') ? 'active text-primary' : 'text-text-light hover:text-text-main' }}">
                    <i class="fas fa-house w-5 text-center"></i>
                    <span class="hidden lg:block ml-3">Início</span>
                </a>

                <a href="{{ route('movies.index') }}" class="sidebar-item flex items-center px-4 py-3 text-sm rounded-r-lg {{ request()->routeIs('movies.index') ? 'active text-primary' : 'text-text-light hover:text-text-main' }}">
                    <i class="fas fa-film w-5 text-center"></i>
                    <span class="hidden lg:block ml-3">Catálogo</span>
                </a>

                <a href="#" class="sidebar-item flex items-center px-4 py-3 text-sm rounded-r-lg text-text-light hover:text-text-main">
                    <i class="fas fa-tv w-5 text-center"></i>
                    <span class="hidden lg:block ml-3">Séries</span>
                </a>

                <a href="#" class="sidebar-item flex items-center px-4 py-3 text-sm rounded-r-lg text-text-light hover:text-text-main">
                    <i class="fas fa-bookmark w-5 text-center"></i>
                    <span class="hidden lg:block ml-3">Minha Lista</span>
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-border-color/30">
            <div class="space-y-1 px-2">
                <a href="#" class="sidebar-item flex items-center px-4 py-3 text-sm rounded-r-lg text-text-light hover:text-text-main">
                    <i class="fas fa-gear w-5 text-center"></i>
                    <span class="hidden lg:block ml-3">Configurações</span>
                </a>

                <a href="#" class="sidebar-item flex items-center px-4 py-3 text-sm rounded-r-lg text-text-light hover:text-text-main">
                    <i class="fas fa-question-circle w-5 text-center"></i>
                    <span class="hidden lg:block ml-3">Ajuda</span>
                </a>

                <form method="post" action="{{ route('user.logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-item w-full flex items-center px-4 py-3 text-sm rounded-r-lg text-text-light hover:text-text-main">
                        <i class="fas fa-sign-out-alt w-5 text-center"></i>
                        <span class="hidden lg:block ml-3">Sair</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="navbar-blur border-b border-border-color/30">
            <div class="px-6 py-4 flex justify-between items-center">
                <nav class="flex items-center space-x-8">
                    <a href="{{ route('movies.dashboard') }}" class="nav-item transition-colors duration-200 {{ request()->routeIs('movies.dashboard') ? 'active text-text-main font-medium' : 'text-text-light hover:text-text-main' }}">
                        Início
                    </a>
                    <a href="{{ route('movies.index') }}" class="nav-item transition-colors duration-200 {{ request()->routeIs('movies.index') ? 'active text-text-main font-medium' : 'text-text-light hover:text-text-main' }}">
                        Catálogo
                    </a>
                    <a href="#" class="nav-item transition-colors duration-200 text-text-light hover:text-text-main">
                        Minha Lista
                    </a>
                </nav>

                <div class="flex items-center gap-6">
                    <div class="relative hidden md:block">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-text-light"></i>
                        <input type="text" placeholder="Pesquisar..."
                               class="w-64 bg-border-color/30 border border-transparent focus:border-primary/50 focus:ring-2 focus:ring-primary/30 rounded-full py-2 pl-10 pr-4 transition-all duration-300 placeholder:text-text-light text-sm">
                    </div>

                    <button class="text-text-light hover:text-primary transition-colors md:hidden">
                        <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                    </button>

                    <button class="text-text-light hover:text-primary transition-colors relative">
                        <i class="fa-solid fa-bell fa-lg"></i>
                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-primary rounded-full flex items-center justify-center">
                            <span class="text-[10px] font-bold text-dark-bg">3</span>
                        </span>
                    </button>

                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-primary to-emerald-400 text-dark-bg flex items-center justify-center font-bold">
                                {{ strtoupper(substr(Auth::user()->name ?? 'AT', 0, 2)) }}
                            </div>
                            <div class="text-left hidden lg:block">
                                <p class="text-sm font-medium text-text-main">{{ Auth::user()->name ?? 'Usuário' }}</p>
                                <p class="text-xs text-primary">Premium</p>
                            </div>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-3 w-48 bg-secondary rounded-md shadow-lg py-1 border border-border-color z-50"
                             style="display: none;">

                            <div class="px-4 py-2 border-b border-border-color">
                                <p class="text-sm font-medium text-text-main">{{ Auth::user()->name ?? 'Usuário' }}</p>
                                <p class="text-xs text-primary">Plano Premium</p>
                            </div>

                            <a href="#" class="block px-4 py-2 text-sm text-text-light hover:bg-border-color hover:text-text-main transition-colors duration-150">
                                <i class="fa-solid fa-user mr-2 w-5"></i>
                                <span>Minha Conta</span>
                            </a>

                            <a href="#" class="block px-4 py-2 text-sm text-text-light hover:bg-border-color hover:text-text-main transition-colors duration-150">
                                <i class="fa-solid fa-gear mr-2 w-5"></i>
                                <span>Configurações</span>
                            </a>

                            <form method="post" action="{{ route('user.logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-text-light hover:bg-border-color hover:text-text-main transition-colors duration-150 flex items-center">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-2 w-5"></i>
                                    <span>Sair</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>

<div id="movie-modal" class="hidden fixed inset-0 bg-black/90 backdrop-blur-md z-50 flex items-center justify-center p-4">
    <div id="modal-backdrop" class="absolute inset-0 bg-black/70"></div>
    <div id="modal-panel" class="relative w-full max-w-4xl bg-secondary rounded-xl overflow-hidden shadow-2xl shadow-primary/20 modal-fade-in">
        <div class="relative h-60 md:h-80 w-full">
            <img id="modal-backdrop-image" src="" alt="Backdrop do filme" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-secondary via-secondary/70 to-transparent"></div>
            <button id="modal-close-button" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-black/70 flex items-center justify-center text-white hover:bg-primary hover:text-dark-bg transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-6 md:p-8 -mt-20 relative z-10">
            <h2 id="modal-title" class="text-3xl md:text-5xl font-bold text-text-main drop-shadow-lg">Título do Filme</h2>
            <div id="modal-meta-info" class="flex items-center flex-wrap gap-x-4 gap-y-2 mt-4 text-text-light"></div>
            <div id="modal-genres" class="flex flex-wrap gap-2 mt-5"></div>
            <p id="modal-overview" class="mt-6 text-text-light leading-relaxed max-w-3xl">Sinopse do filme...</p>
            <div class="mt-8 flex gap-4">
                <button class="bg-primary text-dark-bg font-bold py-3 px-8 rounded-lg flex items-center gap-3 text-lg transition-transform hover:scale-105 play-button-pulse">
                    <i class="fas fa-play"></i>
                    <span>Assistir</span>
                </button>
                <button class="bg-white/10 text-text-main font-bold py-3 px-6 rounded-lg flex items-center gap-3 text-lg transition-colors hover:bg-white/20">
                    <i class="fas fa-plus"></i>
                    <span>Minha Lista</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
@yield('scripts')

</body>
</html>
