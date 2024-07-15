<?php
include("public/header.php");
require_once 'repository_class.php';

// Initialize repository
$repository = new Repository();


$item_namelist = $repository->getItemNames();
// var_dump($item_namelist);
if (count($item_namelist) > 0){
echo '<h2>Item Names</h2>';
echo '<ul>';
foreach ($item_namelist as $item) {
  echo "<li>$item</li>";
}
echo '</ul>';
}else{
  echo "There are no items. Add New Items to list them.<br><br>".
   "<button><a href='add_items.php'> Add New Items </a></button>";
}

include("public/footer.php");
?>




<!-- // The OLD Code before having a Database and a repository:

// This grants access to the functions from the Inventory Class 
require_once("inventory_class.php");
# this adds the html head to this php file, so the code doest have to be repeated each time
include("public/header.php");

$inventory = new Inventory();
$item_namelist = $inventory->getItemNames();
if (count($item_namelist) > 0){
echo '<h2>Item Names</h2>';
echo '<ul>';
foreach ($item_namelist as $item) {
  echo "<li>$item</li>";
}
echo '</ul>';
}else{
  echo "There are no items. Add New Items to list them.<br><br>".
   "<button><a href='add_items.php'> Add New Items </a></button>";
}
# this adds the html footer to this php file
include("public/footer.php");
?>-->