<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    //
    protected $table = 'journal';
    protected $primaryKey = 'journal_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'journal_id',
        'journal_desc',
        'claim_classification_id',
        'is_status'
    ];

    public function classification() {
        return $this->belongsTo('App\MasterModel\MasterClaimClassification', 'claim_classification_id', 'claim_classification_id');
    }


}
