<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://alibahadar.com/
 * @since             1.0.0
 * @package           Wc_Mailchimp
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Mailchimp
 * Plugin URI:        http://alibahadar.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Ali Bahadar
 * Author URI:        http://alibahadar.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-mailchimp
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
if (in_array('woocommerce/woocommerce.php', get_option('active_plugins')) || is_plugin_active_for_network('woocommerce/woocommerce.php')) {
    /**
     * Currently plugin version.
     * Start at version 1.0.0 and use SemVer - https://semver.org
     * Rename this for your plugin and update it as you release new versions.
     */
    define('WC_MAILCHIMP_VERSION', '1.0.0');

    /**
     * The code that runs during plugin activation.
     * This action is documented in includes/class-wc-mailchimp-activator.php
     */
    function activate_wc_mailchimp() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-wc-mailchimp-activator.php';
        Wc_Mailchimp_Activator::activate();
    }

    /**
     * The code that runs during plugin deactivation.
     * This action is documented in includes/class-wc-mailchimp-deactivator.php
     */
    function deactivate_wc_mailchimp() {
        require_once plugin_dir_path(__FILE__) . 'includes/class-wc-mailchimp-deactivator.php';
        Wc_Mailchimp_Deactivator::deactivate();
    }

    register_activation_hook(__FILE__, 'activate_wc_mailchimp');
    register_deactivation_hook(__FILE__, 'deactivate_wc_mailchimp');
    /**
     * Define constants
     */
    define('WM_PLUGIN_DIR', untrailingslashit(plugin_dir_path(__FILE__)));
    define('WM_PLUGIN_URL', untrailingslashit(plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__))));
    /**
     * The core plugin class that is used to define internationalization,
     * admin-specific hooks, and public-facing site hooks.
     */
    require plugin_dir_path(__FILE__) . 'includes/class-wc-mailchimp.php';

    /**
     * Begins execution of the plugin.
     *
     * Since everything within the plugin is registered via hooks,
     * then kicking off the plugin from this point in the file does
     * not affect the page life cycle.
     *
     * @since    1.0.0
     */
    function run_wc_mailchimp() {

        $plugin = new Wc_Mailchimp();
        $plugin->run();
    }

    run_wc_mailchimp();
} else {

    function wc_codes_plugin_error_notice() {
        global $current_screen;
        if ($current_screen->parent_base == 'plugins') {
            echo '<div class="error"><p>WooCommerce Mailchimp ' . __('requires <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> to be activated in order to work. Please install and activate <a href="' . admin_url('plugin-install.php?tab=search&type=term&s=WooCommerce') . '" target="_blank">WooCommerce</a> first.', 'woo-pg') . '</p></div>';
        }
    }

    add_action('admin_notices', 'wc_codes_plugin_error_notice');
    $plugin = plugin_basename(__FILE__);
    if (is_plugin_active($plugin)) {
        deactivate_plugins($plugin);
    }
}