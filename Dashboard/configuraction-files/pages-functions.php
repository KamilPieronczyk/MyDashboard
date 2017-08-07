<?php
global $ob;
function set_page(Page $page)
{
  global $ob;
  $ob = $page;
}

function title()
{
  global $ob;
  echo $ob->get_title();
}

function content()
{
  global $ob;
  return $ob->get_content();
}

function thumbnail()
{
  global $ob;
  return $ob->get_thumbnail();
}
