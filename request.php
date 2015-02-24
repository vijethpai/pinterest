<html>
<head>
<?php
        session_start();
        include("conf.php");
		include("header.php");
		include("left_nav.php"); 
        if(!isset($_SESSION['username']))
        {
                header('Location:index.php');
        }
        if(isset($_GET['uid'])){
                $current_user= $_SESSION['username'];
                $user_id = $_GET['uid'];
		$query1 ="select * from friend where user_id='$user_id' and friend_id='$current_user' and request_status='P' ;";
		
		$result1 = mysqli_query($sql_con,$query1);
		//echo $query1;
		//exit;
		if(mysqli_num_rows($result1)==1)
		{
                	if($_GET['i']==1){
			$query2 ="update friend set request_status = 'A' , request_accepted_date = now() where user_id='$user_id' and friend_id= '$current_user';";
			$query3="insert into friend values ('$current_user','$user_id','A',NULL,now());";
             		mysqli_query($sql_con,$query2);
			mysqli_query($sql_con,$query3);
                	echo "<p class='jumbotron' style='padding-top:0% text-align:center'>Friend Requested Accepted.</p>";}
			elseif($_GET['i']==-1){
                $query ="delete from friend where user_id='$user_id' and friend_id = '$current_user';";
                //echo $query;
                //exit;
				mysqli_query($sql_con,$query);
                echo "<p class='jumbotron' style='padding-top:5%'>Friend Request Rejected.</p>";}
			}
        }
?>
</head>
<body>

<div class="col-xs-6" style='padding-top:6%;'>
<?php
                        $current_user= $_SESSION['username'];
                        $query = "select * from friend natural join user where friend_id = '$current_user' and request_status='P';";
                        //echo "$query<br/>";
                        $result = mysqli_query($sql_con,$query);
                        if(mysqli_num_rows($result) == 0){
                                echo "<p class='jumbotron' style='padding-left: 60px;'>Zero Friend Requests Pending.</p>";
                        }
                        while($row = mysqli_fetch_array($result)){
                                $user_id = $row['user_id'];
                                $fname =strtoupper($row['fname']);
                                $lname = strtoupper($row['lname']);
                                echo "<p class='col-xs-4'>$fname $lname<br/>
                                                        User ID:$user_id<br/>
                                        <a class='btn btn-info btn-sm' href='request.php?uid=$user_id&i=1'>Accept</a>
					<a class='btn btn-danger btn-sm' href='request.php?uid=$user_id&i=-1'>Reject</a></p>";
                        }
?>

</div>
<?php include("footer.php") ?>
</body>
</html>

