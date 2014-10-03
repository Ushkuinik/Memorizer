<?php
include_once("page.php");
include_once("sqlWord.php");

class pageConfig extends Page
{
    //
    //
    //
    function __construct($mysqli, $_id1, $_id2)
    {
        if($_id1 != 0)
            $_SESSION['id1'] = $_id1;
        else
            unset($_SESSION['id1']);

        if($_id2 != 0)
            $_SESSION['id2'] = $_id2;
        else
            unset($_SESSION['id2']);

        if(($_id1 != 0) || ($_id2 != 0)) {
//            header('Location: index.php?view=config');
        }
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

        $id1 = $_SESSION['id1'];
        $result = sqlGetWord($mysqli, $id1, true);
        $word1 = $result['word'];

        $id2 = $_SESSION['id2'];

        $content = '
<div class="col-sm-6 col-md-6 col-lg-6">
' . $this->getSearchComboBox("searchWord1", "@string:placeholder_search_word1", $id1, $word1['word']) . '
    <div id="wordCard1" class="wordCard"></div>
    <hr />
    <form role="form">
        <label for="selectLanguage1">@string:label_language</label>
        <div class="form-group">
        ' . $this->getLanguageDropDown($word1['id_language'], 'selectLanguage1') . '
        </div>
        <div class="form-group">
            <label for="inputWord1">@string:label_word</label>
            <input id="inputWord1" class="form-control" type="text" placeholder="@string:placeholder_word1" value="' . $word1['word'] . '"></p>
        </div>
        <div class="form-group">
            <label for="inputStructure1">@string:label_structure</label>
            <input id="inputStructure1" class="form-control" type="text" placeholder="@string:placeholder_structure" value="' . $word1['structure'] . '"></p>
        </div>
        <div class="form-group">
            <label for="inputStructure1">@string:label_brief</label>
            <input id="inputBrief1" class="form-control" type="text" placeholder="@string:placeholder_brief" value="' . $word1['brief'] . '"></p>
        </div>
        <p><button id="buttonAddWord1" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_add_word</button></p>
        <p><button id="buttonSaveWord1" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;@string:button_save_word</button>
           <button id="buttonDeleteWord1" class="btn btn-danger pull-right"><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;@string:button_delete_word</button></p>
    </form>
</div>

<div class="col-sm-6 col-md-6 col-lg-6">
' . $this->getSearchComboBox("searchWord2", "@string:placeholder_search_word2", $id2, '') . '
    <div id="wordCard2" class="wordCard"></div>
    <hr />
    <form role="form">
        <label for="selectLanguage2">@string:label_language</label>
        <div class="form-group">
        ' . $this->getLanguageDropDown(0, 'selectLanguage2') . '
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
</div>';

        return $content;
    }
}

?>