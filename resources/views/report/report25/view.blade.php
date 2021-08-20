<?php
use Carbon\Carbon;
$locale = App::getLocale();
$month_lang = 'month_' . $locale;
?>
@extends('layouts.app')

@section('after_styles')

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

    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

            <div class="portlet light bordered">
                <div class="portlet-body" style="margin: 20px;">
                    <div id='title'
                         style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">{{ __('new.tribunal')}}
                        <br>
                        {{ __('new.report2_1')}} @if ( $month){{ __('new.month') .' '.$month->$month_lang }}@endif {{ __('new.year') .' '.$year }}
                        <br>
                        {{ __('new.report25')}}<br>
                        ( {{ __('new.until') .' '.date('d/m/Y') }} )<br></div>

                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover data">
                            <thead>
                            <tr>
                                <th rowspan="2"> {{ __('new.no') }} </th>
                                <th rowspan="2"> {{ __('new.state') }} </th>
                                <th rowspan="2"> {{ __('new.reg_case') }} </th>
                                <th colspan="7"> {{ __('new.type') }} </th>
                                <th rowspan="2"> {!! __('new.total_form') !!} </th>
                                <th rowspan="2"> {{ __('new.reminder') }} </th>
                            </tr>
                            <tr>
                                <th> {!! __('new.stop_revoked') !!} </th>
                                <th> 5</th>
                                <th> 6</th>
                                <th> 7</th>
                                <th> 8</th>
                                <th> 9</th>
                                <th> 10</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ( $states as $index => $state )
                                <?php
                                $report = (clone $report25)->where('state_id', $state->state_id);
                                ?>
                                <tr>
                                    <td> {{ $index+1 }} </td>
                                    <td style="text-align: left; text-transform: uppercase;"> {{ $state->state_name }} </td>
                                    <td> {{ $report ? $report->sum('register') : '0' }} </td>
                                    <td>
                                        <a onclick="viewStopNotice( {{ $state->state_id }} )"> {{ $report ? $report->sum('revoked_stopnotice') : '0' }}  </a>
                                    </td>
                                    <td> {{ $report ? $report->sum('award5') : '0' }} </td>
                                    <td> {{ $report ? $report->sum('award6') : '0' }} </td>
                                    <td> {{ $report ? $report->sum('award7') : '0' }} </td>
                                    <td> {{ $report ? $report->sum('award8') : '0' }} </td>
                                    <td> {{ $report ? $report->sum('award9') : '0' }} </td>
                                    <td> {{ $report ? $report->sum('award10') : '0' }} </td>
                                    <td> {{ $report ? $report->sum('total') : '0' }} </td>
                                    <td> {{ $report ? $report->sum('balance') : '0' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2">{{__('new.total')}}</td>
                                <td> {{ $report25->sum('register') }} </td>
                                <td> {{ $report25->sum('revoked_stopnotice') }} </td>
                                <td> {{ $report25->sum('award5') }} </td>
                                <td> {{ $report25->sum('award6') }} </td>
                                <td> {{ $report25->sum('award7') }} </td>
                                <td> {{ $report25->sum('award8') }} </td>
                                <td> {{ $report25->sum('award9') }} </td>
                                <td> {{ $report25->sum('award10') }} </td>
                                <td> {{ $report25->sum('total') }} </td>
                                <td> {{ $report25->sum('balance') }} </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 hide-print" style="text-align: center; line-height: 80px;">
            <a type="button" class="btn default" href='{{ route("report.list", ["page" => 3]) }}'>
                <i class="fa fa-reply mr10"></i>{{ trans('new.back') }}
            </a>
            <button type="button" class="btn dark btn-outline" onclick="exportPDF()"><i
                        class="fa fa-print mr10"></i>{{ trans('button.print') }}</button>
            <button type="button" class="btn purple btn-outline" onclick="exportExcel()"><i
                        class="fa fa-paper-plane mr10"></i>{{ trans('button.export_excel') }}</button>
        </div>
    </div>
@endsection

@section('after_scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL SCRIPTS -->


    <script type="text/javascript">

      function exportPDF() {
        location.href = "{{ url('') }}/report/report25/export/pdf?{!! http_build_query(request()->input()) !!}"
      }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report25/export/excel?{!! http_build_query(request()->input()) !!}"
      }

      function viewStopNotice(state_id) {
        $('#modalDiv').load("{{ url('/report') }}/report25/" + state_id + "/stop_notice?year={{Request::get('year')}}&month={{ Request::get('month')}}")
      }

      var myDataTables = $('table').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        processing: false,
        serverSide: false,
        searching: false,
        bInfo: false,
        paging: false,
        buttons: [
          {
            extend: 'excel',
            className: 'btn yellow btn-outline hidden',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: $('#title').html().replace(/<br>/g, ' '),
            text: '<i class="fa fa-file-excel-o margin-right-5"></i> Excel'
          },
          {
            extend: 'pdfHtml5',
            className: 'btn green btn-outline hidden',
            orientation: 'landscape',
            footer: true,
            title: '{{ __("new.report") }}',
            messageTop: '',
            text: '<i class="fa fa-file-pdf-o margin-right-5"></i> Print As PDF',
            customize: function (doc) {
              // Splice the image in after the header, but before the table
              doc.content.splice(1, 0, {
                margin: [ 0, 0, 0, 12 ],
                alignment: 'center',
                text: $('#title').html().replace(/<br>/g, ' ')
              })
              // Data URL generated by http://dataurl.net/#dataurlmaker
            }
          }
        ],
        language: {
          'aria': {
            'sortAscending': ": {{ trans('new.sort_asc') }}",
            'sortDescending': ": {{ trans('new.sort_desc') }}"
          },
          'processing': "<span class=\"font-md\">{{ trans('new.process_data') }}</span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
          'emptyTable': "{{ trans('new.empty_table') }}",
          'info': "{{ trans('new.info_data') }}",
          'infoEmpty': "{{ trans('new.no_data_found') }}",
          'infoFiltered': "{{ trans('new.info_filtered') }}",
          'lengthMenu': "{{ trans('new.length_menu') }}",
          'search': "{{ trans('new.search') }}",
          'zeroRecords': "{{ trans('new.zero_record') }}"
        }

      })

      function exportTo(buttonSelector) {
        $('.buttons-' + buttonSelector).click()
      }
    </script>

@endsection