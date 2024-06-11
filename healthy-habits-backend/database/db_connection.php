<?php
    date_default_timezone_set("Asia/Kuala_Lumpur");

    // LocalHost Ip address to store database location
    $host = "127.0.0.1";

    // A standard port number to use for pHpMyAdmin MYSQL database in XAMPP 
    $port = 3306;

    // the extend for port if the ip in the port is full
    $socket = "";

    // database username
    //$user = "b032110405";
    $user = "root";


    // Most of the time the password is empty 
    //$password = "021217-14-0358";
    $password = "";


    // database name 
    //$dbname = "student_b032110405";
    $dbname = "healthy_habits";



    // Connection mysqli carry all define above variable to phpadmin
    // die - php immediately stop the function

    // type of connection : mysql object oriented
    $con = new mysqli($host, $user, $password, $dbname, $port, $socket);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    } /* else {
        echo "Connected successfully";
    }   */
?>