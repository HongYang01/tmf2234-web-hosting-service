# TMF2234 Web Based System Development Assignment

## Topic : Web Host Service

## 🏆 Developed by Team: _Semicolon_

- **79880** LIM HONG YANG
- **79065** CHIN TECK YUNG
- **78855** ANNASTASHA CHANG SEE MAY
- **79260** EE CHEE FAT
- **79027** CHAI CHENG KANG

## ⭐ User Manual For Localhost Deployment

<details>
<summary>Click to expand!</summary><br>

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

</details>

## ⭐ How to use ngrok to create secure tunnels to expose your local server to the internet

<details>
<summary>Click to expand!</summary><br>

1. [Register](https://dashboard.ngrok.com/signup) ngrok account
2. [Login](https://dashboard.ngrok.com/login) ngrok aacount
3. Download [ngrok](https://ngrok.com/download) (please remember the download directory)
4. Run `cmd`
5. `cd /absolute/path/to/your/ngrok-v3-stable-windows-amd64` (ngrok.exe should be inside)
6. type `ngrok` & hit ENTER - check if is correctly install (assuming no error)
7. Run your XAMPP/WampServer (Start Apache & MySQL)
8. Goto [ngrok Dashboard](https://dashboard.ngrok.com/get-started/your-authtoken) to get your _AuthToken_
9. Go back to cmd
10. type `ngrok config add-authtoken PUT_YOUR_AuthToken_HERE` & hit ENTER (only need to do this ONCE)
11. type `ngrok http 80` & hit ENTER (listening port 80, may vary depends on your local server)
12. You will now see beautiful interface in cmd
13. Copy the `Forwarding` link
14. Paste the link to any browser
15. to QUIT/Close tunnel: `Ctrl + C` in cmd

### Extra

🔁 Repeat Step `[4], [5], [11-15]` if you wish to reopen a tunnel<br>
✒️ Note: The link will be expired if you choose to close the tunnel (`Ctrl + C`)<br>
✒️ How to update ngrok: `ngrok udpate`

</details>

## Dummy Data

| Role  | Email                  | PWD         |
| ----- | ---------------------- | ----------- |
| ADMIN | admin1@semicolonix.com | 12356       |
| ----- | ---------------------- | ----------- |
| USER  | cynthia@gmail.com      | 123         |
| USER  | name1@gmail.com        | 123         |
| USER  | name2@gmail.com        | 123         |
| USER  | name3@gmail.com        | 123         |
| USER  | alex@gmail.com         | alex456@    |
| USER  | alice@outlook.com      | Alicepass   |
| USER  | bob@hotmail.com        | qwerty789   |
| USER  | emily@hotmail.com      | emily123    |
| USER  | james@gmail.com        | brown123    |
| USER  | jane@yahoo.com         | secret456   |
| USER  | john@gmail.com         | password123 |
| USER  | laura@gamil.com        | laura524    |
| USER  | michael@yahoo.com      | mike78900   |
| USER  | sarah@gmail.com        | sarah456    |

## Paypal Credentials

| Role   | Email                                 | PWD      | Usage                                                       |
| ------ | ------------------------------------- | -------- | ----------------------------------------------------------- |
| USER   | sb-tehix25986425@personal.example.com | iH!y;g8r | testing payment                                             |
| VENDOR | sb-tqzkp25986426@business.example.com | 8i)8L$MI | [manage plan](https://www.sandbox.paypal.com/billing/plans) |

Merchant ID: 425G855NZ29R6

```
hashing method: password_hash("YOUR_PASSWORD", PASSWORD_BCRYPT);
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
