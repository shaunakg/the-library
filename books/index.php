<?php

session_start();

if (!ISSET($_SESSION['username'])) {
    header("Location: ../index.html?login_before_use=true",true,303);
}

?>

<head>
    <link rel="stylesheet" href="stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<div id="backwrap" class="backwrap">
	<br><br>
    <center><span class="circle-text">Logged in.</span></center><br>

    <strong>Welcome to the library.</strong>
    <br><br>

    <div id="login_options">
        <a href="browse.php" class="blue-btn">Browse books</a>
        <a href="../user/loans.php" class="orange-btn">Your Loans</a>
        <a href="../login/logout.php" class="red-btn">Log out</a>
    </div><br><br>

    <div id="vf_admin_options">
        <!-- The pages are secure, so just enabling visibility for this div won't work. -->
        <a href="../admin/all_loans.php" class="blue-btn">View book loan status</a>
        <a href="https://localhost/phpmyadmin" class="orange-btn">[Database Admin] View Database</a>
        <a href="../login/logout.php" class="red-btn">Log out</a>
    </div>
</div>