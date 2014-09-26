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
            <li><a href="index.php?view=import">@string:menu_import</a></li>
        </ul>
        <h3><a class="text-muted" href="index.php">@string:app_name</a></h3>';

        return $content;
    }

    public function getFooter()
    {
        $content = '<p>&copy; Company 2014</p>';

        return $content;
    }

    protected function getLanguageDropDown($_id_language, $_id)
    {
        if($_id_language == 0)
            $_id_language = 1;
        $languages[1] = "@string:language_russian";
        $languages[2] = "@string:language_english";
        $languages[3] = "@string:language_japanese";
        $flags[1] = '<img class="flag" src="img/flag_russia.png" />&nbsp;';
        $flags[2] = '<img class="flag" src="img/flag_uk.png" />&nbsp;';
        $flags[3] = '<img class="flag" src="img/flag_japan.png" />&nbsp;';

        $content      = '
<div class="btn-group">
    <button id="' . $_id. '" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-value="' . $_id_language . '">' . $flags[$_id_language] . $languages[$_id_language] . ' <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">';
        foreach($languages as $i => $l) {
            $content .= '<li><a href="' . $i . '">' . $flags[$i] . $l . '</a></li>';
        }
        $content .= '
    </ul>
</div>';

        return $content;
    }


    protected function getCategoryDropDown($_id_category)
    {
        return '';
    }


    protected function getTranslationDropDown($translation)
    {
        if($translation == null)
            return "";

        $content = '
                    <ul class="list-group">';
        foreach($translation as $id => $t) {
            switch($t['id_language']) {
                case '1':
                    $img = '<img class="flag" src="img/flag_russia.png" />';
                    break;
                case '2':
                    $img = '<img class="flag" src="img/flag_uk.png" />';
                    break;
                case '3':
                    $img = '<img class="flag" src="img/flag_japan.png" />';
                    break;
            }
            $content .= '<li class="list-group-item">' . $img . '<a href="index.php?view=config&id=' . $t['id'] . '">' . $t['word'] . '</a></li>';
        }
        $content .= '
                    </ul>';

        return $content;
    }

    protected function getDecoratedWord($_structure)
    {
        $result = $_structure;
        $result = str_replace('[', '<span class="accent">', $result);
        $result = str_replace(']', '</span>', $result);
        $result = str_replace('!', '&#x301;', $result);

        return '<span class="structure">' . ($result) . '</span>';
    }
}
?>