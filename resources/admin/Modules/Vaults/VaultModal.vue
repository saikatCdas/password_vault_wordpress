<template>
    <div v-if=" (route.path == '/vault/item/edit' && route.query.id) ? true : props.openVaultModal ">
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
                            <h1 class="text-xl font-medium text-gray-800 ">{{ route.query.id ? 'Edit Item': 'Add Item' }}</h1>

                            <router-link v-if="route.query.id" to="/" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </router-link>

                            <button v-else @click=" closeVaultModal" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>

                        <form class="mt-5" ref="formRef" @submit.prevent="manageVault">
                            <div class="mb-4 w-full">
                                <label for="category" class="block text-md font-semibold text-gray-900 capitalize">What type of item is this?</label>
                                <select v-model="vaultData.category" id="category" name="category" class="block w-full max-w-full px-3 py-2 mt-2 text-gray-600 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                    <option value="Login" class="bg-white">Login</option>
                                    <option value="Card" class="bg-white">Card</option>
                                    <option value="Secure note" class="bg-white" >Secure note</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="folder" class="block text-md font-semibold text-gray-900 capitalize">Folder</label>
                                <select v-model="vaultData.folder" id="folder" name="folder" class="block w-full max-w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                    <option :value="'' || null">Chose a folder</option>
                                    <option v-for="(folder, ind) in folders" :key="ind" :value="folder.name">{{ folder.name  }}</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="name" class="block text-md font-semibold text-gray-900 capitalize">Name</label>
                                <input v-model="vaultData.name" type="text" id="name" name="name" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Name goes here.." required/>
                            </div>

                            <!-- Login  -->
                            <div v-if="vaultData.category === 'Login'" class="mb-4">
                                <label for="user_name" class="block text-md font-semibold text-gray-900 capitalize">User Name</label>
                                <input v-model="vaultData.user_name" type="text" id="user_name" name="user_name" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="User name goes here..." />
                            </div>
                            <div v-if="vaultData.category === 'Login'" class="mb-4">
                                <label for="email" class="block text-md font-semibold text-gray-900 capitalize">Email</label>
                                <input v-model="vaultData.email" type="email" id="email" name="email" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="example@something.com"/>
                            </div>
                            <div v-if="vaultData.category === 'Login'" class="mb-4">
                                <label for="password" class="block text-md font-semibold text-gray-900 capitalize">Password</label>
                                <input v-model="vaultData.password" type="text" id="password" name="password" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Password goes here..."/>
                            </div>
                            <div v-if="vaultData.category === 'Login'" class="mb-4">
                                <label for="url" class="block text-md font-semibold text-gray-900 capitalize">URL</label>
                                <input v-model="vaultData.url" type="url" id="url" name="url" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="ex. https://google.com"/>
                            </div>

                            <!-- Card -->
                            <div v-if="vaultData.category === 'Card'" class="mb-4">
                                <label for="card_holder_name" class="block text-md font-semibold text-gray-900 capitalize">Card Holder Name</label>
                                <input v-model="vaultData.card_holder_name" type="text" id="card_holder_name" name="card_holder_name" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Card holder name goes here..." />
                            </div>
                            <div v-if="vaultData.category === 'Card'" class="mb-4">
                                <label for="card_number" class="block text-md font-semibold text-gray-900 capitalize">Card Number</label>
                                <input v-model="vaultData.card_number" type="number" id="card_number" name="card_number" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Card Number goes here..."/>
                            </div>
                            <div v-if="vaultData.category === 'Card'" class="mb-4">
                                <label for="card_expiration_date" class="block text-md font-semibold text-gray-900 capitalize">Expiration Date</label>
                                <input v-model="vaultData.card_expiration_date" type="date" id="card_expiration_date" name="card_expiration_date" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Expiration date goes here..." />
                            </div>
                            <div v-if="vaultData.category === 'Card'" class="mb-4">
                                <label for="card_security_code" class="block text-md font-semibold text-gray-900 capitalize">Security Code</label>
                                <input v-model="vaultData.card_security_code" type="text" id="card_security_code" name="card_security_code" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="Securite code goes here..." />
                            </div>


                            <div class="mb-4">
                                <label for="notes" class="block text-md font-semibold text-gray-900 capitalize">Notes</label>
                                <textarea v-model="vaultData.notes" rows="4" type="text" id="notes" name="notes" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-300 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40" placeholder="You can take some notes" />
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md  hover:bg-indigo-700 ">
                                    {{ route.query.id ? 'Update Item': 'Create Item' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "@vue/reactivity";
import { computed, onMounted } from "@vue/runtime-core";
import { useRouter, useRoute } from "vue-router";
import { createLogger } from "vuex";
import store from "../../store";


const route = useRoute();
const router = useRouter();
const folders = computed(()=>store.state.folders);
const formRef = ref(null)

const props = defineProps({
    openVaultModal:Boolean
});


const emit = defineEmits(['closeVaultModal', 'allVaultItems']);

function closeVaultModal(){
    emit('closeVaultModal');
}


const vaultData = ref({
    'name': '',
    'category' : 'Login',
    'email': '',
    'folder': null,
    'user_name': '',
    'password': '',
    'url': '',
    'card_holder_name': '',
    'card_number': '',
    'card_expiration_date': '',
    'card_security_code':'',
    'notes': ''
});


function clearForm() {
  formRef.value.reset()
  vaultData.value.name = '';
  vaultData.value.category = 'Login';
  vaultData.value.email = '';
  vaultData.value.folder = null;
  vaultData.value.user_name = '';
  vaultData.value.password = '';
  vaultData.value.url = '';
  vaultData.value.card_holder_name = '';
  vaultData.value.card_number = '';
  vaultData.value.card_expiration_date = '';
  vaultData.value.card_security_code = '';
  vaultData.value.notes = '';
}

// Notification for failed
function failedNotification(){
    store.commit("notify", {
        type: "failed",
        message: "Something went wrong.",
    });
}

// initializing vault data for edit
onMounted(()=>{
    if(route.query.id){
        console.log(route.path);
        store.dispatch('getItem', route.query.id)
            .then(()=>{
                vaultData.value = store.state.vaultItem;

            }).catch((err)=>{
                router.push({
                    name: 'vault'
                })
                failedNotification();
            })
    }
    store.dispatch('getFolder');
})

// create or update vault item
function manageVault(ev){
    ev.preventDefault();
    store.dispatch('manageVault', vaultData.value)
        .then(()=>{
            if(route.query.id){
                router.push({
                    name: 'vault',
                    query: { type : 'all'}
                });
            } else{
                closeVaultModal();
                emit('allVaultItems', 'all');
                clearForm();
            }
            store.commit("notify", {
                type: "success",
                message: `Item ${route.query.id ? 'Updated' : 'Added'} Successfully`
            });
        }).catch((err)=>{
            failedNotification();
            console.log(err);
        })
}
</script>

<style scoped>
</style>