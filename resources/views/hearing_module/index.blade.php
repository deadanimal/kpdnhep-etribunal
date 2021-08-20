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
<link href="{{ URL::to('/assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />

<style>
.nowrap {
    white-space: nowrap;
}
</style>
@endsection
@section('heading', 'Holidays')
@section('content')
<div class="row margin-top-10">
  <div class="col-md-12">
    <div class="portlet light bordered">
      <div class="portlet-title">
          <div class="caption font-dark">
              <i class="fa fa-list"></i>
              <span class="caption-subject bold uppercase">{{ trans('menu.set_hearing_date') }}</span>
          </div>
              <div class="tools"> </div>
          </div>
          <div class="portlet-body">
            <ul class="nav nav-tabs" id="myTab">
                <li class="hidden">
                    <a href="#kalendar" data-toggle="tab"> {{ trans('holiday.calendar') }} </a>
                </li>
                <li class="active">
                    <a href="#senarai" data-toggle="tab"> {{ trans('holiday.list') }} </a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane hidden" id="kalendar">
                    <div class="row">
                        <div class="portlet-body">
                            <div class="col-md-12">
                                <!-- <div class="col-md-3 col-sm-12"> -->
                                    <!-- BEGIN DRAGGABLE EVENTS PORTLET-->
                                    <!-- <h3 class="event-form-title margin-bottom-20">{{ trans('holiday.events') }}</h3>
                                    <div id="external-events">
                                        <form class="inline-form">
                                            <input type="text" value="" class="form-control" placeholder="{{ trans('holiday.event_title')}}" id="event_title" />
                                            <br/>
                                            <a href="javascript:;" id="event_add" class="btn green"> {{ trans('holiday.add_event') }} </a>
                                        </form>
                                        <hr/>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline" for="drop-remove"> {{ trans('holiday.remove_after_drop') }}
                                            <input type="checkbox" class="group-checkable" id="drop-remove" />
                                            <span></span>
                                        </label>
                                        <div id="event_box" class="margin-bottom-10"></div>
                                        <hr class="visible-xs" /> 
                                        </div> -->
                                    <!-- END DRAGGABLE EVENTS PORTLET-->
                                <!-- </div> -->
                                <div class="col-md-12 col-sm-12">
                                    <div id="calendar" class="has-toolbar"> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane active" id="senarai">
                    <div style="margin-bottom: 20px;">
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
                                @if(!Auth::user()->hasRole('psu') && !Auth::user()->hasRole('psu-hq'))
                                <div class="form-group mb10">
                                    <label for="branch">{{ trans('hearing.branch') }}</label>
                                    <select id="branch" class="form-control" name="branch" style="margin-right: 10px;">
                                        <option value="" selected disabled hidden>-- {{ __('form1.all_branch') }} --</option>
                                        <option @if(Request::get('branch') == 0) selected @endif value="0" >-- {{ __('form1.all_branch') }} --</option>
                                        @foreach($branches as $i=>$branch)
                                        <option @if(Request::get('branch') == $branch->branch_id) selected @endif value="{{ $branch->branch_id }}">{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
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
                                    <th>{{ trans('master.hearing_venue') }}</th>
                                    <th>{{ trans('hearing.hearing_date') }}</th>
                                    <th>{{ trans('new.time') }}</th>
                                    <th class="nowrap">{{ trans('new.action') }}</th>
                                  </tr>
                                </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


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

<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<!-- <script src="{{ URL::to('/assets/apps/scripts/calendar.min.js') }}" type="text/javascript"></script> -->
@if(App::getLocale() == 'my')
<script src="{{ URL::to('/assets/global/plugins/fullcalendar/lang/my.js') }}" type="text/javascript"></script>
@endif
<!--end sweetalert -->

<script type="text/javascript">
$(document).ready(function(){
    // $('#loadcalendar').load("{{-- route('holiday.calendarholiday') --}}");
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        sessionStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    // var activeTab = sessionStorage.getItem('activeTab');
    // if(activeTab){
    //     $('#myTab a[href="' + activeTab + '"]').tab('show');
    // }
});
</script>
<script type="text/javascript">
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
                { data: "hearing_venue", name: "hearing_room.venue.hearing_venue", 'orderable' : false},
                { data: "hearing_date", name: "hearing_date", 'orderable' : true},
                { data: "hearing_time", name:"hearing_time", 'orderable' : false},
                { data: "tindakan", name: "tindakan", 'searchable': false, 'orderable' : false },
            ],
            "columnDefs": [
                { className: "nowrap", "targets": [ 6 ] }
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
                {
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
                { extend: 'print', className: 'btn dark btn-outline', text:'<i class="fa fa-print margin-right-5"></i> {{ trans("button.print") }}' },
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: false,

            //"ordering": false, disable column ordering 
            "paging": true, //disable pagination

            "order": [
                [ 4, "desc" ]
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

<script type="text/javascript">
$('body').on('click', '.ajaxDeleteDocsButton', function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    swal({
        title: "{{ trans('swal.sure') }} ?",
        text: "{{ trans('swal.data_deleted') }} !",
        type: "info",
        showCancelButton: true,
        cancelButtonClass: "btn-danger",
        confirmButtonClass: "green meadow",
        confirmButtonText: "{{ trans('button.delete') }}",
        cancelButtonText: "{{ trans('button.cancel') }}",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: url,
                type: 'get',
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

                        $.get('allevents', function(data){
                              $("#event_box").html("")
                              $.each(data, function(index, daeObj){
                                var route = "{{-- route('holiday.destroyevent','ids:') --}}";
                                route = route.replace('ids:',daeObj.holiday_event_id);
                                  $('#event_box').append('<div class="external-event label label-default ui-draggable ui-draggable-handle" style="clear: both;">' + daeObj.holiday_event_name + '&nbsp;&nbsp;<a class="ajaxDeleteDocsButton" href="' + route + '" ><i class="fa fa-close"></a></i></div>');
                              });
                        });
                    }else{
                        swal(" {{ trans('swal.error') }} !", "  {{ trans('swal.fail_deleted') }} ", "error");
                    }
                }
            });
            return false;
        }
    });
});
</script>

<script>
var AppCalendar = function() {
    return {
        init: function() {
            this.initCalendar()
        },
        initCalendar: function() {
            if (jQuery().fullCalendar) {

                var e = new Date,
                    t = e.getDate(),
                    a = e.getMonth(),
                    n = e.getFullYear(),
                    r = {};

                App.isRTL() ? $("#calendar").parents(".portlet").width() <= 720 ? ($("#calendar").addClass("mobile"), r = {
                    right: "title, prev, next",
                    center: "",
                    left: " month, today"
                }) : ($("#calendar").removeClass("mobile"), r = {
                    right: "title",
                    center: "",
                    left: " month, today, prev,next"
                }) : $("#calendar").parents(".portlet").width() <= 720 ? ($("#calendar").addClass("mobile"), r = {
                    left: "title, prev, next",
                    center: "",
                    right: "today,month"
                }) : ($("#calendar").removeClass("mobile"), r = {
                    left: "title",
                    center: "",
                    right: "prev,next,today"
                });
                var initDrag = function(el) {
                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim(el.text()) // use the element's text as the event title
                    };
                    // store the Event Object in the DOM element so we can get to it later
                    el.data('eventObject', eventObject);
                    // make the event draggable using jQuery UI
                    el.draggable({
                        zIndex: 999,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0 //  original position after the drag
                    });
                };

                var addEvent = function(title) {
                    title = title.length === 0 ? "{{ __('new.untitled_event')}}" : title;

                    $.ajax({
                        url: "{{-- route('holiday.createevent') --}}",
                        type: 'post',
                        data: {
                            _token: '{{csrf_token()}}',
                            holiday_event_name: title,
                        },
                        success: function (response) {
                            if(response.status=='ok'){
                            var html = $('<div class="external-event label label-default">' + response.name + '&nbsp;&nbsp;<a class="ajaxDeleteDocsButton" href="'+response.route+'"><i class="fa fa-close"></a></i></div>');
                                jQuery('#event_box').append(html);
                                initDrag(html);
                            }else{
                                swal({
                                title: "{{ trans('holiday.sorry') }}",
                                text: "{{ trans('holiday.event_has_exist') }}",
                                type: "error",
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                                });
                            }
                        }
                    });
                };

                $('#external-events div.external-event').each(function() {
                    initDrag($(this));
                });

                $('#event_add').unbind('click').click(function() {
                    var title = $('#event_title').val();
                    addEvent(title);
                });

                // $("#event_box").html(""), 

                $("#calendar").fullCalendar("destroy"), $("#calendar").fullCalendar({
                    header: r,
                    defaultView: "month",
                    slotMinutes: 15,
                    editable: 'true',
                    droppable: !0,
                    displayEventTime: false,
                    buttonText: {
                        today:    '{{ __("new.today") }}',
                        month:    '{{ __("new.month") }}',
                        week:     '{{ __("new.week") }}',
                        day:      '{{ __("new.day") }}',
                        list:     '{{ __("new.list") }}'
                    },

                drop: function(date, allDay) {
                    var originalEventObject = $(this).data('eventObject');
                    var copiedEventObject = $.extend({}, originalEventObject);
                    copiedEventObject.start = date;
                    copiedEventObject.end= date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.className = $(this).attr("data-class");
                    copiedEventObject.backgroundColor = "rgb(248, 203, 0)";

                    //popup to create a new holiday
                    var url = "{{ route('hearing.createhearing',"ids:") }}";
                    url = url.replace('ids:', date);
                    $('#modalPermohonanCuti').modal('show')
                    .find('#modalBodyCuti')
                    .load(url);

                    $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
                        $('#modalBodyCuti').html('');
                    });

                    //initialize data to popup
                    var m =copiedEventObject.start;
                    m = m.format("DD/MM/YYYY");
                    sessionStorage.setItem('holiday_name',copiedEventObject.title);
                    sessionStorage.setItem('holiday_date_start',m);

                    //render cqalendar with new event
                    $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                    //checbox to remove
                    if ($('#drop-remove').is(':checked')) {
                        var url = $(this).find('.ajaxDeleteDocsButton').attr('href');
                        $.ajax({
                            url: url,
                            type: 'get',
                            success: function (response) {
                                if(response.status=='ok'){
                                    $.get('allevents', function(data){
                                          $("#event_box").html("")
                                          $.each(data, function(index, daeObj){
                                            var route = "{{-- route('holiday.destroyevent','ids:') --}}";
                                            route = route.replace('ids:',daeObj.holiday_event_id);
                                              $('#event_box').append('<div class="external-event label label-default ui-draggable ui-draggable-handle" style="clear: both;">' + daeObj.holiday_event_name + '&nbsp;&nbsp;<a class="ajaxDeleteDocsButton" href="' + route + '" ><i class="fa fa-close"></a></i></div>');
                                          });
                                    });
                                }
                                // else{
                                //     swal("Gagal!", "Data gagal dipadam.", "error");
                                // }
                            }
                        });
                        $(this).remove();
                    }
                },
                    
                    
                eventMouseover: function (data, event, view) {

                    tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#d9d9d9;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;"> {{ __('new.name')}} : ' + data.nama + '</br>{{ __('new.location')}} : ' + data.Lokasi + '<br>{{ __('new.time')}} : ' + data.Masa + '</br>{{ __('new.venue')}} : ' + data.Tempat + '<br>{{ __('new.room')}} : ' + data.Bilik + '';


                    $("body").append(tooltip);
                    $(this).mouseover(function (e) {
                        $(this).css('z-index', 10000);
                        $('.tooltiptopicevent').fadeIn('500');
                        $('.tooltiptopicevent').fadeTo('10', 1.9);
                    }).mousemove(function (e) {
                        $('.tooltiptopicevent').css('top', e.pageY + 10);
                        $('.tooltiptopicevent').css('left', e.pageX + 20);
                    });
                },
                eventMouseout: function (data, event, view) {
                    $(this).css('z-index', 8);

                    $('.tooltiptopicevent').remove();

                },
                dayClick: function(date, jsEvent, view) {     

                    var m = date;
                    var m = m.format("YYYY-MM-DD");
                    var n = new Date();
                    var n = n.customFormat( "#YYYY#-#MM#-#DD#" );
                    if(m < n) {
                        swal({
                        title: "{{ trans('holiday.sorry') }}",
                        text: "{{ trans('hearing.disabled_date') }}",
                        type: "error",
                        closeOnConfirm: false,
                        closeOnCancel: true,
                        showLoaderOnConfirm: true
                        });
                    }else{
                        var url = "{{ route('hearing.createhearing',"ids:") }}";
                        url = url.replace('ids:', m);
                        $('#modalPermohonanCuti').modal('show')
                        .find('#modalBodyCuti')
                        .load(url);

                        $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
                            $('#modalBodyCuti').html('');
                        });
                    }
                    
                    var m = date.format("DD/MM/YYYY");
                    sessionStorage.setItem('setHear',m);
                    // setTimeout(function(){ $('#hearing_date').val(m); }, 1000);
                },
                eventClick:  function(event, jsEvent, view) {

                    var m = event.start;
                    var m = m.format("DD/MM/YYYY");


                    var m = date;
                    var m = m.format("YYYY-MM-DD");
                    var n = new Date();
                    var n = n.customFormat( "#YYYY#-#MM#-#DD#" );
                    if(m < n) {
                        swal({
                        title: "{{ trans('holiday.sorry') }}",
                        text: "{{ trans('hearing.disabled_date') }}",
                        type: "error",
                        closeOnConfirm: false,
                        closeOnCancel: true,
                        showLoaderOnConfirm: true
                        });
                    }else{
                        $('#modalPermohonanCuti').modal('show')
                        .find('#modalBodyCuti')
                        .load(event.href);

                        $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
                            $('#modalBodyCuti').html('');
                        });
                    }
                    
                },
                events: [
                @if(!empty($schedule))
                    @foreach($schedule as $s)
                    {
                        title: "{{ $s->president->name or __('new.havent_choose') }}",
                        start: "{{ date('m/d/Y', strtotime(strtr($s->hearing_date, '-', '/'))) }}",
                        end: "{{ date('m/d/Y', strtotime(strtr($s->hearing_date, '-', '/'))) }}",
                        nama: "{{ $s->president->name or __('new.havent_choose') }}",
                        Lokasi: "{{ $s->branch ? $s->branch->branch_name : '' }}",
                        Masa  : "{{ date('h:i a', strtotime($s->hearing_time)) }}",
                        Tempat: "{{ $s->hearing_room ? $s->hearing_room->venue->hearing_venue : '-'}}",
                        Bilik : "{{ $s->hearing_room ? $s->hearing_room->hearing_room : '-' }}",
                        backgroundColor: App.getBrandColor("green-seagreen"),
                        editable: true,
                        href: "{{ route('hearing.edithearing',$s->hearing_id) }}",
                        allDay: false,
                    },
                    @endforeach
                @endif
                ],
                

                })
            }
        }                                                                                               
    }
}();
jQuery(document).ready(function() {
    AppCalendar.init()
});

@include('components.js.customdate')
</script>

<script type="text/javascript">
// @if(!empty($holiday_event))
//     @foreach($holiday_event as $he)
//         var a = "{{$he->holiday_event_name or ''}}";
//         var html = '<div class="external-event label label-default ui-draggable ui-draggable-handle" style="clear: both;">' + a + '&nbsp;&nbsp;<a class="ajaxDeleteDocsButton" href="{{-- route('holiday.destroyevent',$he->holiday_event_id) --}}" ><i class="fa fa-close"></a></i></div>';
//         $('#event_box').append(html);
//     @endforeach
// @endif
</script>

<script type="text/javascript">
function compareDateD(obj){
    targetcompare ='#holiday_date_end';
    if(obj.value > $(targetcompare).val() && $(targetcompare).val() != null){
        swal({
        title: "{{ trans('holiday.sorry') }}",
        text: "{{ trans('holiday.date_exceed') }}",
        type: "error",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
        });
        owning ='#holiday_date_start';
        $(owning).val([]);
    }
}
function compareDateH(obj){
    targetcompare ='#holiday_date_start';
    if(obj.value < $(targetcompare).val() && $(targetcompare).val() != null){
        swal({
        title: "{{ trans('holiday.sorry') }}",
        text: "{{ trans('holiday.date_less') }}",
        type: "error",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
        });
        owning ='#holiday_date_end';
        $(owning).val([]);
    }
}
</script>


<script type="text/javascript">
$('body').on('click', '.ajaxDeleteSchedules', function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    swal({
        title: "{{ trans('swal.sure') }} ?",
        text: "{{ trans('swal.data_deleted') }} !",
        type: "info",
        showCancelButton: true,
        cancelButtonClass: "btn-danger",
        confirmButtonClass: "green meadow",
        confirmButtonText: "{{ trans('button.delete') }}",
        cancelButtonText: "{{ trans('button.cancel') }}",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    },
    function(isConfirm) {
        if (isConfirm) {
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
                        $('.modal.in').modal('hide');
                        $('#holidays').DataTable().draw(false);
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

$('body').on('click', '.ajaxUpdateSchedule', function(e){
    e.preventDefault();
    $('#modalPermohonanCuti').modal('show')
    .find('#modalBodyCuti')
    .load($(this).attr('href'));

    $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
        $('#modalBodyCuti').html('');
    });
});

$('body').on('click', '.btnModalView', function(e){
    e.preventDefault();
    $('#modalPermohonanCuti').modal('show')
    .find('#modalBodyCuti')
    .load($(this).attr('href'));

    $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
        $('#modalBodyCuti').html('');
    });
});
</script>
@endsection