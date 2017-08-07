<?php require_once 'main-functions.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Error 404</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <div class="row">

        <div class="jumbotron mt-5 col-md-6 offset-md-3 text-center">
          <h1 class="display-3">Error 404!</h1>
          <p class="lead">Something was wrong</p>
          <hr class="m-y-md">
          <p><?php echo get_error404_message() ?></p>
          <p class="lead">
            <a class="btn btn-primary btn-lg" href="<?php echo get_main_directory() ?>/" role="button">Go Home</a>
          </p>
        </div>

      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  </body>
</html>
