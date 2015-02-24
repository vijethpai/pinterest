<html>
<head>
<?php
	include("conf.php");
	session_start();
    if(isset($_POST['submit'])){
		//$username= mysqli_real_escape_string($sql_con,$_POST['username']);
		//$passwd= mysqli_real_escape_string($sql_con,$_POST['password']);
        $username= get_input_post('username');
		$passwd= get_input_post('password');
		$query = "select * from user where user_id='".$username."' and password='".$passwd."';";
        $result = mysqli_query($sql_con,$query);
		if(mysqli_num_rows($result) == 1){
			$row = mysqli_fetch_array($result);
			session_start();
			$_SESSION['username'] = $row['user_id'];
			$_SESSION['row'] = $row;
			$_SESSION['logged'] = TRUE;
			header("Location: home.php"); // Modify to go to the page you would like
			exit;
		}
	}
	elseif(isset($_SESSION['username'])){
		header("Location:home.php");
		exit;
	}                

    ?>
</head>
<body style='padding-right: 400px; padding-left: 400px;padding-top:10px;' >
	<div class='jumbotron' > 
		<p>
		
		
		<?php
			if(isset($_POST['submit'])){
			echo "<p class='text-warning' style='text-align: center'>Invalid Username or Password. Please Try Again.</p>";
			}
		?>
		<form name= 'login' action="index.php" method="post">
			<div class="form-group" style="text-align: center">
				<img src="/Pinterest_Logo.png" width="280" height="90" title="Logo" alt="Logo of a company" />
			</div>
			<div class="form-group" style="text-align: center">
				<label for="Login">Please Login.</label>
			</div>
			<div class="form-group" style="text-align: center">
    			Username <input type="text" name="username"/><br/>
    			Password: <input type="password" name="password"/><br/>
				<p style='padding-top:10px; padding-left:30px;'>
					<input class="btn btn-primary btn-defalut" type="submit" name="submit" value="Login"/>
					<a class="btn btn-primary btn-defalut" href='register.php'>Sign Up!</a>
				</p>
			</div>
		</form>
		</p>
	</div>
</body>
</html>
