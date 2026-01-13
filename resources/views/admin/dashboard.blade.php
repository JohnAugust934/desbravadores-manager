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
                <ul class="divide-y divide-gray-100">
                    @foreach($invitations as $inv)
                    <li class="flex flex-col md:flex-row justify-between items-center py-3 gap-2">
                        <div class="flex-1 w-full">
                            <div class="flex items-center gap-2 mb-1">
                                @if($inv->expires_at && $inv->expires_at->isPast())
                                <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded">EXPIRADO</span>
                                @else
                                <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded">ATIVO</span>
                                @endif
                                <span class="text-sm text-gray-600">{{ $inv->email ?? 'Sem email definido' }}</span>

                                @if($inv->expires_at)
                                <span class="text-xs text-gray-400 ml-2">Expira em: {{ $inv->expires_at->format('d/m/Y H:i') }}</span>
                                @endif
                            </div>

                            <div class="flex items-center bg-gray-50 p-2 rounded border border-gray-200">
                                <input type="text" readonly value="{{ route('club.setup', ['token' => $inv->token]) }}" class="bg-transparent border-none text-xs text-gray-600 w-full focus:ring-0 p-0" onclick="this.select()">
                            </div>
                        </div>
                        <form action="{{ route('admin.invites.destroy', $inv->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-500 text-sm hover:text-red-700 font-bold px-3 py-1 border border-red-200 rounded hover:bg-red-50 transition">Revogar</button>
                        </form>
                    </li>
                    @endforeach
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