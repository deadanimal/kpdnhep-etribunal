{{ masterSelectTrans($errors, $masterGender, $userPublicIndividual, NULL, 'gender_id', 'gender', trans('new.gender'), true) }}

@if(Route::current()->getName() == 'public.create.citizen' || $type == 'citizen')
<div class="form-group form-md-line-input">
    <label for="date_of_birth" class="control-label col-md-4">{{ trans('new.dob') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i>
    </label>
    <div class="col-md-3">
        <div class="input-icon right">
            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ ($userPublicIndividual!=NULL) ? date('d/m/Y',strtotime($userPublicIndividual->date_of_birth)) : ''}}" readonly>
            <div class="form-control-focus"></div>
        </div>
    </div>
</div>
@else
<div class="form-group">
    <label for="date_of_birth" class="control-label col-md-4">{{ trans('new.dob') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-4">
        <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy">
            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{ ($userPublicIndividual!=NULL) ? date('d/m/Y',strtotime($userPublicIndividual->date_of_birth)) : ''}}" readonly>
            <span class="input-group-btn">
                <button class="btn default" type="button">
                    <i class="fa fa-calendar"></i>
                </button>
            </span>
        </div>
    </div>
</div>
@endif

{{ masterSelectTrans($errors, $masterRace, $userPublicIndividual, NULL, 'race_id', 'race', trans('new.race'), true) }}

{{ masterSelectTrans($errors, $masterOccupation, $userPublicIndividual, NULL, 'occupation_id', 'occupation', trans('new.occupation'), true) }}

@if(strpos(Request::url(),'edit') !== false)
<div class="form-group form-md-line-input ">
    <label class="control-label col-md-4" for="password">Captcha <i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-6">
        <div class="input-icon right">
            <div class="captcha-holder"></div>
            <div class="form-control-focus"></div>
            <span class="font-sm help-block"></span>
        </div>
    </div>
</div>
@endif