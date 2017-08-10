<?php
require_once '../main-functions.php';

if (!isset($_GET['form'])) {
  exit();
}

$frname = $_GET['form'];

if ($frname == 'sign_in' ) {
  if (isset($_POST['login'])) {
    $user = new User;
    if ($user->sign_in($_POST['login'], $_POST['password'])) {
      go_home();
    } else {
      $adres = get_directory().'/sign_in.php';
      header("location: $adres");
    }
  }
}

if ($frname == 'log_out') {
  log_out();
  go_to_sign_in();
}

if ($frname == 'add-user') {
  if (!isset($_POST['login'])) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Error',
      'content' => 'Problem with creating a new user, please try again'
    ));
    return;
  }
  $permission = $_POST['permission'];
  if (!check_user_permission($permission)) {
    set_alert(array(
      'type' => 'info',
      'title' => 'Ups',
      'content' => "You don't have enough permissions to create ".get_power($permission)
    ));
    go_home();
    exit;
  }
  $newuser = new User;
  $newuser->new_user($_POST['login'], $_POST['password'], $_POST['name'], $_POST['email'], $permission);
  go_home();
}

if ($frname == 'user_edit') {
  if (!isset($_POST['user_id'])) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Error!',
      'content' => 'Problem with edit user, please try again'
    ));
    header_location(get_directory().'/pages/users.php');
    exit;
  }
  $user = get_user($_POST['user_id']);
  if (!check_user_permission($user->get_permission())) {
    set_alert(array(
      'type' => 'warning',
      'title' => 'Oo',
      'content' => "You don't have enough permission to edit this user"
    ));
    header_location(get_directory().'/pages/users.php');
    exit;
  }
  if (isset($_POST['password']) && isset($_POST['password-repeat'])) {
    if ($_POST['password'] != '' || $_POST['password-repeat'] != '') {
      if ($_POST['password'] == $_POST['password-repeat']) {
        $password = $_POST['password'];
      } else {
        set_alert(array(
          'type' => 'warning',
          'title' => 'O o',
          'content' => "Please check again both password"
        ));
        header_location(get_directory().'/pages/users.php');
        exit;
      }
    } elseif ($_POST['password'] == '' && $_POST['password-repeat'] == '') {
      $password = '';
    } else {
      set_alert(array(
        'type' => 'warning',
        'title' => 'O o',
        'content' => "One of the password field is empty"
      ));
      header_location(get_directory().'/pages/users.php');
      exit;
    }
  } else {
    $password = '';
  }
  if ($_POST['login'] == '') {
    set_alert(array(
      'type' => 'warning',
      'title' => 'O o',
      'content' => "Login field can not be empty"
    ));
    header_location(get_directory().'/pages/users.php');
    exit;
  }
  $user->edit_user($_POST['user_id'], $_POST['login'], $_POST['name'], $_POST['email'], $_POST['permission'], $password);
  header_location(get_directory().'/pages/users.php');
  exit;
}

if ($frname == 'user_delete') {
  $user = get_user($_GET['user_id']);
  if (!isset($_GET['user_id'])) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Error!',
      'content' => 'Problem with delete user, please try again'
    ));
    header_location(get_directory().'/pages/users.php');
    exit;
  }
  if (!check_user_permission(50)){
    set_alert(array(
      'type' => 'error',
      'title' => 'Ee',
      'content' => "You don't have permission to delete users"
    ));
    header_location(get_directory().'/pages/users.php');
    exit;
  }
  if (!check_user_permission($user->get_permission()+1)) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Ee',
      'content' => "You don't have permission to delete this user"
    ));
    header_location(get_directory().'/pages/users.php');
    exit;
  }
  $user->delete_user();
  header_location(get_directory().'/pages/users.php');
  exit;
}

if ($frname == 'page_create') {
  if (!isset($_POST['title']) || !isset($_POST['published'])) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Ups',
      'content' => "Problem with downloading data from form"
    ));
    header_location(get_directory().'/pages/pages.php');
    exit;
  }
  if (!is_user_signed_in()) {
    go_to_sign_in();
    exit;
  }
  if (!check_user_permission(50)) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Ee',
      'content' => "You don't have permission to create a page"
    ));
    header_location(get_directory().'/pages/pages.php');
    exit;
  }
  $published = (isset($_POST['published'])) ? 1 : 0;
  $special = (isset($_POST['special'])) ? 1 : 0;
  $page = new Page;
  $thumbnail = prepare_img($_FILES['thumbnail']['tmp_name']);
  if ($page->create_page($_POST['title'],$_POST['content'],$published,$special,$thumbnail))
  {
    header_location(get_directory().'/pages/pages.php');
    exit;
  }
  exit;
}

if ($frname == 'page_edit') {
  if (!isset($_POST['page_id'])) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Error!',
      'content' => 'Problem with edit page, please try again'
    ));
    header_location(get_directory().'/pages/pages.php');
    exit;
  }
  $page = new Page;
  $page->get_page($_POST['page_id']);
  if (!check_user_permission(50)) {
    set_alert(array(
      'type' => 'warning',
      'title' => 'Oo',
      'content' => "You don't have enough permission to edit this page"
    ));
    header_location(get_directory().'/pages/pages.php');
    exit;
  }
  $published = (isset($_POST['published'])) ? 1 : 0;
  $special = (isset($_POST['special'])) ? 1 : 0;
  if (isset($_POST['delete_img'])) {
    $thumbnail = '';
    $page->edit_thumbnail($page->get_page_id(),$thumbnail);
  }
  if ($_FILES['thumbnail']['size']) {
    $thumbnail = prepare_img($_FILES['thumbnail']['tmp_name']);
    $page->edit_thumbnail($page->get_page_id(),$thumbnail);
  }
  $page->edit_page($_POST['page_id'], $_POST['title'], $_POST['content'], $published, $special);
  header_location(get_directory().'/pages/pages.php');
  exit;
}

if ($frname == 'page_delete') {
  $page = new Page;
  $page->get_page($_GET['page_id']);
  if (!isset($_GET['page_id'])) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Error!',
      'content' => 'Problem with delete page, please try again'
    ));
    header_location(get_directory().'/pages/pages.php');
    exit;
  }
  if (!check_user_permission(50)){
    set_alert(array(
      'type' => 'error',
      'title' => 'Ee',
      'content' => "You don't have permission to delete pages"
    ));
    header_location(get_directory().'/pages/posts.php');
    exit;
  }
  $page->delete_page();
  header_location(get_directory().'/pages/pages.php');
  exit;
}

if ($frname == 'post_create') {
  if (!is_user_signed_in()) {
    go_to_sign_in();
    exit;
  }
  if (!check_user_permission(10)) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Ee',
      'content' => "You don't have permission to create a post"
    ));
    header_location(get_directory().'/pages/posts.php');
    exit;
  }
  $published = (isset($_POST['published'])) ? 1 : 0;
  $post = new Post;
  $thumbnail = prepare_img($_FILES['thumbnail']['tmp_name']);
  if ($post->create_post($_POST['title'],$_POST['content'],$published,$thumbnail))
  {
    header_location(get_directory().'/pages/posts.php');
    exit;
  }
  exit;
}

if ($frname == 'post_edit') {
  if (!isset($_POST['post_id'])) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Error!',
      'content' => 'Problem with edit post, please try again'
    ));
    header_location(get_directory().'/pages/posts.php');
    exit;
  }
  $post = new Post;
  $post->get_post($_POST['post_id']);
  if (!check_user_permission(10)) {
    set_alert(array(
      'type' => 'warning',
      'title' => 'Oo',
      'content' => "You don't have enough permission to edit this post"
    ));
    header_location(get_directory().'/pages/posts.php');
    exit;
  }
  $published = (isset($_POST['published'])) ? 1 : 0;
  if (isset($_POST['delete_img'])) {
    $thumbnail = '';
    $post->edit_thumbnail($page->get_post_id(),$thumbnail);
  }
  if ($_FILES['thumbnail']['size']) {
    $thumbnail = prepare_img($_FILES['thumbnail']['tmp_name']);
    $post->edit_thumbnail($post->get_post_id(),$thumbnail);
  }
  $post->edit_post($_POST['post_id'], $_POST['title'], $_POST['content'], $published);
  header_location(get_directory().'/pages/posts.php');
  exit;
}

if ($frname == 'post_delete') {
  $post = new Post;
  $post->get_post($_GET['post_id']);
  if (!isset($_GET['post_id'])) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Error!',
      'content' => 'Problem with delete post, please try again'
    ));
    header_location(get_directory().'/pages/posts.php');
    exit;
  }
  if (!check_user_permission(50)){
    set_alert(array(
      'type' => 'danger',
      'title' => 'Ee',
      'content' => "You don't have permission to delete posts"
    ));
    header_location(get_directory().'/pages/posts.php');
    exit;
  }
  $post->delete_post();
  header_location(get_directory().'/pages/posts.php');
  exit;
}

if ($frname == 'menu_item_add') {
  if ($_POST['type'] == 'page') {
    $url = $_POST['page'];
    if ($_POST['title'] == '') {
      $page= new Page;
      $page->get_page($_POST['page']);
      $title = $page->get_title();
    } else {
      $title = $_POST['title'];
    }
  } else {
    if ($_POST['title'] == '') {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ee',
        'content' => "Title mustn't be empty"
      ));
      header_location(get_directory().'/pages/menu.php');
      exit;
    } else {
      $title = $_POST['title'];
    }
    $url = $_POST['url'];
  }
  Menu::add($title,$url,$_POST['parent'],$_POST['visibility'],$_POST['number'],$_POST['type']);
  header_location(get_directory().'/pages/menu.php');
  exit;
}

if ($frname == "menu_item_edit" ) {
  if (!isset($_POST['url'])) {
    $url = $_POST['page'];
    if ($_POST['title'] == '') {
      $page= new Page;
      $page->get_page($_POST['page']);
      $title = $page->get_title();
    } else {
      $title = $_POST['title'];
    }
  } else {
    if ($_POST['title'] == '') {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ee',
        'content' => "Title mustn't be empty"
      ));
      header_location(get_directory().'/pages/menu.php');
      exit;
    } else {
      $title = $_POST['title'];
    }
    $url = $_POST['url'];
  }
  if ($_POST['parent'] == 'NULL') {
    $parent = '';
  } else {
    $parent = $_POST['parent'];
  }
  Menu::edit($_POST['item_id'], $_POST['title'], $url, $parent, $_POST['visibility'], $_POST['number']);
  header_location(get_directory().'/pages/menu.php');
  exit;
}

if ($frname == "menu_item_delete" ) {
  Menu::delete($_GET['item_id']);
  header_location(get_directory().'/pages/menu.php');
  exit;
}

if ($frname == 'sign-up') {
  if (!isset($_POST['login']) || $_POST['login'] == '') {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Error',
      'content' => 'Problem with creating a new user, please try again'
    ));
    header_location(get_directory().'/sign_in.php');
    exit;
  }
  if ($_POST['password'] != $_POST['password-repeat']) {
    set_alert(array(
      'type' => 'danger',
      'title' => 'Error',
      'content' => 'Password is incorect'
    ));
    header_location(get_directory().'/sign_in.php');
    exit;
  }
  $newuser = new User;
  $newuser->new_user($_POST['login'], $_POST['password'], $_POST['name'], $_POST['email']);
  header_location(get_directory().'/sign_in.php');
  exit;
}
