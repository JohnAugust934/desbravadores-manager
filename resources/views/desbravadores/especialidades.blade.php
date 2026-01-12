<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Especialidades de: {{ $desbravador->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Adicionar Nova Conclusão</h3>

                <form action="{{ route('desbravadores.especialidades.store', $desbravador->id) }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
                    @csrf

                    <div class="w-full md:w-1/2">
                        <label class="block text-sm font-bold mb-1 text-gray-700 dark:text-gray-300">Especialidade</label>
                        <select name="especialidade_id" required class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                            <option value="">Selecione...</option>
                            @foreach($todasEspecialidades as $esp)
                            <option value="{{ $esp->id }}">{{ $esp->nome }} ({{ $esp->area }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full md:w-1/4">
                        <label class="block text-sm font-bold mb-1 text-gray-700 dark:text-gray-300">Data de Conclusão</label>
                        <input type="date" name="data_conclusao" required class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                    </div>

                    <div class="w-full md:w-auto">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-bold">
                            Adicionar
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Especialidades Conquistadas</h3>

                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Especialidade</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Área</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Data Conclusão</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($desbravador->especialidades as $esp)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $esp->nome }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $esp->area }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                {{ \Carbon\Carbon::parse($esp->pivot->data_conclusao)->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <form action="{{ route('desbravadores.especialidades.destroy', [$desbravador->id, $esp->id]) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Remover</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($desbravador->especialidades->isEmpty())
                <p class="text-gray-500 mt-4 text-center">Nenhuma especialidade cadastrada ainda.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>