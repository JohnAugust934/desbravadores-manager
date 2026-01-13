<x-app-layout>
    <x-slot name="header">
        Ficha Médica: {{ $desbravador->nome }}
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex justify-between items-center bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <a href="{{ route('desbravadores.index') }}" class="text-gray-500 hover:text-gray-700 text-sm flex items-center mr-4">
                        &larr; Voltar
                    </a>
                    <h2 class="text-xl font-bold text-gray-800">
                        {{ $desbravador->nome }}
                    </h2>
                </div>

                <a href="{{ route('desbravadores.ficha-medica.print', $desbravador->id) }}" target="_blank" class="bg-gray-800 text-white px-4 py-2 rounded-md font-bold hover:bg-gray-700 transition flex items-center shadow">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Imprimir Ficha
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form action="{{ route('desbravadores.ficha-medica.update', $desbravador->id) }}" method="POST">
                        @csrf

                        <h3 class="text-lg font-bold text-red-600 mb-4 uppercase flex items-center border-b pb-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Contatos de Emergência
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Nome do Contato</label>
                                <input type="text" name="contato_nome" value="{{ old('contato_nome', $desbravador->fichaMedica->contato_nome ?? '') }}" class="w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Telefone / WhatsApp</label>
                                <input type="text" name="contato_telefone" value="{{ old('contato_telefone', $desbravador->fichaMedica->contato_telefone ?? '') }}" class="w-full rounded-md border-gray-300" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Parentesco</label>
                                <input type="text" name="contato_parentesco" value="{{ old('contato_parentesco', $desbravador->fichaMedica->contato_parentesco ?? '') }}" class="w-full rounded-md border-gray-300" placeholder="Ex: Mãe, Pai, Tio">
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-blue-800 mb-4 uppercase border-b pb-2">Dados Clínicos</h3>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700">Tipo Sanguíneo</label>
                            <select name="tipo_sanguineo" class="w-full md:w-1/4 rounded-md border-gray-300">
                                <option value="">Selecione...</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $tipo)
                                <option value="{{ $tipo }}" {{ (old('tipo_sanguineo', $desbravador->fichaMedica->tipo_sanguineo ?? '') == $tipo) ? 'selected' : '' }}>{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Alergias (Alimentos, Remédios, Insetos)</label>
                                <textarea name="alergias" rows="3" class="w-full rounded-md border-gray-300" placeholder="Se não houver, deixe em branco.">{{ old('alergias', $desbravador->fichaMedica->alergias ?? '') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Medicamentos de Uso Contínuo</label>
                                <textarea name="medicamentos_continuos" rows="3" class="w-full rounded-md border-gray-300" placeholder="Nome, dosagem e horário.">{{ old('medicamentos_continuos', $desbravador->fichaMedica->medicamentos_continuos ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700">Problemas de Saúde / Histórico</label>
                            <textarea name="problemas_saude" rows="2" class="w-full rounded-md border-gray-300" placeholder="Ex: Asma, Diabetes, Pressão Alta, Cirurgias recentes...">{{ old('problemas_saude', $desbravador->fichaMedica->problemas_saude ?? '') }}</textarea>
                        </div>

                        <h3 class="text-lg font-bold text-blue-800 mb-4 uppercase border-b pb-2">Convênio / SUS</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Cartão SUS</label>
                                <input type="text" name="numero_sus" value="{{ old('numero_sus', $desbravador->fichaMedica->numero_sus ?? '') }}" class="w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Plano de Saúde</label>
                                <input type="text" name="plano_saude" value="{{ old('plano_saude', $desbravador->fichaMedica->plano_saude ?? '') }}" class="w-full rounded-md border-gray-300" placeholder="Ex: Unimed">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Nº Carteirinha</label>
                                <input type="text" name="numero_carteirinha" value="{{ old('numero_carteirinha', $desbravador->fichaMedica->numero_carteirinha ?? '') }}" class="w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-md font-bold hover:bg-green-700 transition shadow">
                                Salvar Ficha Médica
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>