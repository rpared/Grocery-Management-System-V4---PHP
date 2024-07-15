<?php
require_once("inventory_class.php");
require_once("cart_class.php");

class Order{

  public $order_id;
  public $customer_name;
  public $create_date;


    public function __construct($create_date, $order_id, $customer_name ) {
        global $jsonFile;
        $this->order_id = $order_id;
        $this->customer_name = $customer_name;
      }


public function createCart($order_items){
// A Cart object must be created here
$cart = new Cart($order_items);
return $cart;
}

// Function to display orders in a table format
public function displayOrders($ordersArray) {
    // Iterate through the orders
    foreach ($ordersArray['orders'] as $order) {
        $order_id = $order['order_id'];
        $customer_name = $order['customer_name'];
        $subtotal = $order['subtotal'];
        $net_total = $order['net_total'];
    
        echo "<tr style='background-color:#ebd6bb; padding-top: 6px;'>";
        echo "<td>{$order_id}</td>";
        echo "<td>{$customer_name}</td><td>Item Name</td><td>Quantity</td></tr>";
        // Iterate through the items in each order in a nested loop
        foreach ($order as $key => $item) {
            if (is_array($item)) {
                $item_name = $item['name'];
                $quantity = $item['quantity'];
    
                // Display each item in a row
                echo "<tr>";
                echo "<td style='border:none;'></td>";
                echo "<td style='border:none;'></td>";
                echo "<td>{$item_name}</td>";
                echo "<td>{$quantity}</td>";
                echo "</tr>";
            }
        }
        echo "<tr><td>Subtotal:</td>";
        echo "<td>"."$"."{$subtotal}</td></tr>";
        echo "<tr><td>Net Total:</td>";
        echo "<td>"."$"."{$net_total}</td><td></td><td></td></tr>";
    
        }
      }

}