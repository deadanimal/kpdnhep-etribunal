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
    <form action="{{ route('president_schedule.storeschedule') }}" class="form-horizontal" method="post" role="form" id="submitschedule">
    {{csrf_field()}}
    <table class="table table-striped table-bordered table-advance table-hover">
        <tbody>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.president_name') }} </b></td>
                <td>
                    <select required class="form-control" id="president_id" name="president_id"  data-placeholder="---">
                        <option value="" disabled selected>---</option>
                        @foreach ($psus as $psu)
                        <option value="{{ $psu->user_id }}">{{ $psu->user->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr> 
                <td style="width:25%"><b> {{ trans('hearing.state') }} </b></td>
                <td>
                    <select required class="form-control" id="state_id" name="state_id"  data-placeholder="---">
                        <option value="" disabled selected>---</option>
                        @foreach ($masterState as $ms)
                        <option value="{{ $ms->state_id }}">{{ $ms->state }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.ttpm_branch') }} </b></td>
                <td>
                    <select required class="form-control" id="branch_id" name="branch_id"  data-placeholder="---">
                        <option value="" disabled selected>---</option>
                        @foreach ($masterBranch as $mb)
                        <option value="{{ $mb->branch_id }}">{{ $mb->branch_name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.place_hearing') }} </b></td>
                <td>
                    <select required class="form-control" id="district_id" name="district_id"  data-placeholder="---">
                        <!-- <option value="" disabled selected>---</option> -->
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.hearing_room') }} </b></td>
                <td>
                    <select required class="form-control" id="hearing_room_id" name="hearing_room_id"  data-placeholder="---">
                        <!-- <option value="" disabled selected>---</option> -->
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.hearing_date') }} </b></td>
                <td><input class="form-control" name="hearing_date" id="hearing_date" type="text" value="" /></td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.time') }} </b></td>
                <td><input class="form-control" name="hearing_time" id="time" type="text" value="" /></td>
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
      format: "dd/mm/yyyy",autoclose: true,value:'17/08/2017'
    });
    $('#time').timepicker({autoclose: true
    });
  })
</script>

<script type="text/javascript">
// $(function () {   
    $('body').on('change', '#region1', function(e){
        if($('#region1').is(':checked')){
            $("#checkbox4,#checkbox5,#checkbox6,#checkbox7,#checkbox8,#checkbox9,#checkbox12,#checkbox13").prop('checked', true);
        }
        else if($('#region1').is(":not(:checked)")){
            $("#checkbox4,#checkbox5,#checkbox6,#checkbox7,#checkbox8,#checkbox9,#checkbox12,#checkbox13").prop('checked', false);
        }
    });
    $('body').on('change', '#region2', function(e){
        if($('#region2').is(':checked')){
            $("#checkbox1,#checkbox2,#checkbox3,#checkbox13").prop('checked', true);
        }
        else if($('#region2').is(":not(:checked)")){
            $("#checkbox1,#checkbox2,#checkbox3,#checkbox13").prop('checked', false);
        }
    }); 
    $('body').on('change', '#region3', function(e){
        if($('#region3').is(':checked')){
            $("#checkbox10,#checkbox11").prop('checked', true);
        }
        else if($('#region3').is(":not(:checked)")){
            $("#checkbox10,#checkbox11").prop('checked', false);
        }
    }); 
    $('body').on('change', '#region4', function(e){
        if($('#region4').is(':checked')){
            $("#checkbox14,#checkbox15,#checkbox16").prop('checked', true);
        }
        else if($('#region4').is(":not(:checked)")){
            $("#checkbox14,#checkbox15,#checkbox16").prop('checked', false);
        }
    });    
// });
</script>

<script type="text/javascript">
$("#storepresidentschedule").on("click", function(e) {
    e.preventDefault();
    var url = "{{route('president_schedule.storeschedule')}}";
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
    if($('#hearing_date').val() > targetcompare && targetcompare != ''){
        swal({
            title: "{{ trans('holiday.sorry') }}",
            text: "{{ trans('hearing.disabled_date') }}",
            type: "error",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        });
        $('#hearing_date').val("{{date('m/d/Y')}}");
    }
    console.log(targetcompare + '>' + $('#hearing_date').val());
});


@include('components.js.ajaxdistrict',[
    'scriptTag' => false,
    'district_id' => '#district_id',
    'state_id' => '#state_id',
])

@include('components.js.ajaxhearingroom',[
    'scriptTag' => false,
    'hearing_id' => '#hearing_room_id',
    'state_id' => '#state_id',
])

</script>