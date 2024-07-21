<?php
require_once("inventory_class.php");
require_once("cart_class.php");
require_once("repository_class.php");


class Order{
  private $repository;

  public $order_id;
  public $customer_name;
  public $create_date;


  public function __construct($create_date = null, $order_id = null, $customer_name = null) {
    // Initialize repository
    $this->repository = new Repository();

    // Set properties if provided
    if ($create_date !== null) {
      $this->create_date = $create_date;
    }

    if ($order_id !== null) {
      $this->order_id = $order_id;
    }

    if ($customer_name !== null) {
      $this->customer_name = $customer_name;
    }
  }

//Fetch oder data
  public function getOrdersOOP() {
    $ordersArray = $this->repository->fetchOrders();
    
    echo "<table border='1'>";
    echo "<tr style='background-color:#ebd6bb; padding-top: 6px;'>";
    echo "<th>order_id</th><th>customer_name</th><th>subtotal</th><th>net_total</th></tr>";

    foreach ($ordersArray as $order) {
        $order_id = $order['order_id'];
        $customer_name = $order['customer_name'];
        $subtotal = $order['sub_total'];
        $net_total = $order['net_total'];

        // Display order details
        echo "<tr><td>{$order_id}</td><td>{$customer_name}</td><td>{$subtotal}</td><td>{$net_total}</td></tr>";
    }
    
    echo "</table>";
}

//Fetch oder data with items
public function getOrdersWithItemsOOP() {
  $orderDetails = $this->repository->fetchOrdersWithItems();
  
  echo "<table>";
  echo "<tr>
          <th>Order ID</th>
          <th>Customer Name</th>
          <th>Order Date</th>
          <th>Subtotal</th>
          <th>Net Total</th>
          <th>Item ID</th>
          <th>Item Name</th>
          <th>Item Quantity</th>
        </tr>";

  foreach ($orderDetails as $detail) {
      $order_id = $detail['order_id'];
      $customer_name = $detail['customer_name'];
      $order_date = $detail['order_date'];
      $sub_total = $detail['sub_total'];
      $net_total = $detail['net_total'];
      $item_id = $detail['item_id'];
      $item_name = $detail['item_name'];
      $item_quantity = $detail['item_quantity'];

      echo "<tr style='background-color:#ebd6bb; padding-top: 6px;'>";
      echo "<td>{$order_id}</td>";
      echo "<td>{$customer_name}</td>";
      echo "<td>{$order_date}</td>";
      echo "<td>{$sub_total}</td>";
      echo "<td>{$net_total}</td>";
      echo "<td>{$item_id}</td>";
      echo "<td>{$item_name}</td>";
      echo "<td>{$item_quantity}</td>";
      echo "</tr>";
  }

  echo "</table>";
}


public function createCart($order_items){
// A Cart object must be created here
$cart = new Cart($order_items);
return $cart;
}

// Function to display orders in a table format from JSON file
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