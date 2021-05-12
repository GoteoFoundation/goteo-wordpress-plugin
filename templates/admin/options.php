<div class="goteo-settings">
  <div class="wrap">
    <form action="options.php" method="POST">
        <?php
          settings_fields( 'goteo-settings' );
          do_settings_sections( 'goteo-settings' );
          
          submit_button( __('Save Settings', 'goteo') );
        ?>
    </form>
  </div>

  <div class="wrap">
    <form action="options.php" method="POST" onsubmit="checkApiKey()">

        <div id="infoMessages" class=""></div>

      <?php
        settings_fields( 'goteo-apikey' );
        do_settings_sections( 'goteo-apikey' );

        submit_button( __('Save API Credentials', 'goteo') );
        submit_button( __('Check API') , 'primary', 'check_api', true, array('onsubmit' => 'checkApiKey()'));
        ?>
    </form>
  </div>
</div>