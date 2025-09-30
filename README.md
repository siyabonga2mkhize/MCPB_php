# MCPB_php

## Overview
MCPB_php is a PHP-based application designed to run on a local server using XAMPP. This guide will help you set up, configure, and run the application on your local device.

## Prerequisites
1. Download and install [XAMPP](https://www.apachefriends.org/index.html).
2. Ensure your system has a web browser (e.g., Chrome, Firefox).

## Installation Steps

### Step 1: Download XAMPP
1. Visit the [XAMPP website](https://www.apachefriends.org/index.html).
2. Download the version suitable for your operating system (Windows, macOS, or Linux).
3. Install XAMPP by following the installation instructions.

### Step 2: Clone the Repository
1. Open a terminal or command prompt.
2. Navigate to the `htdocs` directory inside your XAMPP installation folder. For example:
   ```
   cd C:\xampp\htdocs
   ```
3. Clone the MCPB_php repository:
   ```
   git clone https://github.com/siyabonga2mkhize/MCPB_php.git
   ```

### Step 3: Configure the Database
1. Open XAMPP and start the **Apache** and **MySQL** services.
2. Open your web browser and go to `http://localhost/phpmyadmin`.
3. Create a new database named `mcpa`.
4. Import the SQL file provided in the repository (if available) to set up the database schema and data.

### Step 4: Run the Application
1. Open your web browser.
2. Navigate to `http://localhost/MCPB_php`.
3. You should see the homepage of the application.

## Troubleshooting
- **Apache or MySQL not starting**: Ensure no other applications are using ports 80 or 3306.
- **Database errors**: Verify the database name and imported SQL file.
- **Page not loading**: Check the file paths and ensure the repository is inside the `htdocs` folder.

## Additional Notes
- Make sure to configure the `database.php` file with the correct database credentials if needed.
- For further assistance, refer to the [XAMPP documentation](https://www.apachefriends.org/docs.html).

Enjoy using MCPB_php!
