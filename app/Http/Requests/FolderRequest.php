<?php

namespace FluentPlugin\App\Http\Requests;

use FluentPlugin\Framework\Foundation\RequestGuard;

class FolderRequest extends RequestGuard
{
    /**
     * @return Array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string',
            
        ];
    }

    /**
     * @return Array
     */
    public function messages()
    {
        return [];
    }

    /**
     * @return Array
     */
    public function sanitize()
    {
        $data = $this->all();

        $data['name'] = sanitize_text_field($data['name']);
        
        return $data;
    }
}
