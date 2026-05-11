# PizzaHaus — Premium PHP + MySQL Pizza Ordering System

PizzaHaus is a complete restaurant ordering platform with a modern customer site and admin management panel.

## Core stack
- PHP (PDO)
- MySQL
- HTML/CSS/JavaScript
- Stripe Checkout flow placeholder (no custom card fields)

## Customer pages
- Home
- About
- Menu
- Pizza Detail
- Cart
- Checkout
- Order Success
- My Orders
- Contact
- Login / Register

## Admin pages
- Admin Login
- Dashboard
- Products / Pizzas
- Categories
- Toppings
- Orders (online/offline)
- Offline Order Creation
- Kitchen Ticket / Customer Receipt printing

## Setup
1. Import `database.sql` into MySQL.
2. Update database credentials in `config/config.php`.
3. Serve the project and open `/public`.

## Notes
- Uses prepared statements across data access.
- Supports delivery and pickup.
- Supports payment methods: Stripe Checkout, cash on delivery, pay at restaurant.
