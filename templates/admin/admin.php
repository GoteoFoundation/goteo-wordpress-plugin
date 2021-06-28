<!-- <h2> Admin Goteo Plugin </h2> -->

<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

<?php if (Goteo::http_client()->login()): ?>

  <?php
   $matcher = MatcherRepository::get(get_option('goteo_user'));
   ?>

  <h3> <?php echo __('Datos', 'goteo') ?> </h3>

  <div class="goteo-matcher-data">
    <ul>
      <li>
          <p><b> <?php echo __('Saldo comprometido', 'goteo') ?> </b></p>

          <p> <?= wc_price( goteo_calculate_amount() ); ?> </p>
      </li>

      <li>
          <p><b> <?php echo __('Saldo enviado a Goteo', 'goteo') ?> </b></p>

          <p> <?= wc_price($matcher->{'amount-available'}, array('decimals' => 0)); ?> </p>
      </li>

      <?php if (goteo_woodonation_active() and get_option('goteo_woodonation_connection')): ?>
        <li>
          <h3> <?php echo __('Donaciones a través de Woo Donations', 'goteo') ?> </h3>

          <p> <?= wc_price( goteo_pending_amount($matcher) ) ?> </p>

          <div class="goteo-button">
            <a href="<?= get_option('goteo_base_url') ?>/pool?amount=<?php echo goteo_calculate_amount() - $matcher->{'amount-available'} ?>">
              <button class="goteo-button btn-lg btn-lilac"><?= __('DONATE', 'goteo') ?></button>
             </a>
          </div>
        </li>
      <?php else: ?>
        <li>
          <p><b> <?php echo __('Saldo pendiente de enviar', 'goteo') ?> </b></p>

          <p> <?= wc_price( goteo_pending_amount($matcher) ) ?> </p>

          <div class="goteo-button">
            <a href="<?= get_option('goteo_base_url') ?>/pool?amount=<?php echo goteo_calculate_amount() - $matcher->{'amount-available'} ?>">
              <button class="goteo-button btn-lg btn-lilac"><?= __('DONATE', 'goteo') ?></button>
            </a>
          </div>
        </li>
      <?php endif; ?>
    </ul>
  </div>

    


  <?php
    $projects = MatcherProjectRepository::getProjects($matcher->id);
    if ($projects):
  ?>

    <hr>

    <?php require_once 'partials/projects_widget.php'; ?>

    <hr>

    <?php require_once 'partials/map.php'; ?>
  
  <?php endif; ?>

<?php endif; ?>
