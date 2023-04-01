<?php

namespace FluentPlugin\App\Modules\Builder\Tools;


class PasswordGenerator
{
    public function render()
    {
        ob_start();
        ?>
            <h1>hello from generator</h1>
        <?php

        return ob_get_clean();
    }
}