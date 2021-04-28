<!-- <h1> Admin Goteo Plugin </h1> -->

<div class="wrap">
  <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
  <form action="options.php" method="post">
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
  <form action="options.php" method="GET" onsubmit="checkApiKey(event)">

    <?php

      $valid_auth = false;
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.goteo.org/v1/login",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_USERPWD => get_option('goteo_user') . ":" . get_option('goteo_key'),
        CURLOPT_HTTPAUTH, CURLAUTH_BASIC
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);

      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        $valid_auth = true;
        $response_json = json_decode($response);
        add_option( 'goteo_token', $response_json->access_token);
      }

    ?>
    <div id="infoMessages" class=""></div>

    <?php
      settings_fields( 'goteo-apikey' );
      // output setting sections and their fields
      // (sections are registered for "goteo-settings", each field is registered to a specific section)
      do_settings_sections( 'goteo-apikey' );
      // output save settings button

      submit_button( 'Save API Credentials');

      submit_button( 'Check API' , 'primary', 'check_api');
      ?>
  </form>
<div>