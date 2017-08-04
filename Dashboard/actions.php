<?php

function add_action($name, $function_name)
{
  switch ($name) {
    case 'set_the_cut':
      define('THE_CUT_LIMIT', call_user_func($function_name));
      break;

    default:
      break;
  }
}
