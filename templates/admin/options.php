<div class="goteo-settings">
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

        <?php if (get_option('goteo_token')): ?>
        <div id="infoMessages" class="notice notice-info">
          <?php
              echo __('Success autenticating', 'goteo');
          ?>
        </div>
      <?php endif; ?>
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
  </div>
</div>