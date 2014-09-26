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

        $content = '';

        if(is_numeric($id)) {
            $result = sqlGetWord($mysqli, $id, true);
            if($result['code'] == 0) {
                $details           = $result['word'];
                //$id                = $details['id'];
                $word              = $details['word'];
                $structure         = $details['structure'];
                $brief             = $details['brief'];
                $id_language       = $details['id_language'];
                $id_part_of_speech = $details['id_part_of_speech'];
                $translation       = $details['translation'];

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
    </div>';
            } else {
                $content = $result['message'];
            }

        } else
            $content = '
    <div class="col-sm-6 col-md-6 col-lg-6">
        <form id="searchWord1" class="form-search" role="search" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control search-input" placeholder="@string:placeholder_search_word1" value="" data="">
                <ul class="dropdown-menu search-suggest">
                </ul>

                <span class="input-group-btn">
                    <button type="submit" class="btn"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </form>
        <hr />
        <div id="wordCard1" class="wordCard"></div>
        <hr />
        <form role="form">
            <label for="selectLanguage1">@string:label_language</label>
            <div class="form-group">' .
                $this->getLanguageDropDown(0, 'selectLanguage1') . '
            </div>
            <div class="form-group">
                <label for="inputWord1">@string:label_word</label>
                <input id="inputWord1" class="form-control" type="text" placeholder="@string:placeholder_word1" value=""></p>
            </div>
            <div class="form-group">
                <label for="inputStructure1">@string:label_structure</label>
                <input id="inputStructure1" class="form-control" type="text" placeholder="@string:placeholder_structure" value=""></p>
            </div>
            <div class="form-group">
                <label for="inputStructure1">@string:label_brief</label>
                <input id="inputBrief1" class="form-control" type="text" placeholder="@string:placeholder_brief" value=""></p>
            </div>
            <p><button id="buttonAddWord1" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_add_word</button></p>
            <p><button id="buttonSaveWord1" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;@string:button_save_word</button>
               <button id="buttonDeleteWord1" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;@string:button_delete_word</button></p>
        </form>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-6">
        <form id="searchWord2" class="form-search" role="search" autocomplete="off">
            <div class="input-group">
                <input type="text" class="form-control search-input" placeholder="@string:placeholder_search_word2" value="" data="">
                <ul class="dropdown-menu search-suggest">
                </ul>

                <span class="input-group-btn">
                    <button type="submit" class="btn"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </form>
        <hr />
        <div id="wordCard2" class="wordCard"></div>
        <hr />
        <form role="form">
            <label for="selectLanguage2">@string:label_language</label>
            <div class="form-group">' .
                $this->getLanguageDropDown(0, 'selectLanguage2') . '
            </div>
            <div class="form-group">
                <label for="inputWord2">@string:label_word</label>
                <input id="inputWord2" class="form-control" type="text" placeholder="@string:placeholder_word2" value=""></p>
            </div>
            <div class="form-group">
                <label for="inputStructure2">@string:label_structure</label>
                <input id="inputStructure2" class="form-control" type="text" placeholder="@string:placeholder_structure" value=""></p>
            </div>
            <div class="form-group">
                <label for="inputStructure2">@string:label_brief</label>
                <input id="inputBrief2" class="form-control" type="text" placeholder="@string:placeholder_brief" value=""></p>
            </div>
            <p><button id="buttonAddWord2" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_add_word</button></p>
            <p><button id="buttonSaveWord2" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;@string:button_save_word</button>
               <button id="buttonDeleteWord2" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;@string:button_delete_word</button></p>
        </form>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="col-lg-5 centered">
            <button id="buttonLinkWords" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-resize-small"></span>&nbsp;&nbsp;@string:button_link_words</button>
            <button id="buttonUnlinkWords" class="btn btn-danger pull-right btn-block"><span class="glyphicon glyphicon-resize-full"></span>&nbsp;&nbsp;@string:button_unlink_words</button>
        </div>
    </div>
    ';

        return $content;
    }
}

?>