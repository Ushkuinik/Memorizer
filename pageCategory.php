<?php
include_once("page.php");
include_once("sqlWord.php");

class pageCategory extends Page
{
    /**
     * Returns script name to be included into index file
     *
     * @return string <script> tag
     */
    public function getScript()
    {
        return '<script src="js/category.js"></script>';
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
                <p><button id="buttonAddCategory" class="btn btn-primary" data-toggle="modal" data-target="#modalAddCategory"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_add_category</button></p>
            </div>
            <div class="col-sm-8 col-md-8 col-lg-8">
                ' . $this->getCategoryDropDownWithExtra(0, 'selectCategory') . '
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4">
                <button id="buttonRenameCategory" class="btn btn-success" data-toggle="modal" data-target="#modalRenameCategory"><span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;@string:button_rename_category</button>
                <button id="buttonDeleteCategory" class="btn btn-danger pull-right" data-toggle="modal" data-target="#modalDeleteCategory"><span class="glyphicon glyphicon-remove"></span></button>
            </div>

            <div class="col-sm-8 col-md-8 col-lg-8">
                ' . $this->getSearchComboBox("searchWord", "@string:placeholder_search_word", 0, '') . '
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4">
                <button id="buttonAssignWord" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;@string:button_assign_to_category</button>
            </div>


            <div class="col-sm-12 col-md-12 col-lg-12">
                <table id="tableList" class="table">
                    <thead>
                        <tr>
                            <td>@string:table_header_word</td>
                            <td>@string:table_header_translate</td>
                            <td>@string:table_header_action</td>
                        </tr>
                    </thead>
                    <tbody class="table-hover">
                    </tbody>
                </table>
            </div>
            <div class="hidden" hidden="hidden">
                <p class="action-delete-from-category"><button class="btn btn-xs btn-warning delete-from-category" data="[+word_id+]"><span class="glyphicon glyphicon-minus"></span>&nbsp;&nbsp;@string:button_delete_from_category</button></p>
            </div>

            <!-- Modal Rename Category-->
            <div class="modal fade" id="modalRenameCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">@string:modal_title_rename_category <span class="accent"></span></h4>
                  </div>
                  <div class="modal-body">
                    <input type="text" class="form-control category-name" placeholder="@string:placeholder_category_name">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@string:button_cancel</button>
                    <button id="buttonModalSave" type="button" class="btn btn-primary">@string:button_save</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Add Category -->
            <div class="modal fade" id="modalAddCategory" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@string:modal_title_add_category</h4>
                  </div>
                  <div class="modal-body">
                    <input type="text" class="form-control category-name" placeholder="@string:placeholder_category_name_new">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@string:button_cancel</button>
                    <button id="buttonModalAdd" type="button" class="btn btn-primary">@string:button_add</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Modal Delete Category -->
            <div class="modal fade" id="modalDeleteCategory" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@string:modal_title_delete_category <span class="accent"></span></h4>
                  </div>
                  <div class="modal-body">
                    <p></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@string:button_cancel</button>
                    <button id="buttonModalDelete" type="button" class="btn btn-primary">@string:button_delete</button>
                  </div>
                </div>
              </div>
            </div>
';

        return $content;
    }


}

?>