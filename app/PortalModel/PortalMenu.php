<?php

namespace App\PortalModel;

use Illuminate\Database\Eloquent\Model;

class PortalMenu extends Model
{
    //
    protected $table = 'portal_menu';
    protected $primaryKey = 'portal_menu_id';

    protected $fillable = [
        'menu_en',
        'menu_my',
        'url',
        'parent_menu_id',
        'priority'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['children'];

    public function getChildrenAttribute() {
        //return $this->hasMany('App\PortalModel\PortalMenu', 'parent_menu_id', 'portal_menu_id');
        return PortalMenu::where('parent_menu_id', $this->portal_menu_id)->orderBy('priority')->get();
    }

    public function parent() {
        return $this->belongsTo('App\PortalModel\PortalMenu', 'parent_menu_id', 'portal_menu_id');
    }
}
