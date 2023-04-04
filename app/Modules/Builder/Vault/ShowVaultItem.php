<?php

namespace FluentPlugin\App\Modules\Builder\Vault;


class ShowVaultItem
{
    public function render()
    {
        ob_start();
        ?>
        <div class="max-w-xl mt-2 min-h-screen h-fit-content ">
            <h4 id="vault-request-progress" class="text-center text-lg text-gray-700">Loading ...</h4>
            <div>
                <div class="min-h-screen h-fit-content">
                    <div id="no-content-found-in-vault" class="flex flex-col items-center justify-center min-h-[300px] w-full">
                        <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <p class="text-sm text-gray-500">No Content Found</p>
                    </div>

                    <div id='vault-items-show-div' class=" hover:bg-gray-50 h-fit-content">
                        
                    </div>
                </div>
            </div>
        </div>
        <?php
        $form = ob_get_clean();
        return apply_filters('fluentForm/rendered_form_html',  $form);
    }

}

