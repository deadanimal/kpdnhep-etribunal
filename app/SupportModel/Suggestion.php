<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    //
    protected $table = 'suggestion';
    protected $primaryKey = 'suggestion_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'suggestion_id',
        'subject',
        'suggestion',
        'response',
        'responded_by_user_id',
        'created_by_user_id',
        'created_at',
        'updated_at',
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function responded_by() {
        return $this->belongsTo('App\User', 'responded_by_user_id', 'user_id');
    }


}
