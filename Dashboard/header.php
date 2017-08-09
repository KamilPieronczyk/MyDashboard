<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php get_stylesheet_directory('main.css') ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>

  <body>

    <nav class="navbar navbar-toggleable-md">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="<?php echo get_directory() ?>/">SimpleAdmin</a>
      <?php if (is_user_signed_in()): ?>
        <div class="collapse navbar-collapse" id="navbar">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php is_active('index') ?>">
              <a class="nav-link " href="<?php echo get_directory() ?>/">Dashboard <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php is_active('page') ?>">
              <a class="nav-link" href="<?php echo get_directory() ?>/pages/pages.php">Pages</a>
            </li>
            <li class="nav-item <?php is_active('post') ?>">
              <a class="nav-link" href="<?php echo get_directory() ?>/pages/posts.php">Posts</a>
            </li>
            <li class="nav-item <?php is_active('user') ?>">
              <a class="nav-link" href="<?php echo get_directory() ?>/pages/users.php">Users</a>
            </li>
            <li class="nav-item <?php is_active('menu') ?>">
              <a class="nav-link" href="<?php echo get_directory() ?>/pages/menu.php">Menu</a>
            </li>
          </ul>

          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="#" class="nav-link">Welcome, <?php echo get_user_login() ?></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo get_directory() ?>/option.php?form=log_out" class="nav-link">Logout</a>
            </li>
          </ul>

        </div>
      <?php endif; ?>
    </nav>
