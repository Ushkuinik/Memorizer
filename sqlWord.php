<?php
/**
 *
 */


/**
 * Gets a random word from Dictionary
 * @param $_idLanguage language id
 * @return
 */
function getRandomWord($_mysqli, $_id_language)
{
    $word           = array();
    $result['code'] = 0;

    if(!is_numeric($_id_language)) {
        $result['code']    = 1;
        $result['message'] = "Invalid language id:" . $_id_language;
    } else {
        $result['sql'] = "
SELECT
    word.id,
    word.word,
    word.structure,
    brief.brief,
    word.id_part_of_speech
FROM word
LEFT JOIN brief ON brief.id_word=word.id
WHERE id_language=" . $_id_language . "
ORDER BY RAND()
LIMIT 1";

        $sql_result        = $_mysqli->query($result['sql']);
        $result['code']    = ($sql_result) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "" : "Word request failed";

        if(($sql_result) && ($sql_result->num_rows > 0)) {
            if($object = $sql_result->fetch_object()) {
                $word['id']                = $object->id;
                $word['word']              = $object->word;
                $word['structure']         = $object->structure;
                $word['id_part_of_speech'] = $object->id_part_of_speech;
                $word['brief']             = $object->brief;
                $word['translation']       = sqlGetWordTranslations($_mysqli, $object->id, $result);
            }
        }
    }

    if($result['code'] == 0)
        $result['word'] = $word;

    unset($object);
    unset($sql_result);

    return $result;
}


//
//
//
function getWord($_mysqli, $_id, $_flag)
{
    $word           = array();
    $result['code'] = 0;

    if(!is_numeric($_id)) {
        $result['code']    = 1;
        $result['message'] = "Invalid word id:" . $_id;
    } else {
        $result['sql'] = '
SELECT
    word.id,
    word.word,
    word.structure,
    word.id_part_of_speech,
    word.id_language,
    brief.brief
FROM word
LEFT JOIN brief ON brief.id_word=word.id
WHERE word.id=' . $_id;

        $sql_result        = $_mysqli->query($result['sql']);
        $result['code']    = ($sql_result) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? '' : 'No word was found, id: ' . $_id;

        if(($sql_result) && ($sql_result->num_rows > 0)) {
            if($object = $sql_result->fetch_object()) {
                $word['id']                = $_id;
                $word['word']              = $object->word;
                $word['structure']         = $object->structure;
                $word['id_part_of_speech'] = $object->id_part_of_speech;
                $word['id_language']       = $object->id_language;
                $word['brief']             = $object->brief;
                if($_flag)
                    $word['translation']       = sqlGetWordTranslations($_mysqli, $_id, $result);
            }
        }
    }

    if($result['code'] == 0)
        $result['word'] = $word;

    unset($object);
    unset($sql_result);

    return $result;
}


function sqlGetWordTranslations($_mysqli, $_id, &$_result)
{
    $_result['sql'] = "
SELECT
    translate.id,
    word.id as id_word,
    word.word,
    word.structure,
    word.id_language
FROM translate
LEFT JOIN word ON id_word_to=word.id
WHERE id_word_from=" . $_id . "
ORDER BY weight";

    $sql_result         = $_mysqli->query($_result['sql']);
    $_result['code']    = ($sql_result) ? 0 : 1;
    $_result['message'] = ($_result['code'] == 0) ? "" : "Translations request failed";

    if($_result['code'] == 0) {
        while($object = $sql_result->fetch_object()) {
            $translation['id']          = $object->id_word;
            $translation['word']        = $object->word;
            $translation['structure']   = $object->structure;
            $translation['id_language'] = $object->id_language;
            $translations[$object->id]  = $translation;
        }
    }

    return $translations;
}


function addWord($_word, $_structure, $_brief, $_idLanguage, $_idPartOfSpeech)
{
    global $mysqli;
    $result['code'] = 0;

    $word           = $this->getSafeString($mysqli, $_word, 50);
    $structure      = $this->getSafeString($mysqli, $_structure, 50);
    $brief          = $this->getSafeString($mysqli, $_brief, 200);
    $idLanguage     = $this->getSafeString($mysqli, $_idLanguage, 10);
    $idPartOfSpeech = $this->getSafeString($mysqli, $_idPartOfSpeech, 10);

    if(empty($word)) {
        $result['code']    = 1;
        $result['message'] = "Слово не должно быть пустым!";
    }

    if($result['code'] == 0) {
        $result['sql'] = "
                INSERT INTO word (
                    word,
                    structure,
                    id_language,
                    id_part_of_speech)
                VALUES (
                    '$word',
                    '$structure',
                    '$idLanguage',
                    '$idPartOfSpeech');";

        $sql_result        = $mysqli->query($result['sql']);
        $result['code']    = ($sql_result) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "" : "Failed to add new word";

        if($result['code'] == 0) {
            $result['sql']     = "SELECT LAST_INSERT_ID() as id;";
            $sql_result        = $mysqli->query($result['sql']);
            $result['code']    = ($sql_result) ? 0 : 1;
            $result['message'] = ($result['code'] == 0) ? "" : "Failed get last added id";

            if($result['code'] == 0)
                if($object = $sql_result->fetch_object())
                    $id_word = $object->id;
        }

        if(($result['code'] == 0) && !empty($brief)) {
            $result['sql'] = "
                INSERT INTO brief (
                    id_word,
                    brief)
                VALUES (
                    '$id_word',
                    '$brief');";

            $sql_result        = $mysqli->query($result['sql']);
            $result['code']    = ($sql_result) ? 0 : 1;
            $result['message'] = ($result['code'] == 0) ? "" : "Failed to add words brief";
        }
    }

    unset($object);
    unset($sql_result);

    return $result;
}


/**
 * Edits specified word
 * @param $id
 * @return string
 */
function editWord($id)
{
    global $mysqli;
}


/**
 * Deletes specified word from Dictionary
 *
 * @param $id
 * @return string JSON structure with operation result
 */
function deleteWord($_id)
{
    global $mysqli;
    $result['code'] = 0;

    if(!is_numeric($_id)) {
        $result['code']    = 1;
        $result['message'] = "Некорректный идентификатор слова: " . $_id;
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM word WHERE id=$_id";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Слово удалено." : "Слово не было удалено.";
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM brief WHERE id_word=$_id";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Описание удалено." : "Описание не было удален.";
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM translate WHERE (id_word_from=$_id) OR (id_word_to=$_id)";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Связи переводов удалены." : "Связи переводов не были удален.";
    }

    return $result;
}


function getSafeString($_mysqli, $_string, $_length)
{
    $result = stripslashes(substr($_string, 0, 50));
    $result = $_mysqli->real_escape_string(strip_tags($result));
    $result = addcslashes($result, '%_');

    return $result;
}

