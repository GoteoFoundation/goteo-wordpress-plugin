<!-- <h1> Admin Goteo Plugin </h1> -->

<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

<div class="wrap">
  <form action="options.php" method="POST">
      <?php
      // output security fields for the registered setting "wporg"
        settings_fields( 'goteo-settings' );
        // output setting sections and their fields
        // (sections are registered for "goteo-settings", each field is registered to a specific section)
        do_settings_sections( 'goteo-settings' );
        // output save settings button
        submit_button( 'Save Settings' );
      ?>
  </form>
</div>

<div class="wrap">
  <form action="options.php" method="POST">

    <?php

      $args = array(
        'headers' => array(
          'Authorization' => 'Basic ' . base64_encode( get_option('goteo_user') . ":" . get_option('goteo_key') )
          )
        );

      $response = wp_remote_get(
        'https://api.goteo.org/v1/login',
        $args
      );

      $http_code = wp_remote_retrieve_response_code($response);

      if ($http_code == 200) {
        $access_token = json_decode(wp_remote_retrieve_body($response))->access_token;
        add_option('goteo_token', $access_token);
      } else {
        add_option('goteo_token', null);
      }

    ?>
    <div id="infoMessages" class="<?= (get_option('goteo_token'))? "notice notice-success": "notice notice-error"; ?>">
      <?php
        if (get_option('goteo_token')):
          echo "Success autenticating";
        else:
          echo "Error autenticating";
        endif;
      ?>
    </div>

    <?php
      settings_fields( 'goteo-apikey' );
      // output setting sections and their fields
      // (sections are registered for "goteo-settings", each field is registered to a specific section)
      do_settings_sections( 'goteo-apikey' );
      // output save settings button

      submit_button( 'Save API Credentials');

      // submit_button( 'Check API' , 'primary', 'check_api');
      ?>
  </form>
<div>


<div class="wrap">

  <h1> Saldo comprometido </h1>

  <div class="">
        <?php
          // TODO: Integrate with the WooCommerce API
        ?>
  </div>

</div>

<div class="wrap">

  <h1> Saldo enviado a Goteo </h1>

  <div class="">
        <?php

        ?>
  </div>
  
</div>

<div class="wrap">

  <h1> Saldo pendiente de enviar </h1>

  <div class="">
        <?php

        ?>
  </div>
  
</div>

<div class="wrap">

  <h1> Proyectos beneficiarios </h1>

  <div class="">
    <?php
      $projects_response = wp_remote_get(
        'https://api.goteo.org/v1/matchers/' . get_option('goteo_user'). '/projects',
        $args
      );

      $projects = json_decode(wp_remote_retrieve_body($projects_response));

    ?>
    <div class="goteo-project-mosaic">
    <?php
      foreach ($projects->items as $project) :
    ?>
      <iframe frameborder="0" height="492px" src="//ca.goteo.org/widget/project/<?= $project->id ?>?lang=ca" width="300px" scrolling="no"></iframe>
    <?php
      endforeach;
    ?>
    </div>
  </div>
  
</div>