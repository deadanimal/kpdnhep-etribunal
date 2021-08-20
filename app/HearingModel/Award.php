<?php

namespace App\HearingModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Award extends Model
{
    use SoftDeletes;

    protected $table = 'award';
    protected $primaryKey = 'award_id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'award_type',
        'f10_type_id',
        'award_value',
        'award_cost_value',
        'award_obey_duration',
        'award_term_id',
        'award_description',
        'award_description_en',
        'award_date',
        'award_matured_date',
        'is_display_representative',
    ];

    public function f10() {
        return $this->belongsTo('App\MasterModel\MasterF10Type', 'f10_type_id');
    }

    public function term() {
        return $this->belongsTo('App\MasterModel\MasterDurationTerm', 'award_term_id', 'duration_term_id');
    }

}
