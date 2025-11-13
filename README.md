# Go-Pharma: Pharmacy Management System

![Go-Pharma Dashboard Preview](demo_images/dashboard-preview.png)

`Go-Pharma` is a comprehensive, web-based Pharmacy Management System built with PHP and MySQL. It is designed to manage sales, inventory (medicines), suppliers, and users in a hospital or retail pharmacy setting. The system features role-based access for Admins and standard users.

---

## Features

* **User Authentication:** Secure login and logout system with session management.
* **Role-Based Access:** Differentiated dashboard and navigation for 'Admin' and other roles (e.g., 'Admin' can manage users, others cannot).
* **Interactive Dashboard:** At-a-glance view of key metrics, likely including sales charts (powered by Chart.js).
* **Sales Management:** A dedicated module for processing sales and viewing sales history.
* **Invoice Generation:** Dynamically generates PDF invoices for sales (using the FPDF library).
* **Medicine Management:** Full CRUD (Create, Read, Update, Delete) functionality for managing medicine inventory.
* **Supplier Management:** Full CRUD (Create, Read, Update, Delete) functionality for managing supplier details.
* **User Management (Admin-only):** Full CRUD (Create, Read, Update, Delete) functionality for managing system users.
* **Dynamic Search:** AJAX-powered search functionality for finding items quickly.
* **Responsive UI:** A clean, modern, and responsive user interface built with custom CSS, Font Awesome, and Lottie animations.

---

## Technology Stack

* **Backend:** PHP
* **Database:** MySQL
* **Frontend:** HTML, CSS, JavaScript
* **Libraries:**
    * [Chart.js](https://www.chartjs.org/) - For data visualization on the dashboard.
    * [Font Awesome](https://fontawesome.com/) - For icons.
    * [Lottie](https://lottiefiles.com/) - For animations.
    * [FPDF](http://www.fpdf.org/) - For PDF generation.

---

## Prerequisites

Before you begin, you must have a local web server environment installed on your system.

* **XAMPP:** This is the recommended environment as it includes Apache (web server), MySQL (database), and PHP all in one package. The database credentials in this project are set to the XAMPP defaults.
* **Web Browser:** A modern web browser like Google Chrome, Firefox, or Edge.
* **Code Editor:** A code editor like VS Code (optional, for modifications).

---

## Installation and Setup (A-Z Guide)

Follow these steps exactly to get the project running on your local machine.

### Step 1: Get the Project Files

1.  **Download:** Download the project files as a ZIP folder.
2.  **Extract:** Unzip the downloaded folder.
3.  **Rename (Optional):** Rename the extracted folder from `hospital-pharmacy-main` (or similar) to just `hospital-pharmacy`.

### Step 2: Place Files in Server Directory

1.  **Find `htdocs`:** Open your XAMPP installation directory. The webroot folder is called `htdocs`.
    * (Default path on Windows: `C:\xampp\htdocs`)
2.  **Move Project:** Move the entire `hospital-pharmacy` project folder into the `htdocs` directory.
    * Your project should now be at: `C:\xampp\htdocs\hospital-pharmacy`

### Step 3: Start Local Server

1.  **Open XAMPP:** Run the **XAMPP Control Panel**.
2.  **Start Services:** Click the **Start** button for both the **Apache** and **MySQL** modules.

### Step 4: Create and Import the Database

This is the most critical step. The application needs a database named `pharmacy_db` to function.

1.  **Open phpMyAdmin:** In your web browser, go to `http://localhost/phpmyadmin`.
2.  **Create Database:**
    * Click on the **Databases** tab at the top.
    * In the "Create database" field, type `pharmacy_db`.
    * Select `utf8mb4_general_ci` as the collation (optional, but recommended).
    * Click **Create**.
3.  **Import SQL File:**
    * **[IMPORTANT]** You must first have a `.sql` file that contains the database structure (tables) and any default data (like an admin user). You will need to create this file by "exporting" it from your original database.
    * Once you have your `pharmacy_db.sql` file, click on the `pharmacy_db` database in the left-hand sidebar of phpMyAdmin.
    * Click on the **Import** tab at the top.
    * Click **"Choose File"** and select your `pharmacy_db.sql` file.
    * Scroll to the bottom and click **Go**.

> **Note for the Project Owner:**
> Before you upload to GitHub, go to your working `http://localhost/phpmyadmin`, select `pharmacy_db`, click the **Export** tab, and save the database as `pharmacy_db.sql`. Add this `.sql` file to your project folder so others can import it.

### Step 5: Verify Database Connection (Optional)

The project is pre-configured to work with the default XAMPP settings.

* **File:** `hospital-pharmacy/includes/db_connect.php`
* **Server:** `localhost`
* **Username:** `root`
* **Password:** `""` (empty)
* **Database:** `pharmacy_db`

If your local MySQL setup uses a password, you **must** open this file and add your password to the `$password` variable.

### Step 6: Run the Application

You are all set!

1.  Open your web browser.
2.  Navigate to: `http://localhost/hospital-pharmacy/login.php`
3.  The application's login page should appear.

---

## Usage & Default Credentials

To use the system, you must log in.

> **Note for the Project Owner:**
> You should include the default login credentials here, which should be part of your `pharmacy_db.sql` file.

**Example Logins:**

* **Admin Account:**
    * Username: `admin`
    * Password: `admin123`
* **Standard User Account:**
    * Username: `user`
    * Password: `user123`

---

## Project File Structure

Here is a brief overview of the project's directory structure.

```bash
/hospital-pharmacy
│
├── includes/
│   ├── db_connect.php  # Database connection configuration
│   ├── header.php      # Page header, navigation, and session check
│   └── footer.php      # Page footer
│
├── assets/
│   ├── css/
│   │   └── style.css   # Main stylesheet
│   ├── js/
│   │   ├── charts.js   # Logic for Chart.js
│   │   └── sales.js    # JS for the sales page
│   └── animations/
│       └── health.json # Lottie animation file
│
├── fpdf/               # FPDF library for generating PDFs
│
├── add_medicine.php    # PHP files for all pages and features
├── edit_medicine.php
├── medicines.php
├── add_supplier.php
├── ...
├── login.php           # Login page
├── dashboard.php       # Main dashboard page
├── sales.php
├── generate_invoice.php
│
└── pharmacy_db.sql     # [IMPORTANT] The database export file (You must add this)
