<?php
/**
 *
 */
class Query
{
  private $have_results = 0;
  private $row;
  private $results;
  private $num_rows = 0;
  private $sql;

  function __construct($sql = '')
  {
    if ($sql != '') {
      $this->sql = $sql;
    }
  }

  public function query_loop($sql = '')
  {
    $sql = ($sql == '') ? $this->sql : $sql;
    if (!$this->have_results) {
      if ($this->results = conn()->query($sql)) {
        if ($this->results->num_rows > 0) {
          $this->have_results = 1;
          $this->num_rows = $this->results->num_rows;
          $this->num_rows--;
          $this->row = $this->results->fetch_assoc();
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
      if ($this->num_rows > 0) {
        $this->num_rows--;
        $this->row = $this->results->fetch_assoc();
        return 1;
      } else {
        $this->have_results = 0;
        return 0;
      }
    }
  }

  public function get_result_e($value)
  {
    if ($this->have_results == 1) {
      if (!isset($this->row[$value])) {
        set_alert(array(
          'type' => 'warning',
          'title' => 'Ups',
          'content' => 'There is no such column ('. $value .') in the database'
        ));
        return;
      }
      echo $this->row[$value];
      return;
    } else {
      set_alert(array(
        'type' => 'warning',
        'title' => 'Ups',
        'content' => 'Use this function in while loop with function query_loop()'
      ));
    }
  }

  public function get_result($value)
  {
    if ($this->have_results == 1) {
      if (!isset($this->row[$value])) {
        set_alert(array(
          'type' => 'warning',
          'title' => 'Ups',
          'content' => 'There is no such column ('. $value .') in the database'
        ));
        return;
      }
      return $this->row[$value];
    } else {
     set_alert(array(
       'type' => 'warning',
       'title' => 'Ups',
       'content' => 'Use this function in while loop with function query_loop()'
     ));
   }
  }
}
