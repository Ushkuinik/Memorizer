<?php
include_once("page.php");

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
<!--
                        <select id="selectMainLanguage" name="fieldName" data-btn-class="btn-default">
                          <option value="EN">Английский</option>
                          <option value="RU">Русский</option>
                          <option value="JP">Японский</option>
                        </select>
                        <button type="button" class="btn btn-default pull-left">Параметры</button>
-->
                        <!-- Single button -->
                        <div class="btn-group">
                            <button id="selectMainLanguage" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-value="3">Японский <span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="2">Английский</a></li>
                                <li><a href="1">Русский</a></li>
                                <li><a href="3">Японский</a></li>
                            </ul>
                        </div>

                        <div id="radioWordStructure" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="options" value="0"> Слово
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="options" value="1"> Структура
                            </label>
                        </div>

                        <div class="clearfix"></div>
                        <br />
                        <div class="card">
                            <h1 id="word">&nbsp;</h1>
                            <h3 id="brief" class="brief"></h3>
                            <div id="translation" hidden>&nbsp;</div>
                        </div>
                        <br/>
                        <button type="button" class="btn btn-primary btn-lg">Назад</button>
                        <button id="buttonHelp" type="button" class="btn btn-warning btn-lg">Помощь</button>
                        <button type="button" class="btn btn-success btn-lg">Ok</button>
                        <button id="buttonNext" type="button" class="btn btn-primary btn-lg pull-right">Вперед</button>';


        $content .= '<div id="debug"></div>';
        $content .= '<div id="result"></div>';
        return $content;
    }


    /**
     * Gets a random word from Dictionary
     * @param $_idLanguage language id
     * @return string JSON formed result structure
     */
    public function ajaxGetRandom($_idLanguage)
    {
        //FIXME: check &_idLanguage
        global $mysqli;
        $content = '';

        $sql = "
SELECT word.id, word.word, word.structure, brief.brief, word.id_part_of_speech
FROM word
LEFT JOIN brief ON brief.id_word=word.id
WHERE id_language=" . $_idLanguage . "
ORDER BY RAND()
LIMIT 1";

        $result = $mysqli->query($sql);
        $result_code = ($result) ? 0 : 1;

        if ($result) {
            if ($object = $result->fetch_object()) {

                $content .= '
    "wordId": "' . $object->id . '",
    "wordWord": "' . $object->word . '",
    "wordStructure": "' . $object->structure . '",
    "wordBrief": "' . $object->brief . '",
    "partOfSpeech": "' . $object->id_part_of_speech . '"';

                $sql = "
SELECT translate.id, word.word, word.structure, word.id_language
FROM translate
LEFT JOIN word ON id_word_to=word.id
WHERE id_word_from=" . $object->id ."
ORDER BY weight";

                $result = $mysqli->query($sql);
                $result_code = ($result) ? 0 : 1;

                if ($result) {
                    $content .= ', "wordTranslation": {';

                    $translations = '';
                    while ($object = $result->fetch_object()) {
                        if(!empty($translations))
                            $translations .= ', ';
                        $translations .= '"'. $object->id . '": {"transWord": "' . $object->word . '", "transStructure": "' . $object->structure . '", "transLanguageId": "' . $object->id_language . '"}';
                    }
                    $content .= $translations;
                    $content .= '}';
                }
                else {
                    $result_message = "SQL request failed.";
                    $content .= '
    "result_code": "' . $result_code . '",
    "result_message: "' . $result_message . '",
    "sql": "' . $sql . '"';
                }




            }
        }
        else {
            $result_message = "SQL request failed.";
            $content .= '
    "result_code": "' . $result_code . '",
    "result_message: "' . $result_message . '",
    "sql": "' . $sql . '"';
        }



        return '{' . $content . '}';
    }


    /**
     * Adds new word to Dictionary
     * @param $_name
     * @param $_description
     * @return string
     */
    public function ajaxAdd($_name, $_description)
    {
        global $mysqli;
        $row = '';
        $result_code = 0;
        $result_message = '';
        $sql = '';


        $content =
            '{
                "result_code": "' . $result_code . '",
    "result_message: "' . $result_message . '",
    "sql": "' . $sql . '",
    "aux": null"
}';

        return $content;
    }


    /**
     * Edits specified word
     * @param $id
     * @return string
     */
    public function ajaxEdit($id)
    {
        global $mysqli;

        $result_code = 0;
        $result_message = "";
        $sql = '';

        $content =
            '{
                "result_code": "' . $result_code . '",
    "result_message: "' . $result_message . '",
    "sql": "' . $sql . '",
    "aux": null"
}';

        return $content;
    }


    /**
     * Deletes specified word from Dictionary
     *
     * @param $id
     * @return string JSON structure with operation result
     */
    public function ajaxDelete($id)
    {
        global $mysqli;

        if (!is_numeric($id)) {
            $result_code = 1;
            $result_message = 'Incorrect word id: ' . $id . '';
        } else {
            //TODO: Read the word first
            $sql = "DELETE FROM words WHERE id=$id";
            $result_code = ($mysqli->query($sql)) ? 0 : 1;
            $result_message = ($result_code == 0) ? 'Word ' . $id . ' was removed from the Dictionary.' : 'Word ' . $id . ' was NOT removed from the Dictionary.';
        }

        $content =
            '{
                "result_code": "' . $result_code . '",
    "result_message: "' . $result_message . '",
    "sql": "' . $sql . '",
    "aux": null"
}';

        return $content;
    }
}

?>