<?php
/*
 Plugin Name: Goteo LaZona plugin
 Plugin URI: https://git.goteo.org/dev/la-zona
 Description: This Wordpress - Woocommerce plugin connects a marketplace to the crowdfunding platform Goteo.org
 Version: 0.0.1
 Author: Platoniq Foundation, Goteo
 Author URI: https://goteo.org
 License: GNU Public License v3
 Domain: /languages
 */

 if ( ! defined( 'ABSPATH' ) ) {
   die;
 }

 class GoteoLaZona
{

  public $plugin;

  function __construct() {
    $this->plugin = plugin_basename(__FILE__);
  }

  public function activate() {
    flush_rewrite_rules();
  }

  public function deactivate() {
    flush_rewrite_rules();
  }

  public function uninstall() {

  }

  public function register() {
    add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    // add_action('wq_enqueue_scripts', array($this, 'enqueue'));

    add_action( 'admin_menu' , array($this, 'add_admin_pages'));

    add_filter( 'plugin_action_links_' . $this->plugin, array( $this, 'settings_link'));

    add_action( 'admin_init', array($this, 'my_settings_init'));

    add_action( 'admin_init', array($this, 'goteo_api_init'));
  }

  public function my_settings_init() {
    add_settings_section(
      'sample_page_setting_section',
      __( 'Goteo Plugin Settings', 'goteo-admin-setting' ),
      array($this, 'comission_callback_function'),
      'goteo-settings'
    );

    add_settings_field(
      'goteo_comission',
      __( 'Comisión', 'goteo-comission' ),
      array($this, 'my_setting_markup'),
      'goteo-settings',
      'sample_page_setting_section'
    );

    add_settings_field(
      'goteo_date',
      __( 'Fecha', 'goteo-date-definition'),
      array($this, 'date_definition_markup'),
      'goteo-settings',
      'sample_page_setting_section'
    );

    register_setting( 'goteo-settings', 'goteo_comission' );
    register_setting( 'goteo-settings', 'goteo_date');


  }

  function goteo_api_init() {
    add_settings_section(
      'goteo_page_api_section',
      __( 'Goteo API KEY Settings', 'goteo-admin-setting' ),
      array($this, 'apikey_callback_function'),
      'goteo-apikey'
    );

    add_settings_field(
      'goteo_user',
      __( 'User', 'goteo-user' ),
      array($this, 'goteo_user_markup'),
      'goteo-apikey',
      'goteo_page_api_section'
    );

    add_settings_field(
      'goteo_key',
      __( 'Key', 'goteo-key'),
      array($this, 'goteo_apikey_markup'),
      'goteo-apikey',
      'goteo_page_api_section'
    );

    register_setting( 'goteo-apikey', 'goteo_user' );
    register_setting( 'goteo-apikey', 'goteo_key');
  }

  function date_definition_markup() {
    ?>
    <!-- <label for="goteo_comission"><?php _e( 'Comisión', 'goteo-admin-setting-comission' ); ?></label> -->
    <input type="date" id="goteo_date" name="goteo_date" value="<?php echo get_option( 'goteo_date' ); ?>" required>
    <?php
  }

  function my_setting_markup() {
    ?>
    <!-- <label for="goteo_comission"><?php _e( 'Comisión', 'goteo-admin-setting-comission' ); ?></label> -->
    <input type="number" id="goteo_comission" name="goteo_comission" step="0.1" value="<?php echo get_option( 'goteo_comission' ); ?>" required>
    <?php
  }

  function goteo_apikey_markup() {
    ?>
    <input type="text" id="goteo_key" name="goteo_key" value="<?php echo get_option( 'goteo_key' ); ?>" required>
    <?php

  }

  function goteo_user_markup() {
    ?>
    <input type="text" id="goteo_user" name="goteo_user" value="<?php echo get_option( 'goteo_user' ); ?>" required>
    <?php
  }


  function comission_callback_function( $args ) {
    echo '<p>El % de comisión que escojas se utilizará para calcular la cantidad de dinero que puedes donar a través de <a href="https://goteo.org">Goteo.org</a></p>';
  }
  

  public function settings_link($links) {
    $settings_link = '<a href="admin.php?page=goteo_lazona_plugin">Settings</a>';
    array_push($links, $settings_link);
    return $links;
  }

  // deals with the routing of the admin menu to the admin_index
  public function add_admin_pages() {
    add_menu_page('Crowdfunding Plugin', 'Crowdfunding', 'manage_options', 'goteo_lazona_plugin', array($this, 'admin_index'), plugins_url('/assets/icon/goteo.svg', __FILE__), 110);
  }

  public function admin_index() {
    require_once plugin_dir_path( __FILE__ ) . 'templates/admin/admin.php';
  }

  public function enqueue() {
    wp_enqueue_style('goteo_styles', plugins_url('/assets/goteo_styles.css', __FILE__));
    wp_enqueue_script('gotoe_javascript', plugins_url('/assets/goteo_javascript.js', __FILE__));
    wp_enqueue_script('goteo_api', plugins_url('/assets/goteo_api.js', __FILE__));
  }

}


if ( class_exists('GoteoLaZona')) {
  $goteoLaZona = new GoteoLaZona();
  $goteoLaZona->register();
}

register_activation_hook( __FILE__, [$goteoLaZona, 'activate']);

register_deactivation_hook( __FILE__, [$goteoLaZona, 'deactivate']);

// register_uninstall_hook(__FILE__, [$goteoLaZona, 'uninstall']);