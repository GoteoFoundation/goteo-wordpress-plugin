<?php

?>

<div class="wrap">
    <h2> <?php echo __('Proyectos beneficiarios', 'goteo') ?> </h2>

    <div class="">
      <div class="goteo-project-mosaic">
      <?php foreach ($projects as $project) :?>
        <iframe frameborder="0" height="492px" src="<?php echo get_option('goteo_base_url') . "/widget/" . $project->id ?>" width="300px" scrolling="no"></iframe>
      <?php endforeach; ?>
    </div>
  </div>
</div>