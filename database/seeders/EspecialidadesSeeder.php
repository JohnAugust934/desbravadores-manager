<?php

namespace Database\Seeders;

use App\Models\Especialidade;
use Illuminate\Database\Seeder;

class EspecialidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lista massiva de especialidades
        $especialidades = [
            // === ADRA ===
            ['area' => 'ADRA', 'nome' => 'Alívio da Fome'],
            ['area' => 'ADRA', 'nome' => 'Avaliação da Comunidade'],
            ['area' => 'ADRA', 'nome' => 'Desenvolvimento Comunitário'],
            ['area' => 'ADRA', 'nome' => 'Serviço Comunitário'],
            ['area' => 'ADRA', 'nome' => 'Resposta a Emergências e Desastres'],

            // === ARTES E HABILIDADES MANUAIS ===
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Arte em Massa de Pão'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Modelagem'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Cestaria'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Decoupage'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Desenho e Pintura'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Escultura'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Fotografia'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Origami'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Pintura em Vidro'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Saponificação'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Trabalhos em Couro'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Trabalhos em Feltro'],
            ['area' => 'Artes e Habilidades Manuais', 'nome' => 'Música'],

            // === ATIVIDADES AGROPECUÁRIAS ===
            ['area' => 'Atividades Agropecuárias', 'nome' => 'Agricultura de Subsistência'],
            ['area' => 'Atividades Agropecuárias', 'nome' => 'Avicultura'],
            ['area' => 'Atividades Agropecuárias', 'nome' => 'Criação de Ovelhas'],
            ['area' => 'Atividades Agropecuárias', 'nome' => 'Floricultura'],
            ['area' => 'Atividades Agropecuárias', 'nome' => 'Horticultura'],
            ['area' => 'Atividades Agropecuárias', 'nome' => 'Jardinagem'],
            ['area' => 'Atividades Agropecuárias', 'nome' => 'Pomicultura'],

            // === ATIVIDADES MISSIONÁRIAS E COMUNITÁRIAS ===
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Arte de Contar Histórias Cristãs'],
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Arte de Pregar'],
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Aventuri'],
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Cidadania Cristã'],
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Estudos Bíblicos'],
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Evangelismo Pessoal'],
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Libras'],
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Marcação Bíblica'],
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Mordomia'],
            ['area' => 'Atividades Missionárias e Comunitárias', 'nome' => 'Temperança'],

            // === ATIVIDADES PROFISSIONAIS ===
            ['area' => 'Atividades Profissionais', 'nome' => 'Computação'],
            ['area' => 'Atividades Profissionais', 'nome' => 'Contabilidade'],
            ['area' => 'Atividades Profissionais', 'nome' => 'Educação'],
            ['area' => 'Atividades Profissionais', 'nome' => 'Eletricidade'],
            ['area' => 'Atividades Profissionais', 'nome' => 'Jornalismo'],
            ['area' => 'Atividades Profissionais', 'nome' => 'Marcenaria'],
            ['area' => 'Atividades Profissionais', 'nome' => 'Mecânica Automobilística'],
            ['area' => 'Atividades Profissionais', 'nome' => 'Web Design'],

            // === ATIVIDADES RECREATIVAS (As mais comuns) ===
            ['area' => 'Atividades Recreativas', 'nome' => 'Acampamento I'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Acampamento II'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Acampamento III'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Acampamento IV'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Arte de Acampar'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Caminhada'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Ciclismo'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Cultura Física'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Excursionismo'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Fogueiras e Cozinha ao Ar Livre'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Liderança Campestre'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Mapa e Bússola'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Natação Principiante I'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Natação Principiante II'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Nós e Amarras'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Ordem Unida'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Ordem Unida - Avançado'],
            ['area' => 'Atividades Recreativas', 'nome' => 'Pioneiria'],

            // === CIÊNCIA E SAÚDE ===
            ['area' => 'Ciência e Saúde', 'nome' => 'Alerta Vermelho'],
            ['area' => 'Ciência e Saúde', 'nome' => 'Anatomia Humana'],
            ['area' => 'Ciência e Saúde', 'nome' => 'Enfermagem Caseira'],
            ['area' => 'Ciência e Saúde', 'nome' => 'Física'],
            ['area' => 'Ciência e Saúde', 'nome' => 'Nutrição'],
            ['area' => 'Ciência e Saúde', 'nome' => 'Primeiros Socorros - Básico'],
            ['area' => 'Ciência e Saúde', 'nome' => 'Primeiros Socorros'],
            ['area' => 'Ciência e Saúde', 'nome' => 'Química'],
            ['area' => 'Ciência e Saúde', 'nome' => 'Reanimação Cardiopulmonar'],
            ['area' => 'Ciência e Saúde', 'nome' => 'Resgate Básico'],

            // === ESTUDO DA NATUREZA ===
            ['area' => 'Estudo da Natureza', 'nome' => 'Anfíbios'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Animais Domésticos'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Aves'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Aves Domésticas'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Cactos'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Cães'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Climatologia'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Ecologia'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Felinos'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Flores'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Insetos'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Mamíferos'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Répteis'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Sementes'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Árvores'],
            ['area' => 'Estudo da Natureza', 'nome' => 'Astronomia'],

            // === HABILIDADES DOMÉSTICAS ===
            ['area' => 'Habilidades Domésticas', 'nome' => 'Arte Culinária'],
            ['area' => 'Habilidades Domésticas', 'nome' => 'Costura Básica'],
            ['area' => 'Habilidades Domésticas', 'nome' => 'Culinária Básica'],
            ['area' => 'Habilidades Domésticas', 'nome' => 'Lavanderia'],
            ['area' => 'Habilidades Domésticas', 'nome' => 'Nutrição'],
            ['area' => 'Habilidades Domésticas', 'nome' => 'Orçamento Familiar'],

            // === MESTRADOS ===
            ['area' => 'Mestrados', 'nome' => 'Mestrado em ADRA'],
            ['area' => 'Mestrados', 'nome' => 'Mestrado em Artes e Habilidades Manuais'],
            ['area' => 'Mestrados', 'nome' => 'Mestrado em Atividades Recreativas'],
            ['area' => 'Mestrados', 'nome' => 'Mestrado em Ciência e Saúde'],
            ['area' => 'Mestrados', 'nome' => 'Mestrado em Estudo da Natureza'],
            ['area' => 'Mestrados', 'nome' => 'Mestrado em Vida Campestre'],
            ['area' => 'Mestrados', 'nome' => 'Mestrado em Testemunho'],
        ];

        foreach ($especialidades as $esp) {
            // firstOrCreate evita duplicatas se rodar o seeder mais de uma vez
            Especialidade::firstOrCreate(
                ['nome' => $esp['nome']],
                [
                    'area' => $esp['area'],
                    // Adicionando cores padrão baseadas na área (opcional, já que a View trata)
                    'cor_fundo' => $this->getColorByArea($esp['area']),
                ]
            );
        }
    }

    /**
     * Helper para definir uma cor padrão se desejar salvar no banco
     */
    private function getColorByArea($area)
    {
        return match ($area) {
            'ADRA' => '#3b82f6', // Azul
            'Artes e Habilidades Manuais' => '#a855f7', // Roxo
            'Atividades Agropecuárias' => '#854d0e', // Marrom
            'Atividades Missionárias e Comunitárias' => '#1e3a8a', // Azul Escuro
            'Atividades Profissionais' => '#dc2626', // Vermelho
            'Atividades Recreativas' => '#10b981', // Verde
            'Ciência e Saúde' => '#ef4444', // Vermelho Claro
            'Estudo da Natureza' => '#ffffff', // Branco (Na faixa é branca)
            'Habilidades Domésticas' => '#f59e0b', // Amarelo
            'Mestrados' => '#000000', // Preto
            default => '#cccccc',
        };
    }
}
