@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .disabled{
        background: #f0bbbb;
        opacity: 3;
    }
</style>
@endsection

@section('heading', 'Roles')

@section('content')
<nav class="quick-nav showit" style="display: none;margin-top: -6.5%!important;">
    <a class="quick-nav-trigger" href="#0">
        <span aria-hidden="true"></span>
    </a>
    <ul>
        <li>
            <a target="_blank" class="active">
                <span>{{ __('new.accept')}}</span>
                <i class="fa fa-check ajaxAcceptList"></i>
            </a>
        </li>
    </ul>
    <span aria-hidden="true" class="quick-nav-bg"></span>
</nav>
<div class="quick-nav-overlay"></div>

<div class="row margin-top-10">
  <div class="col-md-12">
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <i class="fa fa-list"></i>
                <span class="caption-subject bold uppercase">{{ trans('hearing.list_president_schedule') }}</span>
            </div>
            <div class="tools"> </div>
        </div>
        <div class="clearfix">


        @if(Auth::user()->hasRole('psu-hq') || Auth::user()->hasRole('ks-hq') || Auth::user()->hasRole('admin'))
        <div class="row">
            <div class="col-md-3">
                <label><b> {{ trans('hearing.president_name') }} </b></label>
            </div>
            <div class="col-md-4">
                <select required class="form-control" id="president_id" name="president_id"  data-placeholder="---">
                    <option value="" disabled selected>---</option>
                    @foreach ($psus as $psu)
                    <option value="{{ $psu->user_id }}">{{ $psu->user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        @endif
            <div class="col-md-12 col-sm-12">
            	<div id="calendar" class="has-toolbar"> </div>
            </div>
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

<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

<!--sweetalert -->
<script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<!-- <script src="{{ URL::to('/assets/apps/scripts/calendar.min.js') }}" type="text/javascript"></script> -->
<script src="{{ URL::to('/assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
@if(App::getLocale() == 'my')
<script src="{{ URL::to('/assets/global/plugins/fullcalendar/lang/my.js') }}" type="text/javascript"></script>
@endif

<script type="text/javascript">
$('body').on('click', '.fc-day', function(e){
    var fields = $(".fc-bg .fc-highlight");
    var com = 0;
    $.each(fields, function(i, field) {
    if (field.classList.contains( "fc-highlight" )){
          com++;
    }});
    if(com > 0){
        $('.showit').show();
    }
    else{
        $('.showit').hide();
    }
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
                        revertDuration: 0, //  original position after the drag
                        select: 'multiple' //  original position after the drag
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
                                title: "{{ __('holiday.sorry')}}",
                                text: "{{ __('holiday.event_has_exist')}}",
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
                $("#calendar").fullCalendar("destroy"),
                $("#calendar").fullCalendar({
                    header: r,
                    defaultView: "month",
                    slotMinutes: 15,
                    editable: 'false',
                    droppable: !0,
                    displayEventTime: false,
                    buttonText: {
                        today:    '{{ __("new.today") }}',
                        month:    '{{ __("new.month") }}',
                        week:     '{{ __("new.week") }}',
                        day:      '{{ __("new.day") }}',
                        list:     '{{ __("new.list") }}'
                    },

                dayRender: function(date, cell){
                    // date._d.getMonth();
                    // dates = ('0' + date._d.getMonth()).slice(-2);
                    today = '{{ date("Y-m-d") }}';
                    @if(Auth::user()->hasRole('psu-hq') || Auth::user()->hasRole('ks-hq') || Auth::user()->hasRole('admin'))
                        // if (date._d.customFormat( "#YYYY#-#MM#-#DD#" ) <= today ) {
                        //     $(cell).addClass('disabled');
                        // }
                        if ((date._d.getMonth() + 1) <= {{ date("m") }} && date._d.getFullYear() <= {{ date("Y") }} ) {
                            $(cell).addClass('disabled');
                        }
                    @elseif(Auth::user()->hasRole('presiden'))
                        if ((date._d.getMonth() + 1) <= {{ date("m") }} && date._d.getFullYear() <= {{ date("Y") }} ) {
                            $(cell).addClass('disabled');
                        }
                    @else
                        if ((date._d.getMonth() + 1) <= {{ date("m") }} && date._d.getFullYear() <= {{ date("Y") }} ) {
                            $(cell).addClass('disabled');
                        }
                    @endif
                },
                drop: function(date, allDay) {
                    var originalEventObject = $(this).data('eventObject');
                    var copiedEventObject = $.extend({}, originalEventObject);
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;
                    copiedEventObject.className = $(this).attr("data-class");
                    copiedEventObject.backgroundColor = "rgb(248, 203, 0)";

                    //popup to create a new holiday
                    var url = "{{-- route('holiday.createholiday') --}}";
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
                                }else{
                                    swal("{{ __('swal.fail')}}", "{{ __('swal.fail_deleted')}}", "error");
                                }
                            }
                        });
                        $(this).remove();
                    }
                },
                    
                    
                eventMouseover: function (data, event, view) {

                    /*tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#d9d9d9;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">Nama : ' + data.nama + '</br>Masa : ' + data.Masa + '</br>';*/


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
                        if(!$("td[data-date="+date.format('YYYY-MM-DD')+"]").hasClass( "disabled" ) )
                            $("td[data-date="+date.format('YYYY-MM-DD')+"]").toggleClass("fc-highlight");
                        else{
                            swal({
                                title: "{{ trans('holiday.sorry') }}",
                                text: "{{ __('swal.disabled')}}",
                                type: "error",
                                timer: 500,
                                showConfirmButton: false,
                            });
                        }
                    }
                    
                },
                eventClick:  function(event, jsEvent, view) {
                    var m = event.start;
                    var m = m.format("YYYY-MM-DD");
                         
                    $('#modalPermohonanCuti').modal('show')
                    .find('#modalBodyCuti')
                    .load(event.href);

                    $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
                        $('#modalBodyCuti').html('');
                    });
                },
                events: [
                @if(!empty($schedule))
                    @foreach($schedule as $h)
                    {
                        title: "{{ $h->president->name }}",
                        start: "{{ date('m/d/Y', strtotime($h->suggest_date)) }}",
                        end: "{{ date('m/d/Y', strtotime($h->suggest_date)) }}",
                        nama: "{{ $h->president->name }}",
                        Masa : "{{ date('h:i a', strtotime($h->hearing_time)) }}",
                        backgroundColor: App.getBrandColor("green-seagreen"),
                        editable: true,
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
$('body').on('click', '.ajaxAcceptList', function(e){
    var fields = $(".fc-bg .fc-highlight");
    var sentlist = [];
    var listing = '';
    $.each(fields, function(i, field) {
        if (field.classList.contains( "fc-highlight" )){
            sentlist[i] = $(field).attr('data-date');
            listing = listing + '<tr><td>'+(i+1)+'</td><td>'+moment($(field).attr('data-date'), 'YYYY-MM-DD').format('DD/MM/YYYY');+'</td></tr>';
        }
    });

    var user = 1;var col = 1;
    @if(Auth::user()->hasRole('PSU (HQ)') || Auth::user()->hasRole('ketua-seksyen') || Auth::user()->hasRole('admin'))
        user = $('#president_id').val();
        if(user == '' || user == null){
            col = 0;
        }
        console.log(user);
    @elseif(Auth::user()->hasRole('presiden'))
        user = "{{Auth::user()->user_id}}";
        col = 1;
        console.log(user);
    @else
        user = $('#president_id').val();
        if(user == '' || user == null){
            col = 0;
        }
        console.log(user);
    @endif

    if(col == 1){ 
        newlisting = '<div style="margin-left:3%;"><text>{{ __('holiday.notes')}}</text><center><table class="table table-striped table-bordered table-hover" style="width:60%"><tr><th style="width:7%">{{ __('holiday.no')}}&nbsp;&nbsp;</th><th>{{ __('holiday.date')}}</th></tr>'+listing+'</table></center></div>';
        swal({html:true,title: "{{ __('new.send_suggested_date') }}",text: newlisting,type: "info",showCancelButton: true,
            confirmButtonClass: "green-meadow",cancelButtonClass: "btn-danger",confirmButtonText: "{{ __('button.submit')}}",cancelButtonText: "{{ __('button.cancel')}}",
            closeOnConfirm: false,closeOnCancel: true,showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: "{{route('president_schedule.sentdate')}}",
                    type: 'post',
                    data: {_token: "{{csrf_token()}}",sentlist: sentlist,user: user},
                    success: function (response) {
                        if(response.status=='ok'){
                            swal({
                                title: "{{ __('swal.success')}}",
                                text: "{{ __('swal.submit_success')}}",
                                type: "success",
                                timer: 500,
                                showConfirmButton: false,
                            });
                            window.location.reload(true);
                        }else if(response.status=='fail'){
                            @if(Auth::user()->hasRole('PSU (HQ)') || Auth::user()->hasRole('ketua-seksyen') || Auth::user()->hasRole('admin'))
                            swal({
                                title: "{{ __('holiday.sorry')}}",
                                text: "{{ __('holiday.suggest_date')}} " + response.name + "{{ __('holiday.month_submit')}}",
                                type: "error",
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            });
                            $(".fc-highlight").removeClass("fc-highlight");
                            @else
                            swal({
                                title: "{{ __('holiday.sorry')}}",
                                text: "{{ __('holiday.suggest_date_month')}}",
                                type: "error",
                                closeOnConfirm: false,
                                closeOnCancel: true,
                                showLoaderOnConfirm: true
                            });
                            $(".fc-highlight").removeClass("fc-highlight");
                            @endif
                        }else{
                            swal("{{ __('swal.fail')}}", "{{ __('swal.fail_submit_date')}}", "error");
                        }
                        $('.showit').hide();
                        // $('#senarai-pemilihan-lpf').DataTable().draw();
                        // $('#senarai-print-lpf').DataTable().draw();
                    }
                });
                return false;
            }else{
                 swal("{{ __('swal.fail')}}", "{{ __('swal.fail_submit_date')}}", "error");
            }
        })
    }
    else{
        swal({
            title: "{{ __('holiday.sorry')}}",
            text: "{{ __('swal.choose_president')}}",
            type: "error",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        });
    }
});
</script>
@endsection