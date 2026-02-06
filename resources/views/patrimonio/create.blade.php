<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dbv-blue dark:text-gray-100 leading-tight">
            {{ __('Novo Item de Patrimônio') }}
        </h2>
    </x-slot>

    <div class="py-6 md:py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div
                class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">

                {{-- Cabeçalho do Card --}}
                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        Dados do Bem
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Preencha as informações para adicionar um novo item ao inventário do clube.
                    </p>
                </div>

                <div class="p-6 md:p-8">
                    <form method="POST" action="{{ route('patrimonio.store') }}" class="space-y-6">
                        @csrf

                        {{-- 1. Nome do Item (Full Width) --}}
                        <div>
                            <x-input-label for="item" value="Nome do Item / Equipamento *" />
                            <x-text-input id="item" name="item" type="text" class="mt-1 block w-full"
                                :value="old('item')" placeholder="Ex: Barraca Iglu 4 Pessoas, Caixa de Som..." required
                                autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('item')" />
                        </div>

                        {{-- 2. Grid: Quantidade e Estado --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Quantidade --}}
                            <div>
                                <x-input-label for="quantidade" value="Quantidade *" />
                                <div class="relative mt-1">
                                    <x-text-input id="quantidade" name="quantidade" type="number" min="1"
                                        step="1" class="block w-full pl-4" :value="old('quantidade', 1)" required />
                                    {{-- Ícone decorativo à direita --}}
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                        <span class="text-xs font-bold uppercase">unid.</span>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('quantidade')" />
                            </div>

                            {{-- Estado de Conservação --}}
                            <div>
                                <x-input-label for="estado_conservacao" value="Estado de Conservação *" />
                                <div class="relative mt-1">
                                    <select id="estado_conservacao" name="estado_conservacao"
                                        class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-dbv-blue focus:ring-dbv-blue rounded-lg shadow-sm appearance-none"
                                        required>
                                        <option value="" disabled selected>Selecione...</option>
                                        @foreach (['Novo', 'Ótimo', 'Bom', 'Regular', 'Ruim', 'Péssimo', 'Inservível'] as $estado)
                                            <option value="{{ $estado }}"
                                                {{ old('estado_conservacao') == $estado ? 'selected' : '' }}>
                                                {{ $estado }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- Seta customizada para Select --}}
                                    <div
                                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-300">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error class="mt-2" :messages="$errors->get('estado_conservacao')" />
                            </div>
                        </div>

                        {{-- 3. Grid: Valor e Data --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Valor Estimado --}}
                            <div>
                                <x-input-label for="valor_estimado" value="Valor Unitário Estimado (R$)" />
                                <div class="relative mt-1">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">R$</span>
                                    </div>
                                    <x-text-input id="valor_estimado" name="valor_estimado" type="number"
                                        step="0.01" min="0" class="block w-full pl-10" :value="old('valor_estimado')"
                                        placeholder="0,00" />
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Deixe em branco se
                                    desconhecido.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('valor_estimado')" />
                            </div>

                            {{-- Data de Aquisição --}}
                            <div>
                                <x-input-label for="data_aquisicao" value="Data de Aquisição" />
                                <x-text-input id="data_aquisicao" name="data_aquisicao" type="date"
                                    class="mt-1 block w-full" :value="old('data_aquisicao')" />
                                <x-input-error class="mt-2" :messages="$errors->get('data_aquisicao')" />
                            </div>
                        </div>

                        {{-- 4. Local de Armazenamento --}}
                        <div>
                            <x-input-label for="local_armazenamento" value="Local de Armazenamento" />
                            <div class="relative mt-1">
                                <x-text-input id="local_armazenamento" name="local_armazenamento" type="text"
                                    class="block w-full pl-10" :value="old('local_armazenamento')"
                                    placeholder="Ex: Armário A, Sala da Diretoria, Depósito..." />
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('local_armazenamento')" />
                        </div>

                        {{-- 5. Observações --}}
                        <div>
                            <x-input-label for="observacoes" value="Observações / Detalhes" />
                            <textarea id="observacoes" name="observacoes" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-dbv-blue focus:ring-dbv-blue rounded-lg shadow-sm resize-none"
                                placeholder="Descreva detalhes específicos, número de série, cor, ou avarias existentes...">{{ old('observacoes') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('observacoes')" />
                        </div>

                        {{-- Botões de Ação --}}
                        <div
                            class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <a href="{{ route('patrimonio.index') }}"
                                class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancelar
                            </a>

                            <button type="submit"
                                class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-3 bg-dbv-blue dark:bg-blue-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-800 dark:hover:bg-blue-500 focus:bg-blue-800 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Salvar Item
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
