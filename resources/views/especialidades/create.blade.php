<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cadastrar Especialidade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('especialidades.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2" for="nome">Nome da Especialidade</label>
                            <input type="text" name="nome" id="nome" required placeholder="Ex: Fogueiras e Cozinha ao Ar Livre"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2" for="area">Área</label>
                            <select name="area" id="area" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300">
                                <option value="">Selecione...</option>
                                <option value="ADRA">ADRA</option>
                                <option value="Artes e Habilidades Manuais">Artes e Habilidades Manuais</option>
                                <option value="Atividades Agrícolas">Atividades Agrícolas</option>
                                <option value="Atividades Missionárias">Atividades Missionárias</option>
                                <option value="Atividades Profissionais">Atividades Profissionais</option>
                                <option value="Atividades Recreativas">Atividades Recreativas</option>
                                <option value="Ciência e Saúde">Ciência e Saúde</option>
                                <option value="Estudos da Natureza">Estudos da Natureza</option>
                                <option value="Habilidades Domésticas">Habilidades Domésticas</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Salvar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>