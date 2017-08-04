<?php
/**
 * Alert box
 */
class alert
{
  private $div;
  private $button;
  private $title;
  private $alert_size;
  private $link;
  private $content;
  private $footer;
  private $alert;

  function __construct($type = 'success', $alert_size = 'small')
  {
    $this->div[0] = '<div class="alert alert-'. $type .'" role="alert">';
    $this->div[1] = '</div>';
    $this->button = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>';
    $this->alert_size = $alert_size;
  }

  public function set_title($value = '')
  {
    switch ($this->alert_size) {
      case 'big':
        $this->title = '<h4 class="alert-heading">'. $value . ' </h4>';
        break;

      default:
        $this->title = '<strong>'. $value . ' </strong>';
        break;
    }
  }

  public function set_link( $title, $href = '#')
  {
    $this->link = '<a href="'. $href .'" class="alert-link">'. $title .'</a>';
  }

  public function set_content($value='')
  {
    switch ($this->alert_size) {
      case 'big':
        $this->content = '<p>'. $value . '</p>';
        break;

      default:
        $this->content = $value;
        break;
    }
  }

  public function set_footer($value='')
  {
    if ($this->alert_size == 'big') {
      $this->footer = '<p class="mb-0">'. $value . '</p>';
    }
  }

  public function build_alert()
  {
    $this->alert = $this->div[0] .
                   $this->button .
                   $this->title;
    if (isset($this->link) && $this->link != '')
    {
      $this->content = str_replace('[link]',$this->link,$this->content);
    }
    $this->alert .= $this->content;

    if (isset($this->footer))
    {
      $this->alert .= $this->footer;
    }

    $this->alert .= $this->div[1];

    $_SESSION['alerts'][] = $this->alert;
  }
}
