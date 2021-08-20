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
<div class="row margin-top-10">
  <div class="col-md-12">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <i class="fa fa-list"></i>
                <span class="caption-subject bold uppercase">{{ trans('hearing.list_date') }}</span>
            </div>
            <div class="tools"> </div>
        </div>
        <div class="" style="margin-bottom: 20px;">
            <div id="search-form" class="form-inline">
                <div class="form-group mb10">
                    <span style="margin-right:15px;">
                        <label for="branch">{{ trans('hearing.list_date_at') }}</label>
                        <select id="branch" class="form-control select2 bs-select" name="branch" data-placeholder="--------">
                            <option value="" disabled selected>--{{ trans('hearing.please_choose')}}--</option>
                            <option value="KGS">TTPM Kangsar</option>
                            <option value="ATR">TTPM Alor Setar</option>
                            <option value="GGT">TTPM Georgetown</option>
                            <option value="IPH">TTPM Ipoh</option>
                        </select>
                    </span>

                    <label for="cawangan">{{ trans('hearing.hearing_date') }} </label>
                    <input required class="form-control form-control-inline date-picker datepicker clickme" name="inst_filing_date" id="inst_filing_date" readonly="" data-date-format="dd/mm/yyyy" type="text" value=""/>
                </div>
                <br>
                <div class="form-group mb10">
                    <span style="margin-right:15px;">
                        <label for="cawangan">{{ trans('hearing.year') }} </label>
                        <select id="year" class="form-control select2 bs-select" style="margin-right:15px;" name="branch" data-placeholder="---------">
                                 <option value="" disabled selected>--{{ trans('hearing.please_choose')}}--</option>
                                <option value="10">2010</option>
                                <option value="11">2011</option>
                                <option value="12">2012</option>
                               
                        </select>
                    </span>
                    <span style="margin-right:15px;">
                        <label for="bulan">{{ trans('hearing.month') }}</label>
                        <select id="bulan" class="form-control select2 bs-select" name="branch" data-placeholder="--------">
                            <option value="" disabled selected>--{{ trans('hearing.please_choose')}}--</option>
                            <option value="OCT">OCTROBER</option>
                            <option value="NOV">NOVEMBER</option>
                            <option value="DEC">DECEMBER</option>
                        </select>
                    </span>
                    <div class="form-group">
                            <button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
                     </div>
                </div>
            </div>
        </div>
        <div class="portlet-body">
            <table id="witness" class="table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr align="center">
                        <th width="3%">{{ trans('hearing.no') }}</th>
                        <th>{{ trans('hearing.date') }}</th>
                        <th>{{ trans('hearing.time') }}</th>
                        <th>{{ trans('hearing.place') }}</th>
                        <th>{{ trans('hearing.room') }}</th>
                        <th>{{ trans('hearing.president') }}</th>
                        <th>{{ trans('hearing.replacing') }}</th>
                        <th>{{ trans('hearing.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="3%">1</td>
                        <td>2017-07-25</td>
                        <td>15:12</td>
                        <td>Johor</td>
                        <td>Bilik Pendengaran 1</td>
                        <td>ZACK BIN MAT</td>
                        <td>ZALEHA BINTI MAT</td>
                        <td>
                            <a value="" rel="tooltip" data-original-title="View" data-toggle="modal" class="btn btn-xs blue"  data-target="#modalView"><i class="fa fa-search"></i></a>

                            <a value="" rel="tooltip" data-original-title="Print" class="btn btn-xs yellow" ><i class="fa fa-print"></i></a>

                        </td>
                    </tr>
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
            <h4 class="modal-title">Hearing Date Information</h4>
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

<!-- <div class="modal fade bs-modal-lg" id="modalperanan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ trans('hearing.hearing_info') }}</h4>
            </div>
            <div class="modal-body" id="modalbodyperanan">
                <div style="text-align: center;"><div class="loader"></div></div>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        </div>
    </div>
</div> -->

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
var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#witness');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide":false,
            "ajax": "",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            // "columns": [
            //      // {data: 'rownum'},
            //     { data: "", name: ""},
            //     { data: "", name:"", 'orderable'},
            //     { data: "", name:"", 'orderable'},
            //     { data: "", name:"", 'orderable' : false}
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

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},


            buttons: [
                {
                    text:"<i class=\"fa fa-plus margin-right-5\"></i> {{ trans('hearing.add_date')}}", className:"btn blue btn-outline", action:function()
                        {
                            window.location.href = "{{route('hearing.date.create')}}";
                        }
                },
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

@endsection