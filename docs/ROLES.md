# 👥 Roles

---

## 👤 Guest - 0

### Description
Unauthenticated **visitor**.

### Permissions
- view informations
- register/login

---

## 🛒 Customer - 1

### Description
A **customer** can view all **available cars** and create a new rental request
for a selected car. If the request is accepted, they can pick up the rented car
and then return it.

### Permissions
- view/rent available cars
- view/create rents
- withdraw new rents
- takeaway/return active rents

---

## 🔧 Mechanic - 2

### Description
A **mechanic** can view all **unmaintained cars** and perform maintenance by
modifying the maintenance records of the selected car.

### Permissions
- view/repair unmaintained cars
- modify maintenance records of cars

---

## 💵 Salesman - 3

### Description
A **salesman** can manage all **rental requests** and **receipts** by accepting,
rejecting, or closing rental transactions.

### Permissions
- view rents
- accept/reject new rents
- close returned rents
- view/create receipts for closed rents

---

## 👑 Admin - 4

### Description
An **admin** has the highest level of privileges on the site and has full
control over all aspects of the platform.

### Permissions
- view/modify/suspend/ users
- view/create/modify/delete cars
- view/create/modify/delete rents
- view/create/modify/delete receipts
