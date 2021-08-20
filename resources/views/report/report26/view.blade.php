<?php

$locale = App::getLocale();
$month_lang = 'month_'.$locale;
?>

@extends('layouts.app')

@section('after_styles')


@endsection


@section('content')

<style type="text/css">
    .data th,td {
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
    th.vertical {
        white-space: nowrap;
        position:relative;
    }

    th.vertical > span {
         transform: rotate(-90deg);

      
    }
</style>

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-list"></i>
            <span class="caption-subject bold uppercase">{{ trans('new.report26') }} </span>
        </div>
        <div class="tools"> </div>
    </div>
    <div style="margin-bottom: 20px;">
        <form method='get' action=''>
            <div id="search-form" class="form-inline">
                <div class="form-group mb10">
                    <label for="year">{{ trans('hearing.year') }} </label>
                    <select id="year" class="form-control" name="year" style="margin-right: 10px;">
                        @foreach($years as $cyear)
                        <option
                        @if(Request::get('year') == $cyear) selected 
                        @elseif(date('Y') == $cyear) selected 
                        @endif
                        value="{{ $cyear }}">{{ $cyear }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb10">
                    <label for="month">{{ trans('hearing.month') }}</label>
                    <select id="month" class="form-control" name="month" style="margin-right: 10px;">
                        <option value="0" selected disabled hidden>-- {{ __('form1.all_month') }} --</option>
                        <option value="" >-- {{ __('form1.all_month') }} --</option>
                        @foreach($months as $cmonth)
                        <option
                        @if(Request::get('month') == $cmonth->month_id) selected
                        @endif value="{{ $cmonth->month_id }}">{{ $cmonth->$month_lang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb10">
                    <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="portlet-body">
        <div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}} <br>
{{ __('new.report26') }} @if ( $month ){{ __('new.month').' '.$month->$month_lang }}@endif {{ __('new.year') .' '.$year }}<br></div>

        <table class="table table-bordered table-hover data">
            <thead>
                <tr>
                    <th> {{ __('new.branch') }} </th>
                    <th> {{ __('new.total_noncitizen') }} </th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $report26 as $report )
                <tr>
                    <td style="text-align: left; text-transform: uppercase;"> {{ $report->branch }}</td>
                    <td>{{ $report->noncitizen }}</td>
                </tr>
                @endforeach
                @if( count($report26) == 0)
                    <tr>
                        <td colspan="2">{{ __('new.no_record') }}</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td>{{ __('new.total') }}</td>
                    <td>{{ $report26->sum('noncitizen') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12 hide-print" style="text-align: center; line-height: 80px;">
        <a type="button" class="btn default" href='{{ route("report.list", ["page" => 3]) }}'>
            <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
        </a>
        <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i class="fa fa-print mr10"></i>{{ trans('button.print') }}</button>
        <button type="button" class="btn purple btn-outline" onclick="exportExcel()"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
    </div>
</div>

@endsection

@section('after_scripts')


<!--sweetalert -->
<!--end sweetalert -->

<script>
   
function exportPDF() {
    location.href = "{{ url('') }}/report/report26/export/pdf?{!! http_build_query(request()->input()) !!}";
}
function exportExcel() {
    location.href = "{{ url('') }}/report/report26/export/excel?{!! http_build_query(request()->input()) !!}";
}
    
var myDataTables = $('table').DataTable( {
    dom: 'Bfrtip',
    ordering: false,
    processing: false,
    serverSide: false,
    searching: false,
    bInfo : false,
    paging: false,
    buttons: [
        {
            extend: 'excel',
            className: 'btn yellow btn-outline hidden',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: $('#title').html().replace( /<br>/g, " " ),
            text:'<i class="fa fa-file-excel-o margin-right-5"></i> Excel'
        },
        {
            extend: 'pdfHtml5',
            className: 'btn green btn-outline hidden',
            orientation: 'landscape',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: '',
            text:'<i class="fa fa-file-pdf-o margin-right-5"></i> Print As PDF',
            customize: function ( doc ) {
                // Splice the image in after the header, but before the table
                doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 12 ],
                    alignment: 'center',
                    text: $('#title').html().replace( /<br>/g, " " ),
                } );
                // Data URL generated by http://dataurl.net/#dataurlmaker
            }
        },
    ],
    language: {
        "aria": {
            "sortAscending": ": {{ trans('new.sort_asc') }}",
            "sortDescending": ": {{ trans('new.sort_desc') }}"
        },
        "processing": "<span class=\"font-md\">{{ trans('new.process_data') }}</span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
        "emptyTable": "{{ trans('new.empty_table') }}",
        "info": "{{ trans('new.info_data') }}",
        "infoEmpty": "{{ trans('new.no_data_found') }}",
        "infoFiltered": "{{ trans('new.info_filtered') }}",
        "lengthMenu": "{{ trans('new.length_menu') }}",
        "search": "{{ trans('new.search') }}",
        "zeroRecords": "{{ trans('new.zero_record') }}"
    },

} );

function exportTo(buttonSelector){
    $(".buttons-"+buttonSelector).click();
}
</script>

@endsection