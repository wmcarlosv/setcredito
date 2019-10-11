<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderCredit extends Model
{
    protected $table = 'provider_credits';

    protected $fillable = ['provider','user_sale_point','credits'];
}
