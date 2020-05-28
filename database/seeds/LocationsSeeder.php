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
        $location->id = 1;
        $location->name = "Valparaiso";
        $location->save();

        $location = new Location;
        $location->id = 2;
        $location->name = "Ranzagua";
        $location->save();

        $location = new Location;
        $location->id = 3;
        $location->name = "Curico";
        $location->save();

        $location = new Location;
        $location->id = 4;
        $location->name = "Talca";
        $location->save();

        $location = new Location;
        $location->id = 5;
        $location->name = "La Serena";
        $location->save();

        $location = new Location;
        $location->id = 6;
        $location->name = "Chillan";
        $location->save();

        $location = new Location;
        $location->id = 7;
        $location->name = "Concepción";
        $location->save();

        $location = new Location;
        $location->id = 8;
        $location->name = "Los Angeles";
        $location->save();

        $location = new Location;
        $location->id = 9;
        $location->name = "Temuco";
        $location->save();

        $location = new Location;
        $location->id = 10;
        $location->name = "Copiapo";
        $location->save();

        $location = new Location;
        $location->id = 11;
        $location->name = "Valdivia";
        $location->save();

        $location = new Location;
        $location->id = 12;
        $location->name = "Osorno";
        $location->save();

        $location = new Location;
        $location->id = 13;
        $location->name = "Puerto Montt";
        $location->save();

        $location = new Location;
        $location->id = 14;
        $location->name = "Antofagasta";
        $location->save();

        $location = new Location;
        $location->id = 15;
        $location->name = "Calama";
        $location->save();

        $location = new Location;
        $location->id = 16;
        $location->name = "Iquique";
        $location->save();

        $location = new Location;
        $location->id = 17;
        $location->name = "Arica";
        $location->save();

        $location = new Location;
        $location->id = 18;
        $location->name = "Coyhaique";
        $location->save();

        $location = new Location;
        $location->id = 19;
        $location->name = "Punta Arenas";
        $location->save();

    }
}
