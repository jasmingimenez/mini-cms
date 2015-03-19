<?php
	class Entry_Category {
		
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
		public function add_entry_category($entry_id,$category_id) {
			# Template for our insert query
			$insert_query = "
				INSERT INTO
					entry_category
					(entryID,categoryID)
				VALUES
					(".$entry_id.",".$category_id.")
			";
			echo "<br>entry_category Insert Query: $insert_query<br>";

			# If the query prepares properly, send the record in to the database
			if ( $new_entry_category = $this->database->prepare($insert_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				/*$new_wizard_speciality->bind_param(
					'ii',
					$wizard_id, $speciality_id
				);*/
				
				$new_entry_category->execute();
				
				# Close out the prepared statement
				$new_entry_category->close();
				
				# Return the index page, using the GET to supply a message
				//header("location: index.php?success=add");
			endif;
		}
//======================================================================================================================		
		# Get all the information for a single potion
		public function single_entry_category($entry_id) {
			$query_singleEntry = "
				SELECT 
					id,entryID,categoryID
				FROM
					entry_category
				WHERE
					entryID=?
			";
			
			if ( $entry_category = $this->database->prepare($query_singleEntry) ):
				 $entry_category->bind_param(
				 	'i',
				 	$entry_id
				 );
				 
				 $entry_category->execute();
				 
				 $entry_category->bind_result($id, $entry_id, $category_id);//if there is more than one entry, these variables will be arrays
				 //echo "id: $id <br>";
				 //echo "entry_id: $entry_id<br>";
				 //echo "category_id: $category_id<br>";
				 
				 while ($entry_category->fetch())
				 {
					 //echo "<br>id: $id<BR>";
					 //echo "entry_id: $entry_id<br>";
					 //echo "category_id: $category_id<br>";
					 //echo "<br>Entry_Category_Info Array:<br> $entry_category_info<bR>";
				 $entry_category_info["id"] = $id;
				 $entry_category_info["entry_id"] = $entry_id;
 				 $entry_category_info["category_id"] = $category_id;
				 //echo "<br>entry_category_info:<br>";
				 //print_r($entry_category_info);
				 $EC_array[] = $entry_category_info;
				 //echo "<br>EC_array: <br>";
				 //print_r($EC_array);
				 }
				 //echo "<br>Entry_Category_Info:<br> $entry_category_info<br>";
				 
				 $entry_category->close();
				 
				 return $EC_array;
			else:
				echo "<br>single query did not execute<br>";
			endif;
		}
//======================================================================================================================
		# Edit an existing potion
		public function edit_entry_category( $entry_id, $category_id ) {
			$update_query = "
				UPDATE
					entry_category
				SET
					entryID=".$entry_id.",
					categoryID=".$category_id."
				WHERE
					entryID=? AND categoryID=?
				LIMIT 1
			";
			//echo "<br>Entry Category update_query: $update_query<br>";//you first have to get the old ones
			
			if ( $entry_category_update = $this->database->prepare($update_query) ):
				$entry_category_update->bind_param(
					'ii',
					$entryID, $categoryID
				);//$old_entry_id, $old_categoryID
				
				//echo "<br>Entry Category update_query prepared: $update_query<br>";
				
				$entry_category_update->execute();
				
				$entry_category_update->close();
			else:
				echo "entry_category update_query did not execute.<br>";
				
				//header("location: index.php?success=edit");
			endif;
		}
//======================================================================================================================
		# Delete an existing potion from the database
		public function remove_entry_category($entry_id,$category_id) {
			$delete_query = "
				DELETE FROM
					entry_category
				WHERE 
					entryID=? AND categoryID=?
				LIMIT 1
			";
			
			if ( $entry_category_removal = $this->database->prepare($delete_query) ):
				$entry_category_removal->bind_param(
					'ii',
					$entry_id,$category_id
				);
				
				$entry_category_removal->execute();
				
				$entry_category_removal->close();
				
				//header("location: index.php?success=delete");
			endif;
		}
//======================================================================================================================
		public function find_category_id($entry_id)
		{
			$find_query = "
				SELECT categoryID
				FROM entry_category
				WHERE entryID=".$entry_id."			
			
			";
			if ($find_category_id = $this->database->prepare($find_query))
			{
				/*$find_speciality_id->bind_param(
				'i',
				$wizard_id
				);*/
				
				$find_category_id->execute();
				$find_category_id->bind_result($speciality_id);
				$find_category_id->fetch();
				$find_category_id->close();
				return $category_id;
			}
		}
		
		
	}
?>
