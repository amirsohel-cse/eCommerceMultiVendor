@extends('layouts.app')

@section('content')

    <!-- Basic Data Tables -->
    <!--===================================================-->
    <div class="panel">
        <div class="panel-heading bord-btm clearfix pad-all h-100">
            <h3 class="panel-title pull-left pad-no">Delivered Order</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="delivered_order_list">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Order Code')}}</th>
                    <th>{{__('Customer')}}</th>
                    <th>Customer Phone</th>
                    <th>Driver Name</th>
                    <th>Shipping City</th>
                    <th>Shipping Area</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($delivered_orders as $key => $delivered_order)
                    @php
                        $order = \App\Order::find($delivered_order->order_id);
                    @endphp
                    @if($order != null)
                        <tr>
                            <td>
                                {{ ($key+1)}}
                            </td>
                            <td>
                                {{ ($order->code)}}
                            </td>
                            <td>
                                @if ($order->user_id != null)
                                    {{ $order->user->name }}
                                @else
                                    Guest ({{ $order->guest_id }})
                                @endif
                            </td>
                            <td>
                                @if ($order->user_id != null)
                                    {{ $order->user->phone }}
                                @else
                                    Guest ({{ $order->phone }})
                                @endif
                            </td>
                            @php
                                $order_details = \App\OrderDetail::where('order_id',$order->id)->first();
                                $driver_id = $order_details->driver_id;
                                $driver = \App\Driver::where('id', $driver_id)->first();
                            @endphp
                            <td>{{ $driver['name'] }}</td>
                            <td>
                                {{ json_decode($order->shipping_address)->country }}
                            </td>
                            <td>
                                {{ json_decode($order->shipping_address)->city }}
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection


@section('script')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#delivered_order_list').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                } );
            } );
        </script>
@endsection
