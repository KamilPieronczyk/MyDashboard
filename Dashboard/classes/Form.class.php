<?php

/**
 * Form class
 */
class Form
{
  public $form_name;
  public $fields;

  function __construct($form_name,$fields = array())
  {
    $this->form_name = $form_name;
    foreach ($fields as $key => $value) {
    $this->fields[$key] = $value;
    }
    $this->create_options_table();
  }

  public function send()
  {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
      return 0;
    }
    foreach ($this->fields as $type => $field_name) {
      switch ($type) {
        case 'checkbox':
          if (is_array($field_name)) {
            foreach ($field_name as $name) {
              if (isset($_POST[$name])) $value = 1; else $value = 0;
              if (!$this->add_option($name,$value)) {
                echo 'Error';
              }
            }
          } else {
            if (isset($_POST[$field_name])) $value = 1; else $value = 0;
            if (!$this->add_option($field_name,$value)) {
              echo 'Error';
            }
          }
          break;
        case 'special':
          if (is_array($field_name)) {
            foreach ($field_name as $name) {
              if (!$this->add_option($name,call_user_func($name))) {
                echo 'Error';
              }
            }
          } else {
            if (!$this->add_option($field_name,call_user_func($field_name))) {
              echo 'Error';
            }
          }
          break;
        default:
        if (is_array($field_name)) {
          foreach ($field_name as $name) {
            if (isset($_POST[$name])) {
              if (!$this->add_option($name,$_POST[$name])) {
                echo 'Error';
              }
            }
          }
        } else {
          if (isset($_POST[$field_name])) {
            if (!$this->add_option($field_name,$_POST[$field_name])) {
              echo 'Error';
            }
          }
        }
          break;
      }
    }
  }

  public function create_options_table()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `options`(
      `id` INT(6) UNSIGNED AUTO_INCREMENT,
      `option_name` TEXT,
      `value` TEXT,
      `form_id` TEXT,
      PRIMARY KEY  (`id`)
    )";
      if(conn()->query($sql) === TRUE) return 1;
      else return 0;
  }

  public function add_option($option_name, $value)
  {
    if ($this->form_name=='') {
      $sql = "SELECT * FROM options WHERE option_name = '$option_name' AND form_id = ''";
      $result = conn()->query($sql);
      if(@$result->num_rows>1) return 0;
      if(@$result->num_rows == 1) {
        $this->save_option($option_name,$value);
        return 1;
      }
    } elseif ($this->form_name!='') {
      $sql = "SELECT * FROM options WHERE option_name = '$option_name' AND form_id = '$this->form_name'";
      $result = conn()->query($sql);
      if(@$result->num_rows>1) return 0;
      if(@$result->num_rows == 1) {
        $this->save_option($option_name,$value);
        return 1;
      }
    }
    $sql = "INSERT INTO options VALUES (NULL, '$option_name', '$value', '$this->form_name')";
    if(conn()->query($sql) === TRUE) return 1;
    else return 0;
  }

  public function get_option($option_name)
  {
    if ($this->form_name == '') {
      $sql = "SELECT value FROM options WHERE option_name = '$option_name' AND form_id = ''";
    } else {
      $sql = "SELECT value FROM options WHERE option_name = '$option_name' AND form_id = '$this->form_name'";
    }
    $result = conn()->query($sql);
    if (@$result->num_rows>0) {
      $row = $result->fetch_assoc();
      return $row['value'];
    } else {
      return ;
    }
  }

  public function save_option($option_name, $value)
  {
    if ($this->form_name == '') {
      $sql = "SELECT * FROM options WHERE option_name = '$option_name' AND form_id = ''";
      $result = conn()->query($sql);
      if ($result->num_rows>1) {
        return 0;
      } else {
        $row = $result->fetch_assoc();
        if ($row['form_id'] != '') {
          return 0;
        }
        $sql = "UPDATE options SET value = '$value' WHERE option_name = '$option_name' AND form_id = ''";
        if(conn()->query($sql) === TRUE) return 1;
        else return 0;
      }
    } else {
      $sql = "SELECT value FROM options WHERE option_name = '$option_name' AND form_id = '$this->form_name'";
      $result = conn()->query($sql);
      if ($result->num_rows==1) {
        $sql = "UPDATE options SET value = '$value' WHERE option_name = '$option_name' AND form_id = '$this->form_name'";
        if(conn()->query($sql) === TRUE) return 1;
        else return 0;
      } else {
        return 0;
      }
    }
  }

  function unset_option($option_name)
  {
    if ($this->form_name=='') {
      $sql = "DELETE FROM options WHERE option_name = '$option_name' AND form_id <> ''";
    } else {
      $this->form_name = explode('-',$form_id);
      $this->form_name = $form_id[0];
      $sql = "DELETE FROM options WHERE form_id LIKE '%$this->form_name%' AND option_name = '$option_name'";
    }
    if (conn()->query($sql) === TRUE) {
      return 1;
    } else {
      return 0;
    }
  }

  function unset_options()
  {
    if ($this->form_name != '') {
      $sql = "DELETE FROM options WHERE form_id = '$this->form_name'";
    }
    if (conn()->query($sql) === TRUE) {
      return 1;
    } else {
      return 0;
    }
  }
}
