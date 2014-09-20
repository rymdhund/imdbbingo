<?php
require_once('functions.php');

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
