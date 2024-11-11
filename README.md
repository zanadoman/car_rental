## 🛠️ Dependencies

To host the website, make sure you have the following dependencies installed:

- **Composer**
- **php**
- **MariaDB**

---

## 🔧 Hosting Instructions

Follow these steps to host the backend:
```
git clone https://github.com/zanadoman/car_rental.git
cd car_rental/backend
composer install
mariadb -u root -p -e "CREATE DATABASE carrental;"
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh
php artisan serve
```
---

## 💪 Developers
- Zana Domán (Z17V4D)
- Plasku Dominik (AEEBES)
- Borsodi István (F0M774)
