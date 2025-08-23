<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#0a0a0a',
                        'primary': '#00ff9c',
                        'secondary': '#1a1a1a',
                        'accent': '#00ff9c',
                        'text-main': '#e5e5e5',
                        'text-light': '#a3a3a3'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dark-bg min-h-screen flex items-center justify-center p-4 font-sans">
<div class="w-full max-w-md">
    <div class="bg-secondary rounded-xl shadow-2xl shadow-primary/10 overflow-hidden border border-neutral-800">
        <div class="p-6 text-center border-b border-neutral-800">
            <h1 class="text-2xl font-bold text-primary">Faça Login</h1>
            <p class="text-text-light mt-1">Preencha os campos abaixo</p>
        </div>

        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-900/50 border border-green-500/50 text-green-300 px-4 py-3 rounded text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-900/50 border border-red-500/50 text-red-300 px-4 py-3 rounded text-center">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-900/50 border border-red-500/50 text-red-300 px-4 py-3 rounded">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form class="p-6 space-y-6" method="post" action="{{ route('user.login') }}">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-text-light mb-2">E-mail</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full pl-10 pr-3 py-3 rounded-lg bg-neutral-900/50 border border-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-transparent text-text-main placeholder-neutral-600 transition duration-200"
                        placeholder="seu@email.com"
                        required
                    >
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-text-light mb-2">Senha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="w-full pl-10 pr-3 py-3 rounded-lg bg-neutral-900/50 border border-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-transparent text-text-main placeholder-neutral-600 transition duration-200"
                        placeholder="••••••••"
                        required
                    >
                </div>
            </div>

            <div class="flex items-center">
                <div class="flex-grow border-t border-neutral-700"></div>
                <span class="mx-4 text-text-light text-sm">OU</span>
                <div class="flex-grow border-t border-neutral-700"></div>
            </div>

            <a href="{{ url('/auth/redirect/google') }}" class="block">
                    <button type="button"
                            class="w-full bg-white hover:bg-gray-100 text-gray-800 font-bold py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center shadow-lg shadow-neutral-800/20 hover:shadow-neutral-800/40">
                        <img src="https://www.google.com/favicon.ico" alt="Google" class="w-5 h-5 mr-2">
                        Continuar com Google
                    </button>
                </a>

            <button type="submit"
                    class="w-full bg-primary hover:bg-green-400 text-black font-bold py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center shadow-lg shadow-primary/20 hover:shadow-primary/40">
                <i class="fas fa-sign-in-alt mr-2"></i> Fazer Login
            </button>

            <div class="text-center space-y-2">
                <p class="text-sm text-text-light">
                    Não tem uma conta? <a href="{{ route('user.register') }}" class="text-accent font-medium hover:underline">Crie uma agora</a>
                </p>
                <p class="text-sm text-text-light">
                    <a href="{{ route('user.alterar_senha') }}" class="text-accent font-medium hover:underline">Esqueceu a senha?</a>
                </p>
            </div>
        </form>
    </div>
</div>
</body>
</html>
