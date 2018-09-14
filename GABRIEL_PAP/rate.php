<?php include '5.php'; ?>
<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
if(isset($_GET['id'], $_GET['rating']))  {
	$id = $_GET['id'];
	$rating = $_GET['rating'];
	$exists = mysqli_query($link, "SELECT id FROM products WHERE id = '$id'");
	mysqli_query($link, "INSERT INTO products_ratings (produto, rating) VALUES ('$id', '$rating')");
	header('Location: product.php?id='. $id);
}
?>