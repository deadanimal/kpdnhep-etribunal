<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterClaimClassification extends Model
{
    protected $table = 'master_claim_classification';
    protected $primaryKey = 'claim_classification_id';

    protected $fillable = [
    	'classification_en',
        'classification_my',
    	'category_id',
    	'rcy_id',
    	'is_active'
    ];

    public function category() {
        return $this->belongsTo('App\MasterModel\MasterClaimCategory', 'category_id', 'claim_category_id');
    }
}
