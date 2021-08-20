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
                <span class="caption-subject bold uppercase">{{ __('new.claim_record') }} </span>
            </div>
        </div>
        <div style="margin-bottom: 20px;">
            <form method='get' action=''>
                <div id="search-form" class="form-inline">
                    
                    <div class="form-group mb10">
                        <label for="branch">{{ __('new.record_list_at')}}</label>
                        <select id="branch" class="form-control" name="branch" style="margin-right: 10px;">
                            <option value="" selected disabled hidden>-- {{ __('form1.all_branch') }} --</option>
                            <option value="" >-- {{ __('form1.all_branch') }} --</option>
                            @foreach($branches as $b)
                            <option @if(Request::get('branch') == $b->branch_id) selected @endif value="{{$b->branch_id}}">{{$b->branch_name}}</option>
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
            <table id="claim_record" class="table table-striped table-bordered table-hover table-responsive mt5" width="100%">
                <thead>
                    <tr>
                        <th width="3%">{{ __('new.no') }}</th>
                        <th>{{ __('new.claim_no') }}</th>
                        <th>{{ __('new.branch') }}</th>
                        <th>{{ __('new.party') }}</th>
                        <th>{{ __('new.submission_date') }}</th>
                        <th>{{ __('new.hearing_date') }}</th>
                        <th>{{ __('new.action') }}</th>
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
                <h4 class="modal-title">{{ __('new.claim_submission_info') }}</h4>
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
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
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
    
    var TableDatatablesButtons = function () {

        var initTable = function () {
            var table = $('#claim_record');

            var oTable = table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{!! Request::fullUrl() !!}",
                "deferRender": true,
                "pagingType": "bootstrap_full_number",
                "columns": [
                    { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                    { data: "claim_no", name:"form4.case.case_no", 'orderable' : false},
                    { data: "branch", name:"form4.hearing.branch.branch_name", 'orderable' : false},
                    { data: "party", name:"party", 'orderable' : false, 'searchable' : false},
                    { data: "submission_date", name:"submission_date", 'orderable' : false},
                    { data: "hearing_date", name:"form4.hearing.hearing_date", 'orderable' : false},
                    { data: "action", name:"action", 'orderable' : false, 'searchable' : false}
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
                        return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ trans('new.claim_record') }}</span>"; // #translate
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                    customize: function ( win ) {
                        // Style the body..
                        $( win.document.body ).css( 'background-color', '#FFFFFF' );

                        $( win.document.body ).find('thead').css( 'background-color', '#DDDDDD' );

                        $(win.document.body).find( 'table' )
                            .addClass( 'compact' )
                            .css( 'font-size', 'inherit' );

                        win.document.title = "{{ trans('new.claim_record') }}";

                        $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} '+moment().format("DD/MM/YYYY h:MM A")+'</footer>'); },
                    exportOptions: {
                        columns: [0,1,2,3]
                    },
            }],

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
                });
            });
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

{{ modalScript(false, '#modalPrint', '.btnPrint', '$(\'#modalPrint\').find(\'#modalBodyPrint\').html(\'<div class="text-center"><img class="mr10 mb10" src="'.URL::to('/assets/global/img/loading-spinner-grey.gif').'"><span class="font-md">Memproses Data </span></div>\').load($(this).attr(\'href\'));') }}
</script>
@endsection