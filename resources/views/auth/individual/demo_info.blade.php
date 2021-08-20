{{ masterSelectTrans($errors, $masterGender, NULL, NULL, 'gender_id', 'gender', trans('new.gender'), true) }}

@if(Route::current()->getName() == 'citizen')
<div class="form-group form-md-line-input">
    <label for="date_of_birth" class="control-label col-md-4">{{ trans('new.dob') }}<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i>
    </label>
    <div class="col-md-3">
        <div class="input-icon right">
            <input type="text" class="form-control" name="date_of_birth" id="date_of_birth" readonly>
            <div class="form-control-focus"></div>
        </div>
    </div>
</div>
@else
@endif

{{ masterSelectTrans($errors, $masterRace, NULL, NULL, 'race_id', 'race', trans('new.race'), true) }}

{{ masterSelectTrans($errors, $masterOccupation, NULL, NULL, 'occupation_id', 'occupation', trans('new.occupation'), true) }}