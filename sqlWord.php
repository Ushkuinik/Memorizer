<?php
/**
 *
 */


/**
 * Gets a random word from Dictionary
 * @param $_language_id language id
 * @return
 */
function sqlGetRandomWord($_mysqli, $_language_id, $_category_id)
{
    $word           = array();
    $result['code'] = 0;

    if(!is_numeric($_language_id)) {
        $result['code']    = 1;
        $result['message'] = "Invalid language id:" . $_language_id;
    } else {
        if($_category_id > 0)
            $category_condition = " AND category_word.category_id=$_category_id ";
        else
            $category_condition = '';
/*        $result['sql'] = "
SELECT
    word.id,
    word.word,
    word.structure,
    brief.brief,
    word.id_part_of_speech
FROM word
LEFT JOIN brief ON brief.id_word=word.id
LEFT JOIN category_word ON category_word.word_id=word.id
WHERE id_language=$_language_id $category_condition
ORDER BY RAND()
LIMIT 1";*/
        $language_id = (int)$_language_id;
        $category_id = (int)$_category_id;
        if($category_id > 0)
            $category_condition = " AND cw.category_id=$category_id ";
        else
            $category_condition = '';

        $result['sql'] = "
SELECT
	w1.id                 as id1,
	w1.word               as word1,
	w1.structure          as structure1,
	b1.brief              as brief1,
	w1.id_language        as language1,
	w1.id_part_of_speech  as id_part_of_speech1,
	w2.id                 as id2,
	w2.word               as word2,
	w2.structure          as structure2,
	w2.id_language        as language2,
	w2.id_part_of_speech  as id_part_of_speech2,
	b2.brief              as brief2
FROM word w1
LEFT JOIN brief b1 ON b1.id_word=w1.id
LEFT JOIN category_word cw ON cw.word_id=w1.id
LEFT JOIN translate t ON t.id_word_from=w1.id
LEFT JOIN word w2 ON w2.id=t.id_word_to
LEFT JOIN brief b2 ON b2.id_word=w2.id
WHERE (w1.id_language=$language_id OR w2.id_language=$language_id) $category_condition
ORDER BY RAND()
LIMIT 1;";

        $sql_result        = $_mysqli->query($result['sql']);
        $result['code']    = ($sql_result) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "" : "Word request failed";

        if(($sql_result) && ($sql_result->num_rows > 0)) {
            if($object = $sql_result->fetch_object()) {
                if($object->language1 == $language_id) {
                    $word['id']                = $object->id1;
                    $word['word']              = $object->word1;
                    $word['structure']         = $object->structure1;
                    $word['id_part_of_speech'] = $object->id_part_of_speech1;
                    $word['brief']             = $object->brief1;
                } elseif($object->language2 == $language_id) {
                    $word['id']                = $object->id2;
                    $word['word']              = $object->word2;
                    $word['structure']         = $object->structure2;
                    $word['id_part_of_speech'] = $object->id_part_of_speech2;
                    $word['brief']             = $object->brief2;
                } else {
                    $result['code']    = 1;
                    $result['message'] = "Something gone wrong";
                }
                if($result['code'] == 0)
                    $word['translation'] = sqlGetWordTranslations($_mysqli, $word['id'], $result);
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
                    $word['translation'] = sqlGetWordTranslations($_mysqli, $_id, $result);
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
function sqlGetWordByWord($_mysqli, $_word)
{
    $word           = array();
    $result['code'] = 0;

    $result['sql'] = "
SELECT
    word.id
FROM word
WHERE word.word LIKE '$_word'";

    $sql_result        = $_mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? '' : 'SQL request failed';

    $word['id'] = 0;
    if($result['code'] == 0)
        if ($sql_result->num_rows > 0)
            if($object = $sql_result->fetch_object())
                $result['id_word'] = $object->id;
            else {
                $result['code'] = 1;
                $result['message'] = 'Failed to fetch object';
            }

    unset($object);
    unset($sql_result);

    return $result;
}


function sqlGetWordTranslations($_mysqli, $_id, &$_result) //FIXME: rework to return result
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
        if(empty($structure))
            $structure = $word;
        if(empty($idPartOfSpeech))
            $idPartOfSpeech = 1;
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
            $word_id = $result['last_id'];
            if(($result['code'] == 0) && !empty($brief)) {
                $result = sqlAddBrief($word_id, $brief);
            }
            $result['id_word'] = $word_id; // restoring word_id
        }
    }

    unset($object);
    unset($sql_result);

    if($result['code'] == 0) {
        $result['message'] = "Word <b>" . $word . "</b> was added successfully";
    }

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
            $result['last_id'] = $object->id;
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
 * Parameters should be sql-injection safe
 * @param $_id - brief id
 * @return returns result structure
 */
function sqlDeleteBrief($_id)
{
    global $mysqli;

    $result['sql'] = "DELETE FROM brief WHERE id='$_id';";
    $sql_result        = $mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? "" : "Failed to delete words brief";
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

            if($result['code'] == 0) {
                $result = sqlGetBriefByMemo($id);
                if($result['code'] == 0) {
                    $brief_id = $result['brief_id'];
                    if($brief_id > 0) // if brief exists
                        if(!empty($brief))
                            $result = sqlUpdateBrief($brief_id, $id, $brief);
                        else
                            $result = sqlDeleteBrief($brief_id);
                    else
                        if(!empty($brief))
                            $result = $result = sqlAddBrief($id, $brief);
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
 * @param $_id_word word id (safe)
 * @return record id, 0 if no such record
 */
function sqlGetBriefByMemo($_id_word)
{
    global $mysqli;

    $id = 0;
    $result['sql'] = "
        SELECT *
        FROM brief
        WHERE id_word='$_id_word'
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
        $result['sql']     = "DELETE FROM brief WHERE id_word=$_id";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Brief deleted." : "Brief can't be deleted.";
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM translate WHERE (id_word_from=$_id) OR (id_word_to=$_id)";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Links deleted." : "Links can't be deleted.";
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM category_word WHERE word_id=$_id";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Assignments deleted." : "Assignments can't be deleted.";
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM word WHERE id=$_id";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Word deleted." : "Word can't be deleted.";
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
        return $result;
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
        return $result;
    }

    $result['sql']     = "DELETE FROM translate WHERE ((id_word_from=$_id1) AND (id_word_to=$_id2)) OR ((id_word_from=$_id2) AND (id_word_to=$_id1))";
    $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? "Links deleted." : "Links can't be deleted.";

    return $result;
}


function sqlGetLinkById1Id2($_id1, $_id2) //FIXME: rework on return result instead if id
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
    $result = trim($result);

    return $result;
}

function sqlImportWords($_data, $_id_language, $_id_category) {
    global $mysqli;
    $data = str_replace("\n\r", "\n", $_data);
    $lines = explode("\n", $data);
    foreach($lines as $k => $line) {
        if(empty($line))
            continue; // skip empty lines
        $parts = explode(",", $line);
        if(count($parts) == 0) {
            $result['code'] = '1';
            $result['message'] = 'Line is empty after explode';
            break;
        } else {
            $word           = getSafeString($mysqli, $parts[0], 50);
            $structure      = $word;
            $brief          = '';
            $part_of_speech = '1';

            if(count($parts) > 1) {
                $structure      = getSafeString($mysqli, $parts[1], 50);
            }
            if(count($parts) > 2) {
                $brief          = getSafeString($mysqli, $parts[2], 200);
            }
            if(count($parts) > 3) {
                $part_of_speech = getSafeString($mysqli, $parts[3], 10);
            }

            $result_inner = sqlGetWordByWord($mysqli, $word);

            if($result_inner['id_word'] == 0) {
                $result_inner = sqlAddWord($word, $structure, $brief, $_id_language, $part_of_speech);
                if($result_inner['code'] == 0) {
                    $status_code = 0;    // successfully added
                    $word_id = $result_inner['id_word'];

                    if($_id_category > 0) {
                        $result_inner = sqlAssignWordToCategory($word_id, $_id_category); // this call will overwrite $result_inner['id_word']
                        $result_inner['id_word'] = $word_id; // restore overwritten word_id
                        //FIXME: rework functions to accept result as parameter to avoid previous data rewrite
                    }
                    if($result_inner['code'] != 0)
                        $status_code = 3; // error during assignment to category
                }
                else {
                    $status_code = 2;    // error during adding
                }
            }
            else {
                $status_code = 1;    // word already present
                $status['word']           = word;
                $status['structure']      = $structure;
                $status['brief']          = $brief;
                $status['part_of_speech'] = $part_of_speech;
                $status['language_id']    = $_id_language;
            }

            $status['word'] = $word;
            $status['code'] = $status_code;
            $status['id'] = $result_inner['id_word'];

            $result['status'][$k] = $status;
            $result['code'] = $result_inner['code'];
            $result['message'] = $result_inner['message'];
            $result['sql'] = $result_inner['sql'];
        }
    }
    return $result;
}


//
//
//
function sqlGetCategoryList()
{
    global $mysqli;
    $result['code'] = 0;

    $result['sql'] = "
SELECT
    category.id,
    category.name
FROM category";

    $sql_result        = $mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? '' : 'SQL request failed';

    if($result['code'] == 0)
        if ($sql_result->num_rows > 0)
            while($object = $sql_result->fetch_object()) {
                $result['categories'][$object->id] = $object->name;
            }

    unset($object);
    unset($sql_result);

    return $result;
}


function sqlAddCategory($_name) {
    global $mysqli;
    $result['code'] = 0;

    $name = getSafeString($mysqli, $_name, 50);

    if(empty($name)) {
        $result['code']    = 1;
        $result['message'] = "The category name should not be empty";
    }

    if($result['code'] == 0) {
        $result['sql'] = "
                INSERT INTO category (
                    name)
                VALUES (
                    '$name');";

        $sql_result        = $mysqli->query($result['sql']);
        $result['code']    = ($sql_result) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "" : "Failed to add new category";

        if($result['code'] == 0) {
            $result = sqlGetLastInsertedId();
            if($result['code'] == 0) {
                $result['category_id'] = $result['last_id'];
            }
        }
    }

    unset($object);
    unset($sql_result);

    if($result['code'] == 0) {
        $result['message'] = "Category <b>$name</b> was added successfully";
    }

    return $result;
}


/**
 * Edits specified word
 * @param $_id
 * @return string
 */
function sqlEditCategory($_id, $_name)
{
    global $mysqli;
    $result['code'] = 0;

    if(!is_numeric($_id)) {
        $result['code']    = 1;
        $result['message'] = "Invalid category id: [" . $_id . "]";
    }
    else {
        $id   = (int)($_id);
        $name = getSafeString($mysqli, $_name, 50);

        if($id == 0) {
            $result['code']    = 1;
            $result['message'] = "Invalid category id: [" . $_id . "]";
        }

        if($result['code'] == 0) {
            $result['sql'] = "
                    UPDATE category
                    SET name='$name'
                    WHERE id='$id';";

            $sql_result        = $mysqli->query($result['sql']);
            $result['code']    = ($sql_result) ? 0 : 1;
            $result['message'] = ($result['code'] == 0) ? "" : "Failed to update category";
        }

        unset($object);
        unset($sql_result);
    }

    return $result;
}


/**
 * Deletes specified word from Dictionary
 *
 * @param $_id unsafe word id
 * @return string JSON structure with operation result
 */
function sqlDeleteCategory($_id)
{
    global $mysqli;
    $result['code'] = 0;

    if(!is_numeric($_id)) {
        $result['code']    = 1;
        $result['message'] = "Invalid word id: " . $_id;
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM category_word WHERE category_id=$_id";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "" : "Assignments can't be deleted.";
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM category WHERE id=$_id";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "" : "Category can't be deleted.";
    }
    return $result;
}



function sqlGetCategoryAssignments($_category_id) {
    global $mysqli;
    $category_id = (int)($_category_id);
    if((!is_numeric($category_id)) or ($category_id == 0)) {
        $result['code']    = 1;
        $result['message'] = "Invalid id: [" . $_category_id . ']';
        return $result;
    }

    if($_category_id > 0)
        $result['sql'] = "
            SELECT
                w1.id   as word_id1,
                w1.word as word1,
                w2.id   as word_id2,
                w2.word as word2
            FROM category_word cw
            LEFT JOIN word w1     ON w1.id=cw.word_id
            LEFT JOIN translate t ON t.id_word_from=cw.word_id
            LEFT JOIN word w2     ON w2.id=t.id_word_to
            WHERE cw.category_id=$category_id";
    elseif($_category_id == -1)
        $result['sql'] = "
        SELECT
            w1.id   as word_id1,
            w1.word as word1,
            w2.id   as word_id2,
            w2.word as word2
        FROM word w1
        LEFT JOIN translate t ON t.id_word_from=w1.id
        LEFT JOIN word w2     ON w2.id=t.id_word_to
        WHERE w1.id NOT IN (
            SELECT word.id
            FROM word
            INNER JOIN category_word
            ON word.id = category_word.word_id)
        AND w2.id NOT IN (
            SELECT word.id
            FROM word
            INNER JOIN category_word
            ON word.id = category_word.word_id);";
    elseif($_category_id == -2)
        $result['sql'] = "
        SELECT
            w1.id   as word_id1,
            w1.word as word1
        FROM word w1
        LEFT JOIN translate t ON t.id_word_from=w1.id
        LEFT JOIN word w2     ON w2.id=t.id_word_to
        WHERE w1.id NOT IN (
            SELECT word.id
            FROM word
            INNER JOIN translate
            ON word.id = translate.id_word_from);";

    $sql_result        = $mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? '' : 'Failed to make sql request';
    if(($sql_result) && ($sql_result->num_rows > 0)) {
        while($object = $sql_result->fetch_object()) {
            $id   = $object->word_id1;
            $word = $object->word1;
            $translation_id   = $object->word_id2;
            $translation_word = $object->word2;

            if(!isset($result['words'][$id]))
                $result['words'][$id]['word'] = $word;

            if($translation_id > 0)
                $result['words'][$id]['translations'][$translation_id] =  $translation_word;
        }
    }

    return $result;
}


/**
 * @param $_word_id unsafe word id
 * @param $_category_id unsafe category id
 * @return mixed
 */
function sqlAssignWordToCategory($_word_id, $_category_id)
{
    global $mysqli;
    $word_id = (int)($_word_id);
    $category_id = (int)($_category_id);
    if(($word_id == 0) or ($category_id == 0)) {
        $result['code']    = 1;
        $result['message'] = "Invalid id";
        return $result;
    }
    $result = sqlGetAssignment($mysqli, $word_id, $category_id);
    if($result['code'] == 0)
    {
        $id = $result['assignment_id'];
        if($id == 0) {
            $result['sql'] = "
                    INSERT INTO category_word (
                        category_id,
                        word_id)
                    VALUES (
                        '$category_id',
                        '$word_id');";

            $sql_result        = $mysqli->query($result['sql']);
            $result['code']    = ($sql_result) ? 0 : 1;
            $result['message'] = ($result['code'] == 0) ? "Added assignment" : "Failed to assign word to category";
            if($result['code'] == 0) {
                $result = sqlGetLastInsertedId();
                $result['assignment_id'] = $result['last_id'];
            }
        } else {
            $result['code']    = 1;
            $result['message'] = "The word is already assigned to the category";
        }
    }

    return $result;
}


function sqlDeleteWordFromCategory($_word_id, $_category_id)
{
    global $mysqli;
    $result['code'] = 0;
    $word_id = (int)($_word_id);
    $category_id = (int)($_category_id);
    if(($word_id == 0) or ($category_id == 0)) {
        $result['code']    = 1;
        $result['message'] = "Invalid id";
        return $result;
    }
    if($result['code'] == 0) {
        $result['sql']     = "DELETE FROM category_word WHERE (word_id=$word_id) AND (category_id=$category_id)";
        $result['code']    = ($mysqli->query($result['sql'])) ? 0 : 1;
        $result['message'] = ($result['code'] == 0) ? "Assignment deleted" : "Assignment can't be deleted";
    }
    return $result;
}

/**
 * Parameters should be sql-injection safe
 * @param $_mysqli
 * @param $_word_id safe
 * @param $_category_id safe
 * @return mixed
 */
function sqlGetAssignment($_mysqli, $_word_id, $_category_id) {

    $result['sql']     = "
        SELECT id
        FROM category_word
        WHERE category_id=$_category_id AND
              word_id=$_word_id;";

    $sql_result        = $_mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? "" : "Failed to make sql request";

    $result['assignment_id'] = 0;
    if($result['code'] == 0)
        if($object = $sql_result->fetch_object())
            $result['assignment_id'] = $object->id;

    return $result;
}


function sqlGetWordsWithoutCategory() {
    global $mysqli;

    $result['sql'] = "
        SELECT
            w1.id,
            w1.word,
            w2.id,
            w2.word
        FROM word w1
        LEFT JOIN translate t ON t.id_word_from=w1.word_id
        LEFT JOIN word w2     ON w2.id=t.id_word_to
        WHERE w1.id NOT IN (
            SELECT word.id
            FROM word
            INNER JOIN category_word
            ON word.id = category_word.word_id);";

    $sql_result        = $mysqli->query($result['sql']);
    $result['code']    = ($sql_result) ? 0 : 1;
    $result['message'] = ($result['code'] == 0) ? '' : 'Failed to make sql request';
    if(($sql_result) && ($sql_result->num_rows > 0)) {
        while($object = $sql_result->fetch_object()) {
            $id   = $object->word_id1;
            $word = $object->word1;
            $translation_id   = $object->word_id2;
            $translation_word = $object->word2;

            if(!isset($result['words'][$id]))
                $result['words'][$id]['word'] = $word;

            if($translation_id > 0)
                $result['words'][$id]['translations'][$translation_id] =  $translation_word;
        }
    }

    return $result;
}