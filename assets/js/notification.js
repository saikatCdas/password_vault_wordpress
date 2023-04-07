jQuery('#close-notification-message').click(function(){
    jQuery('#notification-view-div').removeClass('!flex');
})

function notificationView($type, $message){
    jQuery('#notification-message').text($message);
    jQuery('#notification-view-div').addClass('!flex');

    if($type === 'success'){
        // jQuery('#notification-view-div').removeClass('bg-red-500');
        jQuery('#notification-view-div').addClass('bg-emerald-500');
        // jQuery('#close-notification-message').removeClass('hover:bg-red-600');
        jQuery('#close-notification-message').addClass('hover:bg-emerald-600');
    }else{
        // jQuery('#notification-view-div').removeClass('bg-emerald-500');
        jQuery('#notification-view-div').addClass('bg-red-500');
        // jQuery('#close-notification-message').removeClass('hover:bg-emerald-600');
        jQuery('#close-notification-message').addClass('hover:bg-red-600');   
    }

    setTimeout(()=>{
        jQuery('#close-notification-message').removeClass('hover:bg-red-600 hover:bg-emerald-600');
        jQuery('#notification-view-div').removeClass('bg-red-500 bg-emerald-500');
        jQuery('#notification-view-div').removeClass('!flex');
    } ,2000);
}

