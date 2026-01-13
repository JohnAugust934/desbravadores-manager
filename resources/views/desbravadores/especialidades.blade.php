<x-app-layout>
    <x-slot name="header">
        Especialidades de {{ $desbravador->nome }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('desbravadores.index') }}" class="text-gray-500 hover:text-gray-700 text-sm flex items-center">
                    &larr; Voltar para Lista
                </a>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-dbv-blue mb-4">Adicionar Nova Especialidade</h3>

                <form action="{{ route('desbravadores.especialidades.store', $desbravador->id) }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
                    @csrf

                    <div class="w-full md:w-1/2">
                        <x-input-label for="especialidade_id" value="Especialidade" />
                        <select id="especialidade_id" name="especialidade_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Selecione...</option>
                            @foreach($especialidades as $especialidade)
                            <option value="{{ $especialidade->id }}">{{ $especialidade->nome }} ({{ $especialidade->area }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/3">
                        <x-input-label for="data_conclusao" value="Data de Conclusão" />
                        <x-text-input id="data_conclusao" class="block mt-1 w-full" type="date" name="data_conclusao" required />
                    </div>

                    <div class="w-full md:w-auto">
                        <x-primary-button class="h-10 justify-center w-full">
                            Adicionar
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Conquistadas ({{ $desbravador->especialidades->count() }})</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Especialidade</th>
                                    <th class="px-6 py-3">Área</th>
                                    <th class="px-6 py-3">Data Conclusão</th>
                                    <th class="px-6 py-3 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($desbravador->especialidades as $conquistada)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $conquistada->nome }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $conquistada->area }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($conquistada->pivot->data_conclusao)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form action="{{ route('desbravadores.especialidades.destroy', ['id' => $desbravador->id, 'especialidade_id' => $conquistada->id]) }}" method="POST" onsubmit="return confirm('Remover esta especialidade?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Remover</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400 italic">
                                        Nenhuma especialidade cadastrada ainda.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>