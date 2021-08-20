<?php
$locale = App::getLocale();
$status_lang = "form_status_desc_" . $locale;
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
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>

    <style>
        .nowrap {
            white-space: nowrap;
        }

        .data table, tr, td {
            border: 1px solid;
        }
    </style>

@endsection

@section('content')
    <div class="row margin-top-10">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ trans('new.search_list') }}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table id="searchtab1" class="table table-striped table-bordered table-hover table-responsive mt5"
                           width="100%">
                        <thead>
                        <tr>
                            <th width="2%">{{ __('new.no')}}</th>
                            <th>{{ __('new.name')}}</th>
                            <th>{{ __('new.ic')}}</th>
                            <th>{{ __('new.suggestion_details')}}</th>
                            <th>{{ __('new.response')}}</th>
                            <th>{{ __('new.created_at')}}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix">
        <div class="col-md-offset-4 col-md-8 mv20">
            <button type="submit" class="btn default" onclick="history.back()"><i
                        class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
        </div>
    </div>


@endsection

@section('after_scripts')
    <script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
            type="text/javascript"></script>

    <script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
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
          var table = $('#searchtab1')

          var oTable = table.DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': "{!! Request::fullUrl() !!}",
            'deferRender': true,
            'pagingType': 'bootstrap_full_number',
            'columns': [
              { data: 'id', defaultContent: '', 'orderable': false, 'searchable': false },
              { data: 'name', name: 'created_by.name', 'orderable': false, 'searchable': false },
              { data: 'username', name: 'created_by.username', 'orderable': false, 'searchable': false },
              {
                data: 'suggestion', name: 'suggestion', 'orderable': false, 'render': function (data, type, full) {
                  return $('<div/>').html(data).text()
                }
              },
              {
                data: 'status', name: 'response', 'orderable': false, 'render': function (data, type, full) {
                  return $('<div/>').html(data).text()
                }
              },
              { data: 'created_at', name: 'created_at' }


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
                extend: 'excel',
                className: 'btn yellow btn-outline',
                text: '<i class="fa fa-file-excel-o margin-right-5"></i> Excel',
                exportOptions: {
                  orthogonal: 'export' ,
                  columns: ':visible'
                }
              },
              {
                extend: 'colvis',
                className: 'btn blue btn-outline',
                text: 'Paparan Medan'
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
            'pageLength': -1,

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
