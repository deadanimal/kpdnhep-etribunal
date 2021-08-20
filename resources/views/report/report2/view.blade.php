<?php
use Carbon\Carbon;
$locale = App::getLocale();
$month_lang = 'month_'.$locale;

$GLOBALS['total'] = $report2->sum('register');

function calcPercentage($val){
    if($GLOBALS['total'] == 0)
        return "0.0%";

    else {
        return number_format($val/$GLOBALS['total']*100, 1,'.','')."%";
    }
}

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
        .fit {
            width:1%;
            white-space:nowrap;
        }

        .table > tfoot > tr > td, .table > tfoot > tr > th {
            padding: 8px !important;
        }

    </style>
@endsection

@section('content')
    <!-- #start -->

    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">

                <div class="portlet-body" style="margin: 20px;">

                    <div id='title' style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}} <br>
                        {{ __('new.report2_1') }} @if ( $month ){{ __('new.month') .' '.$month->$month_lang }}@endif {{ __('new.year') .' '.$year }} {{ __('new.report2_2')}} <br>
                        ( {{ __('new.until') .' '.date('d/m/Y') }} )<br></div>

                    <div class='table-scrollable'>
                        <table id='table_report2' class="table table-bordered table-hover data">
                            <thead>
                            <tr>
                                <th width="3%" rowspan="3"> {{ __('new.no') }} </th>
                                <th rowspan="3"> {{ __('new.state') }}  </th>
                                <th rowspan="3" class='fit'> {{ __('new.register') }} </th>
                                <th colspan="2" class='fit'> {{ __('new.claim_type') }} </th>
                                <th colspan="4" class='fit'> {{ __('new.form') }} </th>
                                <th colspan="12"> {{ __('new.solution_method') }} </th>
                                <th rowspan="3"> {!! __('new.total_completed') !!}  </th>
                                <th rowspan="3"> {{ __('new.reminder') }} </th>
                            </tr>
                            <tr>
                                <th rowspan="2" class='fit'> B </th>
                                <th rowspan="2" class='fit'> P </th>
                                <th rowspan="2" class='fit'> B2 </th>
                                <th rowspan="2" class='fit'> B3 </th>
                                <th rowspan="2" class='fit'> B11 </th>
                                <th rowspan="2" class='fit'> B12 </th>
                                <th rowspan="2"> {!! __('new.stop_notice_r2') !!} </th>
                                <th rowspan="2"> TB </th>
                                <th rowspan="2"> {{ __('new.revoked_cancel')}} </th>
                                <th colspan="2"> {{ __('new.negotiation') }} </th>
                                <th colspan="7"> {{ __('new.hearing') }} </th>
                            </tr>
                            <tr>
                                <th> B6 </th>
                                <th> B9 </th>
                                <th> B5 </th>
                                <th> B7 </th>
                                <th> B8 </th>
                                <th> B10 </th>
                                <th> B10K </th>
                                <th> B10T </th>
                                <th> B10B </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $states as $index => $state )
                                <?php
                                $report = (clone $report2)->where('state_id', $state->state_id);
                                $report = (clone $report2)->where('state_id', $state->state_id);
                            ?>
                                <tr>
                                    <td> {{$index+1}} </td>
                                    <td style="text-align: left; text-transform: uppercase;"> {{ $state->state_name }} </td>
                                    <td> {{ $report ? $report->sum('register') : '0' }} </td>
                                    <td class='fit'> {{ $report ? $report->sum('b') : '0' }} </td>
                                    <td class='fit'> {{ $report ? $report->sum('p') : '0' }} </td>
                                    <td class='fit'> {{ $report ? $report->sum('f2') : '0' }} </td>
                                    <td class='fit'> {{ $report ? $report->sum('f3') : '0' }} </td>
                                    <td class='fit'> {{ $report ? $report->sum('f11') : '0' }} </td>
                                    <td class='fit'> {{ $report ? $report->sum('f12') : '0' }} </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'stop_notice')">{{ $report ? $report->sum('stop_notice') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'revoked')">{{ $report ? $report->sum('revoked') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'canceled')">{{ $report ? $report->sum('canceled') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'f6')">{{ $report ? $report->sum('f6') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'f9')">{{ $report ? $report->sum('f9') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'f5')">{{ $report ? $report->sum('f5') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'f7')">{{ $report ? $report->sum('f7') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'f8')">{{ $report ? $report->sum('f8') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'f10')">{{ $report ? $report->sum('f10') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'f10k')">{{ $report ? $report->sum('f10k') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'f10t')">{{ $report ? $report->sum('f10t') : '0' }}</a> </td>
                                    <td> <a onclick="viewSolution( {{ $state->state_id }} , 'f10b')">{{ $report ? $report->sum('f10b') : '0' }}</a> </td>
                                    <td>{{ $report ? $report->sum('complete') : '0' }}</td>
                                    <td> <a onclick="viewForm2( {{ $state->state_id }})"> {{ $report ? $report->sum('balance') : '0' }} </a></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2">{{ strtoupper(__('new.total')) }}</td>
                                <td> {{ $report2->sum('register') }}</td>
                                <td> {{ $report2->sum('b') }}</td>
                                <td> {{ $report2->sum('p') }}</td>
                                <td> {{ $report2->sum('f2') }}</td>
                                <td> {{ $report2->sum('f3') }}</td>
                                <td> {{ $report2->sum('f11') }}</td>
                                <td> {{ $report2->sum('f12') }}</td>
                                <td> {{ $report2->sum('stop_notice') }}</td>
                                <td> {{ $report2->sum('revoked') }} </td>
                                <td> {{ $report2->sum('canceled') }}</td>
                                <td> {{ $report2->sum('f6') }}</td>
                                <td> {{ $report2->sum('f9') }}</td>
                                <td> {{ $report2->sum('f5') }}</td>
                                <td> {{ $report2->sum('f7') }}</td>
                                <td> {{ $report2->sum('f8') }}</td>
                                <td> {{ $report2->sum('f10') }}</td>
                                <td> {{ $report2->sum('f10k') }}</td>
                                <td> {{ $report2->sum('f10t') }}</td>
                                <td> {{ $report2->sum('f10b') }}</td>
                                <td> {{ $report2->sum('complete') }} </td>
                                <td> {{ $report2->sum('balance') }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">{{ strtoupper(__('new.percentage')) }}</td>
                                <td>100%</td>
                                <td>{{ calcPercentage($report2->sum('b')) }}</td>
                                <td>{{ calcPercentage($report2->sum('p')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f2')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f3')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f11')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f12')) }}</td>
                                <td>{{ calcPercentage($report2->sum('stop_notice')) }}</td>
                                <td>{{ calcPercentage($report2->sum('revoked')) }}</td>
                                <td>{{ calcPercentage($report2->sum('canceled')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f6')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f9')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f5')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f7')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f8')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f10')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f10k')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f10t')) }}</td>
                                <td>{{ calcPercentage($report2->sum('f10b')) }}</td>
                                <td>{{ calcPercentage($report2->sum('complete')) }}</td>
                                <td>{{ calcPercentage($report2->sum('balance')) }}</td>
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
            <a type="button" class="btn default" href='{{ route("report.list", ["page" => 1]) }}'>
                <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
            </a>
            <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i class="fa fa-print mr10"></i>{{ trans('button.print') }}</button>
            <button type="button" class="btn purple btn-outline" onclick="exportExcel()"><i class="fa fa-print mr10"></i>{{ trans('button.export_excel') }}</button>
        <!-- <button type="button" class="btn purple btn-outline" onclick="exportTo('excel')"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button> -->
        </div>
    </div>
@endsection

@section('after_scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    {{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>
      function exportPDF() {
        location.href = "{{ url('') }}/report/report2/export/pdf?{!! http_build_query(request()->input()) !!}";
      }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report2/export/excel?{!! http_build_query(request()->input()) !!}";
      }

      function viewForm2(state_id) {
        $("#modalDiv").load("{{ url('/report') }}/report2/"+ state_id +"/balance?year={{Request::get('year')}}&month={{ Request::get('month')}}");
      }

      function viewSolution(state_id, solution) {
        $("#modalDiv").load("{{ url('/report') }}/report2/"+ state_id +"/"+ solution +"/solution?year={{Request::get('year')}}&month={{ Request::get('month')}}");
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
