<?php
$locale = App::getLocale();
$status_lang = "form_status_desc_" . $locale;
$month_lang = "month_" . $locale;
?>

@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>
    <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>

    <style>
        .nowrap {
            white-space: nowrap;
        }
    </style>

@endsection

@section('heading', 'Roles')


@section('content')
    <div class="row margin-top-10">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ trans('form4.hearing_list') }}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div style="margin-bottom: 20px;">
                    <form method='get' action=''>
                        <div id="search-form" class="form-inline">
                            <div class="form-group mb10">
                                <label for="status">{{ trans('hearing.status') }}</label>
                                <select id="status" class="form-control" name="status" style="margin-right: 10px;">
                                    <option value="" selected disabled hidden>-- {{ __('form1.all_status') }}--
                                    </option>
                                    <option value="">-- {{ __('form1.all_status') }} --</option>
                                    @foreach($status as $i=>$stat)
                                        <option
                                                @if(Request::get('status') == $stat->form_status_id) selected @endif
                                        value="{{ $stat->form_status_id }}">{{ $stat->$status_lang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb10">
                                <label for="branch">{{ trans('hearing.branch') }}</label>
                                <select id="branch" class="form-control" name="branch" style="margin-right: 10px;">
                                    <option value="" selected disabled hidden>-- {{ __('form1.all_branch') }}--
                                    </option>
                                    <option value="0" @if(Request::get('branch') == 0) selected @endif >
                                        -- {{ __('form1.all_branch') }} --
                                    </option>
                                    @foreach($branches as $i=>$branch)
                                        <option @if(Request::get('branch') == $branch->branch_id) selected
                                                @endif value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br class='hidden-xs hidden-sm'>
                            <div class="form-group mb10">
                                <label for="year">{{ trans('hearing.year') }} </label>
                                <select id="year" class="form-control" name="year" style="margin-right: 10px;">
                                    <option value="0" selected disabled hidden>-- {{ __('form1.all_year') }} --</option>
                                    <option value="0">-- {{ __('form1.all_year') }} --</option>
                                    @foreach($years as $i=>$year)
                                        <option @if($input['year'] == $year) selected
                                                @endif value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb10">
                                <label for="month">{{ trans('hearing.month') }}</label>
                                <select id="month" class="form-control" name="month" style="margin-right: 10px;">
                                    <option value="" selected disabled hidden>-- {{ __('form1.all_month') }} --</option>
                                    <option value="">-- {{ __('form1.all_month') }} --</option>
                                    @foreach($months as $i=>$month)
                                        <option @if(Request::get('month') == $month->month_id) selected
                                                @endif value="{{ $month->month_id }}">{{ $month->$month_lang }}</option>
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
                    <table id="form4_table" class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                        <tr>
                            <th width="3%">{{ trans('new.no') }}</th>
                            <th>{{ trans('form1.claim_no') }}</th>
                            <th>{{ trans('form1.opponent') }}</th>
                            <th>{{ trans('hearing.hearing_date') }}</th>
                            <th>{{ trans('hearing.place_hearing') }}</th>
                            <th>{{ trans('form1.status') }}</th>
                            <th width="3%">{{ trans('hearing.counter') }}</th>
                            <th>{{ trans('datatable.action') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('after_scripts')
    <script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
            type="text/javascript"></script>

    <script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>

    <!--sweetalert -->
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
    <!--end sweetalert -->
    <script type="text/javascript">


      var TableDatatablesButtons = function () {

        var initTable1 = function () {
          var table = $('#form4_table')

          var oTable = table.DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': "{!! Request::fullUrl() !!}",
            'deferRender': true,
            'pagingType': 'bootstrap_full_number',
            'columns': [
              // {data: 'rownum'},
              { data: 'id', defaultContent: '', 'orderable': false, 'searchable': false },
              {
                data: 'case_no', name: 'case.case_no', 'orderable': false, 'render': function (data, type, full) {
                  return $('<div/>').html(data).text()
                }
              },
              { data: 'opponent_name', name: 'opponent.name', 'orderable': false },
              { data: 'hearing_date', name: 'hearing.hearing_date', 'orderable': true },
              {
                data: 'hearing_location',
                name: 'hearing.hearing_room.hearing_room',
                'orderable': false,
                'render': function (data, type, full) {
                  return $('<div/>').html(data).text()
                }
              },
              { data: 'status', name: "status.form_status_desc_{{ App::getLocale() }}", 'orderable': false },
              { data: 'counter', name: 'hearing.counter', 'orderable': false, 'searchable': false },
              { data: 'action', name: 'action', 'orderable': false, 'searchable': false }
            ],
            'columnDefs': [
              { className: 'nowrap', 'targets': [ 4 ] }
            ],
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            'language': {
              'aria': {
                'sortAscending': ": {{ trans('new.sort_asc') }}",
                'sortDescending': ": {{ trans('new.sort_desc') }}"
              },
              'processing': "<span class=\"font-md\">{{ trans('new.process_data') }} </span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
              'emptyTable': "{{ trans('new.empty_table') }}",
              'info': "{{ trans('new.info_data') }}",
              'infoEmpty': "{{ trans('new.no_data_found') }}",
              'infoFiltered': "{{ trans('new.info_filtered') }}",
              'lengthMenu': "{{ trans('new.length_menu') }}",
              'search': "{{ trans('new.search') }}",
              'zeroRecords': "{{ trans('new.zero_record') }}"
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},


            buttons: [
              {
                extend: 'print',
                className: 'btn dark btn-outline',
                title: function () {
                  return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ trans('form4.hearing_list') }}</span>" // #translate
                },
                text: '<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                messageBottom: moment().format('dddd, MMMM Do, YYYY, h:MM:ss A'),
                customize: function (win) {
                  // Style the body..
                  $(win.document.body).css('background-color', '#FFFFFF')

                  $(win.document.body).find('thead').css('background-color', '#DDDDDD')

                  $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit')

                  win.document.title = "{{ trans('form4.hearing_list') }}"

                  $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} ' + moment().format('DD/MM/YYYY h:MM A') + '</footer>')


                },
                exportOptions: {
                  columns: [ 0, 1, 2, 3, 4 ]
                }
              }
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: false,

            //"ordering": false, disable column ordering 
            'paging': true, //disable pagination

            'order': [
              [ 0, 'asc' ]
            ],

            'lengthMenu': [
              [ 5, 10, 15, 20, 50 ],
              [ 5, 10, 15, 20, 50 ] // change per page values here
            ],
            // set the initial value
            'pageLength': 10,

            'dom': '<\'row\' <\'col-md-12\'B>><\'row\'<\'col-md-6 col-sm-12\'l><\'col-md-6 col-sm-12\'f>r><\'table-scrollable\'t><\'row\'<\'col-md-5 col-sm-12\'i><\'col-md-7 col-sm-12\'p>>' // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
          })
          oTable.on('order.dt search.dt draw.dt', function () {
            var start = oTable.page.info().start
            var info = oTable.page.info()
            oTable.column(0, { order: 'applied' }).nodes().each(function (cell, i) {
              cell.innerHTML = start + i + 1
              oTable.cell(cell).invalidate('dom')
            })
          }).draw()
        }

        return {

          //main function to initiate the module
          init: function () {
            if (!jQuery().dataTable) {
              return
            }
            initTable1()
          }
        }
      }()

      jQuery(document).ready(function () {
        TableDatatablesButtons.init()
      })
    </script>
@endsection