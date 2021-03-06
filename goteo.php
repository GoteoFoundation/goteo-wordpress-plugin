<?php
/*
 Plugin Name: Goteo plugin
 Plugin URI: https://github.com/GoteoFoundation/goteo-wordpress-plugin
 Description: This Wordpress - Woocommerce plugin connects a marketplace to the crowdfunding platform Goteo.org
 Version: 0.3
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
  delete_option( 'goteo_date' );
  delete_option( 'goteo_comission' );
  delete_option( 'goteo_base_url' );
  delete_option( 'goteo_base_api_url' );
  delete_option( 'goteo_key' );
  delete_option( 'goteo_user' );
}

function goteo_load_plugin_textdomain() {
    load_plugin_textdomain('goteo', false, basename( dirname( __FILE__ )) . '/languages');
}
add_action('plugins_loaded', 'goteo_load_plugin_textdomain');



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

  return round(($total * get_option('goteo_comission') / 100), 0);
}

function goteo_pending_amount($matcher) {
  $calculated_amount = goteo_calculate_amount();

  return ($calculated_amount - $matcher->{'amount-available'}) > 0?
            $calculated_amount - $matcher->{'amount-available'} : 0;
}

function goteo_woodonation_active() {

  return  in_array( 
    'woo-donations/woo-donations.php',
    apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
  );
}

function goteo_calculate_donations() {
  $orders = wc_get_orders( 
      array( 
        'status' => 'wc-completed',
        'type' => 'shop_order',
        'date_created' => '>=' . get_option('goteo_date')
      )
    );

    $total = 0;

    $product="";
    $options= wdgk_get_wc_donation_setting();
    if(isset($options['Product'])){
      $product = $options['Product'];
    }

    foreach($orders as $order) {
      foreach( $order->get_items() as $order_item ) {
        if($product==$order_item['product_id']) {
          $total += $order_item['quantity'] * $order_item['subtotal'];
        }

      }
    }
 
    return $total;
}

register_activation_hook( __FILE__, 'activate');

register_deactivation_hook( __FILE__, 'deactivate');

register_uninstall_hook(__FILE__, 'uninstall');
