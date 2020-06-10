<?php

namespace App\Imports;

use App\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CategoriesWeightImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        try{
            $index = 0;
            foreach ($rows as $row) 
            {

                if($row[0] != null){
                    Category::where("name", $row[0])->update(["esp_name" => $row[2]]);
                    Category::where("name", $row[1])->update(["esp_name" => $row[3], "length" => $row[4], "width" => $row[5], "height" => $row[6], "weight" => $row[7], "weight_unit" => $row[9], "dimenssions_unit" => $row[8]]);
                }
                

            }

        }catch(\Exception $e){
            dd($e->getMessage(), $e->getLine());
        }
    }
}
