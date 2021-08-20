@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/dropzone/basic.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- #start -->

<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{ trans ('new.add_stop_notice') }}
    <small></small>
    
</h1>
@if(Session::has('message'))
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        {{ Session::get('message') }}
    </div>
@endif
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="row">
    <div class="col-md-12">
        <div class="portlet light">
            <div class="portlet-title">
                 <div class="caption font-dark">
                    <span class="caption-subject font-green-sharp bold uppercase"> {{ trans ('new.reg_stop_notice') }} </span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="portlet-body form">
                    <form class="form-horizontal" action="{{ route('stopnotice-create') }}" method="POST">
                        <div class="form-body">
                            <div class="form-group ">
                                <label for="claim_no" class="control-label col-md-2"> {{ trans('form11.claim_no') }} :
                                </label>
                                <div class="col-md-8">
                                    <label class="col-md-3 control-label">TTPM - </label>

                                    <select class="col-md-3 form-control input-xsmall" id="branch_id" name="branch_id"  data-placeholder="---">
                                        <option value="" disabled selected>---</option>
                                        @foreach($branches as $branch)
                                        <option 
                                        value="{{ $branch->branch_id }}">{{ $branch->branch_code }}</option>
                                        @endforeach
                                    </select>

                                    <label class="col-md-1 control-label"> - ( </label>

                                    <select class="col-md-3 form-control input-xsmall" id="category_id" name="category_id"  data-placeholder="---">
                                        <option value="" disabled selected>---</option>
                                        @foreach($categories as $category)
                                        <option 
                                        value="{{ $category->claim_category_id }}">{{ $category->category_code }}</option>
                                        @endforeach
                                    </select>

                                    <label class="col-md-1 control-label"> ) - </label>

                                    <input class="col-md-3 form-control input-xsmall" type="text" id="form_no" name="form_no" size= "5">

                                    <label class="col-md-1 control-label"> - </label>

                                    <input class="col-md-2 form-control input-xsmall" type="text" id="year" name="year" value="{{ date('Y')}}">
                                </div>
                            </div>
                            <div style="text-align: center; margin-top: 30px;">
                                <button class="btn default button-previous">
                                    <i class="fa fa-angle-left"></i> {{ trans('button.back') }}
                                </button>
                                <button type="submit" class="btn btn-outline green button-next"  > {{ trans('button.next') }}
                                    <i class="fa fa-angle-right"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('after_scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
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
<!-- END PAGE LEVEL SCRIPTS -->

@endsection