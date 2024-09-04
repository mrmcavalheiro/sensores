<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function updateChart(Request $request)
    {
        Log::info('Requisição recebida para updateChart', $request->all());

        $regionId = $request->input('region_id');
        $period = $request->input('period');

        // Calcular a data inicial com base no período selecionado
        $startDate = Carbon::now();
        switch ($period) {
            case '1 semana':
                $startDate = $startDate->subWeek();
                break;
            case '2 semanas':
                $startDate = $startDate->subWeeks(2);
                break;
            case '3 semanas':
                $startDate = $startDate->subWeeks(3);
                break;
            case '1 mês':
                $startDate = $startDate->subMonth();
                break;
            case '2 meses':
                $startDate = $startDate->subMonth(2);
                break;    
            case '3 meses':
                $startDate = $startDate->subMonths(3);
                break;
            case '6 meses':
                $startDate = $startDate->subMonths(6);
                break;
            case '1 ano':
                $startDate = $startDate->subYear();
                break;
            case '3 meses':
                $startDate = $startDate->subMonths(3);
                break;
            case '4 meses':
                $startDate = $startDate->subMonths(4);
                break;
            case '5 meses':
                $startDate = $startDate->subMonths(5);
                break;
            case '6 meses':
                $startDate = $startDate->subMonths(6);
                break;
        }

        // Formatando $startDate para conter apenas a data
        $startDate = $startDate->format('Y-m-d');

        Log::info('Start date calculado', ['startDate' => $startDate]);

        // Construir a consulta
        Log::info('Start date calculado', ['startDate' => $startDate]);

        // Construir a consulta
        /*
        $query = DB::table('region_daily_averages')
            ->where('region_id', $regionId)
            ->whereDate('date_BR', '>=', $startDate)
            ->select(DB::raw("DATE_FORMAT(date_BR, '%d/%m/%Y') as date_BR"), DB::raw('AVG(avg_soil_vwc_s1) as avg_soil_vwc_s1'), DB::raw('AVG(avg_soil_vwc_s2) as avg_soil_vwc_s2'))
            ->groupBy(DB::raw("DATE_FORMAT(date_BR, '%d/%m/%Y')"))
            ->orderBy('date_BR');
*/
        // Construir a consulta
        $query = DB::table('region_daily_averages')
            ->where('region_id', $regionId)
            ->whereDate('date_BR', '>=', $startDate)
            ->select('date_BR', DB::raw('AVG(avg_soil_vwc_s1) as avg_soil_vwc_s1'), DB::raw('AVG(avg_soil_vwc_s2) as avg_soil_vwc_s2'))
            ->groupBy('date_BR')
            ->orderBy('date_BR');



        log::info('Consulta SQL construída', ['query' => $query]);  

        // Executar a consulta
        $chartData = $query->get();

        Log::info('Dados retornados do banco de dados', ['chartData' => $chartData]);

        // Preparar os dados para o gráfico
        $labels = $chartData->pluck('date_BR')->toArray();
        $dataS1 = $chartData->pluck('avg_soil_vwc_s1')->toArray();
        $dataS2 = $chartData->pluck('avg_soil_vwc_s2')->toArray();

        return response()->json([
            'chartData' => [
                'mainChartData' => [
                    'labels' => $labels,
                    'dataS1' => $dataS1,
                    'dataS2' => $dataS2,
                ]
            ]
        ]);
    }
}

// Função para substituir bindings na consulta SQL
if (!function_exists('replaceBindings')) {
    function replaceBindings($sql, $bindings) {
        foreach ($bindings as $binding) {
            $value = is_numeric($binding) ? $binding : "'{$binding}'";
            $sql = preg_replace('/\?/', $value, $sql, 1);
        }
        return $sql;
    }
}
?>
