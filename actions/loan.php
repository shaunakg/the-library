<html>
<head>
    <link rel="stylesheet" href="stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<div class="backwrap">
    <br>

</html>

<?php

session_start();

if (ISSET($_SESSION['username'])) {
    $s_user = $_SESSION['username'];
} else {
    header("Location: ../index.html?login_before_use=true",true,303);
    die();
} 

if (ISSET($_GET['id'])) {
    $borrow_id = $_GET['id'];
} else {
    header("Location: ../books/index.php", true, 303);
    die();
}

$data_username="library_account";
$data_password="123library";
$database="library_database";

// Setup a new connection between MySQL and the program
$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

$book_info_query = "SELECT * FROM books
WHERE book_id='$borrow_id'";

$book_borrow_query = "UPDATE books
SET loaned_by='$s_user',loaned='1'
WHERE book_id='$borrow_id'";

$result_unformatted = $ldata->query($book_info_query);

if ($result_unformatted) {
    $book_info = $result_unformatted->fetch_assoc();
} else {
    header("Location: ../books/index.php", true, 303);
    die();
}

if (!$book_info['loaned']) {
    if (!ISSET($_GET['noloan'])) {
        $borrow_result = $ldata->query($book_borrow_query);
    }
    if ($book_info) {
        echo '<img src="'.$book_info["img_url"].'" class="circle-image">';
        echo '<ul>';
        echo '<li><b>Book Title</b>: ' . $book_info['title'] . '</li>';
        echo '<li><b>Book Authors</b>: ' . $book_info['authors'] . '</li>';
        echo '<li><b>Published</b>: ' . $book_info["publication_year"] . '</li>';
        echo '</ul>';
        echo '<strong>The book is now loaned to you. Thank you!</strong>';
    } else {
        echo '<strong>Error: That book ID is invalid.</strong><br>';
    }
} else if ($book_info['loaned_by'] == $s_user) {
    echo "<strong>You've already loaned this book!</strong>";
} else {
    echo '<strong>Nice try. The book is already loaned to another user. Please wait until it is returned. Thank you!</strong>';
}

echo '<br><br><a href="../books/browse.php" class="green-btn">Go Back</a>';
echo '<br><br>';

die();

?>

</div>