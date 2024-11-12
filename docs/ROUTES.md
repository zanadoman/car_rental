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
201 => ['success']
400 => ['name?', 'email?', 'password?']
500 => ['error?']
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
200 => ['success']
400 => ['name?', 'email?', 'password?']
401 => ['error']
```

### /logout [POST:1,2,3,4]

### Responses
```
200 => ['success']
```
