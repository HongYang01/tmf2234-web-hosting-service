# TMF2234 Web Based System Development Assignment

## Topic : Web Host Service

## Developed by Team: _Semicolon_

- **79880** LIM HONG YANG
- **79065** CHIN TECK YUNG
- **78855** ANNASTASHA CHANG SEE MAY
- **79260** EE CHEE FAT
- **79027** CHAI CHENG KANG

---

## User Manual For Localhost Deployment

1. Open XAMPP
2. Click config (Apache)
3. Select `Apache (httpd.conf)`
4. Search for `DocumentRoot`, change the directory to your project folder

**You will see this (by default):**

```
DocumentRoot "C:/xampp/htdocs"
<Directory "C:/xampp/htdocs">
```

**Change to:**

```
DocumentRoot "path/to/your/project/folder"
<Directory "path/to/your/project/folder">
```

5. Save it, restart XAMPP and start Apache and MySQL
6. Import `id20654951_semicolonix.sql` to database (assuming no error)
7. Done, try `localhost/index.php`

---

## Dummy Data

```
USER:
email: cynthia@gmail.com
pwd  : 123

ADMIN:
email: admin1@semicolonix.com
pwd  : 12356

hashing method: password_hash("YOUR_PASSWORD", PASSWORD_BCRYPT);

PAYPAL:
email: sb-tehix25986425@personal.example.com
pwd:iH!y;g8r


```

# Folder Hierarchy

```
project/
├── assets/
│   ├── icon/
│   └── image/
├── assets/
├── auth/
├── config/
├── css/
├── includes/
├── js/
├── pages/
└── index.php
```

# Tips on SQL

1. Reset auto increment using `ALTER TABLE table_name AUTO_INCREMENT = value`
