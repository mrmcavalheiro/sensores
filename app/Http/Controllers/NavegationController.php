<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApoiadoresController;
use App\Http\Controllers\EquipeController;
use App\Models\SistemaGlobal;
use App\Http\Controllers\SoloController;


class NavegationController extends Controller
{
    //Pagina de Contato
    public function contato(){
        return view('site.contato');
    }

    //Pagina de Principal
    public function home(){
        return view('site.home');
    }

    //Pagina de Apoiadores
    public function apoiadores()
    {
        $apoiadoresController = new ApoiadoresController();
        $apoiadores = $apoiadoresController->getApoiadoresData();
        SistemaGlobal::loadApoiadoresData();

        return view('site.apoiadores', compact('apoiadores'));
    }



    //Pagina de Sobre
    public function sobre(){
        return view('site.sobre');
    }

    public function solo()
    {
        $soloController = new SoloController();
        $soloController::loadSoloData(); // Carrega os dados de análise de solo

        return view('site.solo', compact('soloController'));
    }

    //Pagina de Equipe
    public function equipe()
    {
        $equipeController = new EquipeController();
        $equipe = $equipeController->getEquipeData();
        SistemaGlobal::loadEquipeData();
        return view('site.equipe', compact('equipe'));
    }

}
