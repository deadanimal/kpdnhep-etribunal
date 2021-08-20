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
                    <span class="caption-subject bold uppercase">{{ trans('new.report_list') }} </span>
                </div>
                <div class="tools"> </div>
            </div>
            <div class="portlet-body">
                <table id="announcement" class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr>
                            <th width="3%">{{ trans('others.no') }}</th>
                            <th>{{ trans('others.title') }}</th>
                            <th style="width: 150px;">{{ trans('others.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ __('new.report1') }}</td>
                            <td><a class="btn btn-xs blue" href="{{ route('report1-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>{{ __('new.report33') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" href="{{ route('report33.index') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
{{--                        <tr>--}}
{{--                            <td>3</td>--}}
{{--                            <td>{{ __('new.report2') }}</td>--}}
{{--                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport2()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>--}}
{{--                        </tr>--}}
                        <tr>
                            <td>3</td>
                            <td>{{ __('new.report2') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" href="{{ route('report2v2.index') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>{{ __('new.report3') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport3()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>{{ __('new.report4') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport4()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>{{ __('new.report5') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport5()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>{{ __('new.report6') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport6()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>{{ __('new.report7') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport7()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>{{ __('new.report8') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport8()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>{{ __('new.report9') }}</td>
                            <td><a class="btn btn-xs blue" href="{{ route('report9-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>{{ __('new.report9') }}</td>
                            <td><a class="btn btn-xs blue" href="{{ route('report9v2.index') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>{{ __('new.report10') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" href="{{ route('report10-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <!-- tr>
                            <td>11</td>
                            <td>{{ __('new.report11') }}</td>
                            <td><a value="route('report-11')" class="btn btn-xs blue" href="{{ route('report11-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>{{ __('new.report12') }}</td>
                            <td><a value="route('report-12')" class="btn btn-xs blue" href="{{ route('report12-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr -->
                        <tr>
                            <td>12</td>
                            <td>{{ __('new.report13') }}</td>
                            <td><a value="route('report-13')" class="btn btn-xs blue" href="{{ route('report13-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>{{ __('new.report14') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport14()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>{{ __('new.report15') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport15()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>{{ __('new.report16') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" href=" {{ route('report16-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>16</td>
                            <td>{{ __('new.report17') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport17()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>17</td>
                            <td>{{ __('new.report18') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport18()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>18</td>
                            <td>{{ __('new.report19') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport19()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>19</td>
                            <td>{{ __('new.report20') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" href="{{ route('report20-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>20</td>
                            <td>{{ __('new.report21') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport21()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <!-- tr>
                            <td>20</td>
                            <td>{{ __('new.report22') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport22()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr -->
                        <tr>
                            <td>21</td>
                            <td>{{ __('new.report23') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport23()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>22</td>
                            <td>{{ __('new.report24') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" href="{{ route('report24-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>23</td>
                            <td>{{ __('new.report25') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport25()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>24</td>
                            <td>{{ __('new.report26') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" href="{{ route('report26-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>25</td>
                            <td>{{ __('new.report27') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport27()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>26</td>
                            <td>{{ __('new.report28') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" href="{{ route('report28.index') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
{{--                        <tr>--}}
{{--                            <td>27</td>--}}
{{--                            <td>{{ __('new.report29') }}</td>--}}
{{--                            <td><a data-toggle="modal" class="btn btn-xs blue" href="{{ route('report29-view') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>--}}
{{--                        </tr>--}}
                        <!--tr>
                            <td>30</td>
                            <td>{{ __('new.report30') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport30()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
                        <tr>
                            <td>32</td>
                            <td>{{ __('new.report32') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" onclick="processReport32()"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr> -->

                        <tr>
                            <td>28</td>
                            <td>{{ __('new.report34') }}</td>
                            <td><a data-toggle="modal" class="btn btn-xs blue" href="{{ route('report34.index') }}"><i class="fa fa-send"></i> {{ __('button.open') }}</a></td>
                        </tr>
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
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
<!--end sweetalert -->
<script type="text/javascript">
$('body').on('click', '.btnModalPeranan', function(){
    $('#modalperanan').modal('show')
        .find('#modalbodyperanan')
        .load($(tdis).attr('value'));
});
$('#modalperanan').on('hidden.bs.modal', function(){
    $('#modalbodyperanan').html('<div style="text-align: center;"><div class="loader"></div></div>');
});

function processReport1() {
    $("#modalDiv").load("{{ url('/report') }}/report1/filter");
}
function processReport2() {
    $("#modalDiv").load("{{ url('/report') }}/report2/filter");
}
function processReport3() {
    $("#modalDiv").load("{{ url('/report') }}/report3/filter");
}
function processReport4() {
    $("#modalDiv").load("{{ url('/report') }}/report4/filter");
}
function processReport5() {
    $("#modalDiv").load("{{ url('/report') }}/report5/filter");
}
function processReport6() {
    $("#modalDiv").load("{{ url('/report') }}/report6/filter");
}
function processReport7() {
    $("#modalDiv").load("{{ url('/report') }}/report7/filter");
}
function processReport8() {
    $("#modalDiv").load("{{ url('/report') }}/report8/filter");
}
function processReport9() {
    $("#modalDiv").load("{{ url('/report') }}/report9/filter");
}
function processReport14() {
    $("#modalDiv").load("{{ url('/report') }}/report14/filter");
}
function processReport15() {
    $("#modalDiv").load("{{ url('/report') }}/report15/filter");
}
function processReport17() {
    $("#modalDiv").load("{{ url('/report') }}/report17/filter");
}
function processReport18() {
    $("#modalDiv").load("{{ url('/report') }}/report18/filter");
}
function processReport19() {
    $("#modalDiv").load("{{ url('/report') }}/report19/filter");
}
function processReport20() {
    $("#modalDiv").load("{{ url('/report') }}/report20/filter");
}
function processReport21() {
    $("#modalDiv").load("{{ url('/report') }}/report21/filter");
}
function processReport22() {
    $("#modalDiv").load("{{ url('/report') }}/report22/filter");
}
function processReport23() {
    $("#modalDiv").load("{{ url('/report') }}/report23/filter");
}
function processReport25() {
    $("#modalDiv").load("{{ url('/report') }}/report25/filter");
}
function processReport27() {
    $("#modalDiv").load("{{ url('/report') }}/report27/filter");
}
function processReport30() {
    $("#modalDiv").load("{{ url('/report') }}/report30/filter");
}
{{-- function processReport32() {
    $("#modalDiv").load("{{ url('/report') }}/report32/filter");
} --}}
</script>
<script type="text/javascript">


var TableDatatablesButtons = function () {

    var initTable1 = function () {
        var table = $('#announcement');

        var oTable = table.DataTable({
            "processing": true,
            "serverSide": false,
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                 // {data: 'rownum'},
                { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                { data: "title", name:"title"},
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
            // set tde initial value
            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix tde dropdown overflow issue in tde datatable cells. tde default datatable layout
            // setup uses scrollable div(table-scrollable) witd overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used tde scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        }); 
        oTable.on('order.dt search.dt draw.dt', function () {
            var start = oTable.page.info().start;
            var info = oTable.page.info();
            oTable.column(0, {order:'applied'}).nodes().each( function (cell, i) {
                //cell.innerHTML = start+i+1;
            } );
        } ).draw();

        @if(Request::has("page"))
            oTable.page({{ Request::get("page")-1 }}).draw( 'page' );
        @endif
    }

    return {

        //main function to initiate tde module
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
