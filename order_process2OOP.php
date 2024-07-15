<?php
include("./public/header.php");

require_once("inventory_class.php");

$inventory = new Inventory();
$inventory_details = $inventory->getItemDetails();


$customer_name = $_POST['customer_name'];
$order_id = $_POST['order_id'];
$subtotal = $_POST['subtotal'];
$net_total = $_POST['net_total'];
$order_items = json_decode($_POST['order_items'],true);

// Pushing the order id and customer into the $order_details array
$order_details = [
    "order_id" => $order_id,
    "customer_name" => $customer_name,
    "subtotal" => $subtotal,
    "net_total" => $net_total,
  ];
  
  // Merge order details with cart data (ensuring order details come first to identify each object)
  $new_order = array_merge($order_details, $order_items);


// Path to the JSON file
$jsonOrdersFilePath = './orders/orders.json';
// Read the existing JSON data
$jsonOrdersPrevData = file_get_contents($jsonOrdersFilePath);
// Decode the JSON data into a PHP array
$ordersArray = json_decode($jsonOrdersPrevData, true);

// Push the new Orderarray into the existing data array
// var_dump($ordersArray);
array_push($ordersArray['orders'], $new_order);


// var_dump($ordersArray);
// This function adds the order to the orders.json file
$inventory->update_json ($jsonOrdersFilePath, $ordersArray);

// var_dump($order_items);
// var_dump("----------------------");
// var_dump($inventory_details);
// var_dump("----------------------");

// Here I should invoke a function to remove items from the inventory class instead of this block!!!
// Finally works though yeeeeiii!!!!
foreach ($order_items as $order_item) {
  $quantity = (int) $order_item["quantity"]; 
  $item_name = $order_item["name"];
  
  $item_found = false;
  foreach ($inventory_details["items"] as &$item) {
      if ($item["Name"] === $item_name) {
          $item_found = true;
          $current_stock = $item["Stock"];
          
          // Validate sufficient stock
          if ($current_stock !== null && $current_stock >= $quantity) {
              $new_stock = $current_stock - $quantity;
              $inventory->changeStock($inventory, $item_name, $new_stock); // Call inventory method
              $item["Stock"] = $new_stock; // Update the inventory array with new stock value
          } else {
              // Insufficient stock scenario
              echo "Insufficient stock for " . $item_name . ". Order cannot be processed.";
          }
          break;
      }
  }
  
  if (!$item_found) {
      // Missing item in inventory
      echo "Item " . $item_name . " not found in inventory.";
  }
}




?>

<h2>Place Orders</h2>
<p>
<?php
echo "<h3>". $customer_name ."'s order (Id: " . $order_id.") has been placed.</h3> <br>";
echo "The order has been stored in a Json File orders.json with Object oriented refactoring <br>
The ordered items (if there was sufficient stock) have also been removed from the inventory json file 😁😁😁";
?>

<?php
# this adds the html footer to this php file
include("public/footer.php");
?>