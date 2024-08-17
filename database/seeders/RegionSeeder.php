<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            ['description' => 'R1 - Panambi, Palmeira das Missões, Pejuçara, Bozano', 'status' => true],
            ['description' => 'R2 - Santo Augusto, Nova Ramada, Coronel Bicaco', 'status' => true],
            ['description' => 'R3 - São Valério do Sul, Chiapetta, Catuípe, Giruá', 'status' => true],
            ['description' => 'R4 - Santo Ângelo, Eugênio de Castro, Augusto Pestana, São Miguel das Missões', 'status' => true],
            ['description' => 'R5 - Rolador, São Luiz Gonzaga, Bossoroca', 'status' => true],
            ['description' => 'R6 - Santo Antonio das Missões, Dezessei de Novembro, Pirapó, São Nicolau, Garruchos, São Borja', 'status' => true],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
