<?php

namespace FluentPlugin\App\Http\Requests;

use FluentPlugin\Framework\Foundation\RequestGuard;

class VaultRequest extends RequestGuard
{
    /**
     * @return Array
     */
    public function rules()
    {
        return [
            'category'  => 'required|string',
            'name'      => 'required|string',
            'user_name' => 'nullable|string',
            'email'     => 'nullable|string',
            'password'  => 'nullable|string',
            'url'       => 'nullable|string',
            'card_holder_name' => 'nullable|string',
            'card_number' => 'nullable|string',
            'card_expiration_date' => 'nullable|string',
            'card_security_code' => 'nullable|string',
            'notes'     => 'nullable|string'
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

        $data['category'] = sanitize_text_field($data['category']);
        $data['name'] = sanitize_text_field($data['name']);
        $data['user_name'] = sanitize_text_field($data['user_name']);
        $data['email'] = sanitize_email($data['email']);
        $data['password'] = sanitize_text_field($data['password']);
        $data['url'] = sanitize_url($data['url']);
        $data['card_holder_name'] = sanitize_text_field($data['card_holder_name']);
        $data['card_number'] = sanitize_text_field($data['card_number']);
        $data['card_expiration_date'] = sanitize_text_field($data['card_security_code']);
        $data['card_security_code'] = sanitize_text_field($data['card_security_code']);
        $data['notes'] = sanitize_textarea_field($data['notes']);
        
        return $data;
    }
}
