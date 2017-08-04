<?php require '../main-functions.php'; ?>
<?php get_header() ?>
<?php get_template_part_replace('templates/dashboard','top',array(
  'main' => 'Users',
  'small' => 'Manage your users',
  'icon' => 'fa-user'
)); ?>
<?php go_to_sign_in(); ?>

<section id="breadcrumb">
  <div class="container">
    <?php get_alerts() ?>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo get_directory()?>">Home </a></li>
      <li class="breadcrumb-item active">Users </li>
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

          <div class="card-body">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th>Login</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php while(query_loop("SELECT * FROM users")) : ?>
                  <tr>
                    <td id='first'><?php get_result_e('login') ?></td>
                    <td><?php get_result_e('name') ?></td>
                    <td><?php get_result_e('email') ?></td>
                    <td>
                      <a class="btn btn-secondary" href="<?php echo get_directory()?>/pages/user_edit.php?user_id=<?php get_result_e('id') ?>">Edit</a>
                      <a class="btn btn-danger" href="<?php echo get_directory()?>/option.php?form=user_delete&user_id=<?php get_result_e('id') ?>" onclick="send_href(this)" data-toggle="modal" data-target="#delete">Delete</a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
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
        <p>Are you sure you want to delete <span id='login'></span>?</p>
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
    if (z[1].innerHTML != '') {
      var text = z[1].innerHTML;
    } else {
      var text = z[0].innerHTML;
    }
    $('#login').text(text);
  }
</script>

<?php get_footer() ?>
