<?php
$locale = App::getLocale();
$status_lang = "form_status_desc_".$locale;
?>

@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<style>
.nowrap {
    white-space: nowrap;
}
.data table, .data tr, .data td{
    border: 1px solid ;
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
                    <span class="caption-subject bold uppercase">{{ trans('menu.attendance') }}</span>
                </div>
                <div class="tools"> </div>
            </div>
            <div class="" style="margin-bottom: 20px;">
                <form method='get' action=''>
                    <div id="search-form" class="form-inline">
                        <div class="form-group mb10">
                            <label for="hearing_date">{{ __('new.at')}}</label>
                            <div class="input-group date date-picker" data-date-format="dd/mm/yyyy" style="margin-right: 10px;"> 
                                <input type="text" class="form-control" name="hearing_date" id="hearing_date" value="{{ Request::get('hearing_date') }}" />
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
                                <option value="" selected disabled hidden>-- {{ __('form1.all_branch') }} --</option>
                                <!-- <option value="" >-- {{ __('form1.all_branch') }} --</option> -->
                                @foreach($branches as $i=>$branch)
                                <option @if(Request::get('branch') == $branch->branch_id) selected @endif value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb10">
                            <label for="hearing_venue_id">{{ __('new.place_hearing') }}</label>
                            <select id="hearing_venue_id" class="form-control" name="hearingplace" style="margin-right: 10px;">
                                <option value="" selected disabled hidden>-- {{ __('new.all_places') }} --</option>
                                <option value="" >-- {{ __('new.all_places') }} --</option>
                            </select>
                        </div>
                        <br class='hidden-xs hidden-sm'>
                        <div class="form-group mb10">
                            <label for="hearing_room_id">{{ __('hearing.hearing_room') }}</label>
                            <select id="hearing_room_id" class="form-control" name="hearingRoom" style="margin-right: 10px;">
                                <option value="" selected disabled hidden>-- {{ __('new.all_rooms') }} --</option>
                                <option value="" >-- {{ __('new.all_rooms') }} --</option>
                            </select>
                        </div>
                        <div class="form-group mb10">
                            <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <table id="attendance" class="table table-striped table-bordered table-hover table-responsive mt5" width="100%">
                <thead>
                    <tr>
                        <th width="2%">{{ __('new.no')}}</th>
                        <th>{{ __('new.details_claim')}}</th>
                    </tr>
                </thead>
            </table>
        </div>   
    </div>
</div>


<div class="modal fade bs-modal-lg" id="modalperanan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ __('new.print_minutes')}}</h4>
            </div>
            <div class="modal-body" id="modalbodyperanan">
                <div style="text-align: center;"><div class="loader"></div></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
                <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.submit') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="setAttendance" class="modal fade modal-lg" role="dialog" style="width: 100%;">
  <div class="modal-dialog" style="width: 1000px; max-width: 100%;">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{ __('new.set_attendance') }} </h4>
        </div>
        <div class="modal-body">
            <div style="text-align: center;"><div class="loader"></div></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
            <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.submit') }}</button>
        </div>
    </div>

  </div>
</div>

@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
<!--end sweetalert -->
<script type="text/javascript">

$('#setAttendance').on('hidden.bs.modal', function() {
    $('#setAttendance .modal-body').html('<div style="text-align: center;"><div class="loader"></div></div>');
});

$('body').on('click', '.btnModalPeranan', function(){
    $('#modalperanan').modal('show')
        .find('#modalbodyperanan')
        .load($(this).attr('value'));
});
$('#modalperanan').on('hidden.bs.modal', function(){
    $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>');
});

function setAttendance(id) {
    $("#modalDiv").load("{{ route('listing.attendance') }}/"+id+"/set");
}


var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#attendance');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": true, //change this later
            "ajax": "{!! Request::fullUrl() !!}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                { data: "claim_details", name:"claim_details",  'orderable' : false, 'searchable' : false, 'render': function ( data, type, full ) {
                    return $("<div/>").html(data).text(); 
                }},
                // { data: 'case.case_no', name: 'case.case_no', 'orderable' : false, 'hidden' : true},
                // { data: 'case.claimant_address.name', name: 'case.claimant_address.name', 'orderable' : false, 'hidden' : true},
                // { data: 'case.opponent_address.name', name: 'case.opponent_address.name', 'orderable' : false, 'hidden' : true},
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


            buttons: [],

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


function processAttendance(id) {
    $("#modalDiv").load("{{ url('/listing') }}/attendance/"+id+"/process");
}

function clearRow(btn) {
    var row = $(btn).parent().parent();

    row.find("input").val(null);
    row.find("select").val(null).trigger('change');
}

function submitForm(btn) {
    var form = $(btn).parents("form");

    //form.submit();

    $.ajax({
        url: form.attr('action'),
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: form.attr('method'),
        data: form.serialize(),
        datatype: 'json',
        async: false,
        success: function(data){
            if(data.result == "Success") {

                swal({
                    title: "{{ __('swal.success')}}",
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true
                },
                function(){
                    // swal({
                    //     text: "{{ trans('swal.reload') }}..",
                    //     showConfirmButton: false
                    // });
                    // location.reload();
                });

            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            swal("{{ trans('swal.unexpected_error') }}!", thrownError, "error");
            //alert(thrownError);
        }
    });


    //console.log('form submit');
}

function checkMyIdentity(item){

    var ic = $(item).next().val();

    if( ic=="" )
        return;

    console.log(ic);

    $("#modalDiv").load("{{ route('integration-myidentity-full', ['ic' => '']) }}/"+ic);
}

var data = null;

$('#branch_id').on('change', function(){
    var branch_id = $('#branch_id').val();

    if(branch_id == '') {
        $('#hearing_venue_id').html("<option disabled selected>-- {{ __('new.all_places') }} --</option>");
        $('#hearing_room_id').html("<option disabled selected>-- {{ __('new.all_rooms') }} --</option>");
        return;
    }

    $.ajax({
        url: "{{ url('/') }}/branch/"+branch_id+"/venues",
        type: 'GET',
        async:false,
        success: function (res) {

            data = res;

            $('#hearing_venue_id').empty();
            $('#hearing_room_id').empty();
            $('#hearing_venue_id').append("<option disabled selected>---</option>");
            $.each(data.venues, function(key, venue) {
                if(venue.is_active == 1)
                    $('#hearing_venue_id').append("<option key='"+key+"' value='" + venue.hearing_venue_id +"'>" + venue.hearing_venue + "</option>");
            });

        }
    });
});

$('#hearing_venue_id').on('change', function(){
    hearing_venue_id = $('#hearing_venue_id option:selected').attr("key");

    //console.log(data.branches[branch_id].venues[hearing_venue_id]);

    $('#hearing_room_id').empty();
    $('#hearing_room_id').append("<option disabled selected>---</option>");
    $.each(data.venues[hearing_venue_id].rooms, function(key, room) {
        if(room.is_active == 1)
            $('#hearing_room_id').append("<option key='"+key+"' value='" + room.hearing_room_id +"'>" + room.hearing_room + "</option>");
    });
    
});

@if(Request::has('branch') == $branch->branch_id)
    $("#branch_id").val({{ Request::get('branch') }}).trigger('change');
@endif

@if(Request::has('hearingplace') == $branch->branch_id)
    $("#hearing_venue_id").val({{ Request::get('hearingplace') }}).trigger('change');
@endif

@if(Request::has('hearingRoom') == $branch->branch_id)
    $("#hearing_room_id").val({{ Request::get('hearingRoom') }}).trigger('change');
@endif

// function submitAttendance(){



//     $.ajax({
//         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
//         url: "{{ route('listing.attendance') }}",
//         type: 'POST',
//         data: $('form').serialize(),
//         datatype: 'json',
//         async: false,
//         success: function(data){
//             if(data.result == "Success") {

//                 swal({
//                     title: "{{ __('swal.success')}}",
//                     text: "",
//                     type: "success",
//                     showCancelButton: false,
//                     closeOnConfirm: true
//                 },
//                 function(){
//                     swal({
//                         text: "{{ trans('swal.reload') }}..",
//                         showConfirmButton: false
//                     });
//                     location.reload();
//                 });

//             } else {
//                 var inputError = [];

//                 console.log(Object.keys(data.message)[0]);
//                 if($("input[name='"+Object.keys(data.message)[0]+"']").is(':radio') || $("input[name='"+Object.keys(data.message)[0]+"']").is(':checkbox')){
//                     var input = $("input[name='"+Object.keys(data.message)[0]+"']");
//                 } else {
//                     var input = $('#'+Object.keys(data.message)[0]);
//                 }

//                 $('html,body').animate(
//                     {scrollTop: input.offset().top - 100},
//                     'slow', function() {
//                         //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
//                         input.focus();
//                     }
//                 );

//                 $.each(data.message,function(key, data){
//                     if($("input[name='"+key+"']").is(':radio') || $("input[name='"+key+"']").is(':checkbox')){
//                         var input = $("input[name='"+key+"']");
//                     } else {
//                         var input = $('#'+key);
//                     }
//                     var parent = input.parents('.form-group');
//                     parent.removeClass('has-success');
//                     parent.addClass('has-error');
//                     parent.find('.help-block').html(data[0]);
//                     inputError.push(key);
//                 });

//                 $.each(form.serializeArray(), function(i, field) {
//                     if ($.inArray(field.name, inputError) === -1)
//                     {
//                         if($("input[name='"+field.name+"']").is(':radio') || $("input[name='"+field.name+"']").is(':checkbox')){
//                             var input = $("input[name='"+field.name+"']");
//                         } else {
//                             var input = $('#'+field.name);
//                         }
//                         var parent = input.parents('.form-group');
//                         parent.removeClass('has-error');
//                         parent.addClass('has-success');
//                         parent.find('.help-block').html('');
//                     }
//                 });
//             }
//         },
//         error: function(xhr, ajaxOptions, thrownError){
//             swal("{{ trans('swal.unexpected_error') }}!", thrownError, "error");
//             //alert(thrownError);
//         }
//     });

//     return false;
// }

</script>


@endsection
