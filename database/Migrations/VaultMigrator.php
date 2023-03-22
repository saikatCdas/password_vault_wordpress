<?php

namespace FluentPlugin\Database\Migrations;

class VaultMigrator
{
    static $tableName = 'vaults';

    public static function migrate()
    {
        global $wpdb;

        $charsetCollate = $wpdb->get_charset_collate();

        $table = $wpdb->prefix . static::$tableName;

        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $sql = "CREATE TABLE $table (
                `id` bigint(20)  UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `folder_id` bigint(20) UNSIGNED DEFAULT NULL,
                `user_id` bigint(20) UNSIGNED NOT NULL,
                `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `card_holder_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `card_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `card_expiration_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `card_security_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL
            ) $charsetCollate;";
            dbDelta($sql);
        }
    }
}
