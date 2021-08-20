<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class UserExtra extends Model
{
    //
    protected $table = 'user_extra';
    protected $primaryKey = 'user_extra_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'identification_no',
        'nationality_country_id',
        'relationship_id'
    ];

    public function nationality() {
        return $this->belongsTo('App\MasterModel\MasterCountry', 'nationality_country_id');
    }

    public function relationship() {
        return $this->belongsTo('App\MasterModel\MasterRelationship', 'relationship_id');
    }

}
