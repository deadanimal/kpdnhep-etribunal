<?php
$locale = App::getLocale();
?>
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
                    <span class="caption-subject bold uppercase">{{ trans('portal.menu_list') }} </span>
                </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table id="menu" class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th width="3%">{{ trans('portal.no') }}</th>
                            <th>{{ trans('portal.menu') }}</th>
                            <th>URL</th>
                            <th>{{ trans('portal.parent_menu') }}</th>
                            <th>{{ trans('portal.priority') }} </th>
                            <th style="width: 150px;">{{ trans('others.action') }}</th>
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
                <h4 class="modal-title">{{ trans('portal.menu_info')}}</h4>
            </div>
            <div class="modal-body" id="modalbodyperanan">
                <div style="text-align: center;"><div class="loader"></div></div>
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
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>

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
    $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>');
});
</script>
<script type="text/javascript">
var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#menu');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{!! Request::fullUrl() !!}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                 // {data: 'rownum'},
                { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                { data: "menu", name:"menu_{{ App::getLocale() }}"},
                { data: "url", name:"url"},
                { data: "parent_menu", name:"parent_menu"},
                { data: "priority", name:"priority"},
                { data: "action", name:"action",'orderable' : false},
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
                    text:"<i class=\"fa fa-plus margin-right-5\"></i> {{ trans('portal.add_menu')}}", className:"btn blue btn-outline", action:function()
                        {
                            window.location.href = "{{route('cms.menu.create')}}";
                        }
                },
                {
                    extend: 'print',
                    className: 'btn dark btn-outline',
                    title: function(){
                        return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ trans('portal.menu_list') }}</span>"; // #translate
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                    customize: function ( win ) {
                        // Style the body..
                        $( win.document.body ).css( 'background-color', '#FFFFFF' );

                        $( win.document.body ).find('thead').css( 'background-color', '#DDDDDD' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );

                        win.document.title = "{{ trans('portal.menu_list') }}";

                        $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} '+moment().format("DD/MM/YYYY h:MM A")+'</footer>');                    },
                    exportOptions: {
                        columns: [0,1,2,3,4]
                    },
                },
                // {
                //     extend: 'print',
                //     className: 'btn dark btn-outline',
                //     title: function(){
                //         return ""; // #translate
                //     },
                //     text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                // },
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

function deleteMenu(id) {
    swal({
        title: "{{ __('portal.delete_menu')}}",
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
            url: "{{ route('cms.menu') }}/"+id+"/delete",
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