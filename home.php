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
<?php include("displaypins.php") ?>
<?php include("footer.php") ?>
</body>
</html>
