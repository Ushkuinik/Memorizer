<?php

class Page
{
  function __construct($mysqli) {}

  public function getContent()
  {
    return "";
  }
  public function getSidebar()
  {
    global $mysqli;
    $content = '';

    $content .= '
<div class="panel panel-primary">
  <div class="panel-heading">Справочники</div>
  <div class="panel-body">
    <p><a href="index.php?view=d_company">Компании[+badge_company+]</a></p>
    <p><a href="index.php?view=d_position">Должности[+badge_position+]</a></p>
    <p><a href="index.php?view=d_workplace">Рабочие места[+badge_workplace+]</a></p>
  </div>
</div>';

    $sql =
"SELECT
(SELECT COUNT( * ) FROM `d_company`) AS n_company,
(SELECT COUNT( * ) FROM `d_position`) AS n_position,
(SELECT COUNT( * ) FROM `d_workplace`) AS n_workplace";
    $result = $mysqli->query($sql);
    if($result)
    {
      if($object = $result->fetch_object())
      {
        $content = str_replace('[+badge_company+]', '<span class="badge badge-primary pull-right">' . $object->n_company . '</span>', $content);
        $content = str_replace('[+badge_position+]', '<span class="badge badge-primary pull-right">' . $object->n_position . '</span>', $content);
        $content = str_replace('[+badge_workplace+]', '<span class="badge badge-primary pull-right">' . $object->n_workplace . '</span>', $content);
      }
    }
    $content = str_replace('[+badge_company+]', '', $content);
    $content = str_replace('[+badge_position+]', '', $content);
    $content = str_replace('[+badge_workplace+]', '', $content);

    return $content;
  }
  public function getScript()
  {
    return "";
  }
  public function getFooter()
  {
    return "";
  }
}

?>