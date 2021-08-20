<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />

<div class="row">
    <div class="col-md-3 col-sm-12">
        <!-- BEGIN DRAGGABLE EVENTS PORTLET-->
        <h3 class="event-form-title margin-bottom-20">{{ __('hearing.event') }}</h3>
        <div id="external-events">
            <form class="inline-form">
                <input type="text" value="" class="form-control" placeholder="Event Title..." id="event_title" />
                <br/>
                <a href="javascript:;" id="event_add" class="btn green"> {{ __('hearing.add_event') }} </a>
            </form>
            <hr/>
            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline" for="drop-remove"> {{ __('hearing.remove_after')}}
                <input type="checkbox" class="group-checkable" id="drop-remove" />
                <span></span>
            </label>
            <div id="event_box" class="margin-bottom-10"></div>
            <hr class="visible-xs" /> </div>
        <!-- END DRAGGABLE EVENTS PORTLET-->
    </div>
    <div class="col-md-9 col-sm-12">
    	<div id="calendar" class="has-toolbar"> </div>
    </div>
</div>

<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/fullcalendar/fullcalendar.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<!-- <script src="{{ URL::to('/assets/apps/scripts/calendar.min.js') }}" type="text/javascript"></script> -->
@if(App::getLocale() == 'my')
<script src="{{ URL::to('/assets/global/plugins/fullcalendar/lang/my.js') }}" type="text/javascript"></script>
@endif
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
                    right: "prev,next,today,month"
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
                    title = title.length === 0 ? "{{ __('hearing.untitle')}}" : title;

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
                                title: "Sorry",
                                text: "{{ __('hearing.event_exist')}}",
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

				
				@foreach($holiday_event as $he)
				    var a = "{{$he->holiday_event_name or ''}}";
				    var html = '<div class="external-event label label-default ui-draggable ui-draggable-handle" style="position: relative;">' + a + '&nbsp;&nbsp;<a class="ajaxDeleteDocsButton" href="{{-- route('holiday.destroyevent',$he->holiday_event_id) --}}" ><i class="fa fa-close"></a></i></div>';
				    jQuery('#event_box').append(html);
                    // initDrag(html);
				@endforeach


                $("#calendar").fullCalendar("destroy"),
                $("#calendar").fullCalendar({
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
                                    swal("{{ __('swal.fail') }}", "{{ __('swal.fail') }}", "error");
                                }
                            }
                        });
                        $(this).remove();
                    }
                },
                    
                    
                eventMouseover: function (data, event, view) {

                    tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#d9d9d9;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">' + 'Cuti : ' + data.nama + '</br>';


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
                    var url = "{{-- route('holiday.createholiday') --}}";
                    $('#modalPermohonanCuti').modal('show')
                    .find('#modalBodyCuti')
                    .load(url);

                    $('#modalPermohonanCuti').on('hidden.bs.modal', function(){
                        $('#modalBodyCuti').html('');
                    });
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
                @if(!empty($holiday))
                    @foreach($holiday as $h)
                    {
                        title: "{{ $h->holiday_name }}",
                        start: "{{ date('d/m/Y', strtotime($h->holiday_date_start)) }}",
                        end: "{{ date('d/m/Y', strtotime($h->holiday_date_end)) }}",
                        nama: "{{ $h->holiday_name }}",
                        backgroundColor: App.getBrandColor("green-seagreen"),
                        editable: true,
                        href: "{{-- route('holiday.editholiday',$h->holiday_id) --}}",
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
        confirmButtonText: "{{ t{{ trans('button.cancel') }}",
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
<!-- <script type="text/javascript">
@foreach($holiday_event as $he)
    var a = "{{$he->holiday_event_name or ''}}";
    var html = '<div class="external-event label label-default ui-draggable ui-draggable-handle" style="position: relative;">' + a + '&nbsp;&nbsp;<a class="ajaxDeleteDocsButton" href="{{-- route('holiday.destroyevent',$he->holiday_event_id) --}}" ><i class="fa fa-close"></a></i></div>';
    $('#event_box').append(html);
@endforeach
</script> -->