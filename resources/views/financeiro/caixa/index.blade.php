<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Fluxo de Caixa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Cards de Resumo --}}
            <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Saldo --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 {{ $saldo >= 0 ? 'border-green-500' : 'border-red-500' }}">
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Saldo Atual</h3>
                    <p class="text-3xl font-bold {{ $saldo >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        R$ {{ number_format($saldo, 2, ',', '.') }}
                    </p>
                </div>

                {{-- Entradas (Variável nova que calculamos no Controller) --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Entradas</h3>
                    <p class="text-2xl font-bold text-blue-600">
                        R$ {{ number_format($totalEntradas ?? 0, 2, ',', '.') }}
                    </p>
                </div>

                {{-- Saídas (Variável nova que calculamos no Controller) --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow border-l-4 border-orange-500">
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Saídas</h3>
                    <p class="text-2xl font-bold text-orange-600">
                        R$ {{ number_format($totalSaidas ?? 0, 2, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="mb-4 flex items-center justify-end gap-2">
                {{-- Botões de Ação --}}
                <a href="{{ route('relatorios.financeiro') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-lg shadow transition">
                    Imprimir Relatório
                </a>
                <a href="{{ route('caixa.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow transition">
                    Nova Movimentação
                </a>
            </div>

            {{-- Tabela de Lançamentos --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Data</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Descrição</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipo</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Valor</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lancamentos as $item)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    {{ $item->data_movimentacao->format('d/m/Y') }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    {{ $item->descricao }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    @if($item->tipo == 'entrada')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Entrada
                                    </span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Saída
                                    </span>
                                    @endif
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-mono font-bold">
                                    R$ {{ number_format($item->valor, 2, ',', '.') }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    {{-- Botão de Excluir (Adicionado para facilitar testes) --}}
                                    <form action="{{ route('caixa.destroy', $item) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-xs uppercase">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($lancamentos->isEmpty())
                    <p class="mt-4 text-center text-gray-500">Nenhum lançamento no caixa.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>