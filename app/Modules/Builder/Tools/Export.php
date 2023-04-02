<?php

namespace FluentPlugin\App\Modules\Builder\Tools;


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
                    <button onclick="exportButton()" class="py-2 px-3 text-lg rounded-md bg-emerald-500 hover:bg-emerald-600 text-white">Export Data</button>
                    
                    <!-- <button onclick="myFunction()">Click me</button> -->
                </div>
                <p class="p"></p>
            </div>
            <script>

</script>
        <?php
        $form = ob_get_clean();

        return apply_filters('fluentForm/rendered_form_html',  $form);
    }
}