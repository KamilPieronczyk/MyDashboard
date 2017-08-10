<?php require '../../main-functions.php'; ?>
<?php get_header() ?>
<?php get_template_part_replace('templates/dashboard','top',array(
  'main' => 'Posts',
  'small' => 'Edit posts',
  'icon' => 'fa-pencil'
)); ?>
<?php go_to_sign_in(); ?>
<?php if (!check_user_permission(50)) {
  set_alert(array(
    'type' => 'warning',
    'title' => 'Oo',
    'content' => "You don't have enough permission to edit posts"
  ));
  header_location(get_directory().'/pages/posts.php');
} ?>
<?php $post = new Post; ?>
<?php $post->get_post($_GET['post_id']);
  if (!check_user_permission(50)) {
    set_alert(array(
      'type' => 'warning',
      'title' => 'Oo',
      'content' => "You don't have enough permission to edit this post"
    ));
    header_location(get_directory().'/pages/posts.php');
  }
?>

<section id="breadcrumb">
  <div class="container">
    <?php get_alerts() ?>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo get_directory()?>">Home </a></li>
      <li class="breadcrumb-item"><a href="<?php echo get_directory()?>/pages/posts.php">Posts </a></li>
      <li class="breadcrumb-item active">Edit </li>
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
            Posts
          </div>

          <div class="card-body p-3">
            <form  method="POST" action="<?php echo get_directory()?>/option.php?form=post_edit" enctype="multipart/form-data">
              <fieldset class="form-group">
                <label for="page-title"><h5>Post title</h5></label>
                <input type="text" class="form-control" name="title" id="page-title" value="<?=$post->get_title() ?>">
                <small class="text-muted">This will be show in the title attribute</small>
              </fieldset>
              <fieldset class="form-group">
                <label for="page-content"><h5>Content</h5></label>
                <textarea class="form-control" id="post-content" name="content" rows="3"><?php echo $post->get_content() ?></textarea>
                <script>
                  CKEDITOR.replace( 'post-content' );
                </script>
              </fieldset>
              <fieldset>
                <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="published" <?php echo ($post->get_published() == 1) ? 'checked' : ''?>>
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Published</span>
                </label>
              </fieldset>
              <fieldset>
                <div class="form-group">
                  <label for="exampleInputFile">Thumbnail</label>
                  <input type="file" name="thumbnail" class="form-control-file" id="exampleInputFile" value="<?=$post->get_thumbnail() ?>" aria-describedby="fileHelp">
                  <small id="fileHelp" class="form-text text-muted">Post thumbnail</small>
                </div>
              </fieldset>
              <fieldset>
                <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="delete_img">
                  <span class="custom-control-indicator"></span>
                  <span class="custom-control-description">Delete thumbnail</span>
                </label>
              </fieldset>
              <input type="hidden" name="post_id" value="<?=$post->get_post_id() ?>">
              <button type="submit" class="btn btn-primary" id="user-edit-submit">Save changes</button>
            </form>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<script>
$('#newpassword-repeat').change(function() {
  var passwordVal = $("#newpassword").val();
  var checkVal = $("#newpassword-repeat").val();
   if (passwordVal != checkVal ) {
       $("#description").html('Password is incorect');
       $('#user-edit-submit').attr("disabled", true);
   } else {
     $("#description").html('');
     $('#user-edit-submit').attr("disabled", false);
   }
});
</script>

<?php get_footer() ?>
