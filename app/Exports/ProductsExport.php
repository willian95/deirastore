<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{

    use Exportable;
    /*
        Question $question
    */
    private $i = 1;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with('brand')->skip(15000)->take(10000)->get();
    }

    public function map($product): array
    {
        // $question 

        return [
            $this->i++,
            $product->brand->name,
            $product->parent_nexsys,
            $product->sku,
            $product->min_description,
        ];
    }


    public function headings(): array
    {
        return [
            '#',
            'Marca',
            'parent',
            'sku',
            'Descripción',
        ];
    }


}
