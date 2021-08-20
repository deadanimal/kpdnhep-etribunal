<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //
    protected $table = 'attachment';
    protected $primaryKey = 'attachment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form_no',
        'form_id',
        'attachment_name',
        'file_blob',
        'created_by_user_id'
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id');
    }

}
