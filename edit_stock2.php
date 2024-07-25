<?php
include("public/header.php");
require_once("inventory_class.php");


//The selected item from the dropdown
$selected_item = $_POST['selected_item'];

// Creating an inventory object of the InventoryManagement class, to use its method getStockOOP()
$inventory = new Inventory();
// var_dump( $inventory);

// var_dump($selected_item);
?>

<h2>Edit Stock of <?php echo $selected_item ?></h2>

<p>The current stock is: <b> <?php
echo $inventory->getStockOOP($selected_item);
?></b>
</p>
<form action="edit_stock3.php" method="POST">
        
        <label for="Stock">New Stock:</label>
        <input style="width:40px" id="Stock" type="text" name="stock" />
        <!-- This hidden input will pass the $selected_item thrpugh th ePOST method -->
        <input type="hidden" name="selected_item" value=
        "<?php echo($selected_item);?>"
        >
        <button type="submit" value="submit">Confirm New Stock</button>
      </form>


<?php
# this adds the html footer to this php file
include("public/footer.php");
?>