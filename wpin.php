<html>
<head>
<?php
	session_start();
	include_once("conf.php");
	include('simple_html_dom.php');
	if(isset($_POST['wsubmit'])){
           	$wurl = $_POST['wurl'];
		// Create DOM from URL or file
		$html = file_get_html($wurl);
		// Find all images
		$image = array();
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		foreach($html->find('img') as $element){
        		if (startsWith ( $element->src, "/" )) {
        	    		$element->src = $wurl . $element->src ;
        		}
        		$temp = explode(".",$element->src);
        		$extension = end($temp);
        		if(in_array($extension, $allowedExts))
        	        	$image[]=$element->src;
		}
	}
	elseif(isset($_POST['wpinsub'])){
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
			$rwurl= get_input_post('rwurl');
                	$picturePath = urlImage($rwurl,$pic_id);
                	$current_user=$_SESSION['username'];
			$url = get_input_post('url');
                	$query1 = "insert into picture(source,url,tags,picture_path,uploaded_by,uploaded_date) values ('w','$url','$tags','$picturePath','$current_user',now());";
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
                		echo "<p class='text-success' style='padding-top:5%'>creating pin successfull</p>";
				header('Location:home.php');
                	}

        	}
 
	}
	else
	{
		header('Location:home.php');
	}
	
	function startsWith($haystack, $needle)
	{
    		return !strncmp($haystack, $needle, strlen($needle));
	}
	function urlImage($rwurl,$pic_id){
		$temp = explode(".",$rwurl);
                $extension = end($temp);
		$path = "uploads/image/$pic_id.$extension";
		file_put_contents($path, file_get_contents($rwurl));
		return $path;
	}

?>
</head>
<body>

<?php include("header.php") ?>
<?php include("left_nav.php") ?>
<div class='col-xs-9' style='padding-top: 6%;'>
<form  method='POST' action='wpin.php'>
<?php
	if(isset($_POST['wsubmit'])){
	echo"<div class='col-xs-9' style='padding-top: 6%;'>
	<form  method='POST' action='wpin.php'>";

	foreach(array_unique($image) as $img)
	{
		
		echo "<div class='col-xs-2'>
			<input type='radio' name ='rwurl' value='$img'/>
			<img class='img-thumbnail' style='height:150px;' src='$img'/>
		      </div>";
	}
	

	echo"
	<div class='form-group col-xs-4>
        	<label for='Description'>Description</label>
    		<input type='textarea' class='form-control' id='Description'  name='Description' placeholder='Enter Description'>
   	</div>
	<br/>
	<div class='form-group col-xs-4'>
		<label for='board_id'>Board</label>
		<select class='form-control' id='board_id' name='board_id'>";
			 			include_once("board.php");
                                                list_board($sql_con);
         echo "
           	</select>
   	</div>
       	<div class='form-group col-xs-4'>
        	<label for='tags'>Tags</label>
            	<input type='text' class='form-control' id='tags'  name='tags' placeholder='Comma Saperated Tags'>
  	</div>
	<input type='hidden' name='url' value='$wurl'/>
	<button type='reset' class='btn btn-default' data-dismiss='modal'>reset</button>
        <input type='submit' class='btn btn-primary' name='wpinsub' value='Upload' />
</form>
</div>
";
}
?>
<?php include("footer.php") ?>
</body>
</html>
