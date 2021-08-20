<?php
use Carbon\Carbon;
$locale = App::getLocale();
$month_lang = "abbrev_" . $locale;
$total_state = 0;
?>

@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>
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
                        <span class="caption-subject bold uppercase">{{ trans('new.report9') }} </span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div style="margin-bottom: 20px;">
                    <form method='get' action='' id="filter">
                        <div id="search-form" class="form-horizontal">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="date" class="control-label col-md-3"> {{ __('new.date_start')}}:
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-2">
                                        <div class="input-group input-medium date date-picker"
                                             style="margin-right: 10px;" data-date-format="dd/mm/yyyy"
                                             style="width: 250px;">
                                            <input class="form-control datepicker" readonly=""
                                                   name="date_start" id="date_start"
                                                   data-date-format="dd/mm/yyyy" type="text"
                                                   value="{{ Request::has('date_start') ? Request::get('date_start') : date('d/m/Y') }}"/>
                                            <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                        </div>
                                    </div>
                                    <label for="hearing_day" class="control-label col-md-2"> {{ __('new.day')}}:
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div id='day' class="col-md-3" style="margin-top: 7px;">
                                        {{ localeDay(date('l', strtotime( Request::has('hearing_date') ? Carbon::createFromFormat('d/m/Y', Request::get('hearing_date'))->toDateString() : date('Y-m-d')))) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="date" class="control-label col-md-3"> {{ __('new.date_end')}} :
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-2">
                                        <div class="input-group input-medium date date-picker"
                                             style="margin-right: 10px;" data-date-format="dd/mm/yyyy"
                                             style="width: 250px;">
                                            <input class="form-control datepicker" readonly=""
                                                   name="date_end" id="date_end"
                                                   data-date-format="dd/mm/yyyy" type="text"
                                                   value="{{ Request::has('date_end') ? Request::get('date_end') : date('d/m/Y') }}"/>
                                            <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                        </div>
                                    </div>
                                    <label for="hearing_day" class="control-label col-md-2"> {{ __('new.day')}}:
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div id='day' class="col-md-3" style="margin-top: 7px;">
                                        {{ localeDay(date('l', strtotime( Request::has('hearing_date_end') ? Carbon::createFromFormat('d/m/Y', Request::get('hearing_date_end'))->toDateString() : date('Y-m-d')))) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="state_id" class="control-label col-md-3">{{ trans('new.state')}} :
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
                                <div class="form-group hide-print" style="text-align: center;">
                                    <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="portlet-body">
                    <div id='title'
                         style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                        {{ __('new.tribunal')}}
                        <br>
                        {{ __('new.attendance_vsitor') }} {{ Request::get('year') ? Request::get('year') : date('Y') }}
                        <br>
                        ( {{ __('new.until') .' '.date('d/m/Y') }} )<br></div>

                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover data">
                            <thead>
                            <tr>
                                <th rowspan="2"> {{ __('new.state') }} </th>
                                <th colspan="12"> {{ __('new.month') }} </th>
                                <th rowspan="2"> {{ __('new.total') }} </th>
                            </tr>
                            <tr style="text-transform: uppercase;">
                                @foreach($months as $month)
                                    <th> {{ $month->$month_lang }} </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($states as $state)
                                @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                                    <?php
                                    $visitor_state = (clone $visitor)->get()->where('state_id', $state->state_id);
                                    $total_state += count($visitor_state);
                                    ?>
                                    <tr>
                                        <td style="text-align: left; text-transform: uppercase;"> {{ $state->state }}</td>
                                        @foreach($months as $month)
                                            <?php
                                            $visitor_state_month = (clone $visitor)->whereMonth('visitor_datetime', $month->month_id)->get()->where('state_id', $state->state_id);

                                            ?>
                                            <td>
                                                <a onclick="viewdrilldown({{ $state->state_id }}, {{ $month->month_id }})">
                                                    {{ count($visitor_state_month) }}
                                                </a>
                                            </td>
                                        @endforeach
                                        <td> {{ count($visitor_state) }} </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>{{__('new.total')}}</td>
                                @foreach($months as $month)
                                    <?php
                                    $visitor_month = (clone $visitor)->whereMonth('visitor_datetime', $month->month_id)->get();
                                    ?>
                                    <td> {{ count($visitor_month) }}</td>
                                @endforeach
                                <td> {{ $total_state }} </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="text-align: center; line-height: 80px;">
            <a type="button" class="btn default" href='{{ route("report.list", ["page" => 1]) }}'>
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
    <script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    {{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>
      function exportPDF() {
        location.href = "{{ url('') }}/report/report9/export/pdf?{!! http_build_query(request()->input()) !!}"
      }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report9/export/excel?{!! http_build_query(request()->input()) !!}"
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

      function viewdrilldown(state_id, month) {
        // $("#modalDiv").load("{{ url('/report') }}/report3/"+ state_id +"/form1?year={{Request::get('year')}}&month={{ Request::get('month')}}");
        $("#modalDiv").load("{{ url('/report/report9/viewdd/showmodal') }}?date_start={{Request::has('date_start') ? Carbon::createFromFormat('d/m/Y', Request::get('date_start'))->format('d/m/Y') : date('d/m/Y')}}&date_end={{ Request::has('date_end') ? Carbon::createFromFormat('d/m/Y', Request::get('date_end'))->format('d/m/Y') : date('d/m/Y')}}&state_id="+state_id+"&month="+month);
      }
    </script>

@endsection