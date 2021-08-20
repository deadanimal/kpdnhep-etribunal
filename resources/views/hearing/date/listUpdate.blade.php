<?php
$locale = App::getLocale();
$month_lang = "month_".$locale;
?>
@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<style>
.fit {
    white-space: nowrap;
    width: 1%;
    text-align: center;
}
</style>
@endsection

@section('content')

<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-dark">
            <i class="fa fa-list"></i>
            <span class="caption-subject bold uppercase">
                @if(strpos(Request::url(),'update') !== false) 
                    {{ __('menu.update_hearing_date')}}
                @else
                    {{ __('menu.reset_hearing_date')}}
                @endif

            </span>
        </div>
        <div class="tools"> </div>
    </div>
    <div style="margin-bottom: 20px;">
        <form method='get' action=''>
            <div id="search-form" class="form-inline">
                <div class="form-group mb10">
                    <label for="branch">{{ trans('hearing.branch') }}</label>
                    <select id="branch" class="form-control" name="branch" style="margin-right: 10px;">
                        <option value="" selected disabled hidden>-- {{ __('form1.all_branch') }} --</option>
                        <option value="0" >-- {{ __('form1.all_branch') }} --</option>
                        @foreach($branches as $i=>$branch)
                        <option @if(Request::get('branch') == $branch->branch_id) selected @endif value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb10">
                    <label for="hearing_date">{{ __('hearing.hearing_date')}}</label>
                    <div class="input-group date date-picker" data-date-format="dd/mm/yyyy" style="margin-right: 10px;"> 
                        <input type="text" class="form-control" name="hearing_date" id="hearing_date" value="{{ Request::get('hearing_date') }}" />
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>      <!-- REQUEST TO DISPLAY ON WHAT WE SELECT -->
                    </div>
                </div>
                @if(strpos(Request::url(),'update') !== false)
                <br class='hidden-xs hidden-sm'>
                <div class="form-group mb10">
                    <label for="year">{{ trans('hearing.year') }} </label>
                    <select id="year" class="form-control" name="year" style="margin-right: 10px;">
                        <option value="" selected disabled hidden>-- {{ __('form1.all_year') }} --</option>
                        <option value="" >-- {{ __('form1.all_year') }} --</option>
                        @foreach($years as $i=>$year)
                        <option @if(Request::get('year') == $year) selected @endif value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb10">
                    <label for="month">{{ trans('hearing.month') }}</label>
                    <select id="month" class="form-control" name="month" style="margin-right: 10px;">
                        <option value="" selected disabled hidden>-- {{ __('form1.all_month') }} --</option>
                        <option value="" >-- {{ __('form1.all_month') }} --</option>
                        @foreach($months as $i=>$month)
                        <option @if(Request::get('month') == $month->month_id) selected @endif value="{{ $month->month_id }}">{{ $month->$month_lang }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group mb10" style="margin-left: 5px;">
                    <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="portlet-body">
        <table class="table table-striped table-bordered table-hover table-responsive table-checkable order-column" id="update">
            <thead>
                <tr>
                    <th style='white-space: nowrap;width: 1%;'>
                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                            <input onchange="checkAll(this)" id='checkHeader' type="checkbox" class="group-checkable" data-set="#update .checkboxes" />
                            <span></span>
                        </label>
                    </th>
                    <th>{{ trans('hearing.no')}}</th>
                    <th>{{ trans('hearing.claim_no')}}</th>
                    <th>{{ trans('hearing.claimant_name')}}</th>
                    <th>{{ trans('hearing.hearing_date')}}</th>
                    <th>{{ trans('master.hearing_venue')}}</th>
                    <th>{{ trans('hearing.hearing_room')}}</th>
                    <th>{{ trans('new.president_name')}}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- BEGIN QUICK NAV -->
<nav class="quick-nav hidden">
    <a class="quick-nav-trigger" href="javascript:;">
        <span aria-hidden="true"></span>
    </a>
    <ul>
        @if(strpos(Request::url(),'update') !== false)
        <li>
            <a href="javascript:;" data-toggle="modal" data-target="#modalNewDate" class="active">
                <span>{{ __('button.update')}}</span>
                <i class="fa fa-check"></i>
            </a>
        </li>

        @else
        <li>
            <a href="javascript:;" data-toggle="modal" data-target="#modalNewDate" class="active">
                <span>{{ __('button.reset')}}</span>
                <i class="fa fa-check"></i>
            </a>
        </li>
        @endif
    </ul>
    <span aria-hidden="true" class="quick-nav-bg"></span>
</nav>
<div class="quick-nav-overlay"></div>
<!-- END QUICK NAV -->


<!-- Modal -->
<div id="modalNewDate" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ __('new.new_hearing_date')}}</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-body">

                        <div class="form-group form-md-line-input">
                            <label for="psu" id="row_claim_offence" class="control-label col-md-5">{{ trans('hearing.state') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select onchange='getHearingDate()' required class="form-control select2" id="state_id" name="state_id" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach($states as $i=>$state)
                                    <option value="{{ $state->state_id }}">{{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="form-group form-md-line-input">
                            <label for="psu" id="row_claim_offence" class="control-label col-md-5">{{ trans('hearing.ttpm_branch') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select onchange='getHearingDate()' required class="form-control select2" id="branch_id" name="branch_id" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label for="psu" id="row_claim_offence" class="control-label col-md-5">{{ trans('hearing.place_hearing') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required class="form-control select2" id="hearing_venue_id" name="hearing_venue_id" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label for="psu" id="row_claim_offence" class="control-label col-md-5">{{ trans('hearing.hearing_room') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required class="form-control select2" id="hearing_room_id" name="hearing_room_id" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label for="psu" id="row_claim_offence" class="control-label col-md-5">{{ trans('hearing.hearing_date') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <select required class="form-control select2" id="hearing_id" name="hearing_id" data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        @if(strpos(Request::url(),'reset') !== false)
                        <div class="form-group form-md-line-input">
                            <label for="psu" id="row_claim_offence" class="control-label col-md-5">{{ trans('hearing.reset_reason') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                <textarea id="reason" name="reason" class="form-control" rows="5"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        @endif

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('button.close')}}</button>
                <button type="button" class="btn btn-primary"
                @if(strpos(Request::url(),'update') !== false)
                onclick='submitUpdate()'
                @else
                onclick='submitReset()'
                @endif
                >{{ __('button.submit')}}</button>
            </div>
        </div>

    </div>
</div>


@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{URL::to('/assets/pages/scripts/table-datatables-managed.min.js')}}" type="text/javascript"></script>

<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
<!--end sweetalert -->
<script type="text/javascript">
$('body').on('click', '.btnModalPeranan', function(){
    $('#modalperanan').modal('show')
        .find('#modalbodyperanan')
        .load($(this).attr('value'));
});
$('#modalperanan').on('hidden.bs.modal', function(){
    $('#modalbodyperanan').html('');
});
</script>
<script type="text/javascript">
var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#update');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{!! Request::fullUrl() !!}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                { data: 'checkbox', defaultContent: '', 'orderable' : false, 'searchable' : false, 'render': function ( data, type, full ) {
                    return $("<div/>").html(data).text(); 
                }},
                { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                { data: "case_no", name:"case.case_no"},
                { data: "claimant_name", name:"case.claimant.name"},
                { data: "hearing_date", name:"hearing.hearing_date"},
                { data: "hearing_venue", name:"hearing.hearing_room.venue.hearing_venue"},
                { data: "hearing_room", name:"hearing.hearing_room.hearing_room"},
                { data: "president_name", name:"president.name"},
            ],
            "columnDefs": [
                { className: "fit", "targets": [ 0 ] }
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
                        return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ trans('form1.hearing_date_list') }}</span>"; // #translate
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
                        columns: [1,2,3,4]
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
                [1, 'asc']
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
            oTable.column(1, {order:'applied'}).nodes().each( function (cell, i) {
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


function checkAll(item) {
    $(".checkboxes").prop('checked', $("#checkHeader:checked").length > 0);
    updateSelection()
}

function updateSelection(){
    var selection = $("input[name='selectedF4']:checked").map(function(){
        return this.value;
    }).get();

    var count = selection.length;

    if(count > 0)
        $("nav").removeClass("hidden");
    else
        $("nav").addClass("hidden");
    
    //alert(selection.join(','));
}

function getHearingDate() {

}

$('#state_id').on('change', function(){
    var state_id = $('#state_id').val();

    $.ajax({
        url: "{{ url('/') }}/state/"+state_id+"/hearings",
        type: 'GET',
        async:false,
        success: function (res) {

            data = res;

            $('#branch_id').empty();
            $('#hearing_venue_id').empty();
            $('#hearing_room_id').empty();
            $('#hearing_id').empty();
            $('#branch_id').append("<option disabled selected>---</option>");
            $.each(data.branches, function(key, branch) {
                if(branch.is_active == 1)
                    $('#branch_id').append("<option key='"+key+"' value='" + branch.branch_id +"'>" + branch.branch_name + "</option>");
            });

        }
    });
});

$('#branch_id').on('change', function(){
    branch_id = $('#branch_id option:selected').attr("key");

    //console.log(data.branches[branch_id].venues);

    $('#hearing_venue_id').empty();
    $('#hearing_room_id').empty();
    $('#hearing_id').empty();
    $('#hearing_venue_id').append("<option disabled selected>---</option>");
    $.each(data.branches[branch_id].venues, function(key, venue) {
        if(venue.is_active == 1)
            $('#hearing_venue_id').append("<option key='"+key+"' value='" + venue.hearing_venue_id +"'>" + venue.hearing_venue + "</option>");
    });
    
});

$('#hearing_venue_id').on('change', function(){
    branch_id = $('#branch_id option:selected').attr("key");
    hearing_venue_id = $('#hearing_venue_id option:selected').attr("key");

    //console.log(data.branches[branch_id].venues[hearing_venue_id]);

    $('#hearing_room_id').empty();
    $('#hearing_id').empty();
    $('#hearing_room_id').append("<option disabled selected>---</option>");
    $.each(data.branches[branch_id].venues[hearing_venue_id].rooms, function(key, room) {
        if(room.is_active == 1)
            $('#hearing_room_id').append("<option key='"+key+"' value='" + room.hearing_room_id +"'>" + room.hearing_room + "</option>");
    });
    
});

$('#hearing_room_id').on('change', function(){
    branch_id = $('#branch_id option:selected').attr("key");
    hearing_venue_id = $('#hearing_venue_id option:selected').attr("key");
    hearing_room_id = $('#hearing_room_id option:selected').attr("key");

    //console.log(data.branches[branch_id].venues[hearing_venue_id]);

    $('#hearing_id').empty();
    $('#hearing_id').append("<option disabled selected>---</option>");
    $.each(data.branches[branch_id].venues[hearing_venue_id].rooms[hearing_room_id].hearings, function(key, hearing) {
        // var now = new Date();
        // var expired = new Date(hearing.hearing_date);
        // if (now.getTime() <= expired.getTime()) {
        //     $('#hearing_id').append("<option value='" + hearing.hearing_id +"'>" + hearing.hearing_date + " " + hearing.hearing_time + "</option>");
        // }

        var dates = hearing.hearing_date.split("/");
        var month = parseInt(dates[1]);
        var year = parseInt(dates[2]);
        var date = parseInt(dates[0]);
        var now = new Date(year+"-"+month+"-"+date);
        var expired = new Date("{{ date('Y-m-d') }}");
        expired.setDate(expired.getDate() - 1);

        if (now.getTime() < expired.getTime()) {
            console.log("ignored");
            return;
        }
        $('#hearing_id').append("<option value='" + hearing.hearing_id +"'>" + hearing.hearing_date + " " + hearing.hearing_time + "</option>");

    });
    
});

@if(strpos(Request::url(),'update') !== false)
function submitUpdate() {

    var selection = $("input[name='selectedF4']:checked").map(function(){
        return this.value;
    }).get();

    var hearing_id = $('#hearing_id').val();
    var hearing_venue_id = $('#hearing_venue_id').val();
    var transfer_branch_id = $('#branch_id').val();

    $.ajax({
        url: "{{ route('hearing-update-submit') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {
            hearing_id: hearing_id,
            hearing_venue_id: hearing_venue_id,
            transfer_branch_id : transfer_branch_id,
            selectedF4: selection.join(',')
        },
        datatype: 'json',
        success: function(data){
            if(data.status=='ok'){
                $("#modalNewDate").modal("hide");
                swal({
                    title: "{{ __('new.success') }}",
                    text: data.message, 
                    type: "success"
                },
                function () {
                    location.reload();
                });
            } else {
                var inputError = [];

                console.log(Object.keys(data.message)[0]);
                if($("input[name='"+Object.keys(data.message)[0]+"']").is(':radio') || $("input[name='"+Object.keys(data.message)[0]+"']").is(':checkbox')){
                    var input = $("input[name='"+Object.keys(data.message)[0]+"']");
                } else {
                    var input = $('#'+Object.keys(data.message)[0]);
                }

                $('html,body').animate(
                    {scrollTop: input.offset().top - 100},
                    'slow', function() {
                        //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                        input.focus();
                    }
                );

                $('.form-group').removeClass('has-error');

                $.each(data.message,function(key, data){
                    if($("input[name='"+key+"']").is(':radio') || $("input[name='"+key+"']").is(':checkbox')){
                        var input = $("input[name='"+key+"']");
                    } else {
                        var input = $('#'+key);
                    }
                    
                    var parent = input.parents('.form-group');
                    parent.removeClass('has-success');
                    parent.addClass('has-error');
                    parent.find('.help-block').html(data[0]);
                    inputError.push(key);
                });
            }
        },
        error: function(data){
            console.log(xhr.status);
        }
    });
}
@else
function submitReset() {

    var selection = $("input[name='selectedF4']:checked").map(function(){
        return this.value;
    }).get();

    var hearing_id = $('#hearing_id').val();
    var reset_reason = $('#reason').val();

    $.ajax({
        url: "{{ route('hearing-reset-submit') }}",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'POST',
        data: {
            hearing_id: hearing_id,
            reason: reset_reason,
            selectedF4: selection.join(',')
        },
        datatype: 'json',
        success: function(data){
            if(data.status=='ok'){
                $("#modalNewDate").modal("hide");
                swal({
                    title: "{{ __('new.success') }}",
                    text: data.message, 
                    type: "success"
                },
                function () {
                    location.reload();
                });
            } else {
                var inputError = [];

                console.log(Object.keys(data.message)[0]);
                if($("input[name='"+Object.keys(data.message)[0]+"']").is(':radio') || $("input[name='"+Object.keys(data.message)[0]+"']").is(':checkbox')){
                    var input = $("input[name='"+Object.keys(data.message)[0]+"']");
                } else {
                    var input = $('#'+Object.keys(data.message)[0]);
                }

                $('html,body').animate(
                    {scrollTop: input.offset().top - 100},
                    'slow', function() {
                        //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                        input.focus();
                    }
                );

                $('.form-group').removeClass('has-error');

                $.each(data.message,function(key, data){
                    if($("input[name='"+key+"']").is(':radio') || $("input[name='"+key+"']").is(':checkbox')){
                        var input = $("input[name='"+key+"']");
                    } else {
                        var input = $('#'+key);
                    }
                    
                    var parent = input.parents('.form-group');
                    parent.removeClass('has-success');
                    parent.addClass('has-error');
                    parent.find('.help-block').html(data[0]);
                    inputError.push(key);
                });
            }
        },
        error: function(data){
            console.log(xhr.status);
        }
    });
}
@endif
</script>

@endsection