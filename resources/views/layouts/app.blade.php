<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Meu Site')</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#0a0a0a',     // Fundo escuro
                        'primary': '#00ff9c',     // Verde neon
                        'secondary': '#1a1a1a',   // Cinza escuro
                        'accent': '#00ff9c',      // Mesma cor vibrante para links
                        'text-main': '#e5e5e5',   // Branco suave
                        'text-light': '#a3a3a3'   // Cinza claro
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-dark-bg text-text-main font-sans">

<header class="bg-secondary shadow-sm border-b border-neutral-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
        <a href="{{ route('movies.index') }}" class="text-2xl font-bold text-primary">Site</a>

        <div class="relative">
            <div x-data="{ open: false }" @click.away="open = false" class="relative">

                <button @click="open = !open" class="flex items-center space-x-4 focus:outline-none">
                    <div class="mr-3 text-right hidden sm:block">
                        <p class="text-sm font-medium text-text-main">{{ Auth::user()->name ?? 'Usuário' }}</p>
                        <p class="text-xs text-text-light">Conta</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-primary text-black flex items-center justify-center font-bold ring-2 ring-offset-2 ring-offset-secondary ring-primary/50">
                        {{-- {{ strtoupper(substr(Auth::user()->name, 0, 2))) }} --}}
                        AT
                    </div>
                </button>

                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-48 bg-secondary rounded-md shadow-lg py-1 border border-neutral-700"
                     style="display: none;">

                    <form method="post" action="{{ route('user.logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-text-light hover:bg-neutral-700 hover:text-text-main transition-colors duration-150 flex items-center">
                            <i class="fas fa-sign-out-alt w-5 mr-2"></i>
                            Finalizar Sessão
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @yield('content')
</main>

<footer class="bg-secondary border-t border-neutral-800 mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <p class="text-center text-text-light text-sm">&copy; {{ date('Y') }}  Todos os direitos reservados.</p>
    </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
