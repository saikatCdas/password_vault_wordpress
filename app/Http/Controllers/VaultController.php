<?php

namespace FluentPlugin\App\Http\Controllers;

use FluentPlugin\Framework\Request\Request;
use FluentPlugin\App\Models\Vault;
use FluentPlugin\App\Models\Folder;
use FluentPlugin\App\Http\Requests\VaultRequest;
use FluentPlugin\App\Models\User;
use Exception;
use FluentPlugin\Framework\Validator\Validator;
use LDAP\Result;

class VaultController extends Controller
{

     /**
     * get items from vault
     *
     * @param [type] $type
     * @return void
     */
    public function getVaultItems()
    {
        // $page_number = request()->query('page') ?: 1;
        // wp_send_json();
        try{
            wp_send_json(Vault::getInfo($_GET['encodedData'], $_GET['page'])) ; 
        } catch (\Exception $e){
            wp_send_json_error([
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
            wp_send_json(Vault::createNewItem($request->sanitize()));
        } catch (\Exception $e){
            wp_send_json_error([
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

            wp_send_json(Vault::updateVaultItem($vaultIntiData));

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
            wp_send_json(Vault::deleteVaultItem($itemId));
        } catch (\Exception $e){
            wp_send_json_error([
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
    public function getItemById(Request $request){
        try{
            $id = $request->all();
            // return $id['id'];
            wp_send_json(Vault::getVaultItemById($id['id']));
        } catch (\Exception $e){
            wp_send_json_error([
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
            wp_send_json(Folder::changeFolder($data) );

        }catch (\Exception $e){
            wp_send_json_error([
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
    public function search( Request $request)
    {
        try {
            wp_send_json(Vault::searchItems($request->all()));
        } catch (Exception $e) {
            wp_send_json_error([
                'message' => $e->getMessage()
            ], 423);
        }
    }

    /**
     * Export csv file from Database
     *
     * @return void
     */

     public function export()
     {
         try{
            wp_send_json(Vault::exportVaultItems());
        }catch (\Exception $e){
            wp_send_json_error([
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
    public function import()
    {
        try{

            wp_send_json(Vault::importVaultItems());
        }catch (\Exception $e){
            wp_send_json_error([
                'message' => $e->getMessage()
            ], 423);
        }
    }

    

 
}
