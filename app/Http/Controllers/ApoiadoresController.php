<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory;

class ApoiadoresController extends Controller
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function getApoiadoresData()
    {
        $apoiadores = [];
        $numApoiadores = 6;

        foreach (range(1, $numApoiadores) as $i) {
            $apoiadores[] = $this->gerarParceiro($i);
        }

        return $apoiadores;
    }

    private function gerarParceiro($i)
    {
        return [
            'nome' => $this->faker->company,
            'descricao' => $this->faker->paragraph,
            'website' => $this->faker->url,
            'logo' => 'parceiro-' . $i . '.jpg',
        ];
    }
}
