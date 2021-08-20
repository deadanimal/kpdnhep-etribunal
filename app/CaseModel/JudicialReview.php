<?php

namespace App\CaseModel;

use Illuminate\Database\Eloquent\Model;

class JudicialReview extends Model
{
    //
    protected $table = 'judicial_review';
    protected $primaryKey = 'judicial_review_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'form4_id',
        'applied_by',
        'application_no',
        'court_id',
        'court_applied_at',
        'court_details',
        'is_doc_proceedingnotes',
        'is_doc_decisionreason',
        'psu_notes',
        'form_status_id',
        'created_by_user_id'
    ];

    public function form4()
    {
        return $this->belongsTo('App\CaseModel\Form4', 'form4_id', 'form4_id');
    }

    public function status()
    {
        return $this->belongsTo('App\MasterModel\MasterFormStatus', 'form_status_id', 'form_status_id');
    }

    public function created_by()
    {
        return $this->belongsTo('App\User', 'created_by_user_id', 'user_id');
    }

    public function court()
    {
        return $this->belongsTo('App\MasterModel\MasterCourt', 'court_id', 'court_id');
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['by_user', 'state_id'];

    /**
     * Get the custom attribute.
     *
     * @return boolean
     */
    public function getStateIdAttribute()
    {
        return $this->form4->case->state_id;
    }

    public function getByUserAttribute()
    {
        switch($this->applied_by){
            case 1:
                return __('new.ttpm_parties');
                break;
            case 2:
                return $this->form4->case->claimant->name;
                break;
            case 3:
                return $this->form4->case->opponent->name;
                break;
            default:
                return null;
                break;
        }
    }
}
