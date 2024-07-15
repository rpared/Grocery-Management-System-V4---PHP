<?php

include("public/header.php");

$customerName = '';
$orderId = '';
$errorMessage = ''; // Initialize error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $customerName = trim($_POST['customer_name']);
  $orderId = trim($_POST['order_id']);

  // Simple validation 
  if (strlen($customerName) < 3) {
    $errorMessage = 'Customer name must be at least 3 characters long.';
  }

  // Order ID validation with regular expression
  $orderIdRegex = '/^[0-9]{4}$/';
  if (!preg_match($orderIdRegex, $orderId)) {
    $errorMessage = 'Invalid Order ID. Please enter 4 digits.';
  }

  // Redirect to order_process.php if no errors, sending the params
  if (empty($errorMessage)) {
    header("Location: order_processOOP.php?customer_name=" . urlencode($customerName) . "&order_id=" . urlencode($orderId));
    exit; // Stop further script execution after redirect
  }
}

?>

<h2>Place Orders</h2>

<section class="order-forms">
  <form class="place_order" action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">

    <label for="customer_name">Customer Name:</label>
    <input type="text" id="customer_name" name="customer_name" required <?php if (!empty($errorMessage)) echo 'class="error"'; ?>>

    <label for="order_id">Order Id:</label>
    <input type="text" id="order_id" name="order_id" required <?php if (!empty($errorMessage)) echo 'class="error"'; ?>>

    <button type="submit" value="submit">Continue</button>
    <p></p>
    <?php if (!empty($errorMessage)) : ?>
      <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
  </form>


</section>

<?php
include("public/footer.php");
?>
