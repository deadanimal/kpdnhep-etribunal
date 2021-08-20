<?php

namespace App\ViewModel;

use Illuminate\Database\Eloquent\Model;

class ViewReport2 extends Model
{
    //
    protected $table = 'view_report2';

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id', 'form4_id');
    }
}
