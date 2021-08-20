<?php

namespace App\PortalModel;

use Illuminate\Database\Eloquent\Model;

class Portal extends Model
{
    //
    protected $table = 'portal';
    protected $primaryKey = 'portal_id';

    protected $fillable = [
        'title_en',
        'title_my',
        'subtitle_en',
        'subtitle_my',
        'content_en',
        'content_my',
        'url',
        'created_by_user_id'
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }
}
