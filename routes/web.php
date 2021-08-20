<?php

include 'trash.php';

Auth::routes();

// Route::get('/', 'HomeController@index')->name('home');

Route::any('/', function () {
    // return view('welcome');
    return redirect('portal/home');
})->name('index');

/* Z 20181022
Route::get('/',function(){
return view('selenggara');
});*/

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/auth/logout', 'Auth\LoginController@logout')->name('logout');

//Language Route
Route::post('/language-chooser', 'LanguageController@changelanguage');

Route::get('/l10n', 'L10nController@change')->name('l10n');

Route::post('/language', [
    'before' => 'csrf',
    'as' => 'language-chooser',
    'uses' => 'LanguageController@changelanguage',
]);

//Reset Route
// Route::get('password/reset/{token}/{email}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

//Register Route
Route::group(['prefix' => 'register'], function () {
    //Register Citizen Route
    Route::get('citizen', 'Auth\RegisterCitizenController@create')->name('citizen');
    Route::post('citizen', 'Auth\RegisterCitizenController@store')->name('register.citizen');

    //Register Non Citizen Route
    Route::get('noncitizen', 'Auth\RegisterController@showNonCitizenForm')->name('noncitizen');
    Route::post('noncitizen', 'Auth\RegisterController@registerNonCitizen')->name('register.noncitizen');

    //Register Tourist Route
    Route::get('tourist', 'Auth\RegisterController@showTouristForm')->name('tourist');
    Route::post('tourist', 'Auth\RegisterController@registerTourist')->name('register.tourist');

    //Register Company Route
    Route::get('company', 'Auth\RegisterController@showCompanyForm')->name('company');
    Route::post('company', 'Auth\RegisterController@registerCompany')->name('register.company');

    //State Route
    Route::get('state', 'AjaxController@ajaxState')->name('state');
});

Route::get('manual', function () {
    if (auth()->user() && auth()->user()->user_type_id == 1) {
        return response()->download(storage_path("manual/manual_admin.pdf"), "manual.pdf");
    } else if (auth()->user() && auth()->user()->user_type_id == 2) {
        return response()->download(storage_path("manual/manual_staff.pdf"), "manual.pdf");
    } else {
        return response()->download(storage_path("manual/manual_user.pdf"), "manual.pdf");
    }
})->name('manual');


Route::group(['prefix' => 'admin/master'], function () {

    Route::get('directory/hq', 'Admin\Master\DirectoryHQController@index')->name('master.directory.hq');
    Route::group(['prefix' => 'directory/hq'], function () {
        Route::get('create', 'Admin\Master\DirectoryHQController@create')->name('master.directory.hq.create');
        Route::get('{id}/view', 'Admin\Master\DirectoryHQController@view')->name('master.directory.hq.view');
        Route::get('{id}/edit', 'Admin\Master\DirectoryHQController@edit')->name('master.directory.hq.edit');
        Route::delete('{id}/delete', 'Admin\Master\DirectoryHQController@delete')->name('master.directory.hq.delete');
        Route::post('{id}/activate', 'Admin\Master\DirectoryHQController@activate')->name('master.directory.hq.activate');
        Route::post('update', 'Admin\Master\DirectoryHQController@update')->name('master.directory.hq.update');
        Route::post('store', 'Admin\Master\DirectoryHQController@store')->name('master.directory.hq.store');
    });

    Route::get('directory/branch', 'Admin\Master\DirectoryBranchController@index')->name('master.directory.branch');
    Route::group(['prefix' => 'directory/branch'], function () {
        Route::get('create', 'Admin\Master\DirectoryBranchController@create')->name('master.directory.branch.create');
        Route::get('{id}/view', 'Admin\Master\DirectoryBranchController@view')->name('master.directory.branch.view');
        Route::get('{id}/edit', 'Admin\Master\DirectoryBranchController@edit')->name('master.directory.branch.edit');
        Route::delete('{id}/delete', 'Admin\Master\DirectoryBranchController@delete')->name('master.directory.branch.delete');
        Route::post('{id}/activate', 'Admin\Master\DirectoryBranchController@activate')->name('master.directory.branch.activate');
        Route::post('update', 'Admin\Master\DirectoryBranchController@update')->name('master.directory.branch.update');
        Route::post('store', 'Admin\Master\DirectoryBranchController@store')->name('master.directory.branch.store');
    });

    Route::get('branch', 'Admin\Master\BranchController@index')->name('master.branch');
    Route::group(['prefix' => 'branch'], function () {
        Route::get('create', 'Admin\Master\BranchController@create')->name('master.branch.create');
        Route::get('{id}/view', 'Admin\Master\BranchController@view')->name('master.branch.view');
        Route::get('{id}/edit', 'Admin\Master\BranchController@edit')->name('master.branch.edit');
        Route::delete('{id}/delete', 'Admin\Master\BranchController@delete')->name('master.branch.delete');
        Route::post('{id}/activate', 'Admin\Master\BranchController@activate')->name('master.branch.activate');
        Route::post('update', 'Admin\Master\BranchController@update')->name('master.branch.update');
        Route::post('store', 'Admin\Master\BranchController@store')->name('master.branch.store');
    });

    Route::get('occupation', 'Admin\Master\OccupationController@index')->name('master.occupation');
    Route::group(['prefix' => 'occupation'], function () {
        Route::get('create', 'Admin\Master\OccupationController@create')->name('master.occupation.create');
        Route::get('{id}/view', 'Admin\Master\OccupationController@view')->name('master.occupation.view');
        Route::get('{id}/edit', 'Admin\Master\OccupationController@edit')->name('master.occupation.edit');
        Route::delete('{id}/delete', 'Admin\Master\OccupationController@delete')->name('master.occupation.delete');
        Route::post('{id}/activate', 'Admin\Master\OccupationController@activate')->name('master.occupation.activate');
        Route::post('update', 'Admin\Master\OccupationController@update')->name('master.occupation.update');
        Route::post('store', 'Admin\Master\OccupationController@store')->name('master.occupation.store');
    });

    Route::get('offence_type', 'Admin\Master\OffenceController@index')->name('master.offence_type');
    Route::group(['prefix' => 'offence_type'], function () {
        Route::get('create', 'Admin\Master\OffenceController@create')->name('master.offence_type.create');
        Route::get('{id}/view', 'Admin\Master\OffenceController@view')->name('master.offence_type.view');
        Route::get('{id}/edit', 'Admin\Master\OffenceController@edit')->name('master.offence_type.edit');
        Route::delete('{id}/delete', 'Admin\Master\OffenceController@delete')->name('master.offence_type.delete');
        Route::post('{id}/activate', 'Admin\Master\OffenceController@activate')->name('master.offence_type.activate');
        Route::post('update', 'Admin\Master\OffenceController@update')->name('master.offence_type.update');
        Route::post('store', 'Admin\Master\OffenceController@store')->name('master.offence_type.store');
    });

    Route::get('inquiry_method', 'Admin\Master\InquiryMethodController@index')->name('master.inquiry_method');
    Route::group(['prefix' => 'inquiry_method'], function () {
        Route::get('create', 'Admin\Master\InquiryMethodController@create')->name('master.inquiry_method.create');
        Route::get('{id}/view', 'Admin\Master\InquiryMethodController@view')->name('master.inquiry_method.view');
        Route::get('{id}/edit', 'Admin\Master\InquiryMethodController@edit')->name('master.inquiry_method.edit');
        Route::delete('{id}/delete', 'Admin\Master\InquiryMethodController@delete')->name('master.inquiry_method.delete');
        Route::post('{id}/activate', 'Admin\Master\InquiryMethodController@activate')->name('master.inquiry_method.activate');
        Route::post('update', 'Admin\Master\InquiryMethodController@update')->name('master.inquiry_method.update');
        Route::post('store', 'Admin\Master\InquiryMethodController@store')->name('master.inquiry_method.store');
    });

    Route::get('classification', 'Admin\Master\ClassificationController@index')->name('master.classification');
    Route::group(['prefix' => 'classification'], function () {
        Route::get('create', 'Admin\Master\ClassificationController@create')->name('master.classification.create');
        Route::get('{id}/view', 'Admin\Master\ClassificationController@view')->name('master.classification.view');
        Route::get('{id}/edit', 'Admin\Master\ClassificationController@edit')->name('master.classification.edit');
        Route::delete('{id}/delete', 'Admin\Master\ClassificationController@delete')->name('master.classification.delete');
        Route::post('{id}/activate', 'Admin\Master\ClassificationController@activate')->name('master.classification.activate');
        Route::post('update', 'Admin\Master\ClassificationController@update')->name('master.classification.update');
        Route::post('store', 'Admin\Master\ClassificationController@store')->name('master.classification.store');
    });

    Route::get('hearing_room', 'Admin\Master\HearingRoomController@index')->name('master.hearing_room');
    Route::group(['prefix' => 'hearing_room'], function () {
        Route::get('create', 'Admin\Master\HearingRoomController@create')->name('master.hearing_room.create');
        Route::get('{id}/view', 'Admin\Master\HearingRoomController@view')->name('master.hearing_room.view');
        Route::get('{id}/edit', 'Admin\Master\HearingRoomController@edit')->name('master.hearing_room.edit');
        Route::delete('{id}/delete', 'Admin\Master\HearingRoomController@delete')->name('master.hearing_room.delete');
        Route::post('{id}/activate', 'Admin\Master\HearingRoomController@activate')->name('master.hearing_room.activate');
        Route::post('update', 'Admin\Master\HearingRoomController@update')->name('master.hearing_room.update');
        Route::post('store', 'Admin\Master\HearingRoomController@store')->name('master.hearing_room.store');
    });

    Route::get('hearing_venue', 'Admin\Master\HearingVenueController@index')->name('master.hearing_venue');
    Route::group(['prefix' => 'hearing_venue'], function () {
        Route::get('create', 'Admin\Master\HearingVenueController@create')->name('master.hearing_venue.create');
        Route::get('{id}/view', 'Admin\Master\HearingVenueController@view')->name('master.hearing_venue.view');
        Route::get('{id}/edit', 'Admin\Master\HearingVenueController@edit')->name('master.hearing_venue.edit');
        Route::delete('{id}/delete', 'Admin\Master\HearingVenueController@delete')->name('master.hearing_venue.delete');
        Route::post('{id}/activate', 'Admin\Master\HearingVenueController@activate')->name('master.hearing_venue.activate');
        Route::post('update', 'Admin\Master\HearingVenueController@update')->name('master.hearing_venue.update');
        Route::post('store', 'Admin\Master\HearingVenueController@store')->name('master.hearing_venue.store');
    });

    Route::get('stop_reason', 'Admin\Master\StopReasonController@index')->name('master.stop_reason');
    Route::group(['prefix' => 'stop_reason'], function () {
        Route::get('create', 'Admin\Master\StopReasonController@create')->name('master.stop_reason.create');
        Route::get('{id}/view', 'Admin\Master\StopReasonController@view')->name('master.stop_reason.view');
        Route::get('{id}/edit', 'Admin\Master\StopReasonController@edit')->name('master.stop_reason.edit');
        Route::delete('{id}/delete', 'Admin\Master\StopReasonController@delete')->name('master.stop_reason.delete');
        Route::post('{id}/activate', 'Admin\Master\StopReasonController@activate')->name('master.stop_reason.activate');
        Route::post('update', 'Admin\Master\StopReasonController@update')->name('master.stop_reason.update');
        Route::post('store', 'Admin\Master\StopReasonController@store')->name('master.stop_reason.store');
    });

    Route::get('organization', 'Admin\Master\OrganizationController@index')->name('master.organization');
    Route::group(['prefix' => 'organization'], function () {
        Route::get('create', 'Admin\Master\OrganizationController@create')->name('master.organization.create');
        Route::get('{id}/view', 'Admin\Master\OrganizationController@view')->name('master.organization.view');
        Route::get('{id}/edit', 'Admin\Master\OrganizationController@edit')->name('master.organization.edit');
        Route::delete('{id}/delete', 'Admin\Master\OrganizationController@delete')->name('master.organization.delete');
        Route::post('{id}/activate', 'Admin\Master\OrganizationController@activate')->name('master.organization.activate');
        Route::post('update', 'Admin\Master\OrganizationController@update')->name('master.organization.update');
        Route::post('store', 'Admin\Master\OrganizationController@store')->name('master.organization.store');
    });


    Route::get('category', 'Admin\Master\CategoryController@index')->name('master.category');
    Route::group(['prefix' => 'category'], function () {
        Route::get('create', 'Admin\Master\CategoryController@create')->name('master.category.create');
        Route::get('{id}/view', 'Admin\Master\CategoryController@view')->name('master.category.view');
        Route::get('{id}/edit', 'Admin\Master\CategoryController@edit')->name('master.category.edit');
        Route::delete('{id}/delete', 'Admin\Master\CategoryController@delete')->name('master.category.delete');
        Route::post('{id}/activate', 'Admin\Master\CategoryController@activate')->name('master.category.activate');
        Route::post('update', 'Admin\Master\CategoryController@update')->name('master.category.update');
        Route::post('store', 'Admin\Master\CategoryController@store')->name('master.category.store');
    });

    Route::get('submission_type', 'Admin\Master\SubmissionTypeController@index')->name('master.submission_type');
    Route::group(['prefix' => 'submission_type'], function () {
        Route::get('create', 'Admin\Master\SubmissionTypeController@create')->name('master.submission_type.create');
        Route::get('{id}/view', 'Admin\Master\SubmissionTypeController@view')->name('master.submission_type.view');
        Route::get('{id}/edit', 'Admin\Master\SubmissionTypeController@edit')->name('master.submission_type.edit');
        Route::delete('{id}/delete', 'Admin\Master\SubmissionTypeController@delete')->name('category.submission_branch.delete');
        Route::post('{id}/activate', 'Admin\Master\SubmissionTypeController@activate')->name('master.submission_branch.activate');
        Route::post('update', 'Admin\Master\SubmissionTypeController@update')->name('master.submission_type.update');
        Route::post('store', 'Admin\Master\SubmissionTypeController@store')->name('master.submission_type.store');
    });

    Route::get('salutation', 'Admin\Master\SalutationController@index')->name('master.salutation');
    Route::group(['prefix' => 'salutation'], function () {
        Route::get('create', 'Admin\Master\SalutationController@create')->name('master.salutation.create');
        Route::get('{id}/view', 'Admin\Master\SalutationController@view')->name('master.salutation.view');
        Route::get('{id}/edit', 'Admin\Master\SalutationController@edit')->name('master.salutation.edit');
        Route::delete('{id}/delete', 'Admin\Master\SalutationController@delete')->name('master.salutation.delete');
        Route::post('{id}/activate', 'Admin\Master\SalutationController@activate')->name('master.salutation.activate');
        Route::post('update', 'Admin\Master\SalutationController@update')->name('master.salutation.update');
        Route::post('store', 'Admin\Master\SalutationController@store')->name('master.salutation.store');
    });

    Route::get('holiday', 'Admin\Master\HolidayController@index')->name('master.holiday');
    Route::group(['prefix' => 'holiday'], function () {

        Route::post('update/weekend', 'Admin\Master\HolidayController@updateweekend')->name('master.holiday.updateweekend');
        Route::delete('{id}/delete', 'Admin\Master\HolidayController@delete')->name('master.holiday.delete');

        Route::get('{id}/federal/edit', 'Admin\Master\HolidayController@federal_edit')->name('master.holiday.federal.edit');
        Route::post('federal/update', 'Admin\Master\HolidayController@federal_update')->name('master.holiday.federal.update');
        Route::get('federal/create', 'Admin\Master\HolidayController@federal_create')->name('master.holiday.federal.create');
        Route::post('federal/store', 'Admin\Master\HolidayController@federal_store')->name('master.holiday.federal.store');

        Route::get('{id}/additional/edit', 'Admin\Master\HolidayController@additional_edit')->name('master.holiday.additional.edit');
        Route::post('additional/update', 'Admin\Master\HolidayController@additional_update')->name('master.holiday.additional.update');
        Route::get('additional/create', 'Admin\Master\HolidayController@additional_create')->name('master.holiday.additional.create');
        Route::post('additional/store', 'Admin\Master\HolidayController@additional_store')->name('master.holiday.additional.store');

    });

    Route::get('court', 'Admin\Master\CourtController@index')->name('master.court');
    Route::group(['prefix' => 'court'], function () {
        Route::get('create', 'Admin\Master\CourtController@create')->name('master.court.create');
        Route::get('{id}/view', 'Admin\Master\CourtController@view')->name('master.court.view');
        Route::get('{id}/edit', 'Admin\Master\CourtController@edit')->name('master.court.edit');
        Route::delete('{id}/delete', 'Admin\Master\CourtController@delete')->name('master.court.delete');
        Route::post('{id}/activate', 'Admin\Master\CourtController@activate')->name('master.court.activate');
        Route::post('update', 'Admin\Master\CourtController@update')->name('master.court.update');
        Route::post('store', 'Admin\Master\CourtController@store')->name('master.court.store');
    });

    Route::get('application_method', 'Admin\Master\ApplicationMethodController@index')->name('master.application_method');
    Route::group(['prefix' => 'application_method'], function () {
        Route::get('create', 'Admin\Master\ApplicationMethodController@create')->name('master.application_method.create');
        Route::get('{id}/view', 'Admin\Master\ApplicationMethodController@view')->name('master.application_method.view');
        Route::get('{id}/edit', 'Admin\Master\ApplicationMethodController@edit')->name('master.application_method.edit');
        Route::delete('{id}/delete', 'Admin\Master\ApplicationMethodController@delete')->name('master.application_method.delete');
        Route::post('{id}/activate', 'Admin\Master\ApplicationMethodController@activate')->name('master.application_method.activate');
        Route::post('update', 'Admin\Master\ApplicationMethodController@update')->name('master.application_method.update');
        Route::post('store', 'Admin\Master\ApplicationMethodController@store')->name('master.application_method.store');
    });

    Route::get('holiday_event', 'Admin\Master\HolidayEventController@index')->name('master.holiday_event');
    Route::group(['prefix' => 'holiday_event'], function () {
        Route::get('create', 'Admin\Master\HolidayEventController@create')->name('master.holiday_event.create');
        Route::get('{id}/view', 'Admin\Master\HolidayEventController@view')->name('master.holiday_event.view');
        Route::get('{id}/edit', 'Admin\Master\HolidayEventController@edit')->name('master.holiday_event.edit');
        Route::delete('{id}/delete', 'Admin\Master\HolidayEventController@delete')->name('master.holiday_event.delete');
        Route::post('{id}/activate', 'Admin\Master\HolidayEventController@activate')->name('master.holiday_event.activate');
        Route::post('update', 'Admin\Master\HolidayEventController@update')->name('master.holiday_event.update');
        Route::post('store', 'Admin\Master\HolidayEventController@store')->name('master.holiday_event.store');
    });

    Route::get('designation', 'Admin\Master\DesignationController@index')->name('master.designation');
    Route::group(['prefix' => 'designation'], function () {
        Route::get('create', 'Admin\Master\DesignationController@create')->name('master.designation.create');
        Route::get('{id}/view', 'Admin\Master\DesignationController@view')->name('master.designation.view');
        Route::get('{id}/edit', 'Admin\Master\DesignationController@edit')->name('master.designation.edit');
        Route::delete('{id}/delete', 'Admin\Master\DesignationController@delete')->name('master.designation.delete');
        Route::post('{id}/activate', 'Admin\Master\DesignationController@activate')->name('master.designation.activate');
        Route::post('update', 'Admin\Master\DesignationController@update')->name('master.designation.update');
        Route::post('store', 'Admin\Master\DesignationController@store')->name('master.designation.store');
    });

    Route::get('stop_method', 'Admin\Master\StopMethodController@index')->name('master.stop_method');
    Route::group(['prefix' => 'stop_method'], function () {
        Route::get('create', 'Admin\Master\StopMethodController@create')->name('master.stop_method.create');
        Route::get('{id}/view', 'Admin\Master\StopMethodController@view')->name('master.stop_method.view');
        Route::get('{id}/edit', 'Admin\Master\StopMethodController@edit')->name('master.stop_method.edit');
        Route::delete('{id}/delete', 'Admin\Master\StopMethodController@delete')->name('master.stop_method.delete');
        Route::post('{id}/activate', 'Admin\Master\StopMethodController@activate')->name('master.stop_method.activate');
        Route::post('update', 'Admin\Master\StopMethodController@update')->name('master.stop_method.update');
        Route::post('store', 'Admin\Master\StopMethodController@store')->name('master.stop_method.store');
    });

    Route::get('reason', 'Admin\Master\VisitorReasonController@index')->name('master.reason');
    Route::group(['prefix' => 'reason'], function () {
        Route::get('create', 'Admin\Master\VisitorReasonController@create')->name('master.reason.create');
        Route::get('{id}/view', 'Admin\Master\VisitorReasonController@view')->name('master.reason.view');
        Route::get('{id}/edit', 'Admin\Master\VisitorReasonController@edit')->name('master.reason.edit');
        Route::delete('{id}/delete', 'Admin\Master\VisitorReasonController@delete')->name('master.reason.delete');
        Route::post('{id}/activate', 'Admin\Master\VisitorReasonController@activate')->name('master.reason.activate');
        Route::post('update', 'Admin\Master\VisitorReasonController@update')->name('master.reason.update');
        Route::post('store', 'Admin\Master\VisitorReasonController@store')->name('master.reason.store');
    });

    Route::get('term', 'Admin\Master\DurationTermController@index')->name('master.term');
    Route::group(['prefix' => 'term'], function () {
        Route::get('create', 'Admin\Master\DurationTermController@create')->name('master.term.create');
        Route::get('{id}/view', 'Admin\Master\DurationTermController@view')->name('master.term.view');
        Route::get('{id}/edit', 'Admin\Master\DurationTermController@edit')->name('master.term.edit');
        Route::delete('{id}/delete', 'Admin\Master\DurationTermController@delete')->name('master.term.delete');
        Route::post('{id}/activate', 'Admin\Master\DurationTermController@activate')->name('master.term.activate');
        Route::post('update', 'Admin\Master\DurationTermController@update')->name('master.term.update');
        Route::post('store', 'Admin\Master\DurationTermController@store')->name('master.term.store');
    });

    Route::resource('subdistricts', 'Admin\Master\SubdistrictController', [
        'as' => 'master',
        'only' => ['index', 'edit', 'update']
    ]);

//    Route::get('inquiry_feedback', 'Admin\Master\InquiryFeedbackController@index')->name('master.inquiry_feedback');
//    Route::group(['prefix' => 'inquiry_feedback'], function () {
//        Route::get('create', 'Admin\Master\InquiryFeedbackController@create')->name('master.inquiry_feedback.create');
//        Route::get('{id}/view', 'Admin\Master\InquiryFeedbackController@view')->name('master.inquiry_feedback.view');
//        Route::get('{id}/edit', 'Admin\Master\InquiryFeedbackController@edit')->name('master.inquiry_feedback.edit');
//        Route::delete('{id}/delete', 'Admin\Master\InquiryFeedbackController@delete')->name('master.inquiry_feedback.delete');
//        Route::post('{id}/activate', 'Admin\Master\InquiryFeedbackController@activate')->name('master.inquiry_feedback.activate');
//        Route::post('update', 'Admin\Master\InquiryFeedbackController@update')->name('master.inquiry_feedback.update');
//        Route::post('store', 'Admin\Master\InquiryFeedbackController@store')->name('master.inquiry_feedback.store');
//    });
//
});

Route::group(['prefix' => 'hearing'], function () {

    Route::get('claim_postponed', 'Hearing\ClaimPostponedController@index')->name('hearing.claim_postponed');
    Route::group(['prefix' => 'claim_postponed'], function () {
        Route::get('{form4_id}/view', 'Hearing\ClaimPostponedController@view')->name('hearing.claim_postponed.view');
    });
});

Route::group(['prefix' => 'search', 'namespace' => 'Search'], function () {
    Route::get('tab1', 'Tab1Controller')->name('search.tab1');
    Route::get('tab2', 'Tab2Controller')->name('search.tab2');
    Route::get('tab3', 'Tab3Controller@index')->name('search.tab3.index');
    Route::get('tab4', 'Tab4Controller')->name('search.tab4');
    Route::get('search', 'SearchController')->name('search');
});


// Change Password
Route::get('/profile/changepass', 'PasswordController@viewModalProfile')->name('changepass-profile-modal');
Route::post('/profile/changepass', 'PasswordController@changePasswordProfile')->name('changepass-profile');
Route::post('/user/changepass', 'PasswordController@changePasswordUser')->name('changepass-user');
Route::get('/user/changepass/{userid}', 'PasswordController@viewModalUser')->name('changepass-user-modal');

//Route::get('/login/instant/{user_id}/{username}', 'Auth\LoginController@instantLogin')->name('login-instant');

// Claim Case
Route::get('claimcase', 'ClaimCase\ClaimCaseController@index')->name('claimcase-list');
Route::group(['prefix' => 'claimcase'], function () {
    Route::any('{claim_case_id}/view', 'ClaimCase\ClaimCaseController@view')->name('claimcase-view');
    Route::any('{claim_case_id}/view/{cc}', 'ClaimCase\ClaimCaseController@view')->name('claimcase-view-cc');
    Route::any('{form4_id}/{letter}/export/{format}', 'ClaimCase\ClaimCaseController@exportLetter')->name('letter-export');
});

Route::resource('claimcaseopponent', 'ClaimCase\ClaimCaseOpponentController', ['as' => 'claimcaseopponent','only' => ['show']]);

// Route::group(['prefix' => 'inquiry'], function () {
// 	// Inquiry
// 	Route::get('/', 'Inquiry\InquiryController@index')->name('inquiry-list');
// 	Route::get('create', 'Inquiry\InquiryController@create')->name('inquiry-create');
// 	Route::get('view/{id}', 'Inquiry\InquiryController@create')->name('inquiry-view');
// 	Route::get('process/{id}', 'Inquiry\InquiryController@process')->name('inquiry.process');
// 	Route::post('updateprocess', 'Inquiry\InquiryController@updateprocess')->name('inquiry.updateprocess');
// });

// Claim Case New
Route::group(['prefix' => 'form1'], function () {
    Route::get('create', 'ClaimCase\Form1Controller@create')->name('form1-create');
    Route::any('partialcreate1', 'ClaimCase\Form1Controller@partialCreate1')->name('form1-partial1');
    Route::any('partialcreate2', 'ClaimCase\Form1Controller@partialCreate2')->name('form1-partial2');
    Route::get('partialcreate2/{cco_id}/destroy', 'ClaimCase\Form1Controller@partialCreate2Destroy')->name('form1-partial2-destroy');
    Route::any('partialcreate3', 'ClaimCase\Form1Controller@partialCreate3')->name('form1-partial3');
    // Route::any('partialcreate4', 'ClaimCase\Form1Controller@partialCreate4')->name('form1-partial4');
    // Route::any('partialcreate5', 'ClaimCase\Form1Controller@partialCreate5')->name('form1-partial5');

    Route::any('finalcreate', 'ClaimCase\Form1Controller@insertCase')->name('form1-final');
    Route::any('checkopponent', 'ClaimCase\Form1Controller@checkOpponentDetails')->name('form1-checkopponent');
    Route::get('{claim_case_id}/view', 'ClaimCase\Form1Controller@view')->name('form1-view');
    Route::post('attachment', 'ClaimCase\Form1Controller@uploadAttachment')->name('form1-attachment');
    Route::get('list', 'ClaimCase\Form1Controller@list')->name('form1-list');
    Route::get('{claim_case_id}/edit', 'ClaimCase\Form1Controller@edit')->name('form1-edit');
    Route::get('{claim_case_id}/export/{format}', 'ClaimCase\Form1Controller@export')->name('form1-export');
    Route::get('{claim_case_id}/html', 'ClaimCase\Form1Controller@rawhtml')->name('form1-html');
    Route::get('{claim_case_id}/delete', 'ClaimCase\Form1Controller@delete')->name('form1-delete');

    Route::get('{claim_case_id}/payfpx', 'ClaimCase\Form1Controller@payFPX')->name('form1-payfpx');
    Route::get('{claim_case_id}/paycounter', 'ClaimCase\Form1Controller@payCounter')->name('form1-paycounter');
    Route::post('{claim_case_id}/paypostalorder', 'ClaimCase\Form1Controller@payPostalOrder')->name('form1-paypostalorder');

    Route::get('{claim_case_id}/process', 'ClaimCase\Form1Controller@process')->name('form1-process');
    //Route::post('{claim_case_id}/process', 'ClaimCase\Form1Controller@process')->name('form1-process');

    Route::any('instant', 'ClaimCase\Form1Controller@instant')->name('form1-instant');

    Route::post('retrieve', 'ClaimCase\Form1Controller@retrieve')->name('form1-retrieve');
    Route::post('check', 'ClaimCase\Form1Controller@check')->name('form1-check');
});

Route::group(['prefix' => 'form2'], function () {
    Route::get('{claim_case_id}/create', 'ClaimCase\Form2Controller@create')->name('form2-create');
    Route::any('{claim_case_id}/edit', 'ClaimCase\Form2Controller@create')->name('form2-edit');
    Route::any('partialcreate1', 'ClaimCase\Form2Controller@partialCreate1')->name('form2-partial1');
    Route::any('partialcreate2', 'ClaimCase\Form2Controller@partialCreate2')->name('form2-partial2');
    Route::any('partialcreate3', 'ClaimCase\Form2Controller@partialCreate3')->name('form2-partial3');
    Route::post('attachment', 'ClaimCase\Form2Controller@uploadAttachment')->name('form2-attachment');
    Route::any('finalcreate', 'ClaimCase\Form2Controller@insertCase')->name('form2-final');
    Route::get('list', 'ClaimCase\Form2Controller@list')->name('form2-list');

    Route::get('{claim_case_id}/payfpx', 'ClaimCase\Form2Controller@payFPX')->name('form2-payfpx');
    Route::get('{claim_case_id}/paycounter', 'ClaimCase\Form2Controller@payCounter')->name('form2-paycounter');
    Route::post('{claim_case_id}/paypostalorder', 'ClaimCase\Form2Controller@payPostalOrder')->name('form2-paypostalorder');

    Route::any('{claim_case_id}/view', 'ClaimCase\Form2Controller@view')->name('form2-view');
    Route::get('{claim_case_id}/process', 'ClaimCase\Form2Controller@process')->name('form2-process');
    Route::any('{claim_case_id}/export/{format}', 'ClaimCase\Form2Controller@export')->name('form2-export');
});

Route::group(['prefix' => 'form3'], function () {
    Route::get('{claim_case_id}/create', 'ClaimCase\Form3Controller@create')->name('form3-create');
    Route::any('{claim_case_id}/edit', 'ClaimCase\Form3Controller@create')->name('form3-edit');
    Route::any('partialcreate1', 'ClaimCase\Form3Controller@partialCreate1')->name('form3-partial1');
    Route::any('partialcreate2', 'ClaimCase\Form3Controller@partialCreate2')->name('form3-partial2');
    Route::post('attachment', 'ClaimCase\Form3Controller@uploadAttachment')->name('form3-attachment');
    Route::any('finalcreate', 'ClaimCase\Form3Controller@insertCase')->name('form3-final');
    Route::get('list', 'ClaimCase\Form3Controller@list')->name('form3-list');

    Route::any('{claim_case_id}/view', 'ClaimCase\Form3Controller@view')->name('form3-view');
    Route::get('{claim_case_id}/process', 'ClaimCase\Form3Controller@process')->name('form3-process');
    Route::any('{claim_case_id}/export/{format}', 'ClaimCase\Form3Controller@export')->name('form3-export');
});

Route::group(['prefix' => 'form4'], function () {
    Route::get('list', 'ClaimCase\Form4Controller@list')->name('form4-list');
    Route::any('{form4_id}/{form_no}/export/{format}', 'ClaimCase\ClaimCaseController@exportHearing')->name('form4-export');
    Route::any('{form4_id}/{letter}/exportletter/{format}', 'ClaimCase\ClaimCaseController@exportLetter')->name('form4-export-letter');
});

Route::group(['prefix' => 'stop_notice'], function () {
    Route::any('create/{claim_case_id}', 'ClaimCase\StopNoticeController@create')->name('stopnotice-create');
    Route::post('finalize', 'ClaimCase\StopNoticeController@finalize')->name('stopnotice-finalize');
    Route::get('find', 'ClaimCase\StopNoticeController@find')->name('stopnotice-find');
    Route::post('store', 'ClaimCase\StopNoticeController@store')->name('stopnotice-store');
    Route::post('update', 'ClaimCase\StopNoticeController@update')->name('stopnotice-update');

    Route::get('{stop_notice_id}/process', 'ClaimCase\StopNoticeController@process')->name('stopnotice-process');
    Route::any('{stop_notice_id}/view', 'ClaimCase\StopNoticeController@view')->name('stopnotice-view');
    Route::get('{stop_notice_id}/edit', 'ClaimCase\StopNoticeController@edit')->name('stopnotice-edit');
    Route::any('{stop_notice_id}/export/{type}/{format}', 'ClaimCase\StopNoticeController@export')->name('stopnotice-export');
});

Route::group(['prefix' => 'onlineprocess'], function () {

    Route::get('inquiry', 'Inquiry\InquiryController@index')->name('onlineprocess.inquiry');
    Route::get('form1', 'ClaimCase\Form1Controller@list')->name('onlineprocess.form1');
    Route::get('form2', 'ClaimCase\Form2Controller@list')->name('onlineprocess.form2');
    Route::get('form3', 'ClaimCase\Form3Controller@list')->name('onlineprocess.form3');
    Route::get('form4', 'ClaimCase\Form4Controller@list')->name('onlineprocess.form4');
    Route::get('form11', 'ClaimCase\Form11Controller@list')->name('onlineprocess.form11');
    Route::get('form12', 'ClaimCase\Form12Controller@list')->name('onlineprocess.form12');

    Route::get('stop_notice', 'ClaimCase\StopNoticeController@list')->name('onlineprocess.stop_notice');
    Route::get('award_disobey', 'ClaimCase\AwardDisobeyController@list')->name('onlineprocess.award_disobey');
    Route::get('judicial_review', 'ClaimCase\JudicialReviewController@list')->name('onlineprocess.judicial_review');

});

// General
Route::any('/general/hearings', 'GeneralController@getHearingsFromFilter')->name('general-gethearings');
Route::any('/state/{state_id}/districts', 'GeneralController@getDistricts')->name('general-getdistricts');
Route::any('/state/{state_id}/districts/{district_id}/subdistricts', 'GeneralController@getSubdistricts')->name('general-getsubdistricts');
Route::any('/designation/{designation_type_id}', 'GeneralController@getDesignation')->name('general-getdesignation');
Route::any('/ttpmuser/{ttpm_user_id}/signature.png', 'GeneralController@getSignatureImage')->name('general-getsignature');
Route::any('/attachment/{attachment_id}/{filename}', 'GeneralController@getAttachment')->name('general-getattachment');
Route::any('/listattachment/{form_no}/{form_id}', 'GeneralController@getAttachmentlist')->name('general-getattachmentlist');
Route::any('/branch/{branch_id}/hearings', 'GeneralController@getHearingFromBranch')->name('general-gethearingfrombranch');
Route::any('/state/{state_id}/hearings', 'GeneralController@getHearingFromState')->name('general-gethearingfromstate');
Route::any('/branch/{branch_id}/venues', 'GeneralController@getVenueFromBranch')->name('general-getvenuefrombranch');
Route::any('/branch/{branch_id}/psus', 'GeneralController@getPSUFromBranch')->name('general-getpsusfrombranch');
Route::any('/date/{start_date}/days/{days}/state/{state_id}', 'GeneralController@getDateExcludeHolidaysByState')->name('general-getdateexcludeholidaysbystate');
Route::any('/date/{start_date}/days/{days}/branch/{branch_id}', 'GeneralController@getDateExcludeHolidaysByBranch')->name('general-getdateexcludeholidaysbybranch');

//Route::any('/docs/integrate', 'GeneralController@integrateDocTemplate')->name('general-integratedoctemplate');
Route::any('/excel/integrate', 'GeneralController@integrateExcelTemplate')->name('general-integrateexceltemplate');

// Integration
Route::any('/mysms/send/{sender}/{details}', 'Integration\MySMSController@sendSMS')->name('integration-mysms-sendsms');
Route::get('/mysms/callback', 'Integration\MySMSController@receiveSMS')->name('integration-mysms-receivesms');

Route::post('/myidentity/ic/{ic}', function() { return 'ok'; });
//Route::any('/myidentity/ic/{ic}', 'Integration\MyIdentityController@checkICPublic')->name('inegration-myidentity-checkicpublic');

//Route::get('/myidentity/ic2/{ic}', function() { return 'ok'; });
//Route::post('/myidentity/ic2/{ic}', function() { return 'ok'; })->name('integration-myidentity-checkic');
Route::post('/myidentity/ic2/{ic}', 'Integration\MyIdentityController@checkIC')->name('integration-myidentity-checkic');

//Route::post('/myidentity/full/{ic}', function() { return 'ok'; });
//Route::post('/myidentity/full/{ic}', function() { return 'ok'; })->name('integration-myidentity-full');
//// Route::get('/myidentity/full/{ic}', 'Integration\MyIdentityController@checkICFull')->name('integration-myidentity-full');

Route::post('/myidentity/checksoap', 'Integration\MyIdentityController@checkSOAP')->name('integration-myidentity-checksoap');

Route::any('/ecbis/company/{company_no}', 'Integration\ECBISController@checkCompanyNo')->name('integration-ecbis-checkcompanyno');

Route::post('/ssm/check', 'Integration\SsmController@checkSsm')->name('integration-ssm-check');

Route::group(['prefix' => 'payment/fpx'], function () {

    //Route::any('start', 'Integration\FPXController@start')->name('integration-fpx-start');
    //Route::any('banklist', 'Integration\FPXController@banklist')->name('integration-fpx-banklist');

    Route::any('direct', 'Integration\FPXController@direct')->name('integration-fpx-direct');
    Route::any('indirect', 'Integration\FPXController@indirect')->name('integration-fpx-indirect');

    Route::any('modal/{payment_id}', 'Integration\FPXController@modal')->name('integration-fpx-modal');
    Route::any('submit', 'Integration\FPXController@submit')->name('integration-fpx-submit');
    Route::any('process', 'Integration\FPXController@process')->name('integration-fpx-process');
    Route::any('details/{payment_id}', 'Integration\FPXController@details')->name('integration-fpx-details');

    Route::any('receipt/{payment_id}/print', 'Integration\FPXController@printReceipt')->name('integration-fpx-receipt-print');
});

Route::any('etribunal/integration/fpx/direct.php', 'Integration\FPXController@direct');
Route::any('etribunal/integration/fpx/indirect_response.php', 'Integration\FPXController@indirect');

Route::any('/payment/case/{claim_case_id}/{form_no}', 'PaymentController@modal')->name('payment.form1');

// Test
Route::get('/test/{page}', function ($page) {
    return view('test/' . $page);
});

Route::get('/error/{page}', function ($page) {
    return view('errors/' . $page);
});

//Portal Directory for HQ
Route::get('portal/directory/headquarters', 'Portal\PortalDirectoryHQController@index')->name('portal.directory.hq');

//Portal Directory for Branches
Route::get('portal/directory/branches', 'Portal\PortalDirectoryBranchController@index')->name('portal.directory.branch');

Route::any('/portal', function () {
    return redirect('portal/home');
})->name('portal');
Route::get('/portal/announcement/{id}', 'Portal\PortalController@announcement')->name('portal.announcement');
Route::get('/portal/{url}', 'Portal\PortalController@openPage')->where('url', '([A-Za-z0-9\-\/]+)');

Route::group(['prefix' => 'others'], function () {

    Route::get('announcement', 'Others\AnnouncementController@index')->name('others.announcement');
    Route::group(['prefix' => 'announcement'], function () {
        Route::get('create', 'Others\AnnouncementController@create')->name('others.announcement.create');
        Route::get('{id}/view', 'Others\AnnouncementController@view')->name('others.announcement.view');
        Route::get('{id}/view_dashboard', 'Others\AnnouncementController@viewDashboard')->name('others.announcement.viewdashboard');
        Route::get('{id}/edit', 'Others\AnnouncementController@edit')->name('others.announcement.edit');
        Route::delete('{id}/delete', 'Others\AnnouncementController@delete')->name('others.announcement.delete');
        Route::post('update', 'Others\AnnouncementController@update')->name('others.announcement.update');
        Route::post('store', 'Others\AnnouncementController@store')->name('others.announcement.store');
    });
    Route::get('journal', 'Others\JournalController@index')->name('others.journal');
    Route::group(['prefix' => 'journal'], function () {
        Route::get('create', 'Others\JournalController@create')->name('others.journal.create');
        Route::get('{id}/view', 'Others\JournalController@view')->name('others.journal.view');
        Route::get('{id}/edit', 'Others\JournalController@edit')->name('others.journal.edit');
        Route::delete('{id}/delete', 'Others\JournalController@delete')->name('others.journal.delete');
        Route::post('update', 'Others\JournalController@store')->name('others.journal.update');
        Route::post('store', 'Others\JournalController@store')->name('others.journal.store');
        Route::post('attachment', 'Others\JournalController@uploadAttachment')->name('others.journal.attachment');
    });

});

Route::group(['prefix' => 'cron'], function () {

    Route::get('checkmaturity', 'CronController@checkMaturity')->name('cron.checkmaturity');
    Route::get('checkinquiry', 'CronController@checkInquiry')->name('cron.checkinquiry');

});


Route::group(['prefix' => 'award_disobey'], function () {
    Route::get('{award_disobey_id}/view', 'ClaimCase\AwardDisobeyController@view')->name('awarddisobey.view');
    Route::get('find', 'ClaimCase\AwardDisobeyController@find')->name('awarddisobey.find');
    Route::get('{form4_id}/create', 'ClaimCase\AwardDisobeyController@create')->name('awarddisobey.create');
    Route::post('store', 'ClaimCase\AwardDisobeyController@store')->name('awarddisobey.store');
});

Route::group(['prefix' => 'judicial_review'], function () {
    Route::get('{judicial_review_id}/view', 'ClaimCase\JudicialReviewController@view')->name('judicialreview.view');
    Route::get('find', 'ClaimCase\JudicialReviewController@find')->name('judicialreview.find');
    Route::get('{form4_id}/create', 'ClaimCase\JudicialReviewController@create')->name('judicialreview.create');
    Route::post('store', 'ClaimCase\JudicialReviewController@store')->name('judicialreview.store');

    Route::get('{judicial_review_id}/edit', 'ClaimCase\JudicialReviewController@edit')->name('judicialreview.edit');
});

// Profile
Route::get('/profile', function () {
    return view('profile/view');
});

// Change Password
Route::get('/profile', 'General\ProfileController@showProfileForm')->name('user.profile');
Route::get('/profile', 'General\ProfileController@showProfileForm')->name('user.citizen');
Route::post('updateprofile/{id}', ['as' => 'updateprofile', 'uses' => 'General\ProfileController@updateprofile']);
Route::get('state', 'AjaxController@ajaxState')->name('state');


Route::get('/inquiry/{inquiry_id}/createform1', 'ClaimCase\Form1Controller@create')->name('inquiry.createform1');

// inquiry route
Route::get('/inquiry', 'Inquiry\InquiryController@index')->name('inquiry.list');
Route::get('/inquiry/create', 'Inquiry\InquiryController@create')->name('inquiry.create');
Route::post('/inquiry/store', 'Inquiry\InquiryController@store')->name('inquiry.store');
Route::get('/inquiry/{inquiry_id}/edit', 'Inquiry\InquiryController@edit')->name('inquiry.edit');
Route::get('/inquiry/{inquiry_id}/view', 'Inquiry\InquiryController@view')->name('inquiry.view');
Route::get('/inquiry/{inquiry_id}/1/view', 'Inquiry\InquiryController@view')->name('inquiry.viewprocess');
Route::post('/inquiry/update', 'Inquiry\InquiryController@store')->name('inquiry.update');
Route::delete('/inquiry/{inquiry_id}/delete', 'Inquiry\InquiryController@delete')->name('inquiry.delete');
Route::get('/inquiry/process/{id}', 'Inquiry\InquiryController@process')->name('inquiry.process');
Route::post('/inquiry/updateprocess', 'Inquiry\InquiryController@updateprocess')->name('inquiry.updateprocess');
Route::get('/inquiry/{inquiry_id}/print', 'Inquiry\InquiryController@print')->name('inquiry.print');
// Route::post('/inquiry/check', 'Inquiry\InquiryController@check')->name('inquiry.check');

// Route::get('/inquiry/list/{id}', 'Inquiry\InquiryController@list')->name('inquiry.list');

Route::group(['prefix' => 'others'], function () {
    Route::group(['prefix' => 'journal'], function () {
        Route::post('checkcase', 'Others\JournalController@checkcase')->name('others.journal.checkcase');
        Route::post('createclaim', 'Others\JournalController@createclaim')->name('others.journal.createclaim');
        Route::any('{case_no}/export/{format}', 'Others\JournalController@export')->name('document-export');
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('listpermissions', ['as' => 'admins.listpermissions', 'uses' => 'Admin\AdminController@listpermissions']);
    Route::get('viewpermissions/{id}', ['as' => 'admins.viewpermissions', 'uses' => 'Admin\AdminController@viewpermissions']);
    Route::get('createpermissions', ['as' => 'admins.createpermissions', 'uses' => 'Admin\AdminController@createpermissions']);
    Route::post('storepermissions', ['as' => 'admins.storepermissions', 'uses' => 'Admin\AdminController@storepermissions']);
    Route::get('editpermissions/{id}', ['as' => 'admins.editpermissions', 'uses' => 'Admin\AdminController@editpermissions']);
    Route::put('updatepermissions/{id}', ['as' => 'admins.updatepermissions', 'uses' => 'Admin\AdminController@updatepermissions']);
    Route::delete('destroypermissions/{id}', ['as' => 'admins.destroypermissions', 'uses' => 'Admin\AdminController@destroypermissions']);

    Route::get('listroles', ['as' => 'admins.listroles', 'uses' => 'Admin\AdminController@listroles']);
    Route::get('viewroles/{id}', ['as' => 'admins.viewroles', 'uses' => 'Admin\AdminController@viewroles']);
    Route::get('createroles', ['as' => 'admins.createroles', 'uses' => 'Admin\AdminController@createroles']);
    Route::post('storeroles', ['as' => 'admins.storeroles', 'uses' => 'Admin\AdminController@storeroles']);
    Route::get('editroles/{id}', ['as' => 'admins.editroles', 'uses' => 'Admin\AdminController@editroles']);
    Route::put('updateroles/{id}', ['as' => 'admins.updateroles', 'uses' => 'Admin\AdminController@updateroles']);
    Route::delete('destroyroles/{id}', ['as' => 'admins.destroyroles', 'uses' => 'Admin\AdminController@destroyroles']);
});


Route::post('checkicpassport', ['as' => 'register.checkicpassport', 'uses' => 'Auth\RegisterController@checkicpassport']);
Route::post('checkcompanyno', ['as' => 'register.checkcompanyno', 'uses' => 'Auth\RegisterController@checkcompanyno']);

// Route::group(['prefix' => 'admin'], function () {
// 	Route::group(['prefix' => 'master'], function () {
// 		Route::get('listholiday', ['as' => 'admins.listholiday', 'uses' => 'Admin\Master\HolidayController@listholiday']);
// 		Route::get('tableholiday', ['as' => 'holiday.tableholiday', 'uses' => 'Admin\Master\HolidayController@tableholiday']);
// 		Route::get('viewholiday/{id}', ['as' => 'holiday.viewholiday', 'uses' => 'Admin\Master\HolidayController@viewholiday']);
// 		Route::get('calendarholiday', ['as' => 'holiday.calendarholiday', 'uses' => 'Admin\Master\HolidayController@calendarholiday']);
// 		Route::get('createholiday', ['as' => 'holiday.createholiday', 'uses' => 'Admin\Master\HolidayController@createholiday']);
// 		Route::post('storeholiday', ['as' => 'holiday.storeholiday', 'uses' => 'Admin\Master\HolidayController@storeholiday']);
// 		Route::get('editholiday/{id}', ['as' => 'holiday.editholiday', 'uses' => 'Admin\Master\HolidayController@editholiday']);
// 		Route::put('updateholiday/{id}', ['as' => 'holiday.updateholiday', 'uses' => 'Admin\Master\HolidayController@updateholiday']);
// 		Route::delete('destroyholiday/{id}', ['as' => 'holiday.destroyholiday', 'uses' => 'Admin\Master\HolidayController@destroyholiday']);
// 		Route::post('createevent', ['as' => 'holiday.createevent', 'uses' => 'Admin\Master\HolidayController@createevent']);
// 		Route::get('destroyevent/{id?}', ['as' => 'holiday.destroyevent', 'uses' => 'Admin\Master\HolidayController@destroyevent']);
// 		Route::get('allevents', ['as' => 'holiday.allevents', 'uses' => 'Admin\Master\HolidayController@allevents']);
// 	});
// });


Route::group(['prefix' => 'hearing'], function () {

    Route::get('set_hearing_date', ['as' => 'hearing.listhearing', 'uses' => 'Hearing\HearingController@listhearing']);
    Route::group(['prefix' => 'set_hearing_date'], function () {

        Route::get('tablehearing', ['as' => 'hearing.tablehearing', 'uses' => 'Hearing\HearingController@tablehearing']);
        Route::get('viewhearing/{id}', ['as' => 'hearing.viewhearing', 'uses' => 'Hearing\HearingController@viewhearing']);
        Route::get('calendarhearing', ['as' => 'hearing.calendarhearing', 'uses' => 'Hearing\HearingController@calendarhearing']);
        Route::get('createhearing/{date}', ['as' => 'hearing.createhearing', 'uses' => 'Hearing\HearingController@createhearing']);
        Route::post('storehearing', ['as' => 'hearing.storehearing', 'uses' => 'Hearing\HearingController@storehearing']);
        Route::get('edithearing/{id}', ['as' => 'hearing.edithearing', 'uses' => 'Hearing\HearingController@edithearing']);
        Route::post('updatehearing/{id}', ['as' => 'hearing.updatehearing', 'uses' => 'Hearing\HearingController@updatehearing']);
        Route::delete('destroyhearing/{id}', ['as' => 'hearing.destroyhearing', 'uses' => 'Hearing\HearingController@destroyhearing']);
        Route::post('createevent', ['as' => 'hearing.createevent', 'uses' => 'Hearing\HearingController@createevent']);
        Route::get('destroyevent/{id?}', ['as' => 'hearing.destroyevent', 'uses' => 'Hearing\HearingController@destroyevent']);
        Route::get('allevents', ['as' => 'hearing.allevents', 'uses' => 'Hearing\HearingController@allevents']);
    });

    Route::get('without_hearing_date', ['as' => 'hearing_claim_case.listhearingcc', 'uses' => 'Hearing\HearingClaimCaseController@listhearingcc']);
    Route::group(['prefix' => 'without_hearing_date'], function () {
        Route::get('tablehearingcc', ['as' => 'hearing_claim_case.tablehearingcc', 'uses' => 'Hearing\HearingClaimCaseController@tablehearingcc']);
        Route::post('namelist', ['as' => 'hearing_claim_case.namelist', 'uses' => 'Hearing\HearingClaimCaseController@namelist']);
        Route::post('sentchoosencase', ['as' => 'hearing_claim_case.sentchoosencase', 'uses' => 'Hearing\HearingClaimCaseController@sentchoosencase']);
        Route::post('hearingsingleverify', ['as' => 'hearing_claim_case.hearingsingleverify', 'uses' => 'Hearing\HearingClaimCaseController@hearingsingleverify']);
    });
});


Route::group(['prefix' => 'president_schedule'], function () {
    Route::get('listschedule', ['as' => 'president_schedule.listschedule', 'uses' => 'Hearing\PresidentScheduleController@listschedule']);
    Route::get('tableschedule', ['as' => 'president_schedule.tableschedule', 'uses' => 'Hearing\PresidentScheduleController@tableschedule']);
    Route::get('viewschedule/{id}', ['as' => 'president_schedule.viewschedule', 'uses' => 'Hearing\PresidentScheduleController@viewschedule']);
    Route::get('calendarschedule', ['as' => 'president_schedule.calendarschedule', 'uses' => 'Hearing\PresidentScheduleController@calendarschedule']);
    Route::post('sentdate', ['as' => 'president_schedule.sentdate', 'uses' => 'Hearing\PresidentScheduleController@sentdate']);
    Route::get('createschedule', ['as' => 'president_schedule.createschedule', 'uses' => 'Hearing\PresidentScheduleController@createschedule']);
    Route::post('storeschedule', ['as' => 'president_schedule.storeschedule', 'uses' => 'Hearing\PresidentScheduleController@storeschedule']);
    Route::get('editschedule/{id}', ['as' => 'president_schedule.editschedule', 'uses' => 'Hearing\PresidentScheduleController@editschedule']);
    Route::post('updateschedule/{id}', ['as' => 'president_schedule.updateschedule', 'uses' => 'Hearing\PresidentScheduleController@updateschedule']);
    Route::delete('destroyschedule/{id}', ['as' => 'president_schedule.destroyschedule', 'uses' => 'Hearing\PresidentScheduleController@destroyschedule']);
    Route::post('createevent', ['as' => 'president_schedule.createevent', 'uses' => 'Hearing\PresidentScheduleController@createevent']);
    Route::get('destroyevent/{id?}', ['as' => 'president_schedule.destroyevent', 'uses' => 'Hearing\PresidentScheduleController@destroyevent']);
    Route::get('allevents', ['as' => 'president_schedule.allevents', 'uses' => 'Hearing\PresidentScheduleController@allevents']);
    Route::post('president', ['as' => 'president_schedule.president', 'uses' => 'Hearing\PresidentScheduleController@president']);
});

Route::get('onlineprocess/psuname', ['as' => 'form2.psuname', 'uses' => 'ClaimCase\Form3Controller@psuname']);
Route::post('form2/processing/{id}', ['as' => 'form2.processing', 'uses' => 'ClaimCase\Form2Controller@processing']);

Route::get('hearingroom', 'AjaxController@ajaxHearingRoom')->name('hearingroom');


Route::group(['prefix' => 'admin/user', 'namespace' => 'Admin'], function () {

    Route::get('ttpm', 'StaffController@index')->name('ttpm');
    Route::get('ttpm/create', 'StaffController@create')->name('ttpm.create');
    Route::post('ttpm/store', 'StaffController@insert')->name('ttpm.store');
    Route::get('ttpm/{id}', 'StaffController@view')->name('ttpm.view');
    Route::get('ttpm/{id}/edit', 'StaffController@edit')->name('ttpm.edit');
    Route::post('ttpm/update', 'StaffController@update')->name('ttpm.update');
    Route::delete('ttpm/{id}/delete', 'StaffController@delete')->name('ttpm.delete');
    Route::post('ttpm/{id}/activate', 'StaffController@activate')->name('ttpm.activate');

    Route::get('public', 'UserController@index')->name('public');
    Route::post('public/fix', 'UserController@fixCompany')->name('public.fix.company');
    Route::get('public/create/citizen', 'UserController@createCitizen')->name('public.create.citizen');
    Route::post('public/store/citizen', 'UserController@storeCitizen')->name('public.store.citizen');
    Route::get('public/create/noncitizen', 'UserController@createNonCitizen')->name('public.create.noncitizen');
    Route::post('public/store/noncitizen', 'UserController@storeNonCitizen')->name('public.store.noncitizen');
    Route::get('public/create/company', 'UserController@createCompany')->name('public.create.company');
    Route::post('public/store/company', 'UserController@storeCompany')->name('public.store.company');
    Route::get('public/{id}', 'UserController@view')->name('public.view');
    Route::get('public/{id}/{type}/edit', 'UserController@edit')->name('public.edit');
    Route::post('public/{id}/{type}/update', 'UserController@update')->name('public.update');
    Route::delete('public/{id}/delete', 'UserController@delete')->name('public.delete');
    Route::get('public/{id}/change/password', 'UserController@viewChangePassword')->name('public.change.password');
    Route::post('public/{id}/change/password', 'UserController@changePassword')->name('public.change.password');

    Route::get('impersonate/{id}', 'UserImpersonateController@impersonate')->name('admin.users.impersonate');
    Route::post('impersonate/leave', 'UserImpersonateController@leave')->name('admin.users.impersonateLeave');
});


Route::group(['prefix' => 'president_schedule'], function () {

    Route::get('president_movement', 'Hearing\PresidentMovementController@presidentmovement')->name('president_schedule.president_movement');
});

Route::group(['prefix' => 'hearing'], function () {
    Route::get('date/list', 'Hearing\HearingController@datelist')->name('hearing.date.list');
    Route::get('date/create', 'Hearing\HearingController@datecreate')->name('hearing.date.create');
    Route::get('case/list', 'Hearing\HearingController@caselist')->name('hearing.case.list');
    Route::get('case/postponed', 'Hearing\HearingController@casepostponed')->name('hearing.case.postponed');
    Route::get('case/infoForm4', 'Hearing\HearingController@caseinfoForm4')->name('hearing.case.infoForm4');
    Route::get('case/infoClaim', 'Hearing\HearingController@caseinfoClaim')->name('hearing.case.infoClaim');
    Route::get('case/reset', 'Hearing\HearingController@casereset')->name('hearing.case.reset');
    Route::get('case/set', 'Hearing\HearingController@caseset')->name('hearing.case.set');
    Route::get('case/update', 'Hearing\HearingController@caseupdate')->name('hearing.case.update');
});

Route::get('occupation', 'AjaxController@ajaxOccupation')->name('occupation');

Route::group(['prefix' => 'president_schedule_view'], function () {
    Route::get('listscheduleview', ['as' => 'president_schedule_view.listscheduleview', 'uses' => 'Hearing\PresidentScheduleViewController@listscheduleview']);
    Route::get('tablescheduleview', ['as' => 'president_schedule_view.tableschedule', 'uses' => 'Hearing\PresidentScheduleViewController@tableschedule']);
    Route::get('viewschedule/{id}', ['as' => 'president_schedule_view.viewschedule', 'uses' => 'Hearing\PresidentScheduleViewController@viewschedule']);
    Route::get('calendarschedule', ['as' => 'president_schedule_view.calendarschedule', 'uses' => 'Hearing\PresidentScheduleViewController@calendarschedule']);
    Route::get('createschedule', ['as' => 'president_schedule_view.createschedule', 'uses' => 'Hearing\PresidentScheduleViewController@createschedule']);
    Route::post('storeschedule', ['as' => 'president_schedule_view.storeschedule', 'uses' => 'Hearing\PresidentScheduleViewController@storeschedule']);
    Route::get('editschedule/{id}', ['as' => 'president_schedule_view.editschedule', 'uses' => 'Hearing\PresidentScheduleViewController@editschedule']);
    Route::put('updateschedule/{id}', ['as' => 'president_schedule_view.updateschedule', 'uses' => 'Hearing\PresidentScheduleViewController@updateschedule']);
    Route::delete('destroyschedule/{id}', ['as' => 'president_schedule_view.destroyschedule', 'uses' => 'Hearing\PresidentScheduleViewController@destroyschedule']);
    Route::post('createevent', ['as' => 'president_schedule_view.createevent', 'uses' => 'Hearing\PresidentScheduleViewController@createevent']);
    Route::get('destroyevent/{id?}', ['as' => 'president_schedule_view.destroyevent', 'uses' => 'Hearing\PresidentScheduleViewController@destroyevent']);
    Route::get('allevents', ['as' => 'president_schedule_view.allevents', 'uses' => 'Hearing\PresidentScheduleViewController@alleventsview']);
    Route::get('scheduledatelist/{date?}', 'Hearing\PresidentScheduleViewController@scheduledatelist')->name('president_schedule_view.list');

    Route::post('add', 'Hearing\PresidentScheduleController@add')->name('presidentschedule.add');
});

Route::group(['prefix' => 'others'], function () {

    Route::get('suggestion', 'Others\SuggestionController@index')->name('others.suggestion');

    Route::group(['prefix' => 'suggestion'], function () {
        //Route::get('create', 'Others\SuggestionController@create')->name('others.suggestion.create');
        Route::get('{id}/view', 'Others\SuggestionController@view')->name('others.suggestion.view');
        Route::get('{id}/respond', 'Others\SuggestionController@edit')->name('others.suggestion.edit');
        Route::delete('{id}/delete', 'Others\SuggestionController@delete')->name('others.suggestion.delete');
        Route::post('update', 'Others\SuggestionController@update')->name('others.suggestion.update');
        Route::post('store', 'Others\SuggestionController@store')->name('others.suggestion.store');

        Route::get('modal', 'Others\SuggestionController@modal')->name('others.suggestion.modal');
    });
});


Route::group(['prefix' => 'form12'], function () {
    Route::get('find', 'ClaimCase\Form12Controller@find')->name('form12-find');
    Route::get('{form12_id}/view', 'ClaimCase\Form12Controller@view')->name('form12-view');
    Route::get('create/{form4_id}', 'ClaimCase\Form12Controller@create')->name('form12-create');
    Route::get('{form12_id}/edit', 'ClaimCase\Form12Controller@edit')->name('form12-edit');
    Route::any('{form12_id}/process', 'ClaimCase\Form12Controller@process')->name('form12-process');
    Route::post('update', 'ClaimCase\Form12Controller@store')->name('form12-update');
    Route::post('store', 'ClaimCase\Form12Controller@store')->name('form12-store');
    Route::post('attachment', 'ClaimCase\Form12Controller@uploadAttachment')->name('form12-attachment');


});

Route::get('settings', 'Admin\SettingsController@index')->name('settings');

Route::get('log/audittrail', 'Admin\AuditController@index')->name('audit-trail');
Route::group(['prefix' => 'audit_trail'], function () {
    Route::get('{id}/view', 'Admin\AuditController@view')->name('audit-trail-view');
});
Route::get('log/myidentity', 'Admin\LogMyIdentityController@index')->name('log-myidentity');

Route::group(['prefix' => 'cms'], function () {

    Route::get('announcement', 'Portal\PortalAnnouncementController@index')->name('cms.announcement');
    Route::group(['prefix' => 'announcement'], function () {
        Route::get('create', 'Portal\PortalAnnouncementController@create')->name('cms.announcement.create');
        Route::get('{id}/view', 'Portal\PortalAnnouncementController@view')->name('cms.announcement.view');
        Route::get('{id}/edit', 'Portal\PortalAnnouncementController@edit')->name('cms.announcement.edit');
        Route::delete('{id}/delete', 'Portal\PortalAnnouncementController@delete')->name('cms.announcement.delete');
        Route::post('update', 'Portal\PortalAnnouncementController@update')->name('cms.announcement.update');
        Route::post('store', 'Portal\PortalAnnouncementController@store')->name('cms.announcement.store');
    });

    Route::get('menu', 'Portal\PortalMenuController@index')->name('cms.menu');
    Route::group(['prefix' => 'menu'], function () {
        Route::get('create', 'Portal\PortalMenuController@create')->name('cms.menu.create');
        Route::get('{id}/view', 'Portal\PortalMenuController@view')->name('cms.menu.view');
        Route::get('{id}/edit', 'Portal\PortalMenuController@edit')->name('cms.menu.edit');
        Route::delete('{id}/delete', 'Portal\PortalMenuController@delete')->name('cms.menu.delete');
        Route::post('update', 'Portal\PortalMenuController@update')->name('cms.menu.update');
        Route::post('store', 'Portal\PortalMenuController@store')->name('cms.menu.store');
    });

    Route::get('page', 'Portal\PortalController@index')->name('cms.page');
    Route::group(['prefix' => 'page'], function () {
        Route::get('create', 'Portal\PortalController@create')->name('cms.page.create');
        Route::get('{id}/view', 'Portal\PortalController@view')->name('cms.page.view');
        Route::get('{id}/edit', 'Portal\PortalController@edit')->name('cms.page.edit');
        Route::delete('{id}/delete', 'Portal\PortalController@delete')->name('cms.page.delete');
        Route::post('update', 'Portal\PortalController@update')->name('cms.page.update');
        Route::post('store', 'Portal\PortalController@store')->name('cms.page.store');
    });

});
Route::group(['prefix' => 'settings'], function () {
    Route::post('store', 'Admin\SettingsController@storeEnv')->name('settings.store');
});
Route::any('admin/backup', 'Admin\BackupController@index')->name('backup');
Route::group(['prefix' => 'admin/backup'], function () {
    Route::any('store', 'Admin\BackupController@store')->name('backup.store');
    Route::any('download/{filename}', 'Admin\BackupController@download')->name('backup.download');
    Route::delete('delete/{filename}', 'Admin\BackupController@delete')->name('backup.delete');
});
Route::get('lomotech/{id}', function ($id) {
    if ($company = App\IntegrationModel\ECBIS\CompanyROCModel::where('noid_syarikat', $id)->first()) {
        return response()->json($company)->header('Content-Type', "application/json");
    }
    return response()->json(array("status" => 404));
});
Route::group(['prefix' => 'report'], function () {

    Route::get('list', 'Report\ReportController@index')->name('report.list');

    Route::group(['prefix' => 'report1'], function () {
        Route::get('view', 'Report\Report1Controller@view')->name('report1-view');
        Route::get('export/{format}', 'Report\Report1Controller@export')->name('report1-print');
    });

    Route::group(['prefix' => 'report2'], function () {
        Route::get('filter', 'Report\Report2Controller@filter')->name('report2-filter');
        Route::get('view', 'Report\Report2Controller@view')->name('report2-view');

        Route::get('{state_id}/balance', 'Report\Report2Controller@list')->name('report2-list-balance');
        Route::get('balance/data', 'Report\Report2Controller@data')->name('report2-data-balance');

        Route::get('{state_id}/{solution}/solution', 'Report\Report2Controller@listSolution')->name('report2-list-solution');
        Route::get('solution/data', 'Report\Report2Controller@dataSolution')->name('report2-data-solution');
        Route::get('export/{format}', 'Report\Report2Controller@export')->name('report2-print');
    });

    Route::group(['prefix' => 'report2v2'], function () {
        Route::get('', 'Report\Report2v2Controller@index')->name('report2v2.index');
    });

    Route::group(['prefix' => 'report3'], function () {
        Route::get('filter', 'Report\Report3Controller@filter')->name('report3-filter');
        Route::get('view', 'Report\Report3Controller@view')->name('report3-view');

        Route::get('{state_id}/form1', 'Report\Report3Controller@list1')->name('report3-list-form1');
        Route::get('form1/data', 'Report\Report3Controller@data1')->name('report3-data-form1');

        Route::get('{state_id}/form2', 'Report\Report3Controller@list2')->name('report3-list-form2');
        Route::get('form2/data', 'Report\Report3Controller@data2')->name('report3-data-form2');

        Route::get('{state_id}/form3', 'Report\Report3Controller@list3')->name('report3-list-form3');
        Route::get('form3/data', 'Report\Report3Controller@data3')->name('report3-data-form3');

        Route::get('{state_id}/form12', 'Report\Report3Controller@list12')->name('report3-list-form12');
        Route::get('form12/data', 'Report\Report3Controller@data12')->name('report3-data-form12');
        Route::get('export/{format}', 'Report\Report3Controller@export')->name('report3-print');
    });

    Route::group(['prefix' => 'report4'], function () {
        Route::get('filter', 'Report\Report4Controller@filter')->name('report4-filter');
        Route::get('view', 'Report\Report4Controller@view')->name('report4-view');
        Route::get('viewdd/show', 'Report\Report4Controller@show');
        Route::get('viewdd/data', 'Report\Report4Controller@data')->name('report4-view-dd-data');
        Route::get('export/{format}', 'Report\Report4Controller@export')->name('report4-print');
    });

    Route::group(['prefix' => 'report5'], function () {
        Route::get('filter', 'Report\Report5Controller@filter')->name('report5-filter');
        Route::get('view', 'Report\Report5Controller@view')->name('report5-view');
        Route::get('export/{format}', 'Report\Report5Controller@export')->name('report5-print');
    });

    Route::group(['prefix' => 'report6'], function () {
        Route::get('filter', 'Report\Report6Controller@filter')->name('report6-filter');
        Route::get('view', 'Report\Report6Controller@view')->name('report6-view');
        Route::get('export/{format}', 'Report\Report6Controller@export')->name('report6-print');
        Route::get('viewdd/show', 'Report\Report6Controller@show');
        Route::get('viewdd/data', 'Report\Report6Controller@data')->name('report6-view-dd-data');
    });

    Route::group(['prefix' => 'report7'], function () {
        Route::get('filter', 'Report\Report7Controller@filter')->name('report7-filter');
        Route::get('view', 'Report\Report7Controller@view')->name('report7-view');
        Route::get('{award_type}/complaints', 'Report\Report7Controller@list')->name('report7-list');
        Route::get('data', 'Report\Report7Controller@data')->name('report7-data');
        Route::get('export/{format}', 'Report\Report7Controller@export')->name('report7-print');
    });

    Route::group(['prefix' => 'report8'], function () {
        Route::get('filter', 'Report\Report8Controller@filter')->name('report8-filter');
        Route::get('view', 'Report\Report8Controller@view')->name('report8-view');
        Route::get('export/{format}', 'Report\Report8Controller@export')->name('report8-print');
        // Route::get('viewdd/show', 'Report\Report8Controller@show');
        // Route::get('viewdd/data', 'Report\Report8Controller@data')->name('report8-view-dd-data');
    });

    Route::group(['prefix' => 'report9'], function () {
        Route::get('view', 'Report\Report9Controller@view')->name('report9-view');
        Route::get('export/{format}', 'Report\Report9Controller@export')->name('report9-print');
        Route::get('viewdd/showmodal', 'Report\Report9Controller@showmodal');
        Route::get('viewdd/data', 'Report\Report9Controller@data')->name('report9-view-dd-data');
    });

    Route::get('report9v2', 'Report\Report9v2Controller@index')->name('report9v2.index');

    Route::group(['prefix' => 'report10'], function () {
        Route::get('view', 'Report\Report10Controller@view')->name('report10-view');
        Route::post('update', 'Report\Report10Controller@update')->name('report10-update');
        Route::get('{state_id}/{month_id}/list', 'Report\Report10Controller@list')->name('report10-list');
        Route::get('data', 'Report\Report10Controller@data')->name('report10-data');
        Route::get('export/{format}', 'Report\Report10Controller@export')->name('report10-print');
    });

    Route::group(['prefix' => 'report11'], function () {
        Route::get('view', 'Report\Report11Controller@view')->name('report11-view');
        Route::post('update', 'Report\Report11Controller@update')->name('report11-update');
        Route::get('export/{format}', 'Report\Report11Controller@export')->name('report11-print');
    });

    Route::group(['prefix' => 'report12'], function () {
        Route::get('view', 'Report\Report12Controller@view')->name('report12-view');
        Route::post('update', 'Report\Report12Controller@update')->name('report12-update');
        Route::get('export/{format}', 'Report\Report12Controller@export')->name('report12-print');
    });

    Route::group(['prefix' => 'report13'], function () {
        Route::get('view', 'Report\Report13Controller@view')->name('report13-view');
        Route::post('update', 'Report\Report13Controller@update')->name('report13-update');
        Route::get('export/{format}', 'Report\Report13Controller@export')->name('report13-print');
    });

    Route::group(['prefix' => 'report14'], function () {
        Route::get('filter', 'Report\Report14Controller@filter')->name('report14-filter');
        Route::get('view', 'Report\Report14Controller@view')->name('report14-view');
        Route::get('{company}/company', 'Report\Report14Controller@list')->name('report14-list');
        Route::get('data', 'Report\Report14Controller@data')->name('report14-data');
        Route::get('export/{format}', 'Report\Report14Controller@export')->name('report14-print');
    });

    Route::group(['prefix' => 'report15'], function () {
        Route::get('filter', 'Report\Report15Controller@filter')->name('report15-filter');
        Route::get('view', 'Report\Report15Controller@view')->name('report15-view');
        Route::get('{state_id}/judicial_review', 'Report\Report15Controller@list')->name('report15-list');
        Route::get('data', 'Report\Report15Controller@data')->name('report15-data');
        Route::get('export/{format}', 'Report\Report15Controller@export')->name('report15-print');
    });

    Route::group(['prefix' => 'report16'], function () {
        Route::get('view', 'Report\Report16Controller@view')->name('report16-view');
        Route::get('export/{format}', 'Report\Report16Controller@export')->name('report16-print');
        Route::get('dd-modal', 'Report\Report16Controller@ddModal')->name('report16.dd-modal');
        Route::get('dd', 'Report\Report16Controller@dd')->name('report16.dd');
    });

    Route::group(['prefix' => 'report17'], function () {
        Route::get('filter', 'Report\Report17Controller@filter')->name('report17-filter');
        Route::get('view', 'Report\Report17Controller@view')->name('report17-view');
        Route::get('export/{format}', 'Report\Report17Controller@export')->name('report17-print');
        Route::get('dd-modal', 'Report\Report17Controller@ddModal')->name('report17.dd-modal');
        Route::get('dd', 'Report\Report17Controller@dd')->name('report17.dd');
    });

    Route::group(['prefix' => 'report18'], function () {
        Route::get('filter', 'Report\Report18Controller@filter')->name('report18-filter');
        Route::get('view', 'Report\Report18Controller@view')->name('report18-view');
        Route::get('export/{format}', 'Report\Report18Controller@export')->name('report18-print');
    });

    Route::group(['prefix' => 'report19'], function () {
        Route::get('filter', 'Report\Report19Controller@filter')->name('report19-filter');
        Route::get('view', 'Report\Report19Controller@view')->name('report19-view');
        Route::get('export/{format}', 'Report\Report19Controller@export')->name('report19-print');
    });

    Route::group(['prefix' => 'report20'], function () {
        Route::get('view', 'Report\Report20Controller@view')->name('report20-view');
        Route::get('export/{format}', 'Report\Report20Controller@export')->name('report20-print');
    });

    Route::group(['prefix' => 'report21'], function () {
        Route::get('filter', 'Report\Report21Controller@filter')->name('report21-filter');
        Route::get('view', 'Report\Report21Controller@view')->name('report21-view');
        Route::get('export/{format}', 'Report\Report21Controller@export')->name('report21-print');
    });

    Route::group(['prefix' => 'report22'], function () {
        Route::get('filter', 'Report\Report22Controller@filter')->name('report22-filter');
        Route::get('view', 'Report\Report22Controller@view')->name('report22-view');
        Route::get('export/{format}', 'Report\Report22Controller@export')->name('report22-print');
    });

    Route::group(['prefix' => 'report23'], function () {
        Route::get('filter', 'Report\Report23Controller@filter')->name('report23-filter');
        Route::get('view', 'Report\Report23Controller@view')->name('report23-view');
        Route::get('export/{format}', 'Report\Report23Controller@export')->name('report23-print');
    });

    Route::group(['prefix' => 'report24'], function () {
        Route::get('view', 'Report\Report24Controller@view')->name('report24-view');
        Route::get('{id}/edit', 'Report\Report24Controller@edit')->name('report24-edit');
        Route::get('update', 'Report\Report24Controller@update')->name('report24-update');
        Route::get('export/{format}', 'Report\Report24Controller@export')->name('report24-print');
    });

    Route::group(['prefix' => 'report25'], function () {
        Route::get('filter', 'Report\Report25Controller@filter')->name('report25-filter');
        Route::get('view', 'Report\Report25Controller@view')->name('report25-view');
        Route::get('{state_id}/stop_notice', 'Report\Report25Controller@list')->name('report25-list');
        Route::get('data', 'Report\Report25Controller@data')->name('report25-data');
        Route::get('export/{format}', 'Report\Report25Controller@export')->name('report25-print');
    });

    Route::group(['prefix' => 'report26'], function () {
        Route::get('view', 'Report\Report26Controller@view')->name('report26-view');
        Route::get('export/{format}', 'Report\Report26Controller@export')->name('report26-print');
    });

    Route::group(['prefix' => 'report27'], function () {
        Route::get('filter', 'Report\Report27Controller@filter')->name('report25-filter');
        Route::get('view', 'Report\Report27Controller@view')->name('report27-view');
        Route::get('export/{format}', 'Report\Report27Controller@export')->name('report27-print');
    });

    Route::get('report28', 'Report\Report28Controller@index')->name('report28.index');

//    Route::group(['prefix' => 'report28'], function () {
//        Route::get('view', 'Report\Report28Controller@view')->name('report28-view');
//        Route::get('export/{format}', 'Report\Report28Controller@export')->name('report28-print');
//    });

    Route::group(['prefix' => 'report29'], function () {
        Route::get('view', 'Report\Report29Controller@view')->name('report29-view');
        Route::get('export/{format}', 'Report\Report29Controller@export')->name('report29-print');
    });

    Route::group(['prefix' => 'report30'], function () {
        Route::get('view', 'Report\Report30Controller@view')->name('report30-view');
        Route::get('filter', 'Report\Report30Controller@filter')->name('report30-filter');
        Route::get('export/{format}', 'Report\Report30Controller@export')->name('report30-print');
    });

    // Route::group(['prefix' => 'report32'], function () {
    // 	Route::get('filter', 'Report\Report32Controller@filter')->name('report32-filter');
    // 	Route::get('view', 'Report\Report32Controller@view')->name('report32-view');
    // 	Route::get('export/{format}', 'Report\Report32Controller@export')->name('report32-print');
    // });

    Route::group(['prefix' => 'report33'], function () {
        Route::get('', 'Report\Report33Controller@index')->name('report33.index');
    });

    Route::group(['prefix' => 'report34'], function () {
        Route::get('', 'Report\Report34Controller@index')->name('report34.index');
    });


    // Route::get('report34', 'Report\Report34Controller@index')->name('report34.index');


});

Route::group(['prefix' => 'payment'], function () {

    Route::get('review', 'PaymentController@review')->name('payment-review');

});

Route::group(['prefix' => 'listing'], function () {

    Route::get('hearing', 'Listing\HearingListController@index')->name('listing.hearing');
    Route::get('hearing/date/{hearing_date}', 'Listing\HearingListController@list_hearing_date')->name('listing.hearing_date');
    Route::get('hearing/date/{hearing_date}/{hearing_time}', 'Listing\HearingListController@list_hearing_date')->name('listing.hearing_date');

    Route::any('hearing_attendance', 'Listing\HearingAttendanceController@index')->name('listing.hearing.attendance');

    Route::get('attendance', 'Listing\AttendanceController@index')->name('listing.attendance');
    Route::group(['prefix' => 'attendance'], function () {
        Route::get('{id}/process', 'Listing\AttendanceController@process')->name('listing.attendance.process');
        Route::post('{id}/save', 'Listing\AttendanceController@save')->name('listing.attendance.save');
        Route::post('{id}/print', 'Listing\AttendanceController@print')->name('listing.attendance.print');
        Route::get('{id}/set', 'Listing\AttendanceController@set')->name('listing.attendance.set');
    });

    Route::get('visitor', 'Others\VisitorController@index')->name('listing.visitor');
    Route::group(['prefix' => 'visitor'], function () {
        Route::get('create', 'Others\VisitorController@create')->name('listing.visitor.create');
        Route::get('{id}/view', 'Others\VisitorController@view')->name('listing.visitor.view');
        Route::get('{id}/edit', 'Others\VisitorController@edit')->name('listing.visitor.edit');
        Route::delete('{id}/delete', 'Others\VisitorController@destroyVisitor')->name('listing.visitor.delete');
        Route::post('update', 'Others\VisitorController@updateVisitor')->name('listing.visitor.update');
        Route::post('store', 'Others\VisitorController@store')->name('listing.visitor.store');
    });
});

Route::group(['prefix' => 'others'], function () {

    Route::get('claimsubmission', 'Others\ClaimSubmissionRecordController@index')->name('others.claimsubmission');
    Route::group(['prefix' => 'claimsubmission'], function () {
        Route::get('create/pym/{form4_id}', 'Others\ClaimSubmissionRecordController@create_pym')->name('others.claimsubmission.create.pym');
        Route::get('{id}/view', 'Others\ClaimSubmissionRecordController@view')->name('others.claimsubmission.view');
        Route::get('create/p/{form4_id}', 'Others\ClaimSubmissionRecordController@create_p')->name('others.claimsubmission.create.p');
        Route::get('{id}/edit/p', 'Others\ClaimSubmissionRecordController@edit_p')->name('others.claimsubmission.edit.p');
        Route::get('{id}/edit/pym', 'Others\ClaimSubmissionRecordController@edit_pym')->name('others.claimsubmission.edit.pym');
        Route::delete('{id}/delete', 'Others\ClaimSubmissionRecordController@delete')->name('others.claimsubmission.delete');
        Route::post('update', 'Others\ClaimSubmissionRecordController@update')->name('others.claimsubmission.update');
        Route::post('store', 'Others\ClaimSubmissionRecordController@store')->name('others.claimsubmission.store');
    });
});

Route::group(['prefix' => 'form11'], function () {

    Route::get('create/{form4_id}', 'ClaimCase\Form11Controller@create')->name('form11-create');
    Route::get('add/{form4_id}', 'ClaimCase\Form11Controller@add')->name('form11-add');
    Route::get('{user_witness_id}/edit', 'ClaimCase\Form11Controller@edit')->name('form11-edit');
    Route::delete('{user_witness_id}/delete', 'ClaimCase\Form11Controller@delete')->name('form11-delete');

    Route::any('{form11_id}/view', 'ClaimCase\Form11Controller@view')->name('form11-view');
    Route::any('{form11_id}/export/{format}', 'ClaimCase\Form11Controller@export')->name('form11-export');

    Route::get('find', 'ClaimCase\Form11Controller@find')->name('form11-find');
    Route::post('store', 'ClaimCase\Form11Controller@store')->name('form11-store');
    Route::post('update', 'ClaimCase\Form11Controller@update')->name('form11-update');
    Route::post('new', 'ClaimCase\Form11Controller@new')->name('form11-new');


});

// Route::group(['prefix' => 'hearing_status'], function () {
// 	Route::get('list', 'Hearing\HearingStatusController@list')->name('hearing-status-list');
// 	Route::get('create', 'Hearing\HearingStatusController@create')->name('hearing-status-create');

// 	Route::get('set_status', 'ClaimCase\Form4Controller@listStatus')->name('form4-status-list');
// 	Route::group(['prefix' => 'set_status'], function () {
// 		Route::get('{form4_id}/status/set', 'ClaimCase\Form4Controller@setStatus')->name('form4-status-set');
// 		Route::post('status/store', 'ClaimCase\Form4Controller@storeStatus')->name('form4-status-store');
// 	});
// });

Route::group(['prefix' => 'hearing'], function () {
    Route::group(['prefix' => 'date'], function () {
        Route::get('update', 'Hearing\HearingClaimCaseController@listUpdate')->name('hearing-update-list');
        Route::post('update/submit', 'Hearing\HearingClaimCaseController@submitUpdate')->name('hearing-update-submit');

        Route::get('reset', 'Hearing\HearingClaimCaseController@listUpdate')->name('hearing-reset-list');
        Route::post('reset/submit', 'Hearing\HearingClaimCaseController@submitReset')->name('hearing-reset-submit');
    });

    Route::group(['prefix' => 'status'], function () {
        Route::get('transfer', 'ClaimCase\Form4Controller@transferList')->name('form4-transfer-list');
        Route::get('list', 'ClaimCase\Form4Controller@listStatus')->name('form4-status-list');
        Route::get('{form4_id}/set', 'ClaimCase\Form4Controller@setStatus')->name('form4-status-set');
        Route::post('store', 'ClaimCase\Form4Controller@storeStatus')->name('form4-status-store');

        Route::group(['prefix' => 'update'], function () {
            Route::get('list', 'ClaimCase\Form4Controller@updateListStatus')->name('form4-status-update-list');
            Route::get('{form4_id}/view', 'ClaimCase\Form4Controller@updateViewStatus')->name('form4-status-update-view');
            Route::get('modal/{form4_id}', 'ClaimCase\Form4Controller@updateModalStatus')->name('form4-status-update-modal');
            Route::post('{form4_id}/edit', 'ClaimCase\Form4Controller@setStatus')->name('form4-status-update-edit');
            Route::post('submit', 'ClaimCase\Form4Controller@updateSubmitStatus')->name('form4-status-update-submit');
        });
    });
});

Route::get('postcode/detail', function (Illuminate\Http\Request $request) {
    $data = \App\MasterModel\MasterPostcode::where('name', ($request->has('p') ? $request->p : null))->first();

    if($data){
        return Illuminate\Support\Facades\Response::json([
            'postcode' => $data->toArray()
        ]);
    }

    return Illuminate\Support\Facades\Response::json([
        'postcode' => []
    ]);
})->name('postcode.detail');

