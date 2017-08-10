<?php
/**
 * User class
 * permission: user (10), moderator (50), admin (100)
 */
class User
{
  private $login;
  private $password;
  private $permission;
  private $user_id;
  private $name;
  private $email;

  function __construct()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `login` varchar(255) NOT NULL default '',
    `password` text NOT NULL default '',
    `permission` int(11) unsigned NOT NULL default '10',
    `name` varchar(255) NOT NULL default '',
    `email` varchar (255) NOT NULL default '',
    `created` DATETIME,
    `updated` TIMESTAMP NOT NULL
                       DEFAULT CURRENT_TIMESTAMP
                       ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY  (`id`) )";
    if (conn()->query($sql) === FALSE) {
      set_alert(array(
        'type' => 'info',
        'title' => 'Error!',
        'content' => 'Problem with creating a table in a database, please try again',
      ));
      return 0;
    }
    return 1;
  }

  public function new_user($login, $password, $name = '', $email = '', $permission = 'user')
  {
    $sql = "SELECT * FROM users WHERE login = '$login'";
    if ($result = conn()->query($sql)) {
      if ($result->num_rows > 0) {
        set_alert(array(
          'type' => 'danger',
          'title' => 'Warning!',
          'content' => 'A user with such a nick already exists',
        ));
        return 0;
      }
    }
    if (!is_numeric($permission)) {
      $permission = $this->get_power($permission);
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (id, login, password, name, permission, email) VALUES (NULL, '$login', '$password', '$name', '$permission', '$email')";
    if (conn()->query($sql) === FALSE) {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Warning!',
        'content' => 'Problem with create a user, please try again'
      ));
      return 0;
    }
    $this->user_id = conn()->insert_id;
    $this->login = $login;
    $this->email = $email;
    $this->name = $name;
    $this->permission = $permission;
    set_alert(array(
      'title' => 'Success!',
      'content' => 'A user has been created'
    ));
    return 1;
  }

  public function delete_user($id = '')
  {
    if ($id == '') {
      $id = $this->user_id;
    }
    $sql = "DELETE FROM users WHERE id = '$id'";
    if (conn()->query($sql) === TRUE) {
      set_alert(array(
        'type' => 'success',
        'title' => 'Success!',
        'content' => 'A user has been removed successfull'
      ));
      return 1;
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Error!',
        'content' => 'A user has not been removed, please try again'
      ));
      return 0;
    }
  }

  public function get_user($id)
  {
    $sql = "SELECT * FROM users WHERE id = '$id'";
    if ($result = conn()->query($sql)) {
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $this->user_id = $id;
        $this->login = $row['login'];
        $this->email = $row['email'];
        $this->name = $row['name'];
        $this->permission = $row['permission'];
      }
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Error!',
        'content' => 'Such user does not exist'
      ));
      return 0;
    }
    return 1;
  }

  public function sign_in($login, $password)
  {
    $sql = "SELECT * FROM users WHERE login = '$login'";
    if ($result = conn()->query($sql)) {
      $row = $result->fetch_assoc();
      if (!password_verify($password, $row['password'])) {
        set_alert(array(
          'type' => 'danger',
          'title' => 'Error!',
          'content' => 'Login or password is incorect'
        ));
        return 0;
      }
      $this->user_id = $row['id'];
      $this->login = $row['login'];
      $this->email = $row['email'];
      $this->name = $row['name'];
      $this->permission = $row['permission'];
      $_SESSION['signed_in'] = TRUE;
      $_SESSION['user_id'] = $this->user_id;
      $updatedate = "UPDATE users SET updated = now() WHERE id = '$this->user_id'";
      conn()->query($updatedate);
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Error!',
        'content' => 'Login or password is incorect'
      ));
      $_SESSION['signed_in'] = FALSE;
      return 0;
    }
    return 1;
  }

  public function edit_user($id, $login, $name = '', $email = '', $permission = 'user', $newpassword = '')
  {
    if (!is_numeric($permission)) {
      $permission = get_power($permission);
    }
    if (!check_user_permission($permission)) {
        set_alert(array(
          'type' => 'warning',
          'title' => 'Oo',
          'content' => "You don't have enough permission to update user to this permission"
        ));
        header_location(get_directory().'/pages/users.php');
        return;
    }
    if ($newpassword != '') {
      $newpassword = password_hash($newpassword, PASSWORD_DEFAULT);
      $sql = "UPDATE users SET login = '$login', password = '$newpassword', name = '$name', email = '$email', permission = '$permission', updated=now() WHERE id = '$id' ";
    } else {
      $sql = "UPDATE users SET login = '$login', name = '$name', email = '$email', permission = '$permission', updated=now() WHERE id = '$id' ";
    }
    if (conn()->query($sql) === TRUE) {
      set_alert(array(
        'title' => 'Success',
        'content' => 'User has been edited successful'
      ));
      header_location(get_directory().'/pages/users.php');
      return;
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ups',
        'content' => 'Problem with edit user in database, please try again'
      ));
      header_location(get_directory().'/pages/users.php');
      return;
    }
  }

  public function log_out()
  {
    if (isset($_SESSION['signed_in'])) {
      unset($_SESSION['signed_in']);
      unset($_SESSION['user']);
    }
  }

  public function get_user_id()
  {
    if (isset($this->user_id)) {
      return $this->user_id;
    } else {
      return NULL;
    }
  }

  public function get_login()
  {
    if (isset($this->login)) {
      return $this->login;
    } else {
      return NULL;
    }
  }

  public function get_email()
  {
    if (isset($this->email)) {
      return $this->email;
    } else {
      return NULL;
    }
  }

  public function get_name()
  {
    if (isset($this->name)) {
      return $this->name;
    } else {
      return NULL;
    }
  }

  public function get_permission()
  {
    if (isset($this->permission)) {
      return $this->permission;
    } else {
      return NULL;
    }
  }

  public function get_power($value)
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
      }
    }
  }
}
