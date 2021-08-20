{{ masterSelectTrans($errors, $masterGender, $userPublicIndividual, NULL, 'gender_id', 'gender', trans('new.gender'), true) }}

@if($userPublicIndividual->nationality_country_id == 62 )
<div class="form-group form-md-line-input">
    <label for="date_of_birth" class="control-label col-md-4">{{ trans('new.dob') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i>
    </label>
    <div class="col-md-3">
        <div class="input-icon right">
            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{date('d/m/Y',strtotime($userPublicIndividual->date_of_birth))}}">
            <div class="form-control-focus"></div>
        </div>
    </div>
</div>
@else
<div class="form-group form-md-line-input">
    <label for="date_of_birth" class="control-label col-md-4">{{ trans('new.dob') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></label>
    <div class="col-md-4">
        <div class="input-group input-medium date date-picker" data-date-format="dd/mm/yyyy">
            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" value="{{date('d/m/Y',strtotime($userPublicIndividual->date_of_birth))}}">
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