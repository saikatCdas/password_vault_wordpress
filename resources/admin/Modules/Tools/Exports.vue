<template>
    <div class="bg-emerald-500 text white rounded-md w-[300px] h-[60px] flex items-center justify-center mt-4 mr-4">
            <a href="#" class="text-white text-[23px] no-underline border-none outline-none focus:outline-none focus:ring-none active:outline-double active:outline-2 focus:shadow-none">Upgrade to pro</a>
    </div>
    <!-- <div>
        <h1 class="text-3xl text-gray-700">Export Vault</h1>
        <hr class="mt-4">
    </div>
    <div class="mt-4">
        <a href="#" @click.prevent="exportData" class="py-2 px-3 text-lg rounded-md bg-emerald-500 hover:bg-emerald-600 text-white">Export Data</a>
    </div> -->
</template>

<script setup>
import { computed } from "@vue/runtime-core";
import store from "../../store";

function exportData() {
    store.dispatch('exportVault')
        .then(()=>{
            
            const blob = new Blob([store.state.exportData], { type: "text/csv" });
            const url = URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", "data.csv");
            link.click();
            store.commit("notify", {
                type: "success",
                message: "Csv file downloaded successfully. ",
            });
        }).catch((error)=>{
            console.log(error);
            store.commit("notify", {
                type: "failed",
                message: "Something is wrong !! ",
            });
        })
    }

</script>