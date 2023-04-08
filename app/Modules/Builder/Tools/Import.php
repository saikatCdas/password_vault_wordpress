<?php

namespace FluentPlugin\App\Modules\Builder\Tools;


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
                    <input id="csv-file-input" type="file" class="form-input" name="import_file" required/>
                </div>
                <button type="button" id="import-button" class="py-2 px-3 text-lg rounded-md bg-emerald-500 hover:bg-emerald-600 text-white">Upload</button>
            </form>
        <?php
        $import = ob_get_clean();

        return apply_filters('fluentForm/rendered_import_html',  $import);
    }
}

