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
            "Medições",                     
            "Análise de Solo",              
            "Apoiadores",                   
            "Equipe",                       
            "Sobre",                        
            "Contato"                       
        ],
        "icons" => [
            "fas fa-tachometer-alt",        
            "fas fa-globe",                 
            "fas fa-handshake",             
            "fas fa-users",                 
            "fas fa-info-circle",           
            "fas fa-envelope"               
        ],
        "rotas" => [
            "home",                         
            "solo",                         
            "apoiadores",                   
            "equipe",                       
            "sobre",                        
            "contato"                       
        ]
    ];

 
    public static $paginaSobre = [
        "paginaSobre" => [
            [
                "tituloPagina" => "Sobre o Projeto",
                "apresentacao" => "Apresentamos o projeto inovador de coleta de umidade do solo desenvolvido em parceria entre a renomada Universidade Regional do Noroeste do Estado do Rio Grande do Sul (UNIJUI) e empresas locais da região. Com o objetivo de fornecer dados precisos e relevantes para os agricultores da região noroeste do Rio Grande do Sul, unimos conhecimentos da área agronômica e tecnológica para promover a agricultura de precisão.",
                "projeto"=> "Rede de sensores inteligentes para o monitoramento de sistemas de irrigação por pivô central",
                "tituloJustificativa" => "Justificativa",
                "textoJustificativa" => "Segundo o levantamento da Câmara Setorial de Equipamentos de Irrigação (CSEI, 2021), a área irrigada por pivôs no Brasil, aumentou em 209 mil e 249 mil hectares em 2019 e 2020, respectivamente, totalizando mais de 1,6 milhões de hectares. Esse constante aumento nas áreas irrigadas, gera uma pressão gigantesca sobre os já escassos recursos hídricos. A escassez hídrica, pelas baixas alturas pluviométricas registradas, se torna mais evidente nos períodos de estiagem quando, mesmo com sistemas de irrigação, falta água para irrigar as lavouras. Sistemas de irrigação por pivô são historicamente utilizados nas culturas de milho e soja, mas têm se espalhado para outras culturas nos últimos anos, como em frutíferas e pastagens. Tanto no Brasil, quanto no Estado do Rio Grande do Sul, a agricultura irrigada é responsável pelo uso de mais de 60% da água doce disponível. O constante crescimento nos custos de produção, o aumento da contaminação da água por agrotóxicos e a busca por maior produtividade, exercem pressão sobre o uso da água nos sistemas de irrigação, e são reflexo de irrigação não realizada ou excessiva. A falta de informações para a tomada de decisão, pela baixa adoção de sensores inteligentes, fundamentais para a gestão do uso da água, é uma das principais causas dos erros e desperdícios que acarretam aumento nos gastos de energia e diesel e levam nutrientes e agrotóxicos das lavouras para os rios, reduzindo a produtividade das lavouras e causando poluição ambiental. Para aumentar a eficiência no uso da água e de energia e reduzir o carreamento de nutrientes, é imprescindível a implementação de sistemas inteligentes de monitoramento e alertas para irrigação. Situação frequente no campo é a realização de irrigação desnecessária que compromete a gestão dos recursos do sistema de irrigação. Assim, ao se reduzir os desperdícios de água, possibilita-se que outros produtores rurais, possam implementar tecnologias como sistemas de irrigação nas suas lavouras, garantindo maior segurança e produtividade para a região. Estima-se que ao se evitar apenas duas irrigações (10 milímetros cada) por ano, considerando 27 produtores, com 1 pivô de irrigação de 80 hectares cada, deixasse de desperdiçar 432 milhões de litros de água. O projeto visa a implementar uma rede de sensores de umidade do solo, e por meio de uma plataforma sistematizar informações para tornar a região Noroeste e Missões do Estado do Rio Grande do Sul, referência Latino Americana na eficiência do uso da água em pivôs de irrigação. O projeto pretende distribuir 1 (um) sensor a cada dois ou três municípios da região, beneficiando diretamente produtores rurais. Com essa rede de sensores, será desenvolvida uma plataforma digital pública, que possibilitará processar e apresentar todas as informações da rede inteligente. Esse material estará disponível, para auxiliar na tomada de decisões de produtores, consultores e da sociedade civil que não foram diretamente beneficiados com a instalação dos sensores. Além dos dados da rede de sensores, outras fontes de dados serão integradas ao sistema, dando início a um rede colaborativa com informações em tempo real com detalhes e informações da região. A integração dessas informações em uma plataforma permitirá a geração de mapas temáticos diários, com as condições agrometeorológicas, a duração dos estresses e até mesmo estimativas da redução das produtividades.",
                "tituloObjetivosEspecíficos" => "Objetivos Específicos",
                "textoObjetivosEspecíficos-a" => "a) Selecionar produtores rurais para implementar uma rede inteligente de monitoramento e alertas para sistemas de irrigação;",
                "textoObjetivosEspecíficos-b" => "b) Desenvolver uma plataforma digital capaz de integrar os dados dos sensores com outras fontes de informações agrometeorológicas da região Noroeste e Missões; c) Desenvolver rotinas, na plataforma, capazes de gerar mapas temáticos com as informações, e tornar a geração de conteúdo útil para auxiliar na tomada de decisão dos produtores e demais pessoas ligadas ao agronegócio.",
                "textoObjetivosEspecíficos-c" => "c) Desenvolver rotinas, na plataforma, capazes de gerar mapas temáticos com as informações, e tornar a geração de conteúdo útil para auxiliar na tomada de decisão dos produtores e demais pessoas ligadas ao agronegócio.",
                "tituloEstrutura" => "Estrutura da Plataforma",
                "textoEstrutura" => "A seguir, apresentamos a estrutura da plataforma digital que será desenvolvida como parte deste projeto inovador. A plataforma tem como objetivo integrar e sistematizar as informações coletadas pelos sensores de umidade do solo, além de outros dados agrometeorológicos da região. Com uma interface intuitiva e amigável, a plataforma oferecerá diversas funcionalidades para os usuários, incluindo gráficos dinâmicos, mapas temáticos, e ferramentas de análise que auxiliarão produtores, consultores e pesquisadores na tomada de decisões mais informadas e eficientes sobre o uso da água em sistemas de irrigação. Esta seção detalha cada uma das páginas e funcionalidades que compõem a plataforma, destacando como cada elemento contribui para a gestão sustentável dos recursos hídricos na agricultura.",
            ]
        ],
        "sobreData" => [
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
            'membros' => [
                [
                    'nome' => 'Drª Fernanda San Martins Sanes',
                    'title' => 'Coordenadora',
                    'descricao' => 'Engenheira Agrônoma, Mestre em Agronomia - Área de concentração - Solos, Doutora em Agronomia, Pós-doutora em Ciência do Solo. Experiência em docência na área de Agronomia, Engenharia Civil e Engenharia Ambiental.',
                    'foto' => 'Fernanda.jpeg',
                    'lattes' => 'http://lattes.cnpq.br/2638050343095103',
                    // 'email' => '',
                    // 'twitter' => '',
                    // 'facebook' => '',
                    // 'instagram' => ''                    
                ],
                [
                    'nome' => 'Drª Taciana Paula Enderle',
                    'title' => 'Professora Adjunta',
                    'descricao' => 'Engenheira Elétrica, Mestre em Engenharia Elétrica, Doutora em Modelagem Matemática. Atualmente professora Adjunta e Coordenadora do Campus da UNIJUÍ em Santa Rosa.',
                    'foto' => 'Taciana.jpg',
                    'lattes' => 'http://lattes.cnpq.br/6943517821737582'
                ],
                [
                    'nome' => 'Dr Maurício de Campos',
                    'title' => 'Professor e Pesquisador',
                    'descricao' => 'Engenheiro Elétrico, Mestre em Engenharia Elétrica, Doutor em Engenharia Elétrica. Experiência em cidades inteligentes, eficiência energética, smart grids, modelagem computacional, instrumentação e educação em engenharia.',
                    'foto' => 'Mauricio.jpg',
                    'lattes' => 'http://lattes.cnpq.br/7207601062237405'
                ],
                [
                    'nome' => 'Fabiana Simon',
                    'title' => 'Coordenadora do Núcleo de Pesquisa',
                    'descricao' => 'Graduada em Ciências Econômicas, Especialista em Comércio Exterior e Gestão de Instituições de Ensino Superior. Coordenadora do núcleo de Pesquisa, Desenvolvimento Tecnológico e Inovação da Agência de Inovação e Tecnologia da UNIJUÍ.',
                    'foto' => 'Fabiana.jpg',
                    'lattes' => 'http://lattes.cnpq.br/7497387209067432'
                ],
                [
                    'nome' => 'Eng.º Agrº Matheus Guilherme Libardoni Meotti',
                    'title' => 'Analista de Pesquisa e Desenvolvimento',
                    'descricao' => 'Engenheiro Agrônomo, Mestre em Sistemas Ambientais e Sustentabilidade, Doutorando em Engenharia Agrícola. Experiência em sensoriamento para conservação de grãos.',
                    'foto' => 'Mateus.jpeg',
                    'lattes' => 'http://lattes.cnpq.br/0370883124256890'
                ],

            ]      
        ]
    ];

    public static function loadEquipeData()
    {
      //  $equipeController = new EquipeController();
       // $equipeData = $equipeController->getEquipeData();
      //  self::$paginaEquipe[0]['membros'] = $equipeData;
    //  dd("loadEquipeData()");
    }

    public static $paginaApoiadores = [
        [
            "tituloPagina" => "Apoiadores",
            "apresentacao" => "Conheça nossos apoiadores e patrocinadores que nos apoiam no desenvolvimento deste projeto inovador de coleta de umidade do solo.",
            "apoiadores" =>             [
                [
                    'nome' => "UNIJUI (Universidade Regional do Noroeste do Estado do Rio Grande do Sul)",
                    'descricao' => "A UNIJUI é uma instituição de ensino superior renomada, localizada no Estado do Rio Grande do Sul, Brasil. 
                      <br>Com forte ênfase em pesquisa e inovação, a universidade oferece uma ampla gama de cursos de graduação e pós-graduação em diversas áreas do conhecimento. 
                      <br>A UNIJUI se destaca por sua atuação na integração entre ensino, pesquisa e extensão, promovendo o desenvolvimento regional e contribuindo significativamente para o avanço científico e tecnológico. 
                      <br>No projeto de rede de sensores para monitoramento de sistemas de irrigação, a UNIJUI atua como a principal instituição acadêmica, fornecendo expertise e apoio técnico através de seus pesquisadores e professores.",
                    'website' => "https://www.unijui.edu.br/",
                    'logo' => 'unijui.jpg',
                    'imageOrientation' => 'vertical',
                ],
                [
                    'nome' => "FOCKINK INDÚSTRIAS ELÉTRICAS LTDA",
                    'descricao' => "A FOCKINK INDÚSTRIAS ELÉTRICAS LTDA é uma empresa líder na fabricação de equipamentos elétricos no Brasil, com uma forte presença no mercado nacional e internacional. 
                    <br>A empresa é reconhecida por seu compromisso com a qualidade, inovação e sustentabilidade. A FOCKINK tem uma longa história de colaboração com instituições de pesquisa e desenvolvimento, contribuindo para projetos que visam a melhoria da eficiência energética e a implementação de tecnologias avançadas.
                    <br>No contexto do projeto de rede de sensores, a FOCKINK participa fornecendo suporte técnico e expertise em sensoriamento e conservação de recursos, ajudando a tornar a iniciativa uma referência em eficiência no uso da água em sistemas de irrigação.",
                    'website' => "https://www.unijui.edu.br/",
                    'logo' => 'fockink.png',
                    'imageOrientation' => 'horizontal',
                ],  
  
                [
                    'nome' => "Crops Team",
                    'descricao' => "
                    A Crops Team é uma empresa que une a pesquisa e o conhecimento científico para gerar soluções tecnológicas para produtores rurais e empresas do agronegócio.
                    <br>Através de ferramentas digitais e análise de dados fornecemos consultoria personalizada à produtores e empresas do agronegócio na quantificação da eficiência produtiva e identificação dos fatores que afetam a produção de grãos.
                    <br>Nossa Equipe composta por mestres e doutores em agronomia, ciências do solo, Ecofisiologia, engenharia agrícola, hidrologia e agrometeorologia, possui o know-how para unir modelagem de cultivos com análise de big data, bem como desenvolver modelos de cultivos e modelos preditivos
                    <br>Sua trajetória começou em 1947. Em 2022 completaram 75 anos de história, sendo sempre comprometidos com a excelência dos serviços prestados conforme a ideologia de seu fundador, Alfredo Arnaldo Fockink, aonde 'a melhor propaganda é o serviço'. É uma empresa familiar, 100% brasileira, sólida e bem estruturada que a torna referência nos segmentos em que atuam. Através do slogan, geramos soluções e integramos tecnologias. Desenvolvem Sistemas de Irrigação, Sistemas de Geração Fotovoltaica, Sistemas de Termometria e Aeração, Sistemas de Biogás, Estações de Carregamento Elétrico, Subestações, Painéis Elétricos e Automação, Instalações Eletromecânicas e Painéis e Caixas Metálicas Vazias, tudo isso gerido através de uma plataforma inteligente chamada Fockink IoT.
                    ",
                    'website' => "https://www.unijui.edu.br/",
                    'logo' => 'corpsteam.jpeg',
                    'imageOrientation' => 'horizontal',
                ],    
     
            ]
            
        ]
        
    ];

    public static function loadApoiadoresData()
    {
       // $apoiadoresController = new ApoiadoresController();
       // $apoiadoresData = $apoiadoresController->getApoiadoresData();
      //  self::$paginaApoiadores[0]['apoiadores'] = $apoiadoresData;

    }


    public static function getChartData()
    {
        return [
            'mainChartData' => [
                'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
                'data' => [65, 59, 80, 81, 56, 55, 40]
            ],
            'smallChartsData' => [
                [
                    'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
                    'data' => [28, 48, 40, 19, 86, 27, 90]
                ],
                [
                    'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
                    'data' => [18, 28, 77, 9, 100, 27, 40]
                ],
                [
                    'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
                    'data' => [18, 44, 20, 19, 36, 37, 50]
                ],
                [
                    'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
                    'data' => [38, 25, 47, 9, 40, 25, 50]
                ],
                [
                    'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
                    'data' => [28, 48, 40, 19, 86, 27, 90]
                ],
                [
                    'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
                    'data' => [18, 28, 77, 9, 100, 27, 40]
                ],
                [
                    'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
                    'data' => [18, 44, 20, 19, 36, 37, 50]
                ],
                [
                    'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho'],
                    'data' => [38, 25, 47, 9, 40, 25, 50]
                ]
            ]
        ];
    }



    
}
