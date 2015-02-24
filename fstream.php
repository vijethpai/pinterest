<?php
function createStream($sql_con)
{
	$sname=get_input_post('sname');
	$query = "insert into follow_stream(stream_name,created_by,created_date,modified_date) values('$sname','".$_SESSION['username']."',now(),now());";
	$result=mysqli_query($sql_con,$query);
       	if(!$result){
    		echo "<p class='text-danger' style='padding-top:5%'>failed creating stream.Board name must be unique</p>";
		exit;
     	}
     	else{
       		echo "<p class='text-success' style='padding-top:5%'>Stream created</p>";
		$req = get_input_post('req');
		header("Location:$req");
        }

}
?>

<?php
include_once("conf.php");
if(isset($_POST['fssubmit'])){
	session_start();
	createStream($sql_con);
}
?>
