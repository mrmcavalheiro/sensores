<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApoiadoresController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\ProjetoController;
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
    //    $apoiadoresController = new ApoiadoresController();
    //    $apoiadores = $apoiadoresController->getApoiadoresData();
    //    SistemaGlobal::loadApoiadoresData();
        $apoiadores = \App\Models\SistemaGlobal::$paginaApoiadores[0]['apoiadores'];
        return view('site.apoiadores', compact('apoiadores'));
    }



    //Pagina de Sobre
    public function sobre(){
        return view('site.sobre');
    }

    public function solo()
    {
        $soloController = new SoloController();
        $data = $soloController->loadSoloData(); // Carrega os dados de análise de solo
    
        return view('site.solo', compact('data'));
    }

    public function boletins()
    {
        $boletins = \App\Models\SistemaGlobal::$paginaBoletins[0];
        return view('site.boletins', compact('boletins'));
    }
    
    //Pagina de Equipe
    public function equipe()
    {
        $equipeController = new EquipeController();
        $equipe = $equipeController->getEquipeData();
        SistemaGlobal::loadEquipeData();
        return view('site.equipe', compact('equipe'));
    }

    //Pagina de Equipe
    public function projeto()
    {
        $apoiadores = \App\Models\SistemaGlobal::$paginaApoiadores[0]['apoiadores'];
        $realizadores = \App\Models\SistemaGlobal::$paginaRealizadores[0]['realizadores'];
        $equipeController = new EquipeController();
        $equipe = $equipeController->getEquipeData();
        SistemaGlobal::loadEquipeData();
        return view('site.projeto', compact('realizadores', 'apoiadores', 'equipe'));
    }

}
