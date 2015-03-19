# mini-cms
This php site is a mini-cms. It allows the "admin" to add, edit, and delete posts. The admin may categorize posts, and assign them a status.

class.Blog.php

class.Entry.php

class.Status.php

class.Category.php
class that controls the different categories that may be assigned to a post, such as "art" or "history"
The following methods are in this class:
__construct() : php constructor
display_categories() : displays the categories in the database as options in a checkbox list (for add_edit_entry.php)
display_categories2() : displays the categories in the database as options in a select menu (for index.php)
display_edit_categories($entry_id) : displays the categories in the database as options in a checkbox list, automatically checking the boxes that correspond with the particular entry being edited (for edit.php).
display_delete_categories() : displays the categories in the database as options in a checkbox list (to be deleted)
display_edit_categories2() : displays the categories in the database as text inputs for the user to edit
single_category($i) : returns all the database information belonging to one entry (for edit.php)
add_category($category) : adds a category to the database
edit_category($id, $category) : takes information from user and updates the category table in the database
remove_category($i) : deletes the category from the database with the given $id.

class.entry_category.php
This class controls the relational database table entry_category
