<?php
/**
 * Mysql
 */
class Data
{
  public static $array;
  public static $num_rows;
  function __construct() { }

  public function select($sql = '')
  {
    $result = conn()->query($sql);
    self::$num_rows = $result->num_rows;
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        self::$array[] = $row;
      }
      return self::$array;
    }
  }

  public function query($sql='')
  {
    if (conn()->query($sql) === TRUE) {
      return 1;
    } else {
      return 0;
    }
  }
}
