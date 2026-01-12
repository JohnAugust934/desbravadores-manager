<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Novo Lançamento Financeiro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('caixa.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Tipo de Movimentação</label>
                                <select name="tipo" required class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                                    <option value="entrada">Entrada (Receita)</option>
                                    <option value="saida">Saída (Despesa)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Data</label>
                                <input type="date" name="data_movimentacao" required value="{{ date('Y-m-d') }}"
                                    class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2">Descrição</label>
                            <input type="text" name="descricao" required placeholder="Ex: Venda de picolé no domingo"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Valor (R$)</label>
                                <input type="number" name="valor" step="0.01" min="0.01" required placeholder="0,00"
                                    class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Categoria</label>
                                <input type="text" name="categoria" placeholder="Ex: Cantina, Materiais, Secretaria"
                                    class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:text-white">
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition">
                                Salvar Lançamento
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>