<?php

session_start();

if (ISSET($_SESSION['username'])) {
    $s_user = $_SESSION['username'];
} else {
    header("Location: ../index.html?login_before_use=true",true,303);
    die();
}

$data_username="library_account";
$data_password="123library";
$database="library_database";

// Setup a new connection between MySQL and the program
$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

$action = $_GET['action'];

if ($action == "reverse_loans") {
    $return_query = "UPDATE books
    SET loaned_by='',loaned='0'";

    $ldata->query($return_query);

    echo 'Admin: reversed all loans';
}

?>