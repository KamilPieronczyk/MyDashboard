<?php
/**
 * Form class
 */
class My_Form
{
  //Form id
  public $form_id;
  private $number=0;
  //array of inputs
  public $inputs;
  public $priority;
  public $fields;
  //Title of form
  public $title;
  //multiplied form
  public $multiple;
  private $field_names_id = 0;
  //all settings
  public $settings;
  private $have_values = 0;
  private $all_settings;
  private $settings_rows=0;
  private $bufor;

  private $callback_update;

  function __construct( $id, $title_ = '', $multiple_ = false)
  {
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
    if ($multiple_ == true) {
      while (1) {
        $this->number += 1;
        $sql="SELECT * FROM options WHERE form_id = '$id-$this->number'";
        $result = conn()->query($sql);
        if ($result->num_rows == 0){
           break;
        } else {
          continue;
        }
      }
    }
    $id = ($multiple_) ? $id.'-'.$this->number : $id;
    $this->form_id=$id;
    $this->title=$title_;
    $this->multiple=$multiple_;
    if (isset($_SESSION['field_names'])) {
      $this->update();
    }
    echo '<script src="https://cdn.ckeditor.com/4.7.1/standard/ckeditor.js"></script>';
  }

  public function add_field($name,$attr = array())
  {
    if (!isset($attr['save']) || $attr['save'] == true) {
      $_SESSION['field_names'][$this->field_names_id++]=$name;
    }
    if (!isset($attr['type'])) {
      $attr['type']='text';
    }
    $_SESSION[$name]=$attr['type'];
    if ($this->multiple == false && !isset($attr['input_text'])) {
      $attr['input_text']=get_option($name,$this->form_id);
    } elseif (!isset($attr['input_text'])) {
      $attr['input_text']='';
    }
    if (isset($attr['priority'])) {
      $this->priority[$name]=$attr['priority'];
    } else {
      $this->priority[$name]=0;
    }
    if ( ! isset($attr['class'])) {
      $class = '';
    } else {
      $class = $attr['class'];
    }
    if ( ! isset($attr['placeholder'])) {
      $placeholder = '""';
    } else {
      $placeholder = $attr['placeholder'];
    }
    if ( ! isset($attr['attr'])) {
      $attrs = '';
    } else {
      $attrs = $attr['attr'];
    }
    if ( ! isset($attr['label'])) {
      $attr['label'] = '';
    }
    if (isset($attr['description'])) {
      $description = $attr['description'];
    } else {
      $description = '';
    }
    if (get_class($this) == 'My_Form') {
      $sett = array(
        'label' => $attr['label'],
        'description' => $description,
        'type' => $attr['type'],
        'placeholder' => $placeholder,
        'class' => $class,
        'attr' => $attrs,
        'priority' => $this->priority[$name]
      );
      $this->add_field_db($name,$sett);
    }
     $this->inputs[$name] = '<label>'.$attr['label'];
     if (isset($attr['description'])) {
       $this->inputs[$name] .= '<span class="description">'.$attr['description'].'</spna>';
     }
     switch ($attr['type']) {
       case 'radio':
         foreach ($attr['choices'] as $key => $value) {
           $this->inputs[$name] .= "<input type=".$attr['type']." name=".$name." $class value=".$key." $attrs>".$value."<br>";
         }
        break;
       case 'textarea':
        $this->inputs[$name] .= "<textarea name=\"$name\" $class $attrs>$attr[input_text]</textarea>";
        break;
       case 'checkbox':
        $checked = (get_option($name,$this->form_id)) ? 'checked' : '' ;
        $this->inputs[$name] .= "<input type=".$attr['type']." name=".$name." class=$class $attrs $checked>";
        break;
       default:
        $this->inputs[$name] .= "<input type=".$attr['type']." name=".$name." class=\"$class\" placeholder=\"$placeholder\" $attrs value=\"$attr[input_text]\">";
        break;
     }
     $this->inputs[$name] .= '</label>';
  }

  public function add_text_editor($name,$attr = array()){
    if ($name == '') {
      return ;
    }
    $_SESSION['field_names'][$this->field_names_id++] = $name;
    $_SESSION[$name] = 'text_editor';
    if ($this->multiple == false) {
      $attr['input_text'] = get_option($name,$this->form_id);
    } else {
      $attr['input_text'] = '';
    }
    if (isset($attr['priority'])) {
      $this->priority[$name]=$attr['priority'];
    } else {
      $this->priority[$name]=0;
    }
    if ( ! isset($attr['attr'])) {
      $attr['attr'] = '';
    }
    if (get_class($this) == 'My_Form') {
      $sett = array(
        'label' => @$attr['label'],
        'type' => 'text_editor',
        'description' => @$attr['description'],
        'class' => @$attr['class'],
        'priority' => $this->priority[$name],
        'placeholder' => '',
        'attr' => $attr['attr']
      );
      $this->add_field_db($name,$sett);
    }
    if (isset($attr['label'])) {
      $this->inputs[$name] = '<label>'.$attr['label'];
    }
    if (isset($attr['description'])) {
      $this->inputs[$name] .= '<span class="description">'.$attr['description'].'</spna>';
    }
    $this->inputs[$name] .= "<div ".$attr['attr'].">";
    $this->inputs[$name] .= "<textarea name=\"$name\">".$attr['input_text']."</textarea>
                            <script>CKEDITOR.replace( '$name' )</script>";
    $this->inputs[$name] .= '</div>';
    $this->inputs[$name] .= '</label>';
  }

  public function form_input($args = array('before_form' => '<div>', 'before_title' => '<h2>', 'after_title' => '</h2>', 'after_form' => '</div>'),$callback = '')
  {
    if (isset($_SESSION['field_names'])) {
      $this->update();
    }
    $this->clean();
    array_multisort($this->priority,$this->inputs);

    echo $args['before_form'];
    echo "<form method=\"POST\">";
    echo $args['before_title'].$this->title.$args['after_title'];

    foreach ($this->inputs as $value) {
      echo $value;
      echo '<br>';
    }
    if ($callback != '') {
      call_user_func($callback);
    }
    echo "<input type=\"submit\" name=\"submit\" value=\"Save\" class=\"btn btn-primary\">";
    echo "</form>";
    echo $args['after_form'];
  }

  public function update()
  {
    $formid=$this->form_id;
    $ok = 0;
    foreach ($_SESSION['field_names'] as $name) {
      if (isset($_POST[$name])) {
        if (!add_option($name,$_POST[$name],$formid)) {
          save_option($name,$_POST[$name],$formid);
        }
        if (isset($_SESSION[$name])) {
          if ($_SESSION[$name]=='checkbox') {
            if (!add_option($name,1,$formid)) {
              save_option($name,1,$formid);
            }
          }
        }
        unset($_POST[$name]);
        $ok = 1;
      } elseif (!isset($_POST[$name]) && $_SESSION[$name]=='checkbox' && $ok == 1) {
        $ok = 0;
        if (!add_option($name,0,$formid)) {
          save_option($name,0,$formid);
        }
      }
    unset($_SESSION[$name]);
    }
    if (count($_POST) > 0 && isset($this->callback_update)) {
      call_user_func($this->callback_update);
    }
    unset($_SESSION['field_names']);
  }

  public function register_update($callback)
  {
    $this->callback_update = $callback;
  }

  public function clean()
  {
    if($fields = get_form_field($this->form_id))
    {
      foreach ($fields as $value) {
        $clean=0;
        foreach ($this->inputs as $key => $value2){
          if ($value == $key)
          {
            $clean=1;
            break;
          }
        }
        if ($clean == 0) {
          if (!unset_option($value,$this->form_id)) {
            echo "Error during cleaning a database";
          }
          if (!$this->unset_field_db($value)) {
            echo "Error during cleaning a database";
          }
        }
      }
    }
  }
  public function have_values()
  {
    if(!$this->have_values)
    {
      if ($this->multiple == FALSE) {
        $sql = "SELECT * FROM options WHERE form_id = '$this->form_id'";
      } else {
        $form_id_exploded = explode('-',$this->form_id);
        $id=$form_id_exploded[0];
        $sql = "SELECT * FROM options WHERE form_id LIKE '%$id%'";
      }
      $this->all_settings = conn()->query($sql);
      if ($this->all_settings->num_rows == 0) {
        return 0;
      }
      $this->settings_rows = $this->all_settings->num_rows;
    }
   $this->have_values = 1;
   unset($this->settings);
   if ($this->settings_rows > 0) {
     if (count($this->bufor) != 0) {
       $formid = $this->bufor['form_id'];
       $this->settings[$this->bufor['option_name']] = $this->bufor['value'];
       $this->settings['form_id']=$formid;
       unset($this->bufor);
     } else {
       $row = $this->all_settings->fetch_assoc();
       $this->settings_rows--;
       $formid = $row['form_id'];
       $this->settings['form_id']=$formid;
       $this->settings[$row['option_name']] = $row['value'];
     }
     while($row = $this->all_settings->fetch_assoc())
     {
       $this->settings_rows--;
       if ($formid != $row['form_id']) {
         $this->bufor = $row;
         break;
       }
      $this->settings[$row['option_name']] = $row['value'];
     }
     return 1;
   }
   else {
     return 0;
   }
  }

  public function get_value($option_name)
  {
    if ($this->have_values) {
      return @$this->settings[$option_name];
    } else {
      if ($this->multiple == FALSE) {
        return get_option($option_name,$this->form_id);
      } else {
        return 0;
      }
    }
  }

  public function get_form_id()
  {
    if ($this->have_values) {
      return $this->settings['form_id'];
    } else {
      return $this->form_id;
    }
  }

  public function add_field_db($name,$attr)
  {
    $formid = explode('-',$this->form_id);
    $formid = $formid[0];

    $sql = "SELECT * FROM fields WHERE name = '$name' AND form_id = '$formid'";
    $result = conn()->query($sql);
    if ($result->num_rows > 0) {
      $sql = "UPDATE fields SET type = '$attr[type]', placeholder = '$attr[placeholder]', class = '$attr[class]', description = '$attr[description]', priority = '$attr[priority]', label = '$attr[label]', attrs = '$attr[attr]' WHERE name = '$name' AND form_id = '$formid'";
      conn()->query($sql);
      return 1;
    }
    $sql = "INSERT INTO fields VALUES (NULL, '$formid', '$name', '$attr[type]', '$attr[placeholder]', '$attr[class]', '$attr[attr]', '$attr[description]', '$attr[priority]', '$attr[label]')";
    if (conn()->query($sql) === TRUE) {
      return 1;
    } else {
      return 'ERROR';
    }
  }

  public function unset_field_db($name)
  {
    $formid = explode('-',$this->form_id);
    $formid = $formid[0];
    $sql = "SELECT * FROM fields WHERE name = '$name' AND form_id = '$formid'";
    $result = conn()->query($sql);
    if ($result->num_rows == 0) {
      return 0;
    }
    $sql = "DELETE FROM fields WHERE name = '$name' AND form_id = '$formid'";
    if (conn()->query($sql) === TRUE) {
      return 1;
    } else {
      return 0;
    }
  }

  public function get_form_fields()
  {
    $formid = explode('-',$this->form_id);
    $formid = $formid[0];

    $sql = "SELECT * FROM fields WHERE form_id = '$formid'";
    $result = conn()->query($sql);
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        switch ($row['type']) {
          case 'text_editor':
           $this->add_text_editor($row['name'],array(
           'label' => $row['label'],
           'description' => $row['description'],
           'class' => $row['class'],
           'priority' => $row['priority'],
           'attr' => $row['attrs']
           ));
           break;

          default:
           $this->add_field($row['name'],array(
            'label' => $row['label'],
            'description' => $row['description'],
            'type' => $row['type'],
            'placeholder' => $row['placeholder'],
            'class' => $row['class'],
            'attr' => $row['attrs'],
            'priority' => $row['priority']
           ));
           break;
        }
      }
      return 1;
    } else {
      return 0;
    }
  }

}
