<?php
$is_edit = (strpos(Request::url(), 'edit') !== false);
?>

@extends('layouts.app')

@section('after_styles')
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>
    {{ Html::style(URL::to('/assets/global/plugins/dropify/css/dropify.min.css')) }}

@endsection

@section('content')
    <!-- #start -->

    <!-- BEGIN PAGE TITLE-->
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    @if(strpos(Request::url(),'edit') !== false)
        {{ Form::open(['route' => 'form12-update', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
        <input type="hidden" name="form12_id" value="{{ $form12->form12_id }}">
    @else
        {{ Form::open(['route' => 'form12-store', 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'submitForm']) }}
    @endif

    <input type="hidden" name="form4_id" value="{{ $form4->form4_id }}">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <span class="caption-subject font-green-sharp bold uppercase">{{ __('new.add_f12')}}</span>
                    </div>
                    <div class="tools">
                        <a href="" class="collapse"></a>
                        <a href="" class="fullscreen"></a>
                    </div>
                </div>
                <div class="portlet-body ">
                    <div class="form-group form-md-line-input">
                        <label for="category" class="control-label col-md-4">{{ __('new.applied_by')}} :
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                            <select class="form-control select2 bs-select" id="versus" name="versus"
                                    data-placeholder="---">
                                <option value="" disabled selected>---</option>
                                <option value="2">{{ $form4->case->claimant_address->name }}</option>
                                <option value="3">{{ $form4->claimCaseOpponent->opponent_address->name }}</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label for="category" class="control-label col-md-4">{{ __('new.parties_involved')}} :
                            <span class="required">*</span>
                        </label>
                        <div class="col-md-6">
                            <select class="form-control select2 bs-select" id="versus_against" name="versus_against"
                                    data-placeholder="---">
                                <option value="" disabled selected>---</option>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label for="hearing_date" class="control-label col-md-4"> {{ __('new.latest_hearing_date')}} :
                            <span> &nbsp;&nbsp; </span>
                        </label>
                        <div class="col-md-6" style='padding-top: 5px'>
                            {{ date('d/m/Y', strtotime($form4->hearing->hearing_date)) }}
                        </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label for="award_date" class="control-label col-md-4"> {{ __('new.award_submitted_date')}} :
                            <span> &nbsp;&nbsp; </span>
                        </label>
                        <div class="col-md-6" style='padding-top: 5px'>
                            {{ date('d/m/Y', strtotime($form4->award->award_date)) }}
                        </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label for="application_date" class="control-label col-md-4">{{ __('new.f12_apply_date')}} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <div class="input-group date col-sm-4" data-date-format="dd/mm/yyyy">
                                <input @if($is_edit) disabled
                                       @endif class="form-control form-control-inline date-picker datepicker clickme"
                                       name="application_date" id="application_date" data-date-format="dd/mm/yyyy"
                                       type="text" value="{{ date('d/m/Y') }}"/>
                                <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label for="filing_date" class="control-label col-md-4">{{ __('new.f12_filing_date')}} :
                            <span class="required"> * </span>
                        </label>
                        <div class='col-sm-6'>
                            <div class='input-group date col-sm-4' data-date-format="dd/mm/yyyy">
                                <input @if($is_edit) disabled
                                       @endif class="form-control form-control-inline date-picker datepicker clickme"
                                       name="filing_date" id="filing_date" data-date-format="dd/mm/yyyy" type="text"
                                       value="{{ date('d/m/Y') }}"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label for="absence_reason" class="control-label col-md-4">{{ __('new.reason_absent')}} :
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-6">
                            <textarea id="absence_reason" name="absence_reason" class="form-control"
                                      rows="4">{{ $form4->form12 ? $form4->form12->absence_reason : '' }}</textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label for="unfiled_reason" class="control-label col-md-4">{{ __('new.reason_unfiled_defence')}}
                            :
                            <span class="required"> &nbsp;&nbsp; </span>
                        </label>
                        <div class="col-md-6">
                            <textarea id="unfiled_reason" name="unfiled_reason" class="form-control"
                                      rows="4">{{ $form4->form12 ? $form4->form12->unfiled_reason : '' }}</textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group form-md-line-input">
                        <label for="new_hearing_date" class="control-label col-md-4">{{ __('new.new_hearing_date')}} :
                            <span> &nbsp;&nbsp; </span>
                        </label>
                        <div class="col-md-6">
                            <select class="form-control select2-allow-clear select2 bs-select"
                                    id="new_hearing_date"
                                    name="new_hearing_date"
                                    data-placeholder="---"
                                    {{ (!!$form4_next && $form4_next->hearing_status_id != null) ? "disabled=disabled" : '' }}
                            >
                                <option value="" disabled selected>---</option>

                                @foreach ($hearings as $hearing)
                                    <option value="{{ $hearing->hearing_id }}">
                                        {{ date('d/m/Y h:i A', strtotime($hearing->hearing_date." ".$hearing->hearing_time))." (".($hearing->hearing_room ? $hearing->hearing_room->hearing_room : "").")" }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div id="supporting_docs" class="form-group form-md-line-input">
                        <label for="attachments" id="attachments"
                               class="control-label col-md-4"> {{ __('others.supporting_docs') }} :
                            <span class="required">&nbsp;&nbsp;</span>
                        </label>
                        <div class="col-md-6">
                            <div>

                            </div>
                            <div class="m-heading-1 border-green m-bordered">
                                {!! __('new.dropify_msg') !!}
                            </div>
                            <div style="display: flex; flex-wrap: wrap;">
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_1" name="attachment_1" class="dropify"
                                           @if($attachments) @if($attachments->get(0))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(0)->attachment_id, 'filename' => $attachments->get(0)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_2" name="attachment_2" class="dropify"
                                           @if($attachments) @if($attachments->get(1))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(1)->attachment_id, 'filename' => $attachments->get(1)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_3" name="attachment_3" class="dropify"
                                           @if($attachments) @if($attachments->get(2))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(2)->attachment_id, 'filename' => $attachments->get(2)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_4" name="attachment_4" class="dropify"
                                           @if($attachments) @if($attachments->get(3))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(3)->attachment_id, 'filename' => $attachments->get(3)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                                <div style="padding-bottom: 10px; padding-right: 10px; flex: auto;">
                                    <input type="file" id="attachment_5" name="attachment_5" class="dropify"
                                           @if($attachments) @if($attachments->get(4))data-default-file="{{route('general-getattachment', ['attachment_id' => $attachments->get(4)->attachment_id, 'filename' => $attachments->get(4)->attachment_name])}}"
                                           @endif @endif data-max-file-size="2M"
                                           data-allowed-file-extensions="pdf jpg jpeg gif png" data-height="120"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                    <div class="col-md-offset-4 col-md-8 mv20">
                        @if($is_edit)
                            <button type="button" class="btn default"
                                    onclick="location.href ='{{ route('onlineprocess.form12') }}'"><i
                                        class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
                            <button type="submit" class="btn green"><i
                                        class="fa fa-paper-plane mr10"></i>{{ trans('button.update') }}</button>
                        @else
                            <button type="button" class="btn default"
                                    onclick="location.href ='{{ route('form12-find') }}'"><i
                                        class="fa fa-reply mr10"></i>{{ trans('new.back') }}</button>
                            <button type="submit" class="btn green"><i
                                        class="fa fa-paper-plane mr10"></i>{{ trans('button.create') }}</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ Form::close() }}
@endsection

@section('after_scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}"
            type="text/javascript"></script>
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
    <script src="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}"
            type="text/javascript"></script>
    {{ Html::script(URL::to('/assets/global/plugins/dropify/js/dropify.min.js')) }}
    <!-- END PAGE LEVEL SCRIPTS -->
    <script type="text/javascript">


      $('#versus').on('change', function () {

        $('#versus_against').empty()
        $('#versus_against').append('<option value="" disabled selected>---</option>')
        if ($('#versus').val() == 2)
          $('#versus_against').append('<option value="3">{{ $form4->claimCaseOpponent->name }}</option>')
        else if ($('#versus').val() == 3)
          $('#versus_against').append('</option><option value="2">{{ $form4->case->claimant->name }}</option>')
      })


      $('.dropify').dropify({
        messages: {
          'default': '',
          'replace': '',
          'remove': '{!! __("new.dropify_msg_remove") !!}',
          'error': '{!! __("new.dropify_msg_error") !!}'
        },
        error: {
          'fileSize': '{!! __("new.dropify_error_fileSize") !!}',
          'imageFormat': '{!! __("new.dropify_error_imageFormat") !!}'
        }
      })

      var file1_info = 0, file2_info = 0, file3_info = 0, file4_info = 0, file5_info = 0
      @if($attachments)
              @if($attachments->get(0))
        file1_info = 1
      @endif
              @if($attachments->get(1))
        file2_info = 1
      @endif
              @if($attachments->get(2))
        file3_info = 1
      @endif
              @if($attachments->get(3))
        file4_info = 1
      @endif
              @if($attachments->get(4))
        file5_info = 1
      @endif
      @endif

      // Add events. Grab the files and set them to our variable
      $('#attachment_1').on('change', function (event) {
        file1_info = 2
      })

      $('#attachment_2').on('change', function (event) {
        file2_info = 2
      })

      $('#attachment_3').on('change', function (event) {
        file3_info = 2
      })

      $('#attachment_4').on('change', function (event) {
        file4_info = 2
      })

      $('#attachment_5').on('change', function (event) {
        file5_info = 2
      })

      $('.dropify-clear').on('click', function () {
        $(this).siblings('input').trigger('change')
        //console.log('remove button clicked!');
      })

      $('#submitForm').submit(function (e) {

        e.preventDefault()
        var form = $(this)
        var data = new FormData(form[ 0 ])
        data.append('file1_info', file1_info)
        data.append('file2_info', file2_info)
        data.append('file3_info', file3_info)
        data.append('file4_info', file4_info)
        data.append('file5_info', file5_info)

        $.ajax({
          url: form.attr('action'),
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          method: form.attr('method'),
          data: data,
          dataType: 'json',
          contentType: false,
          processData: false,
          async: true,
          beforeSend: function () {

          },
          success: function (data) {
            if (data.status == 'ok') {
              swal({
                  title: "{{ __('new.success') }}",
                  text: '',
                  type: 'success'
                },
                function () {
                  window.location.href = '{{ route('onlineprocess.form12') }}'
                })
            } else {
              var inputError = []

              console.log(Object.keys(data.message)[ 0 ])
              if ($('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':radio') || $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']').is(':checkbox')) {
                var input = $('input[name=\'' + Object.keys(data.message)[ 0 ] + '\']')
              } else {
                var input = $('#' + Object.keys(data.message)[ 0 ])
              }

              $('html,body').animate(
                { scrollTop: input.offset().top - 100 },
                'slow', function () {
                  //swal("{{ __('new.error') }}!","{{ __('new.fill_required') }}", "error");
                  input.focus()
                }
              )

              $.each(data.message, function (key, data) {
                if ($('input[name=\'' + key + '\']').is(':radio') || $('input[name=\'' + key + '\']').is(':checkbox')) {
                  var input = $('input[name=\'' + key + '\']')
                } else {
                  var input = $('#' + key)
                }
                var parent = input.parents('.form-group')
                parent.removeClass('has-success')
                parent.addClass('has-error')
                parent.find('.help-block').html(data[ 0 ])
                inputError.push(key)
              })

              $.each(form.serializeArray(), function (i, field) {
                if ($.inArray(field.name, inputError) === -1) {
                  if ($('input[name=\'' + field.name + '\']').is(':radio') || $('input[name=\'' + field.name + '\']').is(':checkbox')) {
                    var input = $('input[name=\'' + field.name + '\']')
                  } else {
                    var input = $('#' + field.name)
                  }
                  var parent = input.parents('.form-group')
                  parent.removeClass('has-error')
                  parent.addClass('has-success')
                  parent.find('.help-block').html('')
                }
              })
            }
          },
          error: function (xhr) {
            console.log(xhr.status)
          }
        })
        return false
      })


      @if($is_edit)
      $('#versus').val({{ $form12->applied_by }}).trigger('change')
      $('#versus_against').val({{ $form12->applied_by == 2 ? 3 : 2 }}).trigger('change')

      $('#absence_reason').val('{{ $form12->absence_reason }}')
      $('#unfiled_reason').val('{{ $form12->unfiled_reason }}')
      $('#new_hearing_date').val('{{ $form4_next }}').trigger('change')
        @endif

    </script>
@endsection