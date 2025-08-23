<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    // Nova paleta de cores inspirada na imagem
                    colors: {
                        'dark-bg': '#0a0a0a',     // Um preto profundo para o fundo
                        'primary': '#00ff9c',     // Verde neon vibrante
                        'secondary': '#1a1a1a',   // Um cinza escuro para os cards
                        'accent': '#00ff9c',     // Verde para links e destaques
                        'text-main': '#e5e5e5',    // Branco suave para o texto principal
                        'text-light': '#a3a3a3'     // Cinza claro para texto secundário
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
            <h1 class="text-2xl font-bold text-primary">Crie sua conta</h1>
            <p class="text-text-light mt-1">Preencha os campos abaixo</p>
        </div>

        @if($errors->any())
            <div class="bg-red-900/30 border-l-4 border-red-500 p-4 mx-6 mt-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0 text-red-500">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-200">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <form class="p-6 space-y-5" method="post" action="{{ route('user.create') }}">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-text-light mb-2">Nome completo</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                        <i class="fas fa-user"></i>
                    </div>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full pl-10 pr-3 py-3 rounded-lg bg-neutral-900/50 border border-neutral-700 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-transparent text-text-main placeholder-neutral-600 transition duration-200"
                        placeholder="Seu nome"
                        required
                    >
                </div>
                @error('name')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

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
                @error('email')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
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
                @error('password')
                <div class="flex items-start mt-1">
                    <div class="flex-shrink-0 text-red-500">
                        <i class="fas fa-exclamation-circle text-sm"></i>
                    </div>
                    <div class="ml-2">
                        <p class="text-sm text-red-400">{{ $message }}</p>
                    </div>
                </div>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-text-light mb-2">Confirmar senha</label>
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

            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input
                        type="checkbox"
                        id="terms"
                        name="terms"
                        class="h-4 w-4 text-primary focus:ring-primary border-neutral-600 rounded bg-neutral-700"
                        required
                    >
                </div>
                <div class="ml-3">
                    <label for="terms" class="text-sm text-text-light">
                        Concordo com os <a href="#" onclick="openModal()" class="text-accent hover:underline">Termos de Serviço</a>
                    </label>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-primary hover:bg-green-400 text-black font-bold py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center shadow-lg shadow-primary/20 hover:shadow-primary/40">
                <i class="fas fa-user-plus mr-2"></i> Criar conta
            </button>
        </form>

        <div class="bg-neutral-900/30 px-6 py-4 text-center border-t border-neutral-800">
            <p class="text-sm text-text-light">
                Já tem uma conta? <a href="{{ route('login') }}" class="text-accent font-medium hover:underline">Faça login</a>
            </p>
        </div>
    </div>
</div>

<div id="termsModal" class="fixed inset-0 bg-black/75 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4">
    <div class="relative bg-secondary border border-neutral-800 rounded-xl shadow-2xl shadow-primary/20 w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">
        <div class="flex justify-between items-center border-b border-neutral-800 p-5">
            <h3 class="text-xl font-bold text-primary">Termos de Serviço</h3>
            <button onclick="closeModal()" class="text-neutral-400 hover:text-text-main">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="p-5 overflow-y-auto">
            <div class="space-y-4 text-text-light">
                <div>
                    <h4 class="font-semibold text-lg text-primary">1. Aceitação dos Termos</h4>
                    <p class="mt-1">
                        Ao utilizar nossos serviços, você concorda com estes Termos de Serviço. Se não concordar, por favor, não utilize nossos serviços.
                    </p>
                </div>
                <div><h4 class="font-semibold text-lg text-primary">2. Uso do Serviço</h4><p class="mt-1">Você concorda em usar o serviço apenas para fins legais e de acordo com estes Termos. Você é responsável por manter a confidencialidade de sua conta e senha.</p></div><div><h4 class="font-semibold text-lg text-primary">3. Privacidade</h4><p class="mt-1">Sua privacidade é importante para nós. Nossa Política de Privacidade explica como coletamos, usamos e protegemos suas informações pessoais.</p></div><div><h4 class="font-semibold text-lg text-primary">4. Modificações</h4><p class="mt-1">Reservamos o direito de modificar estes Termos a qualquer momento. Alterações significativas serão comunicadas com antecedência.</p></div><div><h4 class="font-semibold text-lg text-primary">5. Limitação de Responsabilidade</h4><p class="mt-1">Não seremos responsáveis por quaisquer danos diretos, indiretos, incidentais ou consequenciais resultantes do uso ou incapacidade de usar nossos serviços.</p></div>
            </div>
        </div>

        <div class="flex justify-end p-5 border-t border-neutral-800 mt-auto">
            <button onclick="closeModal()" class="px-5 py-2 bg-primary text-black font-bold rounded-lg hover:bg-green-400 transition duration-300">
                Fechar
            </button>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('termsModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('termsModal').classList.add('hidden');
    }

    // Fechar modal ao clicar fora do conteúdo
    window.onclick = function(event) {
        const modal = document.getElementById('termsModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
</body>
</html>
