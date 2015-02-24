<html>
<head>
<?php
        session_start();
        include_once("conf.php");
        if(!isset($_SESSION['username']))
        {
                header('Location:index.php');
        }
        else{
                include_once("board.php");
                include_once("pin.php");
        }
        if(isset($_POST['createB']))
        {
                        createBoard($sql_con);
        }
        if(isset($_POST['uploadPin']))
        {
                        createPin($sql_con);
        }

?>
</head>
<body>
<?php include("header.php") ?>
<?php include("left_nav.php") ?>
<?php
if(isset($_POST['search'])){
$tag = get_input_post('tag');
$query = "select * from pin natural join picture where tags like '%$tag%'  order by pinned_date desc;";
$result=mysqli_query($sql_con,$query);
//echo $query;
if(!$result){
	echo"<h2>Your search result $tag</h2>";
        echo "<option class='text-danger' style='padding-top:5%'>Something went wrong contact admin</option>";
}
else{
        echo "<div class='col-xs-9' style='padding-top: 6%;'>";
	echo"<h2>Search Results for: $tag</h2>";
        display_pins($result,$sql_con);

        echo "</div>";
}
}
?>
<?php include("footer.php") ?>
</body>
</html>

