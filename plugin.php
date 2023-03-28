<?php defined('ABSPATH') or die;

/*
Plugin Name: FluentPlugin
Description: FluentPlugin WordPress Plugin
Version: 1.0.0
Author: 
Author URI: 
Plugin URI: 
License: GPLv2 or later
Text Domain: FluentPlugin
Domain Path: /language
*/


if (!defined('FULENTPLUGIN_VERSION')) {
    define('FULENTPLUGIN_VERSION_LITE', true);
    define('FULENTPLUGIN_VERSION', '4.3.3');
    define('FULENTPLUGIN_DB_VERSION', 120); 
    // Stripe API version should be in 'YYYY-MM-DD' format.
    define('FULENTPLUGIN_STRIPE_API_VERSION', '2019-05-16');
    define('FULENTPLUGIN_MAIN_FILE', __FILE__);
    define('FULENTPLUGIN_URL', plugin_dir_url(__FILE__));
    define('FULENTPLUGIN_DIR', plugin_dir_path(__FILE__));
    if (!defined('FULENTPLUGIN_UPLOAD_DIR')) {
        define('FULENTPLUGIN_UPLOAD_DIR', '/FluentPlugin');
    }

    require __DIR__.'/vendor/autoload.php';

    call_user_func(function($bootstrap) {
        $bootstrap(__FILE__);
    }, require(__DIR__.'/boot/app.php'));

}