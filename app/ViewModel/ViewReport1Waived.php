<?php

namespace App\ViewModel;

use Illuminate\Database\Eloquent\Model;

class ViewReport1Waived extends Model
{
    //
    protected $table = 'view_report1_waived';

    public function form4() {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id', 'form4_id');
    }
}
