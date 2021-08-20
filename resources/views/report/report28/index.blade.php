<?php
$month_lang = "month_" . $locale;
$method_lang = "method_" . $locale;
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
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ __('new.report28') }} </span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div style="margin-bottom: 20px;">
                    <form method='get' action=''>
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
                                <div class="form-group form-md-line-input">
                                    <label for="month" class="control-label col-md-4">{{ trans('new.state')}} :
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-5">
                                        <select id="state_id" class="form-control select2 bs-select" name="state_id"
                                                style="margin-right: 10px;"
                                                placeholder="-- {{ __('new.all_state') }} --">
                                            <option value="" selected>-- {{ __('new.all_state') }} --</option>
                                            {{-- @foreach($states as $id => $state) --}}
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
                    @if($is_search)
                        <div id='title'
                             style="background-color: white !important; color: black; text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                            {{ __('new.tribunal') }}<br>
                            {{ __('new.inquiry_method_for') }}<br>
                            {{ $input['date_start'] ?: date('d/m/Y') }}
                            {{ __('new.until') }}
                            {{ $input['date_end'] ?: date('d/m/Y') }}<br>
                            @if(isset($state_id))
                                {{__('new.state')}} {{$states[$state_id]}}<br>
                            @endif
                        </div>

                        <table class="table table-bordered table-hover data">
                            <thead>
                            <tr>
                                <th rowspan="2"> {{ __('new.state') }} </th>
                                <th colspan="{{ count($inquiry_methods_list) }}"> {{ __('new.method') }} </th>
                                <th rowspan="2"> {{ __('new.total') }} </th>
                            </tr>
                            <tr style="text-transform: uppercase;">
                                @foreach($inquiry_methods_list as $inq)
                                    <th width="10%"> {{ $inq }} </th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($state_list as $state_id => $state)
                                <tr>
                                    <td style="text-align: left; text-transform: uppercase;">{{ $state }}</td>
                                    @foreach($inquiry_methods_list as $i => $im)
                                      <td>{{ $data_final[$state_id][$i] }}</td>
                                    @endforeach
                                    <td>{{ $data_final[$state_id]['total'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>{{__('new.total')}}</td>
                                @foreach($inquiry_methods_list as $i => $im)
                                    <td>{{ $data_final['total'][$i] }}</td>
                                @endforeach
                                <td>{{ $data_final['total']['total'] }}</td>
                            </tr>
                            </tfoot>
                        </table>
                    @endif
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
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>
      function exportExcel() {
        location.href = "{{ url('') }}/report/report28/export/excel?{!! http_build_query(request()->input()) !!}"
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