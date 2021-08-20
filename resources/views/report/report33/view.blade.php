<?php
use Carbon\Carbon;
$locale = App::getLocale();
$month_lang = 'month_'.$locale;
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

<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">

        <div class="portlet light bordered form-fit">
            <div class="portlet-body" style="margin: 20px;">
                <div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}} <br>
{{ __('new.report32') }}
@if ( $month ){{ __('new.month') .' '.$month->$month_lang }}@endif {{ __('new.year') .' '.$year }}<br>
( {{ __('new.until') .' '.date('d/m/Y') }} )<br></div>

                <table class="table table-bordered table-hover data">
                    <thead>
                        <tr>
                            <th width="3%" rowspan="2"> {{ __('new.no') }} </th>
                            <th rowspan="2"> {{ __('new.state') }}  </th>
                            <th rowspan="2"> {{ __('new.register') }} </th>
                            <th colspan="4"> {{ __('new.award') }} </th>
                            <th rowspan="2"> {!! __('new.total_finish_with_award') !!}  </th>
                        </tr>
                        <tr>
                            <th> 5 </th>
                            <th> 7 </th>
                            <th> 8 </th>
                            <th> 10 </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $states as $index => $state )
                        <?php
                            $case_state =(clone $cases)->get()->where('state_id', $state->state_id);
                            $award = (clone $cases)->get()->where('state_id', $state->state_id);

                            $award_state = (clone $award)->filter(function ($value) {
                                if( count($value->form4) > 0 )
                                    if ($value->form4->last()->award)
                                        if($value->form4->last()->award_id != 6 && $value->form4->last()->award_id != 9 )
                                        return $value->form4;
                           });

                            $award_amount = (clone $cases)->get()->filter(function ($value) {
                                if( count($value->form4) > 0 )
                                    if ($value->form4->last()->award)
                                        return $value->form4;
                           });

                            $award5_state = (clone $award)->where('award_type', 5);
                            $award7_state = (clone $award)->where('award_type', 7);
                            $award8_state = (clone $award)->where('award_type', 8);
                            $award10_state = (clone $award)->where('award_type', 10);

                            $award5 = (clone $cases)->get()->where('award_type', 5);
                            $award7 = (clone $cases)->get()->where('award_type', 7);
                            $award8 = (clone $cases)->get()->where('award_type', 8);
                            $award10 = (clone $cases)->get()->where('award_type', 10);

                        ?>
                        <tr>
                            <td> {{$index+1}} </td>
                            <td style="text-align: left; text-transform: uppercase;"> {{ $state->state }}</td>
                            <td> {{ count($case_state) }} </td>
                            <td> {{ count($award5_state) }} </td>
                            <td> {{ count($award7_state) }} </td>
                            <td> {{ count($award8_state) }} </td>
                            <td> {{ count($award10_state) }} </td>
                            <td> {{ count($award_state) }} </td>
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">{{__('new.total')}} ({{__('new.percentage')}})</td>
                            <td> {{ count($cases->get()) }} (100%) </td>
                            <td> {{ count($award5) }} (@if( count($award_amount) > 0 ) {{ (number_format(count($award5)/count($award_amount)*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                            <td> {{ count($award7) }} (@if( count($award_amount) > 0 ) {{ (number_format(count($award7)/count($award_amount)*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                            <td> {{ count($award8) }} (@if( count($award_amount) > 0 ) {{ (number_format(count($award8)/count($award_amount)*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                            <td> {{ count($award10) }} (@if( count($award_amount) > 0 ) {{ (number_format(count($award10)/count($award_amount)*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                            <td> {{ count($award_amount) }} (@if( count($cases->get()) > 0 ) {{ (number_format(count($award_amount)/count($cases->get())*100, 2,'.','')) }} % @else 0.00 % @endif)</td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
<div class="row hide-print">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">
        <a type="button" class="btn default" href='{{ route("report.list", ["page" => 4]) }}'>
            <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
        </a>
        <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i class="fa fa-print mr10"></i>{{ trans('button.print') }}</button>
        <button type="button" class="btn purple btn-outline" onclick="exportTo('excel')"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
    </div>
</div>
@endsection

@section('after_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->

<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script>

function exportPDF() {
        location.href = "{{ url('') }}/report/report32/export/pdf?{!! http_build_query(request()->input()) !!}";
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