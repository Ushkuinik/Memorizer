<?php
include_once("page.php");
include_once("sqlWord.php");

class pageConfig extends Page
{
    //
    //
    //
    function __construct($mysqli, $id = 0)
    {
    }

    /**
     * Returns script name to be included into index file
     *
     * @return string <script> tag
     */
    public function getScript()
    {
        return '<script src="js/config.js"></script>';
    }


    /**
     * @return string
     */
    public function getContent()
    {
        global $mysqli;
        global $id;

        $content = $this->getWordDetails($mysqli, $id);

        return $content;
    }

    function getWordDetails($_mysqli, $_id = 0)
    {
        $content = '';

        if(is_numeric($_id)) {
            $result = sqlGetWord($_mysqli, $_id, true);
            if($result['code'] == 0) {
                $details           = $result['word'];
                $id                = $details['id'];
                $word              = $details['word'];
                $structure         = $details['structure'];
                $brief             = $details['brief'];
                $id_language       = $details['id_language'];
                $id_part_of_speech = $details['id_part_of_speech'];
                $translation       = $details['translation'];
            } else {
                $content = $result['message'];
            }
        }

        $listTranslation = $this->getTranslationDropDown($translation);

        if(is_numeric($_id)) {
            $content = '
    <div class="col-sm-6 col-md-6 col-lg-6">
        <button type="button" id="buttonNewWord" class="btn btn-primary btn-lg">@string:button_new_word</button>
        <h1>' . $this->getDecoratedWord($structure) . '</h1>
        <hr />
        <form role="form">
            <label for="selectMainLanguage">@string:label_language</label>
            <div class="form-group">' .
                $this->getLanguageDropDown($id_language, 'selectMainLanguage') . '
            </div>
            <div class="form-group">
                <label for="inputWord1">@string:label_word</label>
                <input id="inputWord1" class="form-control" type="text" placeholder="@string:placeholder_word1" value="' . $word . '"></p>
            </div>
            <div class="form-group">
                <label for="inputStructure1">@string:label_structure</label>
                <input id="inputStructure1" class="form-control" type="text" placeholder="@string:placeholder_structure" value="' . $structure . '"></p>
            </div>
            <div class="form-group">
                <label for="inputStructure1">@string:label_brief</label>
                <input id="inputBrief1" class="form-control" type="text" placeholder="@string:placeholder_brief" value="' . $brief . '"></p>
            </div>
            <button id="buttonSaveWord1" type="submit" class="btn btn-primary">@string:button_save_word</button>
            <button id="buttonDeleteWord1" type="submit" class="btn btn-warning">@string:button_delete_word</button>
        </form>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-6">
        <label for="listTranslation">@string:label_translation</label>' .
                $this->getTranslationDropDown($translation) . '
        <form id="searchTranslation" class="form-search" role="search" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control search-input" placeholder="@string:placeholder_search_translation" value="" data="">
                <ul class="dropdown-menu search-suggest"></ul>

                <span class="input-group-btn">
                    <button type="submit" class="btn"><span class="glyphicon glyphicon-plus"></span></button>
                </span>
            </div>
        </form>
    </div>

    ';
        } else
            $content = '
    <div class="col-sm-6 col-md-6 col-lg-6">
        <form id="searchWord1" class="form-search" role="search" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control search-input" placeholder="@string:placeholder_search_word1" value="' . $word . '" data="' . $id . ' ">
                <ul class="dropdown-menu search-suggest">
                </ul>

                <span class="input-group-btn">
                    <button type="submit" class="btn"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </form>
        <hr />
        <form role="form">
            <label for="selectLanguage1">@string:label_language</label>
            <div class="form-group">' .
                $this->getLanguageDropDown($id_language, 'selectLanguage1') . '
            </div>
            <div class="form-group">
                <label for="inputWord1">@string:label_word</label>
                <input id="inputWord1" class="form-control" type="text" placeholder="@string:placeholder_word1" value="' . $word . '"></p>
            </div>
            <div class="form-group">
                <label for="inputStructure1">@string:label_structure</label>
                <input id="inputStructure1" class="form-control" type="text" placeholder="@string:placeholder_structure" value="' . $structure . '"></p>
            </div>
            <div class="form-group">
                <label for="inputStructure1">@string:label_brief</label>
                <input id="inputBrief1" class="form-control" type="text" placeholder="@string:placeholder_brief" value="' . $brief . '"></p>
            </div>
            <p><button id="buttonAddWord1" class="btn btn-success">@string:button_add_word</button></p>
            <p><button id="buttonDeleteWord1" class="btn btn-warning">@string:button_delete_word</button></p>
            <p><button id="buttonSaveWord1" class="btn btn-primary">@string:button_save_word</button></p>
        </form>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-6">
        <form id="searchWord2" class="form-search" role="search" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control search-input" placeholder="@string:placeholder_search_word2" value="' . $word . '" data="' . $id . ' ">
                <ul class="dropdown-menu search-suggest">
                </ul>

                <span class="input-group-btn">
                    <button type="submit" class="btn"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </form>
        <hr />
        <form role="form">
            <label for="selectLanguage2">@string:label_language</label>
            <div class="form-group">' .
                $this->getLanguageDropDown($id_language, 'selectLanguage2') . '
            </div>
            <div class="form-group">
                <label for="inputWord2">@string:label_word</label>
                <input id="inputWord2" class="form-control" type="text" placeholder="@string:placeholder_word2" value="' . $word . '"></p>
            </div>
            <div class="form-group">
                <label for="inputStructure2">@string:label_structure</label>
                <input id="inputStructure2" class="form-control" type="text" placeholder="@string:placeholder_structure" value="' . $structure . '"></p>
            </div>
            <div class="form-group">
                <label for="inputStructure2">@string:label_brief</label>
                <input id="inputBrief2" class="form-control" type="text" placeholder="@string:placeholder_brief" value="' . $brief . '"></p>
            </div>
            <p><button id="buttonAddWord2" class="btn btn-success">@string:button_add_word</button></p>
            <p><button id="buttonDeleteWord2" class="btn btn-warning">@string:button_delete_word</button></p>
            <p><button id="buttonSaveWord2" class="btn btn-primary">@string:button_save_word</button></p>
        </form>

        <label for="listTranslation">@string:label_translation</label>' .
                $this->getTranslationDropDown($translation) . '
    </div>';

        return $content;
    }


    private function getLanguageDropDown($_id_language, $_id)
    {
        if($_id_language == 0)
            $_id_language = 1;
        $languages[1] = "@string:language_russian";
        $languages[2] = "@string:language_english";
        $languages[3] = "@string:language_japanese";
        $content      = '
                <div class="btn-group">
                    <button id="' . $_id. '" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-value="' . $_id_language . '">' . $languages[$_id_language] . ' <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">';
        foreach($languages as $i => $l)
            $content .= '<li><a href="' . $i . '">' . $l . '</a></li>';
        $content .= '
                    </ul>
                </div>';

        return $content;
    }

    private function getTranslationDropDown($translation)
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

    private function getDecoratedWord($_structure)
    {
        $result = $_structure;
        $result = str_replace('[', '<span class="accent">', $result);
        $result = str_replace(']', '</span>', $result);
        $result = str_replace('!', '&#x301;', $result);

        return '<span class="structure">' . ($result) . '</span>';
    }


}

?>