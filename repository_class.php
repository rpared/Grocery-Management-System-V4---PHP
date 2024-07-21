<?php
require_once 'database_connection_class.php';
require_once 'product_class.php';

//This repository connects to the database automatically and has functions to fetch all items from the 3 tables 
class Repository {
    private $db;

    public function __construct() {
        $database = new Database_connection();
        $this->db = $database->getConnection();
    }

    // Fetch all items
    public function fetchItems() {
        $query = 'SELECT * FROM items';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $results;
    }
    // Fetch all oreders
    public function fetchOrders() {
        $query = 'SELECT * FROM orders';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $results;
    }

    // Fetch all oreders with items
    public function fetchOrdersWithItems() {
        $query = 'SELECT o.order_id, o.customer_name, o.order_date, o.sub_total, 
        o.net_total, oi.item_id, oi.item_name, oi.item_quantity
        FROM orders o  JOIN order_items oi ON o.order_id = oi.order_id';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $results;
    }



    // Fetch all item names (just the column!!)
    public function getItemNames() {
        $query = 'SELECT item_name FROM items';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_COLUMN);
        $statement->closeCursor();
        return $results;
    }

    // Fetch the item stock
    public function getItemStock($selected_item) {
        $query = 'SELECT item_stock FROM items WHERE item_name = ?';
        $statement = $this->db->prepare($query);
        $statement->bindValue(1, $selected_item);        
        $statement->execute();
        $results = $statement->fetch(PDO::FETCH_COLUMN);
        $statement->closeCursor();
        return $results;
    }    

 // Change the item stock
    public function changeItemStock($new_stock, $selected_item) {
        $query = 'UPDATE items SET item_stock = ? WHERE item_name = ?';
        $statement = $this->db->prepare($query);
        $statement->bindValue(1, $new_stock);   
        $statement->bindValue(2, $selected_item);    
        $statement->execute();
        $statement->closeCursor();
        return true;
    }    



 // Fetch order items by order ID
 public function fetchOrderItems($orderId) {
    $query = 'SELECT * FROM order_items WHERE order_id = :order_id';
    $statement = $this->db->prepare($query);
    $statement->bindValue(':order_id', $orderId);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $results;
}

// Add a new item

public function addItem(Product $item) {
    try {
        $query = 'INSERT INTO items (item_id, item_name, item_category, item_brand, item_price, item_expiry_date, item_stock) 
                  VALUES (:id, :name, :category, :brand, :price, :expiry_date, :stock)';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $item->getId());
        $statement->bindValue(':name', $item->getName());
        $statement->bindValue(':category', $item->getCategory());
        $statement->bindValue(':brand', $item->getBrand());
        $statement->bindValue(':price', $item->getPrice());
        $statement->bindValue(':expiry_date', $item->getExpiryDate());
        $statement->bindValue(':stock', $item->getStock());
        $statement->execute();
        $statement->closeCursor();
        echo "<b> Successful Product Addition (verify vissualy it is vegan!)😁 </b><br>";
    } catch (PDOException $e) {
        throw new Exception("Error adding item: " . $e->getMessage());
    }
}



// Add a new order
public function addOrder($customerName, $orderDate, $subTotal, $netTotal) {
    $query = 'INSERT INTO orders (customer_name, order_date, sub_total, net_total) VALUES (:customer_name, :order_date, :sub_total, :net_total)';
    $statement = $this->db->prepare($query);
    $statement->bindValue(':customer_name', $customerName);
    $statement->bindValue(':order_date', $orderDate);
    $statement->bindValue(':sub_total', $subTotal);
    $statement->bindValue(':net_total', $netTotal);
    $statement->execute();
    $orderId = $this->db->lastInsertId();
    $statement->closeCursor();
    return $orderId;
}

// Add a new order item
public function addOrderItem($orderId, $itemId, $itemName, $itemQuantity) {
    $query = 'INSERT INTO order_items (order_id, item_id, item_name, item_quantity) VALUES (:order_id, :item_id, :item_name, :item_quantity)';
    $statement = $this->db->prepare($query);
    $statement->bindValue(':order_id', $orderId);
    $statement->bindValue(':item_id', $itemId);
    $statement->bindValue(':item_name', $itemName);
    $statement->bindValue(':item_quantity', $itemQuantity);
    $statement->execute();
    $statement->closeCursor();
}
}

?>
