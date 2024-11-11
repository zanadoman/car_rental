# Database

## Users
- id - ID
- name - STRING
- email - STRING UNIQUE
- password - STRING
- role - UNSIGNED_INTEGER DEFAULT(1)

## Cars
- id - ID
- license - STRING UNIQUE
- brand - STRING
- category - STRING
- kilometers - UNSIGNED_INTEGER
- dailyfee - UNSIGNED_INTEGER
- last_maintenance - UNSIGNED_INTEGER
- next_maintenance - UNSIGNED_INTEGER

## Rents
- id - ID
- salesman_id - FK
- customer_id - FK
- car_id - FK
- begin - DATE
- end - DATE
- kilometers - UNSIGNED_INTEGER
- active - BOOELAN
- takeaway - DATE NULLABLE
- return - DATE NULLABLE

## Receipts
- id - ID
- salesman_id - FK
- customer_id - FK
- car_id - FK
- begin - DATE
- end - DATE
- delay - INT NULLABLE
- km - UNSIGNED_INTEGER
- payment - UNSIGNED_INTEGER
