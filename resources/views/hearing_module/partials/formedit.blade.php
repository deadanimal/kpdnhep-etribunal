<div class="form-body">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
        <label class="control-label col-md-2" for="display_name">{{ trans('new.display_name') }}</label>
        <div class="col-md-10">
        <div class="input-icon right">
        <input type="input" class="form-control" unUpper="unUpper" id="display_name" name="display_name" value="{{ (Session::has('errors')) ? old('display_name', '') : $model->display_name }}">
        <div class="form-control-focus"></div>
        {!! $errors->first('display_name', '<span class="help-block help-block-error">:message</span><i class="fa fa-exclamation-triangle"></i>') !!}
        </div>
        </div>
    </div>
    <div class="form-group form-md-line-input">
        <label class="control-label col-md-2" for="description">{{ trans('new.desc') }}</label>
        <div class="col-md-10">
        <textarea class="form-control" unUpper="unUpper" id="description" name="description" rows="3">{{ (Session::has('errors')) ? old('description', '') : $model->description }}</textarea>
        <div class="form-control-focus"></div>
        </div>
    </div>

</div>
