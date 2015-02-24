<?php 	
	function createBoard($sql_con){
		$name_board=get_input_post('Name');
        $Description= get_input_post('Description');
        $Category= get_input_post('Category');
        $current_user=$_SESSION['username'];
		$only_friends='FALSE';
        //$user_id=$_GET['uid'];
		if(isset($_POST['only_friends'])){
			$only_friends= 'TRUE';
		}
        $query = "insert into board (name,description,category,only_friends,created_by,created_date) values('$name_board','$Description','$Category','$only_friends','$current_user',now());";
        $result=mysqli_query($sql_con,$query);
        if(!$result){
			echo "<p class='jumbotron' style='padding-top:5%'>Error. Unable to Create this Board!</p>";
		}
		else{
			echo "<p class='jumbotron' style='padding-top:5%; padding-top:5%'>A Board named $name_board is Created</p>";
		}
	}
	function list_board($sql_con){
		$current_user = $_SESSION['username'];
		$query = "select * from board where created_by='$current_user';";
		$result=mysqli_query($sql_con,$query);
		if(!$result){
            echo "<option class='text-danger' style='padding-top:5%'>Create a board and then try adding pins</option>";
        }
        else{
			while($row = mysqli_fetch_array($result)){
				$name = $row['name'];
				$board_id = $row['board_id'];
				echo "<option value='$board_id'>$name</option>";
			}
		}
	}
	function display_board($result,$sql_con){
		while($row = mysqli_fetch_array($result)){
            $name = $row['name'];
			$board_id = $row['board_id'];
			echo "<div class='col-xs-4 thumbnail'>";
            echo "<a href='boardpin.php?bidpin=$board_id&name=$name'><h3>$name</h3></a>";
            $query1="select * from pin natural join picture where board_id = $board_id order by pinned_date desc;";
            //echo "$query1";
			$result1=mysqli_query($sql_con,$query1);
            if(!$result1){                    
                echo "<h4>Create a board and then try adding pins</h4>";                             
            }
            else{
               	$count = 4;
              	while($row1 = mysqli_fetch_array($result1)){
					if($count>0){
                  		$count = $count-1;
						$pin_id = $row1['pin_id'];
                		$path = $row1['picture_path'];
                		$picture_id = $row1['picture_id'];
						echo"<div class='col-xs-6'>";
                        echo"<img class='img-thumbnail' src='$path' style='height:75px;width: 100%;'/>";     
						echo"</div>";
					}   
				}
			}
			echo"<br/>";
			display_follow($board_id,$sql_con);
			display_sfollow($board_id,$sql_con);				
			echo "</div>";
		}
	}
	function display_follow($board_id,$sql_con){
		$query= "select * from board where created_by = '".$_SESSION['username']."' and board_id = $board_id;";
        $result=mysqli_query($sql_con,$query);
        if(!$result){
			echo "<p class='text-danger' style='padding-top:5%'>Oops! Contact Admin</p>";
            echo $query;
			exit;
        }
		$query1= "select * from follows where  user_id = '".$_SESSION['username']."' and board_id = $board_id;";
        $result1=mysqli_query($sql_con,$query1);
		if(!$result1){
            echo "<p class='text-danger' style='padding-top:5%'>Oops! Contact Admin</p>";
            echo $query;
            exit;
        }
		if(mysqli_num_rows($result)==0 && mysqli_num_rows($result1)==0){
           	echo "<a class='btn btn-info btn-sm' href='board.php?bid=$board_id&req=".$_SERVER['SCRIPT_NAME']."&f=1'>follow</a>";
        }
		elseif(mysqli_num_rows($result1)==1){ 
			echo "<a class='btn btn-info btn-sm' href='board.php?bid=$board_id&req=".$_SERVER['SCRIPT_NAME']."&f=2'>unfollow</a>";
        }
	}
	function follow($board_id,$req,$sql_con){
	    $query= "insert into follows  values('".$_SESSION['username']."','$board_id',now());";
        $result=mysqli_query($sql_con,$query);
		if(!$result){
            include("header.php");
            echo "<p class='text-danger' style='padding-top:5%'>Could not follow board sorry. Contact Admin</p>";
            exit;
        }
        else{
            header("Location: $req");
        }
	}
	function unfollow($board_id,$req,$sql_con){
        $query= "delete from follows where user_id='".$_SESSION['username']."' and board_id='$board_id';";
		$result=mysqli_query($sql_con,$query);
        if(!$result){
            include("header.php");
            echo "<p class='text-danger' style='padding-top:5%'>Could not unfollow board sorry. Contact Admin</p>";
            exit;
        }
        else{
            header("Location: $req");
        }
    }
	function display_sfollow($board_id,$sql_con){
		echo "<a class='btn btn-danger btn-sm' data-toggle='modal' data-target='#sf$board_id'>Stream</a>";
		echo "<div class='modal fade' id='sf$board_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
        <div class='modal-content'>
        <div class='modal-body'>
        <form method='POST' action='board.php'>
			<div class='form-group'>
				<label for='stream_id'>Select Stream</label>
				<select class='form-control' id='stream_id' name='stream_id'>";
				list_stream($sql_con);
				echo "</select>
			</div>
			<input type='hidden' name='board_id' value='$board_id'>
			<input type='hidden' name='req' value='".$_SERVER['SCRIPT_NAME']."'>
			<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
			<input type='submit' class='btn btn-danger' name='asf' value='Add' />
        </form>
        </div>
		</div>
		</div>
		</div>";
	}
	function list_stream($sql_con){
		$current_user = $_SESSION['username'];
        $query = "select * from follow_stream where created_by='$current_user';";
        $result=mysqli_query($sql_con,$query);
        if(!$result){
            echo "<option class='text-danger' style='padding-top:5%'>Create a board and then try adding pins</option>";
        }
        else{
            while($row = mysqli_fetch_array($result)){
				$name = $row['stream_name'];
				$stream_id = $row['stream_id'];
				echo "<option value='$stream_id'>$name</option>";
			}
		}
	}
	function add_board_s($sql_con){	
		$board_id = get_input_post('board_id');
		$stream_id = get_input_post('stream_id');
		$req =get_input_post('req');
		$query = "select * from stream_boards where board_id='$board_id' and stream_id='$stream_id';";
        $result=mysqli_query($sql_con,$query);
        if(!$result){
            echo "<option class='text-danger' style='padding-top:5%'>error adding boards to  streams</option>";
			exit;
        }
		else{
			if(mysqli_num_rows($result)==0){
				$query1="insert into stream_boards values ($stream_id,$board_id)";
				$result1=mysqli_query($sql_con,$query1);
            	if(!$result1){
               		echo "<option class='text-danger' style='padding-top:5%'>Error adding Boards to Streams</option>";
               		exit;
            	}
			}
			header("Location:$req");
		}
	}
?>
<?php
	include_once("conf.php");
	if(isset($_GET['bid']) && $_GET['f']=='1'){
		session_start();
        follow($_GET['bid'],$_GET['req'],$sql_con);
	}
	if(isset($_GET['bid']) && $_GET['f']=='2'){
		session_start();
		unfollow($_GET['bid'],$_GET['req'],$sql_con);
	}
	if(isset($_POST['asf'])){
		session_start();
		add_board_s($sql_con);
	}
?>

