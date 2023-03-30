<?php

namespace FluentPlugin\App\Modules\Builder;

class AddVaultItem 
{
    public function render()
    {
         ob_start()
        ?>
            <div>
                <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true"> 
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                    <div class="fixed inset-0 z-50 overflow-y-auto min-w-full" >
                        <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0 ">
                            <div
                                x-transition:enter="transition ease-out duration-300 transform"
                                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave="transition ease-in duration-200 transform"
                                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl"
                            >
                                <div class="flex items-center justify-between space-x-4">
                                    <h1 class="text-xl font-medium text-gray-800 ">Add Item</h1>
                                </div>

                                <form class="mt-5" id="create-vault">
                                    <div class="mb-4 w-full">
                                        <label for="category" class="block text-md font-semibold text-gray-900 capitalize">What type of item is this?</label>
                                        <select id="category" name="category" class="block w-full max-w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            <option value="Login" class="bg-white">Login</option>
                                            <option value="Card" class="bg-white">Card</option>
                                            <option value="Secure note" class="bg-white">Secure note</option>
                                        </select>
                                    </div>


                                    <div class="mb-4">
                                        <label for="folder" class="block text-md font-semibold text-gray-900 capitalize">Folder</label>
                                        <select id="folder" name="folder" class="block w-full max-w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                            <option value="">Choose a folder</option>
                                        </select>
                                    </div>


                                    <div class="mb-4" id="name-div">
                                        <label for="name" class="block text-md font-semibold text-gray-900 capitalize">Name</label>
                                        <input v-model="vaultData.name" type="text" id="name" name="name" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Name goes here.." required/>
                                    </div>

                                    <!-- Login  -->
                                    <!-- Card -->
                                    <div class="mb-4" id="note-div">
                                        <label for="notes" class="block text-md font-semibold text-gray-900 capitalize">Notes</label>
                                        <textarea v-model="vaultData.notes" rows="4" type="text" id="notes" name="notes" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="You can take some notes" ></textarea>
                                    </div>

                                    <div class="flex justify-end mt-6">
                                        <button type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md  hover:bg-indigo-700 ">
                                            Create Item
                                        </button>
                                    </div>
                                </form>
                            </div>
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
        wp_enqueue_script('fulentplugin_public', FULENTPLUGIN_URL . 'assets/js/add-vault-item.js', array('jquery'), FULENTPLUGIN_VERSION, true);
        wp_enqueue_script('fulentplugin_public_css', "https://cdn.tailwindcss.com");
    }
}