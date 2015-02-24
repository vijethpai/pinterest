<html>
<head>
	<?php 
		session_start();
		include("conf.php");
		if(isset($_POST['register'])){
                        //$username= mysqli_real_escape_string($sql_con,$_POST['userid']);
            $username=get_input_post('userid');
			$email= get_input_post('email');
			$fname= get_input_post('fname');
			$lname= get_input_post('lname');
			$gender= get_input_post('gender');
			$dob= get_input_post('dob');
			$passwd= get_input_post('password1');
			$temp = explode(".", $_FILES["ppic"]["name"]);
            $extension = end($temp);
            $picturePath="uploads/ppic/$username.$extension";
		    $query = "insert into user values('$username','$fname','$lname','$email','$passwd','$gender', '$picturePath', '$dob',now());";
                       // echo "$query<br/>";
		//	exit;
			$result1=mysqli_query($sql_con,$query);
			if(!$result1){
                		echo "<p class='text-danger' style='padding-top:5%'>Sorry this Username is already taken!!</p>";
                	}
                	else
                	{
                		echo "<p class='text-success' style='padding-top:5%'>creating pin successful</p>";
                		$picturePath=saveImg($_FILES,$username);
                        	header("Location: index.php");
                                
                        }
                }
function saveImg($_FILE,$pic_id){
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["ppic"]["name"]);
        $extension = end($temp);
        if ((($_FILES["ppic"]["type"] == "image/gif")
                || ($_FILES["ppic"]["type"] == "image/jpeg")
                || ($_FILES["ppic"]["type"] == "image/jpg")
                || ($_FILES["ppic"]["type"] == "image/pjpeg")
                || ($_FILES["ppic"]["type"] == "image/x-png")
                || ($_FILES["ppic"]["type"] == "image/png"))
                )
        	{
                if ($_FILES["ppic"]["error"] > 0)
                {
                        echo "Error: " . $_FILES["ppic"]["error"] . "<br>";
			exit;
                }
                else
                {
                       /* if (file_exists("uploads/ppic/" .$pic_id.".".$extension))
                        {
                                echo "<p class='text-danger' style='padding-top:5%'>Error creating pin contact admin</p>";
                        }*/
                        //else
                        //{
                        move_uploaded_file($_FILES["ppic"]["tmp_name"],"uploads/ppic/".$pic_id.".".$extension);
                        return "uploads/ppic/".$pic_id.".".$extension;
                        //}


                }
        }
        else
        {
                echo "Invalid file";
        }
}

?>
	<script src="../dist/js/register.js"></script>
</head>
<body style='padding-right: 400px; padding-left: 400px;padding-top:10px;' >
    <div class='jumbotron' >
            <p>
            <form name='register' onSubmit="return validateform()" action="register.php" enctype="multipart/form-data" method="post">
            <div class="form-group" style="text-align: center">
							<img src="/Mapit.jpg" width="280" height="90" title="Logo" alt="Logo of a company" />
			</div>
			<div class="form-group" style="text-align: center">
				<label for="Register">Please Register. Its Fast, Simple and Free.</label>
			</div>
			<div class="form-group">
                <label for="UserName">User ID</label>
                <input type="text" class="form-control" id="User Name" name='userid' placeholder="Enter User Name">
            </div>
			<div class="form-group">
    				<label for="Password1">Password</label>
    				<input type="password" class="form-control" id="password1" name='password1' placeholder="Enter Password">
  			</div>
			<div class="form-group">
                <label for="Password2">Re-Enter Password</label>
                <input type="password" class="form-control" id="password2" name= 'password2' placeholder="Enter Password Again">
            </div>
			<div class="form-group">
				<label for="Email">Email address</label>
                <input type="email" class="form-control" id="Email" name='email' placeholder="Enter email">
            </div>
			 <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" name='fname' placeholder="Enter First Name">
            </div>
			 <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname"  name='lname' placeholder="Enter Last Name">
            </div>
			<div class="form-group">
  				<label><input type="radio" name="female" id="optionsRadios1" value="f" checked> Female</label>
				<label><input type="radio" name="male" id="optionsRadios2" value="m"> Male</label>
			</div>
			<div class="form-group">
				<label for="lname">Date of Birth</label>
                <input type="date" class="form-control" id="dob"  name='dob' placeholder="YYYY/MM/DD">
            </div>
			<div class="form-group">
    			<label for="ppic">Upload your profile Picture</label>
    			<input type="file" id="ppic" name="ppic"/>
    		</div>
            <input class="btn btn-primary btn-defalut" type="submit" name="register" value="REGISTER"/>
            </p>
			</form>
        </p>


    </div>
</body>

</html>
