<?php

namespace FluentPlugin\App\Modules\Builder;
use FluentPlugin\App\Modules\Builder\Vault\ShowVaultItem;
use FluentPlugin\App\Modules\Builder\Vault\MenuButton;
use FluentPlugin\App\Modules\Builder\Vault\AddVaultItem;
use FluentPlugin\App\Modules\Builder\Vault\FolderModal;

class Vault 
{
    public function render()
    {
        ob_start()
        ?>
            <div class="flex max-sm:flex-col min-h-screen h-full max-sm:space-y-6 sm:space-x-6 mt-4">
                <div class="">
                    <div class="bg-white rounded-lg sm:rounded-md border  border-gray-400 w-full sm:w-52">
                        <div class=" bg-gray-100  rounded-md py-2 px-4">
                            <h3 class="text-lg font-medium"> Vaults </h3>
                        </div>
                        <hr>
                        <div class="px-4 py-2">
                        <form id="search-form">
                            <div>
                                <label for="search" class="sr-only"></label>
                                <input id="search" name="search" type="text" class="relative block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="Search">
                            </div>
                        </form>
                            <div class="py-1 px-4 flex items-center space-x-1 text-gray-700 hover:text-blue-300 cursor-pointer" :class="route.query.type === 'all' ? 'font-semibold text-blue-400': ''">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </svg>

                                <button type="button" class="category">All items</button>
                            </div>
                        </div>
                        <hr>
                        <div class="px-4 py-2 ">
                            <div class="flex items-center text-gray-500 space-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                                <h3 class="text-gray-500  font-medium text-lg">
                                    Types
                                </h3>
                            </div>
                                <div class="py-1 px-4 flex items-center space-x-1 text-gray-700 hover:text-blue-300" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 01-1.161.886l-.143.048a1.107 1.107 0 00-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 01-1.652.928l-.679-.906a1.125 1.125 0 00-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 00-8.862 12.872M12.75 3.031a9 9 0 016.69 14.036m0 0l-.177-.529A2.25 2.25 0 0017.128 15H16.5l-.324-.324a1.453 1.453 0 00-2.328.377l-.036.073a1.586 1.586 0 01-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 01-5.276 3.67m0 0a9 9 0 01-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                                    </svg>

                                    <button type="button" class="category">Login</button>
                                </div>
                                <div class="py-1 px-4 flex items-center space-x-1 text-gray-700 hover:text-blue-300" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                    </svg>
                                    <button type="button" class="category">Card</button>
                                </div>
                                <div class="py-1 px-4 flex items-center space-x-1 text-gray-700 hover:text-blue-300" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                    <button type="button" class="category">Secure note</button>
                                </div>
                        </div>
                        <hr>
                        <div class="px-4 py-2 ">
                            <div class="flex items-center justify-between text-gray-500 space-x-1">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                    <h3 class="text-gray-500  font-medium text-lg">
                                        Folder
                                    </h3>
                                </div>
                                <button type="button" id="open-folder-modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </button>
                            </div>
                            <div class="text-gray-700 " id="button-container">
                                <button type="button" id="folder-button" class="py-1 px-4 flex items-center justify-start space-x-1 hover:text-blue-300 no-folder-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                    </svg>
                                        <span>No Folder</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-xl">
                    <div class="mb-4">
                        <div class="mb-4 flex justify-between items-center">
                            <h1 class="text-gray-600 text-2xl">Vault items</h1>
                            <div class="flex items-center space-x-1">
                                <?php echo (new MenuButton())->render() ?>
                                <button id="add-item-modal-button" type="button"  class="flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide text-blue-500 border rounded-sm capitalize transition-colors duration-200 transform hover:text-white hover:bg-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>

                                    <span>Add item</span>
                                </button>
                            </div>
                        </div>
                        <hr class="">
                        <?php echo (new ShowVaultItem())->render() ?>
                    </div>
                </div>
                <?php echo (new AddVaultItem())->render() ?>
                <?php echo (new FolderModal)->render() ?>
            </div>
        <?php
        $form = ob_get_clean();
        do_action('wp_footer', $this->addAssets());
        return apply_filters('fluentForm/rendered_form_html',  $form);
    }

    private function addAssets()
    {
        wp_enqueue_script('fp_vault', FULENTPLUGIN_URL . 'assets/js/vault.js', array('jquery'), FULENTPLUGIN_VERSION, true);
        wp_enqueue_script('fp_vault_menu_buttons', FULENTPLUGIN_URL . 'assets/js/vault/menu-buttons.js', array('jquery'), FULENTPLUGIN_VERSION, true);
        wp_enqueue_script('fp_add_vault_item', FULENTPLUGIN_URL . 'assets/js/vault/add-vault-item.js', array('jquery'), FULENTPLUGIN_VERSION, true);
    }
}