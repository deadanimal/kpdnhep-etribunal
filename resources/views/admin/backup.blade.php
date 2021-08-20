<?php

function human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

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
tr td:last-child, tr td:first-child{
    width:1%;
    white-space:nowrap;
}
</style>

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cog font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('new.backup_manager') }} </span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body">
                <form id="form_backup" action="{{ route('backup.store') }}" method="post" class="form-horizontal ">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="notification" class="control-label col-md-4"> {{ trans('new.type') }} :
                                <span class="required"> * </span>
                            </label>
                            <div id='types' class="col-md-6 md-checkbox-inline">
                                <div class="md-checkbox">
                                    <input id="type_db" onchange="generateName()" name="types[]" type="checkbox" value="1">
                                    <label for="type_db">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ __('new.database') }}
                                    </label>
                                </div>
                                <div class="md-checkbox">
                                    <input id="type_files" onchange="generateName()" name="types[]" type="checkbox" value="2">
                                    <label for="type_files">
                                        <span></span>
                                        <span class="check"></span>
                                        <span class="box"></span> {{ __('new.system_files') }}
                                    </label>
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="control-label col-md-4">{{ __('new.filename') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="filename" name='filename' placeholder="({{ __('new.optional') }})" unupper="unUpper">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>

                        <div class="form-group form-md-line-input">
                            <label class="control-label col-md-4"></label>
                            <div class="col-md-6">
                                <button type="button" onclick="history.back()" class="btn default"><i class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
                                <button type="submit" class="btn green"><i class="fa fa-paper-plane mr10"></i>{{ trans('button.backup') }}</button>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>


        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cog font-green-sharp"></i>
                    <span class="caption-subject bold font-green-sharp uppercase"> {{ __('new.backup_history') }} </span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="" style="margin-bottom: 20px;">
                <form method='get' action=''>
                    <div id="search-form" class="form-inline">
                        <div class="form-group mb10">
                            <label for="date">{{ __('new.date')}}</label>
                            <div class="input-group date date-picker" data-date-format="dd/mm/yyyy" style="margin-right: 10px;"> 
                                <input type="text" class="form-control" name="date" id="date" value="{{ Request::get('date') }}" />
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>      <!-- REQUEST TO DISPLAY ON WHAT WE SELECT -->
                            </div>
                        </div>
                        <div class="form-group mb10">
                            <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <th>{{ __('new.no') }}</th>
                        <th>{{ __('new.filename') }}</th>
                        <th>{{ __('new.size') }}</th>
                        <th>{{ __('new.created_at') }}</th>
                        <th>{{ __('new.action') }}</th>
                    </thead>
                    <tbody>
                        @foreach($files as $i => $file)
                        <tr>
                            <td></td>
                            <td>{{ basename($file) }}</td>
                            <td>{{ human_filesize(filesize($file)) }}</td>
                            <td>{{ date('d/m/Y', filemtime($file)) }}</td>
                            <td>
                                <a class='btn dark btn-xs' href='{{ route("backup.download", ["filename" => basename($file)]) }}'><i class='fa fa-download'></i> {{ __('button.download') }}</a>
                                <a class='btn red btn-xs' url='{{ route("backup.delete", ["filename" => basename($file)]) }}' onclick='deleteFile(this)' rel="tooltip" data-original-title="{{ __('button.delete') }}" ><i class='fa fa-trash'></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
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
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<script>

    function generateName() {

        var filename = "";

        if( $("#type_db").prop("checked") )
            filename += "database-";

        if( $("#type_files").prop("checked") )
            filename += "filesystem-";

        filename += moment().format('YYYYMMDDHHmm');

        $("#filename").val(filename);
    }

    var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('table');

        var oTable = table.DataTable({
                "processing": true,
                "serverSide": false,
                "deferRender": true,
                "pagingType": "bootstrap_full_number",
                // Internationalisation. For more info refer to http://datatables.net/manual/i18n
                "language": {
                    "aria": {
                        "sortAscending": ": {{ trans('new.sort_asc') }}",
                        "sortDescending": ": {{ trans('new.sort_desc') }}"
                    },
                    "processing": "<span class=\"font-md\">{{ trans('new.process_data') }}</span><i class=\"fa fa-circle-o-notch fa-spin ml5\"></i>",
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

    function deleteFile (button) {

        var url = $(button).attr('url');

        swal({
            title: "{{ __('button.delete')}}",
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
            
            $.ajax({
                url: url,
                type: "DELETE",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: "JSON",
                success: function(data){
                    if(data.status=="ok"){
                        swal({
                            title: "{{ __('swal.success') }}!",
                            text: "{{ __('swal.success_delete') }}!",
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

    $("#form_backup").submit(function(e){
        e.preventDefault();
        var form = $(this);

        swal({
            title: "{{ __('button.proceed') }} ?",
            text: "{{ __('new.takes_time') }}",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: false
        }, function () {

            swal({
                title: "{{ __('swal.process_data') }}",
                text: "{{ __('swal.process_on_background') }}",
                type: "info"
            });
            
            $.ajax({
                url: form.attr('action'),
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                method: form.attr('method'),
                data: new FormData(form[0]),
                dataType: 'json',
                contentType: false,
                processData: false,
                async: true,
                success: function(data) {
                    if(data.status=='ok'){
                        swal({
                            title: "{{ __('new.success') }}",
                            text: "{{ __('new.backup_success') }}", 
                            type: "success"
                        },
                        function () {
                            location.reload();
                        });
                    }
                    else if(data.status=='fail'){
                        swal("{{ __('new.error') }}!", "{{ __('new.backup_failed') }}!", "error");
                    }
                    else {
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

        });

        return false;
    });
</script>

@endsection