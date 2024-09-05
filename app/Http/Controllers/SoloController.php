<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SoloController extends Controller
{
    public static $paginaSolo = [
        "tituloPagina" => "Análise de Solo",
        "tituloAnaliseFisica" => "ANÁLISES QUÍMICAS E FÍSICAS DAS AMOSTRAS DE SOLOS NAS PROPRIEDADES DO PROJETO INOVA",
        "tituloAnalises" => "ANÁLISES QUÍMICAS",
        "tituloFisicas" => "ANÁLISES FÍSICAS",
        "apresentacao" => "Veja abaixo os resultados das análises de solo realizadas em diferentes municípios.",
    ];

    public function loadSoloData()
    {
        // Construir a consulta para obter os dados das análises
        $regioes = DB::table('regions as r')
            ->join('municipios as m', 'm.RegiaoSensores', '=', 'r.id')
            ->join('produtores as p', 'p.municipio_ibge', '=', 'm.IBGE')
            ->leftJoin('analises_quimicas_produtor as aqp', 'aqp.produtor_id', '=', 'p.id')
            ->leftJoin('analises_fisicas_produtor as afp', 'afp.produtor_id', '=', 'p.id')
            ->select(
                'r.description as regiao_nome',
                'm.Município as municipio_nome',
                'p.produtor_nome',
                'p.nome_fantasia',
                'aqp.data_analise',
    
                // Análises Químicas
                'aqp.argila_0_20 as argila_quimica_0_20',
                'aqp.argila_20_40 as argila_quimica_20_40',
                'aqp.ph_0_20 as ph_quimica_0_20',
                'aqp.ph_20_40 as ph_quimica_20_40',
                'aqp.smp_0_20 as smp_quimica_0_20',
                'aqp.smp_20_40 as smp_quimica_20_40',
                'aqp.fosforo_0_20 as fosforo_quimica_0_20',
                'aqp.fosforo_20_40 as fosforo_quimica_20_40',
                'aqp.potassio_0_20 as potassio_quimica_0_20',
                'aqp.potassio_20_40 as potassio_quimica_20_40',
                'aqp.materia_organica_0_20 as materia_organica_quimica_0_20',
                'aqp.materia_organica_20_40 as materia_organica_quimica_20_40',
                'aqp.aluminio_0_20 as aluminio_quimica_0_20',
                'aqp.aluminio_20_40 as aluminio_quimica_20_40',
                'aqp.calcio_0_20 as calcio_quimica_0_20',
                'aqp.calcio_20_40 as calcio_quimica_20_40',
                'aqp.magnesio_0_20 as magnesio_quimica_0_20',
                'aqp.magnesio_20_40 as magnesio_quimica_20_40',
                'aqp.ca_mg_0_20 as ca_mg_quimica_0_20',
                'aqp.ca_mg_20_40 as ca_mg_quimica_20_40',
                'aqp.h_al_0_20 as h_al_quimica_0_20',
                'aqp.h_al_20_40 as h_al_quimica_20_40',
                'aqp.ctc_ph7_0_20 as ctc_ph7_quimica_0_20',
                'aqp.ctc_ph7_20_40 as ctc_ph7_quimica_20_40',
                'aqp.ctc_efetiva_0_20 as ctc_efetiva_quimica_0_20',
                'aqp.ctc_efetiva_20_40 as ctc_efetiva_quimica_20_40',
                'aqp.sat_bases_0_20 as sat_bases_quimica_0_20',
                'aqp.sat_bases_20_40 as sat_bases_quimica_20_40',
                'aqp.sat_al_0_20 as sat_al_quimica_0_20',
                'aqp.sat_al_20_40 as sat_al_quimica_20_40',
                'aqp.cobre_0_20 as cobre_quimica_0_20',
                'aqp.cobre_20_40 as cobre_quimica_20_40',
                'aqp.zinco_0_20 as zinco_quimica_0_20',
                'aqp.zinco_20_40 as zinco_quimica_20_40',
                'aqp.manganes_0_20 as manganes_quimica_0_20',
                'aqp.manganes_20_40 as manganes_quimica_20_40',
                'aqp.enxofre_0_20 as enxofre_quimica_0_20',
                'aqp.enxofre_20_40 as enxofre_quimica_20_40',
    
                // Análises Físicas
                'afp.areia_0_20 as areia_fisica_0_20',
                'afp.areia_20_40 as areia_fisica_20_40',
                'afp.argila_0_20 as argila_fisica_0_20',
                'afp.argila_20_40 as argila_fisica_20_40',
                'afp.silte_0_20 as silte_fisica_0_20',
                'afp.silte_20_40 as silte_fisica_20_40',
                'afp.tipo_solo_0_20 as tipo_solo_fisica_0_20',
                'afp.tipo_solo_20_40 as tipo_solo_fisica_20_40',
                'afp.classe_textural_0_20 as classe_textural_fisica_0_20',
                'afp.classe_textural_20_40 as classe_textural_fisica_20_40',
                'afp.ad_predita_0_20 as ad_predita_fisica_0_20',
                'afp.ad_predita_20_40 as ad_predita_fisica_20_40',
                'afp.classe_ad_0_20 as classe_ad_fisica_0_20',
                'afp.classe_ad_20_40 as classe_ad_fisica_20_40',
                'afp.ad2_0_20 as ad2_fisica_0_20',
                'afp.ad2_20_40 as ad2_fisica_20_40'
            )
            ->orderBy('r.description')
            ->orderBy('m.Município')
            ->orderBy('p.produtor_nome')
            ->orderBy('aqp.data_analise')
            ->get()
            ->groupBy('regiao_nome');
    
        Log::info('----------------------------------------------------------------------------');
        Log::info('1 - Dados agrupados por região', ['regioes' => $regioes]);
        Log::info('----------------------------------------------------------------------------');
    
        return $regioes;
    }


    public function solo()
    {
        // Carregar os dados da consulta
        $regioes = $this->loadSoloData();
        Log::info('----------------------------------------------------------------------------');
        log::info('2 - Dados das regi%C3%B5es carregados:', ['regioes' => $regioes]);
        Log::info('----------------------------------------------------------------------------');
        // Validação simples para garantir que os dados estão sendo carregados
        if (empty($regioes)) {
            Log::warning('Nenhum dado encontrado para as regiões.');
        }
    
        // Passar os dados para a view
        return view('site.solo', compact('regioes'));
    }
    
    
}
