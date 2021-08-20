<?php

use Illuminate\Support\HtmlString;

// Begin Input Function
function inputError($errors, $name)
{
    (!empty($errors->has($name))) ? $error = 'has-error' : $error = '';
    return $error;
}

function iconError($errors, $name, $icon)
{
    ($icon == true) ? $icon = '<i class="fa fa-exclamation-triangle"></i>' : $icon = '';
    return $errors->first($name, '<span class="font-sm help-block help-block-error">:message</span>' . $icon);
}

function inputRequired($required)
{
    ($required == true || $required != NULL) ? $asterisk = '<i class="ml5 font-xxs font-red-pink fa fa-asterisk"></i>' : $asterisk = '';
    return $asterisk;
}

function loginInput($errors, $type, $name, $label, $icon, $placeholder = NULL)
{
    (!empty($icon)) ? $icon = '<i class="' . $icon . '"></i>' : $icon = '';
    (!empty(old($name))) ? $value = ' value="' . old($name) . '"' : $value = '';
    (isset($placeholder)) ? $placeholder : $placeholder = $label;

    return new HtmlString('<div class="form-group ' . inputError($errors, $name) . '">
		    <label class="control-label visible-ie8 visible-ie9" for="' . $name . '">' . $label . '</label>
		    <div class="input-icon">
		    	' . $icon . '
			    <input type="' . $type . '" class="form-control placeholder-no-fix" id="' . $name . '" name="' . $name . '" placeholder="' . $placeholder . '"' . $value . '>
			    <div class="form-control-focus"></div>
				<span class="font-sm help-block"></span>
		    </div>
		</div>');
}

function downloadButton($title, $url_pdf, $url_docx, $btn_class = 'btn-default', $is_first = false)
{
    return new HtmlString('<br>		
        <div class="btn-group" style="position: relative;">
            <button class="btn btn-xs ' . $btn_class . ' m-b-5 dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-download"></i> ' . $title . '
            </button>
            <ul class="dropdown-menu pull-left" role="menu" style="position: inherit;">
                <li>
                    <a href="' . $url_pdf . '">
                        <i class="fa fa-file-pdf-o"></i> PDF
                    </a>
                </li>
                <li>
                    <a href="' . $url_docx . '">
                        <i class="fa fa-file-text-o"></i> DOCX
                    </a>
                </li>
            </ul>
        </div>');
}

function staticField($label, $data = NULL, $id = NULL)
{
    (!empty($id)) ? $id = 'id="review_' . $id . '"' : $id = '';
    (!empty($data)) ? $data = $data : $data = '&nbsp';

    return new HtmlString('<div class="form-group flex">
                            <div class="control-label col-xs-4 pt15">' . $label . '</div>
                            <div class="col-xs-8 font-green-sharp stretch">
                                <span ' . $id . '>' . $data . '</span>
                            </div>
                        </div>');
}

function staticField2($label, $data = NULL)
{
    return new HtmlString('<div class="form-group form-md-line-input">
                            <label class="control-label col-md-4" style="padding-top:0">' . $label . '</label>
                            <div class="col-md-6">
                                <span>' . $data . '</span>
                            </div>
                        </div>');
}

function textInput($errors, $type, $model = NULL, $name, $label, $required = NULL)
{
    if ($type !== 'password') {
        if (isset($model)) {
            (Session::has('errors')) ? $value = old($name, '') : $value = $model->$name;
        } else {
            (Session::has('errors')) ? $value = old($name) : $value = '';
        }
        $value = 'value="' . $value . '"';
    } else {
        $value = '';
    }

    return new HtmlString('<div class="form-group form-md-line-input ' . inputError($errors, $name) . '">
		    <label class="control-label col-md-4" for="' . $name . '">' . $label . inputRequired($required) . '</label>
		    <div class="col-md-6">
			    <div class="input-icon right">
				    <input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '" ' . $value . '>
				    <div class="form-control-focus"></div>
				    <span class="font-sm help-block"></span>
			    </div>
		    </div>
		</div>');
}

function textInputNumeric($errors, $type, $model = NULL, $name, $label, $required = NULL)
{
    if ($type !== 'password') {
        if (isset($model)) {
            (Session::has('errors')) ? $value = old($name, '') : $value = $model->$name;
        } else {
            (Session::has('errors')) ? $value = old($name) : $value = '';
        }
        $value = 'value="' . $value . '"';
    } else {
        $value = '';
    }

    return new HtmlString('<div class="form-group form-md-line-input ' . inputError($errors, $name) . '">
		    <label class="control-label col-md-4" for="' . $name . '">' . $label . inputRequired($required) . '</label>
		    <div class="col-md-6">
			    <div class="input-icon right">
				    <input type="' . $type . '" class="form-control numeric" id="' . $name . '" name="' . $name . '" ' . $value . '>
				    <div class="form-control-focus"></div>
				    <span class="font-sm help-block"></span>
			    </div>
		    </div>
		</div>');
}

function textarea($errors, $model, $name, $label, $required)
{
    (Session::has('errors')) ? $value = old($name, '') : $value = $model->$name;

    return new HtmlString('<div class="form-group form-md-line-input ' . inputError($errors, $name) . '">
		    <label class="control-label col-md-4" for="' . $name . '">' . $label . inputRequired($required) . '</label>
		    <div class="col-md-6">
			    <div class="input-icon right">
			    	<textarea rows="4" class="form-control" id="' . $name . '" name="' . $name . '">' . $value . '</textarea>
				    <div class="form-control-focus"></div>
				    ' . iconError($errors, $name, true) . '
				    <span class="font-sm help-block"></span>
			    </div>
		    </div>
		</div>');
}

function masterSelect($errors, $master, $model = NULL, $inputname = NULL, $id, $name, $label, $required, $html = NULL)
{
    if (!empty($master)) {
        $option = '';
        $selected = '';

        (isset($master) && isset($inputname)) ? $var = $inputname : $var = $id;

        foreach ($master as $key => $value) {
            if (isset($model)) {
                ($model->$var == $value->$id) ? $selected = 'selected' : $selected = '';
            }
            $option .= '<option value="' . $value->$id . '" ' . $selected . ' >' . $value->$name . '</option>';
        }
    } else {
        $option = '';
    }

    (isset($html)) ? (list($html, $col) = [$html, 'col-md-4']) : (list($html, $col) = ['', 'col-md-6']);
    (isset($inputname)) ? $var = $inputname : $var = $id;

    return new HtmlString('<div class="form-group form-md-line-input ' . inputError($errors, $id) . '">
		    <label class="control-label col-md-4" for="' . $var . '">' . $label . inputRequired($required) . '</label>
		    <div class="' . $col . '">
		        <div class="input-icon right">
		            <select class="form-control select2" id="' . $var . '" name="' . $var . '" data-placeholder="' . __('new.choose') . ' ' . $label . '">
		              <option></option>
		              ' . $option . '
		            </select>
		            <div class="form-control-focus"></div>
		            ' . iconError($errors, $id, true) . '
		        </div>
		    </div>
		    ' . $html . '
		</div>');
}

function masterSelectTrans($errors, $master, $model = NULL, $inputname = NULL, $id, $rawname, $label, $required, $html = NULL)
{

    $locale = App::getLocale();
    $data_lang = $rawname . "_" . $locale;

    if (!empty($master)) {
        $option = '';
        $selected = '';

        (isset($master) && isset($inputname)) ? $var = $inputname : $var = $id;

        foreach ($master as $key => $value) {
            if (isset($model)) {
                ($model->$var == $value->$id) ? $selected = 'selected' : $selected = '';
            }
            $option .= '<option value="' . $value->$id . '" ' . $selected . ' >' . $value->$data_lang . '</option>';
        }
    } else {
        $option = '';
    }

    (isset($html)) ? (list($html, $col) = [$html, 'col-md-4']) : (list($html, $col) = ['', 'col-md-6']);
    (isset($inputname)) ? $var = $inputname : $var = $id;

    return new HtmlString('<div class="form-group form-md-line-input ' . inputError($errors, $id) . '">
		    <label class="control-label col-md-4" for="' . $var . '">' . $label . inputRequired($required) . '</label>
		    <div class="' . $col . '">
		        <div class="input-icon right">
		            <select class="form-control select2" id="' . $var . '" name="' . $var . '" data-placeholder="' . __('new.choose') . ' ' . $label . '">
		              <option></option>
		              ' . $option . '
		            </select>
		            <div class="form-control-focus"></div>
		            ' . iconError($errors, $id, true) . '
		        </div>
		    </div>
		    ' . $html . '
		</div>');
}

function masterCheckbox($errors, $master, $model, $attribute, $pivot, $id, $label, $required)
{
    if (!empty($master)) {
        $checkbox = '';
        foreach ($master as $key => $value) {
            if (in_array($key, old($attribute, [])) || !Session::has('errors') && $model->$pivot->contains($id, $key)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }

            $checkbox .= '<div class="md-checkbox">
		 				    <input name="' . $attribute . '[]" type="checkbox" id="' . $attribute . $key . '" class="md-check" value="' . $key . '" ' . $checked . '>
		 				    <label for="' . $attribute . $key . '" class="mnw200">
		 				        <span class="inc"></span>
		 				        <span class="check"></span>
		 				        <span class="box"></span> ' . $value . ' </label>
						</div>';
        }
    } else {
        $checkbox = '';
    }

    return new HtmlString('<div class="form-group form-md-line-input ' . inputError($errors, $attribute) . '">
		    <label class="control-label col-md-4" for="' . $attribute . '">' . $label . inputRequired($required) . '
		    </label>
		    <div class="col-md-6">
		        <div class="md-checkbox-inline">
		        ' . $checkbox . '
		        </div>
		    </div>
		</div>');
}

function singleCheckbox($errors, $key, $value, $model, $attribute, $pivot, $id)
{
    if (in_array($key, old($attribute, [])) || !Session::has('errors') && $model->$pivot->contains($id, $key)) {
        $checked = 'checked';
    } else {
        $checked = '';
    }

    return new HtmlString('<div class="md-checkbox">
		    <input name="' . $attribute . '[]" type="checkbox" id="' . $attribute . $key . '" class="md-check" value="' . $key . '" ' . $checked . '>
		    <label for="' . $attribute . $key . '" class="mnw200">
		        <span class="inc"></span>
		        <span class="check"></span>
		        <span class="box"></span> ' . $value . ' </label>
		</div>');
}

// End Input Function
// Begin Action Button Function
function actionButton($class, $title, $href, $modalname, $icon, $data, $text = NULL)
{
    (!empty($title)) ? $tooltip = 'rel="tooltip" data-original-title="' . $title . '"' : $tooltip = '';
    (!empty($modalname)) ? $modal = 'data-target="#' . $modalname . '" data-toggle="modal"' : $modal = '';
    (!empty($data)) ? $data : $data = '';
    (!empty($icon)) ? $icon = '<i class="fa ' . $icon . '"></i>' : $icon = '';

    return new HtmlString('<a class="btn btn-primary ' . $class . '" ' . $tooltip . ' href="' . $href . '" ' . $modal . $data . ' >' . $icon . '' . $text . '</a>');
}

// End Action Button Function
// Begin Modal Function
function modal($modalID, $bodyID, $title, $modalContent = NULL)
{
    (!empty($modalID)) ? $modalID = 'id="' . $modalID . '"' : $modalID = '';
    (!empty($bodyID)) ? $bodyID = 'id="' . $bodyID . '"' : $bodyID = '';

    return new HtmlString('<div ' . $modalID . ' class="modal fade" role="basic" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			        <h4 class="modal-title">' . $title . '</h4>
			      </div>
			      <div class="modal-body" ' . $bodyID . '>
			        ' . $modalContent . '
			      </div>
			    </div>
			  </div>
			</div>');
}

function modalScript($scriptTag, $modalID, $modalBtn, $customScript = NULL)
{
    if ($scriptTag == true) {
        $scriptOpen = '<script type="text/javascript">';
        $scriptClose = '</script>';
    } else {
        $scriptOpen = '';
        $scriptClose = '';
    }

    (!empty($customScript)) ? $customScript : $customScript = '';

    $script = "
	$('body').on('click', '" . $modalBtn . "', function(e){
	    e.preventDefault();
	    $('" . $modalID . "').modal('show');
	    " . $customScript . "
	    return false;
	});
	";
    return new HtmlString($scriptOpen . $script . $scriptClose);
}

// End Modal Function


function confirmDelete($scriptTag, $table = NULL, $customScript = NULL)
{
    if ($scriptTag == true) {
        $scriptOpen = '<script type="text/javascript">';
        $scriptClose = '</script>';
    } else {
        $scriptOpen = '';
        $scriptClose = '';
    }

    (!empty($table)) ? $table = "$('" . $table . "').DataTable().draw(false)" : $table = '';
    (!empty($customScript)) ? $customScript : $customScript = '';

    $script = "
	$('body').on('click', '.ajaxDeleteButton', function(e){
	    e.preventDefault();
	    var url = $(this).attr('href');
	    swal({
	        title: '" . __('button.delete_user') . "',
	        text: '" . __('swal.sure_delete') . "',
	        type: 'info',
	        showCancelButton: true,
	        confirmButtonClass: 'btn-danger',
	        confirmButtonText: '" . __('button.delete_user') . "',
	        cancelButtonText: '" . __('button.cancel') . "',
	        closeOnConfirm: false,
	        closeOnCancel: true,
	        showLoaderOnConfirm: true
	    },
	    function(isConfirm) {
	        if (isConfirm) {
	            $.ajax({
	                url: url,
	                headers: {'X-CSRF-TOKEN': $(\"meta[name='csrf-token']\").attr('content')},
	                type: 'DELETE',
	                dataType: 'json',
	                success: function (response) {
	                    if(response.status=='ok'){
	                        swal('" . __('new.success') . "!', '" . __('new.deleted_data') . "', 'success');
	                        " . $table . "
	                        " . $customScript . "
	                    } else {
	                        swal('" . __('new.unsuccess') . "!', '" . __('new.acc_cannot_deleted') . "', 'error');
	                    }
	                }
	            });
	            return false;
	        }
	    });
	});
	";

    return new HtmlString($scriptOpen . $script . $scriptClose);
}

function localeDay($day)
{
    $day = strtolower($day);

    if (App::getLocale() == "en") {
        return ucwords($day);
    } else {
        switch ($day) {
            case "sunday":
                return ucwords("ahad");
                break;
            case "monday":
                return ucwords("isnin");
                break;
            case "tuesday":
                return ucwords("selasa");
                break;
            case "wednesday":
                return ucwords("rabu");
                break;
            case "thursday":
                return ucwords("khamis");
                break;
            case "friday":
                return ucwords("jumaat");
                break;
            case "saturday":
                return ucwords("sabtu");
                break;
        }
    }
}

function localeMonth($month)
{

    $month = strtolower($month);

    if (App::getLocale() == "en") {
        return ucwords($month);
    } else {
        switch ($month) {
            case "january":
                return ucwords("januari");
                break;
            case "february":
                return ucwords("februari");
                break;
            case "march":
                return ucwords("mac");
                break;
            case "april":
                return ucwords("april");
                break;
            case "may":
                return ucwords("mei");
                break;
            case "june":
                return ucwords("jun");
                break;
            case "july":
                return ucwords("julai");
                break;
            case "august":
                return ucwords("ogos");
                break;
            case "september":
                return ucwords("september");
                break;
            case "october":
                return ucwords("oktober");
                break;
            case "november":
                return ucwords("november");
                break;
            case "december":
                return ucwords("disember");
                break;
        }
    }
}


function localeDaylight($daylight)
{

    $daylight = strtolower($daylight);

    if (App::getLocale() == "en") {
        switch ($daylight) {
            case "am":
                return strtolower("morning");
                break;
            case "pm":
                return strtolower("afternoon/evening");
                break;
        }
    } else {
        switch ($daylight) {
            case "am":
                return strtolower("pagi");
                break;
            case "pm":
                return strtolower("petang");
                break;
        }
    }
}