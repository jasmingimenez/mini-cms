<?php
	class Blog {
		private $database;
		private $blog_list;
//======================================================================================================================
		public function __construct() {
			$this->database = new mysqli("localhost","tardissh_jgim","5885!","tardissh_gimenez");

			if ( $this->database->connect_error ):
				die( "Connection Error! Error: " . $this->database->connect_error );
			endif;
		}
//======================================================================================================================		
		public function all_entries() {
			$query_all_entries = "
				SELECT 
					entries.id,
					entries.post,
					entries.title,
					entries.date,
					statuses.status,
					GROUP_CONCAT(categories.category SEPARATOR ' &bull; ') AS category_list
				FROM
					entries
					LEFT JOIN 
						statuses 
							ON entries.statusID = statuses.id
					LEFT JOIN 
						entry_category 
							ON entry_category.entryID = entries.id
					LEFT JOIN 
						categories 
							ON entry_category.categoryID = categories.id
				GROUP BY
					entries.id
				ORDER BY
					entries.date DESC
				
			";

			if ( $this->blog_list = $this->database->prepare($query_all_entries) ):
				$this->blog_list->execute();
			else:
				die ( "<p class='error'>There was a problem executing your all query</p>" );
			endif;
		}
//======================================================================================================================		
		/*public function by_status($status_id) {
			$query_all_entries = "
				SELECT 
					entries.id,
					entries.post,
					entries.title,
					entries.date,
					statuses.status,
					GROUP_CONCAT(categories.category SEPARATOR ' &bull; ') AS category_list
				FROM
					entries
					LEFT JOIN 
						statuses 
							ON entries.statusID = statuses.id
					LEFT JOIN 
						entry_category 
							ON entry_category.entryID = entries.id
					LEFT JOIN 
						categories 
							ON entry_category.categoryID = categories.id
				WHERE statuses.id=?
				GROUP BY
					entries.id
				ORDER BY
					entries.date DESC
				
			";
			echo "<h1>By Status</h1>";

			if ( $this->blog_list = $this->database->prepare($query_all_entries) ):
				$this->blog_list->execute();
			else:
				die ( "<p class='error'>There was a problem executing your status query</p>" );
			endif;
				
				$this->blog_list->bind_param(
				'i',$status_id
				);
				$this->blog_list->store_result();
	
				$this->blog_list->bind_result($id,$post,$title,$date,$status,$category);
				
				if ( $this->blog_list->num_rows == 0 ):
				echo "
					<p>No entries are in the blog at this time</p>
				";
				
				else:
				
				while ($this->blog_list->fetch())
				{
					$by_status_info["id"] = $id;
					$by_status_info["post"] = $post;
					$by_status_info["title"] = $title;
					$by_status_info["date"] = $date;
					$by_status_info["status"] = $status;
					$by_status_info["category"] = $category;
					
					$by_status_array[] = $by_status_info;
					print_r($by_status_array);
				}
				return $by_status_info;
				
					$this->blog_list->close();
				endif;
		}*/
//======================================================================================================================
//I would pass the parameter of the function into display blog to tell it which function I actually want to call to display the blog
//all_entries()
//by_status($statusID) WHERE status=?$statusID
//by_category($categoryID) WHERE category=?$categoryID
//I can set the public function all_entries to a public variable $all_entries;. I can assign all the functions to variables.
		public function display_blog() {
			$this->all_entries();

			$this->blog_list->store_result();

			$this->blog_list->bind_result($id,$post,$title,$date,$status,$category);

			if ( $this->blog_list->num_rows == 0 ):
				echo "
					<p>No entries are in the blog at this time</p>
				";
			else:
				echo "
				<div id='master_btn' >
					<form method=POST action='add_edit_entry.php'>
						<input type='submit' id='add_btn' class='button' name='add' value='Add Entry' />
					</form>
					<form method=POST action='add_edit_status.php'>
						<input type='submit' class='button' name='add_edit_status_button' value='Add/Edit/Delete Status' />
					</form>
					<form method=POST action='add_edit_category.php'>
						<input type='submit' class='button' name='add_edit_category_button' value='Add/Edit/Delete Category' />
					</form>
				</div>
				<div class='clear'></div>
				";
				while( $this->blog_list->fetch() ):
					echo "

				<div class='entry'>
					<div class='left-column'>
						<form method=POST action='edit.php'>
							<input type='hidden' name='entry_id' value=$id />
							<input type='submit' class='button' name='btn_action' class='btn_action edit' value='Edit Entry' />
						</form>
						<form method=POST action='index.php'>
							<input type='hidden' name='entry_id' value=$id />
							<input type='submit' class='button' name='btn_action' class='btn_action delete' value='Delete Entry' />
						</form><br>
						<div class='categories'><p><strong>$category</strong></p><p>$status</p></div>
					</div>
					<div class='right-column'>
						<h1>$title</h1>
						<h4>$date</h4>
						<div class='post'>$post</div>
					</div>
				</div>
					";
				endwhile;

				$this->blog_list->close();
			endif;
		}
//======================================================================================================================
		public function display_blog_by_status($status_id) {
			
			$query_by_status = "
				SELECT 
					entries.id,
					entries.post,
					entries.title,
					entries.date,
					statuses.status,
					GROUP_CONCAT(categories.category SEPARATOR ' &bull; ') AS category_list
				FROM
					entries
					LEFT JOIN 
						statuses 
							ON entries.statusID = statuses.id
					LEFT JOIN 
						entry_category 
							ON entry_category.entryID = entries.id
					LEFT JOIN 
						categories 
							ON entry_category.categoryID = categories.id
				WHERE statuses.id=".$status_id."
				GROUP BY
					entries.id
				ORDER BY
					entries.date DESC
				
			";
			//echo "<h1>By Status</h1>";
			//echo "<p>query_by_status: $query_by_status</p>";

			if ( $status_list = $this->database->prepare($query_by_status) ):
				//echo "<p>Entered prepared if.</p>";
				var_dump($status_list);
				$status_list->execute();
			else:
				die ( "<p class='error'>There was a problem executing your status query</p>" );
			endif;
				
				$status_list->bind_param(
				'i',$status_id
				);
				//echo "<p>Parameters bound. status_id: $status_id</p>";
				var_dump($status_list);

			$status_list->store_result();
				//echo "<p>Result stored.</p>";
				var_dump($status_list);

			$status_list->bind_result($id,$post,$title,$date,$status,$category);
				//echo "<p>Result bound</p>";

			if ( $this->blog_list->num_rows == 0 ):
				//echo "<p>Entered num_rows if.</p>";
				echo "
					<p>No entries of this status are in the blog at this time</p>
				";
			else:
				//echo "<p>Entered num_rows else.</p>";
				echo "
				<div id='master_btn'>
					<form method=POST action='add_edit_entry.php'>
						<input type='submit' id='add_btn' class='button' name='add' value='Add Entry' />
					</form>
					<form method=POST action='add_edit_status.php'>
						<input type='submit' class='button' name='add_edit_status_button' value='Add/Edit/Delete Status' />
					</form>
					<form method=POST action='add_edit_category.php'>
						<input type='submit' class='button' name='add_edit_category_button' value='Add/Edit/Delete Category' />
					</form>
				</div>
				<div class='clear'></div>
				";
				

				while( $status_list->fetch() ):
					//echo "<p>Fetching while loop fired.</p>";
					echo "

				<div class='entry'>
					<div class='left-column'>
						<form method=POST action='edit.php'>
							<input type='hidden' name='entry_id' value=$id />
							<input type='submit' class='button' name='btn_action' class='btn_action edit' value='Edit Entry' />
						</form>
						<form method=POST action='index.php'>
							<input type='hidden' name='entry_id' value=$id />
							<input type='submit' class='button' name='btn_action' class='btn_action delete' value='Delete Entry' />
						</form><br>
						<div class='categories'><p><strong>$category</strong></p><p>$status</p></div>
					</div>
					<div class='right-column'>
						<h1>$title</h1>
						<h4>$date</h4>
						<div class='post'>$post</div>
					</div>
				</div>
					";
				endwhile;

				$status_list->close();
			endif;
		}
//======================================================================================================================
		public function display_blog_by_category($category_id) {
			
			$query_by_category = "
				SELECT 
					entries.id,
					entries.post,
					entries.title,
					entries.date,
					statuses.status,
					GROUP_CONCAT(categories.category SEPARATOR ' &bull; ') AS category_list
				FROM
					entries
					LEFT JOIN 
						statuses 
							ON entries.statusID = statuses.id
					LEFT JOIN 
						entry_category 
							ON entry_category.entryID = entries.id
					LEFT JOIN 
						categories 
							ON entry_category.categoryID = categories.id
				WHERE categories.id=".$category_id."
				GROUP BY
					entries.id
				ORDER BY
					entries.date DESC
				
			";
			//echo "<h1>By Category</h1>";
			//echo "<p>query_by_category: $query_by_category</p>";

			if ( $category_list = $this->database->prepare($query_by_category) ):
				//echo "<p>Entered prepared if.</p>";
				//var_dump($category_list);
				$category_list->execute();
			else:
				die ( "<p class='error'>There was a problem executing your category query</p>" );
			endif;
				
				$category_list->bind_param(
				'i',$status_id
				);
				//echo "<p>Parameters bound. category_id: $category_id</p>";
				//var_dump($category_list);

			$category_list->store_result();
				//echo "<p>Result stored.</p>";
				//var_dump($category_list);

			$category_list->bind_result($id,$post,$title,$date,$status,$category);
				//echo "<p>Result bound</p>";

			if ( $category_list->num_rows == 0 ):
				//echo "<p>Entered num_rows if.</p>";
				echo "
					<p>No entries of this category are in the blog at this time</p>
				";
			else:
				//echo "<p>Entered num_rows else.</p>";
				echo "
				<div id='master_btn'>
					<form method=POST action='add_edit_entry.php'>
						<input type='submit' id='add_btn' class='button' name='add' value='Add Entry' />
					</form>
					<form method=POST action='add_edit_status.php'>
						<input type='submit' class='button' name='add_edit_status_button' value='Add/Edit/Delete Status' />
					</form>
					<form method=POST action='add_edit_category.php'>
						<input type='submit' class='button' name='add_edit_category_button' value='Add/Edit/Delete Category' />
					</form>
				</div>
				<div class='clear'></div>
				";
				

				while( $category_list->fetch() ):
					//echo "<p>Fetching while loop fired.</p>";
					echo "

				<div class='entry'>
					<div class='left-column'>
						<form method=POST action='edit.php'>
							<input type='hidden' name='entry_id' value=$id />
							<input type='submit' class='button' name='btn_action' class='btn_action edit' value='Edit Entry' />
						</form>
						<form method=POST action='index.php'>
							<input type='hidden' name='entry_id' value=$id />
							<input type='submit' class='button' name='btn_action' class='btn_action delete' value='Delete Entry' />
						</form><br>
						<div class='categories'><p><strong>$category</strong></p><p>$status</p></div>
					</div>
					<div class='right-column'>
						<h1>$title</h1>
						<h4>$date</h4>
						<div class='post'>$post</div>
					</div>
				</div>
					";
				endwhile;

				$category_list->close();
			endif;
		}
//======================================================================================================================
	}
?>
