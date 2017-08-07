<?php require '../main-functions.php'; ?>
<?php get_header() ?>
<?php get_template_part_replace('templates/dashboard','top',array(
  'main' => 'Error 404',
  'small' => '',
  'icon' => 'fa-error'
)); ?>
<?php go_to_sign_in(); ?>

<section id="breadcrumb">
  <div class="container">
    <?php get_alerts() ?>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo get_directory()?>">Home </a></li>
      <li class="breadcrumb-item active">Pages </li>
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
        <div class="card">

          <div class="card-header bg-main white">
            Error 404
          </div>

          <div class="card-body text-center">
            <h1>Error 404</h1>
            <p><?php echo get_error404_message() ?></p>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger">Warning</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <span id='page-title'></span>?</p>
      </div>
      <div class="modal-footer">
        <a href="" class="btn btn-danger" id="btn-delete">Delete</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  function send_href(btn) {
    var href = btn.href;
    $('#btn-delete').attr('href',href);
    var x = btn.parentNode;
    var y = x.parentNode;
    var z = y.children;
    var text = z[0].innerHTML;
    $('#page-title').text(text);
  }
</script>

<?php get_footer() ?>
