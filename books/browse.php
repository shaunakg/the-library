<?php

session_start();

if (!ISSET($_SESSION['username'])) {
    header("Location: ../index.html?login_before_use=true",true,303);
}

$data_username="library_account";
$data_password="123library";
$database="library_database";

// Setup a new connection between MySQL and the program
$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

if (ISSET($_GET['pages_go'])) {
    $limit_min = $ldata->real_escape_string($_GET['limit_min']);
    $limit_max = $ldata->real_escape_string($_GET['limit_max']);
} else {
    $limit_min = 0;
    $limit_max = 50;
}

?>

<head>
    <link rel="stylesheet" href="stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<!-- <h1>Bookshelf</h1> -->
<br>
<form action="" method="GET"><div class="short-backwrap">Showing books from (number) <input min=0 max=7990 type="number" name="limit_min" value="<?php echo $limit_min;?>"> to <input type="number" min=10 max=8000 name="limit_max" value="<?php echo $limit_max;?>">  <input type="submit" class="blue-btn" name="pages_go" value="Change view"><a href="index.php" class="align-right orange-btn">Go back</a></div></form><br>

<div class="large-backwrap">
<table style="width:100%" class="centre">
    <th>Cover</th>
    <th>Title</th>
    <th>Author(s)</th>
    <th>Actions</th>

<?php

$select_query = "SELECT * FROM books limit $limit_min,$limit_max";

$result_unformatted = $ldata->query($select_query);

if (!$result_unformatted) {
    echo '<br><h1>Please enter a valid input</h1>';
    die();
}

$all = [];

while ($row = $result_unformatted->fetch_assoc()) {
    array_push($all, $row);
}

foreach ($all as $item) {

    if (!$item['loaned']) {
        $loan_btn_text = "Loan this book";
        $loan_btn_class = "green-btn";
        $loan_btn_link = '../actions/loan.php?id='.$item['book_id'];
    } else {
        if ($item['loaned_by'] == $_SESSION['username']) {
            $loan_btn_text = "Loaned by you!";
            $loan_btn_class = "green-btn";
            $loan_btn_link = "../user/loans.php";
        } else {
            $loan_btn_text = "Already loaned";
            $loan_btn_class = "red-btn link-disable";
            $loan_btn_link = "#";
        }
    }

    if (ISSET($_GET['disableImages'])) {
        $item['img_url'] = "default-cover.png";
    }

    echo '<tr>';
    echo '<td class="image-td" id="cell'.$item['book_id'].'"><img src="'.$item['img_url'].'" id="img'.$item['book_id'].'"></td>';
    echo '<td>'.$item['title'].'</td>';
    echo '<td>'.$item['authors'].'</td>';
    echo '<td>';
    echo '<a href="specific.php?id='.$item['book_id'].'" class="blue-btn">Information</a><br><br><br>';
    echo '<a href="'.$loan_btn_link.'" class="'.$loan_btn_class.'">'.$loan_btn_text.'</a><br>';
    echo '</tr>';

}

?>

</table></div><br>
