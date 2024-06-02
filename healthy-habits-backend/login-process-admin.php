<?php

    session_start();
    
    include ('../healthy-habits-backend/database/db_connection.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Step 1 :  Obtain value for each input in the form and assign it to the variable
        $Email = $_POST["Email"];
        $Password = $_POST["Password"];


        // step 2: generate sql statement for login

        $sqlLogin = "SELECT * FROM admin
                    WHERE Email = '$Email'
                    AND Password = '$Password'";

        // step 3 : establish connection to database for execute sql
        $result = mysqli_query($con, $sqlLogin);

        // display the number of records retrieve based on the sql login statement
        $count = mysqli_num_rows($result);

        $_SESSION["loggedAdminEmail"] = $Email;

        // step 4 : checking if the number of records is equal to 1, then will proceed to dashboard
        if($count == 1){
            // pop-up message for showing login successful
            echo "<script>
                        window.alert('Login successful! Welcome');
                        window.location.href = '../html/exercise-admin.html';
                    </script>";
        }
        else {
            // pop-up message for showing login fail
            echo "<script>
                        window.alert('Login failed. Please try again...');
                        window.location.href = '../html/index.html';
                    </script>";
        }
    }
    
    
?>