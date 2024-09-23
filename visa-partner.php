<?php
/*
 * Plugin Name:       Visa Search Form
 * Plugin URI:        https://github.com/glmfrk/visafax-plugin
 * Description:       This is a country with a visa filtering search box for travel management websites.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Gulam Faruk
 * Author URI:        https://facebook.com/gulamfrk
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       search_visa
 * Domain Path:       /languages
 */

// Prevent direct access
if (!defined('WPINC')) {
    die;
}


if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('VISAFAX_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('VISAFAX_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
$visafax_includes = [
    'visafax-shortcodes.php',
    'visafax-taxonomy.php',
    'visafax-ajaxhandler.php'
];

foreach ($visafax_includes as $file) {
    $filepath = VISAFAX_PLUGIN_PATH . 'includes/' . $file;
    if (file_exists($filepath)) {
        require_once $filepath;
    }
}

// Enqueue styles and scripts
add_action('wp_enqueue_scripts', 'visafax_enqueue_files');
function visafax_enqueue_files() {
    // Enqueue Font Awesome from CDN
    wp_enqueue_style('visafax-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css', [], '6.0.0-beta3', 'all');

    wp_enqueue_style('visafax-bootstrap', VISAFAX_PLUGIN_URL . 'assets/css/bootstrap.min.css', [], null, 'all');
    wp_enqueue_style('visafax-style', VISAFAX_PLUGIN_URL . 'assets/css/visafax.css', [], null, 'all');
 
    
    wp_enqueue_script('visafax-bootstrap-script', VISAFAX_PLUGIN_URL . 'assets/js/bootstrap.min.js', ['jquery'], null, true);

    // Enqueue and localize script for AJAX
    wp_enqueue_script('visafax_script', VISAFAX_PLUGIN_URL . 'assets/js/visafax.js', ['jquery'], null, true);
    wp_localize_script('visafax_script', 'visafax_api', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);
}



// Activation hook
register_activation_hook(__FILE__, 'visafax_plugin_activate');
function visafax_plugin_activate() {
    // Register the custom taxonomies on activation
    visafax_register_taxonomies();
    // Clear the permalinks after the post type has been registered
    flush_rewrite_rules();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'visafax_plugin_deactivate');
function visafax_plugin_deactivate() {
    // Clear the permalinks
    flush_rewrite_rules();
}



