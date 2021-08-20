<?php

namespace App\SupportModel;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Announcement extends Model
{
    //
    protected $table = 'announcement';
    protected $primaryKey = 'announcement_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'announcement_id',
        'title_en',
        'title_my',
        'description_en',
        'description_my',
        'announcement_type_id',
        'start_date',
        'end_date',
        'created_by_user_id'
    ];

    public function created_by() {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function creator() {
        return $this->belongsTo(User::class, 'created_by_user_id', 'user_id');
    }

    public function targets() {
        return $this->hasMany('App\SupportModel\AnnouncementTarget', 'announcement_id');
    }

    public function type() {
        return $this->belongsTo('App\MasterModel\MasterAnnouncementType', 'announcement_type_id', 'announcement_type_id');
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getStatusAttribute() {

        $end = Carbon::createFromFormat('Y-m-d', $this->end_date);

        if( $end->diffInDays(Carbon::now(), false) > 0 )
            return 2; // Inactive
        else
            return 1;
    }



}
