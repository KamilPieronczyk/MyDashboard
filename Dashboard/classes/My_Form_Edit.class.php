<?php
/**
 * My Form Edit
 */
class My_Form_Edit extends My_Form
{
  function __construct($id,$title_='')
  {
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
    $this->form_id=$id;
    $this->multiple = false;
    $this->title = $title_;
    $this->get_form_fields();
    echo '<script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>';
  }
}
