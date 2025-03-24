<?php
/**
 * Plugin Name: WC Moneris Multicurrency Extension
 * Plugin URI: https://sonicpixel.ca
 * Description: Adds multicurrency support to the WooCommerce Moneris Payment Gateway
 * Version: 1.0.0
 * Author: Michael Sewell
 * Author URI: https://your-website.com/
 * Text Domain: wc-moneris-multicurrency-extension
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 8.0
 * WC requires at least: 6.0
 * WC tested up to: 8.0
 *
 * @package WC_Moneris_Multicurrency_Extension
 */

defined('ABSPATH') || exit;

// Plugin constants
define('WC_MONERIS_MULTI_VERSION', '1.0.0');
define('WC_MONERIS_MULTI_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WC_MONERIS_MULTI_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Check if WooCommerce and Moneris Gateway are active
 */
function wc_moneris_multi_check_dependencies() {
    if (is_admin() && current_user_can('activate_plugins')) {
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', function() {
                echo '<div class="error"><p>' . 
                     __('WC Moneris Multicurrency Extension requires WooCommerce to be installed and active.', 'wc-moneris-multicurrency-extension') . 
                     '</p></div>';
            });
            return false;
        }

        if (!class_exists('WPHEKA_Moneris')) {
            add_action('admin_notices', function() {
                echo '<div class="error"><p>' . 
                     __('WC Moneris Multicurrency Extension requires WC Moneris Payment Gateway to be installed and active.', 'wc-moneris-multicurrency-extension') . 
                     '</p></div>';
            });
            return false;
        }
    }
    return true;
}

/**
 * Initialize the plugin
 */
function wc_moneris_multi_init() {
    if (!wc_moneris_multi_check_dependencies()) {
        return;
    }

    // Load plugin textdomain
    load_plugin_textdomain(
        'wc-moneris-multicurrency-extension',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages/'
    );

    // Include required files
    require_once WC_MONERIS_MULTI_PLUGIN_DIR . 'includes/class-moneris-multicurrency.php';
}
add_action('plugins_loaded', 'wc_moneris_multi_init', 20);

/**
 * Activation hook
 */
function wc_moneris_multi_activate() {
    if (!wc_moneris_multi_check_dependencies()) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(
            __('WC Moneris Multicurrency Extension requires WooCommerce and WC Moneris Payment Gateway to be installed and active.', 'wc-moneris-multicurrency-extension'),
            'Plugin dependency check',
            array('back_link' => true)
        );
    }
}
register_activation_hook(__FILE__, 'wc_moneris_multi_activate'); 