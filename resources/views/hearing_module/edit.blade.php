{{-- Pengesahan --}}
<!--plugin datepickers -->
<link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
      type="text/css"/>
<!-- tamat plugin datepickers -->
<style type="text/css">
    .sweet-overlay {
        z-index: 50000;
    }

    .sweet-alert {
        z-index: 50001;
    }

    .swal-modal {
        z-index: 50002;
    }

    .hardleft {
        left: 0px !important;
        top: 0px !important;
        align-content: center;
        position: relative !important;
        max-height: 400px;
        min-height: 400px;
        max-width: 240px;
        min-width: 240px
</style>
<div class="portlet-body">
    <form action="{{ route('hearing.updatehearing',$schedule->hearing_id) }}" class="form-horizontal" method="post"
          role="form" id="submitschedule">
        {{csrf_field()}}
        <table class="table table-striped table-bordered table-advance table-hover">
            <tbody>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.hearing_date') }} <span style="color: red;">*</span></b>
                </td>
                <td><input class="form-control" name="hearing_date" id="hearing_date" type="text"
                           value="{{ date('d/m/Y', strtotime(strtr($schedule->hearing_date, '-', '/'))) }}"/></td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.president_name') }} <span style="color: red;">*</span></b>
                </td>
                <td>
                    <select required class="form-control " id="president_id" name="president_id" data-placeholder="---">
                        <option value="" disabled selected>---</option>
                        {{--
                        @foreach ($psus as $psu)
                        <option 
                        @if($schedule)
                            @if($schedule->president)
                                @if($schedule->president->user_id == $psu->user_id)
                                selected
                                @endif
                            @endif
                        @endif
                        value="{{ $psu->user_id }}">{{ $psu->user->name }}</option>
                        @endforeach
                        --}}
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.state') }} </b></td>
                <td>
                    <select required class="form-control" id="state_id" name="state_id" data-placeholder="---">
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
                    <select required class="form-control" id="branch_id" name="branch_id" data-placeholder="---">
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.place_hearing') }} </b></td>
                <td>
                    <select required class="form-control" id="hearing_venue_id" name="hearing_venue_id"
                            data-placeholder="---">
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.hearing_room') }} </b></td>
                <td>
                    <select required class="form-control bs-select" id="hearing_room_id" name="hearing_room_id"
                            data-placeholder="---">
                    </select>
                </td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.time') }} <span style="color: red;">*</span></b></td>
                <td><input class="form-control" name="hearing_time" id="time" type="text"
                           value="{{ $schedule->hearing_time or ''}}"/></td>
            </tr>
            <tr>
                <td style="width:25%"><b> {{ trans('hearing.remark') }} <span style="color: red;">*</span></b><br></td>
                <td><textarea class="form-control" name="hearing_remark" id="hearing_remark" rows="5"></textarea></td>
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
<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<!-- tamat plugin datepickers -->
<script type="text/javascript">
  $(document).ready(function () {
    $('#hearing_date').datepicker({
      format: 'dd/mm/yyyy', autoclose: true
    })
    $('#time').timepicker({
      autoclose: true, minuteStep: 1
    })
  })
  $('body').on('change', '#region1', function (e) {
    if ($('#region1').is(':checked')) {
      $('#checkbox4,#checkbox5,#checkbox6,#checkbox7,#checkbox8,#checkbox9,#checkbox12,#checkbox13').prop('checked', true)
    } else if ($('#region1').is(':not(:checked)')) {
      $('#checkbox4,#checkbox5,#checkbox6,#checkbox7,#checkbox8,#checkbox9,#checkbox12,#checkbox13').prop('checked', false)
    }
  })
  $('body').on('change', '#region2', function (e) {
    if ($('#region2').is(':checked')) {
      $('#checkbox1,#checkbox2,#checkbox3,#checkbox13').prop('checked', true)
    } else if ($('#region2').is(':not(:checked)')) {
      $('#checkbox1,#checkbox2,#checkbox3,#checkbox13').prop('checked', false)
    }
  })
  $('body').on('change', '#region3', function (e) {
    if ($('#region3').is(':checked')) {
      $('#checkbox10,#checkbox11').prop('checked', true)
    } else if ($('#region3').is(':not(:checked)')) {
      $('#checkbox10,#checkbox11').prop('checked', false)
    }
  })
  $('body').on('change', '#region4', function (e) {
    if ($('#region4').is(':checked')) {
      $('#checkbox14,#checkbox15,#checkbox16').prop('checked', true)
    } else if ($('#region4').is(':not(:checked)')) {
      $('#checkbox14,#checkbox15,#checkbox16').prop('checked', false)
    }
  })
  // });
</script>

<script type="text/javascript">
  $('#storepresidentschedule').on('click', function (e) {
    e.preventDefault()
    var url = "{{ route('hearing.updatehearing',$schedule->hearing_id) }}"
    swal({
        title: "{{ trans('swal.sure') }}",
        text: "{{ trans('swal.data_confirm_send') }}",
        type: 'info',
        showCancelButton: true,
        confirmButtonClass: 'green-meadow',
        cancelButtonClass: 'btn-danger',
        confirmButtonText: "{{ trans('button.save') }}",
        cancelButtonText: "{{ trans('button.cancel') }}",
        closeOnConfirm: false,
        closeOnCancel: true,
        showLoaderOnConfirm: true
      },
      function (isConfirm) {
        if (isConfirm) {
          $.ajax({
            url: url,
            type: 'post',
            data: $('#submitschedule').serialize(),
            success: function (response) {
              if (response.status == 'ok') {
                swal({
                  title: "{{ trans('swal.success') }} !",
                  text: "{{ trans('swal.data_success') }} .",
                  type: 'success',
                  timer: 500,
                  showConfirmButton: false
                })
                $('.modal.in').modal('hide')
                $('#holidays').DataTable().draw(false)
                // window.location.reload(true);
              } else {
                swal(" {{ trans('swal.error') }} !", "  {{ trans('swal.data_failed') }} ", 'error')
              }
            }
          })
          return false
        }
      })
    $(window).off('beforeunload')
  })
</script>
<script type="text/javascript">
  // $('#hearing_date').on('change',function(){
  //     targetcompare = "{{date('d/m/Y')}}";
  //     if($('#hearing_date').val() > targetcompare && targetcompare != ''){
  //         swal({
  //             title: "{{ trans('holiday.sorry') }}",
  //             text: "{{ trans('hearing.disabled_date') }}",
  //             type: "error",
  //             closeOnConfirm: false,
  //             closeOnCancel: true,
  //             showLoaderOnConfirm: true
  //         });
  //         $('#hearing_date').val("{{date('d/m/Y')}}");
  //     }
  //     console.log(targetcompare + '>' + $('#hearing_date').val());
  // });

  $('#hearing_date').on('change', function () {
    targetcompare = Date.now()
    h = $('#hearing_date').val()
    h = h.replace('/', '-').replace('/', '-')

    h_tmp = h.split('-')
    h = h_tmp[ 2 ] + '-' + h_tmp[ 1 ] + '-' + h_tmp[ 0 ]

    //comment out sbb banyak nk kne wat backdate
    /*if(Date.parse(h) < targetcompare && targetcompare != ''){
        swal({
            title: "{{ trans('holiday.sorry') }}",
            text: "{{ trans('hearing.disabled_date') }}",
            type: "error",
            closeOnConfirm: false,
            closeOnCancel: true,
            showLoaderOnConfirm: true
        });
        $(this).val('');
    }
    else{*/
    var hearing_date = $('#hearing_date').val()
    //ajax
    $.ajax({
      url: "{{route('president_schedule.president')}}",
      type: 'POST',
      data: {
        _token: '{{csrf_token()}}',
        data: hearing_date
      },
      success: function (response) {
        $('#president_id').empty()

        $('#president_id').append('<option value="" disabled selected>---</option>')
        $.each(response, function (index, daeObj) {
          console.log(daeObj)
          $('#president_id').append('<option value="' + daeObj.user_id + '">' + daeObj.name + '<\/option>')
        })
      }
    })
    /*}
    console.log(targetcompare + '>' + h);*/
  })


  $('#state_id').on('change', function () {
    var state_id = $('#state_id').val()

    $.ajax({
      url: "{{ url('/') }}/state/" + state_id + '/hearings',
      type: 'GET',
      async: false,
      success: function (res) {

        data = res

        $('#branch_id').empty()
        $.each(data.branches, function (key, branch) {
          if (branch.is_active == 1)
            $('#branch_id').append('<option key=\'' + key + '\' value=\'' + branch.branch_id + '\'>' + branch.branch_name + '</option>')
        })

        $('#branch_id').trigger('change')
      }
    })
  })

  $('#branch_id').on('change', function () {
    branch_id = $('#branch_id option:selected').attr('key')

    //console.log(data.branches[branch_id].venues);

    $('#hearing_venue_id').empty()
    $('#hearing_venue_id').append('<option disabled selected>---</option>')
    $.each(data.branches[ branch_id ].venues, function (key, venue) {
      if (venue.is_active == 1)
        $('#hearing_venue_id').append('<option key=\'' + key + '\' value=\'' + venue.hearing_venue_id + '\'>' + venue.hearing_venue + '</option>')
    })

  })

  $('#hearing_venue_id').on('change', function () {
    hearing_venue_id = $('#hearing_venue_id option:selected').attr('key')

    //console.log(data.branches[branch_id].venues[hearing_venue_id]);

    $('#hearing_room_id').empty()
    $('#hearing_room_id').append('<option disabled selected>---</option>')
    $.each(data.branches[ branch_id ].venues[ hearing_venue_id ].rooms, function (key, room) {
      if (room.is_active == 1)
        $('#hearing_room_id').append('<option value=\'' + room.hearing_room_id + '\'>' + room.hearing_room + '</option>')
    })

  })

  $(document).ready(function () {
    $('#time').timepicker({
      autoclose: true
    })

      @if($schedule->state_id)
      $('#state_id').val({{ $schedule->state_id }}).trigger('change')
      @endif
      @if($schedule->branch_id)
      $('#branch_id').val({{ $schedule->branch_id }}).trigger('change')
      @endif
      @if($schedule->hearing_room)
      $('#hearing_venue_id').val({{ $schedule->hearing_room->hearing_venue_id }}).trigger('change')
    $('#hearing_room_id').val({{ $schedule->hearing_room_id }})
      @endif
      $('#hearing_date').trigger('change')
    //$("#state_id").val({{ $schedule->district_id }}).trigger('change'); 
      @if($schedule->president_user_id)
      $('#president_id').val({{ $schedule->president_user_id }}).trigger('change')
      @endif

  })
</script>