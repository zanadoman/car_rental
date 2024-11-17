# 🛢 Database (Eloquent ORM)

---

## 👥 Users

|Name    |Type              |Properties         |
|:------:|:----------------:|:-----------------:|
|id      |id()              |                   |
|name    |string('name')    |                   |
|email   |string('email')   |unique()           |
|password|string('password')|                   |
|role    |string('role')    |default('customer')|
|active  |boolean('active') |default(true)      |

---

## 🚗 Cars

|Name            |Type                               |Properties|
|:--------------:|:---------------------------------:|:--------:|
|id              |id()                               |          |
|license         |string('license')                  |unique()  |
|brand           |string('brand')                    |          |
|category        |string('category')                 |          |
|kilometers      |unsignedInteger('kilometers')      |          |
|dailyfee        |unsignedInteger('dailyfee')        |          |
|last_maintenance|unsignedInteger('last_maintenance')|          |
|next_maintenance|unsignedInteger('next_maintenance')|          |

---

## 🔑 Rents

|Name       |Type                         |Properties   |
|:---------:|:---------------------------:|:-----------:|
|id         |id()                         |             |
|user_id    |foreignId('user_id')         |constrained()|
|car_id     |foreignId('car_id')          |constrained()|
|kilometers |unsignedInteger('kilometers')|             |
|begin      |date('begin')                |             |
|end        |date('end')                  |             |
|takeaway   |date('takeaway')             |nullable()   |
|return     |date('return')               |nullable()   |
|active     |boolean('active')            |             |

---

## 🧾 Receipts

|Name       |Type                         |Properties   |
|:---------:|:---------------------------:|:-----------:|
|id         |id()                         |             |
|user_id    |foreignId('user_id')         |constrained()|
|car_id     |foreignId('car_id')          |constrained()|
|kilometers |unsignedInteger('kilometers')|             |
|begin      |date('begin')                |             |
|end        |date('end')                  |             |
|delay      |unsignedInteger('delay')     |nullable()   |
|totalfee   |unsignedInteger('totalfee')  |             |
