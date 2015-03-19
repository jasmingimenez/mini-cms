<?php
	class Category {
		
		private $database;
//======================================================================================================================		
		# This method is automagically called when you create a new Object using this Class
		public function __construct() {
			# New mysqli Object for database communication
			$this->database = new mysqli("localhost","tardissh_jgim","5885!","tardissh_gimenez");

			# Kill the page is there was a problem with the database connection
			if ( $this->database->connect_error ):
				die( "Connection Error! Error: " . $this->database->connect_error );
			endif;
		}
//======================================================================================================================
		public function display_categories()
		{
			$query_all_categories = "
				SELECT id,category
				FROM categories
				ORDER BY category
			";
			if ($categories_list = $this->database->prepare($query_all_categories))
			{
				$categories_list->execute();
			}
			else
			{
				echo "There was a problem executing your query.";
			}
			
			$categories_list->store_result();
			
			$categories_list->bind_result($category_id,$category);
			
			if ($categories_list->num_rows == 0 )
			{
				echo "<p>No categories.</p>";
			}
			else
			{
				while ($categories_list->fetch())
				{
					echo "
						<input type='checkbox' name='entry_category[]' value='".$category_id."'>".$category."<br>
					";
				}
			}
		}
//======================================================================================================================
		public function display_categories2()
		{
			$query_all_categories = "
				SELECT id,category
				FROM categories
				ORDER BY category
			";
			if ($categories_list = $this->database->prepare($query_all_categories))
			{
				$categories_list->execute();
			}
			else
			{
				echo "There was a problem executing your query.";
			}
			
			$categories_list->store_result();
			
			$categories_list->bind_result($category_id,$category);
			
			if ($categories_list->num_rows == 0 )
			{
				echo "<p>No categories.</p>";
			}
			else
			{
				while ($categories_list->fetch())
				{
					echo "
						<option value='".$category_id."' >".$category."</option>
					";
				}
			}
		}
//======================================================================================================================
		public function display_edit_categories($entry_id)
		{
			$query_all_categories = "
				SELECT id,category
				FROM categories
				ORDER BY category
			";
			if ($categories_list = $this->database->prepare($query_all_categories))
			{
				$categories_list->execute();
			}
			else
			{
				echo "There was a problem executing your query.";
			}
			
			$categories_list->store_result();
			
			$categories_list->bind_result($category_id,$category);
			
			if ($categories_list->num_rows == 0 )
			{
				echo "<p>No categories.</p>";
			}
			else
			{
				require_once 'class.entry_category.php';
				$myEntryCategory = new Entry_Category;
				
				/*foreach( $edit_entry as $key => $value ):
					${$key} = $value;
				endforeach;*/
				//$single_entry_category = $myEntryCategory->single_entry_category($entry_id);

				while ($categories_list->fetch())
				{
					$single_entry_category = $myEntryCategory->single_entry_category($entry_id);
					//echo "Single_Entry_category: <br>";
					//print_r($single_entry_category);
					//echo "<br>";
					//echo "<br>array item: ";
					//print_r($single_entry_category[0]['category_id']);
					//echo "<br>";
					$checked = 0;

				for ($i = 0; $i < count($single_entry_category); $i++)
				{
					if ($single_entry_category[$i]["category_id"] == $category_id)
					{
						$checked++;
					}
				}
				if ($checked > 0)
				{
					echo "
						<input type='checkbox' name='entry_category[]' value='".$category_id."' checked>".$category."<br>
					";
				}
				else
				{
					echo "
						<input type='checkbox' name='entry_category[]' value='".$category_id."'>".$category."<br>
					";
				}
				
				}//end while fetch
			}
		}
//======================================================================================================================
		public function display_delete_categories()
		{
			$query_all_categories = "
				SELECT id,category
				FROM categories
				ORDER BY category
			";
			if ($categories_list = $this->database->prepare($query_all_categories))
			{
				$categories_list->execute();
			}
			else
			{
				echo "There was a problem executing your query.";
			}
			
			$categories_list->store_result();
			
			$categories_list->bind_result($category_id,$category);
			
			if ($categories_list->num_rows == 0 )
			{
				echo "<p>No categories.</p>";
			}
			else
			{
				require_once 'class.entry_category.php';
				$myEntryCategory = new Entry_Category;
				
				/*foreach( $edit_entry as $key => $value ):
					${$key} = $value;
				endforeach;*/
				//$single_entry_category = $myEntryCategory->single_entry_category($entry_id);

				while ($categories_list->fetch())
				{

						echo "
							<input type='checkbox' name='entry_category[]' value='".$category_id."'>".$category."<br>
						";
				}
			}
		}
//======================================================================================================================
		public function display_edit_categories2()
		{
			$query_all_categories = "
				SELECT id,category
				FROM categories
			";
			if ($categories_list = $this->database->prepare($query_all_categories))
			{
				$categories_list->execute();
			}
			else
			{
				echo "There was a problem executing your query.";
			}
			
			$categories_list->store_result();
			
			$categories_list->bind_result($category_id,$category);
			
			if ($categories_list->num_rows == 0 )
			{
				echo "<p>No categories.</p>";
			}
			else
			{
				while ($categories_list->fetch())
				{
					echo "
					<p>
						<input type='hidden' name='category_id[]' value='".$category_id."' />
						<input type='text' name='category[]' value='".$category."' />
					</p>
					";
				}
			}
		}
//======================================================================================================================		
		# Get all the information for a single potion
		public function single_category($id) {
			$query_single_category = "
				SELECT 
					id,category
				FROM
					categories
				WHERE
					id=?
				LIMIT 1
			";
			
			if ( $category = $this->database->prepare($query_single_category) ):
				 $category->bind_param(
				 	'i',
				 	$id
				 );
				 
				 $category->execute();
				 
				 $category->bind_result($category_id,$category);
				 
				 $category->fetch();
				 
				 $category_info["category_id"] = $category_id;
 				 $category_info["category"] = $category;
				 
				 $category->close();
				 
				 return $category_info;
			endif;
		}
//======================================================================================================================		
		public function add_category($category) {
			# Template for our insert query
			$insert_query = "
				INSERT INTO
					categories
					(category)
				VALUES
					(?)
			";
			//echo "insert_query: $insert_query<br>";
			# If the query prepares properly, send the record in to the database
			if ( $new_category = $this->database->prepare($insert_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				$new_category->bind_param(
					's',
					$category
				);
				
				$new_category->execute();
				//echo "new_Category: $new_category executed<br>";
				
				# Close out the prepared statement
				$new_cateogry->close();
				
				# Return the index page, using the GET to supply a message
				//header("location: index.php?success=add");
			endif;
		}
//======================================================================================================================
		# Edit an existing potion
		public function edit_category( $id, $category ) {
			$update_query = "
				UPDATE
					categories
				SET
					category=?
				WHERE
					id=?
				LIMIT 1
			";
			
			if ( $category_update = $this->database->prepare($update_query) ):
				$category_update->bind_param(
					'si',
					$category, $id
				);
				
				$category_update->execute();
				
				$category_update->close();
				
				//header("location: index.php?success=edit");
			else:
				echo "update_query not prepared.<br>";
			endif;
		}
//======================================================================================================================
		# Delete an existing potion from the database
		public function remove_category($id) {
			$delete_query = "
				DELETE FROM
					categories
				WHERE 
					id=?
				LIMIT 1
			";
			
			if ( $category_removal = $this->database->prepare($delete_query) ):
				$category_removal->bind_param(
					'i',
					$id
				);
				
				$category_removal->execute();
				
				$category_removal->close();
				
				header("location: index.php?success=delete");
			endif;
		}
		
		
	}
?>
