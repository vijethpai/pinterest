<html>
<head>
<?php
        session_start();
        include_once("conf.php");
        if(!isset($_SESSION['username']))
        {
                header('Location:index.php');
        }
	else{
                include_once("board.php");
                include_once("pin.php");
        }

?>
</head>
<body>
<?php include("header.php") ?>
<?php include("left_nav.php") ?>
<div class='col-xs-9' style='padding-top: 6%;'>
<?php
	$query="select * from user where user_id='".$_SESSION['username']."'";
	$result=mysqli_query($sql_con,$query);
	$row = mysqli_fetch_array($result);
	echo '<div class="col-md-3 col-md-offset-4">';
	echo "<img class='img-thumbnail' src='".$row['profile_pic_path']."' style='height:189px;'/>";
	echo '<div class="col-md-12 col-md-offset-3">';
	echo $row['fname']." ".$row['lname'];
	echo "<br/>".$row['email'];
	echo "</div>";
	echo '</div>';?>
<div class="progress col-xs-12">
<div class="progress-bar" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" style="width: 0%;"></div>
</div>
	<?php
	$query="select * from board where created_by ='".$_SESSION['username']."';";
	$result=mysqli_query($sql_con,$query);
	if(!$result){
	        echo "<h5>Add New Boards</h5>";
	}
	else{
	        if(mysqli_num_rows($result)<1)
	        { echo "<h5>Add New Boards</h5>";}
	        else
	        {display_board($result,$sql_con);}
	}
	?>
</div>


</div>
<?php include("footer.php") ?>
</body>
</html>

