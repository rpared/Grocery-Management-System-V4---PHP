<?php
include("public/header.php");
require_once("inventory_class.php");
require_once 'repository_class.php';

$inventory = New Inventory();
$repository = new Repository();


$item_details = $repository->fetchItems();



//Getting the Current date
$current_date = new DateTime();  
//var_dump($current_date_obj);

//Calling the function  

$expired_list = $inventory->expiry_check($item_details);
// var_dump ($expired_list);
echo '<h2>Expiry Check</h2>';
echo "<p style='margin-left:16px; color: #90b332;'>Current Date: ". $current_date->format('Y-m-d')."</p>"; 
echo "<ul>";
  foreach ($expired_list as $expired_item) {
    echo "<li>$expired_item</li>";
  }
  echo "</ul>";
  if(count($expired_list) > 0){
  echo "There are <b>". count($expired_list). "</b> expired items, get rid of them before it gets nasty!";
}else{
  echo "There are no expired items 😁.";
}

  # this adds the html footer to this php file
include("public/footer.php");
?>