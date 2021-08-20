<?php

namespace App\ViewModel;

use Illuminate\Database\Eloquent\Model;

class ViewForm4Before extends Model
{
    //
    protected $table = 'view_form4_before';

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'previous_form4_id', 'form4_id');
    }
}