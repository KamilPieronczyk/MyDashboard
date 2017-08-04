<header>
  <div class="container">
    <div class="row">
      <div class="col-md-10">
        <h1>
          <i class="fa [icon]" aria-hidden="true"></i>
          [main]
          <small class="text-muted">[small]</small>
        </h1>
      </div>

      <?php if (is_user_signed_in()): ?>
        <div class="col-md-2">
          <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Create Content
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#page">Add Page</a>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#post">Add Post</a>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#user">Add User</a>
            </div>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </div>
</header>
