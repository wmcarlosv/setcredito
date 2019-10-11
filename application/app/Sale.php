<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';

    protected $fillable = ['user_from','user_to','credits','is_variation','variation_type','variation'];


    public function userf(){
    	return $this->belongsTo('App\User','user_from','id');
    }

    public function usert(){
    	return $this->belongsTo('App\User','user_to','id');
    }
}
