<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWitness extends Model
{
    //
    protected $primaryKey = 'user_witness_id';
    protected $table = 'user_witness';
    protected $fillable = [
        'name', 
        'identification_no', 
        'nationality_country_id',
        'user_public_type_id',
        'address',
        'witness_on_behalf',
        'document_desc',
        'form11_id',
        'psu_user_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['type'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getTypeAttribute() {

        if($this->user_public_type_id == 2) {
            return 3;
        }
        else if($this->nationality_country_id == 129) {
            return 1;
        }
        else {
            return 2;
        }
    }

    public function form11 () {
        return $this->belongsTo('App\CaseModel\Form11', 'form11_id');
    }

     public function psu() {
        return $this->belongsTo('App\User', 'psu_user_id', 'user_id');
    }

    public function user_public_type() {
        return $this->belongsTo('App\MasterModel\MasterUserPublicType', 'user_public_type_id');
    }
}
