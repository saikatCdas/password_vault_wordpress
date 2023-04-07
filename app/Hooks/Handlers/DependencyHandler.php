<?php

namespace FluentPlugin\App\Hooks\Handlers;


class DependencyHandler
{
    public function registerShortCodes ()
    {
        // Register the shortcode
        add_shortcode('fp_vault', function () {
            $builder = new \FluentPlugin\App\Modules\Builder\Vault();
            return $builder->render();
        });
        add_shortcode('fp_tools', function () {
            $builder = new \FluentPlugin\App\Modules\Builder\Tools();
            return $builder->render();
        });

    }

    
}

