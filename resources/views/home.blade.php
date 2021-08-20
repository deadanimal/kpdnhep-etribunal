@extends('layouts.app')

@section('content')
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"> Dashboard 
    <small>&nbsp; You are now logged in!</small>
</h1>
<!-- END PAGE TITLE-->
<div class="row">
    <div class="col-md-12">
        <button onclick="location.href='{{ route('inquiry-create')}}'" class="btn btn-success"><i class="glyphicon glyphicon-plus "></i> Open Inquiry</button>
        <button onclick="location.href='{{ route('claimcase-create')}}'" class="btn btn-default"><i class="glyphicon glyphicon-plus "></i> File A Claim</button>
    </div>
</div>
@endsection
