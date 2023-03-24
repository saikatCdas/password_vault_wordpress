<?php

namespace FluentPlugin\App\Models;

use FluentPlugin\App\Models\Model;
use FluentPlugin\App\Models\Vault;


class Folder extends Model
{   
    protected $table = 'fp_password_folders';


    public static function createFolder($folderName){
        unset($folderName['query_timestamp']);
        
        // Gettting the currrent user id
        $current_user_id = apply_filters( 'determine_current_user', false );
      
        $user_id = wp_set_current_user( $current_user_id )->ID;


        $folderName['user_id'] = $user_id;

        Folder::create($folderName);

        return Folder::where('user_id', $user_id)->get();
    }

    public static function changeFolder ($data) {

        if($data['folderId'] ){
            $folderId = Folder::whereId($data['folderId'])->exists();
        }
        
        // Changing Folder
        $itemIds = $data['itemsId'];
        foreach($itemIds as $id){
            $item = Vault::whereId($id)->first();
            $item['folder_id'] = $folderId ? $data['folderId'] : null;
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
