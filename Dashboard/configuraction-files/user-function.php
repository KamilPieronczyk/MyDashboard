<?php
function is_user_signed_in()
{
  if (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function check_user_permission($required = 10)
{
  if (!is_numeric($required)) {
    $required = get_power($required);
  }

  if (is_user_signed_in()) {
    $obj = get_user();
    $permission = $obj->get_permission();
    if ($permission >= $required) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
}

function go_to_sign_in()
{
  if (!is_user_signed_in()) {
    header('location: '.get_directory().'/sign_in.php');
  }
}

function get_user($user_id = '')
{
  if ($user_id != '') {
    $obj = new User;
    $obj->get_user($user_id);
    return $obj;
  }
  if (is_user_signed_in()) {
    $obj = new User;
    $obj->get_user($_SESSION['user_id']);
    return $obj;
  } else {
    $obj = new User;
    return $obj;
  }
}

function get_user_login()
{
  if (!is_user_signed_in()) {
    return NULL;
  }
  $obj = get_user();
  return $obj->get_login();
}

function get_user_email()
{
  if (!is_user_signed_in()) {
    return NULL;
  }
  $obj = get_user();
  return $obj->get_email();
}

function get_user_name()
{
  if (!is_user_signed_in()) {
    return NULL;
  }
  $obj = get_user();
  return $obj->get_name();
}

function get_user_id()
{
  if (!is_user_signed_in()) {
    return NULL;
  }
  $obj = get_user();
  return $obj->get_user_id();
}

function log_out()
{
  if (isset($_SESSION['signed_in'])) {
    unset($_SESSION['signed_in']);
    unset($_SESSION['user_id']);
  }
}

function get_power($value)
{
  if (!is_numeric($value)) {
    switch ($value) {
      case 'moderator':
        return 50;
        break;
      case 'admin':
        return 100;
        break;
      case 'user':
        return 10;
        break;
    }
  } else {
    $value = (int)$value;
    switch ($value) {
      case 50:
        return 'moderator';
        break;
      case 100:
        return 'admin';
        break;
      case 10:
        return 'user';
        break;
      case 150:
        return 'Admin';
        break;
    }
  }
}

function fade()
{
  return $fade = is_user_signed_in() ? '' : 'fade';
}
