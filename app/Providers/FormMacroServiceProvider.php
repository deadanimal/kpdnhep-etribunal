<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;
use App;

class FormMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        // Dropdown identification type (NRIC / PASSPORT)
        Form::macro('identity_type', function($name, $list = [], $selected = null, $options = []) {

            $list = $list + [
                        1 => __('form1.ic_no'), 
                        2 => __('form1.passport_no')
                    ];

            return Form::select($name, $list, $selected, $options);
        });


        // Dropdown country
        Form::macro('country', function($name, $list = [], $selected = null, $options = []) {

            $country = \App\MasterModel\MasterCountry::orderBy('country')->pluck('country','country_id')->all();

            $list = $list + $country;

            return Form::select($name, $list, $selected, $options);
        });


        // visitor reason dropdown
        Form::macro('visit_reason', function($name, $list = [], $selected = null, $options = []) {

            $reason = \App\MasterModel\MasterVisitorReason::where('is_active', 1)->orderBy('visitor_reason_id')->pluck('reason_'.App::getLocale(),'visitor_reason_id')->all();

            $list = $list + $reason;

            return Form::select($name, $list, $selected, $options);
        });
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
