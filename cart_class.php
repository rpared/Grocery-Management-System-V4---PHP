<?php
require_once("inventory_class.php");
require_once("order_class.php");


class Cart {

  // cart_items is an array that will be popullated with items, each one being an associative array ok name and quantity
  public $order_items = [];
  private $inventory_details;
  

  public function __construct($order_items) {
    $this->order_items = $order_items;
    $inventory = new Inventory();
    $inventory_details = $inventory->getItemDetails();
    $this->inventory_details = $inventory_details;
  }

  // Function to add an item to the cart NOT using this!!
  public function addItem($item, $quantity) {
    // Here I select items and push them with quantity to the cart_items array
    // new_cart_item = new CartItem();
    $this->$order_items[] = $item;
  }


  // Function with a nested for loop to echo the unit price, this was troublesome
public function returnPrice($inventory_details, $order_items){
  foreach ($inventory_details["items"] as $product){
      foreach ($order_items as $item){
        if ($product["Name"] == $item["name"]){
          return $product["Unit Price"];
        }
      }
  }
}


  //Function to calculate the net total:
function netTotal($inventory_details, $order_items){
  $netTotal = 0;
foreach ($order_items as $item) {
  $price = $this->returnPrice($inventory_details, $order_items) * $item['quantity'];
  $netTotal += $price;
}
return $netTotal;
}


  // Function to remove an item from the cart, should implement it but have to solve the rest first!
  public function removeItem($item) {
    $updatedCart = []; // array to replace the cart
    foreach ($this->order_items as $cartItem) {
      if ($cartItem['id'] !== $itemId) {
        $updatedCart[] = $cartItem;
      }
    }
    $this->order_items = $updatedCart;
  }



  // Function to calculate the total price including tax
  public function calculateTotal() {
    define('TAX', 0.13);
    $subTotal = $this->calculateSubTotal();
    $total = $subTotal + ($subTotal * $this->TAX);
    return $roundTotal = number_format($total, 2, '.', ''); // Format total to two decimal places
  }
}

?>
