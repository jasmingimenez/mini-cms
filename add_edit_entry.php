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
//SUCCESS
//======================================================================================================================
			/*if( isset($_GET["success"]) ):
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
			endif;*/
//======================================================================================================================
	# Process the form submission here
	/*if ( !empty($_POST["form_action"]) ):
		foreach( $_POST as $key => $value ):
			${$key} = $value;
			
			if ( $value == "" ):
				$error++;
			endif;
		endforeach;*/

		if (!empty($_POST["form_action"])):
			$entry_title = $_POST['entry_title'];
			echo "entry_title: $entry_title <BR>";
			$entry_post = $_POST['entry_post'];
			echo "entry_post: $entry_post<br>";
			$entry_statusID = $_POST['entry_status'];
			echo "entry_statusID: $entry_statusID<br>";
			$category_array = $_POST['entry_category'];
			var_dump($category_array);
			$entry_date = $_POST['entry_date'];
			echo "<br>entry_date: $entry_date<br>";
			
			$entry_id = $myEntry->add_entry($entry_post,$entry_title,$entry_date,$entry_statusID);
			echo "completed add_entry<br>";
			//$entry_id = $myEntry->get_entry_id($entry_title);
			//echo "completed get_entry_id<br>";
			echo "entry_id: $entry_id<br>";
			
			foreach ( $category_array as $id):
				$category_id = $id;
				var_dump($category_array);
				$myEntryCategory->add_entry_category($entry_id,$category_id);
				echo "completed add_entry_category<br>";
			endforeach;
			header("location: index.php?success=add");
			

		endif;
	//endif;
//======================================================================================================================



?>
<!DOCTYPE HTML>

<html>
<head>
	<title>Add An Entry</title>
    <meta charset="utf-8">
    <!-- Set the viewport so this responsive site displays correctly on mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="img/favicon.ico" type="image/x-icon">

        <link type="text/css" rel="stylesheet" href="add.css" >

</head>
	
<body>
    <h3>Add a New Entry</h3>
		<form name="storeroom" id="storeroom" method="post">
			<fieldset>
				<legend>Entry Details</legend>
				
				<input type="hidden" name="form_action" value="add" />
                <input type="hidden" name="entry_date" value="<?=$date;?>" />

				<!-- <input type="hidden" name="entry_id" value="<?//=$entry_id;?>" /> -->

				<p>
					<label for="entry_title">Title:</label>
					<input type="text" name="entry_title" value="" />
				</p>
                
				<p>
					<label for="entry_post">Post:</label>
					<textarea cols="40" rows="10" type="text" name="entry_post" value=""></textarea>
				</p>
                
                <p>
                	<label for="entry_status">Status:</label>
                    <select name="entry_status">
                    	<? $myStatus->display_statuses(); ?>
                    </select>

                    
                </p>
                <p>
                	<label for="entry_category">Category:</label>
                    <br>
					<? $myCategory->display_categories(); ?>
                </p>

				
				<input type="submit" name="btn_action" class="btn_action add" value="Add Entry" />
			</fieldset>
            
        
		</form>
        
        <!-- <input type="button" id="add_edit_status_button" name="edit_status" value="Add/Edit a status" onclick="status_click()" />
        <input type="button" id="add_edit_category_button" name="edit_category" value="Add/Edit a category" onclick="category_click()" />-->
        <p></p>
        <div id="add_edit_status">
        <form name="add_statuses" method=POST action="add_edit_entry.php">
        <fieldset>
        <legend>Add Statuses</legend>
            <input type="text" name="new_status" />
            <input type="submit" name="add_status" value="Add Status" />
            </fieldset>
        </form>
        <form name="edit_statuses" method=POST action="add_edit_entry.php">
        <fieldset>
        <legend>Edit Statuses</legend>
        	<? $myStatus->display_edit_statuses(); ?>
            <input type="submit" name="edit_status" value="Edit Statuses"/>
        </fieldset>
        </form>
        </div>
        
        <p></p>
        <div id="add_edit_category">
		</form>
        <form name="add_categories" method=POST action="add_edit_entry.php">
        <fieldset>
        <legend>Add Categories</legend>
            <input type="text" name="new_category" />
            <input type="submit" name="add_category" value="Add Category" />
            </fieldset>
        </form>
        <form name="edit_categories" method=POST action="add_edit_entry.php">
        <fieldset>
        <legend>Edit Categories</legend>
        	<? $myCategory->display_edit_categories2(); ?>
            <input type="submit" name="edit_status" value="Edit Statuses"/>
        </fieldset>
        </form>
        </div>
</body>

<?php
//Add Status
//==========================================================================
/*if (!empty($_POST['new_status']))
{
	$new_status = $_POST['new_status'];
	$myStatus->add_status($new_status);
	echo "Status added!";
}
//Add Category
//==========================================================================
if (!empty($_POST['new_category']))
{
	$new_category = $_POST['new_category'];
	$myCategory->add_category($new_category);
	echo "Category added!";
	//header("location: index.php?success=add");
}*/

?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>

/*function status_click()
{
	document.getElementById('add_edit_status').style.display='block';
}

function category_click()
{
	document.getElementById('add_edit_category').style.display='block';
}*/
//var button1 = document.getElementById('add_edit_status_button');
function status_click() {
    var div = document.getElementById('add_edit_status');
    if (div.style.display !== 'none') {
        div.style.display = 'none';
    }
    else {
        div.style.display = 'block';
    }
};
//var button = document.getElementById('add_edit_category_button'); // Assumes element with id='button'

function category_click() {
    var div = document.getElementById('add_edit_category');
    if (div.style.display !== 'none') {
        div.style.display = 'none';
    }
    else {
        div.style.display = 'block';
    }
};
/*$("add_edit_category_button").click(function() {
    $("#add_edit_category").toggle();
});*/

</script>
</html>
