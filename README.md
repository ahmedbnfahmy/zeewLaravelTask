<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>
# Laravel Order Management System

A simple RESTful API for managing customers and orders built with Laravel.

## Setup Instructions

1. Clone the repository:
   ```bash
   git clone git@github.com:ahmedbnfahmy/zeewLaravelTask.git
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Copy environment file:
   ```bash
   cp .env.example .env
   ```

4. Configure your database in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations:
   ```bash
   php artisan migrate
   ```

7. Start the server:
   ```bash
   php artisan serve
   ```

## API Endpoints

### Customers

- `GET /api/customers` - List all customers
- `GET /api/customers?name=value` - Filter customers by name
- `GET /api/customers?email=value` - Filter customers by email
- `GET /api/customers?with_orders=1` - Include orders in response
- `GET /api/customers/{id}` - Get customer details with orders
- `POST /api/customers` - Create a new customer
- `PUT /api/customers/{id}` - Update a customer
- `DELETE /api/customers/{id}` - Delete a customer
- `GET /api/customers/stats` - Get customer statistics

### Orders

- `GET /api/orders` - List all orders
- `GET /api/orders?status=shipped` - Filter orders by status
- `GET /api/orders?customer_id=value` - Filter orders by customer
- `GET /api/orders?min_price=value` - Filter orders by minimum price
- `GET /api/orders?max_price=value` - Filter orders by maximum price
- `POST /api/orders` - Create a new order
- `PUT /api/orders/{id}` - Update order status
- `GET /api/orders/stats` - Get order statistics

## Example Requests

### Create a Customer

```bash
curl -X POST http://127.0.0.1:8000/api/customers \
  -H "Content-Type: application/json" \
  -d '{"name":"John Doe","email":"john@example.com"}'
```

### Create an Order

```bash
curl -X POST http://127.0.0.1:8000/api/orders \
  -H "Content-Type: application/json" \
  -d '{"customer_id":1,"product_name":"Smartphone","quantity":2,"price":599.99}'
```

## Models

### Customer
- id
- name
- email
- timestamps

### Order
- id
- customer_id
- product_name
- quantity
- price
- status (pending/shipped)
- timestamps
