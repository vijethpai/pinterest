<?php 
$query = "(select * from pin natural join picture where board_id in (select board_id from board natural join follows where user_id = '".$_SESSION['username']."'))
		union
	(select * from pin natural join picture where board_id in (select board_id from board where created_by = '".$_SESSION['username']."')) order by pinned_date desc;";
$result=mysqli_query($sql_con,$query);
echo "<div class='col-xs-9' style='padding-top: 6%;'>";
if(!$result){
	echo "<option class='text-danger' style='padding-top:5%'>Something went wrong contact admin</option>";
}
else{
	//echo "<div class='col-xs-9' style='padding-top: 6%;'>";
	display_pins($result,$sql_con);

	//echo "</div>";
}

$query = "select * from pin natural join picture where board_id not in (select board_id from board natural join follows where user_id = '".$_SESSION['username']."') and board_id  not in (select board_id from board where created_by = '".$_SESSION['username']."') order by pinned_date desc;";
$result=mysqli_query($sql_con,$query);
if(!$result){
        echo "<option class='text-danger' style='padding-top:5%'>Something went wrong contact admin</option>";
}
else{
        //echo "<div class='col-xs-9' style='padding-top: 6%;'>";
        display_pins($result,$sql_con);

       // echo "</div>";
}
 echo "</div>";
?>
