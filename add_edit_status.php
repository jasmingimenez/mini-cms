<?php
	require_once 'class.Blog.php';
	require_once 'class.Entry.php';
	require_once 'class.Status.php';
	require_once 'class.Category.php';
	require_once 'class.entry_category.php';
	$myBlog = new Blog;
	$myEntry = new Entry;
	$myStatus = new Status;
	$myCategory = new Category;
	$myEntryCategory = new Entry_Category;
    date_default_timezone_set('America/Denver');
	$date = date("Y-m-d H:i:s");

$error = 0;

//Add Status
//==========================================================================
if (!empty($_POST['new_status']))
{
	$new_status = $_POST['new_status'];
	$myStatus->add_status($new_status);
	echo "Status added!";
	header('location: index.php?success=add');
}
//Edit Status
//==========================================================================
if (!empty($_POST['status']))
{
	$edit_status = $_POST['status'];
		echo "edit status: <br>";
		var_dump($edit_status);
	$statusID = $_POST['status_id'];
		echo "<br>statusID: <br>";
		var_dump($statusID);
	$length = count($edit_status);
	$length_id = count($statusID);
		echo "<br>length: $length<br>";
		echo "<br>length_id: $length_id<br>";
	for ($i = 0; $i < count($edit_status); $i++)
	{
			//echo "<br>i: $i<br>";
			//echo "statusID: $statusID[$i]<br>";
			//echo "edit_status: $edit_status[$i] <br>";
		$myStatus->edit_status($statusID[$i], $edit_status[$i]);
	}
	echo "Status edited!";
	header('location: index.php?success=edit');
}
//Delete Status
//==========================================================================
if (!empty($_POST['delete_status']))
{
	$status_array = $_POST['status'];
			
			foreach ( $status_array as $id):
				$status_id = $id;
				echo "status_array: <br>";
				var_dump($status_array);
				
				$myStatus->remove_status($status_id);
				echo "removed category";

			endforeach;
			echo "Status deleted!";
			header("location: index.php?success=delete");
}

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add/Edit Statuses</title>
</head>

<body>
<h1>Add or Edit a Status</h1>
<a href="http://dight350.tardis-shoes.com/gimenez/mini-cms/">Back to Blog</a>
        <div id="add_edit_status">
        <form name="add_statuses" method=POST action="add_edit_status.php">
        <fieldset>
        <legend>Add Statuses</legend>
            <input type="text" name="new_status" />
            <input type="submit" name="add_status" value="Add Status" />
            </fieldset>
        </form>
        
        <form name="edit_statuses" method=POST action="add_edit_status.php">
        <fieldset>
        <legend>Edit Statuses</legend>
        	<? $myStatus->display_edit_statuses(); ?>
            <input type="submit" name="edit_status" value="Edit Statuses"/>
        </fieldset>
        </form>
        
        <form name="delete_statuses" method=POST action="add_edit_status.php">
        <fieldset>
        <legend>Delete Statuses</legend>
        	<? $myStatus->display_delete_statuses(); ?>
            <input type="submit" name="delete_status" value="Delete Statuses"/>
        </fieldset>
        </form>
        </div>

</body>
</html>
