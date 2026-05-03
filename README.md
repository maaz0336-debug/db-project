# 🛒 DB Project – E-Commerce System

## 📌 Overview

This project is a **Database-Driven E-Commerce Web Application** built using PHP and MySQL. It allows users to browse products, place orders, make payments, and leave reviews, while admins can manage the system efficiently.

---

## 🚀 Features

### 👤 User Features

* User registration & login
* Browse products
* Add to cart & place orders
* Secure checkout
* Leave reviews & ratings

### 🛠️ Admin Features

* Manage products
* Manage users
* View and process orders
* Handle payments and reviews

---

## 🏗️ Project Structure

```
db-project/
│── assets/        # CSS, images, frontend files
│── config/        # Database configuration
│── controllers/   # Business logic
│── models/        # Database interaction
│── views/         # UI pages
│── database/      # SQL schema
│── helpers/       # Utility functions
│── index.php      # Entry point
```

---

## ⚙️ Technologies Used

* PHP
* MySQL
* HTML, CSS, JavaScript
* XAMPP / Apache Server

---

## 🖥️ Installation Guide

### 1. Clone the repository

```bash
git clone https://github.com/your-username/db-project.git
```

### 2. Move project

Place the project folder inside:

```
C:/xampp/htdocs/
```

### 3. Start server

* Open XAMPP
* Start **Apache** and **MySQL**

### 4. Setup Database

* Open phpMyAdmin
* Create a database (e.g., `db_project`)
* Import:

```
database/schema.sql
```

### 5. Configure database

Edit:

```
config/database.php
```

Update:

```php
host = "localhost"
username = "root"
password = ""
database = "db_project"
```

### 6. Run project

Open browser:

```
http://localhost/db-project/
```

---




---

## 🤝 Contributing

Feel free to fork this repository and submit pull requests.

---

## 📄 License

This project is for educational purposes.

---

## 👨‍💻 Author

Your Name
GitHub: https://github.com/maaz0336-debug

---
