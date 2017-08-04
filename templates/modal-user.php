<div class="modal fade" id="user">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add User</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </div>
      <div class="modal-body">
        <p>
          <form id="add-user" method="POST" action="<?php echo get_directory()?>/option.php?form=add-user">
            <fieldset class="form-group">
              <label for="login"><h5>User login</h5></label>
              <input type="text" class="form-control" name="login" id="login" placeholder="Enter user login" required>
            </fieldset>
            <fieldset class="form-group">
              <label for="password"><h5>User Password</h5></label>
              <input type="password" class="form-control" name="password" value="" id="password" required>
            </fieldset>
            <fieldset class="form-group">
              <label for="password-repeat"><h5>Repeat Password</h5></label>
              <input type="password" class="form-control" name="password-repeat" value="" id="password-repeat" required>
              <small class="text-danger" id="description"></small>
            </fieldset>
            <fieldset class="form-group">
              <label for="user-email"><h5>User email</h5></label>
              <input type="email" class="form-control" name="email" value="" id="user-email">
            </fieldset>
            <fieldset class="form-group">
              <label for="user-name"><h5>User name</h5></label>
              <input type="text" class="form-control" name="name" value="" id="user-name" placeholder="Enter user name" required>
            </fieldset>
            <fieldset class="form-group">
              <label for="permissions"><h5>User Permissions</h5></label>
              <select class="form-control" id="permissions" name="permission">
                <option value="10">User</option>
                <option value="50">Moderator</option>
                <option value="100">Admin</option>
              </select>
            </fieldset>
          </form>
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" form="add-user" value="Submit" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$('#password-repeat').change(function() {
  var passwordVal = $("#password").val();
  var checkVal = $("#password-repeat").val();
   if (passwordVal != checkVal ) {
       $("#description").html('Password is incorect');
       $('#submit').attr("disabled", true);
   } else {
     $("#description").html('');
     $('#user-submit').attr("disabled", false);
   }
});
</script>
