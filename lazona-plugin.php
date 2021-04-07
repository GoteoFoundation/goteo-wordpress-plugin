<?php
/*
 Plugin Name: Goteo LaZona plugin
 Plugin URI: https://git.goteo.org/dev/la-zona
 Description: This Wordpress - Woocommerce plugin connects a marketplace to the crowdfunding platform Goteo.org
 Version: 0.0.1
 Author: Platoniq Foundation, Goteo
 Author URI: https://goteo.org
 License: GNU Public License v3
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

    add_action('admin_menu', array($this, 'add_admin_pages'));

    add_filter("plugin_action_links_" . $this->plugin, array( $this, 'settings_link'));
  }

  public function settings_link($links) {
    $settings_link = '<a href="admin.php?page=goteo_lazona_plugin">Settigns</a>';
    array_push($links, $settings_link);
    return $links;
  }

  public function add_admin_pages() {
    add_menu_page('Crowdfunding Plugin', 'Crowdfunding', 'manage_options', 'goteo_lazona_plugin', array($this, 'admin_index'), plugins_url('/assets/icon/goteo.svg', __FILE__), 110);
  }

  public function admin_index() {
    require_once plugin_dir_path( __FILE__ ) . 'templates/admin/admin.php';
  }

  public function enqueue() {
    wp_enqueue_style('goteo_styles', plugins_url('/assets/goteo_styles.css', __FILE__));
    wp_enqueue_script('goteo_scripts', plugins_url('/assets/goteo_javascript.js', __FILE__));
  }

}

if ( class_exists('GoteoLaZona')) {
  $goteoLaZona = new GoteoLaZona();
  $goteoLaZona->register();
}

register_activation_hook( __FILE__, [$goteoLaZona, 'activate']);

register_deactivation_hook( __FILE__, [$goteoLaZona, 'deactivate']);

// register_uninstall_hook(__FILE__, [$goteoLaZona, 'uninstall']);