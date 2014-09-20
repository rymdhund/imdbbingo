<?php

function myLog($str){
    $str .= "\n";
    file_put_contents("../log/query.log", $str, FILE_APPEND);
}
function search($term){
    $db = openDb();
    if($db === null){
        myLog("could not open db");
        return Array();
    }
    // simple full text search
    $terms = explode(' ', $term);

    $db_terms = array();
    foreach($terms as $t){
        $db_terms[] = sprintf('name LIKE \'%%%s%%\'', $db->escapeString($t));
    }

    $sql = sprintf('SELECT name FROM movies WHERE %s limit 10', implode(' and ', $db_terms));
    $q = $db->query($sql);
    $res = Array();
    while($ret = $q->fetchArray()){
        $res[] = $ret[0];
    }
    $db->close();
    return $res;
}
function makeBoard($title){
    $db = openDb();
    if($db === null){
        myLog("could not open db");
        return Array();
    }
    $sql = sprintf('SELECT kw FROM keywords WHERE name = \'%s\'', $db->escapeString($title));
    $q = $db->query($sql);
    $kws = Array();
    while($ret = $q->fetchArray()){
        $kws[] = $ret[0];
    }
    //shuffle($kws);
    $db->close();

    if(count($kws) < 9)
      return array();

    $rand_keys = array_rand($kws, 9);
    $res = Array();
    if($rand_keys !== null){
        foreach($rand_keys as $n){
            $res[] = str_replace('-', ' ', $kws[$n]);
        }
    }
    return $res;
}
function openDb(){
    $db = new SQLite3('../keywords.db');
    if ($db){
        return $db;
    }
    return null;
}

?>
