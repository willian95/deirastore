<?php

namespace App\Exports;

use App\Payment;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class SalesExport implements FromView, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /*public function collection()
    {
        return Sale::all();
    }*/

    public function forFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
        
        return $this;
    }

    public function forToDate($toDate)
    {
        $this->toDate = $toDate;
        
        return $this;
    }

    public function view(): View
    {
        return view('exports.sales', [
            'sales' => Payment::with('user', 'guest', 'productPurchase', 'productPurchase.product', "user.location", "user.commune", "guest.location", "guest.commune")->has('productPurchase')->has("user")->whereDate('created_at', '>=', $this->fromDate)->whereDate("created_at", '<=', $this->toDate)->get()
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'D' => "0",
            'F' => "0",
            'G' => "0",
            'H' =>  "0",
        ];
        
    }

}
