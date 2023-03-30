<?php

namespace FluentPlugin\App\Hooks\Handlers;


class DependencyHandler
{
    public function registerShortCodes ()
    {
        // Register the shortcode
        add_shortcode('fp_export', function () {
            $builder = new \FluentPlugin\App\Modules\Builder\Export();
            return $builder->render();
        });

        add_shortcode('fp_import', function () {
            $builder = new \FluentPlugin\App\Modules\Builder\Import();
            return $builder->render();
        });

        add_shortcode('fp_add_vault_item', function () {
            $builder = new \FluentPlugin\App\Modules\Builder\AddVaultItem();
            return $builder->render();
        });

    }

    
}

