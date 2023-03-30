<?php

namespace FluentPlugin\App\Models;

use FluentPlugin\App\Models\Model;
use FluentPlugin\App\Models\User;
use FluentPlugin\App\Services\FolderTools;
use FluentPlugin\App\Services\VaultTools;



class Vault extends Model
{   
    protected $table = 'fp_password_vaults';


    /**
     * Getting in information by category or folder
     * 
     * @return void 
     */
    public static function getInfo($data){
        // decoding data
        $decodedData = json_decode(urldecode($data), true);
        // return $decodedData;

        //  getting current user id
        $vaults = new Vault();
        $current_user_id = $vaults->authUserId();

        // return $type;
        
        // exploding the string
        $parts = explode("=", $decodedData);

        //checking is the request for category or folder
        if($parts[0] === "category"){
            if($parts[1] === 'all'){
                $vaultItems = Vault::where('user_id', $current_user_id)->paginate(20);
            } else{
                $vaultItems = Vault::where('user_id', $current_user_id)->where('category', ucfirst($parts[1]))->paginate(20);
            }
        }else{
            if($parts[1] === "null"){
                $vaultItems = Vault::where('user_id', $current_user_id)->where('folder_id', null)->paginate(20);
            }else{
                $vaultItems = Vault::where('user_id', $current_user_id)->where('folder_id', $parts[1])->paginate(20);
            }
        }

        return $vaultItems;
    }


    /**
     * create a new vault item
     * 
     * @return void
     */
    public static function createNewItem($vaultIntiData){
        // if request has folder
        $vaultIntiData['folder_id'] = (new FolderTools())->getFolderId($vaultIntiData['folder']);

        // clearing the folder name
        unset($vaultIntiData['folder']);

        $vaultIntiData['user_id'] = (new Vault())->authUserId();

        // Create a vault
        $vaultData = Vault::create($vaultIntiData);

        return $vaultData;
    }



    /**
     * update existing item in vault table
     * 
     * @return void
     */
    public static function updateVaultItem ($data){
        // given an array to check is if given data has more key than table item
        $arrayValue = array_flip(array('user_id','folder_id', 'category', 'email', 'name', 'user_name', 'password', 'url', 'card_holder_name', 'card_number', 'card_expiration_date', 'card_security_code', 'notes'));

        $credential = array_intersect_key($data, $arrayValue);

        // if request has folder
        $credential['folder_id'] = (new FolderTools())->getFolderId($data['folder']);

        $credential['user_id'] = (new Vault())->authUserId();

        // update vault
        Vault::whereId($data['id'])->update($credential);
        return true;
    }


    /**
     * Deleteing existing valut items
     * 
     * @return void
     */
    public static function deleteVaultItem ($itemId){
         // exploding and converting into an array
         $itemIds = explode(",", $itemId);

         // looping for multiple value
         foreach($itemIds as $id){
             $vaultData = Vault::whereId($id)->first();

             // Checking user has permission to delete
             if((new Vault())->authUserId() == $vaultData->user_id){
                 $vaultData->delete();
             }
         }
         return true;
    }


    /**
     * Getting Item By Id
     * 
     * @return void
     */
    public static function getVaultItemById ($itemId){
         // Get Item by Id
         $item = Vault::whereId($itemId)->first();
            
         // Get Folder Name
         $folder = Folder::whereId($item['folder_id'])->first();
         $item['folder'] = $folder['name'] ?? null;


         if($item->user_id == (new Vault())->authUserId() ){
             return $item;
         }
         return false;
    }


    /**
     * Search items in vault by key
     * 
     * @return void
     */
    public static function searchItems ($key){
        $result = Vault::latest()->where('user_id',(new Vault())->authUserId())
        ->where('name', 'like', '%' . $key . '%')
        ->orWhere('email', 'like', '%' . $key . '%')
        ->orWhere('category', 'like', '%' . $key . '%')
        ->orWhere('user_name', 'like', '%' . $key . '%')
        ->orWhere('url', 'like', '%' . $key . '%')
        ->orWhere('notes', 'like', '%' . $key . '%')->paginate(20);
        return $result;
    }


    /**
     * returning an array of user vault items
     * 
     * @return void
     */
    public static function exportVaultItems (){
        return Vault::where('user_id', (new Vault())->authUserId() )->get();
    }


    /**
     * Imort data into vault from csv file
     * 
     * @return void
     */
    public static function importVaultItems (){
        if (isset($_FILES['import_file'])) {
            $file_name = $_FILES['import_file']['name'];
            $file_size = $_FILES['import_file']['size'];
            $file_tmp = $_FILES['import_file']['tmp_name'];
            $file_type = $_FILES['import_file']['type'];

            $csvData = file_get_contents($file_tmp);
            $rows = array_map('str_getcsv', explode("\n", $csvData));
                            
            foreach ($rows as $index => $row)
            {
                if($index == 0 || (count($row) <= 1)) {
                    continue;
                }
                $combineArray =  array_combine($rows[0], $row);
                $arrayValue = array_flip(array('user_id','folder_id', 'category', 'email', 'name', 'user_name', 'password', 'url', 'card_holder_name', 'card_number', 'card_expiration_date', 'card_security_code', 'notes'));

                $credential = array_intersect_key($combineArray, $arrayValue);


                $credentialValidation = (new VaultTools())->importVaultDataValidation($credential);

                if(!$credentialValidation){
                    return false;
                }

                if(isset($credential['folder_name'])){
                    // if request has folder
                    $credential['folder_id'] = (new Vault())->getFolderId($credential['folder_name']);
                }elseif (isset($credential['folder_id'])) {
                    // if request has folder_id
                    $folderId = Folder::whereId($credential['folder_id'])->exists();
                    $credential['folder_id'] = $folderId ? $credential['folder_id'] : null;
                }
                else{
                    $credential['folder_id'] = null;
                }

                $credential['user_id'] = (new Vault())->authUserId();
                Vault::create($credential);
            }
            return 'success';
        } 
    }

    // returning current user id
    private function authUserId (){
        $user_id = apply_filters( 'determine_current_user', false );
  
        return wp_set_current_user( $user_id )->ID;
    }
}
