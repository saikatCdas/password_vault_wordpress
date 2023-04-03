<?php


use FluentPlugin\App\Modules\Builder\Tools\PasswordGenerator;
use FluentPlugin\App\Modules\Builder\Tools\Import;
use FluentPlugin\App\Modules\Builder\Tools\Export;

/**
 * All registered action's handlers should be in app\Hooks\Handlers,
 * addAction is similar to add_action and addCustomAction is just a
 * wrapper over add_action which will add a prefix to the hook name
 * using the plugin slug to make it unique in all wordpress plugins,
 * ex: $app->addCustomAction('foo', ['FooHandler', 'handleFoo']) is
 * equivalent to add_action('slug-foo', ['FooHandler', 'handleFoo']).
 */

/**
 * @var $app FluentPlugin\Framework\Foundation\Application
 */

$app->addAction('admin_menu', 'AdminMenuHandler@add');

/**
 * Enable this line if you want to use custom post types
 */

// $app->addAction('init', 'CPTHandler@registerPostTypes');


// Load dependencies
$app->addAction('fluentplugin_loaded', function ($app) {
    $dependency = new \FluentPlugin\App\Hooks\Handlers\DependencyHandler();
    $dependency->registerShortCodes();
});


// localaization of script
function fp_tools_enqueue_scripts() {
    wp_enqueue_script('fp-tools-js', FULENTPLUGIN_URL . 'assets/js/tools.js', array('jquery'), FULENTPLUGIN_VERSION, true);
    wp_enqueue_script('fulentplugin_public_css', "https://cdn.tailwindcss.com");
    wp_localize_script( 'fp-tools-js', 'fp_plugin_data', array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'plugin_path' => FULENTPLUGIN_URL
    ));
  }
add_action( 'wp_enqueue_scripts', 'fp_tools_enqueue_scripts' );



// ajax request
add_action( 'wp_ajax_my_ajax_action', 'my_ajax_handler' );
add_action( 'wp_ajax_nopriv_my_ajax_action', 'my_ajax_handler' );

function my_ajax_handler() {
    switch ($_POST['type']) {
        case 'Generator':
          wp_send_json((new PasswordGenerator)->render());
          break;

        case 'Imports':
            wp_send_json((new Import)->render());
            break;

        case 'Exports':
            // add_action( 'wp_enqueue_scripts', 'fp_vault_export' );
            wp_send_json((new Export)->render());
            break;

        default:
          return 'defalut';
      }
}

