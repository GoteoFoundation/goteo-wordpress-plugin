<?php

?>

<div class="wrap">
  <h2> <?php echo __('Mapa de impacto', 'goteo') ?> </h2>

  <iframe src="<?= get_option('goteo_base_url') ?>/map?channel=<?= $matcher->{'id'} ?>" style="border:none;" allowfullscreen="" width="100%" height="500"></iframe>
</div>