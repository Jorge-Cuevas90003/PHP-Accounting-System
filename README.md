# PHP Accounting System

A simple, web-based accounting management system (CRUD) developed as a project for a 5th-semester Computer Science course. The application allows users to manage accounts and accounting entries, and generate basic financial reports.

![Live Demo of the Application](images/app-demo.gif) 
*(Note: This GIF showcases the main functionalities of the application.)*

## Project Overview

This project was built from scratch using pure PHP and MySQL, with a front-end styled using Bootstrap 5. It covers fundamental web development concepts, including database interaction, secure CRUD operations, and dynamic report generation.

A key aspect of this project was the use of modern tools for asset creation. **The original static images and icons for the interface were designed using Microsoft's AI image generator (Bing Image Creator)**, showcasing an integration of creative AI into the development workflow.

## Features

- **Account Management**: Full CRUD capabilities (Create, Read, Update, Delete) for managing the chart of accounts.
- **Entry Management**: Record, update, and delete accounting entries (pólizas) with debit and credit details.
- **Financial Reports**:
  - Generate a **Journal Report** (Libro Diario) for all entries or a specific one.
  - Generate a **Ledger Report** (Libro Mayor) to view all transactions for a specific account.
  - Generate a **Balance Sheet** (Balanza de Comprobación) summarizing all account totals.


---

## Tech Stack

- **Backend**: PHP 8+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, Bootstrap 5
- **Asset Creation**: Microsoft Bing Image Creator (AI)

---

## Local Setup & Installation

To run this project on your local machine, you will need a local server environment like XAMPP or WAMP.

1.  **Clone the Repository:**
    ```bash
    git clone https://github.com/your-username/PHP-Accounting-System.git
    cd PHP-Accounting-System
    ```

2.  **Database Setup:**
    - Start your Apache and MySQL services from your XAMPP/WAMP control panel.
    - Open your database client (like phpMyAdmin) and create a new database. You can name it `contabilidad`.
    - Import the database structure by running the `schema.sql` file provided in this repository. This will create all the necessary tables.

3.  **Configuration File (Crucial Step):**
    - In the root directory of the project, create a new file named `config.php`.
    - Add your local database connection credentials to this file:
      ```php
      <?php
      // config.php - Database Credentials
      define('DB_HOST', 'localhost');
      define('DB_USER', 'your_user');
      define('DB_PASSWORD', 'your_password');   // Add your local DB password here if you have one
      define('DB_NAME', 'contabilidad');
      ?>
      ```

4.  **Run the Application:**
    - Place the entire `PHP-Accounting-System` project folder inside your web server's root directory (e.g., `C:/xampp/htdocs/`).
    - Open your web browser and navigate to: `http://localhost/PHP-Accounting-System/`

---

## Author

- **Jorge Cuevas**
  - GitHub: [@Jorge-Cuevas90003](https://github.com/Jorge-Cuevas90003)

This project was developed as part of the coursework for the 5th semester of the Computer Science program.
