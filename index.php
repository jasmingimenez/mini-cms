<!DOCTYPE HTML>

<html>
<head>
	<title>Jasmin Gimenez</title>
    <meta charset="utf-8">
    <!-- Set the viewport so this responsive site displays correctly on mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">

        <link type="text/css" rel="stylesheet" href="style.css" >

</head>
	
<body>
<?php include "header.php"; ?>

<div class="parent">
<?php
require_once "class.Blog.php";
require_once "class.Entry.php";
require_once "class.Status.php";
require_once "class.Category.php";

$myStatus = new Status;
$myCategory = new Category;
$blog = new Blog;
//$p_status_id = 1;
//$single_status = $myStatus->single_status($p_status_id);
//$status_name = $single_status["status"];

$myEntry = new Entry;
if (!empty($_POST['entry_id']))
{
$myEntry->remove_entry($_POST["entry_id"]);
}
//===========================================================================================================
//Success====================================================================================================
			if( isset($_GET["success"]) ):
				switch($_GET["success"]):
					case "add":
						echo "<p class='success-add'>Item added successfully.</p>";
						break;
						
					case "delete":
						echo "<p class='success-delete'>Item removed successfully.</p>";
						break;
						
					case "edit":
						echo "<p class='success-edit'>Item updated successfully.</p>";
						break;
				endswitch;
			endif;

//=============================================================================================================
//Display Sorting Options======================================================================================
	echo "
	<!-- <form method=POST action='index.php'>
		<label for='statuses'>Sort by Status</label>
		<select name='statuses'>
	";
		//$myStatus->display_statuses();
	echo "
		</select>
		<input type='submit' name='submit_status' value='Sort by Status'/>
	</form> -->
	<form method=POST id='status_form' action='index.php'>
		<label for='categories'>Sort by Categories</label>
		<select name='categories'>
	";
		$myCategory->display_categories2();
	echo "
		</select>
		<input type='submit' class='button' name='submit_category' value='Sort by Category'/>
	</form>";
	
	echo "
	<form method=POST id='all_form' action='index.php'>
		<input type='submit' class='button' name='submit_all' value='Show All Posts' />
	</form>
	";
	
//$blog->display_blog();
//==============================================================================================================
//Display Blog==================================================================================================
if (isset($_POST['statuses']))
{
	//var_dump($_POST['statuses']);
	//echo "We did it! ooo oooo!";
	$status_id = $_POST['statuses'];
	//echo $status_id;
	$blog->display_blog_by_status($status_id);
}
if (isset($_POST['categories']))
{
	//var_dump($_POST['categories']);
	//echo "We did it! Lo Hicimos!";
	$category_id = $_POST['categories'];
	//echo $category_id;
	$blog->display_blog_by_category($category_id);
}
if (isset($_POST['submit_all']))
{
	$blog->display_blog();
}
else
{
	$blog->display_blog();
}
?>



<div class="clear"></div>
</div>
<!-- Site footer -->
<?php include "footer.php"; ?>
<!-- end footer -->
<div class="clear"></div>
</body>
</html>
