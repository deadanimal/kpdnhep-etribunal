<?php
$locale = App::getLocale();
$month_lang = "month_" . $locale;
$commision = '0.53';
$totalcommision = '0.00';
$total = $payments->sum('amount') - $commision;
?>


@extends('layouts.app')

@section('after_styles')

    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .data th, td {
            text-align: center;
            text-transform: uppercase;
            font-size: smaller !important;
        }

        .data th {
            vertical-align: middle !important;
            background-color: #428bca !important;
            color: #ffffff;
        }

        tfoot {
            vertical-align: middle !important;
            background-color: #428bca;
            color: #ffffff;
        }

    </style>
@endsection

@section('content')
    <!-- #start -->

    <!-- BEGIN PAGE TITLE-->


    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ __('new.report24') }}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="hide-print" style="margin-bottom: 20px;">
                    <form method='get' action=''>
                        <div id="search-form" class="form-inline">
                            <div class="form-group mb10">
                                <label for="date">{{ trans('new.date') }} </label>
                                <div class="input-group input-large date-picker input-daterange"
                                     data-date-format="dd/mm/yyyy">
                                    <input type="text" class="form-control" name="start_date" id="start_date"
                                           @if(Request::has('start_date')) value='{{ Request::get("start_date") }}' @endif
                                    ">
                                    <span class="input-group-addon"> {{ __('new.to') }} </span>
                                    <input type="text" class="form-control" name="end_date" id="end_date" }
                                           @if(Request::has('end_date')) value='{{ Request::get("end_date") }}' @endif">
                                </div>
                            </div>
                            <div class="form-group mb10">
                                <label for="month" class="control-label col-md-4">{{ trans('new.state')}} :
                                    <span> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-5">
                                    <select id="state_id" class="form-control select2 bs-select" name="state_id"
                                            style="margin-right: 10px;"
                                            placeholder="-- {{ __('new.all_state') }} --">
                                        <option value="" selected>-- {{ __('new.all_state') }} --</option>
                                        @foreach($state_list as $id => $state)
                                            <option @if(Request::get('state_id') == $id ) selected
                                                    @endif value="{{ $id }}">{{ $state }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            &emsp;
                            <div class="form-group mb10">
                                <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                            </div>
                        </div>
                </div>
                <div class="portlet-body">
                    <div id='title'
                         style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}
                        <br>
                        {{ __('new.bussiness_report') }} <br>
                        {{ __('new.fee_paid_online')}} {{ __('new.from_date') .' '.$start_date.' '. __('new.until') .' '.$end_date }}
                    </div>

                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover data">
                            <thead>
                            <tr>
                                <th> No</th>
                                <th> {{ __('new.time_paid') }} </th>
                                <th> {{ __('new.receipt_no') }} </th>
                                <th> {{ __('new.transaction_no') }} </th>
                                <th> {{ __('new.ref_no') }} </th>
                                <th> {{ __('new.claim_no') }} </th>
                                <th> {{ __('new.form_type') }} </th>
                                <th> {{ __('new.paid_by') }} </th>
                                <th> {{ __('new.payee_bank') }} </th>
                                <th> {{ __('new.total_gross') }} </th>
                                <th> {{ __('new.commission') }} </th>
                                <th> {{ __('new.total_net') }} </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $i=>$fpx)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <?php
                                    if (date($fpx->paid_at) < '2018-06-01') {
                                        $commision = '0.53';
                                    } else {
                                        $commision = '0.50';
                                    }
                                    $totalcommision = $totalcommision + $commision;
                                    ?>
                                    <td>{{ $fpx->paid_at ? date('d/m/Y h:i A', strtotime($fpx->paid_at)) : '-' }}</td>
                                    <td>
                                        <a target='_blank'
                                           href="{{ route('integration-fpx-details', $fpx->payment_id )}}">{{ $fpx->payment->receipt_no ? $fpx->payment->receipt_no : '-' }}</a>
                                    </td>
                                    <td>{{ $fpx->fpx_transaction_no ? $fpx->fpx_transaction_no : '-' }}</td>
                                    <td>{{ $fpx->payment->case ? $fpx->payment->case->form1_no : '-' }}</td>
                                    <td>
                                        @if ($fpx->payment->case)
                                            <a href=" {{ route('claimcase-view', $fpx->payment->claim_case_id ) }}"> {{ strpos($fpx->payment->case->case_no, 'TTPM-') !== false ? $fpx->payment->case->case_no : __('new.unprocessed') }} </a>
                                        @else -
                                        @endif
                                    </td>
                                    <td>{{ $fpx->payment->case ? 'B'.$fpx->payment->form_no : '-' }}</td>
                                    <td>{{ $fpx->paid_by }}</td>
                                    <td>{{ $fpx->bank ? $fpx->bank->name : '' }}</td>
                                    <td>{{ $fpx->paid_amount ? $fpx->paid_amount : '-'}}</td>
                                    <td>{{ $commision }}</td>
                                    <td>{{ (number_format($fpx->paid_amount - $commision,2,'.',',')) }}</td>
                                </tr>
                            @endforeach
                            @if ( count($payments) == 0 )
                                <tr>
                                    <td colspan="12"> {{ __('new.no_record') }}</td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>

                            <tr>
                                <td colspan="9" class="bold" style="text-align-right">{{ __('new.total') }}</td>
                                <td>RM {{ number_format($payments->sum('paid_amount'),2,'.',',') }}</td>
                                <td>RM {{ number_format($totalcommision,2,'.',',') }}</td>
                                <td>
                                    RM {{ number_format($payments->sum('paid_amount') - $totalcommision,2,'.',',') }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row hide-print">
        <div class="col-md-12" style="text-align: center; line-height: 80px;">
            <a type="button" class="btn default" href='{{ route("report.list", ["page" => 3]) }}'>
                <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
            </a>
            <button type="button" class="btn purple btn-outline" onclick="exportExcel()"><i
                        class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
        </div>
    </div>
@endsection

@section('after_scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>

      // function exportPDF() {
      //     location.href = "{{ url('') }}/report/report24/export/pdf?{!! http_build_query(request()->input()) !!}";
      // }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report24/export/excel?{!! http_build_query(request()->input()) !!}"
      }

    </script>
@endsection