<?php
include("header.php");
if (isset($_GET['rate_id']) && isset($_POST['botao_eliminar'])) {
	$rate_id=$_GET['rate_id'];
	$produto_id = mysqli_real_escape_string($link, $_POST['hidden_product_id']);

	$apagar = "DELETE from products_rating where rate_id='$rate_id'";
	mysqli_query($link, $apagar);


	$avg_rating = "SELECT AVG(rate) AS rate_avg FROM products_rating WHERE product_id='$produto_id';";
	$avg_query = mysqli_query($link, $avg_rating);
	$data = $avg_query->fetch_assoc();
	$avg_rating = $data['rate_avg'];
	$avg_criticas = number_format((float)$avg_rating, 1, '.', '');

	$sql3 = "UPDATE products SET avg_rating = '$avg_criticas' WHERE id = '$produto_id';";
	mysqli_query($link, $sql3);


	echo '<script>window.location="produto/'.$produto_id.'"</script>';
}
include("footer.php");
?>