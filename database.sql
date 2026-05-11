CREATE DATABASE IF NOT EXISTS pizzahaus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pizzahaus;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(120) UNIQUE,
  phone VARCHAR(30),
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL UNIQUE,
  slug VARCHAR(80) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  slug VARCHAR(150) NOT NULL UNIQUE,
  description TEXT,
  base_price DECIMAL(10,2) NOT NULL DEFAULT 0,
  image_url VARCHAR(255),
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE product_sizes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  size_name ENUM('Small','Medium','Large','Family') NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE toppings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  extra_price DECIMAL(10,2) NOT NULL DEFAULT 0,
  is_active TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  session_id VARCHAR(100) NOT NULL,
  product_id INT NOT NULL,
  size_name ENUM('Small','Medium','Large','Family') NOT NULL,
  crust ENUM('Thin','Classic','Cheese crust') NOT NULL,
  qty INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE cart_toppings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cart_id INT NOT NULL,
  topping_id INT NOT NULL,
  extra_price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE CASCADE,
  FOREIGN KEY (topping_id) REFERENCES toppings(id)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_number VARCHAR(30) NOT NULL UNIQUE,
  user_id INT NULL,
  customer_name VARCHAR(120) NOT NULL,
  customer_email VARCHAR(120),
  customer_phone VARCHAR(30) NOT NULL,
  customer_address TEXT,
  fulfillment_type ENUM('delivery','pickup') NOT NULL,
  order_source ENUM('online','phone','walkin') NOT NULL DEFAULT 'online',
  status ENUM('pending','preparing','ready','out_for_delivery','delivered','cancelled') DEFAULT 'pending',
  payment_status ENUM('unpaid','paid','refunded') DEFAULT 'unpaid',
  payment_method ENUM('stripe','cod','pay_at_restaurant') NOT NULL,
  subtotal DECIMAL(10,2) NOT NULL DEFAULT 0,
  delivery_fee DECIMAL(10,2) NOT NULL DEFAULT 0,
  total DECIMAL(10,2) NOT NULL DEFAULT 0,
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  product_name VARCHAR(150) NOT NULL,
  size_name ENUM('Small','Medium','Large','Family') NOT NULL,
  crust ENUM('Thin','Classic','Cheese crust') NOT NULL,
  qty INT NOT NULL,
  unit_price DECIMAL(10,2) NOT NULL,
  line_total DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

CREATE TABLE order_item_toppings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_item_id INT NOT NULL,
  topping_name VARCHAR(120) NOT NULL,
  extra_price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_item_id) REFERENCES order_items(id) ON DELETE CASCADE
);

CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  provider ENUM('stripe','cash') NOT NULL,
  provider_ref VARCHAR(190),
  amount DECIMAL(10,2) NOT NULL,
  currency VARCHAR(8) DEFAULT 'usd',
  status ENUM('pending','paid','refunded','failed') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

INSERT INTO categories (name,slug) VALUES
('Classic','classic'),('Vegetarian','vegetarian'),('Spicy','spicy'),('Family','family'),('Drinks','drinks'),('Desserts','desserts');

INSERT INTO users (name,email,phone,password_hash,role) VALUES
('Admin','admin@pizzahaus.local','0000000000','$2y$10$Rr1uJJ3LlA7I4j8g56kS7uNZ3ghfQ3WyNxhVnVKhoJa0QmHIp7ONy','admin');
-- password: admin123


INSERT INTO products (category_id,name,slug,description,base_price,image_url,is_active) VALUES
(1,'Margherita','margherita','Tomato sauce, mozzarella, basil',8.99,NULL,1),
(1,'Pepperoni','pepperoni','Classic pepperoni and mozzarella',10.99,NULL,1),
(2,'Veggie Supreme','veggie-supreme','Bell peppers, onion, mushroom, olives',11.49,NULL,1),
(3,'Spicy Chicken','spicy-chicken','Chicken, jalapeno, chili flakes',12.49,NULL,1),
(5,'Cola 500ml','cola-500ml','Cold soft drink',2.50,NULL,1),
(6,'Chocolate Lava Cake','chocolate-lava-cake','Warm chocolate dessert',4.99,NULL,1);

INSERT INTO product_sizes (product_id,size_name,price)
SELECT id,'Small',base_price FROM products WHERE slug IN ('margherita','pepperoni','veggie-supreme','spicy-chicken')
UNION ALL SELECT id,'Medium',base_price+2 FROM products WHERE slug IN ('margherita','pepperoni','veggie-supreme','spicy-chicken')
UNION ALL SELECT id,'Large',base_price+4 FROM products WHERE slug IN ('margherita','pepperoni','veggie-supreme','spicy-chicken')
UNION ALL SELECT id,'Family',base_price+7 FROM products WHERE slug IN ('margherita','pepperoni','veggie-supreme','spicy-chicken')
UNION ALL SELECT id,'Small',base_price FROM products WHERE slug IN ('cola-500ml','chocolate-lava-cake')
UNION ALL SELECT id,'Medium',base_price FROM products WHERE slug IN ('cola-500ml','chocolate-lava-cake')
UNION ALL SELECT id,'Large',base_price FROM products WHERE slug IN ('cola-500ml','chocolate-lava-cake')
UNION ALL SELECT id,'Family',base_price FROM products WHERE slug IN ('cola-500ml','chocolate-lava-cake');

INSERT INTO toppings(name,extra_price,is_active) VALUES
('Extra Cheese',1.50,1),('Mushrooms',1.00,1),('Olives',1.00,1),('Jalapenos',1.00,1),('Chicken',2.00,1);
