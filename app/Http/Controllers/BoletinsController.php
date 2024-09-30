<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BoletinsController extends Controller
{
    public function index()
    {
        // Caminho para o arquivo XML
        $xmlPath = public_path('xml/boletins.xml');

        // Carregar o XML usando SimpleXMLElement
        $boletinsXml = simplexml_load_file($xmlPath);

        // Converter o XML para um array associativo
        $boletinsArray = [
            'tituloPagina' => (string)$boletinsXml->pagina->tituloPagina,
            'explicacaoTitulo' => (string)$boletinsXml->pagina->explicacaoTitulo,
            'explicacao' => (string)$boletinsXml->pagina->explicacao,
            'boletins' => []
        ];

        foreach ($boletinsXml->pagina->boletins->boletim as $boletim) {
            $boletinsArray['boletins'][] = [
                'nome' => (string) $boletim->nome,
                'file' => (string) $boletim->file,
            ];
        }

        // Retornar a view correta
        return view('site.boletins', ['boletins' => $boletinsArray]);

    }
}
