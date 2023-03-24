<?php

namespace FluentPlugin\App\Models;

use FluentPlugin\App\Models\Model;

class Folder extends Model
{   
    protected $table = 'fp_password_folders';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vaults(){
        return $this->hasMany(Vault::class);
    }
}
