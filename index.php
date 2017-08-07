<?php
require_once 'main-functions.php';
if (!isset($_GET['action'])) {
  include 'WebPage/index.php';
}
if ($_GET['action'] == 'page') {
  $page = new Page;
  $page->get_page($_GET['page_id']);
}
