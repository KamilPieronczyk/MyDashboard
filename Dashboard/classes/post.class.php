<?php
/**
 * Posts
 */
class Post
{
  private $post_id;
  private $title;
  private $content;
  private $thumbnail;
  private $created;
  private $updated;
  private $published;

  function __construct()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `posts` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `title` varchar(255) NOT NULL default '',
    `content` text NOT NULL default '',
    `published` boolean NOT NULL default '1',
    `thumbnail` mediumblob NOT NULL default '',
    `created` DATETIME NOT NULL default now(),
    `updated` TIMESTAMP NOT NULL
                       DEFAULT CURRENT_TIMESTAMP
                       ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY  (`id`) )";
    if (!Data::query($sql)) {
      set_alert(array(
        'type' => 'info',
        'title' => 'Error!',
        'content' => 'Problem with creating a table in a database, please try again',
      ));
      return 0;
    }
    return 1;
  }

  public function create_post($title, $content = '', $published = 1, $thumbnail = '')
  {
    $sql = "INSERT INTO posts (id, title, content, published, thumbnail) VALUES (NULL, '$title', '$content', '$published', '{$thumbnail}')";
    if (Data::query($sql)) {
      set_alert(array(
        'type' => 'success',
        'title' => 'Success',
        'content' => "Post has been created successfull"
      ));
      $this->post_id = conn()->insert_id;
      $this->title = $title;
      $this->content = $content;
      $this->thumbnail = $thumbnail;
      $this->published = $published;
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

  public function edit_post($id, $title, $content = '', $published = 1)
  {
    $sql = "UPDATE posts SET title = '$title', content = '$content', published = '$published' WHERE id = '$id'";
    if (Data::query($sql)) {
      set_alert(array(
        'type' => 'success',
        'title' => 'Success',
        'content' => "Post has been edited successfull"
      ));
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ups',
        'content' => "Something was wrong, please try again"
      ));
      return 0;
    }
    return 1;
  }

  public function edit_thumbnail($id, $thumbnail = '')
  {
    $sql = "UPDATE posts SET thumbnail = '$thumbnail' WHERE id = '$id'";
    if (conn()->query($sql) === FALSE) {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ups',
        'content' => "Something was wrong with, please try again"
      ));
      return 0;
    }
    return 1;
  }

  public function get_post($id = '')
  {
    if ($id == '') {
      set_alert(array(
        'type' => 'warning',
        'title' => 'Ups',
        'content' => "Post didn't find in a database"
      ));
      return 0;
    }
    $sql = "SELECT * FROM posts WHERE id = '$id'";
    if (Data::select($sql)) {
      $this->post_id = $id;
      $this->title = Data::$array[0]['title'];
      $this->content = Data::$array[0]['content'];
      $this->thumbnail = Data::$array[0]['thumbnail'];
      $this->published = Data::$array[0]['published'];
      $this->created = Data::$array[0]['created'];
      $this->updated = Data::$array[0]['updated'];
    } else {
      set_alert(array(
        'type' => 'warning',
        'title' => 'Ups',
        'content' => "Post didn't find in a database"
      ));
      return 0;
    }
    return 1;
  }

  public function delete_post($id = '')
  {
    if ($id == '') {
      $id = $this->post_id;
    }
    $sql = "DELETE FROM posts WHERE id = '$id'";
    if (Data::query($sql)) {
      set_alert(array(
        'type' => 'success',
        'title' => 'Success!',
        'content' => 'A post has been removed successfull'
      ));
      return 1;
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Error!',
        'content' => 'A post has not been removed, please try again'
      ));
      return 0;
    }
  }

  public function get_post_id()
  {
    if (isset($this->post_id) && $this->post_id != NULL) {
      return $this->post_id;
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

  public function get_thumbnail($value = '')
  {
    if (isset($this->thumbnail) && $this->thumbnail != '') {
      $thumbnail = 'data:image/png;base64,'.base64_encode($this->thumbnail);
      return $thumbnail;
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
}
