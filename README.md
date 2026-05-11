# PizzaHaus - Premium Pizza Ordering System (PHP + MySQL)

Modern restaurant-style ordering platform with online and offline order management.

## Folder structure
- `config/` app config
- `includes/` shared header/footer
- `public/` customer pages
- `public/admin/` admin panel
- `public/auth/` login/register
- `public/assets/css/style.css` premium UI styling
- `database.sql` schema + seed data

## Implemented pages
- Home, About, Menu, Pizza Detail, Cart, Checkout, Order Success, My Orders, Contact, Login/Register
- Admin: Login, Dashboard, Products, Categories, Toppings, Orders, Offline Order Create, Print pages

## Setup
1. Import `database.sql` in MySQL.
2. Update DB config in `config/config.php`.
3. Run app and open `/public`.

## Payment notes
- Stripe Checkout should be used for card payment flow.
- No custom card fields are used in PHP forms.
