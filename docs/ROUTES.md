# 🛣️ ROUTES

---

## 🛡️ AuthenticationController

### /register [POST]

#### Body
```
{
    name: 'foo',
    email: 'foo@bar.baz',
    password: 'foobarbaz'
}
```

#### Responses
```
201 => {success}
400 => {name[]?, email[]?, password[]?}
500 => {error?}
```

### /login [POST]

#### Body
```
{
    email: 'foo@bar.baz',
    password: 'foobarbaz'
}
```

#### Responses
```
200 => {success}
400 => {name[]?, email[]?, password[]?}
401 => {error}
```

### /logout [POST:1,2,3,4]

### Responses
```
200 => {success}
```

---

## CarController

### /cars [GET:1,2,3,4]

#### Responses
```
200 => {id, license, brand, category, picture, kilometers, dailyfee,
        last_maintenance, next_maintenance}[]
```

### /cars [POST:4]

#### Body
```
{
    license: 'ABC-123',
    brand: 'Foo',
    category: 'bar',
    picture: 'https://www.foo.com/bar.jpg',
    kilometers: '0',
    dailyfee: '0',
    last_maintenance: '0',
    next_maintenance: '0'
}
```

#### Responses
```
201 => {success}
400 => {id[]?, license[]?, brand[]?, category[]?, picture[]?, kilometers[]?,
        dailyfee[]?, last_maintenance[]?, next_maintenance[]?}[]
500 => {error?}
```
