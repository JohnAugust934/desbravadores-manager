<x-app-layout>
    <x-slot name="header">
        Administração Geral (Super Admin)
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Gerar Novo Convite</h3>
                <form action="{{ route('admin.invites.store') }}" method="POST" class="flex gap-4">
                    @csrf
                    <input type="email" name="email" placeholder="Email do Diretor (Opcional)" class="rounded-md border-gray-300 w-full md:w-1/3">
                    <button type="submit" class="bg-dbv-blue text-white px-4 py-2 rounded font-bold hover:bg-blue-900 transition">
                        Gerar Link
                    </button>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Convites Pendentes</h3>
                <ul>
                    @foreach($invitations as $inv)
                    <li class="flex justify-between items-center border-b py-2">
                        <div>
                            <span class="font-mono text-sm bg-gray-100 p-1 select-all">{{ route('club.setup', ['token' => $inv->token]) }}</span>
                            <span class="text-xs text-gray-500 ml-2">({{ $inv->email ?? 'Qualquer email' }})</span>
                        </div>
                        <form action="{{ route('admin.invites.destroy', $inv->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-sm hover:underline">Cancelar</button>
                        </form>
                    </li>
                    @endforeach
                    @if($invitations->isEmpty())
                    <li class="text-gray-400 text-sm">Nenhum convite pendente.</li>
                    @endif
                </ul>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Clubes Ativos ({{ $clubs->count() }})</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Nome</th>
                                <th class="px-4 py-2 text-left">Cidade</th>
                                <th class="px-4 py-2 text-left">Usuários</th>
                                <th class="px-4 py-2 text-left">Criado em</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clubs as $club)
                            <tr class="border-b">
                                <td class="px-4 py-2 font-bold">{{ $club->nome }}</td>
                                <td class="px-4 py-2">{{ $club->cidade }}</td>
                                <td class="px-4 py-2">{{ $club->users_count }}</td>
                                <td class="px-4 py-2">{{ $club->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>