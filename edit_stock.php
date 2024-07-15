<?php
require_once("inventory_class.php");
# this adds the html head to this php file, so the code doest have to be repeated each time
include("public/header.php");

$inventory = new Inventory();

?>

<h2>Edit Items Stock</h2>

<form action="edit_stock2.php" method="POST">
        
  <label for="item-select">Select Item:</label>
  <select id="item-select" name="selected_item">
    <!-- To display options -->
    <?php $inventory->itemDropDown();?>
  </select>

  
  <button type="submit">Edit Stock of Selected Item</button>
</form>

<?php
# this adds the html footer to this php file
include("public/footer.php");
?>