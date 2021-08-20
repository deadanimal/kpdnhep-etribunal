<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterDurationTerm extends Model
{
    protected $table = 'master_duration_term';
    protected $primaryKey = 'duration_term_id';

    protected $fillable = [
    	'term_en',
        'term_my'
    ];

}
