<x-app-layout>
    <x-slot name="header">
        Editar Desbravador: {{ $desbravador->nome }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('desbravadores.update', $desbravador->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <x-input-label for="nome" value="Nome Completo" />
                                <x-text-input id="nome" class="block mt-1 w-full" type="text" name="nome" value="{{ old('nome', $desbravador->nome) }}" required />
                                <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="data_nascimento" value="Data de Nascimento" />
                                <x-text-input id="data_nascimento" class="block mt-1 w-full" type="date" name="data_nascimento" value="{{ old('data_nascimento', $desbravador->data_nascimento->format('Y-m-d')) }}" required />
                                <x-input-error :messages="$errors->get('data_nascimento')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="sexo" value="Sexo" />
                                <select id="sexo" name="sexo" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="M" {{ old('sexo', $desbravador->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('sexo', $desbravador->sexo) == 'F' ? 'selected' : '' }}>Feminino</option>
                                </select>
                                <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="unidade_id" value="Unidade" />
                                <select id="unidade_id" name="unidade_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Sem Unidade</option>
                                    @foreach($unidades as $unidade)
                                    <option value="{{ $unidade->id }}" {{ old('unidade_id', $desbravador->unidade_id) == $unidade->id ? 'selected' : '' }}>
                                        {{ $unidade->nome }}
                                    </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('unidade_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="classe_atual" value="Classe Atual" />
                                <select id="classe_atual" name="classe_atual" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Selecione...</option>
                                    @foreach(['Amigo', 'Companheiro', 'Pesquisador', 'Pioneiro', 'Excursionista', 'Guia'] as $classe)
                                    <option value="{{ $classe }}" {{ old('classe_atual', $desbravador->classe_atual) == $classe ? 'selected' : '' }}>
                                        {{ $classe }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center mt-4">
                                <label for="ativo" class="inline-flex items-center">
                                    <input id="ativo" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="ativo" value="1" {{ old('ativo', $desbravador->ativo) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Membro Ativo</span>
                                </label>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('desbravadores.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                Atualizar Dados
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>