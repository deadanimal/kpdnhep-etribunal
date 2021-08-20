<!-- Modal -->
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput-typeahead.css') }}" rel="stylesheet" type="text/css" />

<style>
.bootstrap-tagsinput {
    width: 100%;
}
.no-shadow {
    box-shadow: unset !important;
}
.panel-add:hover .panel {
    border: 1px solid #2ab4c0 !important;
    background-color: rgba(42,180,192,0.2) !important;
}
.panel-add:hover span {
    color: #2ab4c0 !important;
    font-size: 18px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
}
.case-panel {
    padding-right: 0px;
    padding-left: 0px;
}
.case-panel .portlet {
    margin: 15px;
}
@media (max-width: 500px) {
    .case-panel {
        padding-right: 15px;
    }
}
.btn-action {
    position: absolute !important;
    right: 30px;
}
.label {
    padding: 3px 4px 3px !important;
}
.parent {
    position: relative;
}
.child {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.list-status > .btn {
    font-size: 11px !important;
    text-transform: capitalize !important;
    font-weight: normal !important;
}

.list-status li a {
    font-size: small !important;
    text-transform: capitalize !important;
    font-weight: normal !important;
}

.list-status .dropdown-menu {
    min-width: 160px !important;
}

.form-horizontal .form-group.form-md-line-input {
    margin: 0px !important;
}
</style>
<div id="processModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ __('new.print_minutes')}}</h4>
            </div>
            <div class="modal-body" style='background-color: #eef1f5; padding: 0px;'>

                <div class='row'>
                    <div class='col-xs-12'>
                        <form class="form-horizontal" id="submitForm" action="{{ url('') }}/listing/attendance/{{ $form4->form4_id }}/print" method="POST" role="form" style='background-color: white;'>

                            <input type="hidden" name="form4_id" value="{{ $form4->form4_id }}">
                            <div class="form-body" style="padding-bottom: 10px;">

                                <div class="form-group form-md-line-input">
                                    <label for="psu" class="control-label col-md-4"> PSU :
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6">
                                        <select name='psus[]' id="multiple" class="form-control select2-multiple" multiple data-placeholder="---">
                                            @foreach($psus as $psu)
                                            <option 
                                                @if(!empty($attendance))
                                                    @foreach($attendance->minutes as $a_psu)
                                                        @if($a_psu->psu_user_id == $psu->user_id) 
                                                            selected 
                                                        @endif 
                                                    @endforeach
                                                @endif

                                                value="{{ $psu->user_id }}"> {{ $psu->user->name }}</option>
                                            @endforeach
                                        </select>   
                                        <div class="form-control-focus"> </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.close') }}</button>
                <button onclick="submit()" class="btn green-sharp" type="submit">{{ trans('button.process') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/typeahead/typeahead.bundle.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
$("#processModal").modal("show");

function submit() {
    $('#submitForm').submit();
    $("#processModal").modal("hide");
}


</script>