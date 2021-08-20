<?php

namespace App;

use App\SupportModel\UserClaimCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Lab404\Impersonate\Models\Impersonate;
use Lab404\Impersonate\Services\ImpersonateManager;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use Impersonate;

    protected $primaryKey = 'user_id';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'user_type_id',
        'language_id',
        'phone_office',
        'phone_fax',
        'email',
        'user_status_id',
		'temp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
    public function getTypeAttribute()
    {
        if ($this->user_type_id != 3) {
            return 0;
        } else if ($this->public_data->user_public_type_id == 2) {
            return 3;
        } else if ($this->public_data->individual->nationality_country_id == 129) {
            return 1;
        } else {
            return 2;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    public function public_data()
    {
        return $this->hasOne(UserPublic::class, 'user_id', 'user_id');
    }

    public function user_status()
    {
        return $this->belongsTo('App\MasterModel\MasterUserStatus', 'user_status_id');
    }

    public function language()
    {
        return $this->belongsTo('App\MasterModel\MasterLanguage', 'language_id');
    }

    public function ttpm_data()
    {
        return $this->hasOne('App\UserTTPM', 'user_id', 'user_id');
    }

    public function roleuser()
    {
        return $this->hasMany(RoleUser::class, 'user_id', 'user_id');
    }

    public function claims()
    {
        return $this->hasMany('App\CaseModel\ClaimCase', 'claimant_user_id', 'user_id');
    }

    public function againsts()
    {
        return $this->hasMany('App\CaseModel\ClaimCase', 'opponent_user_id', 'user_id');
    }

    public function userClaimCase()
    {
        return $this->hasMany(UserClaimCase::class, 'user_id', 'user_id');
    }

    

    // impersonate usage
    /**
     * Impersonate the given user.
     *
     * @param   Model $user
     * @return  bool
     */
    public function impersonate(Model $user, $model_id = 'user_id')
    {
        return app(ImpersonateManager::class)->take($this, $user);
    }

}
