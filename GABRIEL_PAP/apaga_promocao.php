<?php include 'header.php'; ?>
<?php
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=2";
    $results_admin = mysqli_query($link, $sql_login_admin);
    if (mysqli_num_rows($results_admin) == 1) {
    	if (isset($_GET['id']) && isset($_GET['desconto']) && isset($_GET['tipo']) && isset($_GET['cat'])) {

			$id_promocao = mysqli_real_escape_string($link, $_GET['id']);
			$desconto= mysqli_real_escape_string($link, $_GET['desconto']);
			$tipo= mysqli_real_escape_string($link, $_GET['tipo']);
			$categoria_id = mysqli_real_escape_string($link, $_GET['cat']);

			if ($tipo == 'categoria') {

				$id_pro_busca = mysqli_query($link, "SELECT * FROM promocoes WHERE categoria_id='$categoria_id'");
				while ($info_id_pro = mysqli_fetch_array($id_pro_busca)) {
					$id_produto = $info_id_pro['id_produto'];

					$tipo = $info_id_pro['tipo'];

					mysqli_query($link, "UPDATE products SET price_descontado=0 WHERE id='$id_produto'");
					mysqli_query($link, "DELETE FROM promocoes WHERE categoria_id='$categoria_id' AND id_produto='$id_produto'");

				}
				mysqli_query($link, "UPDATE categorias SET feat='0' WHERE categoria_id='$categoria_id'");
				
			}
		} elseif (isset($_GET['id']) && isset($_GET['desconto'])) {
			$id_promocao = mysqli_real_escape_string($link, $_GET['id']);
			$desconto= mysqli_real_escape_string($link, $_GET['desconto']);

			$id_pro_busca = mysqli_query($link, "SELECT * FROM promocoes WHERE id_promocao='$id_promocao'");
			$info_id_pro = mysqli_fetch_assoc($id_pro_busca);
			$id_produto = $info_id_pro['id_produto'];
			$categoria_id = $info_id_pro['categoria_id'];
			$tipo = $info_id_pro['tipo'];

			mysqli_query($link, "UPDATE products SET price_descontado=0 WHERE id='$id_produto'");
			mysqli_query($link, "DELETE FROM promocoes WHERE id_promocao='$id_promocao' LIMIT 1");
		
			
		}
		echo "<script>window.location.href='painel'</script>"; 
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