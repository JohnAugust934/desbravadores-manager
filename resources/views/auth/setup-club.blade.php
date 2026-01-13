<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-dbv-blue">Bem-vindo, Diretor!</h2>
        <p class="text-gray-600 text-sm mt-2">Vamos configurar o ambiente do seu clube.</p>
    </div>

    <form method="POST" action="{{ route('club.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-4">
            <label class="block font-bold text-sm text-gray-700">Nome do Clube</label>
            <input type="text" name="club_name" class="w-full rounded-md border-gray-300" required autofocus placeholder="Ex: Clube Águias">
        </div>

        <div class="mb-4">
            <label class="block font-bold text-sm text-gray-700">Cidade</label>
            <input type="text" name="club_city" class="w-full rounded-md border-gray-300" required placeholder="Ex: São Paulo">
        </div>

        <hr class="my-6 border-gray-200">

        <div class="mb-4">
            <label class="block font-bold text-sm text-gray-700">Seu Nome Completo</label>
            <input type="text" name="user_name" class="w-full rounded-md border-gray-300" required>
        </div>

        <div class="mb-4">
            <label class="block font-bold text-sm text-gray-700">Seu Email (Login)</label>
            <input type="email" name="email" class="w-full rounded-md border-gray-300" required value="{{ $invitation->email ?? '' }}">
        </div>

        <div class="mb-4">
            <label class="block font-bold text-sm text-gray-700">Senha</label>
            <input type="password" name="password" class="w-full rounded-md border-gray-300" required>
        </div>

        <div class="mb-6">
            <label class="block font-bold text-sm text-gray-700">Confirmar Senha</label>
            <input type="password" name="password_confirmation" class="w-full rounded-md border-gray-300" required>
        </div>

        <button type="submit" class="w-full bg-dbv-blue text-white font-bold py-3 rounded hover:bg-blue-900 transition">
            Finalizar Cadastro e Entrar
        </button>
    </form>
</x-guest-layout>