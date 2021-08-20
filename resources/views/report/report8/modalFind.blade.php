<?php

use Carbon\Carbon;

?>

<!-- Modal -->
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet"
      type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
      rel="stylesheet" type="text/css"/>
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet"
      type="text/css"/>


<div id="filterModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">{{ __('new.report8')}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form">
                        <form id="submitForm" action="{{ url('') }}/report/report8/view" method="GET"
                              class="form-horizontal" role="form">
                            <div class="form-body">
                                <div class="form-group form-md-line-input">
                                    <label for="date" class="control-label col-md-4"> {{ __('new.date_start')}}:
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-5">
                                        <div class="input-group input-medium date date-picker"
                                             style="margin-right: 10px;" data-date-format="dd/mm/yyyy"
                                             style="width: 250px;">
                                            <input class="form-control datepicker" readonly=""
                                                   name="date_start" id="date_start"
                                                   data-date-format="dd/mm/yyyy" type="text"
                                                   value="{{ Request::has('date_start') ? Request::get('date_start') : date('d/m/Y') }}"/>
                                            <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label for="date" class="control-label col-md-4"> {{ __('new.date_end')}} :
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-5">
                                        <div class="input-group input-medium date date-picker"
                                             style="margin-right: 10px;" data-date-format="dd/mm/yyyy"
                                             style="width: 250px;">
                                            <input class="form-control datepicker" readonly=""
                                                   name="date_end" id="date_end"
                                                   data-date-format="dd/mm/yyyy" type="text"
                                                   value="{{ Request::has('date_end') ? Request::get('date_end') : date('d/m/Y') }}"/>
                                            <span class="input-group-btn">
                                                    <button class="btn default" type="button">
                                                        <i class="fa fa-calendar"></i>
                                                    </button>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-md-line-input">
                                    <label for="month" class="control-label col-md-4">{{ trans('new.state')}} :
                                        <span> &nbsp;&nbsp; </span>
                                    </label>
                                    <div class="col-md-5">
                                        <select id="state_id" class="form-control select2 bs-select" name="state_id"
                                                style="margin-right: 10px;"
                                                placeholder="-- {{ __('new.all_state') }} --">
                                            <option value="" selected>-- {{ __('new.all_state') }} --</option>
                                            @foreach($states as $id => $state)
                                                <option @if(Request::get('state_id') == $id ) selected
                                                        @endif value="{{ $id }}">{{ $state }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
                <a class="btn green-sharp" onclick='submit()'>{{ trans('button.process') }}</a>
            </div>
        </div>

    </div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
  $('#filterModal').modal('show')

  // Initialization


  function submit() {
    $('#submitForm').submit()
    $('filterModal').modal('hide')
  }


</script>