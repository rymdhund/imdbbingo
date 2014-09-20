<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>imdbbingo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" media="only screen and (max-width: 400px)" href="style/mobile.css" />
<link rel="stylesheet" media="only screen and (min-width: 401px)" href="style/style.css" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.11.1.js"></script>
<script src="http://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script>
$(function() {
  $( "#movie" ).autocomplete({
  source: "query.php",
    minLength: 2,
    select: function( event, ui ) {
      window.location.href = "/?movie="+ui.item.value;
    }
  });
  // Make board clickable
  $(".cell").click(function(){
    if($(this).hasClass('checked')){
      $(this).removeClass('checked');
    }else{
      $(this).addClass('checked');
    }
  });
});
</script>
</head>
<body>
<a href="rules.php" class="right">Rules</a><h2><a href="index.php">Imdb bingo</a></h2>
<input id="movie">
<hr>
