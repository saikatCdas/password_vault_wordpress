<?php

namespace FluentPlugin\App\Models;

use FluentPlugin\App\Models\Model;
use FluentPlugin\App\Models\User;


class Vault extends Model
{   
    protected $table = 'vaults';


    // Relation with User Class
    // public function user (){
    //     return $this->belongsTo(User::class);
    // }
}
