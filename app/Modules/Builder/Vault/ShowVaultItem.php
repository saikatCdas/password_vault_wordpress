<?php

namespace FluentPlugin\App\Modules\Builder\Vault;


class ShowVaultItem
{
    public function render($itmes)
    {
        echo $itmes;
        ob_start();
        ?>
        <div class="max-w-xl mt-2 ">
            <h4 v-if="loading" class="text-center text-lg text-gray-700">Loading ...</h4>
            <div v-else >
                <div class="min-h-screen">
                    <div v-if="!vaultItems.length" class="flex flex-col items-center justify-center min-h-[300px] w-full">
                        <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-20 h-20 text-gray-400">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <p class="text-sm text-gray-500">No Content Found</p>
                    </div>

                    <div id='vaultItems' class=" hover:bg-gray-50 ">
                        <div class="flex items-center space-x-5 text-gray-500 pl-5 py-3">
                            <input type="checkbox" :name="item.id" class="rounded w-[16px] h-[16px]" :value="item.id">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-xs">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 01-5.276 3.67m0 0a9 9 0 01-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                            </svg>
                            <a href="#" class="text-sky-600 hover:text-sky-700 hover:underline cursor-pointer"></a>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $form = ob_get_clean();
        $this->addAssets();
        return apply_filters('fluentForm/rendered_form_html',  $form);
    }


    private function addAssets()
    {
        wp_enqueue_script('fulentplugin_vault_show_vault_items', FULENTPLUGIN_URL . 'assets/js/vault/showVaultItem.js', array('jquery'), FULENTPLUGIN_VERSION, true);
    }
}

