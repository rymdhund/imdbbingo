<?php
include('header.php');
if(array_key_exists('movie', $_GET)){
  require_once('functions.php');

  $board = makeBoard($_GET['movie']);
  if(count($board) >= 9){
    printf('<h3>%s</h3>', htmlspecialchars($_GET['movie']));
    echo '<table id="table">';
    for($i = 0; $i < 3; $i++){
      echo '<tr class="row">';
      for($j = 0; $j < 3; $j++){
        echo "<td class='cell'>${board[$i*3+$j]}</td>";
      }
      echo '</tr>';
    }
    echo '</table>';
    echo '<a href="">make another board</a>';
  } else {
    printf('<b>No such movie: %s</b>', htmlspecialchars($_GET['movie']));
    echo '<table id="table"> </table>';
  }
} else {
  echo '<table id="table"> </table>';
}
?>
<div class="spoilerwarning">
<i>This site may contain spoilers!</i>
</div>
<?php
include('footer.php');
?>
