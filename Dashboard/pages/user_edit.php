<?php require '../../main-functions.php'; ?>
<?php get_header() ?>
<?php get_template_part_replace('templates/dashboard','top',array(
  'main' => 'Users',
  'small' => 'Edit user',
  'icon' => 'fa-user'
)); ?>
<?php go_to_sign_in(); ?>
<?php if (!check_user_permission(50)) {
  set_alert(array(
    'type' => 'warning',
    'title' => 'Oo',
    'content' => "You don't have enough permission to edit users"
  ));
  header_location(get_directory().'/pages/users.php');
} ?>
<?php $user = get_user($_GET['user_id']);
  if (!check_user_permission($user->get_permission())) {
    set_alert(array(
      'type' => 'warning',
      'title' => 'Oo',
      'content' => "You don't have enough permission to edit this user"
    ));
    header_location(get_directory().'/pages/users.php');
  }
?>

<section id="breadcrumb">
  <div class="container">
    <?php get_alerts() ?>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo get_directory()?>">Home </a></li>
      <li class="breadcrumb-item"><a href="<?php echo get_directory()?>/pages/users.php">Users </a></li>
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
            Users
          </div>

          <div class="card-body p-3">
            <form method="post" action="<?php echo get_directory()?>/option.php?form=user_edit">
              <input type="hidden" name="user_id" value="<?php echo $user->get_user_id() ?>">
              <div class="form-group row">
                <label for="login" class="col-md-2 col-sm-12 col-form-label">Login</label>
                <div class="col-md-10 col-sm-12">
                  <input type="text" name="login" class="form-control" id="login" value="<?php echo $user->get_login()?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-md-2 col-sm-12 col-form-label">New Password</label>
                <div class="col-md-10 col-sm-12">
                  <input type="password" name="password" class="form-control" id="newpassword" value="">
                </div>
              </div>
              <div class="form-group row">
                <label for="password-repeat" class="col-md-2 col-sm-12 col-form-label">Repeat New Password</label>
                <div class="col-md-10 col-sm-12">
                  <input type="password" name="password-repeat" class="form-control" id="newpassword-repeat" value="">
                  <small class="text-danger" id="description"></small>
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-2 col-sm-12 col-form-label">Name</label>
                <div class="col-md-10 col-sm-12">
                  <input type="text" name="name" class="form-control" id="name" value="<?php echo $user->get_name()?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-md-2 col-sm-12 col-form-label">E-mail</label>
                <div class="col-md-10 col-sm-12">
                  <input type="email" name="email" class="form-control" id="email" value="<?php echo $user->get_email()?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="login" class="col-md-2 col-sm-12 col-form-label">Permission</label>
                <div class="col-md-10 col-sm-12">
                  <select class="custom-select" name="permission">
                    <option selected value="<?php echo $user->get_permission() ?>"><?php echo $user->get_power($user->get_permission()) ?></option>
                    <option value="10">User</option>
                    <option value="50">Moderator</option>
                    <option value="100">Admin</option>
                  </select>
                </div>
              </div>
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
