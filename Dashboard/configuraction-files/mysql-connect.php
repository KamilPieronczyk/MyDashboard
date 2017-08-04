<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'dashboard';

$conn = new mysqli($host,$user,$password,$database);
function conn()
{
  $host = 'localhost';
  $user = 'root';
  $password = '';
  $database = 'dashboard';

  return $conn = new mysqli($host,$user,$password,$database);
}

if ($conn->connect_error) {
    die('Connect Error (' . $conn->connect_errno . ') '
            . $conn->connect_error);
}
