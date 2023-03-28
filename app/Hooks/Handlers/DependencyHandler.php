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
    }
}

