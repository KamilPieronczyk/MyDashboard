<?php
/**
 * Pages
 */
class Page
{
  private $page_id;
  private $title;
  private $content;
  private $thumbnail;
  private $special;
  private $file;
  private $created;
  private $updated;
  private $published;

  function __construct()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `pages` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `title` varchar(255) NOT NULL default '',
    `content` text NOT NULL default '',
    `published` boolean NOT NULL default '1',
    `thumbnail` mediumblob NOT NULL default '',
    `special` boolean NOT NULL default '0',
    `file` text NOT NULL default '',
    `created` DATETIME NOT NULL default now(),
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

  public function create_page($title, $content = '', $published = 1, $special = 0, $thumbnail = '')
  {
    if ($special == 1) {
      $file = ($title == '') ? strtotime(date("Y-m-d H:i:s")) : $title;
      $file = preg_replace('~[\/:*?!"<>|,.`()]~', '', $file);
      $file = str_replace(' ','-',$file);
      $file .= '.php';
    } else {
      $file = '';
    }

    $sql = "INSERT INTO pages (id, title, content, published, thumbnail, special, file) VALUES (NULL, '$title', '$content', '$published', '{$thumbnail}', '$special', '$file')";
    if (conn()->query($sql) === TRUE) {
      set_alert(array(
        'type' => 'success',
        'title' => 'Success',
        'content' => "Page has been created successfull"
      ));
      $pagefile = fopen('../'.WEB_PATH.'/'.$file, "w+");
      $theme = fopen('page-theme.php','r');
      fwrite($pagefile,fread($theme,filesize('page-theme.php')));
      fclose($pagefile);
      fclose($theme);
      $this->page_id = conn()->insert_id;
      $this->title = $title;
      $this->content = $content;
      $this->thumbnail = $thumbnail;
      $this->special = $special;
      $this->published = $published;
      $this->file = $file;
      $this->created = date("Y-m-d H:i:s");
      $this->updated = date("Y-m-d H:i:s");
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ups',
        'content' => "Something was wrong, please try again"
      ));
      header_location(get_directory().'/pages/pages.php');
      return 0;
    }
    return 1;
  }

  public function get_page($id = '')
  {
    if ($id == '') {
      set_alert(array(
        'type' => 'warning',
        'title' => 'Ups',
        'content' => "Page didn't find in a database"
      ));
      return 0;
    }
    $sql = "SELECT * FROM pages WHERE id = '$id'";
    if ($result = conn()->query($sql)) {
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $this->page_id = $id;
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->thumbnail = $row['thumbnail'];
        $this->published = $row['published'];
        $this->special = $row['special'];
        $this->file = $row['file'];
        $this->created = $row['created'];
        $this->updated = $row['updated'];
      } else {
        set_alert(array(
          'type' => 'warning',
          'title' => 'Ups',
          'content' => "Page didn't find in a database"
        ));
        return 0;
      }
    } else {
      set_alert(array(
        'type' => 'warning',
        'title' => 'Ups',
        'content' => "Page didn't find in a database"
      ));
      return 0;
    }
    return 1;
  }

  public function edit_page($id, $title, $content = '', $published = 1, $special = 0)
  {
    if ($this->special == 0 && $special = 1) {
      $file = ($title == '') ? $this->page_id : $title;
      $file = preg_replace('~[\/:*?!"<>|,.`()]~', '', $file);
      $file = str_replace(' ','-',$file);
      $file .= '.php';
      $pagefile = fopen('../'.WEB_PATH.'/'.$file, "w+");
      $theme = fopen('page-theme.php','r');
      fwrite($pagefile,fread($theme,filesize('page-theme.php')));
      fclose($pagefile);
      fclose($theme);
      $sql = "UPDATE pages SET title = '$title', content = '$content', published = '$published', special = '$special', file = '$file' WHERE id = '$id'";
    } elseif ($this->special == $special) {
      $sql = "UPDATE pages SET title = '$title', content = '$content', published = '$published', special = '$special' WHERE id = '$id'";
    } else{
      unlink('../'.WEB_PATH.'/'.$this->file);
      $sql = "UPDATE pages SET title = '$title', content = '$content', published = '$published', special = '$special', file = NULL WHERE id = '$id'";
    }
    if (conn()->query($sql) === TRUE) {
      set_alert(array(
        'type' => 'success',
        'title' => 'Success',
        'content' => "Page has been edited successfull"
      ));
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ups',
        'content' => "Something was wrong, please try again"
      ));
      header_location(get_directory().'/pages/pages.php');
      return 0;
    }
    return 1;
  }

  public function edit_thumbnail($id, $thumbnail = '')
  {
    $sql = "UPDATE pages SET thumbnail = '$thumbnail' WHERE id = '$id'";
    if (conn()->query($sql) === FALSE) {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ups',
        'content' => "Something was wrong with, please try again"
      ));
      header_location(get_directory().'/pages/pages.php');
      return 0;
    }
    return 1;
  }

  public function get_page_id()
  {
    if (isset($this->page_id) && $this->page_id != NULL) {
      return $this->page_id;
    } else {
      return NULL;
    }
  }

  public function get_title()
  {
    if (isset($this->title) && $this->title != NULL) {
      return $this->title;
    } else {
      return NULL;
    }
  }

  public function get_content()
  {
    if (isset($this->content) && $this->content != NULL) {
      return $this->content;
    } else {
      return NULL;
    }
  }

  public function get_thumbnail()
  {
    if (isset($this->thumbnail) && $this->thumbnail != '') {
      return $thumbnail = 'data:image/png;base64,'.base64_encode($this->thumbnail);
    } else {
      return NULL;
    }
  }

  public function get_special()
  {
    if (isset($this->special) && $this->special != '') {
      return $this->special;
    } else {
      return NULL;
    }
  }

  public function get_file()
  {
    if (isset($this->file) && $this->file != '') {
      return $this->file;
    } else {
      return NULL;
    }
  }

  public function get_published()
  {
    if (isset($this->published) && $this->published != '') {
      return $this->published;
    } else {
      return NULL;
    }
  }

  public function get_date($type = 'created')
  {
    switch ($type) {
      case 'created':
        if (isset($this->created) && $this->created != '') {
          return $this->created;
        } else {
          return NULL;
        }
        break;

      default:
        if (isset($this->updated) && $this->updated != '') {
          return $this->updated;
        } else {
          return NULL;
        }
        break;
    }
    return NULL;
  }

  public function prepare_thumbnail($fieldname)
  {
    $thumbnail = addslashes(file_get_contents($_FILES[$filename]['tmp_name']));
    return $thumbnail;
  }

  public function delete_page($id = '')
  {
    if ($id == '') {
      $id = $this->page_id;
    }
    if ($this->special) {
      unlink('../'.WEB_PATH.'/'.$this->file);
    }
    $sql = "DELETE FROM pages WHERE id = '$id'";
    if (conn()->query($sql) === TRUE) {
      set_alert(array(
        'type' => 'success',
        'title' => 'Success!',
        'content' => 'A page has been removed successfull'
      ));
      return 1;
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Error!',
        'content' => 'A page has not been removed, please try again'
      ));
      return 0;
    }
  }
}
