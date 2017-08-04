<?php

function set_cut_limit()
{
  return 5;
}

add_action('set_the_cut','set_cut_limit');
