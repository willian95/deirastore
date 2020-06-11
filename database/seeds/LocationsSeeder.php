<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $location = new Location;
        $location->id = 2;
        $location->name = "Iquique";
        $location->save();

        $location = new Location;
        $location->id = 3;
        $location->name = "Antofagasta";
        $location->save();

        $location = new Location;
        $location->id = 4;
        $location->name = "Copiapó";
        $location->save();

        $location = new Location;
        $location->id = 5;
        $location->name = "Coquimbo";
        $location->save();

        $location = new Location;
        $location->id = 6;
        $location->name = "Valparaíso";
        $location->save();

        $location = new Location;
        $location->id = 8;
        $location->name = "Rancagua";
        $location->save();

        $location = new Location;
        $location->id = 9;
        $location->name = "Talca";
        $location->save();

        $location = new Location;
        $location->id = 11;
        $location->name = "Concepción";
        $location->save();

        $location = new Location;
        $location->id = 12;
        $location->name = "Temuco";
        $location->save();

        $location = new Location;
        $location->id = 14;
        $location->name = "Puerto Montt";
        $location->save();

        $location = new Location;
        $location->id = 15;
        $location->name = "Coyhaique";
        $location->save();

        $location = new Location;
        $location->id = 16;
        $location->name = "Punta Arenas";
        $location->save();

        $location = new Location;
        $location->id = 7;
        $location->name = "Región metropolitana";
        $location->save();

        $location = new Location;
        $location->id = 13;
        $location->name = "Valdivia";
        $location->save();

        $location = new Location;
        $location->id = 1;
        $location->name = "Arica";
        $location->save();

        $location = new Location;
        $location->id = 10;
        $location->name = "Chillán";
        $location->save();

    }
}
