<?php

namespace FluentPlugin\App\Modules\Builder;


class Tools 
{
    public function render()
    {   
        ob_start();
        ?>
        <div class="flex w-full items-center justify-center">
            <div class="max-w-5xl w-full">
                <div class="flex max-sm:flex-col max-sm:space-y-6 sm:space-x-6 mt-4 min-h-screen h-full max-md:px-4">
                    <div class="">
                        <div class="bg-white rounded-lg sm:rounded-md border  border-gray-400 w-full sm:w-52">
                            <div class=" bg-gray-100  rounded-md py-2 px-4">
                                <h3 class="text-lg font-medium"> Tools </h3>
                            </div>
                            <hr>
                            <div id="tool-menu-button">
                            </div>
                        </div>
                    </div>
                    <div class="w-full php-class-container">
                    </div>
                </div>
            </div>
        </div>
        <?php
        $tools = ob_get_clean();
        $this->addAssets();

        return apply_filters('fluentForm/rendered_tools_html',  $tools);
    }

    private function addAssets()
    {
        wp_enqueue_script('fulentplugin_vault', FULENTPLUGIN_URL . 'assets/js/tools.js', array('jquery'), FULENTPLUGIN_VERSION, true);
        // wp_enqueue_script('fulentplugin_public_export', FULENTPLUGIN_URL . 'assets/js/export-vault.js', array('jquery'), FULENTPLUGIN_VERSION, true);
        // wp_enqueue_script('fulentplugin_public_import', FULENTPLUGIN_URL . 'assets/js/import-vault.js', array('jquery'), FULENTPLUGIN_VERSION, true);
        wp_enqueue_script('fulentplugin_public_css', "https://cdn.tailwindcss.com");
    }

    
    
}