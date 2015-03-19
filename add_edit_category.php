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


//Add Category
//==========================================================================
if (!empty($_POST['new_category']))
{
	$new_category = $_POST['new_category'];
	$myCategory->add_category($new_category);
	echo "Category added!";
	header("location: http://dight350.tardis-shoes.com/gimenez/mini-cms/index.php?success=add");
}
//Edit Category
//==========================================================================
if (!empty($_POST['category']))
{
	$edit_category = $_POST['category'];
		echo "edit category: <br>";
		var_dump($edit_category);
	$categoryID = $_POST['category_id'];
		echo "<br>categoryID: <br>";
		var_dump($categoryID);
	$length = count($edit_category);
	$length_id = count($categoryID);
		echo "<br>length: $length<br>";
		echo "<br>length_id: $length_id<br>";
	for ($i = 0; $i < count($edit_category); $i++)
	{
			//echo "<br>i: $i<br>";
			//echo "categoryID: $categoryID[$i]<br>";
			//echo "edit_category: $edit_category[$i] <br>";
		$myCategory->edit_category($categoryID[$i], $edit_category[$i]);
	}
	echo "Category edited!";
	header('location: index.php?success=edit');
}
//Delete Category
//==========================================================================
if (!empty($_POST['delete_category']))
{
	$category_array = $_POST['entry_category'];
			
			foreach ( $category_array as $id):
				$category_id = $id;
				var_dump($category_array);
				
				$myCategory->remove_category($id);
				echo "removed category";
				
				$myEntryCategory->delete_entry_category($entry_id,$category_id);
				echo "completed delete_entry_category<br>";
			endforeach;
			//header("location: index.php?success=delete");
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add/Edit Category</title>
</head>

<body>
<h1>Add Edit, or Delete a Category</h1>
<a href="http://dight350.tardis-shoes.com/gimenez/mini-cms/">Back to Blog</a>
        <div id="add_edit_category">
		</form>
        <form name="add_categories" method=POST action="add_edit_category.php">
        <fieldset>
        <legend>Add Categories</legend>
            <input type="text" name="new_category" />
            <input type="submit" name="add_category" value="Add Category" />
            </fieldset>
        </form>
        
        <form name="edit_categories" method=POST action="add_edit_category.php">
        <fieldset>
        <legend>Edit Categories</legend>
        	<? $myCategory->display_edit_categories2(); ?>
            <input type="submit" name="edit_category" value="Edit Categories"/>
        </fieldset>
        </form>
        
        <form name="delete_categories" method=POST action="add_edit_category.php">
        <fieldset>
        <legend>Delete Categories</legend>
        	<? $myCategory->display_delete_categories(); ?>
            <input type="submit" name="delete_category" value="Delete Cateories"/>
        </fieldset>
        </form>
        </div>
</body>
</html>
