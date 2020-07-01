@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-7">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('SMS Settings')}}</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ route('env_key_update.update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="SMS_DRIVER">
                        <div class="col-lg-4">
                            <label class="control-label">{{__('SMS DRIVER')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <select class="demo-select2" name="SMS_DRIVER">
                                <option value="twilio" @if (env('SMS_DRIVER') == "twilio") selected @endif>Twilio</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="TWILIO_SID">
                        <div class="col-lg-4">
                            <label class="control-label">{{__('TWILIO SID')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="TWILIO_SID" value="{{  env('TWILIO_SID') }}" placeholder="TWILIO SID">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="TWILIO_TOKEN">
                        <div class="col-lg-4">
                            <label class="control-label">{{__('TWILIO AUTH TOKEN')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="TWILIO_TOKEN" value="{{  env('TWILIO_TOKEN') }}" placeholder="TWILIO AUTH TOKEN">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="types[]" value="TWILIO_FROM">
                        <div class="col-lg-4">
                            <label class="control-label">{{__('TWILIO FROM NO.')}}</label>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" name="TWILIO_FROM" value="{{  env('TWILIO_FROM') }}" placeholder="TWILIO FROM NO." required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-12 text-right">
                            <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="panel bg-gray-light">
            <div class="panel-body">
                <h4>{{__('Instruction')}}</h4>
                <p class="text-danger">{{ __('Please be carefull when you are configuring SMS. For incorrect configuration you will get error at the time of order place, new registration, sending newsletter.') }}</p>
                <hr>
                <p>{{ __('Where You Get This Info') }}</p>
                <ul class="list-group">
                    <li class="list-group-item text-dark">From Twilio Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
