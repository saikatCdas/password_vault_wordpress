<?php

namespace FluentPlugin\App\Models;

use FluentPlugin\App\Models\Model;
use FluentPlugin\App\Models\Vault;


class Folder extends Model
{   
    protected $table = 'fp_password_folders';


    public static function changeFolder ($data) {
            // Changing Folder
            $itemIds = $data['itemsId'];
            foreach($itemIds as $id){
                $item = Vault::whereId($id)->first();
                $item['folder_id'] = $data['folderId'];
                // return $item['folder_id'];
                $item->save();
            }

            return 'success';
    }



    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vaults(){
        return $this->hasMany(Vault::class);
    }
}
