<?php

namespace App\Imports;
Use Illuminate\Database\Eloquent;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Eloquent\Model;
class InventoryImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection  $rows)
    {
        // dd($rows);
         $i=0;
        foreach ($rows as $row) {
            if($i==0) { $i++; continue;}
            $store = Product::find($row[0]);
            $store->name =$row[3];
            $store->sku_code =$row[1];
            $store->div_code =$row[2];
            $store->discount =$row[8];

            if(json_decode($store->choice_options))
            $choice_options_pcs=json_decode($store->choice_options)[0]->options[0];

            if(json_decode($store->choice_options))
            $choice_options_case=json_decode($store->choice_options)[0]->options[1];

         //   dd($choice_options_case);
            $item = array();
            $item[$choice_options_pcs]['qty'] = $row[4];
            $item[$choice_options_pcs]['sku'] = $row[1];
            $item[$choice_options_pcs]['price'] = $row[5];
            $item[$choice_options_case]['price'] = $row[7];
            $item[$choice_options_case]['sku'] = $row[1];
            $item[$choice_options_case]['qty'] =  $row[6];

            $store->variations = json_encode($item);
            $store->save();


        }
    }
}
