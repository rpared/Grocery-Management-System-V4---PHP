<?php
// include("./database/database_functions.php");
include("./public/header.php");

require_once("inventory_class.php");
require_once("order_class.php");
require_once("cart_class.php");

$inventory = new Inventory();
$inventory_details = $inventory->getItemDetails();
//var_dump($inventory);


// Decode the URL-encoded values for safe usage, Im not using this!
// $customerName = urldecode($customerName);
// $orderId = urldecode($orderId)

//This file branches here according to the process: Step 1 and Step2
//Getting $order_items = $_POST['order_items'] after the Review button is pressed and a hidden form sends array data
//If items are just being added, this is the 1st STEP:
if (empty($_POST['order_items'])) {

  $customer_name = $_GET['customer_name'];
  $order_id = $_GET['order_id'];

    ?>

    <h2>Place Orders</h2>
    <p>
    <?php
    echo "<h3>Customer name: ". $customer_name ." /  Order Id: " . $order_id."</h3>";
    ?>
    </p>
    <section class="order-forms">

      <!-- div class="place_order" is used instead of a Form, it will not send an http request, it will be handled with Ajax to 
      rtrieve the item stock and to populate the right column with the selected items. This way
      there wont be 2 extra screens in the process-->
    <div class="place_order" >

      <h3>Item Selection:</h3>
      <p></p>

      <label for="search-select">Select Item:</label>
      <input type="search" id="search-select" name="search-select" list="options" placeholder="Start typing and select">
        <datalist id="options">
          <!-- To display options -->
          <?php $inventory->itemDatalist();?>
        <!-- <?//php itemDatalist($item_details);?>//previous way -->
            <!-- Populates options in this format:
            <option value="Option 1">
            <option value="Option 2">
            <option value="Option 3"> -->
        </datalist>
      <!-- <button id="selectBtn" type="submit">Select</button> -->

        <div id="search-results-label" class="search-results">
        </div>
        <div id="search-results"class="search-results">
        </div>
        <label for="quantity">Quantity:</label>
        <input style="width: 20%;" type="text" id="quantity" name="quantity" min="1" required>
        <button id="add-to-cart">Add to Cart</button>


    </div>

      <form class="process_order" action="order_processOOP.php" method="POST">
      <h3>In the Cart:</h3>

      <!-- //These are hidden to be passed to the next step -->

      <input type="hidden" name="customer_name" value="
      <?php echo $customer_name;?>">
      <input type="hidden" name="order_id" value="<?php echo $order_id;?>">
      <!-- //This value order_items holds the array with the the items selected -->
      <input type="hidden" name="order_items" id="order_items">

      <div id="order-details">

      </div>
      <button type="submit" value="submit">Review Order</button>
      </form>

      </section>


      
    <?php


    //2nd STEP

    // The if case there were items added to cart meaning there is an $order_items array:
} else {


// order_items hidden input was populated with a Javascript array decoded:

$order_items = $_POST['order_items'];
// $order_items will be decoded (stringified) to be displayed in the screen then recoded to be sent to the next step when the order is confirmed

$order_items = json_decode($_POST['order_items'], true);

// $order_items_enconded will store order_items and be sent to the next php file
$order_items_enconded = json_encode($order_items, true);

$customer_name = $_POST['customer_name'];
$order_id = $_POST['order_id'];
$create_date = new DateTime();
// Creating the new order Object
$new_order = new Order($create_date, $order_id, $customer_name);


$cart = $new_order->createCart($order_items);
// var_dump($inventory_details);
// order_items hidden input was populated with a Javascript array decoded:


//This replaces the prev returnPrice function:
//$cart->returnPrice($inventory, $order_items);

//This replavces the prev netTotal functin:
//netTotal($inventory_details, $order_items


define('TAX', 0.13);
// var_dump($order_items);

//Function to create an array with the order, later this array will be pushed into a Json file called orders
// THis is no longer needed, it is done afterwards
$newOrder = array();
function createOrderArray($order_id, $customer_name, $order_items){
 $newOrder = [$order_id, $customer_name, $order_items];
 return $newOrder;
};
createOrderArray($order_id, $customer_name, $order_items);



echo "<h3>Your Order:</h3><br> 
<p>Customer name: <b>" . $customer_name ."</b></p>  <p> Order Id: <b>" . $order_id."</b></p> <br/>";
echo "<table>
  <thead>
    <tr>
      <th>Item</th>
      <th>Quantity</th>
      <th>Unit Price</th> 
      <th>Total Price</th>  </tr>
  </thead>
  <tbody>";  // to display data in table rows
foreach ($order_items as $item) {
  echo "<tr>
    <td>" . $item['name'] . "</td>
    <td>" . $item['quantity'] . "</td>
    <td> $" . $cart->returnPrice($inventory_details, $order_items) . "</td>
    <td> $" . $cart->returnPrice($inventory_details, $order_items) * $item['quantity'] . "</td>  </tr>";
}

echo "</tbody>
<tr>
<td></td>
<td></td>
<td><b>Net Total: </b></td>
<td> <b>$" . $cart->netTotal($inventory_details, $order_items) . "</b></td></tr>
<tr>
<td></td>
<td></td>
<td><b>Tax:</b></td>
<td> <b>$" . $cart->netTotal($inventory_details, $order_items) * TAX . "</b></td></tr>
<tr>
<td></td>
<td></td>
<td><b>Total: </b></td>
<td> <b>$" . $cart->netTotal($inventory_details, $order_items) + $cart->netTotal($inventory_details, $order_items) * TAX . "</b></td></table>";

echo"
<br>
<form class='place_order' action='order_process2OOP.php' method='POST'>

<!-- //This are all hidden to be passed to the next file -->
<input type='hidden' name='customer_name' value='".
   $customer_name . "'>
  <input type='hidden' name='order_id' value='". $order_id . "'>
  <input type='hidden' name='subtotal' value='". $cart->netTotal($inventory_details, $order_items) . "'>
  <input type='hidden' name='net_total' value='". $cart->netTotal($inventory_details, $order_items) + $cart->netTotal($inventory_details, $order_items) * TAX . "'>

<input type='hidden' name='order_items' value='". $order_items_enconded ."'>
<p></p>
<button type='submit' value='submit'>Place Order</button>
           
</form>
";

}
?>


<?php
# this adds the html footer to this php file
include("public/footer.php");
?>