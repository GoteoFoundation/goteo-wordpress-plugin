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
      __( 'Comisión para la plataforma', 'goteo' ),
      array($this, 'my_setting_markup'),
      'goteo-settings',
      'goteo-main-settings',
      [
        'label_for' => 'goteo_comission'
      ]
    );

    add_settings_field(
      'goteo_date',
      __( 'Fecha de inicio de donaciones', 'goteo'),
      array($this, 'date_definition_markup'),
      'goteo-settings',
      'goteo-main-settings',
      [
        'label_for' => 'goteo_date' 
      ]
    );

    if (goteo_woodonation_active()) {
      add_settings_field(
        'goteo_woodonation_connection',
        __( 'Connexión con WooDonation', 'goteo'),
        array($this, 'woodonation_connection_markup'),
        'goteo-settings',
        'goteo-main-settings'
      );
    } else {
      add_settings_field(
        'goteo_woodonation_connection',
        __( 'Connexión con WooDonation', 'goteo'),
        array($this, 'woodonation_connection_markup_disabled'),
        'goteo-settings',
        'goteo-main-settings'
      );
    }

    register_setting( 'goteo-settings', 'goteo_woodonation_connection');
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
      __( 'Url base de la plataforma Goteo ', 'goteo' ),
      array($this, 'goteo_base_url_markup'),
      'goteo-apikey',
      'goteo-apikey-settings',
      [
        'label_for' => 'goteo_base_url' 
      ]

    );

    add_settings_field(
      'API URL de la plataforma Goteo',
      __( 'API Base Url', 'goteo' ),
      array($this, 'goteo_base_api_url_markup'),
      'goteo-apikey',
      'goteo-apikey-settings',
       [
        'label_for' => 'goteo_base_api_url' 
      ]
    );

    add_settings_field(
      'goteo_user',
      __( 'User', 'goteo' ),
      array($this, 'goteo_user_markup'),
      'goteo-apikey',
      'goteo-apikey-settings',
       [
        'label_for' => 'goteo_user' 
      ]
    );

    add_settings_field(
      'goteo_key',
      __( 'Key', 'goteo'),
      array($this, 'goteo_apikey_markup'),
      'goteo-apikey',
      'goteo-apikey-settings',
       [
        'label_for' => 'goteo_key' 
      ]
    );

    register_setting( 'goteo-apikey', 'goteo_base_url' );
    register_setting( 'goteo-apikey', 'goteo_base_api_url' );
    register_setting( 'goteo-apikey', 'goteo_user' );
    register_setting( 'goteo-apikey', 'goteo_key');
  }

  function woodonation_connection_markup() {
    ?>
    <input type="checkbox" id="goteo_date" name="goteo_woodonation_connection" <?= get_option( 'goteo_woodonation_connection' ) ?  'checked=true' : '' ?> >
    <?php
  }

  function woodonation_connection_markup_disabled() {
    ?>
    <p><?= __('Puedes activar esta opción instalando WooDonation', 'Goteo') ?></p>
    <input type="checkbox" id="goteo_date" name="goteo_woodonation_connection" disabled >
    <?php
  }


  function date_definition_markup() {
    ?>
    <input type="date" id="goteo_date" name="goteo_date" value="<?php echo get_option( 'goteo_date' ) ? get_option('goteo_date') : date('Y-m-d'); ?>" required>
    <?php
  }

  function my_setting_markup() {
    ?>
    <input type="number" id="goteo_comission" name="goteo_comission" step="0.1" min=0 max=100 value="<?php echo get_option( 'goteo_comission' ); ?>" placeholder="0,5" required>
    <?php
  }

  function goteo_base_url_markup() {
    ?>
    <input type="url" id="goteo_base_url" name="goteo_base_url" value="<?php echo get_option( 'goteo_base_url' ); ?>" placeholder="https://goteo.org" required>
    <?php

  }

  function goteo_base_api_url_markup() {
    ?>
    <input type="url" id="goteo_base_api_url" name="goteo_base_api_url" value="<?php echo get_option( 'goteo_base_api_url' ); ?>" placeholder="https://api.goteo.org/v1" required>
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