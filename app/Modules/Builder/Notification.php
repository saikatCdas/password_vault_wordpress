<?php

namespace FluentPlugin\App\Modules\Builder;


class Notification 
{
    public function render()
    {   
        ob_start();
        ?>
        <div id="notification-view-div"
            class=" z-50  items-center fixed w-[300px] right-4 top-20 py-2 px-4 text-white animate-fade-in-down hidden"
        >
            <div class="w-6 h-6 mr-2">
                <svg id="close-notification-message" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer rounded-full">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <p id="notification-message"></p>
        </div>
        <?php
        $notifiaction = ob_get_clean();        

        return apply_filters('fluentForm/rendered_tools_html',  $notifiaction);
    }
}

