@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet"
          type="text/css"/>
    <style type="text/css">
        .select2 {
            width: 200px !important;
        }
    </style>
@endsection

@section('content')
    <nav class="quick-nav showit" style="display: none;margin-top: -6.5%!important;">
        <a class="quick-nav-trigger" href="#0">
            <span aria-hidden="true"></span>
        </a>
        <ul>
            <li>
                <a target="_blank" class="active">
                    <span>{{ __('hearing.accept')}}</span>
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
                        <span class="caption-subject bold uppercase">{{ trans('menu.claim_no_hearing_date') }}</span>
                    </div>
                    <div class="tools"></div>
                </div>
                <div class=" col-md-8" style="margin-bottom: 20px;">
                    <div id="search-form" class="form-inline">
                        <div class="mb10">
                            <form id="search-form" class="" role="form" novalidate>
                                <div class="row margin-bottom-10">
                                    <div class="col-md-6">
                                        <div class="row" id="date">
                                            <label for="branch"
                                                   class="col-sm-4 control-label">{{ trans('hearing.branch') }}</label>
                                            <div class="col-sm-8">
                                                <select id="branch" class="form-control select2" name="branch"
                                                        data-placeholder="--------">
                                                    <option value="" disabled selected>
                                                        --{{ __('hearing.please_choose') }}--
                                                    </option>
                                                    @foreach($branch as $b)
                                                        <option value="{{$b->branch_id}}">{{$b->branch_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row" id="date">
                                            <label for="branch" class="col-sm-4 control-label">{{ 'Tahun' }}</label>
                                            <div class="col-sm-8">
                                                <select id="year" class="form-control select2" name="year"
                                                        data-placeholder="--------">
                                                    <option value="" disabled selected>--Year--</option>
                                                    <option value="{{date('Y')+1}}">{{date('Y')+1}}</option>
                                                    <option value="{{date('Y')}}"
                                                            selected="selected">{{date('Y')}}</option>
                                                    <option value="{{date('Y')-1}}">{{date('Y')-1}}</option>
                                                    <option value="{{date('Y')-2}}">{{date('Y')-2}}</option>
                                                    <option value="2015">2015</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row margin-bottom-10">
                                    <div class="col-md-6">
                                        <div class="row" id="date">
                                            <label for="branch" class="col-sm-4 control-label">{{ 'Bulan' }}</label>
                                            <div class="col-sm-8">
                                                <select id="month" class="form-control select2" name="month"
                                                        data-placeholder="--------">
                                                    <option value="" disabled selected>--Month--</option>
                                                    @for($i = 1; $i <13; $i++)
                                                        <option value="{{$i}}" {{ $i == date('m') ? "selected = 'selected'" : '' }}>{{Carbon\Carbon::createFromFormat('m-d', $i.'-1')->format('F')}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="btn btn-primary"
                                                     onclick="loadHearing()">{{__('new.search')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label for="hearing_date"
                                                   class="col-sm-4 control-label">{{ trans('hearing.date') }}</label>
                                            <div class="col-sm-8">
                                                <select id="hearing_date" class="form-control select2"
                                                        name="hearing_date"
                                                        data-placeholder="--------" disabled="disabled">
                                                    <option value="" disabled selected>
                                                        --{{ __('hearing.please_choose') }}
                                                        --
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <table id="witness" class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                        <tr align="center">
                            <th width="3%">{{ trans('hearing.no') }}</th>
                            <th width="3%"></th>
                            <th>{{ trans('form1.claim_no') }}</th>
                            <th>{{ trans('form1.matured_date') }}</th>
                            <th>{{ trans('form1.claimant') }}</th>
                            <th>{{ trans('form1.opponent') }}</th>
                            <th>{{ trans('new.type') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @endsection

        @section('after_scripts')
            <script src="{{ URL::to('/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/datatables/datatables.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
                    type="text/javascript"></script>

            <script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}"
                    type="text/javascript"></script>

            <!--sweetalert -->
            <script src="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}"
                    type="text/javascript"></script>
            <script src="{{ URL::to('/assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
            <script src="{{ URL::to('/assets/layouts/global/scripts/quick-nav.min.js') }}"
                    type="text/javascript"></script>
            <!--end sweetalert -->
            <script type="text/javascript">

              function loadHearing() {
                $('#hearing_date').attr('disabled', 'disabled')
                var branch = $('#branch').val()
                var year = $('#year').val()
                var month = $('#month').val()
                $('#hearing_date').empty()
                $('#hearing_date').append('<option value="" disabled selected>--{{ trans('hearing.please_choose')}}--</option>')
                $.get('{{ url('/') }}/branch/' + branch + '/hearings?year=' + year + '&month=' + month)
                  .then(function (data) {
                    $.each(data, function (key, hearings) {
                      $.each(hearings, function (k, hearing) {
                        console.log(hearing)
                        if (hearing.hearing_room === null)
                          $('#hearing_date').append('<option value=\'' + hearing.hearing_id + '\'>' + hearing.hearing_date + ' ' + hearing.hearing_time + '</option>')
                        else
                          $('#hearing_date').append('<option value=\'' + hearing.hearing_id + '\'>' + hearing.hearing_date + ' ' + hearing.hearing_time + ' (' + hearing.hearing_venue + ' : ' + hearing.hearing_room + ')</option>')
                      })
                    })
                    $('#hearing_date').removeAttr('disabled')
                  }, function (err) {
                    console.error(err)
                  })
              }
            </script>
            <script type="text/javascript">
              $('body').on('click', '.btnModalPeranan', function () {
                $('#modalperanan').modal('show')
                  .find('#modalbodyperanan')
                  .load($(this).attr('value'))
              })
              $('#modalperanan').on('hidden.bs.modal', function () {
                $('#modalbodyperanan').html('')
              })
            </script>

            <script>
                @include('hearing_claim_case.partial.datatablejs',[
                  'var' => 'Datatable',
                  'table' => '#witness',
                  'destroy' => 'true',
                  'processing' => 'true',
                  'serverSide' => 'true',
                  'columns' => [
                      'checkbox' => 'checkbox',
                      'case_no' => 'claimCase.case_no',
                      'matured_date' => 'claimCase.form1.matured_date',
                      'claimant' => 'claimant_address.name',
                      'opponent' => 'opponent_address.name',
                      //'status' => 'status',
                      'type' => 'type',
                      // 'tindakan' => 'tindakan',
                  ],
                  'ajax' => route('hearing_claim_case.listhearingcc'),
                  'order' => '0',
                  'deferRender' => 'true',
                  'buttons' => true,
                ])

                $('#hearing_date').on('change', function (e) {
                  e.preventDefault()
                  // $('#searchprogress').show('fast', function(){
                  //   $(this).delay(1000).hide('fast', function(){
                  var branch = $('#branch').val()
                  var hearing_date = $('#hearing_date').val()

                  if (branch != '' && hearing_date != '') {
                      @include('hearing_claim_case.partial.datatablejs',[
                        'var' => 'Datatable',
                        'table' => '#witness',
                        'destroy' => 'true',
                        'processing' => 'true',
                        'serverSide' => 'true',
                        'ajax' => route('hearing_claim_case.tablehearingcc'),
                        'data' =>[
                          'branch' => 'branch',
                          'hearing_date' => 'hearing_date',
                        ],
                        'columns' => [
                            'checkbox' => 'checkbox',
                            'case_no' => 'claim_case.case_no',
                            'matured_date' => 'form1.matured_date',
                            'claimant' => 'claimant',
                            'opponent' => 'opponent',
                            //'status' => 'status',
                            'type' => 'type',
                            // 'tindakan' => 'tindakan',
                        ],
                        'order' => '0',
                        'deferRender' => 'true',
                        'buttons' => true,
                      ])
                      Datatable.ajax.reload()
                    e.preventDefault()
                  }

                  //   });
                  // });
                })
            </script>
            <script type="text/javascript">
              $('body').on('change', '.checkterima', function (e) {
                var fields = $('.checkterima').serializeArray()
                var com = 0
                console.log(fields)
                $.each(fields, function (i, field) {
                  if (!field.checked) {
                    com++
                  }
                })
                if (com > 0) {
                  $('.showit').show()
                } else {
                  $('.showit').hide()
                }
              })
            </script>

            <script type="text/javascript">
              $('body').on('click', '.ajaxAcceptList', function (e) {
                var fields = $('.checkterima').serializeArray()
                var sentlist = []
                $.each(fields, function (i, field) {
                  if (!field.checked) {
                    sentlist[ i ] = field.value
                  }
                })
                $.ajax({
                  url: "{{route('hearing_claim_case.namelist')}}",
                  type: 'post',
                  data: {
                    _token: "{{csrf_token()}}",
                    sentlist: sentlist
                  },
                  success: function (response) {
                    if (response.listcase != '[]') {
                      data = response.listcase
                      var listing = ''
                      sessionStorage.setItem('data', JSON.stringify(response.idcase))
                      var i = 1
                      $.each(data, function (index, daeObj) {
                        listing = listing + '<tr><td>' + (i++) + '</td><td>' + daeObj + '</td></tr>'
                      })
                      // newlisting = '<div style="margin-left:3%;"><center><table class="table table-striped table-bordered table-hover"><tr><th style="width:10%">Bil</th><th>No Tuntutan</th></tr>'+listing+'</table><label>Tarikh</label><input type="text" name="hearing_dates" id="hearing_dates" class="form-control sebabTolak" style="width:100px" value=""><span class="sa-input-error help-block creatinger" style="display:none;color:#ff1a1a"><span class="glyphicon glyphicon-exclamation-sign"></span> <span class="sa-help-text">Sila Isi Sebab!</span></span></center></div>';

                      newlisting = '<div style="margin-left:3%;"><center><table class="table table-striped table-bordered table-hover"><tr><th style="width:10%">{{ __('hearing.no')}}</th><th>{{ __('hearing.claim_no')}}</th></tr>' + listing + '</table></center></div>'

                      setTimeout(function () {
                        $('#hearing_dates').datepicker({
                          format: 'dd/mm/yyyy', autoclose: true
                        })
                      }, 100)
                      swal({
                          html: true,
                          title: "{{ __('swal.set_hearing_date')}}",
                          text: newlisting,
                          type: 'info',
                          allowOutsideClick: true,
                          showCancelButton: true,
                          confirmButtonClass: 'btn green-meadow',
                          cancelButtonClass: 'btn-danger',
                          confirmButtonText: "{{ __('button.proceed')}}",
                          cancelButtonText: "{{ __('button.cancel')}}",
                          closeOnConfirm: false,
                          closeOnCancel: true,
                          showLoaderOnConfirm: true
                        },
                        function (isConfirm) {
                          if (isConfirm) {
                            var fields = $('#hearing_date').val()
                            var branchs = $('#branch').val()
                            console.log(fields)
                            if (fields == null || branchs == null) {
                              $('.creatinger').show()
                              setTimeout(function () {
                                sweetAlert.enableButtons()
                              }, 1)

                              swal({
                                title: "{{ trans('swal.error') }}",
                                text: "{{ __('swal.fill_branch_date')}}",
                                type: 'error',
                                confirmButtonText: 'OK',
                                closeOnConfirm: true
                              })
                              return false
                            } else if (fields != '') {
                              data = JSON.parse(sessionStorage.getItem('data'))
                              $.ajax({
                                url: "{{route('hearing_claim_case.sentchoosencase')}}",
                                type: 'post',
                                data: { _token: "{{csrf_token()}}", sentlist: data, branchs: branchs, fields: fields },
                                success: function (response) {
                                  if (response.status == 'ok') {
                                    swal({
                                      title: "{{ trans('swal.success') }}!",
                                      text: "{{ trans('swal.submit_success') }}",
                                      type: 'success',
                                      timer: 500,
                                      showConfirmButton: false
                                    })
                                  } else {
                                    swal("{{ trans('swal.fail') }}!", "{{ trans('swal.submit_failed') }}", 'error')
                                  }
                                  $('#witness').DataTable().draw()
                                  $('.showit').hide()
                                }
                              })
                              return false
                            }
                          }
                        })
                    }
                    //else{
                    //swal("{{ trans('swal.fail') }}!", "{{ trans('swal.submit_failed') }}", "error");
                    //}
                  }
                })
              })
            </script>
            <script type="text/javascript">

              $('#branch').val({{ Auth::user()->ttpm_data->branch_id }}).trigger('change')


              $('body').on('click', '.btnModalView', function (e) {
                e.preventDefault()

                var fields = $('#hearing_date').val()
                var branchs = $('#branch').val()
                if (fields == null || branchs == null) {
                  $('.creatinger').show()
                  setTimeout(function () {
                    sweetAlert.enableButtons()
                  }, 1)

                  swal({
                    title: "{{ trans('swal.error') }}",
                    text: "{{ __('swal.fill_branch_date') }}",
                    type: 'error',
                    confirmButtonText: 'OK',
                    closeOnConfirm: true
                  })
                  return false
                } else if (fields != '') {
                  swal({
                      html: true,
                      title: "{{ __('swal.set_date') }}",
                      text: "{{ __('button.proceed') }}",
                      type: 'info',
                      allowOutsideClick: true,
                      showCancelButton: true,
                      confirmButtonClass: 'btn green-meadow',
                      cancelButtonClass: 'btn-danger',
                      confirmButtonText: "{{ __('button.proceed') }}",
                      cancelButtonText: "{{ __('button.cancel') }}",
                      closeOnConfirm: false,
                      closeOnCancel: true,
                      showLoaderOnConfirm: true
                    },
                    function (isConfirm) {
                      if (isConfirm) {
                        $.ajax({
                          url: "{{route('hearing_claim_case.hearingsingleverify')}}",
                          type: 'post',
                          data: { _token: "{{csrf_token()}}", sentlist: data, branchs: branchs, fields: fields },
                          success: function (response) {
                            if (response.status == 'ok') {
                              swal({
                                title: "{{ __('swal.success') }}!",
                                text: "{{ __('button.submit_success') }}",
                                type: 'success',
                                timer: 500,
                                showConfirmButton: false
                              })
                            } else {
                              swal("{{ __('swal.fail') }}!", "{{ __('swal.submit_failed') }}", 'error')
                            }
                            $('#witness').DataTable().draw()
                            $('.showit').hide()
                          }
                        })
                      }
                    })
                  return false
                }
              })
            </script>


@endsection