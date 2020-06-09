<?php

use Illuminate\Database\Seeder;
use App\Text;

class TextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $text = new Text;
        $text->id = 1;
        $text->site_location = "Selección de despacho";
        $text->type = "imagen";
        $text->save();
        
        $text = new Text;
        $text->id = 2;
        $text->site_location = "Selección de despacho";
        $text->type = "texto";
        $text->save();

        $text = new Text;
        $text->id = 3;
        $text->site_location = "Tipo de facturación";
        $text->type = "texto";
        $text->save();

    }
}
