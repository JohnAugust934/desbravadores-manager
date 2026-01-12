<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Controle de Mensalidades
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-100 p-4 rounded-lg shadow border-l-4 border-blue-500">
                    <h3 class="text-blue-800 text-sm font-bold uppercase">Mês/Ano</h3>
                    <p class="text-2xl font-bold text-blue-900">{{ $mes }}/{{ $ano }}</p>
                </div>
                <div class="bg-green-100 p-4 rounded-lg shadow border-l-4 border-green-500">
                    <h3 class="text-green-800 text-sm font-bold uppercase">Recebido</h3>
                    <p class="text-2xl font-bold text-green-900">R$ {{ number_format($valorRecebido, 2, ',', '.') }}</p>
                    <span class="text-xs text-green-700">{{ $totalPago }} pagos</span>
                </div>
                <div class="bg-red-100 p-4 rounded-lg shadow border-l-4 border-red-500">
                    <h3 class="text-red-800 text-sm font-bold uppercase">Pendente</h3>
                    <p class="text-2xl font-bold text-red-900">R$ {{ number_format($valorPendente, 2, ',', '.') }}</p>
                    <span class="text-xs text-red-700">{{ $totalPendente }} pendentes</span>
                </div>

                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex flex-col justify-center">
                    <form action="{{ route('mensalidades.gerar') }}" method="POST" class="flex flex-col gap-2">
                        @csrf
                        <input type="hidden" name="mes" value="{{ $mes }}">
                        <input type="hidden" name="ano" value="{{ $ano }}">
                        <div class="flex gap-2">
                            <input type="number" name="valor" step="0.01" placeholder="Valor (R$)" required class="w-full text-sm rounded border-gray-300">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-3 py-2 rounded uppercase">
                                Gerar Boleto
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-500 text-center">Gera para todos os ativos neste mês</p>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow flex items-center justify-between">
                <h3 class="text-gray-900 dark:text-gray-100 font-bold">Lista de Desbravadores</h3>
                <form action="{{ route('mensalidades.index') }}" method="GET" class="flex gap-2 items-center">
                    <select name="mes" class="rounded border-gray-300 text-sm">
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ $mes == $i ? 'selected' : '' }}>Mês {{ $i }}</option>
                            @endfor
                    </select>
                    <input type="number" name="ano" value="{{ $ano }}" class="w-20 rounded border-gray-300 text-sm">
                    <button type="submit" class="bg-gray-500 text-white px-3 py-2 rounded text-sm">Filtrar</button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Desbravador</th>
                                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Valor</th>
                                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mensalidades as $m)
                            <tr class="border-b border-gray-200">
                                <td class="px-5 py-5 bg-white text-sm font-bold">{{ $m->desbravador->nome }}</td>
                                <td class="px-5 py-5 bg-white text-sm">R$ {{ number_format($m->valor, 2, ',', '.') }}</td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    @if($m->status == 'pago')
                                    <span class="text-green-600 font-bold bg-green-100 px-2 py-1 rounded">Pago em {{ $m->data_pagamento->format('d/m') }}</span>
                                    @else
                                    <span class="text-red-600 font-bold bg-red-100 px-2 py-1 rounded">Pendente</span>
                                    @endif
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    @if($m->status == 'pendente')
                                    <form action="{{ route('mensalidades.pagar', $m->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-blue-600 hover:text-blue-900 font-bold border border-blue-600 rounded px-3 py-1 text-xs hover:bg-blue-50 transition">
                                            RECEBER
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-gray-400 text-xs">Concluído</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($mensalidades->isEmpty())
                    <div class="text-center py-10 text-gray-500">
                        Nenhuma mensalidade gerada para este mês.<br>
                        Use o formulário acima para gerar.
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>