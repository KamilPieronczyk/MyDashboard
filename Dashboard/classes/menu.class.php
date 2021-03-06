<?php
/**
 *
 */
class Menu
{
  function __construct()
  {
    Menu::create_table();
  }

  public static function create_table()
  {
    $sql = "CREATE TABLE IF NOT EXISTS `menu` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `parent_id` int(11) unsigned NULL default NULL,
    `title` text NOT NULL default '',
    `url` text NOT NULL default '',
    `is_parent` boolean NOT NULL default 0,
    `visibility` boolean NOT NULL default 1,
    `number` int(11) unsigned NOT NULL default 20,
    `type` text NOT NULL default '',
    `menu` text NOT NULL default '',
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

  public static function add($title, $url = '', $parent_id = '',$visibility = 1, $number = 20, $type = 'page' ,$menu = 'primary')
  {
    Menu::create_table();
    $is_parent = 0;
    if ($parent_id == 'NULL') {
      $sql = "INSERT INTO menu (id, parent_id, title, url, is_parent, visibility,number, type, menu)
              VALUES (NULL, NULL, '$title', '$url', '$is_parent', '$visibility', '$number', '$type', '$menu')";
    } else {
    $sql = "INSERT INTO menu (id, parent_id, title, url, is_parent, visibility,number, type, menu)
            VALUES (NULL, '$parent_id', '$title', '$url', '$is_parent', '$visibility', '$number', '$type', '$menu')";
    }
    if (conn()->query($sql) === TRUE) {
      set_alert(array(
        'title' => 'Success',
        'content' => 'Added item into menu successful',
      ));

      if ($parent_id != 'NULL') {
        Data::query("UPDATE menu SET is_parent = 1 WHERE id = $parent_id");
      }
      return 1;
    } else {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ups',
        'content' => 'Item has been not added into menu',
      ));
      return 0;
    }
  }

  public static function edit($id, $title, $url = '', $parent_id = '',$visibility = 1, $number = 20, $menu = 'primary')
  {
    Data::select("SELECT * FROM menu WHERE id = '". $id ."'");
    $is_parent = Data::$array[0]['is_parent'];
    $old_parent_id = Data::$array[0]['parent_id'];
    if ($parent_id != '' && $is_parent) {
      if (!Data::query("UPDATE menu SET parent_id = NULL WHERE parent_id = '". $id ."'")) {
        set_alert(array(
          'type' => 'danger',
          'title' => 'Ups!',
          'content' => "Item has been not edited",
        ));
        return 0;
      }
      Data::query("UPDATE menu SET is_parent = 0 WHERE id = $id");
    }

    if ($parent_id == '' && $old_parent_id != '') {
      Data::select("SELECT * FROM menu WHERE parent_id = $old_parent_id");
      echo Data::$num_rows;
      if (Data::$num_rows < 2) {
        if (!Data::query("UPDATE menu SET is_parent = 0 WHERE id = $old_parent_id")) {
          set_alert(array(
            'type' => 'danger',
            'title' => 'Ups!',
            'content' => "Item has been not edited",
          ));
          return 0;
        }
      }
    }

    if ($old_parent_id == '' && $parent_id !='') {
      if (!Data::query("UPDATE menu SET is_parent = 1 WHERE id = $parent_id")) {
        set_alert(array(
          'type' => 'danger',
          'title' => 'Ups!',
          'content' => "Item has been not edited",
        ));
        return 0;
      }
    }

    if ($title == '') {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ups!',
        'content' => "The title mustn't be empty",
      ));
      return 0;
    }
    if ($parent_id == '') {
      if (!Data::query("UPDATE menu SET title = '$title', url = '$url', parent_id = NULL, visibility = '$visibility', number = '$number', menu = '$menu' WHERE id = '". $id ."'")) {
        set_alert(array(
          'type' => 'danger',
          'title' => 'Ups!',
          'content' => "Item has been not edited",
        ));
        return 0;
      }
    } else {
      if (!Data::query("UPDATE menu SET title = '$title', url = '$url', parent_id = '$parent_id', visibility = '$visibility', number = '$number', menu = '$menu' WHERE id = '". $id ."'")) {
        set_alert(array(
          'type' => 'danger',
          'title' => 'Ups!',
          'content' => "Item has been not edited",
        ));
        return 0;
      }
    }
    set_alert(array(
      'title' => 'Success!',
      'content' => "Item has been edited",
    ));
    return 1;
  }

  public static function delete($id)
  {
    if (Data::select("SELECT * FROM menu WHERE parent_id = '". $id ."'")) {
      if (Data::$num_rows > 0) {
        if (!Data::query("UPDATE menu SET parent_id = NULL WHERE parent_id = '". $id ."'")) {
          set_alert(array(
            'type' => 'danger',
            'title' => 'Ups',
            'content' => 'Item has not been removed',
          ));
          return 0;
        }
      }
    }
    if (!Data::query("DELETE FROM menu WHERE id = '". $id ."'")) {
      set_alert(array(
        'type' => 'danger',
        'title' => 'Ups',
        'content' => 'Item has not been removed',
      ));
      return 0;
    }
    set_alert(array(
      'title' => 'Ups',
      'content' => 'Item has been removed',
    ));
    return 1;
  }

  public static function get($attr = array())
  {
    $menu = (isset($attr['menu'])) ? $attr['menu'] : 'primary';
    $menu_class = (isset($attr['menu_class'])) ? $attr['menu_class'] : 'navbar_nav';
    $menu_id = (isset($attr['menu_id'])) ? $attr['menu_id'] : 'navbar';
    $container = (isset($attr['container'])) ? $attr['container'] : 'div';
    $container_class = (isset($attr['container_class'])) ? $attr['container_class'] : '';
    $container_id = (isset($attr['container_id'])) ? $attr['container_id'] : '';
    $active_class = (isset($attr['active_class'])) ? $attr['active_class'] : 'active';
    $item_class = (isset($attr['item_class'])) ? $attr['item_class'] : 'nav-item';
    $a_class = (isset($attr['a_class'])) ? $attr['a_class'] : 'nav-link';
    $target = (isset($attr['target'])) ? $attr['target'] : '_parent';
    echo @$attr['before'];
      echo "<$container class=\"$container_class\" id=$container_id>";
        echo "<ul class=\"$menu_class\" id=$menu_id>";

          while (query_loop("SELECT * FROM menu WHERE menu = '$menu' AND visibility = 1 AND parent_id IS NULL ORDER BY `number`")) {
            if (get_result('type') == 'page') {
              $url = get_main_directory().'/?action=page&page_id='.get_result('url');
              $active = (@$_GET['page_id'] == get_result('url')) ? $active_class : '';
            } else {
              $active = '';
              $url = get_result('url');
            }
            if (get_result('is_parent') == 0) {
              echo "<li class=$item_class $active>";
                echo "<a href=$url class=$a_class target=$target>".get_result('title')."</a>";
              echo "</li>";
            } else {
              echo "<li class=\"$item_class dropdown $active\">";
                echo "<a href=$url class=\"$a_class d-inline-block mr-0 pr-0\" target=$target>".get_result('title')."</a>";
                echo "<a class=\"nav-link dropdown-toggle d-inline-block ml-0 pl-1\" href=\"http://example.com\" id=\"navbarDropdownMenuLink\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
                echo "";
                echo '</a>';
                  echo "<div class=dropdown-menu aria-labelledby=navbarDropdownMenuurl>";
                  $sql = "SELECT * FROM menu WHERE parent_id = '".get_result('id')."' AND visibility = 1 AND menu = '$menu' ORDER BY `number`";
                //Data::select($sql);
                  $url_query = new Query($sql);
                  while ($url_query->query_loop()) {
                    if ($url_query->get_result('type') == 'page') {
                      $url = get_main_directory().'/?action=page&page_id='.$url_query->get_result('url');
                    } else {
                      $url = $url_query->get_result('url');
                    }
                    echo "<a class=dropdown-item href=". $url .">". $url_query->get_result('title') ."</a>";
                  }
                  // for ($i=0; $i < Data::$num_rows; $i++) {
                  //   if (Data::$array[$i]['type'] == 'page') {
                  //     $url = get_main_directory().'/?action=page&page_id='.Data::$array[$i]['url'];
                  //   } else {
                  //     $url = Data::$array[$i]['url'];
                  //   }
                  //   echo "<a class=dropdown-item href=". $url .">". Data::$array[$i]['title'] ."</a>";
                  // }
                  echo "</div>";
              echo "</li>";
            }
          }

        echo "</ul>";
      echo "</$container>";
    echo @$attr['after'];
  }
}
