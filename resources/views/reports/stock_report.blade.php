@extends('layouts.app')

@section('content')

    <div class="pad-all text-center">
        <form class="" action="{{ route('stock_report.index') }}" method="GET">
            <div class="box-inline mar-btm pad-rgt">
                 Sort by Category:
                 <div class="select">
                     <select id="demo-ease" class="demo-select2" name="category_id" required>
                         @foreach (\App\Category::all() as $key => $category)
                             <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                         @endforeach
                     </select>
                 </div>
            </div>
            <button class="btn btn-default" type="submit">Filter</button>
        </form>
    </div>
  @if(Session::has('success'))
    <div class="alert alert-success">
        <strong>Success!</strong> {{Session::get('success')}}
    </div>
@endif
    <div class="row">
        <div class=" col-md-offset-2 col-md-8">
            <div class="panel">
                <div class="panel-body bg-primary" style="padding:20px; margin-bottom: 30px;">
                    <div class="text-center">
                        <label for="" style="background: red; padding: 5px;"> <strong style="color: white;">** NTOTE  ** </strong> * Your Excel File Must be like this. * Please Don't Change the S_Id. * Must be in one sheet on you Excel. *Otherwise your data will be lost.</label>
                        <img style="width:100%" src="{{ asset('img/demxl.PNG') }}" alt="">
                    </div>

                    <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data" style="border: 1px solid #fff;margin-top: 15px;padding: 15px;">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-10" style="">
                                <div class="form-group">
                                    <label for="file">Choose Formatted Excel File to Update Information</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2" style="margin-top: 25px">
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>

    <div class="col-md-offset-1 col-md-10">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">Product wise Inventory Report</h3>

            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no " id="inventory_product_list">
                        <thead>
                            <tr>
                                <th>S_Id</th>
                                <th>SKU_Code</th>
                                <th>DIV_Code</th>
                                <th>Product_Name</th>
                                <th>PCs_Qty</th>
                                <th>PCs-Cost</th>
                                <th>Case_Qty</th>
                                <th>Case_Cost</th>
                                <th>Discount</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                @php
                                    $qty = 0;
                                    foreach (json_decode($product->variations) as $key => $variation) {
                                        $qty += $variation->qty;
                                    }
                                @endphp
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{ $product->sku_code }}</td>
                                    <td>{{ $product->div_code }}</td>
                                    <td>{{ $product->name }}</td>
                                    @if(json_decode($product->variations))
                                        @foreach (json_decode($product->variations) as $key => $variation)
                                        <td>{{ $variation->qty}}</td>
                                        <td>{{ $variation->price }}</td>
                                        @endforeach
                                        @else
                                        <td>{{ 0}}</td>
                                        <td>{{ 0 }}</td>
                                        <td>{{ 0}}</td>
                                        <td>{{ 0 }}</td>
                                    @endif
                                    <td>{{ $product->discount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#inventory_product_list').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    {
                        extend: 'excelHtml5',
                        title: "inventory"
                    }
                ]
            } );
        } );
    </script>
@endsection
