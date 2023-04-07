<?php


use FluentPlugin\App\Modules\Builder\Tools\PasswordGenerator;
use FluentPlugin\App\Modules\Builder\Tools\Import;
use FluentPlugin\App\Modules\Builder\Tools\Export;
use FluentPlugin\App\Http\Controllers\VaultController;
use FluentPlugin\App\Http\Controllers\FolderController;
use FluentPlugin\App\App;

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



$vaultController = new VaultController();
$folderController = new FolderController();

// Load dependencies
$app->addAction('fluentplugin_loaded', function ($app) {
    $dependency = new \FluentPlugin\App\Hooks\Handlers\DependencyHandler();
    $dependency->registerShortCodes();
});


// localaization of script
function fp_tools_enqueue_scripts() {

  
    $ns = (App::getInstance())->config->get('app.rest_namespace');
    $ver = (App::getInstance())->config->get('app.rest_version');

    wp_enqueue_script('fp_notification', FULENTPLUGIN_URL . 'assets/js/notification.js', array('jquery'), FULENTPLUGIN_VERSION, true);
    wp_enqueue_script('fp-tools-js', FULENTPLUGIN_URL . 'assets/js/tools.js', array('jquery'), FULENTPLUGIN_VERSION, true);
    wp_enqueue_script('fulentplugin_public_css', "https://cdn.tailwindcss.com");
    wp_localize_script( 'fp-tools-js', 'fp_plugin_data', array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'plugin_path' => FULENTPLUGIN_URL,
      'rest_url'       => rest_url($ns . '/' . $ver),
    ));
  }
add_action( 'wp_enqueue_scripts', 'fp_tools_enqueue_scripts' );



// tool page component handler
add_action( 'wp_ajax_fp_tool_page_component', 'tool_page_component_handler' );
add_action( 'wp_ajax_nopriv_fp_tool_page_component', 'tool_page_component_handler' );

function tool_page_component_handler() {
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



// export vault data from database
add_action( 'wp_ajax_fp_export_vault', array($vaultController, 'export') );
add_action( 'wp_ajax_nopriv_fp_export_vault', array($vaultController, 'export') );


// import data into the vault
add_action( 'wp_ajax_fp_import_vault', array($vaultController, 'import') );
add_action( 'wp_ajax_nopriv_fp_import_vault', array($vaultController, 'import') );


// get data from the vault
add_action( 'wp_ajax_fp_get_vault_items', array($vaultController, 'getVaultItems') );
add_action( 'wp_ajax_nopriv_fp_get_vault_items', array($vaultController, 'getVaultItems') );

// get folder name from the folder
add_action( 'wp_ajax_fp_get_folder_items', array($folderController, 'allFolder') );
add_action( 'wp_ajax_nopriv_fp_get_folder_items', array($vaultController, 'allFolder') );

// crete a vault item
add_action( 'wp_ajax_fp_create_vault_item', array($vaultController, 'store') );
add_action( 'wp_ajax_nopriv_fp_create_vault_item', array($vaultController, 'store') );