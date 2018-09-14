<?php
include ('header.php');
if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($link, $_GET['token']);
    $select_token = mysqli_query($link, "SELECT token FROM users WHERE token='$token'");
    $select_tk = mysqli_fetch_assoc($select_token);
    $token_db = $select_tk['token'];

    if ($token_db == $token) {
        mysqli_query($link, "UPDATE users SET activate='1' WHERE token='$token'");
        no_login();
    }
}
include ('footer.php');
?>