## Introduction
This project presents a functional Broadway ticket booking web application, crafted in PHP and designed for local development using XAMPP. The application enables users to interact with a MySQL database, allowing them to create a table, add show records, and view booking data.

![img1](https://github.com/7awad/ticket-booking-web-application/assets/123418692/14829a46-0604-42cc-818b-ce2ac95bd9a2)
![img3](https://github.com/7awad/ticket-booking-web-application/assets/123418692/c929a465-e31f-401d-a1db-ac2cc6e121a5)
![img2](https://github.com/7awad/ticket-booking-web-application/assets/123418692/f29fbbb0-651e-40e1-95a8-095e3719899d)


## Files

### `asstInclude.php`

#### Purpose
This file contains a set of PHP functions utilized by the main application (`asstmain.php`) for common tasks like writing HTML headers, displaying form elements, creating a database connection, and more.

#### Functions
- `WriteHeaders($Heading = "Welcome", $TitleBar = "MySite")`: Outputs HTML headers.
- `DisplayLabel($prompt)`: Displays a label in a specific format.
- `DisplayTextbox($inputType, $Name, $Size, $Value = 0, $focus = false)`: Displays a text input.
- `DisplayImage($filename, $alt, $height, $width)`: Displays an image.
- `DisplayButton($name, $text, $filename, $alt, $tooltip)`: Displays a button with optional image.
- `DisplayContactInfo()`: Displays contact information in the footer.
- `WriteFooters()`: Closes HTML body and adds contact information.
- `CreateConnectionObject()`: Reads database authentication information and establishes a MySQL connection.
- `CloseConnection(&$mysqlObj)`: Closes the MySQL connection.

### `asstmain.php`

#### Purpose
This file serves as the main application code for the Broadway ticket booking system. It includes functions to display the main form, create a table, add records, and display the data.

#### Functions
- `DisplayMainForm()`: Displays the main form with buttons for creating a table, adding a record, and displaying data.
- `CreateTableForm($mysqlObj, $TableName)`: Handles the creation of a table with specified columns in the database.
- `AddRecordForm()`: Displays a form for adding a show record.
- `AddRecordToTable($mysqlObj, $TableName)`: Processes form data and adds a record to the database.
- `ShowDataForm($mysqlObj, $TableName)`: Displays a table with booking data retrieved from the database.

### Prerequisites
- Install https://www.apachefriends.org/download.html on your local machine.

### Download and Setup

1. **Download the Project:**
   - Download the project from the repository.

2. **Place Files in XAMPP Root Directory:**
   - Navigate to the XAMPP root directory. This is typically the `htdocs` folder inside the XAMPP installation directory.
   - Create a new folder for your project (e.g., `BroadwayBooking`).
   - Place the downloaded project files inside this folder.

3. **Start XAMPP:**
   - Start XAMPP control panel.
   - Start the Apache server.
   - Start the MySQL server.

### Accessing the Project

4. **Access the Project in the Browser:**
   - Open your web browser.
   - Type `http://localhost/BroadwayBooking/asstmain.php` in the address bar.

5. **Interact with the Application:**
   - The Broadway Ticket Booking application should now be accessible.
   - Use the buttons on the main form to create a table, add records, and display data.

### Database Setup

6. **Database Configuration (Optional):**
   - The application uses a MySQL database. Ensure that your XAMPP MySQL server is running.
   - Database connection details are read from `auth.txt`.

7. **Run the Application:**
   - With XAMPP and MySQL running, access `http://localhost/BroadwayBooking/asstmain.php` in your browser.
   - Follow the application flow: create a table, add records, and display data.

### Important Notes:
- Ensure that your XAMPP Apache and MySQL servers are running when you try to access the application.
- If any issues arise related to database connectivity, check the `auth.txt` file and ensure that your MySQL server is configured correctly.

This setup assumes a basic understanding of XAMPP, PHP, and MySQL. Adjustments may be needed based on your specific environment or preferences.
