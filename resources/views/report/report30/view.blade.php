<?php
$locale = App::getLocale();
$month_lang = "month_".$locale;
?>


@extends('layouts.app')

@section('after_styles')

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
            
            <div class="portlet-body">
                <div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal') }} <br>
{{ __('new.report30') .' '.__('new.on') }} @if( $month ){{ __('new.month') .' '. $month->$month_lang }}@endif {{ __('new.year') .' '. $year }} {{ __('new.at_2').' '.__('new.at_hq') }} <br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></div>

                <table class="table table-bordered table-hover data">
                    <thead>
                        <tr>
                            <th rowspan="2"> {{ __('new.no') }} </th>
                            <th rowspan="2"> {{ __('new.state')}} </th>
                            <th rowspan="2"> {{ __('new.total_filings')}} </th>
                            <th colspan="2"> {{ __('new.filing_method')}} </th>
                        </tr>
                        <tr>
                            <th> {!! __('new.online_counter') !!} </th>
                            <th> {!! __('new.online_not_counter') !!} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $index=>$state)
                        <?php
                            $case_state =(clone $claimcases)->get()->where('state_id', $state->state_id);
                            $online_counter_state = (clone $claimcases)->whereRaw('claim_case.created_by_user_id = claim_case.claimant_user_id')->get()->where('state_id', $state->state_id);
                            $online_notcounter_state = (clone $claimcases)->whereRaw('claim_case.created_by_user_id != claim_case.claimant_user_id')->get()->where('state_id', $state->state_id);

                            $online_counter = (clone $claimcases)->whereRaw('claim_case.created_by_user_id = claim_case.claimant_user_id')->get();
                            $online_notcounter = (clone $claimcases)->whereRaw('claim_case.created_by_user_id != claim_case.claimant_user_id')->get();

                        ?>
                        <tr>
                            <td> {{ $index+1 }} </td>
                            <td style="text-align: left; text-transform: uppercase;">{{ $state->state }}</td>
                            <td> {{ count($case_state) }} </td>
                            <td> {{ count($online_counter_state) }} </td>
                            <td> {{ count($online_notcounter_state) }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"> {{ __('new.total')}}</td>
                            <td> {{ count($claimcases->get()) }}</td>
                            <td> {{ count($online_counter) }} </td>
                            <td> {{ count($online_notcounter) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"> {{ __('new.percentage')}}</td>
                            <td> @if( count($claimcases->get()) != 0 ) 100.00 @else 0.00 @endif %</td>
                            <td> @if( count($claimcases->get()) != 0 ) {{ number_format ( count($online_counter)/count($claimcases->get())*100, 2,'.','') }} @else 0.00 @endif %</td>
                            <td> @if( count($claimcases->get()) != 0 ) {{ number_format ( count($online_notcounter)/count($claimcases->get())*100, 2,'.','') }} @else 0.00 @endif %</td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
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
<!-- BEGIN PAGE LEVEL PLUGINS -->

<!-- END PAGE LEVEL PLUGINS -->

<script>

function exportPDF() {
    location.href = "{{ url('') }}/report/report30/export/pdf?{!! http_build_query(request()->input()) !!}";
}

function exportExcel() {
    location.href = "{{ url('') }}/report/report30/export/excel?{!! http_build_query(request()->input()) !!}";
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