<?php
include_once("page.php");
include_once("sqlWord.php");

class pageTester extends Page
{
    /**
     * Returns script name to be included into index file
     *
     * @return string <script> tag
     */
    public function getScript()
    {
        return '<script src="js/tester.js"></script>';
    }


    /**
     * @return string
     */
    public function getContent()
    {
        global $mysqli;

        $content = '
    <div class="col-sm-4 col-md-4 col-lg-4">
        ' . $this->getCategoryDropDown(0, 'selectCategory', true) . '
    </div>

    <div class="col-sm-4 col-md-4 col-lg-4">
        ' . $this->getLanguageDropDown(3, 'selectMainLanguage') . '
    </div>

    <div class="col-sm-4 col-md-4 col-lg-4">
        <div id="radioWordStructure" class="btn-group pull-right" data-toggle="buttons">
            <label class="btn btn-default active">
                <input type="radio" name="options" value="0">@string:radio_word
            </label>
            <label class="btn btn-default">
                <input type="radio" name="options" value="1">@string:radio_structure
            </label>
        </div>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <button id="buttonPrevious" type="button" class="btn btn-primary btn-lg">@string:button_prev</button>
                <button id="buttonHelp" type="button" class="btn btn-warning btn-lg">@string:button_help</button>
                <button type="button" class="btn btn-success btn-lg">@string:button_ok</button>
                <button id="buttonNext" type="button" class="btn btn-primary btn-lg pull-right">@string:button_next</button>
                <div class="card">
                    <h1 id="word">&nbsp;</h1>
                    <h3 id="brief" class="brief"></h3>
                    <div id="translation" hidden>&nbsp;</div>
                </div>
            </div>
        </div>
    </div>';


        return $content;
    }
}

?>