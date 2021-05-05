<!-- <h2> Admin Goteo Plugin </h2> -->

<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

<?php $matcher = MatcherRepository::get('fabraicoats'); ?>

<div class="goteo-matcher-data">
  <div class="wrap">
    <h2> <?php echo __('Saldo comprometido', 'goteo') ?> </h2>

    <div class="">
          <?php // TODO: Integrate with the WooCommerce API ?>
    </div>
  </div>

  <div class="wrap">
    <h2> <?php echo __('Saldo enviado a Goteo', 'goteo') ?> </h2>

    <h2> <?php echo $matcher->{'amount-available'}; ?> </h2>
  </div>

  <div class="wrap">
    <h2> <?php echo __('Saldo pendiente de enviar', 'goteo') ?> </h2>

    <div class="">
          <?php ?>
    </div>
  </div>
</div>

<div class="wrap">
  <h2> <?php echo __('Proyectos beneficiarios', 'goteo') ?> </h2>

  <div class="">
    <?php $projects = MatcherProjectRepository::getProjects($matcher->id); ?>
    <div class="goteo-project-mosaic">
    <?php foreach ($projects as $project) :?>
      <iframe frameborder="0" height="492px" src="//ca.goteo.org/widget/project/<?= $project->id ?>?lang=ca" width="300px" scrolling="no"></iframe>
    <?php endforeach; ?>
    </div>
  </div>
</div>

<div class="wrap">
  <h2> <?php echo __('Mapa de impacto', 'goteo') ?> </h2>

  <iframe src="https://goteo.org/map/8/41.745186118683,1.7299261914344?channel=fabraicoats" style="border:none;" allowfullscreen="" width="100%" height="500"></iframe>
</div>