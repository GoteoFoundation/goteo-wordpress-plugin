<?php

 class Goteo
 {
   private static $http_client;

   public $plugin;
 
   function __construct() {
     $this->plugin = plugin_basename(__FILE__);
   }

   public static function http_client()
   {
       if (!self::$http_client) {
           self::$http_client = new Goteo_HttpClient();
       }

       return self::$http_client;
   }

   public function register() {
     add_action('admin_enqueue_scripts', array($this, 'enqueue'));
     // add_action('wq_enqueue_scripts', array($this, 'enqueue'));
 
     add_action( 'admin_menu' , array($this, 'add_admin_pages'));
   }
  
   // deals with the routing of the admin menu to the admin_index
   public function add_admin_pages() {
     add_menu_page(
      __('Crowdfunding Plugin', 'goteo'),
      __('Crowdfunding','goteo'),
      'manage_options',
      'goteo_plugin',
      array($this, 'admin_index'),
      plugins_url('/assets/icon/goteo.svg', __DIR__));

   }
 
   public function admin_index() {
    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

     require_once plugin_dir_path( __DIR__ ) . 'templates/admin/admin.php';
   }
 
   public function enqueue() {
     wp_enqueue_style('goteo_styles', plugins_url('/assets/goteo_styles.css', __DIR__ ));
     wp_enqueue_script('gotoe_javascript', plugins_url('/assets/goteo_javascript.js', __DIR__));
     wp_enqueue_script('goteo_api', plugins_url('/assets/goteo_api.js', __DIR__));
   }
 
 }