<?php

namespace App\PortalModel;

use Illuminate\Database\Eloquent\Model;

class PortalAnnouncement extends Model
{
    //
    protected $table = 'portal_announcement';
    protected $primaryKey = 'portal_announcement_id';

    protected $fillable = [
        'title_en',
        'title_my',
        'description_en',
        'description_my',
        'start_date',
        'end_date',
        'created_by_user_id'
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }
}
