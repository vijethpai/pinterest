<html>
<head>
	<?php 
		session_start();
		include("conf.php");
		if(isset($_POST['Modify'])){
                        //$username= mysqli_real_escape_string($sql_con,$_POST['userid']);
						$current_user=$_SESSION['username'];
                        $username=get_input_post('userid');
			$email= get_input_post('email');
			$fname= get_input_post('fname');
			$lname= get_input_post('lname');
			$dob= get_input_post('dob');
			$query = "update user set fname='$fname',lname='$lname', email='$email', dob='$dob' where user_id='$current_user';";
            echo "$query<br/>";
            mysqli_query($sql_con,$query);
            header("Location: home.php ");
            //    exit;
        }
	?>
	<script src="../dist/js/register.js"></script>
</head>
<body style='padding-right: 400px; padding-left: 400px;padding-top:10px;' >
        <?php include("header.php") ?>
	<?php// include("left_nav.php") ?>
	<div class='jumbotron' >
                <p>
				<?php 
				$current_user=$_SESSION['username'];
			
			
                        $query = "select * from user where user_id='$current_user';";
                        //echo "$query<br/>";
						
						$result=mysqli_query($sql_con,$query);
						if(!$result){
						}
						else{
							//	echo "$query<br/>";
							$row = mysqli_fetch_array($result);
							$name = $row['user_id'];
							$name1=$row['fname'];
							$name2=$row['lname'];
							$name3=$row['email'];
							$name4=$row['gender'];
							$name9=$row['dob'];
						}
						
        
				 ?>
                <form name='register' onSubmit="return validateform()" action="editprofile.php" method="post">
                	<div class="form-group">
                                <label for="User Name">User ID</label>
                                <input type="text" class="form-control" id="User Name" name='userid' value='<?php echo $name;?>' disabled/>
                        </div>

			<div class="form-group">
                                <label for="Email">Email address</label>
                                <input type="email" class="form-control" id="Email" name='email' value='<?php echo $name3;?>'/>
                        </div>
			 <div class="form-group">
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" id="fname" name='fname' value='<?php echo $name1;?>'/>
                        </div>
			 <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" id="lname"  name='lname' value='<?php echo $name2;?>'/>
                        </div>
			<div class="form-group">
  				<label>
    				<input type="radio" name="gender" id="optionsRadios1" value="f" <?php if($name4=="f") echo "checked"?>>
    				Female
  				</label>
				<label>
    				<input type="radio" name="gender" id="optionsRadios2" value="m"<?php if($name4=="m") echo "checked"?>>
    				Male
  				</label>
			</div>
			<div class="form-group">
                    <input type="date" class="form-control" id="dob"  name='dob' placeholder='YYYY/MM/DD' value='<?php echo $name9;?>'/>
            </div>
			<div class="form-group">
    				<input type="hidden" id="ppic" name="ppic"/>
  			</div>

                        <input class="btn btn-primary btn-defalut" type="submit" name="Modify" value="Modify"/>
            </p>
            </form>
            </p>
        </div>
</body>
</html>
