<template>
    <div v-if="props.modalOpen" class="fixed max-sm:top-6 inset-0 z-50 overflow-y-auto" >
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true"> 
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-50 overflow-y-auto min-w-full" >
                <div class="flex items-end justify-center sm:min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
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
                            <h1 class="text-xl font-medium text-gray-800 ">Select Folder</h1>

                            <button @click="modalClose" class="text-gray-600 focus:outline-none hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>

                        <form class="mt-5" @submit="changeFolder">
                            <div>
                                <label for="folder-name" class="block text-sm text-gray-700 capitalize">Folder Name</label>
                                <select v-model="folderId" class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                    <option v-for="(folder, ind) in folders" :key="ind" :value="folder.id">{{ folder.name }}</option>
                                    <option :value="null">No Folder</option>
                                </select>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit" class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                    Change Folder
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
import { computed } from "@vue/runtime-core";
import { useRouter } from "vue-router";
import store from "../../store";


const props = defineProps({
    modalOpen: Boolean,
});
const emit = defineEmits(['modalClose', 'changeFolder']);
const router = useRouter();

const folderId = ref(null);
const folders = computed(()=>store.state.folders)

function modalClose(){
    folderId.value = '';
    emit('modalClose', false);
}


function changeFolder(ev){
    ev.preventDefault();
    emit('changeFolder', folderId.value)
}
</script>

<style>

</style>