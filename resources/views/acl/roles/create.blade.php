@extends('layouts.app')

@section('after_styles')
<link href="{{ URL::to('/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::to('/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('heading', 'Create Role')

@section('content')
<div class="row margin-top-10">
	<div class="col-md-12">
		<div class="portlet light portlet-fit portlet-form bordered">
			<div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">{{ trans('acl.role_create') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"> </a>
                    <a href="" class="fullscreen"> </a>
                </div>
            </div>
			<form action="{{route('admins.storeroles')}}" class="form-horizontal" method="post" role="form">
			    @include('acl.roles.partials.form')
			    <div class="form-actions">
                    <center>
                    <!-- <div class="col-md-offset-2 col-md-10"> -->
                        <a class="btn btn-labeled btn-default" href="{{ route('admins.listroles') }}"><span class="btn-label"><i class="fa fa-chevron-left margin-right-5"></i></span> {{ trans('button.cancel') }}</a>
                        <button type="submit" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-plus margin-right-5"></i></span> {{ trans('button.create') }}</button>
                    <!-- </div> -->
                    </center>
			    </div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('after_scripts')
<script src="{{ URL::to('/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('/assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $("#role_type").change(function(){
            var val = $(this).val();

            switch (val){
                case '1':
                     $('.ttpmType').hide();
                     $("#ttpm_type").val("1");
                break;

                case '2':
                     $('.ttpmType').show();
                break;
            }
        });
</script>
<script>
    $(document).ready(function(){
        $('#roles').select2({
            placeholder: "",
             allowClear: true,
         });
    });
</script>
@endsection