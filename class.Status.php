<?php
	class Status {
		
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
		public function display_statuses()
		{
			$query_all_statuses = "
				SELECT id,status
				FROM statuses
			";
			if ($all_statuses = $this->database->prepare($query_all_statuses))
			{
				$all_statuses->execute();
			}
			else
			{
				echo "There was a problem executing your display_statuses query.";
			}
			
			$all_statuses->store_result();
			$all_statuses->bind_result($statusID,$status);
			
			if ($all_statuses->num_rows == 0)
			{
				echo "<p>No alignments.</p>";
			}
			else
			{
				while ($all_statuses->fetch())
				{
					echo "
						<option value='".$statusID."' >".$status."</option>
					";
				}
			}
			
		}
//======================================================================================================================
		public function display_edit_statuses()
		{
			$query_all_statuses = "
				SELECT id,status
				FROM statuses
			";
			if ($all_statuses = $this->database->prepare($query_all_statuses))
			{
				$all_statuses->execute();
			}
			else
			{
				echo "There was a problem executing your query.";
			}
			
			$all_statuses->store_result();
			$all_statuses->bind_result($statusID,$status);
			
			if ($all_statuses->num_rows == 0)
			{
				echo "<p>No alignments.</p>";
			}
			else
			{
				while ($all_statuses->fetch())
				{
					echo "
					<p>
						<input type='hidden' name='status_id[]' value='".$statusID."' />
						<input type='text' name='status[]' value='".$status."' />
					</p>
					";
				}
			}
			
		}
//======================================================================================================================
		public function display_delete_statuses()
		{
			$query_all_statuses = "
				SELECT id,status
				FROM statuses
				ORDER BY status
			";
			if ($all_statuses = $this->database->prepare($query_all_statuses))
			{
				$all_statuses->execute();
			}
			else
			{
				echo "There was a problem executing your query.";
			}
			
			$all_statuses->store_result();
			$all_statuses->bind_result($statusID,$status);
			
			if ($all_statuses->num_rows == 0)
			{
				echo "<p>No alignments.</p>";
			}
			else
			{
				while ($all_statuses->fetch())
				{
					echo "
					<p>
						<input type='checkbox' name='status[]' value='".$statusID."' />".$status."
					</p>
					";
				}
			}
			
		}
//======================================================================================================================	
		# Get all the information for a single potion
		public function single_status($id) {
			$query_single_status = "
				SELECT 
					id,status
				FROM
					statuses
				WHERE
					id=?
				LIMIT 1
			";
			
			if ( $status = $this->database->prepare($query_single_status) ):
				 $status->bind_param(
				 	'i',
				 	$id
				 );
				 
				 $status->execute();
				 
				 $status->bind_result($statusID,$status);
				 
				 $status->fetch();
				 
				 $status_info["statusID"] = $statusID;
 				 $status_info["status"] = $status;
				 
				 $status->close();
				 
				 return $status_info;
			endif;
		}
//======================================================================================================================		
		public function add_status($status) {
			# Template for our insert query
			$insert_query = "
				INSERT INTO
					statuses
					(status)
				VALUES
					(?)
			";

			# If the query prepares properly, send the record in to the database
			if ( $new_status = $this->database->prepare($insert_query) ):
				
				# First argument is the data types for each piece of information
				# Second argument is the data itself
				$new_status->bind_param(
					's',
					$status
				);
				
				$new_status->execute();
				
				# Close out the prepared statement
				$new_status->close();
				
				# Return the index page, using the GET to supply a message
				//header("location: index.php?success=add");
			endif;
		}
//======================================================================================================================
		# Edit an existing potion
		public function edit_status( $id, $status ) {
			$update_query = "
				UPDATE
					statuses
				SET
					status=?
				WHERE
					id=?
				LIMIT 1
			";
			//echo "update_query: $update_query<br>";
			
			if ( $status_update = $this->database->prepare($update_query) ):
				$status_update->bind_param(
					'si',
					$status, $id
				);
				//echo "<br>update_query prepared: $update_query<br>";
				//echo $status;
				//echo $id;
				
				$status_update->execute();
				
				$status_update->close();
				
				//header("location: index.php?success=edit");
			else:
				echo "edit query not prepared.<br>";
			endif;
		}
//======================================================================================================================
		# Delete an existing potion from the database
		public function remove_status($id) {
			$delete_query = "
				DELETE FROM
					statuses
				WHERE 
					id=?
				LIMIT 1
			";
			
			if ( $status_removal = $this->database->prepare($delete_query) ):
				$status_removal->bind_param(
					'i',
					$id
				);
				
				$status_removal->execute();
				
				$status_removal->close();
				
				//header("location: index.php?success=delete");
			endif;
		}
		
		
	}
?>
