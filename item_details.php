<?php
include("public/header.php");
require_once 'repository_class.php';

// Initialize repository
$repository = new Repository();

// Fetch items
# This function creates an HTML table with key-value pairs from the Associative array $obtained from the Repository fetchItems(), Yeiii its working!!!
function create_table($data){
  echo '<h2>Item Details</h2>';
  if (isset($data)){
    $table_html = "<table>";
    # To add 6 column headers
    $table_html .= "<tr><th>Id</th><th>Name</th><th>Category</th><th>Unit Price</th><th>Expiry Date</th><th>Stock</th></tr>";
      
      // Loop through each item in the data array
      foreach ($data as $product) {
        $table_html .= "<tr>"; // Add a row to the table
        $table_html .= "<td>" . $product["item_id"] . "</td>"; // Display ID
        $table_html .= "<td>" . $product["item_name"] . "</td>"; // Display Name
        $table_html .= "<td>" . $product["item_category"] . "</td>"; // Display Category
        $table_html .= "<td>" . $product["item_price"] . "</td>"; // Display Price
        $table_html .= "<td>" . $product["item_expiry_date"] . "</td>"; // Display Expiry Date
        $table_html .= "<td>" . $product["item_stock"] . "</td>"; // Displaying Stock
        $table_html .= "</tr>"; // Closing the row
      }

      $table_html .= "</table>"; // Close the table tag
      return $table_html; // Return the completed table HTML

  }else{
    echo "There are no items. Add New Items to get a detailed list of them.<br><br>".
    "<button><a href='add_items.php'> Add New Items </a></button>";
  }
}
//The param is a functin othat returns an assoicative array
$table_detailed_list = create_table($repository->fetchItems());
 echo $table_detailed_list;


include("public/footer.php");
?>


<!-- // The OLD Code before having a Database and a repository:
 This grants access to the functions from the Inventory Class 
require_once("inventory_class.php");
# this adds the html head to this php file, so the code doest have to be repeated each time
include("public/header.php");

$inventory = new Inventory();
    

# This function creates an HTML table with key-value pairs from the Associative array $item_details, Yeiii its working!!!
function create_table($data){
  echo '<h2>Item Details</h2>';
  if (isset($data)){
    $table_html = "<table>";
    # To add 6 column headers
    $table_html .= "<tr><th>Id</th><th>Name</th><th>Category</th><th>Unit Price</th><th>Expiry Date</th><th>Stock</th></tr>";
      
      // Loop through each item in the data array
      foreach ($data["items"] as $product) {
        $table_html .= "<tr>"; // Add a row to the table
        $table_html .= "<td>" . $product["Id"] . "</td>"; // Display ID
        $table_html .= "<td>" . $product["Name"] . "</td>"; // Display Name
        $table_html .= "<td>" . $product["Category"] . "</td>"; // Display Category
        $table_html .= "<td>" . $product["Unit Price"] . "</td>"; // Display Price
        $table_html .= "<td>" . $product["Expiry Date"] . "</td>"; // Display Expiry Date
        $table_html .= "<td>" . $product["Stock"] . "</td>"; // Displaying Stock
        $table_html .= "</tr>"; // Closing the row
      }

      $table_html .= "</table>"; // Close the table tag
      return $table_html; // Return the completed table HTML

  }else{
    echo "There are no items. Add New Items to get a detailed list of them.<br><br>".
    "<button><a href='add_items.php'> Add New Items </a></button>";
  }
}
//The param is a functin othat returns an assoicative array
$table_detailed_list = create_table($inventory->getItemDetails());
 echo $table_detailed_list;

 include("public/footer.php");
?> -->
