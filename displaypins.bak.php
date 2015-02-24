<?php 
$query = "select * from pin natural join picture order by pinned_date desc;";
$result=mysqli_query($sql_con,$query);
if(!$result){
	echo "<option class='text-danger' style='padding-top:5%'>Something went wrong contact admin</option>";
}
else{
	echo "<div class='col-xs-9' style='padding-top: 6%;'>";
	display_pins($result,$sql_con);

	echo "</div>";
}
?>
