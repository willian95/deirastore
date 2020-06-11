<?php

use Illuminate\Database\Seeder;
use App\Shipping;

class ShippingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //Iquique

        $shipping = new Shipping;
        $shipping->location_id = 1;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 4376;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 1;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 4675;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 1;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 4977;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 1;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 5449;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 1;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 419;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 1;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 351;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 1;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 346;
        $shipping->save();

        //Antofagasta

        $shipping = new Shipping;
        $shipping->location_id = 2;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 4167;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 2;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 4452;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 2;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 4740;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 2;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 5199;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 2;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 379;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 2;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 307;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 2;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 275;
        $shipping->save();

        //Copiapó

        $shipping = new Shipping;
        $shipping->location_id = 3;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 3730;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 3;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 3985;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 3;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 4243;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 3;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 4653;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 3;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 349;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 3;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 274;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 3;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 244;
        $shipping->save();

        //Coquimbo

        $shipping = new Shipping;
        $shipping->location_id = 4;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 3276;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 4;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 3501;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 4;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 3727;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 4;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 4087;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 4;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 314;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 4;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 235;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 4;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 224;
        $shipping->save();

        //Valparaiso

        $shipping = new Shipping;
        $shipping->location_id = 5;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 2938;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 5;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 3138;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 5;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 3341;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 5;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 3664;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 5;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 302;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 5;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 193;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 5;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 145;
        $shipping->save();

        //Rancagua

        $shipping = new Shipping;
        $shipping->location_id = 6;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 2938;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 6;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 3138;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 6;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 3341;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 6;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 3664;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 6;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 302;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 6;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 193;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 6;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 145;
        $shipping->save();

        //Talca

        $shipping = new Shipping;
        $shipping->location_id = 7;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 3022;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 7;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 3229;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 7;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 3428;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 7;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 3770;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 7;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 314;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 7;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 220;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 7;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 196;
        $shipping->save();

        //La Concepción

        $shipping = new Shipping;
        $shipping->location_id = 8;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 3276;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 8;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 3501;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 8;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 3727;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 8;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 4087;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 8;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 314;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 8;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 235;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 8;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 224;
        $shipping->save();

        //Temuco

        $shipping = new Shipping;
        $shipping->location_id = 9;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 3382;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 9;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 3613;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 9;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 3847;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 9;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 4219;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 9;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 327;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 9;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 242;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 9;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 215;
        $shipping->save();

        //Puerto Montt

        $shipping = new Shipping;
        $shipping->location_id = 10;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 3918;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 10;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 4186;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 10;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 4456;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 10;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 4887;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 10;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 379;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 10;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 307;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 10;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 275;
        $shipping->save();

        //Coyhaique

        $shipping = new Shipping;
        $shipping->location_id = 11;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 4912;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 11;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 5249;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 11;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 5587;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 11;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 6128;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 11;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 452;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 11;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 428;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 11;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 393;
        $shipping->save();

        //Punta Arenas

        $shipping = new Shipping;
        $shipping->location_id = 12;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 6424;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 12;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 6863;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 12;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 7306;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 12;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 8013;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 12;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 623;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 12;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 551;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 12;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 520;
        $shipping->save();

        //Santiago

        $shipping = new Shipping;
        $shipping->location_id = 13;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 0;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 13;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 0;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 13;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 0;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 13;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 0;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 123;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 0;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 13;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 0;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 13;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 0;
        $shipping->save();

        //Valdivia

        $shipping = new Shipping;
        $shipping->location_id = 14;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 3730;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 14;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 3985;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 14;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 4243;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 14;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 4653;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 14;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 349;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 14;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 274;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 14;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 244;
        $shipping->save();

        //Arica

        $shipping = new Shipping;
        $shipping->location_id = 15;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 4912;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 15;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 5249;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 15;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 5587;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 15;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 6128;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 15;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 452;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 15;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 428;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 15;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 393;
        $shipping->save();
        

        //La Chillán

        $shipping = new Shipping;
        $shipping->location_id = 16;
        $shipping->min_weight = 0;
        $shipping->max_weight = 3;
        $shipping->price = 3276;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 16;
        $shipping->min_weight = 3.1;
        $shipping->max_weight = 6;
        $shipping->price = 3501;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 16;
        $shipping->min_weight = 6.1;
        $shipping->max_weight = 10;
        $shipping->price = 3727;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 16;
        $shipping->min_weight = 10.1;
        $shipping->max_weight = 16;
        $shipping->price = 4087;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 16;
        $shipping->min_weight = 16.1;
        $shipping->max_weight = 100;
        $shipping->price = 314;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 16;
        $shipping->min_weight = 101;
        $shipping->max_weight = 200;
        $shipping->price = 235;
        $shipping->save();

        $shipping = new Shipping;
        $shipping->location_id = 16;
        $shipping->min_weight = 201;
        $shipping->max_weight = 0;
        $shipping->price = 224;
        $shipping->save();
    

    }
}
