<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Faker\Factory;

class ProjetoController extends Controller
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }
}
