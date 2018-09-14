<?php include 'header.php'; ?>
<?php
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=(SELECT role_id FROM roles WHERE role_id=2)";
    $results_admin = mysqli_query($link, $sql_login_admin);
    if (mysqli_num_rows($results_admin) == 1) {
		if (isset($_GET['id'])) {
			$id_product = mysqli_real_escape_string($link, $_GET['id']);
			mysqli_query($link, "DELETE FROM products_rating WHERE product_id='$id_product' LIMIT 1");
			mysqli_query($link, "DELETE FROM carrinho WHERE product_id='$id_product' LIMIT 1");
			mysqli_query($link, "DELETE FROM products WHERE id='$id_product' LIMIT 1");
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