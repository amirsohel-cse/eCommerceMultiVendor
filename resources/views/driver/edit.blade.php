@extends('layouts.app')

@section('content')

<div class="col-lg-6 col-lg-offset-3">
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Edit Driver Information</h3>
        </div>

        <!--Horizontal Form-->
        <!--===================================================-->
        <form class="form-horizontal" action="{{ route('driver.driver_update', $driver->id) }}" method="POST" enctype="multipart/form-data">
        	@csrf
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-sm-12">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">{{__('Name')}}</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="{{__('Name')}}" id="name" name="name" value="{{ $driver->name }}" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="password">{{__('Password')}}</label>
                    <div class="col-sm-9">
                        <input type="password" placeholder="{{__('Password')}}" id="password" name="password" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="plate_no">Car Plate No</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Car Plate No" id="plate_no" name="plate_no" value="{{ $driver->plate_no }}"class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="city">City</label>
                    <div class="col-sm-9">
                        <select class="form-control selectpicker" data-live-search="true" name="city">
                                @foreach (\App\Country::all() as $key => $country)
                                    <option value="{{ $country->code }}" <?php if( $driver->city == $country->code) echo "selected";?> >{{ $country->name }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="area">Area</label>
                    <div class="col-sm-9">
                        <input type="text" placeholder="Area" id="area" name="area" class="form-control" value="{{ $driver->area }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="name">Status</label>
                    <div class="col-sm-9">
                        <select name="status" required class="form-control demo-select2-placeholder">
                            @if($driver->status==1)
                                <option value="1" selected>Active</option>
                                <option value="0">Disable</option>
                            @else
                                <option value="0" selected>Disable</option>
                                <option value="1">Active</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-footer text-right">
                <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
            </div>
        </form>
        <!--===================================================-->
        <!--End Horizontal Form-->

    </div>
</div>

@endsection
