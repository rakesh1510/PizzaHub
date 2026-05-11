# PizzaHaus (PHP + MySQL)

Pizza restaurant ordering system for online and offline orders.

## Features implemented
- Homepage, menu, pizza details, categories, size/crust/topping selection
- Cart add/update/remove
- Checkout with delivery/pickup and payment methods (Stripe/COD/Pay at restaurant)
- Order success + customer order lookup page
- Admin panel: dashboard, categories, products, toppings, offline orders, order status/payment updates, printing

## Setup
1. Create a MySQL database and import `database.sql`.
2. Update DB credentials and Stripe keys in `config/config.php`.
3. Serve the project root and open `/public`.

## Admin login
- URL: `/public/admin/login.php`
- Email: `admin@pizzahaus.local`
- Password: `admin123`

## Stripe integration
This code **does not collect card numbers in PHP forms**.
To enable real card payments:
1. Install Stripe SDK: `composer require stripe/stripe-php`
2. In `public/checkout.php`, create Stripe Checkout session when `payment_method=stripe`
3. Add a webhook endpoint to mark payment/order as paid after successful checkout
