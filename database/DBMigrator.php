<?php

namespace FluentPlugin\Database;

use FluentPlugin\Database\Migrations\VaultMigrator;
use FluentPlugin\Database\Migrations\FolderMigrator;

class DBMigrator
{
    public static function run($network_wide = false)
    {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        // Migrate vault item
        VaultMigrator::migrate();

        // Migrate Folder
        FolderMigrator::migrate();
    }
}
