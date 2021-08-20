@extends('layouts.print')
@section('content')
    <style>
        td, th {
            font-size: 8px;
        }
    </style>
    <div class="row">
        <div id='title'
            style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
            <span>{{ __('new.tribunal')}}</span><br>
            <span>{{ __('new.report33') }}</span><br>
            <span>{{ $param['date_start'] }} - {{ $param['date_end'] }}</span><br>
        </div>
        <div class="">
            @include('report.report33.table')
        </div>
    </div>
@stop