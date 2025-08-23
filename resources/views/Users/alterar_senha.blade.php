<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Senha</title>
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
            <h1 class="text-2xl font-bold text-primary">Altere Sua Senha</h1>
            <p class="text-text-light mt-1">Preencha os campos abaixo</p>
        </div>

        <div class="px-6 pt-4">
            @if($errors->any())
                <div class="bg-red-900/50 border border-red-500/50 text-red-300 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <form class="p-6 space-y-6" method="post" action="{{ route('user.update_senha') }}">
            @csrf
            @method('PUT')
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
                        value="{{ old('email') }}"
                        class="w-full pl-10 pr-3 py-3 rounded-lg bg-neutral-900/50 border border-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-transparent text-text-main placeholder-neutral-600 transition duration-200"
                        placeholder="seu@email.com"
                        required
                    >
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-text-light mb-2">Nova Senha</label>
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

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-text-light mb-2">Confirmar nova senha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full pl-10 pr-3 py-3 rounded-lg bg-neutral-900/50 border border-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-transparent text-text-main placeholder-neutral-600 transition duration-200"
                        placeholder="••••••••"
                        required
                    >
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-primary hover:bg-green-400 text-black font-bold py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center shadow-lg shadow-primary/20 hover:shadow-primary/40">
                <i class="fas fa-key mr-2"></i> Alterar Senha
            </button>
        </form>

        <div class="bg-neutral-900/30 px-6 py-4 text-center border-t border-neutral-800">
            <p class="text-sm text-text-light">
                Lembrou a senha? <a href="{{ route('login') }}" class="text-accent font-medium hover:underline">Faça login</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
