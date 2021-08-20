<?php

?>

@extends('layouts.app')
@section('after_styles')

<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<!-- <style>
tr td:last-child, tr td:first-child{
    width:1%;
    white-space:nowrap;
}
</style> -->

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cog font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('new.search_option') }} </span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body">

                <div class="row">
                    <div class="col-md-12 form">
                        <form method='get' action='' id='filter'>
                            <div id="search-form" class="form-horizontal">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label for="username" class="control-label col-md-4"> {{ trans('new.user_id') }}  :
                                            <span> &nbsp;&nbsp; </span>
                                        </label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" value="" name="username" id="username" value="{{ Request::has('username') ? Request::get('username') : '' }}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="transaction_code" class="control-label col-md-4"> {{ trans('new.transaction_code') }}  :
                                            <span> &nbsp;&nbsp; </span>
                                        </label>
                                        <div class="col-md-5">
                                            <select id="transaction_code" class="form-control" name="transaction_code">
                                                <option value="" selected disabled hidden>-- {{ __('new.please_choose') }} --</option>
                                                <option value="" >-- {{ __('new.please_choose') }} --</option>
                                                <option @if(Request::get('transaction_code') == 'T2') selected @endif value="T2">T2 - {{ __('new.agency_user') }}</option>
                                                <option @if(Request::get('transaction_code') == 'T7') selected @endif value="T7">T7 - {{ __('new.public_user') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="requested_at" class="control-label col-md-4"> {{ trans('new.request_datetime') }}  :
                                            <span> &nbsp;&nbsp; </span>
                                        </label>
                                        <div class="col-md-5">
                                            <div class="input-group date form_datetime bs-datetime" >
                                                <input name='requested_at' type="text" size="16"  value="{{ Request::has('hearing_date') ? Request::get('hearing_date') : '' }}" class="form-control">
                                                <span class="input-group-addon">
                                                    <button class="btn default date-set" type="button" >
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="requested_ic" class="control-label col-md-4"> {{ trans('new.search_nric') }}  :
                                            <span> &nbsp;&nbsp; </span>
                                        </label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" value="" name="requested_ic" id="requested_ic" value="{{ Request::has('requested_ic') ? Request::get('requested_ic') : '' }}"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="replied_at" class="control-label col-md-4"> {{ trans('new.reply_datetime') }} :
                                            <span> &nbsp;&nbsp; </span>
                                        </label>
                                        <div class="col-md-5">
                                            <div class="input-group date form_datetime bs-datetime">
                                                <input name='replied_at' type="text" size="16"  value="{{ Request::has('hearing_date') ? Request::get('hearing_date') : '' }}" class="form-control">
                                                <span class="input-group-addon">
                                                    <button class="btn default date-set" type="button" >
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="reply_indicator" class="control-label col-md-4"> {{ trans('new.reply_indicator') }} :
                                            <span> &nbsp;&nbsp; </span>
                                        </label>
                                        <div class="col-md-5">
                                            <select id="reply_indicator" class="form-control" name="reply_indicator">
                                                <option value="" selected disabled hidden>-- {{ __('new.please_choose') }} --</option>
                                                <option value="" selected="">-- {{ __('new.please_choose') }} --</option>
                                                <option @if(Request::get('reply_indicator') == 1) selected @endif value="1">0 - {{ __('new.error') }}</option>
                                                <option @if(Request::get('reply_indicator') == 2) selected @endif value="2">1 - {{ __('new.successful') }}</option>
                                                <option @if(Request::get('reply_indicator') == 3) selected @endif value="3">2 - {{ __('new.alert') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="status" class="control-label col-md-4"> {{ trans('new.complaint_status') }} :
                                            <span> &nbsp;&nbsp; </span>
                                        </label>
                                        <div class="col-md-5">
                                            <select id="status" class="form-control" name="status">
                                                <option value="" selected disabled hidden>-- {{ __('new.please_choose') }} --</option>
                                                <option value="" >-- {{ __('new.please_choose') }} --</option>
                                                <option @if(Request::get('status') == 1) selected @endif value="1">1 - {{ __('new.citizen') }}</option>
                                                <option @if(Request::get('status') == 2) selected @endif value="2">2 - {{ __('new.permanent_resident') }} </option>
                                                <option @if(Request::get('status') == 3) selected @endif value="3">3 - {{ __('new.non_citizen') }}</option>
                                                <option @if(Request::get('status') == 4) selected @endif value="4">4 - {{ __('new.name_ic') }}</option>
                                                <option @if(Request::get('status') == 5) selected @endif value="5">5 - {{ __('new.ic_invalid') }}</option>
                                                <option @if(Request::get('status') == 6) selected @endif value="6">6 - {{ __('new.passed_away') }}</option>
                                                <option @if(Request::get('status') == 7) selected @endif value="7">7 - {{ __('new.technical_prob') }}</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="form-group" style="text-align: center;">
                                        
                                        <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cog font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('new.myidentity_log') }} </span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body">
                <table id="myidentity" class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <th>{{ __('new.no') }}</th>
                        <th>{{ __('new.ip_address') }}</th>
                        <th>{{ __('new.agency_code') }}</th>
                        <th>{{ __('new.branch_code') }}</th>
                        <th>{{ __('new.user_id') }}</th>
                        <th>{!! __('new.list_transaction_code') !!}</th>
                        <th>{!! __('new.list_request_datetime') !!}</th>
                        <th>{{ __('new.search_nric') }}</th>
                        <th>{!! __('new.list_request_indicator') !!}</th>
                        <th>{!! __('new.list_reply_datetime') !!}</th>
                        <th>{!! __('new.list_reply_indicator') !!}</th>
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
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

$(".form_datetime").datetimepicker({format: 'dd/mm/yyyy hh:ii P'});
var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#myidentity');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{!! Request::fullUrl() !!}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                 // {data: 'rownum'},
                { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                { data: "ip_address", name:"ip_address", 'orderable' : true},
                { data: "agency_code", name:"agency_code", 'orderable' : true},
                { data: "branch_code", name:"branch_code", 'orderable' : false},
                { data: "username", name:"username", 'orderable' : false},
                { data: "transaction_code", name:"transaction_code", 'orderable' : false, 'render': function ( data, type, full ) {
                    return $("<div/>").html(data).text(); 
                }},
                { data: "requested_at", name:"requested_at", 'orderable' : false},
                { data: "requested_ic", name:"requested_ic", 'orderable' : false},
                { data: "request_indicator", name:"request_indicator", 'orderable' : false, 'render': function ( data, type, full ) {
                    return $("<div/>").html(data).text(); 
                }},
                { data: "replied_at", name:"replied_at", 'orderable' : false},
                { data: "reply_indicator", name:"reply_indicator", 'orderable' : false, 'render': function ( data, type, full ) {
                    return $("<div/>").html(data).text(); 
                }},
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

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},


            buttons: [
                {
                    extend: 'print',
                    className: 'btn dark btn-outline',
                    title: function(){
                        return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ trans('new.myidentity_log') }}</span>"; // #translate
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                    customize: function ( win ) {
                        // Style the body..
                        $( win.document.body ).css( 'background-color', '#FFFFFF' );

                        $( win.document.body ).find('thead').css( 'background-color', '#DDDDDD' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );

                        win.document.title = "{{ trans('form1.form1_list') }}";

                        $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} '+moment().format("DD/MM/YYYY h:MM A")+'</footer>');                    },
                    exportOptions: {
                        columns: [0,1,2,3,4,5,6,7,8,9,10]
                    },
                },
                // { extend: 'copy', className: 'btn red btn-outline', text:'<i class="fa fa-files-o margin-right-5"></i>Copy' },
                // { extend: 'pdf', className: 'btn green btn-outline', text:'<i class="fa fa-file-pdf-o margin-right-5"></i>PDF' },
                // { extend: 'excel', className: 'btn yellow btn-outline', text:'<i class="fa fa-file-excel-o margin-right-5"></i>Excel' },
                // { extend: 'csv', className: 'btn purple btn-outline', text:'<i class="fa fa-file-excel-o margin-right-5"></i>CSV' },
                // { extend: 'colvis', className: 'btn dark btn-outline', text: '<i class="fa fa-columns margin-right-5"></i>Columns'}
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

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        }); 
        oTable.on('order.dt search.dt draw.dt', function () {
            var start = oTable.page.info().start;
            var info = oTable.page.info();
            oTable.column(0, {order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = start+i+1;
                oTable.cell(cell).invalidate('dom');
            } );
        } ).draw();
    }

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }
            initTable1();
        }
    };
}();

jQuery(document).ready(function() {
    TableDatatablesButtons.init();
});

</script>

@endsection