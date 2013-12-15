<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>imdbbingo</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" media="only screen and (max-width: 400px)" href="style/mobile.css" />
<link rel="stylesheet" media="only screen and (min-width: 401px)" href="style/style.css" />
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
    $(function() {
        function make_board(item){
            $(".row").remove();
            $(".loader").show();
            $.getJSON("query.php","title="+item.value,function(data,status,xhr){
                $(".loader").hide();
                t = "";
                for(i=0;i<3;i++){
                    t += "<tr class='row'>";
                    for(j=0;j<3;j++){
                       t += "<td class='cell'>"+data[i*3+j]+"</td>";
                    }
                    t += "</tr>";
                }
                $("#table").append(t);
                $(".cell").click(function(){
                    if($(this).hasClass('checked')){
                        $(this).removeClass('checked');
                    }else{
                        $(this).addClass('checked');
                    }
                });
                        
                $("#newboard").show();
                $("body").append("<button class='newboard'>new board</button>");
                $(".newboard").click(function(){
                    $(".newboard").remove();
                    make_board(item);
                });
                    
            });
        }
        $(".loader").hide();
        $( "#movie" ).autocomplete({
            source: "query.php",
            minLength: 2,
            select: function( event, ui ) {
                $("#movie").removeClass("ui-autocomplete-loading");
                $(".newboard").remove();
                make_board(ui.item);
            }
        });
    });
</script>
</head>
<body>

<?php
include("header.php");
?>

<div class="ui-widget">
<label for="movie">Movie: </label>
<input id="movie">
</div>
<br>
<img class="loader" src="images/ui-anim_basic_16x16.gif" />
<table id="table">
</table>
</body>
</html>
