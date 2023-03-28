<?php

namespace FluentPlugin\App\Modules\Builder;

class Export 
{
    public function render()
    {
        return '<div class="export-main-div">
            <div >
                <h1 class="export-header">Export Vault</h1>
                <hr class="mt-4">
            </div>
            <div class="mt-4">
                <button onclick="exportData()" class="export-button">Export Data</button>
            </div>
            <p class="p"></p>
        </div>' ;
        // return 'Success';
    }
}