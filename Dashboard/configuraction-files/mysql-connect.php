<?php
define('HOST','localhost');
define('USER', 'root');
define('PASSWORD','');
define('DATABASE', 'dashboard');

$conn = new mysqli(HOST,USER,PASSWORD,DATABASE);

function conn()
{
  return $conn = new mysqli(HOST,USER,PASSWORD,DATABASE);
}

if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') '
            . $conn->connect_error);
}
