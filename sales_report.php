<?php
require_once("order_class.php");
include("public/header.php");


// Path to the JSON file
$jsonOrdersFilePath = './orders/orders.json';
// Read the existing JSON data
$jsonOrdersPrevData = file_get_contents($jsonOrdersFilePath);
// Decode the JSON data into a PHP array
$ordersArray = json_decode($jsonOrdersPrevData, true);
// var_dump($ordersArray);
$create_date = new DateTime();
$orders = new Order($create_date, "SalesReport", "Admin");

?>

<h2>Sales Report</h2>
<br>
<table>
  <thead>
    <tr>
      <th>Order ID</th>
      <th>Customer Name</th>
      <th>Item Name</th>
      <th>Quantity</th>
    </tr>
  </thead>
  <tbody>
    <?php
    
    $orders->displayOrders($ordersArray);
    
    ?>
  </tbody>
</table>
<?php
# this adds the html footer to this php file
include("public/footer.php");
?>