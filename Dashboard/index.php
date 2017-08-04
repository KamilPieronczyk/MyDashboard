<?php require 'main-functions.php'; ?>
<?php get_header() ?>
<?php get_template_part_replace('templates/dashboard','top',array(
  'main' => 'Dashboard',
  'small' => 'Manage your website',
  'icon' => 'fa-cog'
)); ?>
<?php go_to_sign_in(); ?>

<section id="breadcrumb">
  <div class="container">
    <?php get_alerts() ?>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Home </li>
    </ol>
  </div>
</section>

<section id="main">
  <div class="container">
    <div class="row">

      <div class="col-md-3">
        <?php get_template_part('templates/dashboard','menu') ?>
      </div>

      <div class="col-md-9">
        <?php get_template_part('templates/dashboard','overview') ?>
        <?php get_template_part('templates/dashboard','latestusers') ?>
      </div>

    </div>
  </div>
</section>


<?php get_footer() ?>
