@extends('layouts.app')

@section('after_styles')<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <i class="fa fa-list"></i>
                <span class="caption-subject bold uppercase"> {{ trans('hearing.listen_claim')}} </span>
            </div>
        </div>
        <!--       <div class="portlet-body"> -->
        <div class="mb20">
            <div id="search-form" class="form-inline">
                <div class="form-group mt10 " style="width: 100%">
                    <span style="margin-right:15px;">
                        <label for="cawangan">{{ trans('hearing.list_form4')}}  </label>
                        <select id="status" class="form-control select2 bs-select" name="status" data-placeholder="---------">
                            <option value="" disabled selected>--{{ trans('hearing.please_choose')}}--</option>
                            <option value="1">Haven't Print</option>
                            <option value="2">Have Printed</option>
                        </select>
                    </span>
                    <span style="margin-right:15px;">
                        <label for="cawangan">{{ trans('hearing.located_in')}} </label>
                        <select id="branch" class="form-control select2 bs-select" name="branch" data-placeholder="---------">
                            <option value="" disabled selected>--{{ trans('hearing.please_choose')}}--</option>
                            <option value="ALL" selected="">{{ trans('hearing.all_branch')}}</option>
                            <option value="KGS">TTPM Kangsa</option>
                            <option value="ATR">TTPM Alor Star</option>
                            <option value="GGT">TTPM Georgetown<</option>
                            <option value="IPH">TTPM Ipoh</option>
                            <option value="SL">TTPM Shah Alam</option>
                            <option value="KL">TTPM Kuala Lumpur</option>
                            <option value="PJ">TTPM Putrajaya</option>
                            <option value="SR">TTPM Seremban</option>
                            <option value="MK">TTPM Melaka</option>
                            <option value="JB">TTPM Johor Bahru</option>
                            <option value="KU">TTPM Kuantan</option>
                            <option value="KT">TTPM Kuala Terengganu</option>
                            <option value="KB">TTPM Kota Bharu</option>
                            <option value="KK">TTPM Kota Kinabalu</option>
                            <option value="LB">TTPM Labuan</option>
                            <option value="KC">TTPM Kuching</option>
                        </select>
                    </span>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                    </div>
                </div>    
            </div>
        </div>
       <!--  <div class="form-group mt10 mb10 form-inline">
            <label for="cawangan">{{ trans('hearing.claim_no')}}</label>
            <input class="form-control placeholder-no-fix" type="text" name="peserta" value="" size="25">
        </div> -->
        <div class="portlet-body">
            <table id="claim" class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <th width="3%">{{ trans('new.no') }}</th>
                        <th>{{ trans('form2.date_send') }}</th>
                        <th>{{ trans('form2.claim_no') }}</th>
                        <th>{{ trans('form2.claimant') }}</th>
                        <th>{{ trans('form2.opponent') }}</th>
                        <th>{{ trans('form2.branch') }}</th>
                        <th>{{ trans('form2.status') }}</th>
                        <th width="20%">{{ trans('form2.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="3%">1</td>
                        <td>2017-07-25</td>
                        <td>TTPM-(B)-200-2017</td>
                        <td>AHMAD BIN MAN</td>
                        <td>ZACK BIN MAT</td>
                        <td>TTPM IPOH</td>
                        <td>Belum Dicetak</td>
                        <td>
                            <a value="" rel="tooltip" data-original-title="View" class="btn btn-xs blue" href="{{ route('hearing.case.infoForm4') }}"><i class="fa fa-search"></i></a>                          

                            <a value="" rel="tooltip" data-original-title="Print" class="btn btn-xs yellow" ><i class="fa fa-print"></i></a>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>        
    </div>


@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>


<!--end sweetalert -->
<script type="text/javascript">
var TableDatatablesButtons = function () {

    var initTable = function () {
        var table = $('#claim');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": false;
            // "ajax": "{{ route('form2.indexform1') }}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            // "columns": [
            //     { data: null, 'orderable' : false, 'searchable' : false},
            //     { data: "created_at", name:"created_at", 'orderable' : false},
            //     { data: "case_no", name:"case_no", 'orderable' : false},
            //     { data: "claimant_name", name:"claimant_name", 'orderable' : false},
            //     { data: "opponent_name", name:"opponent_name", 'orderable' : false},
            //     { data: "branch_name", name:"branch_name", 'orderable' : false},
            //     { data: "form_status", name:"form_status", 'orderable' : false},
            //     { data: "action", name:"action", 'orderable' : false, 'searchable' : false},
            // ],
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
                        return "{{ trans('new.title_user_list') }}"; // #translate
                    },
                    text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
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