<?php require_once '../main-functions.php'; ?>
<?php get_header(); ?>
<?php get_template_part_replace_php('templates/dashboard','top',array(
  'main' => 'Sign in',
  'small' => 'Welcome to SimpleAdmin',
  'icon' => 'fa-sign-in'
)); ?>
<?php
  if (is_user_signed_in()) {
    go_home();
  }
?>
<section id="sign-in">
  <div class="container">
    <?php get_alerts() ?>
    <div class="row" id="row">

      <div class="col-md-4 offset-md-4" id="sign-in-card">
        <div class="card">
          <div class="card-header bg-main white">
            <h5>Sign in</h5>
          </div>
          <div class="card-body">
            <form method="POST" action="<?php echo get_directory() ?>/option.php?form=sign_in">
                <fieldset>
                  <label for="login"><h5>Login</h5></label>
                  <input type="text" id="login" name="login" value="" class="form-control" required>
                </fieldset>
                <fieldset>
                  <label for="password"><h5>Password</h5></label>
                  <input type="password" id="password" name="password" value="" class="form-control" required>
                </fieldset>
                <input type="hidden" name="page" value="<?php if (isset($_GET['page'])) echo $_GET['page']?>">
                <button type="submit" class="btn bg-main white w-75">Sign in</button>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-2 offset-md-2 mt-5 text-center" id="sign-up-button-body">
        <button type="button" id="sign-up-button" class="btn btn-outline-primary" name="button">
          <h1>Sign up</h1>
          <h1><?php fa_icon('fa-sign-in') ?></h1>
        </button>
      </div>

      <div class="col-md-6 collapse" id="sign-up">
        <div class="card">
          <div class="card-header white bg-main">
            Sign Up
          </div>
          <div class="card-body">
            <form action="<?php echo get_directory() ?>/option.php?form=sign-up" method="post">
              <div class="form-group row">
                <label for="login" class="col-md-3 form-control-label"><h5>Login</h5></label>
                <div class="col-md-9">
                  <input type="text" id="login" name="login" value="" class="form-control" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-md-3 form-control-label"><h5>Password</h5></label>
                <div class="col-md-9">
                  <input type="password" class="form-control" name="password" value="" id="sign-up-password" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="password-repeat" class="col-md-3 form-control-label"><h5>Repeat Password</h5></label>
                <div class="col-md-9">
                  <input type="password" class="form-control" name="password-repeat" value="" id="sign-up-password-repeat" required>
                  <small class="text-danger" id="description"></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="user-email" class="col-md-3 form-control-label"><h5>Email</h5></label>
                <div class="col-md-9">
                  <input type="email" class="form-control" name="email" value="" id="user-email">
                </div>
              </div>
              <div class="form-group row">
                <label for="user-name" class="col-md-3 form-control-label"><h5>Name</h5></label>
                <div class="col-md-9">
                  <input type="text" class="form-control" name="name" value="" id="user-name" placeholder="Enter user name" required>
                </div>
              </div>
              <button type="submit" id="submit" value="Submit" class="btn bg-main white w-75">Sign up</button>
              <input type="hidden" name="page" value="<?php if (isset($_GET['page'])) echo $_GET['page']?>">
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  $('#sign-up').hide();

  $('#sign-up-button').click(function(){
    $('#sign-up-button-body').hide();
    $('#sign-in-card').removeClass('offset-md-4');
    $('#row').addClass('justify-content-around');
    $('#sign-up').show(450);
  })

  $('#sign-up-password-repeat').change(function() {
    var passwordVal = $("#sign-up-password").val();
    var checkVal = $("#sign-up-password-repeat").val();
    console.log(passwordVal);
    console.log(checkVal)
     if (passwordVal != checkVal ) {
         $("#description").html('Password is incorect');
         $('#submit').attr("disabled", true);
     } else {
       $("#description").html('');
       $('#submit').attr("disabled", false);
     }
  });
</script>

<?php get_footer(); ?>
