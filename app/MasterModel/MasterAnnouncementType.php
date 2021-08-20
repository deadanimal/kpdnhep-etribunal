<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterAnnouncementType extends Model
{
    protected $table = 'master_announcement_type';
    protected $primaryKey = 'announcement_type_id';
    // Display Field from DB
    protected $fillable = [
    	'announcement_type_en',
    	'announcement_type_my'
    ];
}

