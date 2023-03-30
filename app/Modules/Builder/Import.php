<?php

namespace FluentPlugin\App\Modules\Builder;

class Import 
{
    public function render()
    {
         ob_start()
        ?>
            <div>
                <h1 class="text-3xl text-gray-700">Import Data </h1>
                <hr class="mt-4">
            </div>
            <form enctype="multipart/form-data" id="upload_csv_form" class="mt-6 space-y-6 py-2 px-3" >
                <div class="flex flex-col text-gray-600 space-y-2">
                    <label class=" form-label ">Choose a csv file</label>
                    <input @click="showUploadButton = true" type="file" class="form-input" name="import_file" required/>
                </div>
                <button type="submit" type="primary" class="py-2 px-3 text-lg rounded-md bg-emerald-500 hover:bg-emerald-600 text-white">Upload</button>
            </form>
        <?php
        $form = ob_get_clean();
        $this->addAssets();

        return apply_filters('fluentForm/rendered_form_html',  $form);
    }

    private function addAssets()
    {
        wp_enqueue_script('fulentplugin_public_import', FULENTPLUGIN_URL . 'assets/js/import-vault.js', array('jquery'), FULENTPLUGIN_VERSION, true);
        wp_enqueue_script('fulentplugin_public_css', "https://cdn.tailwindcss.com");
    }
}