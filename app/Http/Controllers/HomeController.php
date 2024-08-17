<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $regions = Region::where('status', true)->get();
        $periods = [
            '1 semana', '2 semanas', '3 semanas', '1 mês', '2 meses', '3 meses', '6 meses', '1 ano'
        ];

        return view('site.home', compact('regions', 'periods'));
    }

    public  static  function getMenuGraficos()
    {
        $regions = Region::where('status', true)->get();
        $periods = [
            '1 semana', '2 semanas', '3 semanas', '1 mês', '2 meses', '3 meses', '6 meses', '1 ano'
        ];

        return response()->json([
            'regions' => $regions,
            'periods' => $periods
        ]);
    }
}
