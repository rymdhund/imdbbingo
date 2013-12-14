<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>imdbbingo</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<style>
.ui-autocomplete-loading {
    background: white url('images/ui-anim_basic_16x16.gif') right center no-repeat;
}

table td {
    border: 1px solid black;
    height: 150px;
    padding: 10px;
    text-align: center;
    width: 150px;
}
</style>
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
                    if($(this).css('background-color') != 'transparent'){
                        $(this).css('background-color', '');
                    }else{
                        $(this).css('background-color', 'green');
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
