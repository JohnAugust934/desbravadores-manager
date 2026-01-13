<x-app-layout>
    <x-slot name="header">Adicionar Novo Membro</x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form action="{{ route('team.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-bold text-gray-700">Nome Completo</label>
                        <input type="text" name="name" class="w-full rounded-md border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700">Email de Acesso</label>
                        <input type="email" name="email" class="w-full rounded-md border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700">Cargo / Função</label>
                        <select name="role" class="w-full rounded-md border-gray-300">
                            <option value="conselheiro">Conselheiro(a)</option>
                            <option value="secretario">Secretário(a)</option>
                            <option value="tesoureiro">Tesoureiro(a)</option>
                            <option value="diretor">Diretor(a) Associado(a)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Senha Inicial</label>
                            <input type="password" name="password" class="w-full rounded-md border-gray-300" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Confirmar Senha</label>
                            <input type="password" name="password_confirmation" class="w-full rounded-md border-gray-300" required>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded font-bold hover:bg-green-700 transition">
                            Cadastrar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>