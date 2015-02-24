<html>
<head>
<?php
    session_start();
    include_once("conf.php");
    if(!isset($_SESSION['username'])){
        header('Location:index.php');
    }
    else{
        include_once("board.php");
        include_once("pin.php");
    }
    if(isset($_POST['createB'])){
            createBoard($sql_con);
    }
    if(isset($_POST['uploadPin'])){
            createPin($sql_con);
    }    
?>
</head>
<body>
<?php include("header.php") ?>
<?php include("left_nav.php") ?>
<?php
	if(isset($_GET['bidpin'])){
	$board_id = $_GET['bidpin'];
	$query = "select * from pin, picture, board where pin.picture_id=picture.picture_id and pin.board_id=board.board_id and board.board_id='$board_id' order by pinned_date desc;";
	$result=mysqli_query($sql_con,$query);
		if(!$result){
			echo"<h2>Your search result $tag</h2>";
			echo "<option class='text-danger' style='padding-top:5%'>Something went wrong contact admin</option>";
		}
		else{
			echo "<div class='col-xs-9' style='padding-top: 6%;'>";
			echo"<h2>".$_GET['name']."</h2>";
			display_pins($result,$sql_con);
			echo "</div>";
		}
	}
?>
<?php include("footer.php") ?>
</body>
</html>

