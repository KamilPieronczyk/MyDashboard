<?php
function create_options_table()
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
create_options_table();

function add_option($option_name, $value, $form_id='')
{
  if ($form_id=='') {
    $sql = "SELECT * FROM options WHERE option_name = '$option_name'";
    $result = conn()->query($sql);
    if(@$result->num_rows>0) return 0;
  } elseif ($form_id!='') {
    $sql = "SELECT * FROM options WHERE option_name = '$option_name' AND form_id = '$form_id'";
    $result = conn()->query($sql);
    if($result->num_rows>0) return 0;
  }
  $sql = "INSERT INTO options VALUES (NULL, '$option_name', '$value', '$form_id')";
  if(conn()->query($sql) === TRUE) return 1;
  else return 0;
}

function get_option($option_name, $form_id='')
{
  if ($form_id == '') {
    $sql = "SELECT value FROM options WHERE option_name = '$option_name'";
  } else {
    $sql = "SELECT value FROM options WHERE option_name = '$option_name' AND form_id = '$form_id'";
  }
  $result = conn()->query($sql);
  if (@$result->num_rows>0) {
    $row = $result->fetch_assoc();
    return $row['value'];
  } else {
    return ;
  }
}

function save_option($option_name, $value, $form_id='')
{
  if ($form_id == '') {
    $sql = "SELECT * FROM options WHERE option_name = '$option_name'";
    $result = conn()->query($sql);
    if ($result->num_rows>1) {
      return 0;
    } else {
      $row = $result->fetch_assoc();
      if ($row['form_id'] != '') {
        return 0;
      }
      $sql = "UPDATE options SET value = '$value' WHERE option_name = '$option_name'";
      if(conn()->query($sql) === TRUE) return 1;
      else return 0;
    }
  } else {
    $sql = "SELECT value FROM options WHERE option_name = '$option_name' AND form_id = '$form_id'";
    $result = conn()->query($sql);
    if ($result->num_rows==1) {
      $sql = "UPDATE options SET value = '$value' WHERE option_name = '$option_name' AND form_id = '$form_id'";
      if(conn()->query($sql) === TRUE) return 1;
      else return 0;
    } else {
      return 0;
    }
  }
}

function unset_option($option_name,$form_id='')
{
  if ($form_id=='') {
    $sql = "DELETE FROM options WHERE option_name = '$option_name' AND form_id <> ''";
  } else {
    $form_id = explode('-',$form_id);
    $form_id = $form_id[0];
    $sql = "DELETE FROM options WHERE form_id LIKE '%$form_id%' AND option_name = '$option_name'";
  }
  if (conn()->query($sql) === TRUE) {
    return 1;
  } else {
    return 0;
  }
}

function unset_options($form_id)
{
  if ($form_id != '') {
    $sql = "DELETE FROM options WHERE form_id = '$form_id'";
  }
  if (conn()->query($sql) === TRUE) {
    return 1;
  } else {
    return 0;
  }
}

function get_form_field($form_id)
{
  $form_id = explode('-',$form_id);
  $form_id = $form_id[0];

  $sql = "SELECT * FROM fields WHERE form_id = '$form_id'";
  $result = conn()->query($sql);
    if ($result->num_rows>0) {
      while ($row = $result->fetch_assoc()) {
        $fields[] = $row['name'];
      }
      if (count($fields)>0) {
        return $fields;
      } else {
        return 0;
      }
    } else {
      return 0;
    }
}
