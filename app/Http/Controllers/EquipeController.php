<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory;

class EquipeController extends Controller
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function getEquipeData()
    {
        $equipe = [];
        $numMembros = 8;

        foreach (range(1, $numMembros) as $i) {
            $equipe[] = $this->gerarMembroEquipe($i);
        }

        return $equipe;
    }

    private function gerarMembroEquipe($i)
    {
        return [
            'nome' => $this->faker->name,
            'descricao' => $this->faker->sentence . ' ' . $this->faker->sentence . ' ' . $this->faker->sentence,
            'contato_email' => $this->faker->email,
            'facebook' => $this->faker->url,
            'instagram' => $this->faker->url,
            'foto' => 'pessoa-' . $i . '.jpg',
        ];
    }
}
