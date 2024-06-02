<?php
// Include the configuration file which contains database connection details
include 'config.php';

// Query to select GoalId and Name from the Goals table
$sql = "SELECT GoalId, Name FROM Goals";

// Perform the SQL query
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data for each row
    while($row = $result->fetch_assoc()) {
        echo "GoalId: " . $row["GoalId"]. " - Name: " . $row["Name"]. "<br>";
    }
} else {
    echo "0 results"; // Output if no rows were returned
}

// Close the database connection
$conn->close();
?>
