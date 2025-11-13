-- Create a new database
CREATE DATABASE `hospital_pharmacy`;

-- Select the new database to use it
USE `hospital_pharmacy`;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--
CREATE TABLE `medicines` (
  `medicine_id` int(11) NOT NULL AUTO_INCREMENT,
  `medicine_name` varchar(255) NOT NULL,
  `packing` varchar(50) DEFAULT NULL,
  `generic_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `cost_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`medicine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping sample data for table `medicines`
--
INSERT INTO `medicines` (`medicine_name`, `packing`, `generic_name`, `price`, `stock_quantity`, `cost_price`) VALUES
('Paracetamol 500mg', '10pc', 'Paracetamol', 15.00, 200, 10.00),
('Dolo 650', '15pc', 'Paracetamol', 30.00, 150, 22.00),
('Vicks Action 500', '10pc', 'Paracetamol, Phenylephrine, Caffeine', 25.00, 95, 18.50);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--
CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping sample data for table `suppliers`
--
INSERT INTO `suppliers` (`supplier_name`, `contact_person`, `phone`, `email`) VALUES
('Kollam Pharma Distributors', 'Suresh Kumar', '9847012345', 'suresh.k@kollampharma.com'),
('Global Med Supplies', 'Anitha Varma', '9995554321', 'contact@globalmed.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL COMMENT 'e.g., Admin, Pharmacist',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping sample data for table `users`
-- Note: In a real app, passwords must be hashed!
--
INSERT INTO `users` (`full_name`, `username`, `password`, `role`) VALUES
('Admin User', 'admin', 'admin123', 'Admin'),
('Renjith R', 'renjith123', 'pass123', 'Pharmacist');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
-- This table holds one record for each completed bill/invoice.
--
CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) DEFAULT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `change_due` decimal(10,2) NOT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
-- This table holds a record for each medicine line item in a sale.
-- It links the `sales` and `medicines` tables.
--
CREATE TABLE `sale_items` (
  `sale_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`sale_item_id`),
  KEY `sale_id` (`sale_id`),
  KEY `medicine_id` (`medicine_id`),
  CONSTRAINT `fk_sale_items_medicine` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`medicine_id`),
  CONSTRAINT `fk_sale_items_sale` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;