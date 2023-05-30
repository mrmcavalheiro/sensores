<?php

namespace App\Http\Controllers;

class SoloController extends Controller
{
    public static $paginaSolo = [
        [
            "tituloPagina" => "Análise de Solo",
            "apresentacao" => "Veja abaixo os resultados das análises de solo realizadas em diferentes municípios.",
            "municipios" => [],
        ]
    ];

    public static function getAnaliseSoloData($data)
    {
        $dadosAnalise = [
            'dataAnalise' => $data,
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

    public static function geraAnalises($totalAnalises)
    {
        $analises = [];

        for ($i = 1; $i <= $totalAnalises; $i++) {
            $dataAnalise = date('Y-m-d'); // Pode ser alterada para a data desejada
            $analise = self::getAnaliseSoloData($dataAnalise);

            $analises[] = $analise;
        }

        return $analises;
    }

    public static function gerarMunicipios($quantidade)
    {
        $municipios = [];

        for ($i = 1; $i <= $quantidade; $i++) {
            $totalAnalises = random_int(5, 10);
            $codigoMunicipio = $i;
            $nomeMunicipio = "Município-" . sprintf('%03d', $i);
            $analises = self::geraAnalises($totalAnalises);

            $municipio = [
                'codigoMunicipio' => $codigoMunicipio,
                'nomeMunicipio' => $nomeMunicipio,
                'totalAnalise' => $totalAnalises,
                'analises' => $analises,
            ];
            $municipios[] = $municipio;
        }

        return $municipios;
    }

    public static function loadSoloData()
    {
        $municipios = self::gerarMunicipios(8);
        self::$paginaSolo[0]['municipios'] = $municipios;
    }
}
