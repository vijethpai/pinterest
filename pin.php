<?php
function createPin($sql_con){
	$query = "select max(picture_id) as max_pic_id from picture;";
	$result=mysqli_query($sql_con,$query);
	if(!$result){
		echo "<p class='text-danger' style='padding-top:5%'>Error creating pin contact admin</p>";
	}
	else{
		$row = mysqli_fetch_array($result);
	    $pic_id = intval($row["max_pic_id"])+1;
		$board_id = get_input_post('board_id');
		$tags = get_input_post('tags'); 
		$desc= get_input_post('Description');
		$picturePath = saveImg($_FILES,$pic_id);
		$current_user=$_SESSION['username'];
		$query1 = "insert into picture(source,url,tags,picture_path,uploaded_by,uploaded_date) values ('l',NULL,'$tags','$picturePath','$current_user',now());";		
		$result1=mysqli_query($sql_con,$query1);
		$query2 = "insert into pin(picture_id,board_id,description,pinned_date) values('$pic_id','$board_id','$desc',now());";
                $result2=mysqli_query($sql_con,$query2);
		$pin_id =  mysqli_insert_id($sql_con);
		$query3 = "update pin set parent_pin_id = '$pin_id' where pin_id = $pin_id;";
		$result3=mysqli_query($sql_con,$query3);
		if(!$result1 || !$result2 || !$result3){
                echo "<p class='text-danger' style='padding-top:5%'>Error creating pin contact admin</p>";
                }
		else
		{
		//echo "<p class='text-success' style='padding-top:5%'>creating pin successfull</p>";
		}

	}

}

function saveImg($_FILE,$pic_id){
	$allowedExts = array("gif", "jpeg", "jpg", "png");
		echo $_FILES["pinFile"]["name"];
        $temp = explode(".", $_FILES["pinFile"]["name"]);
        $extension = end($temp);
        if ((($_FILES["pinFile"]["type"] == "image/gif")
                || ($_FILES["pinFile"]["type"] == "image/jpeg")
                || ($_FILES["pinFile"]["type"] == "image/jpg")
                || ($_FILES["pinFile"]["type"] == "image/pjpeg")
                || ($_FILES["pinFile"]["type"] == "image/x-png")
                || ($_FILES["pinFile"]["type"] == "image/png"))
                )
        {
                if ($_FILES["pinFile"]["error"] > 0)
                {
                        echo "Error: " . $_FILES["pinFile"]["error"] . "<br>";
                }
                else
                {
			if (file_exists("uploads/image/" .$pic_id.".".$extension))
      			{
      				echo "<p class='text-danger' style='padding-top:5%'>Error creating pin contact admin</p>";
     	 		}
    			else
      			{
      				move_uploaded_file($_FILES["pinFile"]["tmp_name"],"uploads/image/".$pic_id.".".$extension);
					
     				return "uploads/image/".$pic_id.".".$extension;
      			}
			

            }
        }
        else
        {
                echo "Invalid file";
        }

}

function like_pin($pin_id,$req,$sql_con){
	echo $pin_id."----".$req;
	$query1="select Picture_id from pin where pin_id =$pin_id;";
	$result=mysqli_query($sql_con,$query1);
	if(!$result){
                        include("header.php");        
			echo "<p class='text-danger' style='padding-top:5%'>Could not like picture sorry. Contact Admin</p>";
			exit;
                    }
        else{
              $row = mysqli_fetch_array($result);
	      $pic_id= $row['Picture_id'];
	      $query2= "insert into likes values('".$_SESSION['username']."','$pic_id',now());";
	      $result2=mysqli_query($sql_con,$query2);
	      if(!$result2){
                        include("header.php");        
			echo "<p class='text-danger' style='padding-top:5%'>Could not like picture sorry. Contact Admin</p>";
			exit;
              }
	      else{
		header("Location: $req");
	      }

         }
	
}
function unlike_pin($pin_id,$req,$sql_con){
        echo $pin_id."----".$req;
        $query1="select Picture_id from pin where pin_id =$pin_id;";
        $result=mysqli_query($sql_con,$query1);
        if(!$result){
                        include("header.php");
                        echo "<p class='text-danger' style='padding-top:5%'>Could not like picture sorry. Contact Admin</p>";
                        exit;
                    }
        else{
              $row = mysqli_fetch_array($result);
              $pic_id= $row['Picture_id'];
              $query2= "delete from likes where user_id='".$_SESSION['username']."' and Picture_id =$pic_id;";
              $result2=mysqli_query($sql_con,$query2);
              if(!$result2){
                        include("header.php");
                        echo "<p class='text-danger' style='padding-top:5%'>Could not like picture sorry. Contact Admin</p>";
                        exit;
              }
              else{
                header("Location: $req");
              }

         }
}
function display_like($picture_id,$pin_id,$sql_con){
        $query= "select * from likes where user_id='".$_SESSION['username']."' and picture_id=$picture_id;";
        $result=mysqli_query($sql_con,$query);
        $query2= "select * from likes where picture_id=$picture_id;";
        $result2=mysqli_query($sql_con,$query2);
        $no_likes=mysqli_num_rows($result2);
        if(!$result2){
                        echo "<p class='text-danger' style='padding-top:5%'>Oops! Contact Admin</p>";
                        echo $query;
        }
        if(mysqli_num_rows($result)<1)
        {
                echo "<a class='btn btn-info btn-sm' href='pin.php?pid=$pin_id&req=".$_SERVER['SCRIPT_NAME']."&l=1'>like<span class='badge'>$no_likes</span></a>";
        }
        else{
                echo "<a class='btn btn-info btn-sm' href='pin.php?pid=$pin_id&req=".$_SERVER['SCRIPT_NAME']."&l=2'>unlike<span class='badge'>$no_likes</span></a>";
        }

}
function display_repin($picture_id,$pin_id,$sql_con){
                include_once("board.php");
                $query2= "select * from pin where picture_id=$picture_id;";
                $result2=mysqli_query($sql_con,$query2);
                $no_rpin=mysqli_num_rows($result2);
                if(!$result2){
                        echo "<p class='text-danger' style='padding-top:5%'>Oops! Contact Admin</p>";
                        echo $query2;
                        exit;
                }

                echo "<a class='btn btn-info btn-sm' data-toggle='modal' data-target='#rp$pin_id$picture_id'>pin<span class='badge'>$no_rpin</span></a>";
                echo "<div class='modal fade' id='rp$pin_id$picture_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                              <div class='modal-dialog'>
                               <div class='modal-content'>
                                <div class='modal-body'>
                                        <form name='repin' method='POST' action='pin.php'>
                                        <div class='form-group'>
                                                <label for='Description'>Description</label>
                                                <input type='textarea' class='form-control' id='Description'  name='Description' placeholder='Enter Description'>
                                        </div>
                                        <div class='form-group'>
                                                <label for='board_id'>Board</label>
                                                <select class='form-control' id='board_id' name='board_id'>";
                                                        list_board($sql_con);
                                                echo "</select>
                                        </div>
                                        <input type='hidden' name='picture_id' value='$picture_id'>
                                        <input type='hidden' name='pin_id' value='$pin_id'>
                                        <input type='hidden' name='req' value='".$_SERVER['SCRIPT_NAME']."'>
                                        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                                        <input type='submit' class='btn btn-danger' name='rpin' value='pin it' />
                                        </form>
                        </div></div></div></div>";
}
function display_pins($result,$sql_con){
        while($row = mysqli_fetch_array($result)){
                $pin_id = $row['pin_id'];
                $path = $row['picture_path'];
                $picture_id = $row['picture_id'];
                echo "<div class='col-xs-3 thumbnail'>
                       <a data-toggle='modal' data-target='#$pin_id$picture_id'><img class='img-thumbnail' src='$path' width='240px'/></a>";
                //echo '<h4 class="">'.$row['description'].'</h4>';
		display_like($picture_id,$pin_id,$sql_con);
                display_repin($picture_id,$pin_id,$sql_con);
		display_delete($picture_id,$pin_id,$sql_con);
		echo "<br/>";
		display_comment($picture_id,$pin_id,$sql_con);
                echo "</div>";

                echo "<div class='modal fade' id='$pin_id$picture_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                          <div class='modal-dialog'>
                               <div class='modal-content'>
                                        <img class='img-thumbnail' src='$path'/>
                                 <div class='modal-body'>
                        </div></div></div></div>";
        }
}


function delete_pin($pic_id,$pin_id,$req,$sql_con){
	$query = "select * from pin where parent_pin_id=$pin_id and pin_id=$pin_id;";
        $result=mysqli_query($sql_con,$query);
        if(!$result){
        	echo "<option class='text-danger' style='padding-top:5%'>Error deleting</option>";
		exit;
        }
	else{
		if(mysqli_num_rows($result)>0){
			
			$resultp = mysqli_query($sql_con,"SELECT picture_path from picture where picture_id=$pic_id");
			$row  =mysqli_fetch_array($resultp);
			@unlink($row['picture_path']);
			deleterec('pin','parent_pin_id',$pin_id,$sql_con);
			deleterec('picture','picture_id',$pic_id,$sql_con);
			
		}
		else{
			deleterec('pin','pin_id',$pin_id,$sql_con);
		}
		header("Location: $req");
	}

}

function display_delete($pic_id,$pin_id,$sql_con){
        $query= "select * from pin,board where pin.board_id = board.board_id and created_by='".$_SESSION['username']."' and pin_id=$pin_id;";
        $result=mysqli_query($sql_con,$query);
        if(!$result){
                        echo "<p class='text-danger' style='padding-top:5%'>Oops! Contact Admin</p>";
                        echo $query;
			exit;
        }
        if(mysqli_num_rows($result)>0)
        {
                echo "<a class='btn btn-warning btn-sm' href='pin.php?pin_id=$pin_id&pic_id=$pic_id&req=".$_SERVER['SCRIPT_NAME']."&l=3'>delete</a>";
        }
}

function display_comment($pic_id,$pin_id,$sql_con){
	$query= "select * from pin,board where pin.board_id = board.board_id and pin_id=$pin_id and only_friends='0';";
        $result=mysqli_query($sql_con,$query);
	$query2="select b.board_id,name from board b,friend f,pin p where p.board_id = b.board_id and pin_id=$pin_id and f.user_id = '".$_SESSION['username']."' and f.request_status = 'A' and f.friend_id = b.created_by;";
        $result2=mysqli_query($sql_con,$query2);
	$query3= "select * from pin,board where pin.board_id = board.board_id and pin_id=$pin_id and created_by='".$_SESSION['username']."';";
        $result3=mysqli_query($sql_con,$query3);

	if(!$result || !$result2 || !$result3){
                        echo "<p class='text-danger' style='padding-top:5%'>Oops! Contact Admin</p>";
                        echo $query;
			echo $query2;
                        exit;
        }
        if(mysqli_num_rows($result)==1 || mysqli_num_rows($result2)==1 || mysqli_num_rows($result3)==1)
        {
            // echo "<a class='btn btn-default btn-sm' href='pin.php?pin_id=$pin_id&pic_id=$pic_id&req=".$_SERVER['SCRIPT_NAME']."&l=3'>comment</a>";
		echo "<a class='btn btn-default btn-sm' data-toggle='modal' data-target='#c$pin_id'>comment</a>";
                echo "<div class='modal fade' id='c$pin_id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                              <div class='modal-dialog'>
                               <div class='modal-content'>
                                <div class='modal-body'>";
				list_comment($pin_id,$sql_con);
                                       echo" <form name='comment' method='POST' action='pin.php'>
                                        <div class='form-group'>
                                                <label for='com'>Comment</label>
                                                <input type='textarea' class='form-control' id='com'  name='com' placeholder='comment'>
                                        </div>
                                        <input type='hidden' name='pin_id' value='$pin_id'>
                                        <input type='hidden' name='req' value='".$_SERVER['SCRIPT_NAME']."'>
                                        <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                                        <input type='submit' class='btn btn-default' name='comment' value='comment' />
                                        </form>
                        </div></div></div></div>";
	}
}

function list_comment($pin_id,$sql_con)
{
	$current_user = $_SESSION['username'];
      	$query = "select * from comments where pin_id='$pin_id' order by commented_date desc;";
       	$result=mysqli_query($sql_con,$query);
       	if(!$result){
     		echo "<option class='text-danger' style='padding-top:5%'>Create a board and then try adding pins</option>";
     	}
        else{
        	while($row = mysqli_fetch_array($result)){
      			$name = $row['user_id'];
                 	$comment = $row['comment_txt'];
                      	echo "<p><span class='label label-default'> $name:</span> $comment</p>";
          	}
 	}

}

?>

<?php
include_once("conf.php");
if(!isset($_SESSION['username']))
{
                session_start();
}
if(isset($_GET['pid']) && $_GET['l']=='1')
	like_pin($_GET['pid'],$_GET['req'],$sql_con);

if(isset($_GET['pid']) && $_GET['l']=='2')
        unlike_pin($_GET['pid'],$_GET['req'],$sql_con);

if(isset($_GET['pin_id']) && $_GET['l']=='3')
        delete_pin($_GET['pic_id'],$_GET['pin_id'],$_GET['req'],$sql_con);
if(isset($_POST['rpin']))
{
	$pic_id = get_input_post('picture_id');
	$board_id = get_input_post('board_id');
	$desc = get_input_post('Description');
	$pin_id = get_input_post('pin_id');
	$req = get_input_post('req');
	$query1= "select parent_pin_id from pin where pin_id = $pin_id;";
	$result1=mysqli_query($sql_con,$query1);
        if(!$result1){
                        include("header.php");
                        echo "<p class='text-danger' style='padding-top:5%'>Could not Repin. Contact Admin</p>";
                        exit;
         }
	else{
		$row = mysqli_fetch_array($result1);
        	$p_pin_id= $row['parent_pin_id'];
		$query2 = "insert into pin(picture_id,parent_pin_id,board_id,description,pinned_date) values('$pic_id','$p_pin_id','$board_id','$desc',now());";
		$result2=mysqli_query($sql_con,$query2);
        	if(!$result2){
                        include("header.php");
                        echo "<p class='text-danger' style='padding-top:5%'>Could not like picture sorry. Contact Admin</p>";
                        exit;
      		}
      		else{
        		header("Location: $req");
     		}

	}
}

if(isset($_POST['comment']))
{       
	$com = get_input_post('com');
        $pin_id = get_input_post('pin_id');
        $req = get_input_post('req');
	$query1= "insert into comments(user_id,pin_id,comment_txt,commented_date) values ('".$_SESSION['username']."','$pin_id','$com',now());";
        $result1=mysqli_query($sql_con,$query1);
        if(!$result1){
                        include("header.php");
                        echo "<p class='text-danger' style='padding-top:5%'>Could not Comment. Contact Admin</p>";
                        exit;
         }
	else{
		header("Location: $req");
	}
}

?>
