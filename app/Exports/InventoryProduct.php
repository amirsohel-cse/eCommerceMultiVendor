<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use function Matrix\inverse;

class InventoryProduct implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
//        $inventory = new Product();
//        $inventory->

        return Product::all();
    }
}
