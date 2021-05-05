<?php
/*
 Plugin Name: Goteo plugin
 Plugin URI: https://git.goteo.org/dev/goteo-wordpress-plugin
 Description: This Wordpress - Woocommerce plugin connects a marketplace to the crowdfunding platform Goteo.org
 Version: 0.0.1
 Author: Platoniq Foundation, Goteo
 Author URI: https://goteo.org
 License: GNU Public License v3
 Domain Path: /languages
 */

 if ( ! defined( 'ABSPATH' ) ) {
   die;
 }

 require_once __DIR__ . '/src/Goteo.php';
 require_once __DIR__ . '/src/Goteo_HttpClient.php';
 require_once __DIR__ . '/src/Models/Matcher.php';
 require_once __DIR__ . '/src/Models/Project.php';
 require_once __DIR__ . '/src/Repositories/MatcherRepository.php';
 require_once __DIR__ . '/src/Repositories/MatcherProjectsRepository.php';

 if (is_admin()) {
   require_once __DIR__ . '/src/GoteoSettingsPage.php';
   $settings_page = new GoteoSettingsPage();
   add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $settings_page, 'add_action_link'));
  }


if ( class_exists('Goteo')) {
  $goteo = new Goteo();
  $goteo->register();
}


function activate() {
  flush_rewrite_rules();
}

function deactivate() {
  flush_rewrite_rules();
}

function uninstall() {
}

register_activation_hook( __FILE__, 'activate');

register_deactivation_hook( __FILE__, 'deactivate');

// register_uninstall_hook(__FILE__, 'uninstall');