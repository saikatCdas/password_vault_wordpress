<?php

namespace FluentPlugin\App\Modules\Builder;

class Export 
{
    public function render()
    {
        ?> 
        <div class="export-main-div">
            <div >
                <h1 class="export-header">Export Vault</h1>
                <hr class="mt-4">
            </div>
            <div class="mt-4">
                <button onclick="exportData()" class="export-button">Export Data</button>
            </div>
        </div>
            <?php 

        wp_enqueue_script('fulentplugin_public', FULENTPLUGIN_URL . 'assets/js/export-vault.js', array(), FULENTPLUGIN_VERSION, true);
        wp_enqueue_style('fulentplugin_public', FULENTPLUGIN_URL . 'assets/css/export-vault.css', array(), FULENTPLUGIN_VERSION);
    }
}