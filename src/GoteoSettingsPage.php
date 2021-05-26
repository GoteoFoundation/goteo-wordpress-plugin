<?php

class GoteoSettingsPage {

  private $page = 'goteo-settings';

  public function __construct() {
    add_action( 'admin_menu' , array($this, 'add_submenu_settings_page'));

    add_filter( 'plugin_action_links_' . $this->plugin, array( $this, 'settings_link'));

    add_action( 'admin_init', array($this, 'goteo_settings_init'));

    add_action( 'admin_init', array($this, 'goteo_api_init'));
 }

 public function add_submenu_settings_page() {
  add_submenu_page(
    'goteo_plugin',
    __('Settings', 'goteo'),
    __('Settings', 'goteo'),
    'manage_options', 
    'goteo_plugin_settings', 
    array($this, 'submenu_page')
  );
 }

  public function submenu_page() {
    if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    
    require_once plugin_dir_path(__DIR__) . 'templates/admin/options.php';
  }

  public function add_action_link() {
    $settings_link = "<a href='admin.php?page=$this->page'>Settings</a>";
    array_push($links, $settings_link);
    return $links;
  }

  public function goteo_settings_init() {
    add_settings_section(
      'goteo-main-settings',
      __( 'Goteo Plugin Settings', 'goteo' ),
      array($this, 'goteo_settings_callback_function'),
      'goteo-settings'
    );

    add_settings_field(
      'goteo_comission',
      __( 'Comisión', 'goteo' ),
      array($this, 'my_setting_markup'),
      'goteo-settings',
      'goteo-main-settings'
    );

    add_settings_field(
      'goteo_date',
      __( 'Fecha', 'goteo'),
      array($this, 'date_definition_markup'),
      'goteo-settings',
      'goteo-main-settings'
    );

    register_setting( 'goteo-settings', 'goteo_comission' );
    register_setting( 'goteo-settings', 'goteo_date');
  }

  function goteo_api_init() {
    add_settings_section(
      'goteo-apikey-settings',
      __( 'Goteo API KEY Settings', 'goteo' ),
      array($this, 'goteo_apikey_callback_function'),
      'goteo-apikey'
    );

    add_settings_field(
      'goteo_base_url',
      __( 'Base Url ', 'goteo' ),
      array($this, 'goteo_base_url_markup'),
      'goteo-apikey',
      'goteo-apikey-settings'
    );

    add_settings_field(
      'goteo_base_api_url',
      __( 'API Base Url', 'goteo' ),
      array($this, 'goteo_base_api_url_markup'),
      'goteo-apikey',
      'goteo-apikey-settings'
    );

    add_settings_field(
      'goteo_user',
      __( 'User', 'goteo' ),
      array($this, 'goteo_user_markup'),
      'goteo-apikey',
      'goteo-apikey-settings'
    );

    add_settings_field(
      'goteo_key',
      __( 'Key', 'goteo'),
      array($this, 'goteo_apikey_markup'),
      'goteo-apikey',
      'goteo-apikey-settings'
    );

    register_setting( 'goteo-apikey', 'goteo_base_url' );
    register_setting( 'goteo-apikey', 'goteo_base_api_url' );
    register_setting( 'goteo-apikey', 'goteo_user' );
    register_setting( 'goteo-apikey', 'goteo_key');
  }

  function date_definition_markup() {
    ?>
    <input type="date" id="goteo_date" name="goteo_date" value="<?php echo get_option( 'goteo_date' ); ?>" required>
    <?php
  }

  function my_setting_markup() {
    ?>
    <input type="number" id="goteo_comission" name="goteo_comission" step="0.1" min=0 max=100 value="<?php echo get_option( 'goteo_comission' ); ?>" required>
    <?php
  }

  function goteo_base_url_markup() {
    ?>
    <input type="url" id="goteo_base_url" name="goteo_base_url" value="<?php echo get_option( 'goteo_base_url' ); ?>" required>
    <?php

  }

  function goteo_base_api_url_markup() {
    ?>
    <input type="url" id="goteo_base_api_url" name="goteo_base_api_url" value="<?php echo get_option( 'goteo_base_api_url' ); ?>" required>
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

  function goteo_settings_callback_function( $args ) {
    echo __('<p>El % de comisión que escojas se utilizará para calcular la cantidad de dinero que puedes donar a través de <a href="https://goteo.org">Goteo.org</a></p>', 'goteo');
  }

  function goteo_apikey_callback_function( $args ) {
    echo __('<p>Las credenciales introducidas se usarán para conectarse a la plataforma <a href="https://goteo.org">Goteo.org</a></p>', 'goteo');
  }

}