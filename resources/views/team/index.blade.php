<x-app-layout>
    <x-slot name="header">Minha Equipe</x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <a href="{{ route('team.create') }}" class="bg-dbv-blue text-white px-4 py-2 rounded-md font-bold hover:bg-blue-900 transition">
                    + Adicionar Membro
                </a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Nome</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Cargo</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b border-gray-200">
                            <td class="px-5 py-4">{{ $user->name }}</td>
                            <td class="px-5 py-4">{{ $user->email }}</td>
                            <td class="px-5 py-4">
                                <span class="px-2 py-1 text-xs font-bold rounded 
                                    {{ $user->role == 'diretor' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                @if(Auth::id() !== $user->id)
                                <form action="{{ route('team.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900 text-sm font-bold">Remover</button>
                                </form>
                                @else
                                <span class="text-gray-400 text-sm italic">Você</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>