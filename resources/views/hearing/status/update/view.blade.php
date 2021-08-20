<?php
$locale = App::getLocale();
$status_lang = "hearing_status_".$locale;
$position_lang = "hearing_position_".$locale;

?>

@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<style>

    .control-label-custom  {
        padding-top: 0px !important;
    }

</style>
@endsection

@section('content')
<div class="row margin-top-10">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase"> {{$form4->case->case_no}} | 
                        <small style="font-weight: normal;"> {{ date('d/m/Y', strtotime($form4->case->form1->filing_date." 00:00:00")) }} </small>
                    </span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-horizontal form-bordered ">
                    <div class="form-body row">
                        <div class="form-group col-md-6" style="display: flex;">
                            <div class="control-label control-label-custom col-xs-5">{{ __('new.claimant_name')}}</div>
                            <div class="col-xs-7 font-green-sharp" style="align-items: stretch;">
                                <span style='font-weight: bold'>{{ $form4->case->claimant_address->name }}</span><br>(<small>{{ $form4->case->claimant_address->identification_no }}</small>)
                            </div>
                        </div>
                        <div class="form-group col-md-6" style="display: flex;">
                            <div class="control-label control-label-custom col-xs-5">{{ __('new.opponent_name')}}</div>
                            <div class="col-xs-7 font-green-sharp" style="align-items: stretch;">
                                @if(!$form4->claimCaseOpponent)
                                @else
                                    <span style='font-weight: bold'>{{ $form4->claimCaseOpponent->opponent_address->name }}</span><br>(<small>{{ $form4->claimCaseOpponent->opponent_address->identification_no }}</small>)
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-list"></i>
                    <span class="caption-subject bold uppercase">{{ __('hearing.hearing_list')}}</span>
                </div>
            </div>
            <div class="portlet-body">
                <table id="hearing_status" class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th width="3%">{{ trans('new.no') }}</th>
                            <th>{{ trans('hearing.hearing_date') }}</th>
                            <th>{{ trans('new.status') }}</th>
                            <th>{{ trans('new.position') }}</th>
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
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
<!--end sweetalert -->
<script type="text/javascript">

function updateModal(id){
    $("#modalDiv").load("{{ url('hearing/status/update/modal') }}/"+id);
}

var TableDatatablesButtons = function () {

    var initTable = function () {
        var table = $('#hearing_status');

        var oTable = table.DataTable({
            "processing": true,
            // "serverSide": true,
            "ajax": "{!! Request::fullUrl() !!}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                { data: null, 'orderable' : false, 'searchable' : false},
                { data: "hearing_date", name:"hearing.hearing_date"},
                { data: "status", name:"hearing_status.hearing_status_{{ App::getLocale() }}"},
                { data: "position", name:"hearing_position.hearing_position_{{ App::getLocale() }}"},
                { data: "action", name:"action", 'orderable' : false, 'searchable' : false},
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

            // buttons: [
            //     {
            //         extend: 'print',
            //         className: 'btn dark btn-outline',
            //         title: function(){
            //             return "{{ trans('new.title_user_list') }}"; // #translate
            //         },
            //         text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
            //     },
            // ],

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

            "dom": "<'row' <'col-md-12'>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
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