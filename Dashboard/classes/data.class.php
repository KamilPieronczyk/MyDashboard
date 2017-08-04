<?php
/**
 * Mysql
 */
class Data
{
  public static $array;
  public static $num_rows;
  function __construct() { }

  public static function select($sql = '')
  {
    $result = conn()->query($sql);
    self::$num_rows = $result->num_rows;
    if ($result->num_rows > 1) {
      while ($row = $result->fetch_assoc()) {
        self::$array[] = $row;
      }
      return self::$array;
    } elseif ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      self::$num_rows = 1;
      return $row;
    } else {
      self::$num_rows = 0;
      return 0;
    }
  }

  public static function query($sql='')
  {
    if (conn()->query($sql) === TRUE) {
      return 1;
    } else {
      return 0;
    }
  }
}
