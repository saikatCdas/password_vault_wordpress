<?php

namespace FluentPlugin\App\Services;

use FluentPlugin\App\Models\Folder;
use FluentPlugin\Framework\Response\Response;


/**
 * Managing Folder Tools
 */
class FolderTools
{

    public function getFolderId($name){
        // if request has folder
        if($name){
            $exists = Folder::where('name', $name)->exists();
            if($exists){
                $folder = Folder::where('name', $name)->first();
            } else{
                if(is_string($name)){
                    $credential['name'] = $name;
                    $credential['user_id'] = get_current_user_id();
                    $folder = Folder::create($credential);
                }
            }
            // get the Folder id
            return $folder->id;

        }else{
            return null;
        }
    }

}