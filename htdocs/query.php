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
    $sql = sprintf('SELECT name FROM movies WHERE name LIKE \'%s%%\' limit 10', $db->escapeString($term));
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
    shuffle($kws);
    $db->close();


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

if(array_key_exists('term', $_GET)){
    $term = $_GET['term'];
    myLog("searching $term");

    $res = search($term);
    echo json_encode($res);
}else if(array_key_exists('title', $_GET)){
    $title = $_GET['title'];
    if(mb_detect_encoding($_GET['title'], "UTF-8, ISO-8859-1") != "UTF-8"){
        $title = utf8_encode($title);
    }
    myLog("getting keywords for $title");
    $board = makeBoard($title);
    echo json_encode($board);
}else{
    echo json_encode(Array());
}

?>
