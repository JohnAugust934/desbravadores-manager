<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gerenciar Especialidades') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-end">
                <a href="{{ route('especialidades.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    + Nova Especialidade
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nome da Especialidade
                                </th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Área
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($especialidades as $especialidade)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap font-bold">{{ $especialidade->nome }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    @php
                                    $cor = match($especialidade->area) {
                                    'ADRA' => 'bg-indigo-200',
                                    'Artes e Habilidades Manuais' => 'bg-blue-200',
                                    'Atividades Agrícolas' => 'bg-amber-700 text-white',
                                    'Atividades Missionárias' => 'bg-gray-200',
                                    'Atividades Profissionais' => 'bg-red-200',
                                    'Atividades Recreativas' => 'bg-green-200',
                                    'Ciência e Saúde' => 'bg-purple-200',
                                    'Estudos da Natureza' => 'bg-green-100',
                                    'Habilidades Domésticas' => 'bg-yellow-200',
                                    default => 'bg-gray-100'
                                    };
                                    @endphp
                                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight {{ $cor }} rounded-full">
                                        <span class="relative">{{ $especialidade->area }}</span>
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($especialidades->isEmpty())
                    <p class="mt-4 text-center text-gray-500">Nenhuma especialidade cadastrada.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>