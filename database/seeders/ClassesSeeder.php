<?php

namespace Database\Seeders;

use App\Models\Classe;
use App\Models\Requisito;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Definição das Classes Oficiais
        $classes = [
            // Regulares
            ['nome' => 'Amigo', 'cor' => '#3B82F6', 'ordem' => 1],       // Azul
            ['nome' => 'Companheiro', 'cor' => '#F59E0B', 'ordem' => 2], // Amarelo/Laranja (Correção: Companheiro geralmente é Amarelo Ouro)
            ['nome' => 'Pesquisador', 'cor' => '#10B981', 'ordem' => 3], // Verde
            ['nome' => 'Pioneiro', 'cor' => '#6B7280', 'ordem' => 4],    // Cinza/Prata
            ['nome' => 'Excursionista', 'cor' => '#8B5CF6', 'ordem' => 5], // Roxo/Bordô
            ['nome' => 'Guia', 'cor' => '#EF4444', 'ordem' => 6],        // Vermelho (Guia é vermelho)

            // Liderança
            ['nome' => 'Líder', 'cor' => '#1E3A8A', 'ordem' => 7],             // Azul Escuro
            ['nome' => 'Líder Máster', 'cor' => '#DC2626', 'ordem' => 8],      // Vermelho Forte
            ['nome' => 'Líder Máster Avançado', 'cor' => '#000000', 'ordem' => 9], // Preto
        ];

        foreach ($classes as $dadosClasse) {
            $classe = Classe::firstOrCreate(
                ['nome' => $dadosClasse['nome']],
                ['cor' => $dadosClasse['cor'], 'ordem' => $dadosClasse['ordem']]
            );

            // Popula os requisitos baseados na classe
            $this->criarRequisitos($classe);
        }
    }

    private function criarRequisitos(Classe $classe)
    {
        $requisitos = [];

        switch ($classe->nome) {
            case 'Amigo':
                $requisitos = [
                    // I. Gerais
                    ['cat' => 'Gerais', 'desc' => 'Ter no mínimo 10 anos de idade.'],
                    ['cat' => 'Gerais', 'desc' => 'Ser membro ativo do Clube de Desbravadores.'],
                    ['cat' => 'Gerais', 'desc' => 'Memorizar e recitar o Voto e a Lei do Desbravador.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro do Clube de Leitura Juvenil do ano em curso.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro "Pela Graça de Deus".'],
                    // II. Descoberta Espiritual
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Memorizar e recitar os livros do Antigo Testamento.'],
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Criar uma linha do tempo da criação (Gênesis 1 e 2).'],
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Escolher e cumprir um dos itens de leitura bíblica e diário.'],
                    // III. Servindo a Outros
                    ['cat' => 'Servindo a Outros', 'desc' => 'Dedicar duas horas ajudando alguém em necessidade.'],
                    ['cat' => 'Servindo a Outros', 'desc' => 'Demonstrar boas maneiras à mesa e como fazer uma apresentação.'],
                    // IV. Desenvolvimento da Amizade
                    ['cat' => 'Desenvolvimento da Amizade', 'desc' => 'Mencionar 10 aspectos de um bom cidadão.'],
                    ['cat' => 'Desenvolvimento da Amizade', 'desc' => 'Conhecer o Hino Nacional e a Bandeira do seu país.'],
                    // V. Saúde e Aptidão Física
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Completar uma especialidade de Natação Principiante I.'],
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Memorizar e explicar Daniel 1:8 e os princípios de temperança.'],
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Aprender os princípios de uma dieta saudável e preparar um cardápio.'],
                    // VI. Organização e Liderança
                    ['cat' => 'Organização e Liderança', 'desc' => 'Conhecer o hino dos Desbravadores e a história do clube local.'],
                    // VII. Estudo da Natureza
                    ['cat' => 'Estudo da Natureza', 'desc' => 'Completar uma especialidade: Gatos, Cães, Mamíferos, Sementes ou Aves de Estimação.'],
                    ['cat' => 'Estudo da Natureza', 'desc' => 'Conhecer diferentes métodos de observar a natureza.'],
                    // VIII. Arte de Acampar
                    ['cat' => 'Arte de Acampar', 'desc' => 'Saber fazer e usar os nós: Direito, Cirurgião, Escota, Lais de Guia, Cego, Fateixa, Pescador e Volta do Fiel.'],
                    ['cat' => 'Arte de Acampar', 'desc' => 'Pernoitar em um acampamento e explicar regras de segurança.'],
                ];
                break;

            case 'Companheiro':
                $requisitos = [
                    // I. Gerais
                    ['cat' => 'Gerais', 'desc' => 'Ter no mínimo 11 anos de idade.'],
                    ['cat' => 'Gerais', 'desc' => 'Membro ativo e memorizar o Voto e a Lei.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro do Clube de Leitura Juvenil do ano.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro "Caminho a Cristo".'],
                    // II. Descoberta Espiritual
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Memorizar e recitar os livros do Novo Testamento.'],
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Ler os evangelhos de Mateus e Marcos.'],
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Memorizar e recitar a Oração do Pai Nosso e as Bem-Aventuranças.'],
                    // III. Servindo a Outros
                    ['cat' => 'Servindo a Outros', 'desc' => 'Planejar e dedicar pelo menos duas horas servindo à comunidade.'],
                    // IV. Desenvolvimento da Amizade
                    ['cat' => 'Desenvolvimento da Amizade', 'desc' => 'Conversar sobre o respeito aos líderes e autoridades.'],
                    // V. Saúde e Aptidão Física
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Memorizar e explicar 1 Coríntios 6:19, 20.'],
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Completar a especialidade de Natação Principiante II.'],
                    // VI. Organização e Liderança
                    ['cat' => 'Organização e Liderança', 'desc' => 'Planejar e dirigir uma devocional.'],
                    ['cat' => 'Organização e Liderança', 'desc' => 'Participar de um programa especial do clube.'],
                    // VII. Estudo da Natureza
                    ['cat' => 'Estudo da Natureza', 'desc' => 'Participar de jogos na natureza e identificar 12 pássaros/árvores.'],
                    ['cat' => 'Estudo da Natureza', 'desc' => 'Completar uma especialidade: Árvores, Arbustos, Cactos, etc.'],
                    // VIII. Arte de Acampar
                    ['cat' => 'Arte de Acampar', 'desc' => 'Saber encontrar os 8 pontos cardeais sem bússola.'],
                    ['cat' => 'Arte de Acampar', 'desc' => 'Fazer e usar 5 nós novos e construir um móvel de acampamento.'],
                    ['cat' => 'Arte de Acampar', 'desc' => 'Participar de um acampamento de final de semana.'],
                ];
                break;

            case 'Pesquisador':
                $requisitos = [
                    // I. Gerais
                    ['cat' => 'Gerais', 'desc' => 'Ter no mínimo 12 anos de idade.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro do Clube de Leitura Juvenil do ano.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro "Além da Magia".'],
                    // II. Descoberta Espiritual
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Ler os evangelhos de Lucas e João.'],
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Discutir com sua unidade sobre o Espírito Santo.'],
                    // III. Servindo a Outros
                    ['cat' => 'Servindo a Outros', 'desc' => 'Participar de um projeto comunitário ou da igreja.'],
                    // IV. Desenvolvimento da Amizade
                    ['cat' => 'Desenvolvimento da Amizade', 'desc' => 'Participar de um debate sobre pressão de grupo.'],
                    ['cat' => 'Desenvolvimento da Amizade', 'desc' => 'Visitar uma repartição pública ou autoridade.'],
                    // V. Saúde e Aptidão Física
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Completar a especialidade de Primeiros Socorros Básicos.'],
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Fazer uma caminhada de 10 km.'],
                    // VI. Organização e Liderança
                    ['cat' => 'Organização e Liderança', 'desc' => 'Participar da abertura de uma reunião do clube.'],
                    // VII. Estudo da Natureza
                    ['cat' => 'Estudo da Natureza', 'desc' => 'Identificar 3 planetas e 5 estrelas/constelações.'],
                    ['cat' => 'Estudo da Natureza', 'desc' => 'Recapitular a história do Dilúvio e estudar fósseis.'],
                    // VIII. Arte de Acampar
                    ['cat' => 'Arte de Acampar', 'desc' => 'Descobrir direções usando estrelas/constelações.'],
                    ['cat' => 'Arte de Acampar', 'desc' => 'Ter uma faca/canivete e saber usar com segurança.'],
                    ['cat' => 'Arte de Acampar', 'desc' => 'Aprender a fazer 3 fogueiras e cozinhar nelas.'],
                ];
                break;

            case 'Pioneiro':
                $requisitos = [
                    // I. Gerais
                    ['cat' => 'Gerais', 'desc' => 'Ter no mínimo 13 anos de idade.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro do Clube de Leitura Juvenil do ano.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro "A História da Vida".'],
                    // II. Descoberta Espiritual
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Ler o livro de Atos dos Apóstolos.'],
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Estudar sobre a origem da IASD.'],
                    // III. Servindo a Outros
                    ['cat' => 'Servindo a Outros', 'desc' => 'Ajudar no planejamento de uma atividade social.'],
                    // IV. Desenvolvimento da Amizade
                    ['cat' => 'Desenvolvimento da Amizade', 'desc' => 'Participar de uma atividade missionária.'],
                    // V. Saúde e Aptidão Física
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Completar a especialidade de Resgate Básico.'],
                    // VI. Organização e Liderança
                    ['cat' => 'Organização e Liderança', 'desc' => 'Planejar e ensinar uma especialidade a um grupo.'],
                    // VII. Estudo da Natureza
                    ['cat' => 'Estudo da Natureza', 'desc' => 'Completar uma especialidade de natureza não realizada.'],
                    // VIII. Arte de Acampar
                    ['cat' => 'Arte de Acampar', 'desc' => 'Fazer e usar 3 amarras (Quadrada, Diagonal, Paralela).'],
                    ['cat' => 'Arte de Acampar', 'desc' => 'Construir móveis de acampamento.'],
                ];
                break;

            case 'Excursionista':
                $requisitos = [
                    // I. Gerais
                    ['cat' => 'Gerais', 'desc' => 'Ter no mínimo 14 anos de idade.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro do Clube de Leitura Juvenil do ano.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro "Nos Bastidores da Mídia".'],
                    // II. Descoberta Espiritual
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Ler os evangelhos de Romanos e I/II Coríntios.'],
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Descrever os dons espirituais descritos na Bíblia.'],
                    // III. Servindo a Outros
                    ['cat' => 'Servindo a Outros', 'desc' => 'Ajudar a organizar a Escola Cristã de Férias ou projeto similar.'],
                    // IV. Desenvolvimento da Amizade
                    ['cat' => 'Desenvolvimento da Amizade', 'desc' => 'Discutir como escolher um bom companheiro(a).'],
                    // V. Saúde e Aptidão Física
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Completar a especialidade de Temperança.'],
                    // VI. Organização e Liderança
                    ['cat' => 'Organização e Liderança', 'desc' => 'Auxiliar uma unidade de Desbravadores.'],
                    // VII. Estudo da Natureza
                    ['cat' => 'Estudo da Natureza', 'desc' => 'Recapitular o relato da criação e fazer um diário de 7 dias.'],
                    // VIII. Arte de Acampar
                    ['cat' => 'Arte de Acampar', 'desc' => 'Planejar e cozinhar três refeições ao ar livre.'],
                    ['cat' => 'Arte de Acampar', 'desc' => 'Construir um objeto com amarras e usar um machado/facão.'],
                    ['cat' => 'Arte de Acampar', 'desc' => 'Completar a especialidade de Pioneiria.'],
                ];
                break;

            case 'Guia':
                $requisitos = [
                    // I. Gerais
                    ['cat' => 'Gerais', 'desc' => 'Ter no mínimo 15 anos de idade.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro do Clube de Leitura Juvenil do ano.'],
                    ['cat' => 'Gerais', 'desc' => 'Ler o livro "Nossa Herança".'],
                    // II. Descoberta Espiritual
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Ler Apocalipse e estudar sobre o Santuário.'],
                    ['cat' => 'Descoberta Espiritual', 'desc' => 'Ler o livro "O Desejado de Todas as Nações" (capítulos selecionados).'],
                    // III. Servindo a Outros
                    ['cat' => 'Servindo a Outros', 'desc' => 'Trabalhar com o departamento infantil da igreja por 3 meses.'],
                    // IV. Desenvolvimento da Amizade
                    ['cat' => 'Desenvolvimento da Amizade', 'desc' => 'Discutir sobre namoro e casamento.'],
                    // V. Saúde e Aptidão Física
                    ['cat' => 'Saúde e Aptidão Física', 'desc' => 'Completar a especialidade de Primeiros Socorros (Geral).'],
                    // VI. Organização e Liderança
                    ['cat' => 'Organização e Liderança', 'desc' => 'Liderar uma unidade ou atividade do clube.'],
                    // VII. Estudo da Natureza
                    ['cat' => 'Estudo da Natureza', 'desc' => 'Completar a especialidade de Ecologia.'],
                    // VIII. Arte de Acampar
                    ['cat' => 'Arte de Acampar', 'desc' => 'Planejar e executar uma caminhada de 20 km com pernoite.'],
                    ['cat' => 'Arte de Acampar', 'desc' => 'Completar a especialidade de Vida Silvestre.'],
                ];
                break;

            case 'Líder':
                $requisitos = [
                    ['cat' => 'Pré-requisitos', 'desc' => 'Ter no mínimo 16 anos completos.'],
                    ['cat' => 'Pré-requisitos', 'desc' => 'Ser membro batizado da IASD.'],
                    ['cat' => 'Pré-requisitos', 'desc' => 'Ter completado a classe de Guia.'],
                    ['cat' => 'Liderança', 'desc' => 'Ler o Manual Administrativo do Clube de Desbravadores.'],
                    ['cat' => 'Liderança', 'desc' => 'Participar de um curso de treinamento para conselheiros (10 horas).'],
                    ['cat' => 'Desenvolvimento', 'desc' => 'Ler o livro "Nisto Cremos" (capítulos selecionados).'],
                    ['cat' => 'Desenvolvimento', 'desc' => 'Ler o livro "Salvação e Serviço".'],
                    ['cat' => 'Desenvolvimento', 'desc' => 'Completar o Ano Bíblico Jovem.'],
                    ['cat' => 'Habilidades', 'desc' => 'Participar de um curso de 10 horas sobre Liderança Campestre.'],
                    ['cat' => 'Habilidades', 'desc' => 'Planejar e conduzir três reuniões do clube.'],
                    ['cat' => 'Habilidades', 'desc' => 'Ter a especialidade de Primeiros Socorros Básicos.'],
                    ['cat' => 'Habilidades', 'desc' => 'Ter a especialidade de Segurança em Acampamentos.'],
                ];
                break;

            case 'Líder Máster':
                $requisitos = [
                    ['cat' => 'Pré-requisitos', 'desc' => 'Ser investido em Líder há pelo menos 1 ano.'],
                    ['cat' => 'Liderança', 'desc' => 'Participar de um curso de Liderança Master (Nível Distrital/Campo).'],
                    ['cat' => 'Liderança', 'desc' => 'Atuar como diretor ou diretor associado por pelo menos 1 ano.'],
                    ['cat' => 'Desenvolvimento', 'desc' => 'Ler o livro "O Libertador" (Desejado de Todas as Nações).'],
                    ['cat' => 'Desenvolvimento', 'desc' => 'Criar um projeto evangelístico envolvendo o clube.'],
                    ['cat' => 'Habilidades', 'desc' => 'Completar o Mestrado em Vida Campestre.'],
                    ['cat' => 'Habilidades', 'desc' => 'Ensinar 2 especialidades para o clube.'],
                    ['cat' => 'Habilidades', 'desc' => 'Planejar e coordenar um acampamento de 3 dias.'],
                ];
                break;

            case 'Líder Máster Avançado':
                $requisitos = [
                    ['cat' => 'Pré-requisitos', 'desc' => 'Ser investido em Líder Máster há pelo menos 1 ano.'],
                    ['cat' => 'Liderança', 'desc' => 'Exercer função na coordenação distrital ou regional.'],
                    ['cat' => 'Liderança', 'desc' => 'Auxiliar na formação de novos líderes.'],
                    ['cat' => 'Desenvolvimento', 'desc' => 'Ler o livro "Educação".'],
                    ['cat' => 'Desenvolvimento', 'desc' => 'Escrever um artigo ou monografia sobre o desenvolvimento de Desbravadores.'],
                    ['cat' => 'Habilidades', 'desc' => 'Organizar e dirigir um Campori ou evento de grande porte.'],
                    ['cat' => 'Habilidades', 'desc' => 'Completar mais um Mestrado (além de Vida Campestre).'],
                    ['cat' => 'Habilidades', 'desc' => 'Criar e executar um plano de discipulado anual.'],
                ];
                break;
        }

        // Inserção no Banco
        foreach ($requisitos as $index => $req) {
            Requisito::firstOrCreate(
                ['classe_id' => $classe->id, 'descricao' => $req['desc']],
                [
                    'categoria' => $req['cat'],
                    'codigo' => strtoupper(substr($classe->nome, 0, 3)).'-'.($index + 1),
                ]
            );
        }
    }
}
