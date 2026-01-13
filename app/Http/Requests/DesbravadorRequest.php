<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class DesbravadorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Apenas usuários autenticados podem fazer isso
        return Auth::check();
    }

    /**
     * Prepare the data for validation.
     * Útil para converter checkboxes (que não enviam nada quando false) em booleanos.
     */
    protected function prepareForValidation(): void
    {
        // Se 'ativo' vier no request, converte para boolean true/false.
        // Se não vier (checkbox desmarcado), define como false.
        $this->merge([
            'ativo' => $this->boolean('ativo'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date'],
            'sexo' => ['required', 'in:M,F'],

            // SEGURANÇA EXTRA: Garante que a unidade escolhida pertence ao MEU clube.
            // Sem o "where", um usuário poderia chutar o ID de uma unidade de outro clube.
            'unidade_id' => [
                'nullable',
                Rule::exists('unidades', 'id')->where(function ($query) {
                    return $query->where('club_id', Auth::user()->club_id);
                }),
            ],

            'classe_atual' => ['nullable', 'string', 'max:255'],
            'ativo' => ['boolean'],
        ];
    }
}
