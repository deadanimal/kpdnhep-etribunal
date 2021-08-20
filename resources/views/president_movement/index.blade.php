<?php
$locale = App::getLocale();
$month_lang = "month_".$locale;
?>

@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('heading', 'Holidays')
@section('content')
<div class="portlet light bordered">
	<div class="portlet-title">
		<div class="caption font-dark">
			<i class="fa fa-list"></i>
			<span class="caption-subject bold uppercase">{{ trans('hearing.president_movement') }}</span>
		</div>
		<div class="tools"> </div>
	</div><div style="margin-bottom: 20px;">
		<form method='get' action='#senarai'>
			<div id="search-form" class="form-inline">
				<div class="form-group mb10">
					<label for="president">{{ trans('hearing.president') }}</label>
					<select id="president" class="form-control" name="president" style="margin-right: 10px;">
						<option value="" selected disabled hidden>-- {{ __('hearing.all_president') }} --</option>
						<option value="" >-- {{ __('hearing.all_president') }} --</option>
						@foreach($presidents as $i=>$president)
						<option class='uppercase' 
						@if(Request::get('president') == $president->user_id) selected @endif
						value="{{ $president->user_id }}">{{ $president->user->name }}</option>
						@endforeach
					</select>
				</div>
				<br class='hidden-xs hidden-sm'>
				<div class="form-group mb10">
					<label for="year">{{ trans('hearing.year') }} </label>
					<select id="year" class="form-control" name="year" style="margin-right: 10px;">
						<option value="" selected disabled hidden>-- {{ __('form1.all_year') }} --</option>
						<option value="" >-- {{ __('form1.all_year') }} --</option>
						@foreach($years as $i=>$year)
						<option @if(Request::get('year') == $year) selected @endif value="{{ $year }}">{{ $year }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group mb10">
					<label for="month">{{ trans('hearing.month') }}</label>
					<select id="month" class="form-control" name="month" style="margin-right: 10px;">
						<option value="" selected disabled hidden>-- {{ __('form1.all_month') }} --</option>
						<option value="" >-- {{ __('form1.all_month') }} --</option>
						@foreach($months as $i=>$month)
                        <option @if(Request::get('month') == $month->month_id) selected @endif value="{{ $month->month_id }}">{{ $month->$month_lang }}</option>
                        @endforeach
					</select>
				</div>
				<div class="form-group mb10">
					<button class="btn btn-primary" type="submit">{{ trans('button.search')}}</button>
				</div>
			</div>
		</form>
	</div>
	<div class="row">
		<div class="portlet-body">
			<div class="col-md-12">
				<table id="holidays" class="table table-striped table-bordered table-hover table-responsive">
					<thead>
						<tr>
							<th width="3%">{{ trans('new.no') }}</th>
							<th>{{ trans('hearing.president_name') }}</th>
							<th>{{ trans('new.branch') }}</th>
							<th>{{ trans('hearing.hearing_date') }}</th>
							<th>{{ trans('new.time') }}</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="modal fade bs-modal-lg" id="modalPermohonanCuti" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">{{ trans('hearing.hearing_info') }}</h4>
			</div>
			<div class="modal-body" id="modalBodyCuti">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Back</button>
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


<script type="text/javascript"> //list tabs
var TableDatatablesButtons = function () {
    var initTable1 = function () {
        var table = $('#holidays');

        var oTable = table.DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": "{!! request::fullUrl() !!}",
            "deferRender": true,
            "pagingType": "bootstrap_full_number",
            "columns": [
                 // {data: 'rownum'},
                { data: 'id', defaultContent: '', 'orderable' : false, 'searchable' : false},
                { data: "president_name", name:"president.name", 'orderable' : false},
                { data: "branch_id", name:"branch.branch_name", 'orderable' : false},
                { data: "hearing_date", name: "hearing_date"},
                { data: "hearing_time", name:"hearing_time"},
               
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
            buttons: [
                /*{
                text:"<i class=\"fa fa-plus margin-right-5\"></i> {{ trans('hearing.add_date') }}", className:"btn blue btn-outline", action:function()
                    {
                        date = "{{date('Y-m-d')}}";
                        var url = "{{ route('hearing.createhearing',"ids:") }}";
                        url = url.replace('ids:', date);
                        // e.preventDefault();
                        $('#modalPermohonanCuti').modal('show')
                        .find('#modalBodyCuti')
                        .load(url);

                        $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
                            $('#modalBodyCuti').html('');
                        });
                    }
                },
                { extend: 'print', className: 'btn dark btn-outline', text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}' },*/
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