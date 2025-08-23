<!DOCTYPE html>
<html>
<head>
    <title>Verificar Email</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-blue-600 px-6 py-4 text-white">
            <h1 class="text-xl font-bold">Verifique seu endereço de email</h1>
        </div>

        <div class="p-6">
            @if (session('resent'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    Um novo link de verificação foi enviado para seu email.
                </div>
            @endif

            <p class="mb-4">Antes de continuar, por favor verifique seu email por um link de verificação.</p>
            <p class="mb-4">Se você não recebeu o email,</p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="text-blue-600 hover:text-blue-800">
                    clique aqui para solicitar outro
                </button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
