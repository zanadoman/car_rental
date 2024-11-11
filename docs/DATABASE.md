# 🛢 Database (Eloquent ORM)

## 👥 Users
|Name    |Type               |Properties|
|:-------|:-----------------:|:---------|
|id      |id                 |          |
|name    |string             |          |
|email   |string             |unique    |
|password|string             |          |
|role    |unsignedTinyInteger|default(1)|

---

## 🚗 Cars
|Name            |Type           |Properties|
|:---------------|:-------------:|:---------|
|id              |id             |          |
|license         |string         |unique    |
|brand           |string         |          |
|category        |string         |          |
|picture         |string         |          |
|kilometers      |unsignedInteger|          |
|dailyfee        |unsignedInteger|          |
|last_maintenance|unsignedInteger|          |
|next_maintenance|unsignedInteger|          |

---

## 🔑 Rents
|Name       |Type              |Properties |
|:----------|:----------------:|:----------|
|id         |id                |           |
|customer   |foreignId(user_id)|constrained|
|car        |foreignId(car_id) |constrained|
|kilometers |unsignedInteger   |           |
|begin      |date              |           |
|end        |date              |           |
|takeaway   |date              |nullable   |
|return     |date              |nullable   |
|active     |boolean           |           |

---

## 🧾 Receipts
|Name       |Type              |Properties |
|:----------|:----------------:|:----------|
|id         |id                |           |
|customer   |foreignId(user_id)|constrained|
|car        |foreignId(car_id) |constrained|
|kilometers |unsignedInteger   |           |
|begin      |date              |           |
|end        |date              |           |
|delay      |unsignedInteger   |nullable   |
|totalfee   |unsignedInteger   |           |
