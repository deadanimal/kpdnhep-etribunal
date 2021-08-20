{{-- Pengesahan --}}
<!--plugin datepickers -->
<link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<!-- tamat plugin datepickers -->
<style type="text/css">
    .sweet-overlay{z-index:50000;}.sweet-alert{z-index:50001;}  .swal-modal{z-index:50002;}
    .hardleft {left: 0px!important;
        top: 0px!important;
        align-content: center;
        position: relative!important;   
        max-height: 400px;
        min-height: 400px;
        max-width: 240px;
        min-width: 240px
</style>
<div class="portlet-body">
    <form action="{{ route('president_schedule.updateschedule',$schedule->president_schedule_id) }}" class="form-horizontal" method="post" role="form" id="submitschedule">
    {{csrf_field()}}
    <table class="table table-striped table-bordered table-advance table-hover">
        <tbody>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.president_name') }} </b></td>
                <td>
                    <select required class="form-control " id="president_id" name="president_id"  data-placeholder="---">
                        <option value="" disabled selected>---</option>
                        @foreach ($psus as $psu)
                        <option 
                        @if($schedule)
                            @if($schedule->president->user_id)
                                @if($schedule->president->user_id == $psu->user_id) selected
                                @endif
                            @endif
                        @endif
                        value="{{ $psu->user_id }}">{{ $psu->user->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.hearing_date') }} </b></td>
                <td><input class="form-control" name="hearing_date" id="hearing_date" type="text" value="{{ date('d/m/Y', strtotime(strtr($schedule->suggest_date, '-', '/'))) }}" /></td>
            </tr>
        </tbody>
    </table>
    <center>
        <a class="btn green" id="storepresidentschedule"> {{ trans('button.save') }} </a>
    </center>
    </form>
</div>


<!--Plugin datepickers-->
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<!-- tamat plugin datepickers -->
<script type="text/javascript">
  $(document).ready(function () {
    $('#hearing_date').datepicker({
      format: "dd/mm/yyyy", autoclose: true, value: '17/08/2017'
    });
    $('#time').timepicker({
      autoclose: true
    });
  });
</script>

<script type="text/javascript">
$("#storepresidentschedule").on("click", function(e) {
    e.preventDefault();
    var url = "{{ route('president_schedule.updateschedule',$schedule->president_schedule_id) }}";
    swal({
        title: "{{ trans('swal.sure') }}",
        text: "{{ trans('swal.data_sent') }} !",
        type: "info",
        showCancelButton: true,
        confirmButtonClass: "green-meadow",
        cancelButtonClass: "btn-danger",
        confirmButtonText: "{{ trans('button.save') }}",
        cancelButtonText: "{{ trans('button.cancel') }}",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
    },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: url,
                type: 'post',
                data: $('#submitschedule').serialize(),
                success: function (response) {
                    if(response.status=='ok'){
                        swal({
                            title: "{{ trans('swal.success') }} !",
                            text: "{{ trans('swal.data_success') }} .",
                            type: "success",
                            timer: 500,
                            showConfirmButton: false,
                        });
                        $('.modal.in').modal('hide');
                        window.location.reload(true);
                    }else{
                        swal(" {{ trans('swal.error') }} !", "  {{ trans('swal.fail_deleted') }} ", "error");
                    }
                }
            });
            return false;
        }
    });
    $(window).off("beforeunload");
});
</script>
<script type="text/javascript">
$('#hearing_date').on('change',function(){
    targetcompare = "{{date('d/m/Y')}}";
    if($('#hearing_date').val() < targetcompare && targetcompare != ''){
        swal({
            title: "{{ trans('holiday.sorry') }}",
            text: "{{ trans('hearing.disabled_date') }}",
            type: "error",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        });
        $('#hearing_date').val('{{date("d/m/Y")}}');
        $('#hearing_date').val('');
    }
    console.log(targetcompare + '>' + $('#hearing_date').val());
});


$('#state_id').on('change', function(e){
    console.log(e);
    var state = e.target.value;

    $.get('{{  URL::to('state?state_id=') }}' + state, function(data) {
        var $district = $('#district_id');

        $district.removeAttr("disabled").end();

        $.each(data, function(index, district) {
            var a = "{{$schedule->district_id}}";
            if(district.district_id != a)
                $district.append('<option value="' + district.district_id + '">' + district.district + '</option>');
        });
        @if(!empty($inputEmpty))
        var district_id = {{ $inputEmpty }};
        $district.val(district_id).find('option[value="' + district_id +'"]').attr('selected', true);
        @endif
    });
}).change();

$('#state_id').on('change', function(e){
    console.log(e);
    var hearing = e.target.value;

    $.get('{{  URL::to('hearingroom?state_id=') }}' + hearing, function(data) {
        var $hearing = $('#hearing_room_id');

        $hearing.removeAttr("disabled").end();

        $.each(data, function(index, hearing) {
            var a = "{{$schedule->hearing_room_id}}";
            if(hearing.hearing_room_id != a)
                $hearing.append('<option value="' + hearing.hearing_room_id + '">' + hearing.hearing_room + '</option>');
        });
        @if(!empty($inputEmpty))
        var hearing_room_id = {{ $inputEmpty }};
        $hearing.val(hearing_room_id).find('option[value="' + hearing_room_id +'"]').attr('selected', true);
        @endif
    });
}).change();


$(document).ready(function () {
$('#hearing_date').datepicker({
    format: "dd/mm/yyyy",autoclose: true
});
$('#time').timepicker({autoclose: true
});
})
</script>