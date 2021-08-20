<?php
$locale = App::getLocale();
$month_lang = "month_" . $locale;
$classification_lang = "classification_" . $locale;
$category_lang = "category_" . $locale;

$total = 0;
$dualtotal = 0;
$a = 1;
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

        th {
            vertical-align: middle !important;
            background-color: #428bca !important;
            color: #ffffff;
        }

        th.rotate {
            /* Something you can count on */
            height: 150px;
            white-space: nowrap;
        }

        th.rotate > div {
            transform: /* Magic Numbers */ translate(0px, 50px) /* 45 is really 360 - 45 */ rotate(270deg);
            width: 10px;
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
                    <div style="text-align: center; text-transform: uppercase; font-weight: bold; margin-bottom: 20px;">
                        {{ __('new.tribunal')}}<br><br>
                        <form method='get' action='' id="search-form">
                    <span style="line-height: 2; display: inline-flex; text-align: center; margin-bottom: 10px">
                        {{ __('new.claim_category')}} (
                        <select id="category" class="form-control" name="category"
                                style="width: 200px; margin: 0px 15px;">
                            <option value="0" selected>-- {{ __('new.all') }} --</option>
                            @foreach($categories as $i=>$category)
                                <option @if(Request::get('category') == $category->claim_category_id ) selected
                                        @endif value="{{ $category->claim_category_id }}">{{ $category->$category_lang }}</option>
                            @endforeach
                        </select>
                        ) {{ __('new.filed_each_state') }}
                        <select id="state_id" class="form-control " name="state_id"
                                style="width: 200px; margin: 0px 15px;"
                                placeholder="-- {{ __('new.all_state') }} --">
                                            <option value="" selected>-- {{ __('new.all_state') }} --</option>
                                            @foreach($state_list as $id => $state)
                                <option @if(Request::get('state_id') == $id ) selected
                                        @endif value="{{ $id }}">{{ $state }}
                                                </option>
                            @endforeach
                                        </select>
                    </span>
                            <br>
                            <span style="line-height: 34px; display: inline-flex; text-align: center; margin-bottom: 10px">
                       {{ __('new.year') }}

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
                        {{ __('new.month') }}

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

                         <div class="form-group mb10">
                            <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                        </div>
                    </span>
                            <br>
                            <span>( {{ __('new.until') .' '.date('d/m/Y') }} )</span><br><br>
                        </form>
                    </div>

                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover data">
                            <thead>
                            <tr>
                                <th> {{ __('new.no') }} </th>
                                <th> {{ __('inquiry.claim_classification') }} </th>
                                @foreach ($states as $state)
                                    @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                                        <th class="rotate" style="text-transform: uppercase;">
                                            <div><span>{{ $state->state_name }} </span></div>
                                        </th>
                                    @endif
                                @endforeach
                                <th> {{ __('new.total') }} </th>
                                <th> %</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classifications as $index => $classification)
                                <?php
                                $case_class = (clone $case)->where('classification_id', $classification->claim_classification_id);
                                ?>
                                <tr>
                                    <td>{{ $a++ }}</td>
                                    <td style="text-align: left; text-transform: uppercase;"> {{ $classification->$classification_lang }}</td>
                                    @foreach($states as $state)
                                        @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                                            <?php
                                            $class_state = (clone $case_class)->where('state_id', $state->state_id);
                                            $total += count($class_state);
                                            ?>
                                            <td>
                                                <a onclick="dd( {{ $state->state_id }} , {{ $classification->claim_classification_id }})">{{ count($class_state) }}</a>
                                            </td>
                                        @endif
                                    @endforeach
                                    <td> <a onclick="dd( '' , {{ $classification->claim_classification_id }})">{{ count($case_class) }}</a> </td>
                                    <td> @if(count($case) > 0)
                                            {{ number_format( count($case_class)/count($case)*100, 2,'.',',') }}%
                                        @else
                                            0
                                        @endif </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2">{{__('new.total')}}</td>
                                @foreach($states as $state)
                                    @if(($state_id != '' && $state_id == $state->state_id) || ($state_id == ''))
                                        <?php
                                        $state_count = (clone $case)->where('state_id', $state->state_id);
                                        ?>
                                        <td><a style="color:white" onclick="dd( {{ $state->state_id }} , ''')">{{ count($state_count) }}</a></td>
                                    @endif
                                @endforeach
                                <td><a style="color:white" onclick="dd( '' , '')">{{ $total }}</a></td>
                                <td>100%</td>
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
            <a type="button" class="btn default" href='{{ route("report.list", ["page" => 2]) }}'>
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
    <script>

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

      function exportPDF() {
        location.href = "{{ url('') }}/report/report16/export/pdf?{!! http_build_query(request()->input()) !!}"
      }

      function exportExcel() {
        location.href = "{{ url('') }}/report/report16/export/excel?{!! http_build_query(request()->input()) !!}"
      }

      function getTitle() {
        var title = "{{ __('new.tribunal')}}<br>{{ __('new.claim_category')}} "

        if ($('#category').val() > 0) {
          title += '(' + $('#category option:selected').text() + ')'
        }

        title += " {{ __('new.filed_each_state') }}<br>{{ __('new.year') }} " + $('#year option:selected').text() + " {{ __('new.month') }}"

        if ($('#month').val() > 0) {
          title += $('#month option:selected').text()
        }

        title += "<br>( {{ __('new.until') .' '.date('d/m/Y') }} )"

        return title.replace(/<br>/g, '\n')

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

      function exportTo(buttonSelector) {
        $('.buttons-' + buttonSelector).click()
      }

      function dd(state_id, classification_id) {
        $('#modalDiv').load("{{ url('/report') }}/report16/dd-modal?state_id=" + state_id + '&classification_id=' + classification_id + "&category={{Request::get('category')}}&date_start={{Request::get('date_start')}}&date_end={{ Request::get('date_end')}}");
      }
    </script>

@endsection