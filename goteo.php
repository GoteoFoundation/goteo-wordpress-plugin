<?php
/*
 Plugin Name: Goteo plugin
 Plugin URI: https://git.goteo.org/dev/goteo-wordpress-plugin
 Description: This Wordpress - Woocommerce plugin connects a marketplace to the crowdfunding platform Goteo.org
 Version: 0.0.2
 Author: Platoniq Foundation, Goteo
 Author URI: https://goteo.org
 License: GNU Public License v3
 Domain Path: /languages
 */

 if ( ! defined( 'ABSPATH' ) ) {
  die;
 }

 if ( ! in_array( 
    'woocommerce/woocommerce.php',
    apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
  ) ) {
    die;
  }

 require_once __DIR__ . '/src/Goteo.php';
 require_once __DIR__ . '/src/Goteo_HttpClient.php';
 require_once __DIR__ . '/src/Models/Matcher.php';
 require_once __DIR__ . '/src/Models/Project.php';
 require_once __DIR__ . '/src/Repositories/MatcherRepository.php';
 require_once __DIR__ . '/src/Repositories/MatcherProjectsRepository.php';

if ( class_exists('Goteo')) {
  $goteo = new Goteo();
  $goteo->register();
}

if (is_admin()) {
  require_once __DIR__ . '/src/GoteoSettingsPage.php';
  $settings_page = new GoteoSettingsPage();
  add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $settings_page, 'add_action_link'));
 }

function activate() {
  flush_rewrite_rules();
}

function deactivate() {
  flush_rewrite_rules();
}

function uninstall() {
}

function goteo_calculate_amount() {
  $orders = wc_get_orders( 
    array( 
      'status' => 'wc-completed',
      'type' => 'shop_order',
      'date_created' => '>=' . get_option('goteo_date')
    )
  );

  $total = 0;
  foreach ($orders as $order) {
    $total += $order->calculate_totals();
  }

  return round(($total * get_option('goteo_comission') / 100), array('decimals' => 0));
}

function goteo_pending_amount($matcher) {
  $calculated_amount = goteo_calculate_amount();

  return ($calculated_amount - $matcher->{'amount-available'}) > 0?
            $calculated_amount - $matcher->{'amount-available'} : 0;
}

register_activation_hook( __FILE__, 'activate');

register_deactivation_hook( __FILE__, 'deactivate');

// register_uninstall_hook(__FILE__, 'uninstall');
