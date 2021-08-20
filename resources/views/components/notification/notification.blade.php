<?php
	$is_login ?: 0;
?>

@if (isset($errors) && count($errors->all()) > 0)
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dissmissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<span class="sbold">{{ trans('swal.error_occured') }} :</span>
			<ul>
				{!! implode('', $errors->all('<li>:message</li>')) !!}

				@if($is_login == 1)
					<li><span style="font-size:small">{!! trans('auth.forget') !!}</span></li>
				@endif
			</ul>
		</div>
	</div>
</div>
@endif
@if ($message = Session::get('success'))
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>{{ trans('entrust-gui::flash.success') }}</strong> {{ $message }}
		</div>
		{{ Session::forget('success') }}
	</div>
</div>
@endif

@if ($message = Session::get('error'))
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>{{ trans('entrust-gui::flash.error') }}</strong> {{ $message }}
		</div>
		{{ Session::forget('error') }}
	</div>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-warning alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>{{ trans('entrust-gui::flash.warning') }}</strong> {{ $message }}
		</div>
		{{ Session::forget('warning') }}
	</div>
</div>
@endif

@if ($message = Session::get('info'))
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-info alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>{{ trans('entrust-gui::flash.info') }}</strong> {{ $message }}
		</div>
		{{ Session::forget('info') }}
	</div>
</div>
@endif

@if (Request::get('token') == 'expired')
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dissmissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<span class="sbold">{{ trans('swal.error_occured') }} :</span>
			<ul>
				{{ trans('swal.token_expired') }} !
			</ul>
		</div>
	</div>
</div>
@endif

@if (Request::get('status') == 'closed')
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dissmissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<span class="sbold">{{ trans('swal.error_occured') }} :</span>
			<ul>
				{{ trans('swal.system_closed') }}
			</ul>
		</div>
	</div>
</div>
@endif

@if (Request::get('status') == 'inactive')
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dissmissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<span class="sbold">{{ trans('swal.error_occured') }} :</span>
			<ul>
				{{ trans('swal.account_inactive') }}
			</ul>
		</div>
	</div>
</div>
@endif

@if (Request::get('status') == 'suspended')
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dissmissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<span class="sbold">{{ trans('swal.error_occured') }} :</span>
			<ul>
				{{ trans('swal.account_suspended') }}
				<!--{{ \App\User::find(1)->email }}-->
			</ul>
		</div>
	</div>
</div>
@endif
