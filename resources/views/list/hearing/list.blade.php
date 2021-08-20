@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet"
          type="text/css"/>

@endsection

@section('heading', 'Roles')


@section('content')
    <div class="row margin-top-10">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list"></i>
                        <span class="caption-subject bold uppercase"> {{ __('hearing.hearing_list') }} </span>
                    </div>
                    <div class="tools"></div>
                </div>

                <div class="" style="margin-bottom: 20px;">
                    <form method='get' action=''>
                        <div id="search-form" class="form-inline">
                            <div class="form-group mb10">
                                <label for="hearing_date">{{ __('new.at')}}</label>
                                <div class="input-group date date-picker" data-date-format="dd/mm/yyyy"
                                     style="margin-right: 10px;">
                                    <input type="text" class="form-control" name="hearing_date" id="hearing_date"
                                           value="{{ Request::get('hearing_date') }}"/>
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>      <!-- REQUEST TO DISPLAY ON WHAT WE SELECT -->
                                </div>
                            </div>
                            <div class="form-group mb10">
                                <label for="branch_id">{{ trans('hearing.branch') }}</label>
                                <select id="branch_id" class="form-control" name="branch" style="margin-right: 10px;">
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
                            <div class="form-group mb10">
                                <label for="hearing_venue_id">{{ __('new.place_hearing') }}</label>
                                <select id="hearing_venue_id" class="form-control" name="hearingplace"
                                        style="margin-right: 10px;">
                                    <option value="" selected>-- {{ __('new.all_places') }} --</option>
                                    <option value="">-- {{ __('new.all_places') }} --</option>
                                </select>
                            </div>
                            <br class='hidden-xs hidden-sm'>
                            <div class="form-group mb10">
                                <label for="hearing_room_id">{{ __('hearing.hearing_room') }}</label>
                                <select id="hearing_room_id" class="form-control" name="hearingRoom"
                                        style="margin-right: 10px;">
                                    <option value="" selected>--{{ __('new.all_rooms') }}--</option>
                                    <option value="">--{{ __('new.all_rooms') }}--</option>
                                </select>
                            </div>
                            <div class="form-group mb10">
                                <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="portlet-body">
                    <table id="stop_reason" class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                        {{--
                        <tr>
                            <th colspan="7" style="text-align: center">
                                {{ __('new.hearing_schedule') }} <br>
                                {{ __('new.hearing_date') }} : <span style="font-weight: normal;"> {{ Request::get('hearing_date') }} </span><br>
                                {{ __('new.hearing_place') }} : <span style="font-weight: normal;">
                                    @foreach($branches as $i=>$branch)
                                         @if(Request::get('branch') == $branch->branch_id) 
                                            {{ $branch->branch_name}}
                                         @endif
                                    @endforeach
                                </span>
                            </th>
                        </tr>
                        --}}
                        <tr>
                            <th width="3%">{{ trans('new.no') }}</th>
                            <th>{{ __('new.claim_no') }}</th>
                            <th>{{ __('new.claim_no') }}</th>
                            <th style="text-align: center">{{ __('new.filing_date') }} <br> {{ __('new.claim') }}</th>
                            <th style="text-align: center">{{ __('new.last_date') }} <br> {{ __('new.must_filed') }}
                            </th>
                            <th>{{ __('new.form2') }}</th>
                            <th>{{ __('new.form3') }}</th>
                            <th>{!! __('form4.list_hearing_date') !!}</th>
                            <th>{{ __('new.president') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade bs-modal-lg" id="modalperanan" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{ __('master.stop_reason_info')}}</h4>
                </div>
                <div class="modal-body" id="modalbodyperanan" style="padding: 0px;">
                    <div style="text-align: center;">
                        <div class="loader"></div>
                    </div>
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
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
    <!--sweetalert -->
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
    <!--end sweetalert -->
    <script type="text/javascript">
      $('body').on('click', '.btnModalPeranan', function () {
        $('#modalperanan').modal('show')
          .find('#modalbodyperanan')
          .load($(this).attr('value'))
      })
      $('#modalperanan').on('hidden.bs.modal', function () {
        $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>')
      })
    </script>
    <script type="text/javascript">
      var TableDatatablesButtons = function () {

        var initTable1 = function () {
          var table = $('#stop_reason')

          var oTable = table.DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': "{!! Request::fullUrl() !!}",
            'deferRender': true,
            'pagingType': 'bootstrap_full_number',
            'columns': [
              { data: 'id', defaultContent: '', 'orderable': false, 'searchable': false },
              { data: 'filing_date_form1_raw', name: 'filing_date', visible: false },
              { data: 'case_no', name: 'case_no', 'orderable': false },
              { data: 'filing_date', name: 'filing_date ', 'orderable': false },
              { data: 'matured_date', name: 'matured_date', 'orderable': false },
              { data: 'form2_status', name: "f2_status.form_status_desc_{{ App::getLocale() }}", 'orderable': false },
              { data: 'form3_status', name: "f3_status.form_status_desc_{{ App::getLocale() }}", 'orderable': false },
              { data: 'hearing_date', name: 'hearing_date ', 'orderable': false },
              { data: 'president_name', name: 'president.name', 'orderable': false }
            ],
            'orderFixed': [ 1, 'asc' ],
            'language': {
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
            },

            buttons: [
              {
                extend: 'print',
                className: 'btn dark btn-outline',
                title: function () {
                  return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ __('hearing.hearing_list') }}</span>" // #translate
                },
                text: '<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                customize: function (win) {
                  // Style the body..
                  $(win.document.body).css('background-color', '#FFFFFF')

                  $(win.document.body).find('thead').css('background-color', '#DDDDDD')

                  $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit')

                  win.document.title = "{{ __('hearing.hearing_list') }}"

                  $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} ' + moment().format('DD/MM/YYYY h:MM A') + '</footer>')
                },
                exportOptions: {
                  columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                }
              }

            ],

            responsive: false,

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

      var data = null

      $('#branch_id').on('change', function () {
        var branch_id = $('#branch_id').val()

        if (branch_id == '') {
          $('#hearing_venue_id').html("<option selected>-- {{ __('new.all_places') }} --</option>")
          $('#hearing_room_id').html("<option selected>-- {{ __('new.all_rooms') }} --</option>")
          return
        }

        $.ajax({
          url: "{{ url('/') }}/branch/" + branch_id + '/venues',
          type: 'GET',
          async: false,
          success: function (res) {

            data = res

            $('#hearing_venue_id').empty()
            $('#hearing_room_id').empty()
            $('#hearing_venue_id').append("<option value='' selected>-- {{ __('new.all_places') }} --</option>")
            $.each(data.venues, function (key, venue) {
              if (venue.is_active == 1)
                $('#hearing_venue_id').append('<option key=\'' + key + '\' value=\'' + venue.hearing_venue_id + '\'>' + venue.hearing_venue + '</option>')
            })

          }
        })
      })

      $('#hearing_venue_id').on('change', function () {
        hearing_venue_id = $('#hearing_venue_id option:selected').attr('key')

        //console.log(data.branches[branch_id].venues[hearing_venue_id]);

        $('#hearing_room_id').empty()
        $('#hearing_room_id').append("<option value='' selected>-- {{ __('new.all_rooms') }} --</option>")
        $.each(data.venues[ hearing_venue_id ].rooms, function (key, room) {
          if (room.is_active == 1)
            $('#hearing_room_id').append('<option key=\'' + key + '\' value=\'' + room.hearing_room_id + '\'>' + room.hearing_room + '</option>')
        })

      })

      @if(Request::has('branch') == $branch->branch_id)
      $('#branch_id').val({{ Request::get('branch') }}).trigger('change')
      @endif

      @if(Request::has('hearingplace') == $branch->branch_id)
      $('#hearing_venue_id').val({{ Request::get('hearingplace') }}).trigger('change')
      @endif

      @if(Request::has('hearingRoom') == $branch->branch_id)
      $('#hearing_room_id').val({{ Request::get('hearingRoom') }}).trigger('change')
        @endif

    </script>

@endsection