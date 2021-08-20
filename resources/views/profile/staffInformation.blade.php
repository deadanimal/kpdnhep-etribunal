<?php
use App\MasterModel\MasterBranch;
use App\MasterModel\MasterDesignation;
use App\MasterModel\MasterDesignationType;
use App\Role;
use App\RoleUser;
?>

<?php
$locale = App::getLocale();
$display_name = 'display_name_'.$locale;
$findBranch = MasterBranch::where('branch_id', '=', $userTTPM->branch_id)->first();

$role_user = RoleUser::where('user_id', $userTTPM->user_id)->first()->role_id;
$designation = Role::find($role_user)->$display_name;



//die($findDesignation['designation']);
// dd($masterBranch);
?>
{{ textInput($errors, 'tel', $userTTPM, 'phone_mobile', trans('new.phone_mobile'), true) }}

{{ textInput($errors, 'text', $userTTPM, 'identification_no', trans('new.ic'), true) }}

{{ textInput($errors, false, $findBranch, 'branch_name', 'Cawangan', 'branch_id', trans('new.branch'), true) }}

<div class="form-group form-md-line-input"">
    <label class="col-md-4 control-label">{{ __('new.designation') }}<span class="required"><i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i></span></label>
    <div class="col-md-6">
        <input class="form-control" type="text" value="{{ $designation }}" disabled>
    </div>
</div>

{{ textInputNumeric($errors, 'tel', $user, 'phone_office', trans('new.phone_office'), true) }}

{{ textInputNumeric($errors, 'tel', $user, 'phone_fax', trans('new.phone_fax')) }}

{{ textInput($errors, 'email', $user, 'email', trans('new.email'), true) }}

<div class="form-group form-md-line-input"">
    <label id="label_supporting_docs" class="col-md-4 control-label">{{ __('new.signature') }}<span class="required"><!-- <i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i> --></span></label>
    <div class="col-md-6">
        <input type="file" id="signature_blob" name="signature_blob" class="dropify" data-default-file="@if($userTTPM->user_id)
        {{ route('general-getsignature', ['ttpm_user_id' => $userTTPM->user_id]) }}@endif" data-max-file-size="2M" data-allowed-file-extensions="jpeg jpg png"/>
    </div>
</div>