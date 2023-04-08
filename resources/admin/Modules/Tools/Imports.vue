<template>
    <div>
        <div class="bg-emerald-500 text white rounded-md w-[300px] h-[60px] flex items-center justify-center mt-4 mr-4">
            <a href="#" class="text-white text-[23px] no-underline border-none outline-none focus:outline-none focus:ring-none active:outline-double active:outline-2 focus:shadow-none">Upgrade to pro</a>
        </div>
        <!-- <div>
            <h1 class="text-3xl text-gray-700">Import Data </h1>
            <hr class="mt-4">
        </div>
        <form enctype="multipart/form-data" ref="importFormRef"  id="upload_csv_form" class="mt-6 space-y-6 py-2 px-3">
            <div class="flex flex-col text-gray-600 space-y-2">
                <input type="hidden" name="action" value="wppayform_global_tools"/>
                <input type="hidden" name="route" value="upload_form"/>
                <label class="  text-lg ">Choose a csv file</label>
                <input @click="showUploadButton = true" type="file" ref="fileInput" name="import_file" required/>
            </div>
            <button @click.prevent="submitFile(event)" v-show="showUploadButton" type="primary" class="py-2 px-3 text-lg rounded-md bg-emerald-500 hover:bg-emerald-600 text-white">Upload</button>
        </form> -->
    </div>
    </template>
    
    <script setup>
    import { ref } from 'vue';
    import { useRouter } from 'vue-router';
    import store from '../../store';
    
    const fileInput = ref(null);
    const router = useRouter();
    const importFormRef = ref(null);
    
    const showUploadButton = ref(false);
    function submitFile (event){
        showUploadButton.value = false;
        // Get the file from the input
        const file = fileInput.value.files[0];
    
        // Checking Extension
        let extensionNotMatch = checkingFileExtension(file.name)
        if(extensionNotMatch){
            importFormRef.value.reset()
            store.commit("notify", {
                    type: "failed",
                    message: "Please select a csv file !! ",
                });
            return;
        } 
        store.dispatch('import', new FormData(jQuery('#upload_csv_form')[0]))
            .then(() => {
                store.commit("notify", {
                    type: "success",
                    message: "File imported successfully !!",
                });
                router.push({
                    name: 'vault'
                })
            })
            .catch((err)=>{
                console.log(err);
                store.commit("notify", {
                    type: "failed",
                    message: "Something is wrong !! ",
                });
            })
    }
    
    
    function checkingFileExtension(file){
        const fileExtension = file.split('.');
        if(fileExtension[fileExtension.length - 1].toLowerCase() !== 'csv'){
            return true;
        }
    }
    </script>