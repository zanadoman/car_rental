## 🛠️ Dependencies

To host the website, make sure you have the following depencencies installed:

- **Composer**
- **php**
- **MariaDB**

## 🔧 Hosting Instructions

Follow these steps to host the backend:
```
git clone https://github.com/zanadoman/car_rental.git
cd car_rental/backend
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

