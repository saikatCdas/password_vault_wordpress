<?php

namespace FluentPlugin\Database\Migrations;

class FolderMigrator
{
    static $tableName = 'fp_password_folders';

    public static function migrate()
    {
        global $wpdb;

        $charsetCollate = $wpdb->get_charset_collate();

        $table = $wpdb->prefix . static::$tableName;

        if ($wpdb->get_var("SHOW TABLES LIKE '$table'") != $table) {
            $sql = "CREATE TABLE $table (
                `id` bigint(20) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `user_id` bigint(20) UNSIGNED NOT NULL,
                `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL
            ) $charsetCollate;";
            dbDelta($sql);
        }
    }
}
