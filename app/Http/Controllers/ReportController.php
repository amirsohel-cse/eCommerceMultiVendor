<?php

namespace App\Http\Controllers;

use App\Imports\InventoryImport;
use Illuminate\Http\Request;
use App\Product;
use App\Seller;
use App\User;
use App\Exports\InventoryProduct;
use Maatwebsite\Excel\Facades\Excel;
use File;
class ReportController extends Controller
{
    public function stock_report(Request $request)
    {
        if($request->has('category_id')){
            $products = Product::where('category_id', $request->category_id)->get();
        }
        else{
            $products = Product::all();
        }
        return view('reports.stock_report', compact('products'));
    }

    public function in_house_sale_report(Request $request)
    {
        if($request->has('category_id')){
            $products = Product::where('category_id', $request->category_id)->orderBy('num_of_sale', 'desc')->get();
        }
        else{
            $products = Product::orderBy('num_of_sale', 'desc')->get();
        }
        return view('reports.in_house_sale_report', compact('products'));
    }

    public function seller_report(Request $request)
    {
        if($request->has('verification_status')){
            $sellers = Seller::where('verification_status', $request->verification_status)->get();
        }
        else{
            $sellers = Seller::all();
        }
        return view('reports.seller_report', compact('sellers'));
    }

    public function seller_sale_report(Request $request)
    {
        if($request->has('verification_status')){
            $sellers = Seller::where('verification_status', $request->verification_status)->get();
        }
        else{
            $sellers = Seller::all();
        }
        return view('reports.seller_sale_report', compact('sellers'));
    }

    public function wish_report(Request $request)
    {
        if($request->has('category_id')){
            $products = Product::where('category_id', $request->category_id)->get();
        }
        else{
            $products = Product::all();
        }
        return view('reports.wish_report', compact('products'));
    }

//    public function export()
//    {
//        return Excel::download(new InventoryProduct(), 'inventoryProducts.xlsx');
//    }

    public function import()
    {
        Excel::import(new InventoryImport, request()->file('file'));

        // call App/Imports/InventoryImports

        return redirect()->back()->with('success', "Table Updated Successfully!");
    }

}
