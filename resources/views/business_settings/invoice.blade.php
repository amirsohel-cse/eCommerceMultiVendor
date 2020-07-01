@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Invoices Settings')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('invoice.save') }}" method ="POST">
                @csrf
                <input type="hidden" name="_method" value="PATCH">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">{{__('Invoice Name English')}}</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name_english" value="{{$invoices->name_english}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">{{__('Invoice Name Arabic')}}</label>
                        <div class="col-sm-9">
                            <input type="text" id="address" name="name_arabic" value="{{$invoices->name_arabic}}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="vat">{{__('Vat Number')}}</label>
                        <div class="col-sm-9">
                            <input type="text" id="address" name="vat" value="{{$invoices->vat_no}}" class="form-control" required>
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
