<?php
$locale = App::getLocale();
$status_lang = "status_".$locale;
?>
@extends('layouts.app')

@section('after_styles')
{{ Html::style(URL::to('/assets/global/plugins/datatables/datatables.min.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')) }}
{{ Html::style(URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css')) }}

@endsection

@section('content')
<div class="row margin-top-10">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-list"></i>
                    <span class="caption-subject bold uppercase">{{ trans('new.public_user')}}</span>
                </div>
                <div class="tools"> </div>
            </div>
            <div style="margin-bottom: 20px;">
                <form method='get' action=''>
                    <div id="search-form" class="form-inline">
                        <div class="form-group mb10">
                            <label for="status">{{ trans('hearing.status') }}</label>
                            <select id="status" class="form-control" name="status" style="margin-right: 10px;">
                                <option value="" selected disabled hidden>-- {{ __('form1.all_status') }} --</option>
                                <option value="" >-- {{ __('form1.all_status') }} --</option>
                                @foreach($status as $i=>$stat)
                                <option 
                                @if(Request::get('status') == $stat->user_status_id) selected @endif
                                value="{{ $stat->user_status_id }}">{{ $stat->$status_lang }}</option>
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
                <table id="user" class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th width="3%">{{ trans('new.no')}}</th>
                            <th>{{ trans('new.name') }}</th>
                            <th>{{ trans('new.id_no') }}</th>
                            <th>{{ trans('new.reg_date') }}</th>
                            <th>{{ trans('new.type') }}</th>
                            <th>{{ trans('new.status') }}</th>
                            <th width="20%">{{ trans('new.action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{ modal('modalUser', 'modalBodyUser', trans('new.user_acc')) }}
{{ modal('modalCreateUser', 'modalBodyCreateUser', trans('new.create_user'), 
'<div class="row">
    <div class="col-lg-12 col-md-12 text-center">
        <img src="'.URL::to('/assets/pages/img/etribunalv2/register-public.png').'" class="mb30">

        <div class="form-group">
            <a class="btn blue btn-outline btn-md" href="'.route('public.create.citizen').'">'.__('login.citizen').'</a>
            <a class="btn blue btn-outline btn-md" href="'.route('public.create.noncitizen').'">'.__('login.noncitizen').'</a>
            <a class="btn blue btn-outline btn-md" href="'.route('public.create.company').'">'.__('login.company').'</a>
        </div>
    
    </div>
</div>'
) }}
{{-- modal('modalChangePassword', 'modalBodyChangePassword', 'Change Password') --}}
@endsection

@section('after_scripts')
<!-- Modal -->
<div id="modal-fix" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('new.fix_user_type') }}</h4>
            </div>
            <div class="modal-body">
                <form id="form-fix" class="form-horizontal" role="form" method="post" action="{{ route('public.fix.company') }}">
                    <div class="form-body">
                        <div class="form-group form-md-line-input">
                            <label for="pass_new" class="control-label col-md-5">{{ __('new.company_no') }} :
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-6">
                                {{ csrf_field() }}
                                <input type="text" class="form-control" id="company_no" name="company_no" value="" required/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" >{{ __('button.close') }}</button>
                <button type="button" class="btn btn-primary" onclick="submitFix()" >{{ __('button.submit') }}</button>
            </div>
        </div>

    </div>
</div>

{{ Html::script(URL::to('/assets/global/scripts/datatable.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/datatables/datatables.min.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')) }}
{{ Html::script(URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')) }}
{{ Html::script(URL::to('/assets/pages/scripts/ui-sweetalert.min.js')) }}
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
{{ modalScript(false, '#modalUser', '.btnModalUser', '$(\'#modalUser\').find(\'#modalBodyUser\').load($(this).attr(\'href\'));') }}
{{ modalScript(false, '#modalCreateUser', '.btnCreateUser') }}
{{ confirmDelete(false, '#user') }}

$("#modalUser, #modalCreateUser, #modalChangePassword").on("hide.bs.modal", function () {
    // put your default event here
    $(this).find(".modal-body").html('<div style="text-align: center;"><div class="loader"></div></div>');
});

function changePasswordUser(id){
    $("#modalDiv").load("{{ route('changepass-user') }}/"+id);
}

function submitFix() {

    if( $("#company_no").val() == "" ) {
        swal("{{ __('new.error') }}", "{{ __('new.company_no_empty') }}", "error");
        return;
    }

    var form = $("#form-fix");

    $.ajax({
        url: form.attr('action'),
        method: form.attr('method'),
        data: new FormData(form[0]),
        dataType: 'json',
        async: true,
        contentType: false,
        processData: false,
        success: function(data) {
            // swal(data.title, data.message, data.status);
            swal({
                title: data.title,
                text: data.message,
                type: data.status,
                showCancelButton: false,
                closeOnConfirm: true
            },
            function(){
                if(data.status == "success") {
                    $("#modal-fix").modal("hide");
                    location.reload();
                }
            });
        }
    });
}

var TableDatatablesButtons = function () {

    var initTable = function () {
        var table = $('#user');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{!! Request::fullUrl() !!}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                {data: 'id', defaultContent: '', orderable: false, searchable: false},
                {data: 'name'},
                {data: 'username'},
                {data: 'created_at'},
                {data: 'user_public_type_id', name: 'user_public.user_public_type_id'},
                {data: 'user_status', orderable: false, searchable: false},
                {data: 'action', orderable: false, searchable: false},
                { data: "user_status_id", name: "user_status_id", 'visible' : false},
            ],
            "columnDefs": [
                { className: "nowrap", "targets": [ 5 ] }
            ],
            "createdRow": function( row, data, dataIndex){
                if( data.user_status_id ==  "2"){
                    $(row).addClass('inactive');
                }
            },
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

            buttons: [
                {
                text:"<i class=\"fa fa-plus margin-right-5\"></i> {{ trans('new.add_user') }} ", className:"btn blue btn-outline btnCreateUser", action:function()
                    {
                        window.location.href = "javascript:;";
                    }
                },
                {
                text:"<i class=\"fa fa-wrench margin-right-5\"></i> {{ trans('new.fix_user_type') }} ", className:"btn green-jungle btn-outline", action:function()
                    {
                        $('#modal-fix').modal('show');
                    }
                },
                {
                    extend: 'print',
                    className: 'btn dark btn-outline',
                    title: function(){
                        return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ trans('new.title_user_list') }}</span>"; // #translate
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                    messageBottom: moment().format("dddd, MMMM Do, YYYY, h:MM:ss A"),
                    customize: function ( win ) {
                        // Style the body..
                        $( win.document.body ).css( 'background-color', '#FFFFFF' );

                        $( win.document.body ).find('thead').css( 'background-color', '#DDDDDD' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );

                        win.document.title = "{{ trans('new.title_user_list') }}";

                        $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} '+moment().format("DD/MM/YYYY h:MM A")+'</footer>');     

                        
                    },
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    },
                },
                {
                    extend: 'excel',
                    className: 'btn yellow btn-outline',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    },
                    text:'<i class="fa fa-file-excel-o margin-right-5"></i> Excel'

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
                oTable.cell(cell).invalidate('dom');
            } );
        } );
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

function activateUser(id) {
    swal({
        title: "{{ trans('swal.reactivate') }}",
        text: "{{ trans('swal.sure_reactivate') }} ?",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "fade-out",
        showLoaderOnConfirm: true,
        cancelButtonText: "{{ __('button.cancel') }}",
        confirmButtonText: "{{ __('button.activate') }}"
    },
    function(){

        var _token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            url: "{{ route('ttpm') }}/"+id+"/activate",
            type: "POST",
            data : {
                _token:_token,
                id:id
            },
            dataType: "JSON",
            success: function(data){
                if(data.status=="ok"){
                    swal({
                        title: "{{ trans('swal.success') }}!",
                        text: "{{ __('swal.success_reactivate') }}!",
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
                    swal("{{ trans('swal.error') }}", "{{ __('new.something_wrong') }}", "error");
                }
            },
            error: function(xhr, ajaxOptions, thrownError){
                swal("{{ __('new.unexpected_error') }}!", thrownError, "error");
            }
        });
    });
}
</script>
</script>

@endsection