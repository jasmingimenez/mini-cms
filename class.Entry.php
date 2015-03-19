<?php
	class Entry {
		
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
		# Get all the information for a single potion
		public function single_entry($id) {
			$query_singleEntry = "
				SELECT 
					id,post,title,date,statusID
				FROM
					entries
				WHERE
					id=?
				LIMIT 1
			";
			
			if ( $entry = $this->database->prepare($query_singleEntry) ):
				 $entry->bind_param(
				 	'i',
				 	$id
				 );
				 
				 $entry->execute();
				 
				 $entry->bind_result($entry_id,$post,$title,$date,$statusID);
				 
				 $entry->fetch();
				 
				 $entry_info["entry_id"] = $entry_id;
 				 $entry_info["entry_post"] = $post;
				 $entry_info["entry_title"] = $title;
				 $entry_info["entry_date"] = $date;
 				 $entry_info["entry_status"] = $statusID;
				 
				 $entry->close();
				 
				 return $entry_info;
			endif;
		}
//======================================================================================================================
		public function get_entry_id($entry_title)
		{
			$id_query = "
				SELECT id
				FROM entries
				WHERE title='".$entry_title."'
			";
			//echo "<br>Entry Title: $entry_title<br>";
			//echo "<br>entry_id id_query: $id_query<br>";
			if ($entry_id = $this->database->prepare($id_query))
			{
				$entry_id->bind_param('s',$entry_title);
				$entry_id->execute();
				$entry_id->bind_result($id);
				//echo "<br>Entry Id: $id<br>";
				$entry_id->close();
				return $id;
			}
			else
			{
				echo "did not execute query.";
			}
		}
//======================================================================================================================		
		public function add_entry($entry_post, $entry_title, $entry_date, $entry_statusID) {
			# Template for our insert query
			$insert_query = "
				INSERT INTO
					entries
					(post,title,date,statusID)
				VALUES
					(?,?,?,?)
			";
			//echo "Insert Query: $insert_query<br>";

			# If the query prepares properly, send the record in to the database
			if ( $new_entry = $this->database->prepare($insert_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				$new_entry->bind_param(
					'sssi',
					$entry_post,$entry_title,$entry_date,$entry_statusID
				);
				
				$new_entry->execute();
				
				$insertID = $this->database->insert_id;
				echo "<br>InsertID: $insertID<br>";
				
				# Close out the prepared statement
				$new_entry->close();
			else:
				echo "query did not execute properly.";
				
				# Return the index page, using the GET to supply a message
				//header("location: index.php?success=add");
			endif;
			return $insertID;
		}
//======================================================================================================================
		# Edit an existing potion
		public function edit_entry( $id, $post, $title, $date, $status ) {
			$update_query = "
				UPDATE
					entries
				SET
					post='".$post."',
					title='".$title."',
					date='".$date."',
					statusID='".$status."'
				WHERE
					id=".$id."
				LIMIT 1
			";
			//echo "Update Query: $update_query<br>";
			
			if ( $entry_update = $this->database->prepare($update_query) ):
				$entry_update->bind_param(
					'sssii',
					$post, $title, $date, $statusID, $id
				);
				//echo "Update Query Prepared: $update_query<br><br>";
				
				//echo "Post: $post<br>";
				//echo "Title: $title<br>";
				//echo "StatusID: $statusID<br>";
				//echo "ID: $id<br>";
				
				$entry_update->execute();
				
				
				$entry_update->close();
			else:
				echo "<br>Update query not prepared<Br>";
				
				//header("location: index.php?success=edit");
			endif;
		}
//======================================================================================================================
		# Delete an existing potion from the database
		public function remove_entry($id) {
			$delete_query = "
				DELETE FROM
					entries
				WHERE 
					id=?
				LIMIT 1
			";
			
			if ( $entry_removal = $this->database->prepare($delete_query) ):
				$entry_removal->bind_param(
					'i',
					$id
				);
				
				$entry_removal->execute();
				
				$entry_removal->close();
				
				header("location: index.php?success=delete");
			endif;
		}
		
		
	}
?>
