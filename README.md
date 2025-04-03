# ThriveCart :: Acme Basket System (CLI App)

A simple PHP 8.2 CLI app for managing a product basket with offers and delivery charges.
Built with SOLID principles, tested with PHPUnit, and Docker-ready for easy setup.

---

## Features

- Add products to a virtual basket via CLI
- Applies offer: **Buy 1 Red Widget (R01), get second at half price**
- Applies delivery charges:
  - Orders < $50 delivery charges would be $4.95
  - $50–< $90 delivery charges would be $2.95
  - $90+ would get free delivery
- Written using modern PHP 8.2 features
- Unit tested with PHPUnit

---

## Assumptions
- Products are identified by a fixed product code (e.g., R01, G01, B01).
- The only offer currently implemented is for Red Widget (R01): "Buy one, get the second at half price."
    - This applies to every pair in the basket.
    - The offer does not stack beyond what is described (e.g., buy two, get one free is not valid).
- Delivery charges are applied after all product offers have been applied.
- Delivery charge tiers are mutually exclusive and based strictly on the subtotal:
    - < $50 → $4.95
    - ≥ $50 and < $90 → $2.95
    - ≥ $90 → free delivery
- Product catalogue and delivery rules are injected at runtime (can be expanded in future).
- CLI usage is the primary interface; there's no web UI or API layer.
- Invalid product codes will not crash the application but will print a warning.

---

## Tech Stack

- PHP 8.2+ or Docker
- Composer

---

## Setup

### Using Docker

1. To build the container, inside the root directory run:


```bash
docker-compose build
```

2. Run the app with product codes:

```bash
docker-compose run --rm php-cli php index.php R01 R01 G01
```

3. Run unit tests:

```bash
docker-compose run --rm php-cli ./vendor/bin/phpunit tests
```

---

### Manual Setup (without Docker, if you have dependencies installed)

1. Install dependencies:

```bash
composer install
```

2. Run the basket using CLI:

```bash
php index.php B01 G01 R01
```

3. Run tests:

```bash
./vendor/bin/phpunit tests
```

---

## Test Coverage

The test suite covers:

- Red Widget offer logic (half price for second item)
- Delivery charge tiers
- Free delivery on large orders
- Invalid product code rejection
- Subtotal and total accuracy

---

## Project Structure

```
app/
  Utils/
    Offers/
    DeliveryCalculators/
index.php
tests/
composer.json
Dockerfile
docker-compose.yml
```
---

## Future Improvements

- Support for multiple and more complex offers (e.g., Buy 3 for 2)
- Configurable product catalog via database
- Interactive CLI input or web UI
- Extend support for additional pricing rules (e.g., bulk discounts)
- Improved test coverage
- Refactor to use a Service Container for even cleaner dependency management