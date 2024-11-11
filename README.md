## 🛠️ Dependencies

To host the website, make sure you have the following dependencies installed:

- **Composer**
- **php**
- **MariaDB**
- **npm**

---

## 🔧 Hosting Instructions

Follow these steps to host the website:
```
git clone https://github.com/zanadoman/car_rental.git
```

Follow these steps to host the backend:
```
cd car_rental/backend
composer install
mariadb -u root -p -e "CREATE DATABASE carrental;"
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh
php artisan serve
```

Follow these steps to host the frontend:
```
cd car_rental/frontend
npm install
npm start
```

---

## 💪 Developers
- Zana Domán (Z17V4D)
- Plasku Dominik (AEEBES)
- Borsodi István (F0M774)
