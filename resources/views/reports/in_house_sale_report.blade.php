@extends('layouts.app')

@section('content')

    <div class="pad-all text-center">
        <form class="" action="{{ route('in_house_sale_report.index') }}" method="GET">
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
    <div style="margin-left: 62.5%; margin-bottom: 1%;">
        <a href="{{route('delivered.order')}}" class="btn btn-purple">Delivered</a>
        <a href="{{route('non_delivered.driver')}}" class="btn btn-purple">Non-Delivered</a>
    </div>

    <div class="col-md-offset-2 col-md-8">
        <div class="panel">
            <!--Panel heading-->
            <div class="panel-heading">
                <h3 class="panel-title">Product wise sale report</h3>
            </div>

            <!--Panel body-->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped mar-no " id="product_list">
                        <thead>

                            <tr>
                                <th>S.No</th>
                                <th>SKU Code</th>
                                <th>DIV Code</th>
                                <th>Product Name</th>
                                <th>UOM</th>
                                <th>Qty Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{ $product->sku_code }}</td>
                                    <td>{{ $product->div_code }}</td>
                                    <td>{{ __($product->name) }}</td>
                                    <td>{{ $product->unit }}</td>
                                    <td>{{ $product->num_of_sale }}</td>
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
            $('#product_list').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'print'
                ]
            } );
        } );
    </script>
@endsection
