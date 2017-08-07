<?php require_once '../main-functions.php'; ?>
<?php get_header(); ?>
<?php get_template_part_replace_php('templates/dashboard','top',array(
  'main' => 'Sign in',
  'small' => 'Welcome to SimpleAdmin',
  'icon' => 'fa-sign-in'
)); ?>
<?php
  if (is_user_signed_in()) {
    header('location: index.php');
  }
?>
<section id="sign-in">
  <div class="container">
    <?php get_alerts() ?>
    <div class="row">

      <div class="col-md-4 offset-md-4">
        <div class="card">
          <div class="card-header bg-main white">
            <h5>Sign in</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="option.php?form=sign_in">
                <fieldset>
                  <label for="login"><h5>Login</h5></label>
                  <input type="text" id="login" name="login" value="" class="form-control" required>
                </fieldset>
                <fieldset>
                  <label for="password"><h5>Password</h5></label>
                  <input type="password" id="password" name="password" value="" class="form-control" required>
                </fieldset>
                <button type="submit" class="btn bg-main white w-75">Sign in</button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?php get_footer(); ?>
