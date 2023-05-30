<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\SoloController;

class SoloModel extends Model
{
    protected $table = 'solo';

    protected $fillable = [
        'municipio',
        'textura_solo',
        'ph_solo',
        'materia_organica',
        'capacidade_troca_cations',
        'teores_nutrientes',
        'teor_materia_seca',
        'teor_carbono_organico',
        'densidade_solo',
        'porosidade_solo',
        'condutividade_eletrica',
    ];

    protected $casts = [
        'teores_nutrientes' => 'array',
    ];
}
