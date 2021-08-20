<?php
$locale = App::getLocale();
$category_lang = "category_".$locale;
$classification_lang = "classification_".$locale;
$offence_lang = "offence_description_".$locale;
?>

@extends('layouts.app')
@section('after_styles')

<link href="{{ URL::to('/assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />

<style type="text/css">
.control-label-custom  {
    padding-top: 15px !important;
}

.bootstrap-select .dropdown-menu {
    max-width: 200px;
}
.bootstrap-select .dropdown-menu span.text {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
}
.control-label.col-md-4 {
    color: #888 !important;
}

.tabbable-line > .nav-tabs > li {
    background-color: #f3f8f8 !important
}

.tabbable-line > .nav-tabs > li.active {
    background-color: #daecee !important
}
</style>

@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-layers font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase">  {{ __('new.search') }}</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="tabbable-line">
                    <ul class="nav nav-tabs ">
                        <li class="active">
                            <a href="#tab_suggestion" data-toggle="tab" aria-expanded="true"> {{ trans('new.suggestion_search')}} </a>
                        </li>
                        <li class="">
                            <a href="#tab_question" data-toggle="tab" aria-expanded="false"> {{ trans('new.question_search')}} </a>
                        </li>
                        <li class="">
                            <a href="#tab_filings" data-toggle="tab" aria-expanded="false"> {{ trans('new.filing_search')}} </a>
                        </li>
                        <li class="">
                            <a href="#tab_form1" data-toggle="tab" aria-expanded="false"> {{ trans('new.form1_search')}} </a>
                        </li>
                    </ul>

                    <div class="tab-content" style="padding-top: 0px;">
                        <div class="tab-pane active" id="tab_suggestion" style="margin-top: 30px;">
                            @include('search.tab1')
                        </div>

                        <div class="tab-pane" id="tab_question" style="margin-top: 30px;">
                            @include('search.tab2')
                        </div>

                        <div class="tab-pane" id="tab_filings" style="margin-top: 30px;">
                            @include('search.tab3')
                        </div>

                        <div class="tab-pane" id="tab_form1" style="margin-top: 30px;">
                            @include('search.tab4')
                        </div>
                    </div>
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
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/form-dropzone.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-bootstrap-select.min.js') }}" type="text/javascript"></script>

<script>
//     $("#processModal").modal("show");
// }
// Initialization

function submitSuggestion(){
    $("#suggestion").submit();
}

function submitQuestion(){
    $("#question").submit();
}

function submitFilings(){
    $("#filings").submit();
}

function submitForm1(){
    $("#form1").submit();
}

function resetBranch() {
    //console.log('reset');
    $("#branch_id_4").val("0").trigger('change');
}


@foreach ($claimcategory as $category)
    var cat{{ $category->claim_category_id }} = [];
@endforeach

// Insert data into array
@foreach ($classifications as $classification)
    cat{{ $classification->category_id }}.push({ "id": "{{ $classification->claim_classification_id }}", "name": "{{ $classification->$classification_lang }}" });
@endforeach

function loadClassification() {
    var newTitle = "{{ __('new.all') }}";
    var cat = $('#claim_category').val();
    $('#claim_classification').empty();

    @foreach ($claimcategory as $category)
    if(cat == {{ $category->claim_category_id }}) {
      $('#claim_classification').append("<option value='0' >-- " + newTitle + " --</option>");
      $.each(cat{{ $category->claim_category_id }}, function(key, data) {
            $('#claim_classification').append("<option value='" + data.id +"'>" + data.name + "</option>");
        });
    }
    @endforeach

    if(cat == 0) {
        $('#claim_classification').append("<option value='0' selected>-- {{ __('new.all') }} --</option>");
    }
}



</script>
@endsection