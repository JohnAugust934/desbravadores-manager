<x-app-layout>
    <x-slot name="header">
        Lista de Desbravadores
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-end mb-4">
                <a href="{{ route('desbravadores.create') }}" class="bg-dbv-blue text-white px-4 py-2 rounded-md font-bold hover:bg-blue-900 transition shadow">
                    + Novo Desbravador
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 border-b border-gray-200">
                            <tr>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-gray-600">Nome</th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-gray-600">Unidade</th>
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm text-gray-600">Classe</th>
                                <th class="text-center py-3 px-4 uppercase font-semibold text-sm text-gray-600">Idade</th>
                                <th class="text-right py-3 px-4 uppercase font-semibold text-sm text-gray-600">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse($desbravadores as $desbravador)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="text-left py-3 px-4 font-bold text-dbv-blue">
                                    {{ $desbravador->nome }}
                                </td>
                                <td class="text-left py-3 px-4">
                                    {{ $desbravador->unidade->nome ?? 'Sem Unidade' }}
                                </td>
                                <td class="text-left py-3 px-4">
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        {{ $desbravador->classe_atual ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-center py-3 px-4">
                                    {{ \Carbon\Carbon::parse($desbravador->data_nascimento)->age }} anos
                                </td>
                                <td class="text-right py-3 px-4 flex justify-end items-center">

                                    <a href="{{ route('desbravadores.ficha-medica', $desbravador->id) }}" class="text-red-500 hover:text-red-700 mr-3" title="Ficha Médica / Saúde">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </a>

                                    <a href="{{ route('desbravadores.especialidades', $desbravador->id) }}" class="text-yellow-500 hover:text-yellow-600 mr-3" title="Especialidades">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                        </svg>
                                    </a>

                                    <a href="{{ route('desbravadores.edit', $desbravador->id) }}" class="text-blue-500 hover:text-blue-700 mr-3" title="Editar">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('desbravadores.destroy', $desbravador->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este desbravador?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" title="Excluir">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">
                                    Nenhum desbravador cadastrado.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>