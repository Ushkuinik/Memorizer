<?php
/**
 *
 */


/**
 * Gets a random word from Dictionary
 * @param $_id_language language id
 * @return
 */
function sqlGetRandomWord($_mysqli, $_id_language)
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
function sqlGetWord($_mysqli, $_id, $_flag)
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


/**
 * @param $_word
 * @param $_structure
 * @param $_brief
 * @param $_idLanguage
 * @param $_idPartOfSpeech
 * @return mixed
 */
function sqlAddWord($_word, $_structure, $_brief, $_idLanguage, $_idPartOfSpeech)
{
    global $mysqli;
    $result['code'] = 0;

    $word           = getSafeString($mysqli, $_word, 50);
    $structure      = getSafeString($mysqli, $_structure, 50);
    $brief          = getSafeString($mysqli, $_brief, 200);
    $idLanguage     = getSafeString($mysqli, $_idLanguage, 10);
    $idPartOfSpeech = getSafeString($mysqli, $_idPartOfSpeech, 10);

    if(empty($word)) {
        $result['code']    = 1;
        $result['message'] = "The word should not be empty";
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
            $result = sqlGetLastInsertedId();
            if(($result['code'] == 0) && !empty($brief)) {
                $id_word = $result['id_word'];
                $result = sqlAddBrief($id_word, $brief);
            }
        }

    }

    unset($object);
    unset($sql_result);

    return $result;
}


/**
 * @return mixed
 */
function sqlGetLastInsertedId()
{
    global $mysqli;

    $result['sql']     = "SELECT LAST_INSERT_ID() as id;";
    $sql_result        = $mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? "" : "Failed get last added id";

    if($result['code'] == 0)
        if($object = $sql_result->fetch_object())
            $result['id_word'] = $object->id;
    return $result;
}


/**
 * Parameters should be sql-injection safe
 * @param $_id_word - word id
 * @param $_brief - brief description of the word
 * @return returns result structure
 */
function sqlAddBrief($_id_word, $_brief)
{
    global $mysqli;

    $result['sql'] = "
                INSERT INTO brief (
                    id_word,
                    brief)
                VALUES (
                    '$_id_word',
                    '$_brief');";

    $sql_result        = $mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? "" : "Failed to add words brief";
    return $result;
}


/**
 * Parameters should be sql-injection safe
 * @param $_id_word - word id
 * @param $_brief - brief description of the word
 * @return returns result structure
 */
function sqlUpdateBrief($_id, $_id_word, $_brief)
{
    global $mysqli;

    $result['sql'] = "
        UPDATE brief
        SET
            id_word='$_id_word',
            brief='$_brief'
        WHERE
            id='$_id';";

    $sql_result        = $mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? "" : "Failed to update words brief";
    return $result;
}


/**
 * Edits specified word
 * @param $_id
 * @return string
 */
function sqlEditWord($_id, $_word, $_structure, $_brief, $_idLanguage, $_idPartOfSpeech)
{
    global $mysqli;
    $result['code'] = 0;

    if(!is_numeric($_id)) {
        $result['code']    = 1;
        $result['message'] = "Invalid word id:" . $_id;
    }
    else {
        $id             = (int)($_id);
        $word           = getSafeString($mysqli, $_word, 50);
        $structure      = getSafeString($mysqli, $_structure, 50);
        $brief          = getSafeString($mysqli, $_brief, 200);
        $idLanguage     = getSafeString($mysqli, $_idLanguage, 10);
        $idPartOfSpeech = getSafeString($mysqli, $_idPartOfSpeech, 10);

        if($id == 0) {
            $result['code']    = 1;
            $result['message'] = "Invalid word id: [" . $_id . "]";
        }

        if($result['code'] == 0) {
            $result['sql'] = "
                    UPDATE word
                    SET
                        word='$word',
                        structure='$structure',
                        id_language='$idLanguage',
                        id_part_of_speech='$idPartOfSpeech'
                    WHERE id='$id';";

            $sql_result        = $mysqli->query($result['sql']);
            $result['code']    = ($sql_result) ? 0 : 1;
            $result['message'] = ($result['code'] == 0) ? "" : "Failed to update word";

            if(($result['code'] == 0) && !empty($brief)) {
                $result = sqlGetBriefByMemo($id);
                if($result['code'] == 0) {
                    $brief_id = $result['brief_id'];
                    if($brief_id > 0)
                        $result = sqlUpdateBrief($brief_id, $id, $brief);
                    else
                        $result = sqlAddBrief($id, $brief);
                }
            }
        }

        unset($object);
        unset($sql_result);
    }

    return $result;
}


/**
 * Checks if description for specified word exists
 * @param $_word_id word id (safe)
 * @return record id, 0 if no such record
 */
function sqlGetBriefByMemo($_word_id)
{
    global $mysqli;

    $id = 0;
    $result['sql'] = "
        SELECT *
        FROM brief
        WHERE id_word='$_word_id'
        LIMIT 1;";
    $sql_result = $mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? "" : "Failed to select brief record";
    if($result['code'] == 0) {
        $object = $sql_result->fetch_object();
        if($object) {
            $result['brief_id'] = $object->id;
        }
    }
    return $result;
}


/**
 * Deletes specified word from Dictionary
 *
 * @param $_id unsafe word id
 * @return string JSON structure with operation result
 */
function sqlDeleteWord($_id)
{
    global $mysqli;
    $result['code'] = 0;

    if(!is_numeric($_id)) {
        $result['code']    = 1;
        $result['message'] = "Invalid word id: " . $_id;
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM word WHERE id=$_id";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Word deleted." : "Word can't be deleted.";
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM brief WHERE id_word=$_id";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Brief deleted." : "Brief can't be deleted.";
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM translate WHERE (id_word_from=$_id) OR (id_word_to=$_id)";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Links deleted." : "Links can't be deleted.";
    }

    return $result;
}


/**
 * @param $_id1 unsafe word id
 * @param $_id2 unsafe word id
 * @return mixed
 */
function sqlLinkWords($_id1, $_id2)
{
    global $mysqli;
    $id1 = (int)($_id1);
    $id2 = (int)($_id2);
    if(($id1 == 0) or ($id2 == 0)) {
        $result['code']    = 1;
        $result['message'] = "Invalid word id";
        return;
    }
    $id = sqlGetLinkById1Id2($id1, $id2);
    if($id == 0) {
        $result['sql'] = "
                INSERT INTO translate (
                    id_word_from,
                    id_word_to)
                VALUES (
                    '$id1',
                    '$id2');";

        $sql_result        = $mysqli->query($result['sql']);
        $result['code']    = ($sql_result) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "" : "Failed to link words";
    }

    $id = sqlGetLinkById1Id2($id2, $id1);
    if($id == 0) {
        $result['sql'] = "
                INSERT INTO translate (
                    id_word_from,
                    id_word_to)
                VALUES (
                    '$id2',
                    '$id1');";

        $sql_result        = $mysqli->query($result['sql']);
        $result['code']    = ($sql_result) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "" : "Failed to link words";
    }
    return $result;
}


function sqlUnlinkWords($_id1, $_id2)
{
    global $mysqli;
    $id1 = (int)($_id1);
    $id2 = (int)($_id2);
    if(($id1 == 0) or ($id2 == 0)) {
        $result['code']    = 1;
        $result['message'] = "Invalid word id";
        return;
    }

    $result['sql']     = "DELETE FROM translate WHERE ((id_word_from=$_id1) AND (id_word_to=$_id2)) OR ((id_word_from=$_id2) AND (id_word_to=$_id1))";
    $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? "Links deleted." : "Links can't be deleted.";

    return $result;
}


function sqlGetLinkById1Id2($_id1, $_id2)
{
    global $mysqli;
    $id = 0;
    $result['sql'] = "
        SELECT *
        FROM translate
        WHERE (id_word_from='$_id1' AND id_word_to='$_id2')
        LIMIT 1;";
    $sql_result = $mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? "" : "Failed to select translation link";
    $object = $sql_result->fetch_object();
    if($object) {
        $id = $object->id;
    }

    return $id;
}


function getSafeString($_mysqli, $_string, $_length)
{
    $result = stripslashes(substr($_string, 0, $_length));
    $result = $_mysqli->real_escape_string(strip_tags($result));
    $result = addcslashes($result, '%_');

    return $result;
}

