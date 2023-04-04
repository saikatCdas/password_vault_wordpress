<?php

namespace FluentPlugin\App\Http\Controllers;

use FluentPlugin\Framework\Request\Request;
use FluentPlugin\App\Models\Folder;
use FluentPlugin\App\Http\Requests\FolderRequest;
use FluentPlugin\App\Models\User;
use Exception;


class FolderController extends Controller
{

    public function allFolder()
    {
        try {
             // Gettting the currrent user id
            $current_user_id = apply_filters( 'determine_current_user', false );

            $user_id = wp_set_current_user( $current_user_id )->ID;

            wp_send_json(Folder::where('user_id', $user_id)->get());
        } catch (\Exception $e){
            wp_send_json_error([
                'message' => $e->getMessage()
            ], 423);
        }
    }

    
      /**
     * Create a Folder
     *
     * @param Request $request
     * @return void
     */
    public function store(FolderRequest $request)
    {
        try {
            wp_send_json(Folder::createFolder($request->sanitize()));
        } catch (\Exception $e){
            wp_send_json_error([
                'message' => $e->getMessage()
            ], 423);
        }
    }
}
