<?php
include("public/header.php");
require_once("inventory_class.php");

// Creating an inventory object of the InventoryManagement class, to use its method getStockOOP()
$inventory = new Inventory();

//The selected item from the dropdown
$selected_item = $_POST['selected_item'];
$new_stock = intval($_POST['stock']); //Ensuring it is an integer

//INvoking the function from $inventory_class.php to modify the stock and save to the json file
$inventory->changeStock($inventory, $selected_item, $new_stock);

?>

<h2>Edit Stock of <?php echo $selected_item ?></h2>

<p>The new Stock of <?php
echo $selected_item . " is <b>" . $inventory->getStockOOP($selected_item, $inventory) . "</b>";
?> 
</p>

<?php
# this adds the html footer to this php file
include("public/footer.php");
?>