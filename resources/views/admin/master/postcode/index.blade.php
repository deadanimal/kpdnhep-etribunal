@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('heading', 'Roles')

@section('content')
<div class="row margin-top-10">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-dark">
              <i class="fa fa-list"></i>
              <span class="caption-subject bold uppercase"> {{ __('master.designation') }} </span>
          </div>
          <div class="tools"> </div>
      </div>
      <div class="portlet-body">
        <table id="stop_reason" class="table table-striped table-bordered table-hover table-responsive">
        <thead>
          <tr>
            <th width="3%">{{ trans('new.no') }}</th>
            <th>{{ __('master.designation') }} (EN)</th>            
            <th>{{ __('master.designation') }} (MY)</th>
            <th>{{ __('new.created_at') }}</th>
            <th style="width: 120px;">{{ trans('new.action') }}</th>
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
                <h4 class="modal-title">{{ __('master.designation_info')}}</h4>
            </div>
            <div class="modal-body" id="modalbodyperanan" style="padding: 0px;">
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
        var table = $('#stop_reason');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('master.designation') }}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                 // {data: 'rownum'},
                { data: "designation_id", name:"designation_id", searchable: false},
                { data: "designation_en", name:"designation_en", 'orderable' : false},
                { data: "designation_my", name:"designation_my", 'orderable' : false},
                { data: "created_at", name:"created_at", 'orderable' : false},
                { data: "action", name:"action", searchable: false},
                { data: "is_active", name:"is_active", "visible": false},
            ],
            "columnDefs": [
                { className: "nowrap", "targets": [ 4 ] }
            ],
            "createdRow": function( row, data, dataIndex){
                if( data.is_active ==  "0"){
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

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},


            buttons: [
                {
                text:"<i class=\"fa fa-plus margin-right-5\"></i> {{ __('master.add_designation') }}", className:"btn blue btn-outline", action:function()
                    {
                        window.location.href = "{{ route('master.designation.create') }}"; 
                    }
                },
                {
                extend: 'print',
                className: 'btn dark btn-outline',
                title: function(){
                        return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ __('master.designation') }}</span>"; // #translate
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                    customize: function ( win ) {
                        // Style the body..
                        $( win.document.body ).css( 'background-color', '#FFFFFF' );

                        $( win.document.body ).find('thead').css( 'background-color', '#DDDDDD' );

                        $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );

                        win.document.title = "{{ __('master.designation') }}";

                        $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} '+moment().format("DD/MM/YYYY h:MM A")+'</footer>');                    },
                        exportOptions: {
                            columns: [0,1,2,3]
                        },
                    },
                /*
                {
                    extend: 'print',
                    className: 'btn dark btn-outline',
                    title: function(){
                        return "{{ trans('new.list_branch') }}";
                    },
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                },*/
                // { extend: 'copy', className: 'btn red btn-outline', text:'<i class="fa fa-files-o margin-right-5"></i>Copy' },
                // { extend: 'pdf', className: 'btn green btn-outline', text:'<i class="fa fa-file-pdf-o margin-right-5"></i>PDF' },
                { extend: 'excel', className: 'btn yellow btn-outline', text:'<i class="fa fa-file-excel-o margin-right-5"></i>Excel' },
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

function deleteDesignation(id) {
    swal({
        title: "{{ __('swal.delete_designation')}}",
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
            url: "{{ route('master.designation') }}/"+id+"/delete",
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

function activateDesignation(id) {
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
            url: "{{ route('master.designation') }}/"+id+"/activate",
            type: "POST",
            data : {
                _token:_token,
                id:id
            },
            dataType: "JSON",
            success: function(data){
                if(data.status=="ok"){
                    swal({
                        title: "{{ __('swal.success') }}!",
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