<?php

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
    
    wp_enqueue_script('fulentplugin_public', FULENTPLUGIN_URL . 'assets/js/export-vault.js', array('jquery'), FULENTPLUGIN_VERSION, true);
    wp_enqueue_style('fulentplugin_public', FULENTPLUGIN_URL . 'assets/css/export-vault.css', array(), FULENTPLUGIN_VERSION);

});


