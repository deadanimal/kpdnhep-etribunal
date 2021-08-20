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
            <span>{{ __('new.report2') }}</span><br>
        </div>
        <div class="">
            @include('report.report2v2.table')
        </div>
    </div>
@stop