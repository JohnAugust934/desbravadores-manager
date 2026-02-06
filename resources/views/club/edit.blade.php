<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dbv-blue dark:text-gray-100 leading-tight">
            {{ __('Meu Clube') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Card Principal --}}
            <div
                class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-xl border border-gray-100 dark:border-gray-700">

                <header class="mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        {{ __('Informações Gerais') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Mantenha os dados do seu clube e o brasão oficial atualizados.
                    </p>
                </header>

                {{-- Formulário de Edição --}}
                <form id="update-club-form" method="post" action="{{ route('club.update') }}"
                    enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        {{-- Coluna 1: Identidade Visual (Brasão) --}}
                        <div class="col-span-1 flex flex-col items-center md:items-start space-y-4">
                            <span
                                class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Brasão Oficial') }}</span>

                            <div class="relative group">
                                <div
                                    class="h-32 w-32 rounded-full overflow-hidden border-4 border-gray-100 dark:border-gray-700 shadow-md bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
                                    @if ($club->logo)
                                        <img src="{{ asset('storage/' . $club->logo) }}" alt="Brasão do Clube"
                                            class="h-full w-full object-cover">
                                    @else
                                        <svg class="h-12 w-12 text-gray-300 dark:text-gray-600" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>

                                {{-- Botão de Upload Escondido sobre a imagem (opcional) ou input abaixo --}}
                            </div>

                            <div class="w-full max-w-xs">
                                <label class="block">
                                    <span class="sr-only">Escolher brasão</span>
                                    <input type="file" name="logo" id="logo"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-xs file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        dark:file:bg-blue-900/30 dark:file:text-blue-300
                                        hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50
                                        cursor-pointer transition-colors" />
                                </label>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-500 text-center md:text-left">
                                    PNG, JPG ou GIF (Max. 2MB)
                                </p>
                                <x-input-error class="mt-2 text-center md:text-left" :messages="$errors->get('logo')" />
                            </div>
                        </div>

                        {{-- Coluna 2 e 3: Dados Cadastrais --}}
                        <div class="col-span-1 md:col-span-2 space-y-5">

                            {{-- Nome do Clube --}}
                            <div>
                                <x-input-label for="nome" :value="__('Nome do Clube *')" />
                                <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full"
                                    :value="old('nome', $club->nome)" required autofocus autocomplete="organization" />
                                <x-input-error class="mt-2" :messages="$errors->get('nome')" />
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                {{-- Cidade --}}
                                <div>
                                    <x-input-label for="cidade" :value="__('Cidade *')" />
                                    <x-text-input id="cidade" name="cidade" type="text" class="mt-1 block w-full"
                                        :value="old('cidade', $club->cidade)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('cidade')" />
                                </div>

                                {{-- Associação --}}
                                <div>
                                    <x-input-label for="associacao" :value="__('Associação / Campo')" />
                                    <x-text-input id="associacao" name="associacao" type="text"
                                        class="mt-1 block w-full" :value="old('associacao', $club->associacao)" placeholder="Ex: APO, APV..." />
                                    <x-input-error class="mt-2" :messages="$errors->get('associacao')" />
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Rodapé com Ações --}}
                    <div
                        class="flex flex-col-reverse sm:flex-row items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        @if (session('success'))
                            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                                class="text-sm font-medium text-green-600 dark:text-green-400 mr-auto animate-pulse">
                                {{ session('success') }}
                            </div>
                        @endif

                        <x-primary-button class="w-full sm:w-auto justify-center">
                            {{ __('Salvar Alterações') }}
                        </x-primary-button>
                    </div>
                </form>

                {{-- Formulário Separado para Remoção de Logo (Só aparece se tiver logo) --}}
                @if ($club->logo)
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400 text-center sm:text-left">
                                <span class="font-medium text-red-500">Zona de Perigo:</span> Deseja remover o brasão
                                atual e voltar ao padrão?
                            </div>
                            <form method="POST" action="{{ route('club.logo.destroy') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-semibold underline decoration-transparent hover:decoration-red-600 transition-all"
                                    onclick="return confirm('Tem certeza que deseja remover o brasão?');">
                                    {{ __('Remover Brasão') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
