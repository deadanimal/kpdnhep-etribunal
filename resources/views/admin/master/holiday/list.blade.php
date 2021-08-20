@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />

<style rel="stylesheet" type="text/css">
.btn-sm {
    padding: 5px 7px !important;
    width: 32px;
}
tr td:last-child, tr td:first-child{
    width:1%;
    white-space:nowrap;
}
.fit {
    width:1%;
    white-space:nowrap;
}
</style>
@endsection


@section('content')
<div class='row'>
    {{ Form::open(['route' => 'master.holiday.updateweekend', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
    <div class="col-md-5 col-md-push-7">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption font-green-sharp">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold uppercase"> {{ __('holiday.weekend_setting') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="form-body">
                    <div class="form-group form-md-line-input">
                        <label for="state" class="control-label col-md-4">{{ __('new.state') }} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-7">
                            <select onchange='updateData()' id="state" class="form-control select2 bs-select" name="state" style="margin-right: 10px;">
                                @foreach ($states as $i=>$state)
                                <option
                                @if($user->ttpm_data->branch->branch_state_id == $state->state_id)
                                    selected
                                @endif
                                value="{{ $state->state_id }}" index="{{ $i }}">{{ $state->state }}
                            </option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>
                    </div>
                </div>

                <div id="weekends" class="form-group form-md-line-input">
                    <label for="weekends" id="weekends" class="control-label col-md-4"> {{ __('holiday.weekends') }} :
                        <span class="required"> * </span>
                    </label>
                    <div class="col-md-7">
                        <div class="md-radio-inline">
                            <div class="md-radio">
                                <input id="yes" name="is_friday_weekend"  class="md-checkboxbtn" type="radio" value="1">
                                <label for="yes">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('holiday.friday_saturday') }}
                                </label>
                            </div>
                            <br>
                            <div class="md-radio">
                                <input id="no" name="is_friday_weekend"  class="md-checkboxbtn" type="radio" value="0">
                                <label for="no">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span> {{ __('holiday.saturday_sunday') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group form-md-line-input">
                    <div class="col-md-12">
                        <button id="btn_update" type="submit" class="btn green button-submit pull-right">{{ __('button.update') }}
                            <i class="fa fa-check"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END Portlet PORTLET-->
    </div>
    {{ Form::close() }}

    <div class="col-md-7 col-md-pull-5">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('holiday.holiday_control') }} </span>
                </div>
                <ul class="nav nav-tabs">
                    <li>
                        <a href="#tab_federal" data-toggle="tab"> {{ __('holiday.federal') }} </a>
                    </li>
                    <li class="active">
                        <a href="#tab_additional" data-toggle="tab"> {{ __('holiday.additional_holiday') }} </a>
                    </li>
                </ul>
            </div>
            <div class="portlet-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_additional">
                        <div>
                            <div style="margin-bottom: 20px;">
                                <form method='get' action=''>
                                    <div id="search-form" class="form-inline">
                                        <div class="form-group mb10">
                                            <label for="status">{{ trans('new.year') }}</label>
                                            <select class="form-control select2 bs-select" name="year" style="margin-right: 10px;">
                                                @foreach($years as $i=>$year)
                                                <option @if(Request::get('year') == $year) selected 
                                                @elseif ( $year == date('Y'))
                                                @endif value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb10">
                                            <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div style="text-align: right; margin-bottom: 10px;"> 
                             <button id="btn_add_additional" onclick="createAdditional()" class="btn green button-submit">{{ trans('button.add') }}
                                <i class="fa fa-plus margin-right-5"></i>
                                </button>
                            </div>
                            <table id="additional" class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <th width="3%">{{ trans('new.no') }}</th>
                                        <th>{{ trans('new.holiday') }}</th>
                                        <th>{{ trans('new.date') }}</th>
                                        <th>{{ trans('new.day') }}</th>
                                        <th>{{ trans('new.action') }}</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_federal">
                        <div>
                            <div style="margin-bottom: 20px;">
                                <form method='get' action=''>
                                    <div id="search-form" class="form-inline">
                                        <div class="form-group mb10">
                                            <label for="status">{{ trans('new.year') }}</label>
                                            <select class="form-control select2 bs-select" name="year" style="margin-right: 10px;">
                                                @foreach($years as $i=>$year)
                                                <option @if(Request::get('year') == $year) selected 
                                                @elseif ( $year == date('Y'))
                                                @endif value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb10">
                                            <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div style="text-align: right; margin-bottom: 10px;"> 
                                @if(Auth::user()->hasRole('admin'))
                               <button id="btn_add_additional" onclick="createFederal()" class="btn green button-submit">{{ trans('button.add') }}
                                    <i class="fa fa-plus margin-right-5"></i>
                                </button>
                                @endif
                            </div>
                            <table id="federal" class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                    <tr>
                                        <th width="3%">{{ trans('new.no') }}</th>
                                        <th>{{ trans('new.holiday') }}</th>
                                        <th>{{ trans('new.date') }}</th>
                                        <th>{{ trans('new.day') }}</th>
                                        <th>{{ trans('new.action') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('after_scripts')
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<!--sweetalert -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>

<script>

    // $("#state").val({{ $user->ttpm_data->branch->branch_state_id }}).trigger('change');

    @if($user->ttpm_data->branch->state->is_friday_weekend == 1)
        $("#yes").prop("checked", true);
    @else
        $("#no").prop("checked", true);
    @endif


    var data = [];
    @foreach($states as $state)
        data.push({{ $state->is_friday_weekend }});
    @endforeach

    function updateData() {
        var state = $("#state option:selected").attr("index");

        //console.log(data[state]);

        if(data[state] == 1)
            $("#yes").prop("checked", true);
        else
            $("#no").prop("checked", true);

    }


    $("#submitForm").submit(function(e){

        e.preventDefault();
        var form = $(this);
        var data = new FormData(form[0]);

        $.ajax({
            url: form.attr('action'),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: form.attr('method'),
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,
            async: true,
            beforeSend: function() {
                
            },
            success: function(data) {
                if(data.status=='ok'){
                    swal({
                        title:"{{ __('new.success') }}",
                        text: "{{ __('swal.success') }}",
                        type: "success"
                    },
                    function () {
                        //location.href = "{{ route('home') }}";
                        location.href = "{{ route('master.holiday') }}";
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
                            swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                            input.focus();
                        }
                    );

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

                    $.each(form.serializeArray(), function(i, field) {
                        if ($.inArray(field.name, inputError) === -1)
                        {
                            if($("input[name='"+field.name+"']").is(':radio') || $("input[name='"+field.name+"']").is(':checkbox')){
                                var input = $("input[name='"+field.name+"']");
                            } else {
                                var input = $('#'+field.name);
                            }
                            var parent = input.parents('.form-group');
                            parent.removeClass('has-error');
                            parent.addClass('has-success');
                            parent.find('.help-block').html('');
                        }
                    });
                }
            },
            error: function(xhr){
                console.log(xhr.status);
            }
        });
        return false;
    });

    var TableDatatablesButtons1 = function () {

        var initTable1 = function () {
            var table = $('#federal');

            var oTable = table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{!! Request::has('year') ? route('master.holiday', ['table' => 1, 'year' => Request::get('year')]) : route('master.holiday', ['table' => 1]) !!}",
                "deferRender": true,
                "pagingType": "bootstrap_full_number",
                "columns": [
                     // {data: 'rownum'},
                    { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                    { data: "holiday", name: "holiday"},
                    { data: "date", name:"date"},
                    { data: "day", name:"day"},
                    { data: "action", name:"action", 'orderable' : false, 'searchable' : false},
                ],
                "columnDefs": [
                    //{ className: "nowrap", "targets": [ 5 ] }
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
                
                ],
                // Or you can use remote translation file
                //"language": {
                //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
                //},
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

    var TableDatatablesButtons2 = function () {

        var initTable1 = function () {
            var table = $('#additional');

            var oTable = table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{!! Request::has('year') ? route('master.holiday', ['table' => 0, 'year' => Request::get('year')]) : route('master.holiday', ['table' => 0]) !!}",
                "deferRender": true,
                "pagingType": "bootstrap_full_number",
                "columns": [
                     // {data: 'rownum'},
                    { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                    { data: "holiday", name: "holiday"},
                    { data: "date", name:"date"},
                    { data: "day", name:"day"},
                    { data: "action", name:"action", 'orderable' : false, 'searchable' : false},
                ],
                "columnDefs": [
                    //{ className: "nowrap", "targets": [ 5 ] }
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
        TableDatatablesButtons1.init();
        TableDatatablesButtons2.init();
    });


    var weekday = new Array(7);
    weekday[0] =  "{{ __('new.sun')}}";
    weekday[1] = "{{ __('new.mon')}}";
    weekday[2] = "{{ __('new.tue')}}";
    weekday[3] = "{{ __('new.wed')}}";
    weekday[4] = "{{ __('new.thur')}}";
    weekday[5] = "{{ __('new.fri')}}";
    weekday[6] = "{{ __('new.sat')}}";

    $(".datepicker ").on("change", function(){

    var dateString = $(this).val(); // Oct 23

    if(dateString) {
        var dateParts = dateString.split("/");
        var dateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);

        var n = weekday[dateObject.getDay()];

        $(this).parents("tr").find(".day").html(n);

        //console.log(n);
    }
});

function addRowFederal() {
    

    console.log("add federal");
}

function addRowAdditional() {
    console.log("add additional");
}

function updateFederal(id) {
    $("#modalDiv").load("{{ url('/') }}/admin/master/holiday/"+id+"/federal/edit");
}

function createFederal(id) {
    $("#modalDiv").load("{{ url('/') }}/admin/master/holiday/federal/create");
}

function updateAdditional(id) {
    $("#modalDiv").load("{{ url('/') }}/admin/master/holiday/"+id+"/additional/edit");
}

function createAdditional(id) {
    $("#modalDiv").load("{{ url('/') }}/admin/master/holiday/additional/create");
}

function deleteHoliday(id) {
    swal({
        title: "{{ __('swal.delete')}}",
        text: "{{ __('swal.sure_delete')}}",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "fade-out",
        showLoaderOnConfirm: true,
        cancelButtonText: "{{ __('button.cancel') }}",
        confirmButtonText: "{{ __('button.delete') }}"
    },

    function(){

        var _token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url: "{{ route('master.holiday') }}/"+id+"/delete",
            type: "DELETE",
            data : {
                _token:_token,
                id:id
            },
            dataType: "JSON",
            success: function(data){
                if(data.status=="ok"){
                    swal({
                        title: "{{ __('swal.success') }}!",
                        text: "{{ __('swal.success_delete') }}",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true
                    },
                    function(){
                        swal({
                            text: "{{ __('new.reloading') }}",
                            showConfirmButton: false
                        });
                        location.reload();
                    });
                } else {
                    swal("{{ __('new.error') }}!", "{{ __('new.something_wrong') }}", "error");
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                swal("{{ __('new.unexpected_error') }}!", thrownError, "error");
            }
        });
    });
}


</script>
@endsection