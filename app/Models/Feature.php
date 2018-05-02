<?php

namespace App\Models;

use Baum\Node;

class Feature extends Node
{
    protected $table = 'features';
    protected $guarded = [];

    public function child(){
        return $this->hasMany(Feature::class,'parent_id','id')
                        ->Join('features_loc','features_loc.feature_id','=','features.id')
                        ->where('features_loc.lang','=','ru')
                        ->select('features.*','features_loc.name');
    }
}
