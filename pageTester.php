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
    <div class="col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="btn-group">
                    <button id="selectMainLanguage" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-value="3">@string:language_japanese <span class="caret"></span></button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="2">@string:language_english</a></li>
                        <li><a href="1">@string:language_russian</a></li>
                        <li><a href="3">@string:language_japanese</a></li>
                    </ul>
                </div>

                <div id="radioWordStructure" class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default active">
                        <input type="radio" name="options" value="0">@string:radio_word
                    </label>
                    <label class="btn btn-default">
                        <input type="radio" name="options" value="1">@string:radio_structure
                    </label>
                </div>

                <div class="card">
                    <h1 id="word">&nbsp;</h1>
                    <h3 id="brief" class="brief"></h3>
                    <div id="translation" hidden>&nbsp;</div>
                </div>
                <br/>
                <button type="button" class="btn btn-primary btn-lg">@string:button_prev</button>
                <button id="buttonHelp" type="button" class="btn btn-warning btn-lg">@string:button_help</button>
                <button type="button" class="btn btn-success btn-lg">@string:button_ok</button>
                <button id="buttonNext" type="button" class="btn btn-primary btn-lg pull-right">@string:button_next</button>
            </div>
        </div>
    </div>';


        return $content;
    }
}

?>