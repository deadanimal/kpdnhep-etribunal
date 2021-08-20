@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
<div class="row margin-top-10">
  <div class="col-md-12">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <i class="fa fa-list"></i>
                <span class="caption-subject bold uppercase">{{ __('new.attendance_hearing')}}</span>
            </div>
        </div>
        <div style="margin-bottom: 20px;">
            <form method='get' action=''>
                <div id="search-form" class="form-inline">
                    <div class="form-group mb10">
                        <label for="hearing_date" class="control-label">{{ __('new.at')}} </label>
                        <div class="input-group date date-picker mb10" data-date-format="dd/mm/yyyy" style="margin-right: 10px;"> 
                            <input type="text" class="form-control" name="hearing_date" id="hearing_date" value="{{ Request::get('hearing_date') }}" />
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>      <!-- REQUEST TO DISPLAY ON WHAT WE SELECT -->
                        </div>
                    </div>
                    <div class="form-group mb10">
                        <label for="branch">{{ trans('hearing.branch') }}</label>
                        <select id="branch" class="form-control" name="branch" style="margin-right: 10px;">
                            <option value="" selected disabled hidden>-- {{ __('form1.all_branch') }} --</option>
                            <option value="" >-- {{ __('form1.all_branch') }} --</option>
                            
                        </select>
                    </div>
                    <div class="form-group mb10">
                        <label for="hearingplace">{{ __('new.place_hearing') }}</label>
                        <select id="hearing_place" class="form-control" name="hearingplace" style="margin-right: 10px;">
                            <option value="" selected disabled hidden>--{{ __('new.all') }}--</option>
                            <option value="" >-- {{ __('new.all') }} --</option>
                        </select>
                    </div>
                    <br class='hidden-xs hidden-sm'>
                    <div class="form-group mb10">
                        <label for="hearingplace">{{ __('hearing.hearing_room') }}</label>
                        <select id="hearing_room" class="form-control" name="hearingRoom" style="margin-right: 10px;">
                            <option value="" selected disabled hidden>--{{ __('new.all') }}--</option>
                            <option value="" >--{{ __('new.all') }}--</option>
                        </select>
                    </div>
                    <div class="form-group mb10">
                        <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="portlet-body">
            <table id="form1_list" class="table table-striped table-bordered table-hover table-responsive mt5" width="100%">
                <thead>
                    <tr>
                        <th style="text-align: center;float: center" rowspan="2">{{ __('new.no')}}</th>
                        <th style="text-align: center;float: center" rowspan="2">{{ __('new.claim_no')}}</th>
                        <th style="text-align: center;float: center" rowspan="2">{!! __('hearing.list_claimant_name') !!} </th>
                        <th style="text-align: center;float: center" rowspan="2">{{ __('new.opponent_name')}}</th>
                        <th style="text-align: center;float: center" rowspan="2">{!! __('hearing.list_hearing_date') !!}</th>
                        <th style="text-align: center;float: center" rowspan="2">{{ __('hearing.form')}} 2</th>
                        <th style="text-align: center;float: center" rowspan="2">{{ __('hearing.form')}} 3</th>
                        <th style="text-align: center;float: center" rowspan="2">{{ __('hearing.form')}} 11</th>
                        <th style="text-align: center;float: center" rowspan="2">{{ __('hearing.form')}} 12</th>
                        <th style="text-align: center;float: center" colspan="2">{{ __('new.attendance_status')}}</th>  
                    </tr>
                    <tr>
                        <th style="text-align: center;float: center">{!! __('hearing.claimant') !!}</th>
                        <th style="text-align: center;float: center">{{ __('new.opponent')}}</th>
                    </tr>
                </thead>
            </table>
        </div>   
    </div>    
</div>

@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
<!--end sweetalert -->
<script type="text/javascript">
    var TableDatatablesButtons = function () {

        var initTable = function () {
            var table = $('#form1_list');

            var oTable = table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{!! Request::fullUrl() !!}",
                "deferRender": true,
                "pagingType": "bootstrap_full_number",
                "columns": [
                { data: null, 'orderable' : false, 'searchable' : false},
                { data: "case_no", name:"case_no", 'orderable' : false},
                { data: "claimant_name", name:"claimant_name", 'orderable' : false},
                { data: "opponent_name", name:"opponent_name", 'orderable' : false},
                { data: "hearing_date", name:"branch_name", 'orderable' : false},
                { data: "form2_status", name:"case.form1.form2.status.form_status_desc_{{ App::getLocale() }}", 'orderable' : false},
                { data: "form3_status", name:"case.form1.form2.form3.status.form_status_desc_{{ App::getLocale() }}", 'orderable' : false},
                { data: "form11_status", name:"form11_status", 'orderable' : false},
                { data: "form12_status", name:"form12.status.form_status_desc_{{ App::getLocale() }}", 'orderable' : false},
                { data: "is_claimant_present", name:"is_claimant_present", 'orderable' : false},
                { data: "is_opponent_present", name:"is_opponent_present", 'orderable' : false},
                ],
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": {{ trans('new.sort_asc') }}",
                    "sortDescending": ": {{ trans('new.sort_desc') }}"
                },
                "processing": "<span class=\"font-md\">{{ trans('new.process_data') }} </span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
                "emptyTable": "{{ trans('new.empty_table') }}",
                "info": "{{ trans('new.info_data') }}",
                "infoEmpty": "{{ trans('new.no_data_found') }}",
                "infoFiltered": "{{ trans('new.info_filtered') }}",
                "lengthMenu": "{{ trans('new.length_menu') }}",
                "search": "{{ trans('new.search') }}",
                "zeroRecords": "{{ trans('new.zero_record') }}"
            },

            buttons: [
            {
                extend: 'print',
                className: 'btn dark btn-outline',
                title: function(){
                        return "{{ trans('new.title_user_list') }}"; // #translate
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                },
                ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: false,

            //"ordering": false, disable column ordering 
            "paging": true, //disable pagination

            "order": [
            [0, 'asc']
            ],
            
            "lengthMenu": [
            [5, 10, 15, 20, 50],
                [5, 10, 15, 20, 50] // change per page values here
                ],
            // set the initial value
            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        }); 
            oTable.on('order.dt search.dt draw.dt', function () {
                var start = oTable.page.info().start;
                var info = oTable.page.info();
                oTable.column(0, {order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = start+i+1;
                });
            });
        }

        return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable();
        }
    };
}();

jQuery(document).ready(function() {
    TableDatatablesButtons.init();
});


</script>
@endsection