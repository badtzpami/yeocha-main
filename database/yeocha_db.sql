DROP TABLE sale;
DROP TABLE history;
DROP TABLE menu;
DROP TABLE inventory;
DROP TABLE material;
DROP TABLE product;
DROP TABLE category;
DROP TABLE loginhistory;
DROP TABLE users;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(225) NOT NULL,
  `firstname` varchar(225) NOT NULL,
  `lastname` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `phone` varchar(225) NOT NULL,
  `address` varchar(225) NOT NULL,
  `age` varchar(225) NOT NULL,
  `birthday` date NOT NULL,
  `start_date` date NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` varchar(225) NOT NULL COMMENT 'Admin, Cashier, Employee, Supplier',
  `about` varchar(225) NOT NULL,
  `image` varchar(225) NOT NULL,
  `signature` varchar(225) NOT NULL,
  `session_attempt` int(11) NOT NULL,
  `code` varchar(225) NOT NULL,
  `time` varchar(225) NOT NULL,
  `status` varchar(225) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `loginhistory` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date_created_at` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `category` (
  `ca_id` int(222) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(222) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  PRIMARY KEY (`ca_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `product` (
  `pr_id` int(222) NOT NULL AUTO_INCREMENT,
  `ca_id` int(11) NOT NULL,
  `product_name` varchar(222) NOT NULL,
  `category` varchar(222) NOT NULL,
  `material_cost` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(222) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  PRIMARY KEY (`pr_id`),
  FOREIGN KEY (`ca_id`) REFERENCES `category`(`ca_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `material` (
  `ma_id` int(222) NOT NULL AUTO_INCREMENT,
  `material_name` varchar(222) NOT NULL,
  `type` varchar(222) NOT NULL,
  `stock` int(222) NOT NULL,
  `enter_stock` int(222) NOT NULL,
  `unit` varchar(222) NOT NULL,
  `remarks` varchar(222) NOT NULL,
  `comment` varchar(222) NOT NULL,
  `image` varchar(222) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  PRIMARY KEY (`ma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `inventory` (
  `in_id` int(222) NOT NULL AUTO_INCREMENT,
  `ma_id` int(11) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  PRIMARY KEY (`in_id`),
  FOREIGN KEY (`ma_id`) REFERENCES `material`(`ma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `menu` (
  `me_id` int(222) NOT NULL AUTO_INCREMENT,
  -- `ca_id` int(11) NOT NULL,
  `pr_id` int(11) NOT NULL,
  `ma_id` int(11) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  PRIMARY KEY (`me_id`),
  -- FOREIGN KEY (`ca_id`) REFERENCES `category`(`ca_id`),
  FOREIGN KEY (`pr_id`) REFERENCES `product`(`pr_id`),
  FOREIGN KEY (`ma_id`) REFERENCES `material`(`ma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `history` (
  `ar_id` int(222) NOT NULL AUTO_INCREMENT,
  `material_name` varchar(222) NOT NULL,
  `type` varchar(222) NOT NULL,
  `stock` int(222) NOT NULL,
  `enter_stock` int(222) NOT NULL,
  `unit` varchar(222) NOT NULL,
  `remarks` varchar(222) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  PRIMARY KEY (`ar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `sale` (
  `sa_id` int(222) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `pr_id` int(222) NOT NULL,
  `sales_code` varchar(222) NOT NULL,
  `sell_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(222) NOT NULL,
  `total` int(222) NOT NULL,
  `full_name` varchar(222) NOT NULL,
  `id_number` varchar(222) NOT NULL,
  `address` varchar(222) NOT NULL,
  `created_by` int(222) NOT NULL,
  `updated_by` int(222) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



CREATE TABLE `supplier_material` (
  `sm_id` int(222) NOT NULL AUTO_INCREMENT,
  `material_name` varchar(222) NOT NULL,
  `type` varchar(222) NOT NULL,
  `stock` int(222) NOT NULL,
  `enter_stock` int(222) NOT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `unit` varchar(222) NOT NULL,
  `remarks` varchar(222) NOT NULL,
  `comment` varchar(222) NOT NULL,
  `image` varchar(222) NOT NULL,
  `user_id` int(222) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  PRIMARY KEY (`sm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


CREATE TABLE `supplier_history` (
  `sh_id` int(222) NOT NULL AUTO_INCREMENT,
  `material_name` varchar(222) NOT NULL,
  `type` varchar(222) NOT NULL,
  `stock` int(222) NOT NULL,
  `enter_stock` int(222) NOT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `unit` varchar(222) NOT NULL,
  `remarks` varchar(222) NOT NULL,
  `user_id` int(222) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  PRIMARY KEY (`sh_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

CREATE TABLE `cart` (
  `ct_id` int(222) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `sm_id` int(222) NOT NULL,
  `sell_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(222) NOT NULL,
  `total` int(222) NOT NULL,
  `user_id` int(222) NOT NULL,
  `date_created_at` datetime NOT NULL,
  `date_updated_at` datetime NOT NULL,
  FOREIGN KEY (`sm_id`) REFERENCES `supplier_material`(`sm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO `users` (`user_id`, `username`, `firstname`, `lastname`, `email`, `phone`, `address`, `birthday`, `password`, `role`, `image`, `signature`, `session_attempt`, `code`, `time`, `status`,  `date_created_at`, `date_updated_at`) VALUES
(1, 'Admin', 'Admin', 'Admin', '@gmail.com', '+639123456789', '9581 Narra Street', '1995-12-23', 'e64b78fc3bc91bcbc7dc232ba8ec59e0', 'Admin', '', '', 1, '', '', 'ACTIVE', '2024-10-10 15:47:26', ''),
(2, 'Cashier', 'Cashier', 'Cashier', 'cashier@gmail.com', '+639876543210', '4212 Pulo Street', '1994-03-16', '5725dbcc7254ee8422d1cb60db29625c', 'Cashier', '', '', 1, '0', '', 'ACTIVE', '2024-10-10 15:47:26', ''),
(3, 'Employee', 'Employee', 'Employee', 'employee@gmail.com', '+63924681012', '5245 Narra Street', '2004-04-12', '5725dbcc7254ee8422d1cb60db29625c', 'Employee', '', '', 1, '0', '2024-10-10 15:47:26', 'ACTIVE', '2024-10-10 15:47:26', ''),
(4, 'Supplier', 'Supplier', 'Supplier', 'supplier@gmail.com', '+639123456789', 'Supplier', '2001-06-03', '5725dbcc7254ee8422d1cb60db29625c', 'Admin', '', '', 1, '', '', 'ACTIVE', '2024-10-10 15:47:26', '');
