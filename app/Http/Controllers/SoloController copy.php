<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SoloModel;
use Faker\Factory;

class SoloController extends Controller
{
    private $faker;
    public static $paginaSolo = [
        [
            "tituloPagina" => "Análise de Solo",
            "apresentacao" => "Veja abaixo os resultados das análises de solo realizadas em diferentes municípios.",
            "municipios" => [],
            "analisesPorMunicipio" => [],
        ]
    ];

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public static function gerarAnalisesSolo($quantidade, $municipios)
    {
        $analises = [];

        foreach ($municipios as $municipio) {
            $totalAnalise = random_int(5, 10);

            for ($i = 0; $i < $totalAnalise; $i++) {
                $analise = [
                    'municipio' => [
                        'codigoMunicipio' => $municipio['codigoMunicipio'],
                        'nomeMunicipio' => $municipio['nomeMunicipio'],
                        'totalAnalise' => $totalAnalise
                    ],
                    'analise' => self::getAnaliseSoloData(),
                ];

                $analises[] = $analise;
            }
        }
        return $analises;
    }



    public static function getAnaliseSoloData()
    {
        $dadosAnalise = [
            'textura_solo' => 'Franco-argiloso',
            'ph_solo' => 6.2,
            'materia_organica' => 2.5,
            'capacidade_troca_cations' => 20,
            'teores_nutrientes' => [
                'nitrogenio' => 30,
                'fosforo' => 20,
                'potassio' => 150,
                'calcio' => 800,
                'magnesio' => 200,
            ],
            'teor_materia_seca' => 20,
            'teor_carbono_organico' => 1.8,
            'densidade_solo' => 1.3,
            'porosidade_solo' => 40,
            'condutividade_eletrica' => 0.8,
        ];

        return $dadosAnalise;
    }

    public static function loadSoloData()
    {
        $municipios = self::gerarMunicipios(8);
        $analisesSolo = self::gerarAnalisesSolo(count($municipios), $municipios);

        self::$paginaSolo[0]['municipios'] = $municipios;
        self::$paginaSolo[0]['analisesPorMunicipio'] = $analisesSolo;
    }

    private static function gerarMunicipios($quantidade)
    {
        $municipios = [];

        for ($i = 1; $i <= $quantidade; $i++) {
            $codigoMunicipio = $i;
            $nomeMunicipio = "Município-" . sprintf('%03d', $i);

            $municipio = [
                'codigoMunicipio' => $codigoMunicipio,
                'nomeMunicipio' => $nomeMunicipio,
                'totalAnalise' => random_int(5, 10),
            ];
            $municipios[] = $municipio;
        }

        return $municipios;
    }
    private static function gerarAnalisesPorMunicipio($municipios)
    {
        $analisesPorMunicipio = [];

        foreach ($municipios as $municipio) {
            $analises = [];

            for ($i = 1; $i <= $municipio['totalAnalise']; $i++) {
                $analise = [
                    'codigoMunicipio' => $municipio['codigoMunicipio'],
                    'nomeMunicipio' => $municipio['nomeMunicipio'],
                    'codigoAnalise' => $i,
                    // Outros atributos da análise, se houver
                ];

                $analises[] = $analise;
            }

            $analisesPorMunicipio[] = $analises;
        }

        return $analisesPorMunicipio;
    }

}
