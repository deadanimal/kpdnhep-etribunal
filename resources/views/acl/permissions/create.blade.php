@extends('layouts.app')

@section('heading', 'Create Permission')

@section('content')
<div class="row margin-top-10">
	<div class="col-md-12">
		<div class="portlet light portlet-fit portlet-form bordered">
			<div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">{{ trans('acl.permission_create') }}</span>
                </div>
                <div class="tools">
                    <a href="" class="collapse"> </a>
                    <a href="" class="fullscreen"> </a>
                </div>
            </div>
			<form action="{{route('admins.storepermissions')}}" class="form-horizontal" method="post" role="form">
			    @include('acl.permissions.partials.form')
			    <div class="form-actions">
					<center>
				    <a class="btn btn-labeled btn-default" href="{{ route('admins.listpermissions') }}"><span class="btn-label"><i class="fa fa-chevron-left margin-right-5"></i></span> {{ trans('button.cancel') }}</a>
				    <button type="submit" class="btn btn-labeled btn-primary"><span class="btn-label"><i class="fa fa-plus margin-right-5"></i></span> {{ trans('button.create') }}</button>
				    </center>
			    </div>
			</form>
		</div>
	</div>
</div>
@endsection
