<?php
$locale = App::getLocale();
$month_lang = "month_".$locale;
?>
@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('heading', 'Roles')

@section('content')
<style type="text/css">
.modal-open .bootstrap-select .dropdown-menu {
    z-index: 100580 !important;
}
</style>
<div class="row margin-top-10">
  <div class="col-md-12">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <i class="fa fa-list"></i>
                <span class="caption-subject bold uppercase">{{ trans('menu.president_schedule_suggest') }}</span>
            </div>
            <div class="tools"> </div>
        </div>
        <div style="margin-bottom: 20px;">
            <form method='get' action=''>
                <div id="search-form" class="form-inline">
                    @if(Auth::user()->hasRole('psu-hq') || Auth::user()->hasRole('admin') && Auth::user()->hasRole('ks-hq'))
                    <div class="form-group mb10">
                        <label for="president">{{ trans('hearing.president') }}</label>
                        <select id="president" class="form-control" name="president" style="margin-right: 10px;">
                            <option value="" selected disabled hidden>-- {{ __('hearing.all_president') }} --</option>
                            <option value="" >-- {{ __('hearing.all_president') }} --</option>
                            @foreach($presidents as $i=>$president)
                            <option class='uppercase' 
                            @if(Request::get('president') == $president->user_id) selected @endif
                            value="{{ $president->user_id }}">{{ $president->user->name or "" }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
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
                    <div class="form-group mb10">
                        <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="portlet-body">
            <table id="witness" class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                      <tr>
                        <th width="3%">{{ trans('new.no') }}</th>
                        <th>{{ trans('hearing.president_name') }}</th>
                        <th>{{ trans('hearing.president_suggested_date') }}</th>
                        <th width="21%">{{ trans('new.action') }}</th>
                      </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="modalView" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ __('hearing.hearing_info')}}</h4>
        </div>
        <div class="modal-body"> 
            <div class="row">
                <div class="col-md-12 form">
                    <div class="form-horizontal" role="form">
                        <div class="form-body">

                            <div class="portlet light bordered form-fit">
                                <div class="portlet-title">
                                    <div class="caption font-dark">
                                        <i class="icon-layers font-green-sharp"></i>
                                        <span class="caption-subject font-green-sharp bold uppercase"> 28/12/2018 | <small> President Name </small></span>
                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <form action="#" class="form-horizontal form-bordered ">
                                        <div class="form-body">
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-3 control-label-custom" style="border-left: none; padding-top: 13px;">President Name </div>
                                                <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                                    <span id="">Puteri Zulaiha Abdul Saat</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-3 control-label-custom" style="border-left: none; padding-top: 13px;">State </div>
                                                <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                                    <span id="">Perak</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-3 control-label-custom" style="border-left: none; padding-top: 13px;">Branch </div>
                                                <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                                    <span id="">TTPM Ipoh</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-3 control-label-custom" style="border-left: none; padding-top: 13px;">Time </div>
                                                <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                                    <span id="">12:12 AM</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-3 control-label-custom" style="border-left: none; padding-top: 13px;">Place </div>
                                                <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                                    <span id="">Perak</span>
                                                </div>
                                            </div>
                                            <div class="form-group" style="display: flex;">
                                                <div class="control-label col-xs-3 control-label-custom" style="border-left: none; padding-top: 13px;">Room </div>
                                                <div class="col-xs-9 font-green-sharp" style="align-items: stretch;">
                                                    <span id="">Bilik Pendengaran 1</span>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Back</button>
            <button type="button" class="btn green">Send</button>
        </div>
      </div>

  </div>
</div>

<div class="modal fade bs-modal-lg" id="modalPermohonanCuti" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('menu.president_schedule') }}</h4>
            </div>
            <div class="modal-body" id="modalBodyCuti">
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('hearing.add_president_schedule')}}</h4>
            </div>
            <div class="modal-body">
                <form id='formAdd' class="form-horizontal" role="form">
                    <div class="form-body">

                        <div id="row_branch" class="form-group form-md-line-input">
                            <label for="branch_id" id="row_claim_offence" class="control-label col-md-4">{{ trans('hearing.president') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-7">
                                <select required class="form-control" id="add_president_id" name="add_president_id"  data-placeholder="---">
                                    <option value="" disabled selected>---</option>
                                    @foreach($presidents as $i=>$president)
                                    <option class='uppercase' value="{{ $president->user_id }}">{{ $president->user->name or "" }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div id="row_filing_date" class="form-group form-md-line-input">
                            <label for="filing_date" id="label_filing_date" class="control-label col-md-4">{{ __('hearing.hearing_date') }} :
                                <span class="required"> &nbsp;&nbsp; </span>
                            </label>
                            <div class="col-md-7">
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
                                    <input class="form-control form-control-inline date-picker datepicker clickme" name="add_date" id="filing_date" readonly="" data-date-format="dd/mm/yyyy" type="text" value="{{ date('d/m/Y') }}"/>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('button.close') }}</button>
                <button type="button" onclick="submitAdd()" class="btn btn-primary">{{ __('button.submit') }}</button>
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
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
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

function submitAdd() {
    // $("#formAdd").submit();
    console.log('submit');

    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: "{{ route('presidentschedule.add') }}",
        type: 'POST',
        data: $('#formAdd').serialize(),
        datatype: 'json',
        async: false,
        success: function(data){
            if(data.result == "success") {
                $("#addModal").modal("hide");
                // swal("{{ trans('swal.success') }}", "", "success");
                swal({
                    title: "{{ trans('swal.success') }}",
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true
                },
                function(){
                    location.reload();
                });

            } else {
                swal("{{ trans('new.error') }}", "", "error");
            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            $("#addModal").modal("hide");
            swal("{{ trans('swal.unexpected_error') }}!", thrownError, "error");
            //alert(thrownError);
        }
    });
}

var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#witness');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide":true,
            "ajax": "{!! Request::fullUrl() !!}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                 // {data: 'rownum'},
                { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                { data: "president_name", name:"president_name", 'orderable' : false},
                { data: "suggest_date", name: "suggest_date"},
                { data: "tindakan", name: "tindakan", 'searchable': false, 'orderable' : false },
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
                    text:"<i class=\"fa fa-plus margin-right-5\"></i> {{ trans('hearing.add_president_schedule')}}", className:"btn blue btn-outline", action:function()
                        {
                            // window.location.href = "{{route('president_schedule.calendarschedule')}}";
                            $("#addModal").modal("show");
                        }
                },
                // {
                //     text:"<i class=\"fa fa-plus margin-right-5\"></i> {{ trans('hearing.add_president_schedule')}}", className:"btn blue btn-outline", action:function()
                //         {
                //             window.location.href = "{{route('president_schedule.calendarschedule')}}";
                //         }
                // },
                {
                    extend: 'print',
                    className: 'btn dark btn-outline',
                    title: function(){
                        return ""; // #translate
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
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
<script type="text/javascript">
$('body').on('click', '.ajaxDeleteSchedules', function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    swal({
        title: "{{ trans('swal.sure') }} ?",
        text: "{{ trans('swal.data_deleted') }} !",
        type: "info",
        showCancelButton: true,
        cancelButtonClass: "btn-danger",
        confirmButtonClass: "green meadow",
        confirmButtonText: "{{ trans('button.delete') }}",
        cancelButtonText: "{{ trans('button.cancel') }}",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data:{
                    _token:'{{csrf_token()}}',
                },
                success: function (response) {
                    if(response.status=='ok'){
                        swal({
                            title: " {{ trans('swal.success') }} !",
                            text: " {{ trans('swal.success_deleted') }}.",
                            type: "success",
                            timer: 500,
                            showConfirmButton: false,
                        });
                        $('.modal.in').modal('hide');
                        $('#witness').DataTable().draw(false);
                    }else{
                        swal(" {{ trans('swal.error') }} !", "  {{ trans('swal.fail_deleted') }} ", "error");
                    }
                }
            });
            // deletes.submit();
            return false;
        }
    });
});
$('body').on('click', '.ajaxUpdateSchedule', function(e){
    e.preventDefault();
    $('#modalPermohonanCuti').modal('show')
    .find('#modalBodyCuti')
    .load($(this).attr('href'));

    $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
        $('#modalBodyCuti').html('');
    });
});

$('body').on('click', '.btnModalView', function(e){
    e.preventDefault();
    $('#modalPermohonanCuti').modal('show')
    .find('#modalBodyCuti')
    .load($(this).attr('href'));

    $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
        $('#modalBodyCuti').html('');
    });
});
</script>
@endsection