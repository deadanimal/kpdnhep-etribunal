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
                <span class="caption-subject bold uppercase">
                   {{ __('new.list_hearing_award') }} 
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
                            <option value="" >-- {{ __('form1.all_branch') }} --</option>
                            @foreach($branches as $i=>$branch)
                            <option @if(Request::get('branch') == $branch->branch_id) selected @endif value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
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
            <table id="list_case" class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th width="3%">{{ trans('new.no') }}</th>
                        <th>{{ trans('new.claim_no') }}</th>
                        <th>{{ trans('new.branch') }}</th>
                        <th>{{ trans('new.filing_date') }}</th>
                        <th>{{ trans('new.action') }}</th>
                    </tr>
                </thead>
            </table>
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

var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#list_case');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{!! Request::fullUrl() !!}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                 { data: null, 'orderable' : false, 'searchable' : false},
                 { data: "case_no", name: "case_no"},
                 { data: "branch", name: "branch"},
                 { data: "filing_date", name:"form1.filing_date"},
                 { data: "action", name:"action", 'orderable' : false, 'searchable' : false},
            ],
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

@endsection