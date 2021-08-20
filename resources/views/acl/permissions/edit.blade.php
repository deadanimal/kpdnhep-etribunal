@extends('layouts.app')

@section('heading', 'Edit Permission')

@section('content')
<div class="row margin-top-10">
	<div class="col-md-12">
		<div class="portlet light portlet-fit portlet-form bordered">
			<div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">{{ trans('acl.permission_edit') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"> </a>
                    <a href="" class="fullscreen"> </a>
                </div>
            </div>
			<form action="{{route('admins.updatepermissions', $model->id)}}" class="form-horizontal" method="post" role="form">
			<input type="hidden" name="_method" value="put">
				@include('acl.permissions.partials.formedit')
				<div class="form-actions">
					<center>
					{{-- <div class="col-md-offset-2 col-md-10"> --}}
						<a class="btn btn-labeled btn-default" href="{{ route('admins.listpermissions') }}"><span class="btn-label"><i class="fa fa-chevron-left margin-right-5"></i></span> {{ trans('button.cancel') }}</a>
						<button type="submit" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-check margin-right-5"></i></span> {{ trans('button.save') }}</button>
					{{-- </div> --}}
					</center>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection