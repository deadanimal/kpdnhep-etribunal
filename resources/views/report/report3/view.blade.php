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

<!-- BEGIN PAGE TITLE-->
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">

        <div class="portlet light bordered">

            <div class="portlet-body" style="margin: 20px;">
                <div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                    {{ __('new.tribunal')}}<br>
                    {{ __('new.claim_filing')}}
                    {{ Request::has('date_start') ? Request::get('date_start') : date('d/m/Y') }}
                    {{ __('new.until') }}
                    {{ Request::has('date_end') ? Request::get('date_end') : date('d/m/Y') }}<br>
                </div>

                <table class="table table-bordered table-hover data">
                    <thead>
                        <tr>
                            <th width="3%"> {{ __('new.no') }} </th>
                            <th> {{ __('new.state') }}  </th>
                            <th> {{ __('new.form') }} 1</th>
                            <th> {{ __('new.form') }} 2</th>
                            <th> {{ __('new.form') }} 3</th>
                            <th> {{ __('new.form') }} 12</th>                                 
                            <th> {{ __('new.filing_year') }} {{ $year }}</th>
                            <th> % </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $states as $index => $state )
                            @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                        <?php
                            $form1_state = (clone $form1)->where('state_id', $state->state_id);
                            $form2_state = (clone $form2)->where('state_id', $state->state_id);
                            $form3_state = (clone $form3)->where('state_id', $state->state_id);
                            $form12_state = (clone $form12)->where('state_id', $state->state_id);
                            $case_state = (clone $case)->where('state_id', $state->state_id);
                        ?>
                        <tr> 
                            <td>{{ $index+1 }}</td>
                            <td style="text-align: left; text-transform: uppercase;">{{ $state->state}}</td>
                            <!-- total f1 -->
                            <td>
                                <a onclick="viewForm1( {{ $state->state_id }})">{{ count($form1_state)}} </a>
                            </td>
                            <!-- total f2 -->
                            <td>
                                <a onclick="viewForm2( {{ $state->state_id }})">{{ count($form2_state)}}</a> 
                            </td>
                            <!-- total f3 -->
                            <td>
                                <a onclick="viewForm3( {{ $state->state_id }})">{{ count($form3_state)}}</a>
                            </td>
                             <!-- total f3 -->
                            <td>
                                <a onclick="viewForm12( {{ $state->state_id }})">{{ count($form12_state)}}</a>
                            </td>
                            <!-- total by year -->
                            <td>{{ count($case_state) }}</td>
                            <!-- total by state -->
                            <td>
                                @if(count($case) > 0)
                                    {{ (number_format(count($case_state)/count($case)*100, 2,'.','')) }}
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">{{__('new.total')}}</td>
                            <td>{{ count($form1)}}</td>
                            <td>{{ count($form2)}}</td>
                            <td>{{ count($form3)}}</td>
                            <td>{{ count($form12)}}</td>
                            <td>{{ count($case) }}</td>
                            <td>
                                @if(count($case) > 0)
                                    100
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
<div class="row hide-print">
    <div class="col-md-12" style="text-align: center; line-height: 80px;">
        <a type="button" class="btn default" href='{{ route("report.list", ["page" => 1]) }}'>
            <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
        </a>
        <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.print') }}</button>
        <button type="button" class="btn purple btn-outline"  onclick="exportExcel()"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
    </div>
</div>
@endsection

@section('after_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->

<script type="text/javascript">
function exportPDF() {
    location.href = "{{ url('') }}/report/report3/export/pdf?{!! http_build_query(request()->input()) !!}";
}

function exportExcel() {
    location.href = "{{ url('') }}/report/report3/export/excel?{!! http_build_query(request()->input()) !!}";
}

function viewForm1(state_id) {
    // $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form1?year={{Request::get('year')}}&month={{ Request::get('month')}}");
    $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form1?year={{Request::get('year')}}&month={{ Request::get('month')}}&date_start={{ Request::get('date_start')}}&date_end={{ Request::get('date_end')}}");
}
function viewForm2(state_id) {
    // $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form2?year={{Request::get('year')}}&month={{ Request::get('month')}}");
    $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form2?year={{Request::get('year')}}&month={{ Request::get('month')}}&date_start={{ Request::get('date_start')}}&date_end={{ Request::get('date_end')}}");
}
function viewForm3(state_id) {
    // $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form3?year={{Request::get('year')}}&month={{ Request::get('month')}}");
    $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form3?year={{Request::get('year')}}&month={{ Request::get('month')}}&date_start={{ Request::get('date_start')}}&date_end={{ Request::get('date_end')}}");
}
function viewForm12(state_id) {
    // $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form12?year={{Request::get('year')}}&month={{ Request::get('month')}}");
    $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form12?year={{Request::get('year')}}&month={{ Request::get('month')}}&date_start={{ Request::get('date_start')}}&date_end={{ Request::get('date_end')}}");
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

<!-- END PAGE LEVEL SCRIPTS -->

@endsection