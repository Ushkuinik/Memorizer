<?php

class Page
{
    function __construct($mysqli)
    {
    }

    public function getContent()
    {
        return "";
    }

    public function getScript()
    {
        return "";
    }

    public function getMenu()
    {
        $content = '<ul class="nav nav-pills pull-right">
            <li><a href="index.php?view=tester">@string:menu_tester</a></li>
            <li><a href="index.php?view=config">@string:menu_config</a></li>
        </ul>
        <h3><a class="text-muted" href="index.php">@string:app_name</a></h3>';

        return $content;
    }

    public function getFooter()
    {
        $content = '<p>&copy; Company 2014</p>';

        return $content;
    }
}

?>