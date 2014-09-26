<?php
include_once("page.php");
include_once("sqlWord.php");

class pageImport extends Page
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
        return '<script src="js/import.js"></script>';
    }


    /**
     * @return string
     */
    public function getContent()
    {
        global $mysqli;
        global $id;

        $content = '
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="form-group">' .
            $this->getLanguageDropDown(0, 'selectLanguage') . '
        </div>
        <div class="form-group">' .
            $this->getCategoryDropDown(0, 'selectCategory') . '
        </div>
        <p><button class="btn btn-success import"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_import</button></p>
        <p><textarea id="textImport" class="form-control" rows="3"></textarea></p>
        <p><button class="btn btn-success import"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_import</button></p>
    </div>';

        return $content;
    }


}

?>