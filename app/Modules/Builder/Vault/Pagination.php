<?php

namespace FluentPlugin\App\Modules\Builder\Vault;


class Pagination
{
    public function render()
    {
        ob_start();
        ?>
        <div id="pagination-div" class="justify-center mt-5 pb-3 hidden">
            <nav id="pagination-nav"
            class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
            aria-label="Pagination"
            >
                
            </nav>
        </div>
        <?php
        $pagination = ob_get_clean();
        return apply_filters('fluentForm/rendered_pagination_html',  $pagination);
    }

}