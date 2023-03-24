<?php

namespace FluentPlugin\App\Http\Controllers;

use FluentPlugin\Framework\Request\Request;
use FluentPlugin\App\Models\Vault;
use FluentPlugin\App\Models\Folder;
use FluentPlugin\App\Http\Requests\VaultRequest;
use FluentPlugin\App\Models\User;
use Exception;



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
        try{
            return $this->response(Vault::getInfo($type)) ; 
        } catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }

    /**
     * create a item in vault
     */
    public function store( VaultRequest $request)
    {
        try{
            // Validate form data
            return $this->response(Vault::createNewItem($request->sanitize()));

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
            // Validate form data
            $vaultIntiData = $request->sanitize();

            return $this->response(Vault::updateVaultItem($vaultIntiData));

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
            return $this->response(Vault::deleteVaultItem($itemId));
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
            return $this->response(Vault::getVaultItemById($id));
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
            $data = $request->all();
            // Checking Folder Exist
            if($data['folderId'] !== null){
                $data->validate([
                    'folderId' => 'exists:folders,id'
                ], []);
            };
            
            return $this->response(Folder::changeFolder($data) );

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
        try {
            return $this->response(Vault::searchItems($searchInp));
        } catch (Exception $e) {
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }

    /**
     * Export csv file from Database
     *
     * @return void
     */

     public function export(Request $request)
     {
         try{
            return $this->response(Vault::exportVaultItems());
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
            return $this->response(Vault::importVaultItems());
        }catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }

    

 
}
