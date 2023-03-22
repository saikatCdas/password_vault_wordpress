<?php

namespace FluentPlugin\App\Models;

use FluentPlugin\App\Models\Model;
use FluentPlugin\App\Models\Vault;

class User extends Model
{   
    protected $primaryKey = 'ID'; 
    protected $table = 'users';
    protected $with = ['vaults'];
   
    // build relationship with folder
    public function vaults(){
        return $this->hasMany(Vault::class);
    }
}
