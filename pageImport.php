<?php
include_once("page.php");
include_once("sqlWord.php");

class pageImport extends Page
{
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
        <div id="import1">
            <div class="form-group">' .
                $this->getLanguageDropDown(0, 'selectLanguage') . '
            </div>
            <div class="form-group">' .
                $this->getCategoryDropDown(0, 'selectCategory', ture) . '
            </div>
            <p><button class="btn btn-success import"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_import</button></p>
            <p><textarea id="textImport" class="form-control" rows="3" value=""></textarea></p>
            <p><button class="btn btn-success import"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_import</button></p>
        </div>
        <div id="import2">
            <p><button class="btn btn-primary return"><span class="glyphicon glyphicon-arrow-left" visible></span>&nbsp;&nbsp;@string:button_return</button></p>
            <table class="table">
                <thead>
                    <tr>
                        <td>@string:table_header_status</td><td>@string:table_header_word</td><td>@string:table_header_id</td><td>@string:table_header_action</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <p><button class="btn btn-primary return"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;&nbsp;@string:button_return</button></p>
        </div>
        <div class="hidden" hidden="hidden">
            <p class="status-success">@string:status_success</p>
            <p class="status-present">@string:status_present</p>
            <p class="status-error">@string:status_error</p>
            <p class="action-add-synonym"><button class="btn btn-xs btn-success add-synonym"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_add_synonym</button></p>
        </div>
    </div>';

        return $content;
    }


}

?>