<?php

namespace FluentPlugin\App\Modules\Builder\Tools;


class Export 
{

    public function render()
    {
        ob_start()
        ?>
            <div id="export-vault" class="export-main-div">
                <div >
                    <h1 class="text-3xl text-gray-700">Export Vault</h1>
                    <hr class="mt-4">
                </div>
                <div class="mt-4">
                    <button id="exportButton" class="py-2 px-3 text-lg rounded-md bg-emerald-500 hover:bg-emerald-600 text-white">Export Data</button>
                </div>
                <p class="p"></p>
            </div>
        <?php
        $export = ob_get_clean();

        return apply_filters('fluentForm/rendered_export_html',  $export);
    }

}