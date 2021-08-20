<?php

namespace App\SupportModel;

use Illuminate\Database\Eloquent\Model;

class AnnouncementTarget extends Model
{
    //
    protected $table = 'announcement_target';
    protected $primaryKey = 'announcement_target';
    public $timestamps = false;

    protected $fillable = [
        'announcement_id',
    	'role_id',
    ];

    public function role() {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function announcement() {
        return $this->belongsTo('App\SupportModel\Announcement', 'announcement_id', 'announcement_id');
    }

}
