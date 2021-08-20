@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('heading', 'Permissions')

@section('content')
<div class="row margin-top-10">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-dark">
              <i class="fa fa-list"></i>
              <span class="caption-subject bold uppercase">{{ trans('acl.permission_list') }}</span>
          </div>
              <div class="tools"> </div>
          </div>
          <div class="portlet-body">
            <table id="permissions" class="table table-striped table-bordered table-hover table-responsive">
            <thead>
                <tr>
                    <th width="3%">{{ trans('new.no') }}</th>
                    <th>{{ trans('new.name') }}</th>
                    <th>{{ trans('new.desc') }}</th>
                    <th width="21%">{{ trans('new.action') }}</th>
                </tr>
            </thead>
            </table>
     </div>
  </div>
</div>
<div class="modal fade bs-modal-lg" id="modalkebenaran" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('acl.permission_info') }}</h4>
            </div>
            <div class="modal-body" id="modalbodykebenaran">
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
$('body').on('click', '.btnModalKebenaran', function(e){
    e.preventDefault();
    $('#modalkebenaran').modal('show')
        .find('#modalbodykebenaran')
        .load($(this).attr('href'));
});
$('#modalkebenaran').on('hidden.bs.modal', function(){
    $('#modalbodykebenaran').html('');
});

</script>
<script type="text/javascript">
var TableDatatablesButtons = function () {
    var initTable1 = function () {
        var table = $('#permissions');

        var oTable = table.DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('admins.listpermissions') }}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                 // {data: 'rownum'},
                { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                { data: "name", name:"name", 'orderable' : false},
                { data: "description", name: "description"},
                { data: "tindakan", name: "tindakan", 'searchable': false, 'orderable' : false },
            ],

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
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
                text:"<i class=\"fa fa-plus margin-right-5\"></i> {{ trans('new.add_permission') }}", className:"btn blue btn-outline", action:function()
                    {
                        window.location.href = "{{ route('admins.createpermissions') }}";
                    }
                },
                { extend: 'print', className: 'btn dark btn-outline', text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}' },
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
$('body').on('click', '.ajaxDelete', function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    var deletes = $(this).parent();
    swal({
        title: "{{ trans('swal.sure') }} ?",
        text: "{{ trans('swal.data_deleted') }} !",
        type: "info",
        showCancelButton: true,
        cancelButtonClass: "btn-danger",
        confirmButtonClass: "green meadow",
        confirmButtonText: "Padam",
        cancelButtonText: "Batal",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    },
    function(isConfirm) {
        if (isConfirm) {
            console.log('ada');
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
                        $('#permissions').DataTable().draw(false);
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
</script>
@endsection