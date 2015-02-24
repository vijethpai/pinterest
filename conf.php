<?php
//$sql_con=mysqli_connect('localhost','root','','our_pinterst');
//$sql_con=mysqli_connect('localhost','root','','pinterest2');
$sql_con=mysqli_connect('localhost','root','','pinterest1');
echo"
<link href='../dist/css/bootstrap.css' rel='stylesheet'>
<!-- Bootstrap theme -->
<link href='../dist/css/bootstrap-theme.min.css' rel='stylesheet'>
";

function get_input_post($data)
{
  $data = $_POST[$data];
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function deleterec($tname,$cname,$value,$sql_con){
	$query = "delete from $tname where $cname = '$value';";
	$result=mysqli_query($sql_con,$query);
        if(!$result){
        	echo "<option class='text-danger' style='padding-top:5%'>Delete Failed</option>";
		exit;
     	}
}
function deleterec2($tname,$cname,$value,$cname1,$value1,$sql_con){
        $query = "delete from $tname where $cname = '$value' and $cnmae1 = '$value1';";
        $result=mysqli_query($sql_con,$query);
        if(!$result){
                echo "<option class='text-danger' style='padding-top:5%'>Delete Failed</option>";
                exit;
        }
}
?>
<title>
Pintrest
</title>
