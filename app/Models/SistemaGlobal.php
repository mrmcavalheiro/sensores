<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\ApoiadoresController;
use App\Http\Controllers\SoloController;

class SistemaGlobal extends Model
{
    use HasFactory;

    public static $Menu = [
        "itens" => [
            "Medições",                     // Título da Página: "Medições"
            "Análise de Solo",              // Título da Página: "Análise de Solo"
            "Apoiadores",      // Título da Página: "Patrocinadores/Apoiadores"
            "Equipe",                       // Título da Página: "Equipe"
            "Sobre",                        // Título da Página: "Sobre"
            "Contato"                       // Título da Página: "Contato"
        ],
        "icons" => [
            "fas fa-tachometer-alt",        // Ícone para "Medições"
            "fas fa-globe",                  // Ícone para "Análise de Solo"
            "fas fa-handshake",              // Ícone para "Patrocinadores/Apoiadores"
            "fas fa-users",                  // Ícone para "Equipe"
            "fas fa-info-circle",            // Ícone para "Sobre"
            "fas fa-envelope"                // Ícone para "Contato"
        ],
        "rotas" => [
            "home",                         // Rota para "Medições"
            "solo",                         // Rota para "Análise de Solo"
            "apoiadores",                    // Rota para "Patrocinadores/Apoiadores"
            "equipe",                         // Rota para "Equipe"
            "sobre",                        // Rota para "Sobre"
            "contato"                       // Rota para "Contato"
        ]
    ];

    public static $paginaSobre =[
        "paginaSobre"=> [
            [
                "tituloPagina" => "Sobre o Projeto",
                "apresentacao" => "Apresentamos o projeto inovador de coleta de umidade do solo desenvolvido em parceria entre a renomada Universidade Regional do Noroeste do Estado do Rio Grande do Sul (UNIJUI) e empresas locais da região. Com o objetivo de fornecer dados precisos e relevantes para os agricultores da região noroeste do Rio Grande do Sul, unimos conhecimentos da área agronômica e tecnológica para promover a agricultura de precisão."
            ]
        ],
        "sobreData"=> [
            [
                "titulo" => "Objetivo do Projeto",
                "texto" => "O objetivo principal do nosso projeto é coletar a umidade do solo nos estados da região noroeste do Rio Grande do Sul. Em parceria com a UNIJUI e empresas da região, trabalhamos para fornecer dados precisos sobre a umidade do solo para agricultores locais.",
                "rota" => "#"
            ],
            [
                "titulo" => "Equipe Técnica",
                "texto" => "A equipe técnica responsável pelo projeto é composta por professores do curso de Agronomia, professores de Ciência da Computação e técnicos das empresas parceiras. Todos os membros da equipe possuem experiência e conhecimento na área.",
                "rota" => "#"
            ],
            [
                "titulo" => "Página \"Medições\"",
                "texto" => "A página \"Medições\" apresenta uma lista de municípios com gráficos e tabelas das leituras dos dados coletados nas propriedades rurais de agricultores locais. Esses dados são essenciais para o monitoramento da umidade do solo.",
                "rota" => "home"
            ],
            [
                "titulo" => "Página \"Análise de Solo\"",
                "texto" => "A página \"Análise de Solo\" fornece informações relevantes sobre análises de solo realizadas pelos laboratórios da UNIJUI. Essas análises contribuem para um melhor entendimento das propriedades do solo nas áreas de interesse.",
                "rota" => "solo"
            ],
            [
                "titulo" => "Página \"Apoiadores\"",
                "texto" => "A página \"Apoiadores\" destaca as instituições parceiras que colaboram com o projeto. Ela inclui uma breve descrição sobre cada parceiro e fornece links para suas respectivas páginas. Além disso, são mencionados os agricultores/produtores rurais que forneceram os dados para as medições da umidade e dados do solo.",
                "rota" => "apoiadores"
            ],
            [
                "titulo" => "Página \"Equipe\"",
                "texto" => "A página \"Equipe\" apresenta informações sobre os professores e programadores envolvidos no projeto. É uma forma de reconhecer e destacar a contribuição de cada membro da equipe para o sucesso do projeto.",
                "rota" => "equipe"
            ],
            [
                "titulo" => "Página \"Sobre\"",
                "texto" => "A página \"Sobre\" contém uma descrição completa do projeto, abordando sua importância, objetivos e benefícios para a comunidade agrícola da região. É uma oportunidade de compartilhar mais detalhes sobre o trabalho desenvolvido.",
                "rota" => "sobre"
            ],
            [
                "titulo" => "Página \"Contato\"",
                "texto" => "A página \"Contato\" permite que os usuários entrem em contato conosco para fazer perguntas, enviar feedback ou solicitar informações adicionais sobre o projeto e suas iniciativas. Estamos sempre disponíveis para ajudar e fornecer suporte.",
                "rota" => "contato"
            ]
        ]
    ];


    public static $paginaEquipe = [
        [
            "tituloPagina" => "Equipe",
            "apresentacao" => "Conheça nossa equipe de especialistas que trabalham duro para fornecer soluções inovadoras no campo da coleta de umidade do solo.",
            "membros" => [] // Adicione um array vazio para armazenar os dados da equipe
        ]
    ];

    public static function loadEquipeData()
    {
        $equipeController = new EquipeController();
        $equipeData = $equipeController->getEquipeData();
        self::$paginaEquipe[0]['membros'] = $equipeData;
    }

    public static $paginaApoiadores = [
        [
            "tituloPagina" => "Apoiadores",
            "apresentacao" => "Conheça nossos apoiadores e patrocinadores que nos apoiam no desenvolvimento deste projeto inovador de coleta de umidade do solo.",
            "apoiadores" => [] // Adicione um array vazio para armazenar os dados dos apoiadores
        ]
    ];

    public static function loadApoiadoresData()
    {
        $apoiadoresController = new ApoiadoresController();
        $apoiadoresData = $apoiadoresController->getApoiadoresData();
        self::$paginaApoiadores[0]['apoiadores'] = $apoiadoresData;
    }

}
