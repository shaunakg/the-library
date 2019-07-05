<head>
    <link rel="stylesheet" href="stylesheet.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<div id="backwrap" class="backwrap">
	<br><br>
	<center><span id="login_status" class="circle-text">Library</span></center><br><br>
    
    <strong>The username or password combination is incorrect.</strong><br>

<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("X-Error-Information: Post only",true,400);
    die();
}

$data_username="library_account";
$data_password="123library";
$database="library_database";

// Setup a new connection between MySQL and the program
$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

$raw_user = $_POST['user'];
$raw_pw = $_POST['pw'];

$user = $ldata->real_escape_string($_POST['user']);
$password = $ldata->real_escape_string($_POST['pw']);
$pw_md5 = md5($password);

echo '<form action="" method="POST">';
echo "<input type=\"hidden\" name=\"user\" value=\"$raw_user\">";
echo "<input type=\"hidden\" name=\"pw\" value=\"$raw_pw\">";
echo "<input type=\"hidden\" name=\"action\" value=\"create\">";

?>

<p>You can either <strong><label><input type="submit" class="hidden_submit" value="create this account"></label></strong> or <strong><a href="../index.html">try again</a></strong>.</p>
</form>

</div>

<?php

if ($_POST['action'] == "login") {
    $exists_query = "SELECT * FROM logins
    WHERE username='$user'
    AND password='$pw_md5'";

    $exists_result = $ldata->query($exists_query);
    $exists_row = $exists_result->fetch_assoc();

    if ($exists_row['username'] == $user) {
        session_start();
        $_SESSION = array_merge($_SESSION,$exists_row);
        header("Location: ../books/index.php?loggedin=true", true, 303);
    }

} else if ($_POST['action'] == "create") {
    $create_query = "INSERT INTO logins (username, password) VALUES ('$user','$pw_md5')";
    $ldata->query($create_query);
    header("Location: ../index.html?just_created=true", true, 303);
}

?>