<?php

namespace FluentPlugin\App\Modules\Builder;


class Export 
{
    public function render()
    {
        ob_start()
        ?>
            <div class="export-main-div">
                <div >
                    <h1 class="text-3xl text-gray-700">Export Vault</h1>
                    <hr class="mt-4">
                </div>
                <div class="mt-4">
                    <button onclick="exportData()" class="py-2 px-3 text-lg rounded-md bg-emerald-500 hover:bg-emerald-600 text-white">Export Data</button>
                </div>
                <p class="p"></p>
            </div>
        <?php
        $form = ob_get_clean();
        $this->addAssets();

        return apply_filters('fluentForm/rendered_form_html',  $form);
    }

    private function addAssets()
    {
        wp_enqueue_script('fulentplugin_public_export', FULENTPLUGIN_URL . 'assets/js/export-vault.js', array('jquery'), FULENTPLUGIN_VERSION, true);
        wp_enqueue_script('fulentplugin_public_css', "https://cdn.tailwindcss.com");
    }
}