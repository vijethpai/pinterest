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
	<?php
	$query1="select * from follow_stream where created_by='".$_SESSION['username']."';";
	$result1=mysqli_query($sql_con,$query1);
        if(!$result1){
        	echo "<option class='text-danger' style='padding-top:5%'>Error displaying streams</option>";
		echo "$query1";
      	}
	while($row = mysqli_fetch_array($result1)){
	$sname =strtoupper($row['stream_name']);
	echo"	<div class='col-xs-12' style='padding-top: 6%;'>
		<h2>$sname</h2>";
	$query="select * from board natural join stream_boards where stream_id='".$row['stream_id']."';";
	$result=mysqli_query($sql_con,$query);
	if(!$result){
	        echo "<h5> Add New Boards to this Stream! </h5>";
	}
	else{
        	if(mysqli_num_rows($result)<1)
        	{ echo "<h5> Add New Boards to this Stream! </h5>";}
        else
        {display_board($result,$sql_con);}
	}
	$query2="select * from board where upper(name) like '%$sname%' and board_id not in (select board_id from stream_boards where stream_id='".$row['stream_id']."') ;";
        $result2=mysqli_query($sql_con,$query2);
	//echo $query2;
        if(!$result2){
                echo "<h5>Create a New Board.</h5>";
        }
        else{
        display_board($result2,$sql_con);
        }

	echo"
		</div>
		<div class='progress col-xs-12'>
		<div class='progress-bar' aria-valuemax='100' aria-valuemin='0' aria-valuenow='60' role='progressbar' style='width: 0%;'></div>
		</div>";
	}
	?>
</div>
<?php include("footer.php") ?>
</body>
</html>

