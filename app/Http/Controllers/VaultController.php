<?php

namespace FluentPlugin\App\Http\Controllers;

use FluentPlugin\Framework\Request\Request;
use FluentPlugin\App\Models\Vault;
use FluentPlugin\App\Models\Folder;
use FluentPlugin\App\Http\Requests\VaultRequest;
use FluentPlugin\App\Models\User;
use Exception;
use FluentPlugin\Framework\Response\Response;

class VaultController extends Controller
{

     /**
     * get items from vault
     *
     * @param [type] $type
     * @return void
     */
    public function getVaultItems( $type)
    {

        // $user = User::get();
        // //$users = $users->toArray();

        // var_dump($user->toArray());
        // exit;
        try{
            // decoding data
            $decodedData = json_decode(urldecode($type), true);
            // return $decodedData;

            $user_id = apply_filters( 'determine_current_user', false );
      
            $current_user_id = wp_set_current_user( $user_id )->ID;

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

            return $this->response($vaultItems);

        } catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }

    
    }

    public function store( VaultRequest $request)
    {

        $user_id = apply_filters( 'determine_current_user', false );
      
        $current_user_id = wp_set_current_user( $user_id )->ID;
        try{

            // Validate form data
            $vaultIntiData = $request->sanitize();

            $arrayValue = array_flip(array('user_id','folder_id', 'category', 'email', 'name', 'user_name', 'password', 'url', 'card_holder_name', 'card_number', 'card_expiration_date', 'card_security_code', 'notes'));

            $credential = array_intersect_key($vaultIntiData, $arrayValue);
            // if request has folder
            $vaultIntiData['folder_id'] = $this->getFolderId($credential['folder']);

            // clearing the folder name
            unset($credential['folder']);

            $credential['user_id'] = $current_user_id;

            // Create a vault
            $vaultData = Vault::create($credential);

            return $vaultData;

        } catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
       
    }

     /**
     * update Vault item
     *
     * @param VaultStoreRequest $request
     * @return void
     */
    public function update(VaultRequest $request){
        
        try{
            $user_id = apply_filters( 'determine_current_user', false );
      
            $current_user_id = wp_set_current_user( $user_id )->ID;

            // Validate form data
            $vaultIntiData = $request->sanitize();

            $arrayValue = array_flip(array('user_id','folder_id', 'category', 'email', 'name', 'user_name', 'password', 'url', 'card_holder_name', 'card_number', 'card_expiration_date', 'card_security_code', 'notes'));

            $credential = array_intersect_key($vaultIntiData, $arrayValue);

            // if request has folder
            $credential['folder_id'] = $this->getFolderId($vaultIntiData['folder']);

            $credential['user_id'] = $current_user_id;

            // update vault
            Vault::whereId($vaultIntiData['id'])->update($credential);

            return $this->response('success');

        } catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }

     /**
     * delete Item or Items
     *
     * @param [type] $itemId
     * @return void
     */
    public function destroy($itemId)
    {
        try{
            $user_id = apply_filters( 'determine_current_user', false );
      
            $current_user_id = wp_set_current_user( $user_id )->ID;

            // exploding and converting into an array
            $itemIds = explode(",", $itemId);

            // looping for multiple value
            foreach($itemIds as $id){
                $vaultData = Vault::whereId($id)->first();

                // Checking user has permission to delete
                if($current_user_id == $vaultData->user_id){
                    $vaultData->delete();
                }
            }
            return 'success';
        
        } catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }


    /**
     * get item from vault by id
     *
     * @param [type] $id
     * @return void
     */
    public function getItemById($id){
        

        try{

            $user_id = apply_filters( 'determine_current_user', false );
      
            $current_user_id = wp_set_current_user( $user_id )->ID;

            // Get Item by Id
            $item = Vault::whereId($id)->first();
            

            // Get Folder Name
            $folder = Folder::whereId($item['folder_id'])->first();
            $item['folder'] = $folder['name'] ?? null;


            if($item->user_id == $current_user_id){
                return $this->response($item);
            }

            // return abort(403,'Unauthorized Action');

        } catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }


    // Get Folder Id
    private function getFolderId($name){
        // if request has folder
        try{
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
        } catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }

    /**
     * move Folder for Selected Items
     *
     * @param Request $request
     * @return void
     */
    public function moveFolder(Request $request){
        try{

            $request_data = $request->all();
            // Checking Folder Exist
            if($request_data['folderId'] !== null){
                $request->validate([
                    'folderId' => 'exists:folders,id'
                ], []);
            }

            // Changing Folder
            $itemIds = $request_data['itemsId'];
            foreach($itemIds as $id){
                $item = Vault::whereId($id)->first();
                $item['folder_id'] = $request_data['folderId'];
                // return $item['folder_id'];
                $item->save();
            }

            return 'success';

        }catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }

    /**
     * Search into vault
     *
     * @param String $searchInp
     * @return void
     */
    public function search( $searchInp)
    {
        // return $searchInp;
        $user_id = apply_filters( 'determine_current_user', false );
      
        $current_user_id = wp_set_current_user( $user_id )->ID;

        $result = Vault::latest()->where('user_id',$current_user_id)
                    ->where('name', 'like', '%' . $searchInp . '%')
                    ->orWhere('email', 'like', '%' . $searchInp . '%')
                    ->orWhere('category', 'like', '%' . $searchInp . '%')
                    ->orWhere('user_name', 'like', '%' . $searchInp . '%')
                    ->orWhere('url', 'like', '%' . $searchInp . '%')
                    ->orWhere('notes', 'like', '%' . $searchInp . '%')->paginate(20);

        return $result;
    }

    /**
     * Export csv file from Database
     *
     * @return void
     */

     public function export(Request $request)
     {
         try{
            $user_id = apply_filters( 'determine_current_user', false );
      
            $current_user_id = wp_set_current_user( $user_id )->ID;

             $fileName = 'vaultItems.csv';
            $vaultItems = Vault::where('user_id', $current_user_id )->get();
            return $this->response($vaultItems);
         
        }catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
     }

    /**
     * import csv file
     *
     * @param Request $request
     * @return void
     */
    public function import(Request $request)
    {
        try{

            $user_id = apply_filters( 'determine_current_user', false );
      
            $current_user_id = wp_set_current_user( $user_id )->ID;

            // return $_FILES['csv_file'];
            if (!isset($_FILES['import_file'])) {
                throw new \Exception('No file found');
            }

            if (isset($_FILES['import_file'])) {
                $file_name = $_FILES['import_file']['name'];
                $file_size = $_FILES['import_file']['size'];
                $file_tmp = $_FILES['import_file']['tmp_name'];
                $file_type = $_FILES['import_file']['type'];
                // $file = $request['csv_file'];
                $csvData = file_get_contents($file_tmp);
                $rows = array_map('str_getcsv', explode("\n", $csvData));
                // return $rows;
                                
                foreach ($rows as $index => $row)
                {
                    if($index == 0 || (count($row) <= 1)) {
                        continue;
                    }
                    $combineArray =  array_combine($rows[0], $row);
                    $arrayValue = array_flip(array('user_id','folder_id', 'category', 'email', 'name', 'user_name', 'password', 'url', 'card_holder_name', 'card_number', 'card_expiration_date', 'card_security_code', 'notes'));

                    $credential = array_intersect_key($combineArray, $arrayValue);


                    $credentialValidation = $this->importVaultDataValidation($credential);

                    // return $credential;

                    if(!$credentialValidation){
                        return session_abort();
                    }

                    if(isset($credential['folder_name'])){
                        // if request has folder
                        $credential['folder_id'] = $this->getFolderId($credential['folder_name']);
                    }elseif (isset($credential['folder_id'])) {
                        // if request has folder_id
                        $folderId = Folder::whereId($credential['folder_id'])->exists();
                        $credential['folder_id'] = $folderId ? $credential['folder_id'] : null;
                    }
                    else{
                        $credential['folder_id'] = null;
                    }

                    $credential['user_id'] = $current_user_id;
                    Vault::create($credential);
                }
                // fclose($handle);
                return $this->response([
                    'message' => __('Success', 'fluent-support')
                ], 200);
            } 
       
        }catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }

    private function importVaultDataValidation($credential)
    {
        try{

            // checking category required and string
            if ((strlen($credential['category']) <= 0 ) || !(is_string($credential['category']))) {
            return false;
            }

            // checking name required and string
            elseif ((strlen($credential['name']) <= 0 ) || !(is_string($credential['name']))) {
            return false;
            }

            // checking user_name string
            elseif (!(is_string($credential['user_name']))) {
                return false;
            }

            // checking email string
            elseif (!(is_string($credential['email']))) {
                return false;
            }

            // checking password string
            elseif (!(is_string($credential['password']))) {
                return false;
            }

            // checking category url
            elseif (!(is_string($credential['url']))) {
                return false;
            }

            // checking category card_holder_name
            elseif (!(is_string($credential['card_holder_name']))) {
                return false;
            }

            // checking category card_number
            elseif (!(is_string($credential['card_number']))) {
                return false;
            }

            // checking category card_expiration_date
            elseif (!(is_string($credential['card_expiration_date']))) {
                return false;
            }

            // checking category card_security_code
            elseif (!(is_string($credential['card_security_code']))) {
                return false;
            }

            // checking category string
            elseif (!(is_string($credential['notes']))) {
                return false;
            } else return true;

        }catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }

 
}
