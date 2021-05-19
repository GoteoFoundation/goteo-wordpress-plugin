<!-- <h2> Admin Goteo Plugin </h2> -->

<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

<?php if (Goteo::http_client()->login()): ?>

  <?php
   $matcher = MatcherRepository::get(get_option('goteo_user'));
   ?>

  <div class="goteo-matcher-data">
    <div class="wrap">
      <h2> <?php echo __('Saldo comprometido', 'goteo') ?> </h2>

      <div class="">
        <?php // TODO: Integrate with the WooCommerce API
            $my_posts = wc_get_orders( 
                array( 
                  'status' => 'wc-completed',
                  'type' => 'shop_order',
                  'date_created' => '>=' . get_option('goteo_date')
                )
              );

            $total = 0;
            foreach ($my_posts as $order) {
              $total += $order->calculate_totals();
            }
        ?>

        <h2> <?= wc_price(round($total * get_option('goteo_comission')), array('decimals' => 0)); ?> </h2>
      </div>
    </div>

    <div class="wrap">
      <h2> <?php echo __('Saldo enviado a Goteo', 'goteo') ?> </h2>

      <h2> <?php echo wc_price($matcher->{'amount-available'}, array('decimals' => 0)); ?> </h2>
    </div>

    <div class="wrap">
      <h2> <?php echo __('Saldo pendiente de enviar', 'goteo') ?> </h2>

      <div class="">
        <h2> <?php echo wc_price(round($total * get_option('goteo_comission') - $matcher->{'amount-available'}), array('decimals' => 0)); ?> </h2>
      </div>

      <div class="goteo-button">
            <a href="<?= get_option('goteo_base_url') ?>/pool?amount=<?= round($total * get_option('goteo_comission') - $matcher->{'amount-available'}) ?>">
              <button class="goteo-button btn-lg btn-lilac"><?= __('DONATE', 'goteo') ?></button>
            </a>
      </div>
    </div>
  </div>

  <?php
    $projects = MatcherProjectRepository::getProjects($matcher->id);
    if ($projects):
  ?>
    <?php require_once 'partials/projects_widget.php'; ?>

    <?php require_once 'partials/map.php'; ?>
  
  <?php endif; ?>

<?php endif; ?>
