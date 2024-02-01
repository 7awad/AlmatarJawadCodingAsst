<?php
// http://localhost/AlmatarJawadCodingAsst/AsstMain.php

// Main code for the Broadway ticket booking web application
date_default_timezone_set('America/Toronto');
$mysqlObj; // Create a MySQL connection object
$TableName = "BroadwayShows"; // Define the table name
require "AsstInclude.php";
$mysqlObj = CreateConnectionObject();

// Call the function to write the page header
WriteHeaders("Jawad Almatar - Assignment 1", "Broadway Ticket Booking");

if (isset($_POST['f_addRecord'])) {
    AddRecordForm();
} elseif (isset($_POST['f_saveRecord'])) {
    AddRecordToTable($mysqlObj, $TableName);
} elseif (isset($_POST['f_displayData'])) {
    ShowDataForm($mysqlObj, $TableName);
} elseif (isset($_POST['f_createTable'])) {
    // Handle creating the table here
    CreateTableForm($mysqlObj, $TableName);
} else {
    DisplayMainForm();
}
WriteFooters();
CloseConnection($mysqlObj);



function DisplayMainForm()
{
    // Form to handle button actions via POST method
    echo "<form action= ? method=post>";

    // Container for buttons
    echo '<div class="button-container">';

    // Display button for creating a table
    DisplayButton(
        "f_createTable",
        "Create Table",
        "table.png",
        "Create table",
        "Create a table"
    );

    // Display button for adding a record
    DisplayButton(
        "f_addRecord",
        "Add Record",
        "add.png",
        "Add record",
        "Add a record"
    );

    // Display button for displaying data
    DisplayButton(
        "f_displayData",
        "Display Data",
        "display.png",
        "Display data",
        "Display data"
    );

    echo "</div>"; // Close the button container
    echo "</form>"; // Close the form
}



function CreateTableForm($mysqlObj, $TableName)
{
    // Start a form to handle the table creation process
    echo '<form action="?f_createTable" method="post">';

    // SQL query to drop the existing table if it exists
    $dropTableQuery = "DROP TABLE IF EXISTS $TableName";

    // SQL query to create a new table with specified columns
    $createTableQuery = "CREATE TABLE $TableName (
        showName VARCHAR(50) PRIMARY KEY,
        performanceDateAndTime DATETIME,
        nbrTickets INT,
        ticketPrice DECIMAL(5,2),
        totalCost DECIMAL(8,2)
    )";

    // Attempt to execute the DROP TABLE query
    if ($mysqlObj->query($dropTableQuery) === TRUE) {
        // If dropping table is successful, attempt to create a new table
        if ($mysqlObj->query($createTableQuery) === TRUE)
            echo "<p>Table $TableName created successfully.</p>"; // Display success message
        else
            echo "<p>Unable to create table $TableName: " . $mysqlObj->error . "</p>"; // Display error message
    } else {
        echo "<p>Unable to drop table $TableName: " . $mysqlObj->error . "</p>"; // Display error message
    }

    // Display a button to go back to the home page
    DisplayButton("f_home", "Home", "home.png", "Home", "Home");

    // Check if the home button was clicked
    if (isset($_POST["f_home"])) {
        DisplayMainForm(); // If clicked, display the main form
    }

    // Close the form
    echo "</form>";
}



function AddRecordForm()
{
    // Open a form to submit data via POST method
    echo "<form action=\"?\" method=\"post\">";

    // Field for entering the show name
    echo '<div class="datapair">';
    DisplayLabel("Show Name:"); // Display label for the input field
    DisplayTextbox("text", "showName", 50, ""); // Display a textbox for show name
    echo '</div>';

    // Field for selecting the performance date
    echo '<div class="datapair">';
    DisplayLabel("Performance Date:"); // Display label for the input field
    DisplayTextbox("date", "performanceDate", "", date("Y-m-d"), true); // Display a date input field
    echo '</div>';

    // Field for selecting the performance time
    echo '<div class="datapair">';
    DisplayLabel("Performance Time:"); // Display label for the input field
    DisplayTextbox("time", "performanceTime", "", date("H:i"), true); // Display a time input field
    echo '</div>';

    // Field for entering the number of tickets
    echo '<div class="datapair">';
    DisplayLabel("Number of Tickets:"); // Display label for the input field
    DisplayTextbox("number", "nbrTickets", "", 2); // Display a number input field
    echo '</div>';

    // Field for selecting the ticket price using radio buttons
    echo '<div class="datapair">';
    DisplayLabel("Ticket Price:"); // Display label for the input field
    echo "<div class=\"DataPair\">"; // Start a container for radio buttons
    // Display radio buttons for different ticket prices
    echo "<label>$100<input type=\"radio\" name=\"ticketPrice\" value=\"100\" checked></label>";
    echo "<label>$150<input type=\"radio\" name=\"ticketPrice\" value=\"150\"></label>";
    echo "<label>$200<input type=\"radio\" name=\"ticketPrice\" value=\"200\"></label>";
    echo "</div>"; // Close the container for radio buttons
    echo '</div>';

    // Buttons for saving record and going back to the home page
    echo '<div class="datapair">';
    DisplayButton("f_saveRecord", "Save Record", "save.png", "save", "Save Record"); // Button to save the record
    DisplayButton("f_home", "Home", "home.png", "Home", "Home"); // Button to go back to the home page
    echo '</div>';

    // Close the form
    echo "</form>";
}




function AddRecordToTable($mysqlObj, $TableName)
{
    // Retrieve data entered in the form fields
    $showName = $_POST['showName'];
    $performanceDate = $_POST['performanceDate'];
    $performanceTime = $_POST['performanceTime'];
    $nbrTickets = $_POST['nbrTickets'];
    $ticketPrice = $_POST['ticketPrice'];

    // Combine date and time for the performance date and time
    $performanceDateTime = $performanceDate . ' ' . $performanceTime;

    // Calculate the total cost considering 13% tax
    $totalCost = ($nbrTickets * $ticketPrice) * 1.13;

    // SQL query to insert the data into the specified table
    $insertQuery = "INSERT INTO $TableName (showName, performanceDateAndTime, 
                                            nbrTickets, ticketPrice, totalCost)
                                            VALUES (?, ?, ?, ?, ?)";

    // Prepare the SQL statement for execution
    if ($stmt = $mysqlObj->prepare($insertQuery)) {
        // Bind parameters to the prepared statement placeholders
        $stmt->bind_param("ssidd", $showName, $performanceDateTime, $nbrTickets,
                           $ticketPrice, $totalCost);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            // Display a success message if the record is added successfully
            echo "<p>Record successfully added to $TableName.</p>";
        } else {
            // Display an error message if execution fails
            echo "<p>Unable to add record to $TableName: " . $stmt->error . "</p>";
        }
    }

    // Display a button to return to the home page after processing the form
    echo "<form action=\"?\" method=\"post\">";
    DisplayButton("f_home", "Home", "home.png", "Home", "Home");
    echo "</form>";
}




function ShowDataForm($mysqlObj, $TableName)
{
    // Opening form tag for the data display
    echo " <form action = ? method=post>";

    // SQL query to retrieve data from the specified table and order by ticketPrice and nbrTickets
    $query = "SELECT * FROM $TableName ORDER BY ticketPrice ASC, nbrTickets DESC";
    
    // Creating a prepared statement object
    $stmtObj = new mysqli_stmt($mysqlObj);
    
    // Preparing the SQL query
    $stmtObj = $mysqlObj->prepare($query);

    // Check if preparation of the statement failed
    if ($stmtObj == false) {
        echo "Prepare failed: " . $mysqlObj->error;
    } else {
        // Binding the result variables to the prepared statement
        $bindSuccess = $stmtObj->bind_result(
            $showName,
            $performanceDateAndTime,
            $nbrTickets,
            $ticketPrice,
            $totalCost
        );

        // Check if binding was successful
        if ($bindSuccess) {
            // Executing the prepared statement
            $success = $stmtObj->execute();

            // Check if execution was successful
            if ($success) {
                // Displaying the fetched data in a table format
                echo "<table class=\"dataPair\">";
                echo "<th>Show Name</th>";
                echo "<th>Date and Time</th>";
                echo "<th>Number Of Tickets</th>";
                echo "<th>Ticket Price</th>";
                echo "<th>Total Cost</th>";

                // Loop through the fetched results
                while ($stmtObj->fetch()) {
                    echo "<tr>";
                    echo "<td>$showName</td>";
                    echo "<td>$performanceDateAndTime</td>";
                    echo "<td>$nbrTickets</td>";
                    echo "<td>$ticketPrice</td>";
                    echo "<td>$totalCost</td>";
                    echo "</tr>";
                }

                echo "</table>";

                // Get the number of rows returned by the query
                $numRows = $stmtObj->num_rows;

                // Display the total number of bookings
                echo "<p>$numRows bookings to date.</p>";

                // Displaying a button to go back to the home page
                DisplayButton("f_home", "Home", "home.png", "Home", "Home");
            } else {
                // Display an error message if execution failed
                echo "Execution failed: " . $stmtObj->error;
            }
        } else {
            // Display an error message if binding failed
            echo "Bind failed: " . $stmtObj->error;
        }
    }

    // Closing the form tag
    echo "</form>";
}
