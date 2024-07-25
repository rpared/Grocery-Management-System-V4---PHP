CREATE SCHEMA `db_vegan_heaven` ;

show databases;
DROP TABLE db_vegan_heaven.order_items;
DROP TABLE db_vegan_heaven.items;
DROP TABLE db_vegan_heaven.orders;

CREATE TABLE `db_vegan_heaven`.`items` (
	`item_id` VARCHAR(5) PRIMARY KEY,
    `item_name` VARCHAR(45) NOT NULL UNIQUE,
    `item_category` VARCHAR(45),
    `item_brand` VARCHAR(45),
    `item_price` DECIMAL(10, 2),
    `item_expiry_date` DATE,
    `item_stock` INT
) ENGINE=InnoDB;


CREATE TABLE `db_vegan_heaven`.`orders` (
    `order_id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_name` VARCHAR(45),
    `order_date` DATE,
    `sub_total` DOUBLE,
    `net_total` DOUBLE
) ENGINE=InnoDB;


CREATE TABLE `db_vegan_heaven`.`order_items` (
    `order_item_id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT,
    `item_id` VARCHAR(5),
    `item_name` VARCHAR(45),
    `item_quantity` INT,
    FOREIGN KEY (`order_id`) REFERENCES `db_vegan_heaven`.`orders`(`order_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`item_id`) REFERENCES `db_vegan_heaven`.`items`(`item_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`item_name`) REFERENCES `db_vegan_heaven`.`items`(`item_name`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB;



INSERT INTO `db_vegan_heaven`.`items` (`item_id`, `item_name`, `item_category`, `item_brand`, `item_price`, `item_expiry_date`, `item_stock`)
VALUES 
    ('001', 'Chocolate Cookies', 'Snacks', 'Made Good', 8.99, '2024-12-31', 100),
    ('002', 'Almond Milk', 'Plant-based Milk', 'Happy Cow', 3.49, '2024-07-15', 20);
    
SELECT item_id AS Id, item_name AS Name, item_category AS Category, item_brand AS Brand, item_price AS Unit_price,
    DATE_FORMAT(item_expiry_date, "%Y-%m-%d") AS "Expiry_date", item_stock AS Stock FROM items;

SELECT * FROM items;

-- Inserting sample orders into the orders table
INSERT INTO `db_vegan_heaven`.`orders` (`customer_name`, `order_date`, `sub_total`, `net_total`)
VALUES
('Alice Johnson', '2024-07-20', 25.50, 25.50),
('Bob Smith', '2024-07-20', 45.75, 45.75);

SELECT * FROM orders;

-- Inserting sample order items into the order_items table
-- For order_id = 1 (Alice Johnson's order)
INSERT INTO `db_vegan_heaven`.`order_items` (`order_id`, `item_id`, `item_name`, `item_quantity`)
VALUES
(1, '001', 'Chocolate Cookies', 2),
(1, '002', 'Almond Milk', 1);

-- For order_id = 2 (Bob Smith's order)
INSERT INTO `db_vegan_heaven`.`order_items` (`order_id`, `item_id`, `item_name`, `item_quantity`)
VALUES
(2, '001', 'Chocolate Cookies', 1),
(2, '002', 'Almond Milk', 3);

SELECT * FROM order_items;


