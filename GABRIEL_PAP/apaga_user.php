<?php include 'header.php'; ?>
<?php
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=(SELECT role_id FROM roles WHERE role_id='2')";
    $results_admin = mysqli_query($link, $sql_login_admin);
    if (mysqli_num_rows($results_admin) == 1) {
		if (isset($_GET['id'])) {
			$id_user = mysqli_real_escape_string($link, $_GET['id']);

			mysqli_query($link, "DELETE FROM carrinho WHERE user_id='$id_user'") or die(mysqli_error($link));
		    mysqli_query($link, "DELETE FROM products_rating WHERE user_id=(SELECT id FROM users WHERE id='$id_user') LIMIT 1");
		    mysqli_query($link, "DELETE FROM users WHERE id='$id_user'") or die(mysqli_error($link));
		    echo "<script>window.location.href = 'painel';</script>";
		     
		}
	}
	else {
		no_login();
	}
}
else {
	no_login();
}
?>
<?php include 'footer.php'; ?>