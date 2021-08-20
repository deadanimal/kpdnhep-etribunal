<?php
$locale = App::getLocale();
$type_lang = "type_".$locale;
?>

<div class="form-body">
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group form-md-line-input">
    <label class="control-label col-md-2" for="role_type">{{ trans('acl.role')}}</label>
    <div class="col-md-10">
    <div class="input-icon right">
    <select class="form-control select2" name="role_type" id="role_type" required="required">
        @foreach($userType AS $key => $type)
        <option value="{{ $type->user_type_id }}" @if($type->user_type_id == $model->type) selected @endif>{{ $type->$type_lang }}</option>
        @endforeach
        <!-- <option @if($model->type == 0) selected @endif value=1>{{ trans('acl.new_role')}}</option>
        <option @if($model->type == 1 || $model->type == 2) selected @endif value=2>{{ trans('acl.staff_role')}}</option> -->
    </select>
    <div class="form-control-focus"></div>
    <!-- {!! $errors->first('status_id', '<span class="help-block help-block-error">:message</span><i class="fa fa-exclamation-triangle"></i>') !!} -->
    </div>
    </div>
</div>
<!-- <div class="form-group form-md-line-input ttpmType" @if($model->type == 0) style="display: none" @endif>
    <label class="control-label col-md-2" for="ttpm_type">{{ trans('acl.type')}}</label>
    <div class="col-md-10">
    <div class="input-icon right">
    <select class="form-control select2" name="ttpm_type" id="ttpm_type" required="required">
            <option @if($model->type == 0 || $model->type == 1) selected @endif value=1>
            <option selected value=1>{{ trans('acl.new_staff_role')}}</option>
            <option @if($model->type == 2) selected @endif value=2>{{ trans('acl.psu_role')}}</option>
    </select>
    <div class="form-control-focus"></div>
    {!! $errors->first('status_id', '<span class="help-block help-block-error">:message</span><i class="fa fa-exclamation-triangle"></i>') !!}
    </div>
    </div>
</div> -->

<div class="form-group form-md-line-input {{ $errors->has('name') ? 'has-error' : ''}}">
    <label class="control-label col-md-2" for="name">{{ trans('new.name') }}</label>
    <div class="col-md-10">
    <div class="input-icon right">
    <input type="input" class="form-control" unUpper="unUpper" id="name" name="name" value="{{ (Session::has('errors')) ? old('name', '') : $model->name }}">
    <div class="form-control-focus"></div>
    {!! $errors->first('name', '<span class="help-block help-block-error">:message</span><i class="fa fa-exclamation-triangle"></i>') !!}
    </div>
    </div>
</div>
<div class="form-group form-md-line-input {{ $errors->has('display_name') ? 'has-error' : ''}}">
    <label class="control-label col-md-2" for="display_name">{{ trans('new.display_name') }} (EN)</label>
    <div class="col-md-10">
    <div class="input-icon right">
    <input type="input" class="form-control" unUpper="unUpper" id="display_name_en" name="display_name_en" value="{{ (Session::has('errors')) ? old('display_name_en', '') : $model->display_name_en }}">
    <div class="form-control-focus"></div>
    {!! $errors->first('display_name_en', '<span class="help-block help-block-error">:message</span><i class="fa fa-exclamation-triangle"></i>') !!}
    </div>
    </div>
</div>
<div class="form-group form-md-line-input {{ $errors->has('display_name') ? 'has-error' : ''}}">
    <label class="control-label col-md-2" for="display_name">{{ trans('new.display_name') }} (MY)</label>
    <div class="col-md-10">
    <div class="input-icon right">
    <input type="input" class="form-control" unUpper="unUpper" id="display_name_my" name="display_name_my" value="{{ (Session::has('errors')) ? old('display_name_my', '') : $model->display_name_my }}">
    <div class="form-control-focus"></div>
    {!! $errors->first('display_name_my', '<span class="help-block help-block-error">:message</span><i class="fa fa-exclamation-triangle"></i>') !!}
    </div>
    </div>
</div>
<div class="form-group form-md-line-input">
    <label class="control-label col-md-2" for="description">{{ trans('new.desc') }}</label>
    <div class="col-md-10">
    <textarea class="form-control" id="description" name="description" rows="3">{{ (Session::has('errors')) ? old('description', '') : $model->description }}</textarea>
    <div class="form-control-focus"></div>
    </div>
</div>
<div class="form-group form-md-checkboxes form-md-line-input">
    <label class="control-label col-md-2" for="permissions">{{ trans('acl.permission') }}</label>
    <div class="col-md-3">
    <div class="md-checkbox-inline">
    <?php $prm=count($relations); ?>
    @foreach($relations as $index => $relation)
        @if($index <= ceil($prm/2))
            <div class="md-checkbox">
            <input name="permissions[]" type="checkbox" id="checkbox{{ $index }}" class="md-check" value="{{ $index }}" {{ ((in_array($index, old('roles', []))) || ( ! Session::has('errors') && $model->permissions->contains('id', $index))) ? 'checked' : '' }}>
            <label for="checkbox{{ $index }}">
            <span class="inc"></span>
            <span class="check"></span>
            <span class="box"></span> {{ $relation }} </label>
            </div><br>
        @endif
    @endforeach
    </div>
    </div>
    <div class="col-md-4">
    <div class="md-checkbox-inline">
    @foreach($relations as $index => $relation)
        @if($index > ceil($prm/2))
            <div class="md-checkbox">
            <input name="permissions[]" type="checkbox" id="checkbox{{ $index }}" class="md-check" value="{{ $index }}" {{ ((in_array($index, old('roles', []))) || ( ! Session::has('errors') && $model->permissions->contains('id', $index))) ? 'checked' : '' }}>
            <label for="checkbox{{ $index }}">
            <span class="inc"></span>
            <span class="check"></span>
            <span class="box"></span> {{ $relation }} </label>
            </div><br>
        @endif
    @endforeach
    </div>
    </div>
</div>

</div>