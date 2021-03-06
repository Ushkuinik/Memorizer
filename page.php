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
            <li><a href="index.php?view=category">@string:menu_category</a></li>
        </ul>
        <h3><a class="text-muted" href="index.php">@string:app_name</a></h3>';

        return $content;
    }

    public function getFooter()
    {
        $content = '<p>&copy; Company 2014</p>';

        return $content;
    }


    protected function getSearchComboBox($_id, $_placeholder, $_word_id, $_word) {
        $content = '
            <form id="' . $_id . '" class="form-search" role="search" autocomplete="off">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control search-input" placeholder="' . $_placeholder . '" value="' . $_word . '" data="' . $_word_id . '">
                        <ul class="dropdown-menu search-suggest">
                        </ul>

                        <span class="input-group-btn">
                            <button type="submit" class="btn"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </div>
            </form>';
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
<div id="' . $_id. '" class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data="' . $_id_language . '">' . $flags[$_id_language] . $languages[$_id_language] . ' <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">';
        foreach($languages as $i => $l) {
            $content .= '<li><a href="' . $i . '">' . $flags[$i] . $l . '</a></li>';
        }
        $content .= '
    </ul>
</div>';

        return $content;
    }


    protected function getCategoryDropDown($_id_category, $_id, $_need_null)
    {
        $template = '
                <div class="form-group">
                    <div id="[+id+]" class="input-group">
                        <input type="text" class="form-control" readonly="readonly" placeholder="@string:placeholder_category" data-value="[+category_id+]" value="[+category_name+]">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                [+items+]
                            </ul>
                        </div><!-- /btn-group -->
                    </div><!-- /input-group -->
                </div><!-- /form-group -->';

        $result = sqlGetCategoryList();
        if($result['code'] == 0) {
            $categories = $result['categories'];

            if(isset($categories[$_id_category])) {
                $category_name = $categories[$_id_category];
            }
            else {
                $category_name = ($_need_null) ? '@string:all_words' : '';
            }

            $template = str_replace('[+id+]', $_id, $template);
            $template = str_replace('[+category_id+]', $_id_category, $template);
            $template = str_replace('[+category_name+]', $category_name, $template);

            $items = ($_need_null) ? '<li><a href="0">@string:all_words</a></li>' : '';
            foreach($categories as $id => $category) {
                $items .= '<li><a href="' . $id . '">' . $category . '</a></li>';
            }
            $content = str_replace('[+items+]', $items, $template);
        }
        return $content;
    }


    protected function getCategoryDropDownWithExtra($_id_category, $_id)
    {
        $template = '
                <div class="form-group">
                    <div id="[+id+]" class="input-group">
                        <input type="text" class="form-control" readonly="readonly" placeholder="@string:placeholder_category" data-value="[+category_id+]" value="[+category_name+]">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"> <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                [+items+]
                            </ul>
                        </div><!-- /btn-group -->
                    </div><!-- /input-group -->
                </div><!-- /form-group -->';

        $result = sqlGetCategoryList();
        if($result['code'] == 0) {
            $categories = $result['categories'];

            if(isset($categories[$_id_category])) {
                $category_name = $categories[$_id_category];
            }
            else {
                $category_name = '';
            }

            $template = str_replace('[+id+]', $_id, $template);
            $template = str_replace('[+category_id+]', $_id_category, $template);
            $template = str_replace('[+category_name+]', $category_name, $template);

            $items = '<li class="special wo-translate"><a href="-2">Слова без перевода</a></li>';
            $items .= '<li class="special wo-category"><a href="-1">Слова без категории</a></li>';
            foreach($categories as $id => $category) {
                $items .= '<li><a href="' . $id . '">' . $category . '</a></li>';
            }
            $content = str_replace('[+items+]', $items, $template);
        }
        return $content;
    }


    protected function getTranslationDropDown($translation)
    {
        if($translation == null)
            return "";

        $content = '<ul class="list-group">';
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
        $content .= '</ul>';

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