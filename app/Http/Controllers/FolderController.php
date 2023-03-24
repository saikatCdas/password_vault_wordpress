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
        // Gettting the currrent user id
        $current_user_id = apply_filters( 'determine_current_user', false );

        $user_id = wp_set_current_user( $current_user_id )->ID;

        return $this->response(Folder::where('user_id', $user_id)->get());
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
            return $this->response(Folder::createFolder($request->sanitize()));
        } catch (\Exception $e){
            return $this->sendError([
                'message' => $e->getMessage()
            ], 423);
        }
    }
}
