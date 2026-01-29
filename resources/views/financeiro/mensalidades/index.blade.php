<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Controle de Mensalidades
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg shadow border-l-4 border-blue-500">
                    <h3 class="text-blue-800 dark:text-blue-300 text-xs font-bold uppercase tracking-wider">Referência</h3>
                    <p class="text-2xl font-bold text-blue-900 dark:text-white">{{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}/{{ $ano }}</p>
                </div>

                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg shadow border-l-4 border-green-500">
                    <h3 class="text-green-800 dark:text-green-300 text-xs font-bold uppercase tracking-wider">Recebido (Mês)</h3>
                    <p class="text-2xl font-bold text-green-900 dark:text-white">R$ {{ number_format($valorRecebido, 2, ',', '.') }}</p>
                    <span class="text-xs text-green-600 font-semibold">{{ $totalPago }} pagantes</span>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg shadow border-l-4 border-yellow-500">
                    <h3 class="text-yellow-800 dark:text-yellow-300 text-xs font-bold uppercase tracking-wider">Pendente (Mês)</h3>
                    <p class="text-2xl font-bold text-yellow-900 dark:text-white">R$ {{ number_format($valorPendente, 2, ',', '.') }}</p>
                    <span class="text-xs text-yellow-600 font-semibold">{{ $totalPendente }} em aberto</span>
                </div>

                <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg shadow border-l-4 border-red-500 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-2 opacity-10 group-hover:opacity-20 transition">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-red-800 dark:text-red-300 text-xs font-bold uppercase tracking-wider">Dívida Ativa (Total)</h3>
                    <p class="text-2xl font-bold text-red-900 dark:text-white">R$ {{ number_format($totalInadimplenteGeral, 2, ',', '.') }}</p>
                    <span class="text-xs text-red-600 font-semibold">{{ $qtdInadimplentes }} boletos atrasados</span>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 justify-between items-end bg-white dark:bg-gray-800 p-4 rounded-lg shadow">

                <form action="{{ route('mensalidades.gerar') }}" method="POST" class="flex flex-col gap-2 w-full md:w-auto">
                    @csrf
                    <label class="text-xs font-bold text-gray-500 uppercase">Gerar Cobrança em Massa</label>
                    <div class="flex gap-2">
                        <input type="hidden" name="mes" value="{{ $mes }}">
                        <input type="hidden" name="ano" value="{{ $ano }}">
                        <input type="number" name="valor" step="0.01" placeholder="Valor (R$)" required class="w-32 text-sm rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2 rounded uppercase shadow transition">
                            Gerar para Todos
                        </button>
                    </div>
                </form>

                <form action="{{ route('mensalidades.index') }}" method="GET" class="flex flex-col gap-2 w-full md:w-auto">
                    <label class="text-xs font-bold text-gray-500 uppercase">Filtrar Período</label>
                    <div class="flex gap-2">
                        <select name="mes" class="rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-sm">
                            @for($i=1; $i<=12; $i++)
                                <option value="{{ $i }}" {{ $mes == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                        </select>
                        <input type="number" name="ano" value="{{ $ano }}" class="w-20 rounded border-gray-300 dark:bg-gray-700 dark:border-gray-600 text-sm">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded text-sm shadow transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Desbravador</th>
                                <th class="px-5 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Valor</th>
                                <th class="px-5 py-3 bg-gray-50 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3 bg-gray-50 dark:bg-gray-700 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mensalidades as $m)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                                <td class="px-5 py-4 bg-white dark:bg-gray-800 text-sm font-bold">{{ $m->desbravador->nome }}</td>
                                <td class="px-5 py-4 bg-white dark:bg-gray-800 text-sm">R$ {{ number_format($m->valor, 2, ',', '.') }}</td>
                                <td class="px-5 py-4 bg-white dark:bg-gray-800 text-sm">
                                    @if($m->status == 'pago')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        Pago @if($m->data_pagamento) em {{ $m->data_pagamento->format('d/m') }} @endif
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        Pendente
                                    </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 bg-white dark:bg-gray-800 text-sm text-right">
                                    @if($m->status == 'pendente')
                                    <form action="{{ route('mensalidades.pagar', $m->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-white hover:bg-blue-600 border border-blue-600 rounded px-3 py-1 text-xs font-bold transition duration-200 uppercase tracking-wide">
                                            Receber
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-gray-400 text-xs italic">Concluído</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($mensalidades->isEmpty())
                    <div class="flex flex-col items-center justify-center py-10 text-gray-500">
                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p>Nenhuma mensalidade encontrada para este período.</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>