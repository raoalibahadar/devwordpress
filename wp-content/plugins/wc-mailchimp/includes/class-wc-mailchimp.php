<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wordpress.org/
 * @since      1.0.0
 *
 * @package    Wc_Mailchimp
 * @subpackage Wc_Mailchimp/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wc_Mailchimp
 * @subpackage Wc_Mailchimp/includes
 * @author     WordPress <zahid.zee115@gmail.com>
 */
class Wc_Mailchimp {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Wc_Mailchimp_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if (defined('WC_MAILCHIMP_VERSION')) {
            $this->version = WC_MAILCHIMP_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'wc-mailchimp';

        // -> Subscrbe mailchimp on order place
        add_filter('woocommerce_checkout_order_processed', [$this, 'subscribe'], 10, 3);

        // -> Add setting section
        add_filter('woocommerce_get_sections_products', [$this, 'add_settings_tab']);
        // ->
        add_filter('woocommerce_get_settings_products', [$this, 'get_settings'], 10, 2);

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /*
     * Add settings tab
     */

    public function add_settings_tab($settings_tab) {
        $settings_tab['wc_mailchimp_setting'] = __('Mailcihmp');
        return $settings_tab;
    }

    /*
     * Adding fields to the custom settings page
     */

    public function get_settings($settings, $current_section) {
        $custom_settings = array();
        if ('wc_mailchimp_setting' == $current_section) {

            $custom_settings = array(
                array(
                    'name' => __('Mailchimp API Key'),
                    'type' => 'text',
                    'desc_tip' => true,
                    'desc' => __('Enter your Mailcimp API Key'),
                    'id' => 'wc_mailchimp_api_key'
                ),
                array(
                    'name' => __('List ID'),
                    'type' => 'text',
                    'desc_tip' => true,
                    'desc' => __('Enter Mailcimp list ID'),
                    'id' => 'wc_mailchimp_list_id'
                ),
                array('type' => 'sectionend', 'id' => 'wc_mailchimp'),
            );

            return $custom_settings;
        } else {
            return $settings;
        }
    }

    /*
     * Subscrbe mailchimp on order place
     */

    public function subscribe($order_id, $posted_data, $order) {
        $apikey = get_option('wc_mailchimp_api_key', '');
        $mailing_list_id = get_option('wc_mailchimp_list_id', '');
        $MailChimp = new \DrewM\MailChimp\MailChimp($apikey);
        $email = $order->get_billing_email();
        $first_name = $order->get_billing_first_name();
        $last_name = $order->get_billing_last_name();
        if (!empty($apikey) && !empty($mailing_list_id)) {
            try {
                $result = $MailChimp->post("lists/$mailing_list_id/members", [
                    'merge_fields' => ['FNAME' => $first_name, 'LNAME' => $last_name],
                    'email_address' => $email,
                    'status' => 'subscribed',
                ]);

                if ($result['status'] == 'subscribed') {
                    // Do some thing on successfull subscription
                } else if ($result['status'] == '400') {
                    // Do some thing user already exists
                } else {
                    throw new Exception;
                }
            } catch (Exception $e) {

            }
        }
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Wc_Mailchimp_Loader. Orchestrates the hooks of the plugin.
     * - Wc_Mailchimp_i18n. Defines internationalization functionality.
     * - Wc_Mailchimp_Admin. Defines all hooks for the admin area.
     * - Wc_Mailchimp_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wc-mailchimp-loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/MailChimp.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wc-mailchimp-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wc-mailchimp-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wc-mailchimp-public.php';

        $this->loader = new Wc_Mailchimp_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Wc_Mailchimp_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Wc_Mailchimp_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {

        $plugin_admin = new Wc_Mailchimp_Admin($this->get_plugin_name(), $this->get_version());

        // $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        // $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Wc_Mailchimp_Public($this->get_plugin_name(), $this->get_version());

        //$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        //$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Wc_Mailchimp_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
