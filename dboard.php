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
        if(isset($_POST['createB']))
        {	
                        createBoard($sql_con);
        }
        if(isset($_POST['uploadPin']))
        {               
                        createPin($sql_con);
        }

?>
</head>
<body>
<?php include("header.php") ?>
<?php include("left_nav.php") ?>
<div class="col-xs-9">
<div class='col-xs-12' style='padding-top: 6%;'>
<div class="col-xs-12">
<?php
if(isset($_POST['bsearch']))
{
	echo "<h2> Search Results </h2>";
	$query="select * from board where upper(name) like '%".strtoupper($_POST['bname'])."%';";
	$result=mysqli_query($sql_con,$query);
	if(!$result){
	        echo "<h4> None </h4>";
	}
	else{
	    if(mysqli_num_rows($result)<1){
			echo "<h4> None </h4>";}
	        else{
				display_board($result,$sql_con);
			}
		}
	echo 	'<div class="progress col-xs-12">
	<div class="progress-bar" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" style="width: 0%;"></div>
	</div>';
}
?>
<h3>My Boards</h3>
<?php
$query="select * from board where created_by ='".$_SESSION['username']."';";
$result=mysqli_query($sql_con,$query);
if(!$result){
        echo "<h4> None </h4>";
}
else{
	if(mysqli_num_rows($result)<1){ 
		echo "<h4> None </h4>";
	}
	else{
		display_board($result,$sql_con);
	}
}
?>
</div>
<div class="progress col-xs-12">
<div class="progress-bar" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" style="width: 0%;"></div>
</div>
<h3>Boards I Follow </h3>
<div class='col-xs-12'>
<?php
$query="select * from board natural join follows where user_id = '".$_SESSION['username']."';";
$result=mysqli_query($sql_con,$query);
if(!$result){
        echo "<h4> None </h4>";
}
else{
        if(mysqli_num_rows($result)<1){ 
			echo "<h4> None </h4>";
		}
        else{
		display_board($result,$sql_con);
		}
}
?>
</div>

<div class="progress col-xs-12">
<div class="progress-bar" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" style="width: 0%;"></div>
</div>
<h3> My Friends Boards </h3>
<div class='col-xs-12'>
<?php
$query="select board_id,name from board b,friend f where f.user_id = '".$_SESSION['username']."'and f.request_status = 'A' and f.friend_id = b.created_by;";
$result=mysqli_query($sql_con,$query);
if(!$result){
        echo "<h4> None </h4>";
}
else{
        if(mysqli_num_rows($result)<1){ 
			echo "<h4> None </h4>";
		}
        else{
			display_board($result,$sql_con);
		}
}
?>
</div>

<div class="progress col-xs-12">
<div class="progress-bar" aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" role="progressbar" style="width: 0%;"></div>
</div>
<h3> Search Boards </h3>
<form class="navbar-form" method='post' action='dboard.php'>
<input type="text" placeholder="search boards" name='bname' class="form-control"></br></br>
<button type="submit" name='bsearch' class="btn btn-primary btn-default">search</button>
</div>
</form> 
<?php include("footer.php") ?>
</body>
</html>
