<?php
require_once 'main-functions.php';
if (!isset($_GET['action'])) {
  include WEB_PATH.'/index.php';
}
if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'page':
      create_page();
      break;
    default:
      (@include WEB_PATH.'/index.php') or die(error404('Index file does not exist'));
      break;
  }
}

function create_page()
{
  if (!isset($_GET['page_id'])) {
    error404('Page id does not set');
  }
  $page = new Page;
  if (!$page->get_page($_GET['page_id'])) {
    error404('Page within id does not exist');
  }

  set_page($page);
  if ($page->get_published()) {
    if (!$page->get_special()) {
      ob_start();
      include WEB_PATH.'/pages.php';
      $page_included = ob_get_clean();
      if ($page_included == Null) {
        error404('Pages theme does not exist');
      }
    } else {
      ob_start();
      include WEB_PATH.'/'.$page->get_file();
      $page_included = ob_get_clean();
      if ($page_included == Null) {
        error404('Pages does not exist '.WEB_PATH.'/'.$page->get_file());
      }
    }
  } else {
    error404('Page does not exist');
  }

  echo $page_included;
}
