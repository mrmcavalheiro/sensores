<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RegionDailyAverage extends Model
{
    protected $table = 'region_daily_averages';  // Especifica o nome da tabela

    protected $fillable = [
        'region_id', 
        'device_id', 
        'date_BR', 
        'avg_soil_vwc_s1', 
        'avg_soil_vwc_s2', 
        'created_at'
    ];

    public $timestamps = false;  // Desabilita timestamps automáticos
}