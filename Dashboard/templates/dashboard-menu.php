<div class="list-group">
  <a href="<?php echo get_directory() ?>" class="list-group-item bg-main white">
    <i class="fa fa-cog" aria-hidden="true"></i>
    Dashboard
  </a>
  <a href="<?php echo get_directory() ?>/pages/pages.php" class="list-group-item list-group-item-action">
    <i class="fa fa-list-alt" aria-hidden="true"></i>
    Pages
    <span class="badge badge-default badge-pill"><?php echo get_num_pages() ?></span>
  </a>
  <a href="<?php echo get_directory() ?>/pages/posts.php" class="list-group-item list-group-item-action">
    <i class="fa fa-pencil" aria-hidden="true"></i>
    Posts
    <span class="badge badge-default badge-pill"><?php echo get_num_posts() ?></span>
  </a>
  <a href="<?php echo get_directory() ?>/pages/users.php" class="list-group-item list-group-item-action">
    <i class="fa fa-user" aria-hidden="true"></i>
    Users
    <span class="badge badge-default badge-pill"><?php echo get_num_users() ?></span>
  </a>
  <a href="<?php echo get_directory() ?>/pages/menu.php" class="list-group-item list-group-item-action">
    <i class="fa fa-bars" aria-hidden="true"></i>
    Menu
    <span class="badge badge-default badge-pill">1</span>
  </a>
</div>
