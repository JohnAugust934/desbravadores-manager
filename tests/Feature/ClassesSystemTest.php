<?php

namespace Tests\Feature;

use App\Models\Classe;
use App\Models\Club;
use App\Models\Desbravador;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClassesSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_desbravador_aparece_apenas_na_classe_que_esta_vinculado()
    {
        // 1. Popula as classes
        $this->seed(\Database\Seeders\ClassesSeeder::class);

        // 2. Cria Usuário Instrutor
        $clube = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $clube->id, 'role' => 'instrutor']);

        // 3. Recupera classes do banco
        $classeAmigo = Classe::where('nome', 'Amigo')->first();
        $classeCompanheiro = Classe::where('nome', 'Companheiro')->first();

        // 4. Cria Desbravador vinculado a AMIGO (classe_atual = ID do Amigo)
        $dbv = Desbravador::factory()->create([
            'nome' => 'Joaozinho',
            'classe_atual' => $classeAmigo->id, // <--- O PULO DO GATO
            'ativo' => true,
        ]);

        // 5. Teste: Acessa tela de AMIGO -> Deve ver Joaozinho
        $response = $this->actingAs($user)->get(route('classes.show', $classeAmigo->id));
        $response->assertStatus(200);
        $response->assertSee('Joaozinho');

        // 6. Teste: Acessa tela de COMPANHEIRO -> NÃO deve ver Joaozinho
        $response = $this->actingAs($user)->get(route('classes.show', $classeCompanheiro->id));
        $response->assertStatus(200);
        $response->assertDontSee('Joaozinho');

        // 7. Teste: Muda Joaozinho para COMPANHEIRO no banco
        $dbv->update(['classe_atual' => $classeCompanheiro->id]);

        // 8. Teste: Acessa tela de COMPANHEIRO -> Agora DEVE ver Joaozinho
        $this->actingAs($user)->get(route('classes.show', $classeCompanheiro->id))
            ->assertSee('Joaozinho');
    }

    public function test_instrutor_pode_assinar_requisito()
    {
        $this->seed(\Database\Seeders\ClassesSeeder::class);
        $clube = Club::create(['nome' => 'Clube Teste', 'cidade' => 'SP']);
        $user = User::factory()->create(['club_id' => $clube->id, 'role' => 'instrutor']);

        $classe = Classe::where('nome', 'Amigo')->first();
        $req = $classe->requisitos->first();

        $dbv = Desbravador::factory()->create([
            'classe_atual' => $classe->id,
            'ativo' => true,
        ]);

        $response = $this->actingAs($user)->postJson(route('classes.toggle'), [
            'desbravador_id' => $dbv->id,
            'requisito_id' => $req->id,
            'concluido' => true,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('desbravador_requisito', [
            'desbravador_id' => $dbv->id,
            'requisito_id' => $req->id,
        ]);
    }
}
