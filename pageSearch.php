<?php
include_once("page.php");

class pageSearch extends Page
{


    //
    //
    //
    public function ajaxSuggest($_string)
    {
        global $mysqli;

        $_string = stripslashes(substr($_string, 0, 50));
        $string  = $mysqli->real_escape_string(strip_tags(substr($_string, 0, 50)));
        $string  = addcslashes($string, '%_');

        if(empty($string)) {
            $result['code']    = 1;
            $result['message'] = "Строка поиска не должна быть пустой!";
        }

        if($result['code'] == 0) {
            $result['$sql'] =
                "SELECT id, word, structure
FROM `word`
WHERE
  `word` LIKE '%$string%'
LIMIT 10;";

            $sql_result        = $mysqli->query($result['$sql']);
            $result['code']    = ($sql_result) ? 0 : 1;
            $result['message'] = ($result['code'] == 0) ? "Запрос выполен успешно." : "Запрос не был выполнен.";

            if($result['code'] == 0) {
                while($object = $sql_result->fetch_object()) {
                    $structure = $object->structure;
                    $structure = str_replace(array('[', ']'), '', $structure);
//                    $structure = str_replace('!', '&#x301;', $structure);

//                    $word = $object->word;
                    $word = $this->markString($structure, $_string);
//                    $word = substr($word)

                    $result['data'] .= '<li><a class="suggestItem " href="' . $object->id . '">' . $word . '</a></li>';
                }
            }
        }

        unset($object);
        unset($sql_result);

        return $result;
    }


    function markString($_source, $_target)
    {
        $result = $_source;
        mb_internal_encoding("UTF-8");
        $span1 = '<span class="suggestEmphasis">';
        $span2 = '</span>';

        $position_accent = mb_stripos($result, '!');
        $result          = str_replace('!', '', $result);
        $position        = mb_stripos($result, $_target);

        if($position !== false)
            $result = mb_substr($result, 0, $position) . $span1 . mb_substr($result, $position, mb_strlen($_target)) . $span2 . mb_substr($result, $position + mb_strlen($_target));

        if($position_accent) {
            if($position_accent <= $position) {
            } else if($position_accent <= ($position + mb_strlen($_target)))
                $position_accent += mb_strlen($span1);
            else
                $position_accent += mb_strlen($span1) + mb_strlen($span2);

            $result = mb_substr($result, 0, $position_accent) . '&#x301;' . mb_substr($result, $position_accent, mb_strlen($result));
        }

        return $result;
    }
}

?>