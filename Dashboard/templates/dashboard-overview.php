<div class="card">
  <div class="card-header bg-main white">
    Website overview
  </div>
  <div class="card-block">
    <div class="row">

      <div class="col-md-3">
        <div class="card card-block bg-faded text-center">
          <h2><i class="fa fa-user" aria-hidden="true"></i><?php echo get_num_users() ?></h2>
          <h4>Users</h4>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card card-block bg-faded text-center">
          <h2><i class="fa fa-list-alt" aria-hidden="true"></i><?php echo get_num_pages() ?></h2>
          <h4>Pages</h4>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card card-block bg-faded text-center">
          <h2><i class="fa fa-pencil" aria-hidden="true"></i><?php echo get_num_posts() ?></h2>
          <h4>Posts</h4>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card card-block bg-faded text-center">
          <h2><i class="fa fa-bar-chart" aria-hidden="true"></i><?php echo get_visitors() ?></h2>
          <h4>Visitors</h4>
        </div>
      </div>

    </div>
  </div>
</div>
