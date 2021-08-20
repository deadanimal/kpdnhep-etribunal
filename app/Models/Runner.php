<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class Ticket
 * @package App\Models
 * @version September 4, 2018, 2:27 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection roleHasPermissions
 * @property \Illuminate\Database\Eloquent\Collection users
 * @property string title
 * @property string description
 * @property integer ticket_status_id
 */
class Runner extends Model
{
    public $table = 'runners';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'rule_1',
        'rule_2',
        'rule_3',
        'rule_4',
        'rule_5',
        'runner'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'rule_1' => 'string',
        'rule_2' => 'string',
        'rule_3' => 'string',
        'rule_4' => 'string',
        'rule_5' => 'string',
        'runner' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}

