<?php

class Product {
  private $id;
  private $name;
  private $brand;
  private $category; // Category is more pro than type (musyt change)
  private $price;
  private $expiry_date; // Date of expiry
  private $stock; // Current stock quantity

  // Constructor to initialize product attributes
  public function __construct($id, $name, $brand, $category, $price, $expiry_date,$stock) {
    $this->id = $id;
    $this->name = $name;
    $this->brand = $brand;
    $this->category = $category;
    $this->price = $price;
    $this->expiry_date = $expiry_date;
    $this->stock = $stock;
  }

  // Acessors to product attributes
  public function getId() {
    return $this->id;
  }

  public function getName() {
    return $this->name;
  }

  public function getBrand() {
    return $this->brand;
  }

  public function getCategory() {
    return $this->category;
  }

  public function getPrice() {
    return $this->price;
  }

    public function getExpiryDate() {
      return $this->expiry_date;
    }
  
    public function getStock() {
      return $this->stock;
    }

  // Mutator methods to update product attributes


  public function setStock($stock) {
    $this->stock = $stock;
  }

  // Function to display product information (not in use)
  public function displayProductInfo() {
    echo "Product ID: " . $this->id . "\n";
    echo "Name: " . $this->name . "\n";
    echo "Brand: " . $this->brand . "\n";
    echo "Category: " . $this->category . "\n";
    echo "Unit Price: $" . $this->price . "\n";
    echo "Expiry Date: " . $this->expiry_date . "\n";
    echo "Stock: " . $this->stock . "\n";
  }
}

?>