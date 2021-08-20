<?php
use Carbon\Carbon;
$locale = App::getLocale();
$month_lang = 'month_'.$locale;
?>

<!-- Modal -->
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />



<div id="filterModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">{{ __('new.report25')}}</h4>
        </div>
        <div class="modal-body"> 
            <div class="row">
                <div class="col-md-12 form">
                    <form id="submitForm" action="{{ url('') }}/report/report25/view" method="GET" class="form-horizontal" role="form">
                        <div class="form-body">
                            <div class="form-group form-md-line-input">
                                <label for="year" class="control-label col-md-4"> {{ __('new.year')}}  :
                                    <span> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-5">
                                    <select id="year" class="form-control select2 bs-select" name="year" style="margin-right: 10px;">
                                        @foreach($years as $i=>$year)
                                        <option @if(Request::get('year') == $year) selected 
                                        @elseif ( $year == date('Y') ) selected 
                                        @endif value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label for="month" class="control-label col-md-4">{{ trans('new.month')}} :
                                    <span> &nbsp;&nbsp; </span>
                                </label>
                                <div class="col-md-5">
                                    <select id="month" class="form-control select2 bs-select" name="month" style="margin-right: 10px;">
                                        <option value="0" selected>-- {{ __('form1.all_month') }} --</option>
                                        @foreach($months as $i=>$month)
                                        <option @if(Request::get('month') == $month->month_id) selected @endif value="{{ $month->month_id }}">{{ $month->$month_lang }}</option>
                                        @endforeach
                                    </select>
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
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
$("#filterModal").modal("show");

// Initialization

function submit() {
    $('#submitForm').submit();
    $("filterModal").modal("hide");
}

</script>