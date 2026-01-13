<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <title>Ficha Médica - {{ $desbravador->nome }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                -webkit-print-color-adjust: exact;
            }
        }

        body {
            font-family: sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 p-8 print:p-0 print:bg-white">

    <div class="max-w-3xl mx-auto bg-white p-8 shadow-lg print:shadow-none">

        <div class="text-center border-b-2 border-gray-800 pb-6 mb-6">
            <h1 class="text-2xl font-bold uppercase tracking-wider">{{ Auth::user()->club->nome ?? 'Clube de Desbravadores' }}</h1>
            <p class="text-sm text-gray-500 uppercase tracking-widest mt-1">Ficha de Saúde e Emergência</p>
        </div>

        <div class="mb-6">
            <h2 class="text-sm font-bold bg-gray-200 p-2 uppercase mb-4 border-l-4 border-gray-800">1. Identificação</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-gray-500 text-xs uppercase">Nome Completo</span>
                    <span class="font-bold text-lg">{{ $desbravador->nome }}</span>
                </div>
                <div>
                    <span class="block text-gray-500 text-xs uppercase">Data de Nascimento</span>
                    <span class="font-bold">{{ $desbravador->data_nascimento->format('d/m/Y') }} ({{ $desbravador->data_nascimento->age }} anos)</span>
                </div>
                <div>
                    <span class="block text-gray-500 text-xs uppercase">Unidade</span>
                    <span class="font-bold">{{ $desbravador->unidade->nome ?? 'Não definida' }}</span>
                </div>
                <div>
                    <span class="block text-gray-500 text-xs uppercase">Sexo</span>
                    <span class="font-bold">{{ $desbravador->sexo == 'M' ? 'Masculino' : 'Feminino' }}</span>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-sm font-bold bg-red-100 p-2 uppercase mb-4 border-l-4 border-red-600 text-red-900">2. Em Caso de Emergência (Prioridade)</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-gray-500 text-xs uppercase">Nome do Contato</span>
                    <span class="font-bold text-lg">{{ $desbravador->fichaMedica->contato_nome ?? '---' }}</span>
                </div>
                <div>
                    <span class="block text-gray-500 text-xs uppercase">Telefone / Celular</span>
                    <span class="font-bold text-lg">{{ $desbravador->fichaMedica->contato_telefone ?? '---' }}</span>
                </div>
                <div class="col-span-2">
                    <span class="block text-gray-500 text-xs uppercase">Parentesco</span>
                    <span class="font-bold">{{ $desbravador->fichaMedica->contato_parentesco ?? '---' }}</span>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-sm font-bold bg-gray-200 p-2 uppercase mb-4 border-l-4 border-gray-800">3. Dados Clínicos</h2>

            <div class="grid grid-cols-4 gap-4 mb-4 text-sm">
                <div>
                    <span class="block text-gray-500 text-xs uppercase">Tipo Sanguíneo</span>
                    <span class="font-bold text-xl border-2 border-dashed border-gray-300 p-2 text-center rounded block mt-1">
                        {{ $desbravador->fichaMedica->tipo_sanguineo ?? '?' }}
                    </span>
                </div>
                <div>
                    <span class="block text-gray-500 text-xs uppercase">Cartão SUS</span>
                    <span class="font-bold block mt-2">{{ $desbravador->fichaMedica->numero_sus ?? '---' }}</span>
                </div>
                <div class="col-span-2">
                    <span class="block text-gray-500 text-xs uppercase">Plano de Saúde</span>
                    <span class="font-bold block mt-2">{{ $desbravador->fichaMedica->plano_saude ?? '---' }}</span>
                </div>
            </div>

            <div class="space-y-4 text-sm">
                <div class="border border-gray-200 p-3 rounded bg-red-50">
                    <span class="block text-red-600 text-xs uppercase font-bold mb-1">Alergias</span>
                    <p class="font-medium">{{ $desbravador->fichaMedica->alergias ?? 'Nenhuma alergia relatada.' }}</p>
                </div>

                <div class="border border-gray-200 p-3 rounded">
                    <span class="block text-gray-500 text-xs uppercase font-bold mb-1">Medicamentos Contínuos</span>
                    <p class="font-medium">{{ $desbravador->fichaMedica->medicamentos_continuos ?? 'Nenhum medicamento relatado.' }}</p>
                </div>

                <div class="border border-gray-200 p-3 rounded">
                    <span class="block text-gray-500 text-xs uppercase font-bold mb-1">Problemas de Saúde / Observações</span>
                    <p class="font-medium">{{ $desbravador->fichaMedica->problemas_saude ?? 'Nenhum histórico relatado.' }}</p>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-gray-300 grid grid-cols-2 gap-12 text-center text-xs break-inside-avoid">
            <div>
                <div class="border-t border-black pt-2">Assinatura do Responsável</div>
            </div>
            <div>
                <div class="border-t border-black pt-2">Assinatura do Diretor</div>
                <div class="mt-1">Data: {{ date('d/m/Y') }}</div>
            </div>
        </div>

        <div class="fixed bottom-8 right-8 no-print">
            <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-4 rounded-full shadow-xl font-bold hover:bg-blue-700 flex items-center transition transform hover:scale-105">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                IMPRIMIR AGORA
            </button>
        </div>

    </div>
</body>

</html>