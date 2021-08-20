<?php
$locale = App::getLocale();
$type_lang = 'type_'.$locale;
?>
@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- DB BASE -->
<div class="row margin-top-10">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="fa fa-list"></i>
                    <span class="caption-subject bold uppercase">{{ __('menu.audit_trail')}} </span>
                </div>
                <div class="tools"> </div>
            </div>
            <div class="" style="margin-bottom: 20px;">
            <form method='get' action=''>
                <div id="search-form" class="form-inline">
                    <div class="form-group mb10">
                        <label for="date">{{ __('new.date')}}</label>
                        <div class="input-group date date-picker" data-date-format="dd/mm/yyyy" style="margin-right: 10px;"> 
                            <input type="text" class="form-control" name="date" id="date" value="{{ Request::get('date') }}" />
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>      <!-- REQUEST TO DISPLAY ON WHAT WE SELECT -->
                        </div>
                    </div>
                    <div class="form-group mb10">
                        <label for="type">{{ trans('new.type') }}</label>
                        <select id="type" class="form-control" name="type" style="margin-right: 10px;">
                            <option value="" selected disabled hidden>-- {{ __('inquiry.all_type') }} --</option>
                            <option value="" >-- {{ __('inquiry.all_type') }} --</option>
                            @foreach($types as $i=>$type)
                            <option 
                            @if(Request::get('type') == $type->audit_type_id) selected @endif
                            value="{{ $type->audit_type_id }}">{{ $type->$type_lang }}</option>
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
                <table id="audit_trail" class="table table-striped table-bordered table-hover table-responsive">
                    <thead>
                      <tr>
                        <th width="3%">{{ __('master.no')}}</th>
                        <th>{{ __('new.user')}}</th>                
                        <th>{{ __('new.date')}}</th>
                        <th> Model </th>
                        <th> URL </th>
                        <th>{{ __('new.ip_address')}}</th>
                        <th>{{ __('new.type')}}</th>
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
                <h4 class="modal-title">{{ __('new.info_audit')}}</h4>
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

<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>

<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
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

    var TableDatatablesButtons = function () {

        var initTable1 = function () {
            var table = $('#audit_trail');

            var oTable = table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{!! Request::fullUrl() !!}",
                "deferRender": true,
                "pagingType": "bootstrap_full_number",
                "columns": [
                     // {data: 'rownum'},
                    { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                    { data: "created_by", name:"createdBy.name", 'orderable' : false, 'render': function ( data, type, full ){
                        return $("<div/>").html(data).text(); 
                    }},
                    { data: "created_at", name:"created_at", 'orderable' : true},
                    { data: "model", name:"model", 'orderable' : false},
                    { data: "url", name:"url", 'orderable' : false},
                    { data: "ip_address", name:"ip_address", 'orderable' : true},
                    { data: "audit_type_id", name:"audit_type_id", 'orderable' : false},
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
                    //     text:"<i class=\"fa fa-plus margin-right-5\"></i> {{ __('new.add_visitor')}} ", className:"btn blue btn-outline", action:function()
                    //     {
                    //         window.location.href = "{{route('listing.visitor.create')}}"; 
                    //     }
                    // },
                    {
                        extend: 'print',
                        className: 'btn dark btn-outline',
                        title: function(){
                            return "<span style='font-size: 22px'><strong>e-Tribunal V2 | </strong>{{ trans('menu.audit_trail') }}</span>"; // #translate
                        },
                        text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}',
                        customize: function ( win ) {
                            // Style the body..
                            $( win.document.body ).css( 'background-color', '#FFFFFF' );

                            $( win.document.body ).find('thead').css( 'background-color', '#DDDDDD' );

                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );

                            win.document.title = "{{ trans('menu.audit_trail') }}";

                            $(win.document.body).append('<footer style="font-size: smaller; bottom: 0px; right: 0px;">{{ __("new.printed_on") }} '+moment().format("DD/MM/YYYY h:MM A")+'</footer>');                    },
                        exportOptions: {
                            columns: [0,1,2,3]
                        },
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
</script>

@endsection