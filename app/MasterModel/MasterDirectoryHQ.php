<?php

namespace App\MasterModel;

use Illuminate\Database\Eloquent\Model;

class MasterDirectoryHQ extends Model
{
	protected $table = 'master_directory_hq';
    protected $primaryKey = 'directory_hq_id';

    protected $fillable = [
    	'directory_hq_id',
    	'directory_hq_division',
    	'directory_hq_name',
    	'directory_hq_designation',
    	'directory_hq_ext',
    	'directory_hq_email',
    	'directory_hq_sort',
    ];

    protected $division = [
        'Chairman Office', 
        'Deputy Chairman Office',
        'Assistant Chairman Office',
        'Secretary',
        'Administration And Finance Division',
        'Registration Division',
        'Management Hearing And Advice Division'
    ];

    protected $designation = [
        'Pengerusi', 
        'Pem. Setiausaha Pejabat',
        'Timbalan Pengerusi',
        'Peguam Kanan Persekutuan',
        'Setiausaha',
        'Pen. Peg. Tadbir',
        'Pem. Tadbir (Kew)',
        'Pem. Tadbir (P/O)',
        'Pem. Penguatkuasa',
        'Pen. Peg. Undang-Undang',
        'Pembantu Am Pejabat',
        'Pemandu Kenderaan'
    ];

    public function getDivisions()
    {
        return $this->division;
    }

        public function getDesignations()
    {
        return $this->designation;
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
}
