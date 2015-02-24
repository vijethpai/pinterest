<html>
<head>
<?php
        session_start();
        include_once("conf.php");
        if(!isset($_SESSION['username']))
        {
                header('Location:index.php');
        }
	if(isset($_GET['uid'])){
		$current_user= $_SESSION['username'];
		$user_id = $_GET['uid'];
		$query ="insert into friend values ('$current_user','$user_id','P',now(),NULL);";
		mysqli_query($sql_con,$query);
		echo "<p class='jumbotron' style='padding-left: 80px;padding-right: 10px;'>Friend Request sent to $user_id.</p>";
	}
?>
</head>
<body>
<?php include("header.php") ?>
<?php include("left_nav.php") ?>
<div class="col-xs-6" style='padding-top:6%;'>
<form name='search' action='findfriends.php' method='POST'>
<input type="text" class="form-control" name='search_key' placeholder="userid or email address"></br>
<label> Search based on 
<select name='search_opt' class="form-control">
  <option>email</option>
  <option>userid</option>
</select>
</label>
<button type="submit" class="btn btn-info btn-sm" name='search'>search</button>
</form>
<?php
if(isset($_POST['search'])){
			$current_user= $_SESSION['username'];
                        $search_key= strtolower(get_input_post('search_key'));
                        $option = get_input_post('search_opt');
			if($option=='email')
                $query = "select * from user where lcase(email) like '%$search_key%' and user_id <> '$current_user' and user_id not in(select friend_id from friend where (user_id='$current_user')) ;";
            elseif($option=='userid')
				$query = "select * from user where lcase(user_id) like '%$search_key%' and user_id <> '$current_user' and user_id not in(select friend_id from friend where (user_id='$current_user'));";
			//echo "$query<br/>";
            $result = mysqli_query($sql_con,$query);
            if(mysqli_num_rows($result) == 0){
                echo "<p class='text-warning'>No Such User!</p>";
            }
			while($row = mysqli_fetch_array($result)){
				$user_id = $row['user_id'];
				$fname =strtoupper($row['fname']);
				$lname = strtoupper($row['lname']);
				echo "<div class='col-xs-4'>";
				echo "<img class='img-thumbnail' src='".$row['profile_pic_path']."' style='height:189px;width:100%;' alt='no profile picture'/>";
				echo "<class='col-xs-4'>$fname $lname<br/>
							
					<a class='btn btn-info btn-sm' href='findfriends.php?uid=$user_id'>Add Friend</a></p>";
				echo "</div>";
			}
}

?>
</div>

<?php include("footer.php") ?>
</body>
</html>

