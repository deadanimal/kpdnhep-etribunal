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


@section('content')
    <div class="row margin-top-10">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase">{{ __('new.list_applicable_f12')}}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class="portlet-body">
                    <table id="form12_table" class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                        <tr>
                            <th width="3%">{{ trans('new.no') }}</th>
                            <th>{{ trans('form1.claim_no') }}</th>
                            <th>{{ trans('new.opponent_name') }}</th>
                            <th>{{ trans('new.hearing_date') }}</th>
                            <th>{{ trans('new.award_date') }}</th>
                            <th>{{ trans('new.action') }}</th>
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
          var table = $('#form12_table')

          var oTable = table.DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': "{!! Request::fullUrl() !!}",
            'deferRender': true,
            'pagingType': 'bootstrap_full_number',
            'columns': [
              { data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false },
              { data: 'case_no', name: 'claim_case.case_no', 'orderable': true },
              { data: 'opponent_name', name: 'opponent_address.name', 'orderable': true },
              { data: 'hearing_date', name: 'form4_latest.form4.hearing.hearing_date', 'orderable': true, 'searchable': false},
              { data: 'award_date', name: 'form4_latest.form4.award.award_date', 'orderable': false, 'searchable': false},
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

            buttons: [],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: false,
            stateSave: true,

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
          })
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
    <script type="text/javascript">
      $('body').on('click', '.ajaxDeleteSchedules', function (e) {
        e.preventDefault()
        var url = $(this).attr('href')
        swal({
            title: "{{ trans('swal.sure') }} ?",
            text: "{{ trans('swal.data_deleted') }} !",
            type: 'info',
            showCancelButton: true,
            cancelButtonClass: 'btn-danger',
            confirmButtonClass: 'green meadow',
            confirmButtonText: "{{ trans('button.delete') }}",
            cancelButtonText: "{{ trans('button.cancel') }}",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
          },
          function (isConfirm) {
            if (isConfirm) {
              $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                  _token: '{{csrf_token()}}'
                },
                success: function (response) {
                  if (response.status == 'ok') {
                    swal({
                      title: " {{ trans('swal.success') }} !",
                      text: " {{ trans('swal.success_deleted') }}.",
                      type: 'success',
                      timer: 500,
                      showConfirmButton: false
                    })
                    $('.modal.in').modal('hide')
                    $('#witness').DataTable().draw(false)
                  } else {
                    swal(" {{ trans('swal.error') }} !", "  {{ trans('swal.fail_deleted') }} ", 'error')
                  }
                }
              })
              // deletes.submit();
              return false
            }
          })
      })
      $('body').on('click', '.ajaxUpdateSchedule', function (e) {
        e.preventDefault()
        $('#modalPermohonanCuti').modal('show')
          .find('#modalBodyCuti')
          .load($(this).attr('href'))

        $('#modalPermohonanCuti').on('hidden.bs.modal', function () {
          $('#modalBodyCuti').html('')
        })
      })

      $('body').on('click', '.btnModalView', function (e) {
        e.preventDefault()
        $('#modalPermohonanCuti').modal('show')
          .find('#modalBodyCuti')
          .load($(this).attr('href'))

        $('#modalPermohonanCuti').on('hidden.bs.modal', function () {
          $('#modalBodyCuti').html('')
        })
      })

      @if(Session::has('form2_url'))

      swal({
          title: "{{ trans('swal.reminder') }}!",
          text: "{{ trans('swal.form2_not_filed') }}",
          type: 'warning',
          // showCancelButton: true,
          closeOnConfirm: true,
          closeOnCancel: true,
          allowOutsideClick: true,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: "{{ trans('swal.file_f2') }}"
          // cancelButtonText: "{{ trans('button.proceed_anyway') }}"
        },
        function (isConfirm) {
          if (isConfirm) {
            location.href = "{!! Session::get('form2_url')[0] !!}"
          }
          // else {
          //     location.href="{!! route('form12-create', ['form4_id' => Session::get('form2_url')[1], 'forced' => 'yes' ]) !!}";
          // }
        })
        @endif
    </script>
@endsection