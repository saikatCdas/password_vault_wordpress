<?php

namespace FluentPlugin\App\Services;


/**
 * Managing Vault Tools
 */
class VaultTools
{
    public function importVaultDataValidation($credential)
    {
        switch (true) {
            case (strlen($credential['category']) <= 0) || !(is_string($credential['category'])):
                return false;
            case (strlen($credential['name']) <= 0) || !(is_string($credential['name'])):
                return false;
            case !(is_string($credential['user_name'])):
                return false;
            case !(is_string($credential['email'])):
                return false;
            case !(is_string($credential['password'])):
                return false;
            case !(is_string($credential['url'])):
                return false;
            case !(is_string($credential['card_holder_name'])):
                return false;
            case !(is_string($credential['card_number'])):
                return false;
            case !(is_string($credential['card_expiration_date'])):
                return false;
            case !(is_string($credential['card_security_code'])):
                return false;
            case !(is_string($credential['notes'])):
                return false;
            default:
                return true;
        }
    }

}