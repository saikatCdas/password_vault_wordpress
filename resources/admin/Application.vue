<template>
    <div class="fl_app">
        <router-view></router-view>
        <Notification/>
    </div>
</template>

<script>
import Notification from './Components/Notification.vue';
    export default {
        name: 'DashboardApplication',
        mounted() {
            jQuery('.notice-warning, .notice-error').remove();
        },
        components: {
            Notification
        }
    };
</script>
