<?php
/*
* Include files
*/
require_once 'config.php';
require_once DASHBOARD_PATH.'/configuraction-files/mysql-connect.php';
require_once DASHBOARD_PATH.'/configuraction-files/options-funcions.php';
require_once DASHBOARD_PATH.'/actions.php';
// variabel to connect with mysql = conn()
session_start();
spl_autoload_register(function ($class) {
    include DASHBOARD_PATH.'/classes/' . $class . '.class.php';
});
require_once DASHBOARD_PATH.'/configuraction-files/user-function.php';
require_once DASHBOARD_PATH.'/configuraction-files/pages-functions.php';
@include DASHBOARD_PATH.'/functions.php';


/*
* Functions
*/

function get_header()
{
  (@include DASHBOARD_PATH.'/header.php') or die('Cannot find a header file');
}

function get_footer()
{
  (@include DASHBOARD_PATH.'/footer.php') or die('Cannot find a footer file');
}

function get_stylesheet_directory($filename, $maindir = DASHBOARD_PATH)
{
  $dir = strtolower(basename(__DIR__));
  $uri = $_SERVER['REQUEST_URI'];
  $uri = explode('/',$uri);
  $url = '';
  foreach ($uri as $value) {
    $value = strtolower($value);
    if ($value != $dir) {
      $url .= $value.'/';
    } else {
      $url .= $value.'/'.$maindir.'/css/'.$filename;
      break;
    }
  }
  echo $url;
}

function go_home()
{
  $adres = get_directory().'/index.php';
  header("location: $adres");
}

function header_location($value = '')
{
  if ($value != '') {
    header("location: $value");
    exit;
    return;
  } else {
    if (isset($_POST['href'])) {
      $href = $_POST['href'];
      header("location: $href");
      exit;
      return;
    }
  }
}

function get_directory()
{
  $dir = strtolower(basename(__DIR__));
  $uri = $_SERVER['REQUEST_URI'];
  $uri = explode('/',$uri);
  $url = '';
  foreach ($uri as $value) {
    $value = strtolower($value);
    if ($value != $dir) {
      $url .= $value.'/';
    } else {
      $url .= $value.'/'.DASHBOARD_PATH;
      break;
    }
  }
  return $url;
}

function get_theme_directory()
{
  $dir = strtolower(basename(__DIR__));
  $uri = $_SERVER['REQUEST_URI'];
  $uri = explode('/',$uri);
  $url = '';
  foreach ($uri as $value) {
    $value = strtolower($value);
    if ($value != $dir) {
      $url .= $value.'/';
    } else {
      $url .= $value.'/'.WEB_PATH;
      break;
    }
  }
  return $url;
}

function get_main_directory()
{
  $dir = strtolower(basename(__DIR__));
  $uri = $_SERVER['REQUEST_URI'];
  $uri = explode('/',$uri);
  $url = '';
  foreach ($uri as $value) {
    $value = strtolower($value);
    if ($value != $dir) {
      $url .= $value.'/';
    } else {
      $url .= $value;
      break;
    }
  }
  return $url;
}

function get_template_part($first,$second = '',$maindir = DASHBOARD_PATH)
{
  if ($second != '') {
    (@include $maindir.'/'.$first.'-'.$second.'.php') or die ('Cannot open a '. $first.'-'.$second.'.php');
  } else {
    (@include $maindir.'/'.$first.'.php') or die('Cannot open a'. $first.'.php');
  }
}

function get_template_part_replace($first,$second = '',$replace = array(), $maindir = DASHBOARD_PATH)
{
  if ($second != '') {
  if (($file = file_get_contents($maindir.'/'.$first.'-'.$second.'.php', FILE_USE_INCLUDE_PATH)) === FALSE)
  {
    die('Cannot open a '. $first.'-'.$second.'.php');
    return 0;
  }
    foreach ($replace as $key => $value) {
      $file = str_replace('['.$key.']',$value,$file);
    }
    echo $file;
  } else {
    if(($file = file_get_contents($maindir.'/'.$first.'.php', FILE_USE_INCLUDE_PATH)) === FALSE)
    {
      die('Cannot open a '. $first.'.php');
      return 0;
    }
    foreach ($replace as $key => $value) {
      $file = str_replace('['.$key.']',$value,$file);
    }
    echo $file;
  }
  return 1;
}

function get_template_part_replace_php($first,$second = '',$replace = array(),$maindir = DASHBOARD_PATH)
{
  if ($second != '') {
    ob_start();
    (@include $maindir.'/'.$first.'-'.$second.'.php') or die ('Cannot open a '. $first.'-'.$second.'.php');
    $file = ob_get_clean();
    foreach ($replace as $key => $value) {
      $file = str_replace('['.$key.']',$value,$file);
    }
    echo $file;
  } else {
    (@include $maindir.'/'.$first.'.php') or die('Cannot open a'. $first.'.php');
    $file = ob_get_clean();
    foreach ($replace as $key => $value) {
      $file = str_replace('['.$key.']',$value,$file);
    }
    echo $file;
  }
  return 1;
}

function set_alert($attr = array())
{
  $attr['type'] = (isset($attr['type'])) ? $attr['type'] : 'success';
  $attr['title'] = (isset($attr['title'])) ? $attr['title'] : '';
  $attr['size'] = (isset($attr['size'])) ? $attr['size'] : '';
  $attr['link-content'] = (isset($attr['link-content'])) ? $attr['link-content'] : '';
  $attr['link'] = (isset($attr['link'])) ? $attr['link'] : '';
  $attr['content'] = (isset($attr['content'])) ? $attr['content'] : '';
  $attr['footer'] = (isset($attr['footer'])) ? $attr['footer'] : '';

  $alert = new alert($attr['type'], $attr['size']);
  $alert->set_title($attr['title']);
  $alert->set_content($attr['content']);
  $alert->set_link($attr['link-content'], $attr['link']);
  $alert->set_footer($attr['footer']);
  $alert->build_alert();
  $alert = null;
}

function get_alerts()
{
  if (!isset($_SESSION['alerts'])) {
    return;
  }
  foreach ($_SESSION['alerts'] as $key => $value) {
    echo $value;
    unset($_SESSION['alerts'][$key]);
  }
}

$have_results = 0;
$row;
$results;
$num_rows = 0;
function query_loop($sql)
{
  global $results,$row,$have_results,$num_rows;
  if (!$have_results) {
    if ($results = conn()->query($sql)) {
      if ($results->num_rows > 0) {
        $have_results = 1;
        $num_rows = $results->num_rows;
        $num_rows--;
        $row = $results->fetch_assoc();
        return 1;
      } else {
        return 0;
      }
    } else {
      set_alert(array(
        'type' => 'warning',
        'title' => 'Ups',
        'content' => 'Check your mysql query and try again'
      ));
    }
  } else {
    if ($num_rows > 0) {
      $num_rows--;
      $row = $results->fetch_assoc();
      return 1;
    } else {
      $have_results = 0;
      return 0;
    }
  }
}

function get_result_e($value)
{
  global $row,$have_results;
  if ($have_results == 1) {
    if (!isset($row[$value])) {
      set_alert(array(
        'type' => 'warning',
        'title' => 'Ups',
        'content' => 'There is no such column ('. $value .') in the database'
      ));
      return;
    }
    echo $row[$value];
    return;
  } else {
    set_alert(array(
      'type' => 'warning',
      'title' => 'Ups',
      'content' => 'Use this function in while loop with function query_loop()'
    ));
  }
}

function get_result($value)
{
  global $row,$have_results;
  if ($have_results == 1) {
    if (!isset($row[$value])) {
      set_alert(array(
        'type' => 'warning',
        'title' => 'Ups',
        'content' => 'There is no such column ('. $value .') in the database'
      ));
      return;
    }
    return $row[$value];
  } else {
   set_alert(array(
     'type' => 'warning',
     'title' => 'Ups',
     'content' => 'Use this function in while loop with function query_loop()'
   ));
 }
}

function get_num_users()
{
  $sql = "SELECT * FROM users";
  if (Data::select($sql)) {
    return Data::$num_rows;
  } else {
    return 0;
  }
}

function get_num_pages()
{
  $sql = "SELECT * FROM pages";
  if (Data::select($sql)) {
    return Data::$num_rows;
  } else {
    return 0;
  }
}

function get_num_posts()
{
  $sql = "SELECT * FROM posts";
  if (Data::select($sql)) {
    return Data::$num_rows;
  } else {
    return 0;
  }
}

function is_active($file)
{
  $active = pathinfo($_SERVER['REQUEST_URI']);
  $active = $active['filename'];
  $uri = get_directory();
  if ($active == DASHBOARD_PATH) {
    $active =  'index.php';
  }
  if (strpos($active,$file) !== false) {
    echo 'active';
    return 'active';
  }
  echo '';
  return NULL;
}

function the_cut($string, $wordsreturned = THE_CUT_LIMIT)
{
  $retval = $string;
  $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
  $string = str_replace("\n", " ", $string);
  $array = explode(" ", $string);
  if (count($array)<=$wordsreturned)
  {
    $retval = $string;
  }
  else
  {
    array_splice($array, $wordsreturned);
    $retval = implode(" ", $array)." ...";
  }
  return $retval;
}

function prepare_img($value)
{
  $thumbnail = addslashes(file_get_contents($value));
  return $thumbnail;
}

function fa_icon($fa, $class = '', $id = '')
{
  $id = ($id == '') ? '' : 'id="'. $id .'"';
  echo '<i class="fa '. $fa .' '. $class .'" '. $id .' aria-hidden="true"></i>';
}

function error404($message = '',$value = '')
{
  if ($message != '') {
    $_SESSION['error404_message'] = $message;
  }
  switch ($value) {
    case 'dashboard':
      header_location(get_main_directory().'/error404.php');
      break;

    default:
      header_location(get_main_directory().'/error404.php');
      break;
  }
}

function get_error404_message()
{
  if (isset($_SESSION['error404_message'])) {
    $message = $_SESSION['error404_message'];
    unset($_SESSION['error404_message']);
  }else {
    $message = '';
  }
  return $message;
}

function plus_visitors()
{
  if (!isset($_SESSION['latest_visit'])) {
    $date = date('Y-m-d H:i:s');
    $_SESSION['latest_visit'] = $date;
    $visitors = get_option('visitors');
    if (!$visitors) {
      $visitors = 0;
      add_option('visitors',++$visitors);
      return;
    }
    save_option('visitors',++$visitors);
    return;
  }
  $minutes = round(strtotime(date('Y-m-d H:i:s')) - strtotime($_SESSION['latest_visit'])) / (60);

  if ($minutes > 30) {
    $_SESSION['latest_visit'] = date('Y-m-d H:i:s');
    $visitors = get_option('visitors');
    if (!$visitors) {
      $visitors = 0;
      add_option('visitors',++$visitors);
      return;
    }
    save_option('visitors',++$visitors);
  }
}

function get_visitors()
{
  return get_option('visitors');
}
