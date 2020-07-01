@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('driver.create')}}" class="btn btn-rounded btn-info pull-right">Add New Driver</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Driver</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%" id="driver_list">
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Phone')}}</th>
                    <th>{{__('Email')}}</th>
                    <th>Plate</th>
                    <th>City</th>
                    <th>Area</th>
                    <th>Status</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $key => $driver)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$driver->name}}</td>
                        <td>{{$driver->phone}}</td>
                        <td>{{$driver->email}}</td>
                        <td>{{$driver->plate_no}}</td>
                        @if(!empty($driver->city))
                        @foreach (\App\Country::all() as $key => $country)
                            @if($country->code==$driver->city)
                                <td>{{ $country->name }}</td>
                            @endif
                        @endforeach
                        @else
                            <td>Not set yet</td>
                        @endif
                        <td>{{$driver->area}}</td>
                        @if($driver->status==1)
                        <td>Active</td>
                        @else
                        <td>Disable</td>
                        @endif
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('driver.edit', encrypt($driver->id))}}">{{__('Edit')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('driver.delete', $driver->id)}}');">{{__('Delete')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection

@section('script')
@endsection
