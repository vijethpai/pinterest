<html>
<head>
<?php
        session_start();
        include_once("conf.php");
        if(!isset($_SESSION['username']))
        {
                header('Location:index.php');
        }
?>
</head>
<body>
<?php include("header.php") ?>
<?php include("left_nav.php") ?>
<div class="col-xs-9" style='padding-top:6%;'>
<?php
 	$current_user= $_SESSION['username'];
	$query = "select * from user,friend where user.user_id = friend_id and friend.user_id = '$current_user' and request_status = 'A';";
	$result = mysqli_query($sql_con,$query);
                        if(mysqli_num_rows($result) == 0){
                                echo "<p class='jumbotron' style='padding-left: 80px;padding-right: 10px;'>You have Zero Friends at the Moment.</p>";
                        }
                        while($row = mysqli_fetch_array($result)){
                                $user_id = $row['user_id'];
                                $fname =strtoupper($row['fname']);
                                $lname = strtoupper($row['lname']);
				echo "<div class='col-xs-3'>";
                                echo "<p class=''>$fname $lname<br/>";
                                                      
				echo "<img class='img-thumbnail' src='".$row['profile_pic_path']."' style='height:189px;width:100%;' alt='no profile picture'/>";
                                   //     <a class='btn btn-info btn-sm' href='findfriends.php?uid=$user_id'>Add Friend</a></p>";
				echo "</div>";
                        }


?>
</div>
<?php include("footer.php") ?>
</body>
</html>

