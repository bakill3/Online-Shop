<?php include 'header.php'; ?>
<?php
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=2";
	$results_admin = mysqli_query($link, $sql_login_admin);
	if (mysqli_num_rows($results_admin) == 1) {
		if (isset($_GET['id'])) {
			$id_promocao = preg_replace('#[^0-9]#i', '', $_GET['id']); 
			$sql = mysqli_query($link, "SELECT * FROM promocoes WHERE id_promocao='$id_promocao'");
			$buscardados = mysqli_num_rows($sql);
			if ($buscardados > 0) {
				while($row = mysqli_fetch_array($sql)) { 
					$id_promocao = $row["id_promocao"];
					$id_produto = $row["id_produto"];
					$promocao = $row["promocao"];
					$ativado = $row["ativado"];
					$destaque = $row["destaque"];
					$desconto = $row['desconto'];
					$data = $row['data'];
				}
			}
			if (isset($_POST['alterar_promocao'])) {
				$promocao_atualizado = mysqli_real_escape_string($link, $_POST['promocao_atualizado']);
				$produto_atualizado = mysqli_real_escape_string($link, $_POST['produto']);
				$desconto_atualizado = mysqli_real_escape_string($link, $_POST['desconto']);
				if (isset($_POST['ativado'])) {
					$ativado_atualizado = mysqli_real_escape_string($link, $_POST['ativado']);
				} else {
					$ativado_atualizado = 0;
				}
				if (isset($_POST['destaque'])) {
					$destaque_atualizado = mysqli_real_escape_string($link, $_POST['destaque']);
				} else {
					$destaque_atualizado = 0;
				}


				$promocao_len = strlen($promocao_atualizado);

				$verfica_prod = mysqli_query($link, "SELECT * FROM promocoes WHERE id_produto=(SELECT id FROM products WHERE id='$produto_atualizado')");

				if ($promocao_len < 50 && $promocao_len > 5) {
					if ($destaque_atualizado == 1) {
						mysqli_query($link, "UPDATE promocoes SET destaque='0' WHERE destaque='1'");
					}
					mysqli_query($link, "UPDATE promocoes SET promocao='$promocao_atualizado', id_produto=(SELECT id FROM products WHERE id='$produto_atualizado'), ativado='$ativado_atualizado', destaque='$destaque_atualizado', desconto='$desconto_atualizado', data='$data' WHERE id_promocao='$id_promocao'");

					$liga_prod_prom = mysqli_query($link, "SELECT price FROM products WHERE id='$produto_atualizado'");
					$info_prod_prom = mysqli_fetch_assoc($liga_prod_prom);
					$preco = $info_prod_prom['price'];



					$preco_descontado = $preco * $desconto_atualizado;

					$preco_total = $preco - $preco_descontado;
					mysqli_query($link, "UPDATE products SET price_descontado='$preco_total' WHERE id='$produto_atualizado'");
				}

				echo "<script>window.location.href = 'painel';</script>";
			}
			?>
			<form action="" method="POST">
				<div class="containter">
				<center>
					<h1>Editar Promoções</h1><br>
					Promoção:
					<input type="text" class="form-control" style="width: 20%" name="promocao_atualizado" value="<?php echo $promocao; ?>"><br>
					Produto
					<select name="produto" class="form-control" style="width: 20%">
						<?php 
						$select_produto = mysqli_query($link, "SELECT p_name, id FROM products");
						while ($info_prod = mysqli_fetch_array($select_produto)) {
							$id_prod_db = $info_prod['id'];
							$p_name_db = $info_prod['p_name'];
						?>
						<option value="<?php echo $id_prod_db; ?>" <?php if ($id_prod_db == $id_produto) { ?> selected <?php } ?> ><?php echo $p_name_db; ?></option>
						<?php
						}
						?>
					</select><br>
					Desconto 
					<select name="desconto" class="form-control" style="width: 20%">
						<?php 
						$b = 0;
						for ($i=0.00; $i < 1; $i+=0.01) { 

						?>
						<option value="<?php echo $i; ?>" <?php if (number_format((float)$i, 2, '.', '') == $desconto) { echo "selected"; } ?> > <?php echo $b; ?>%</option>
						<?php
						$b++;
						}
						?>
					</select><br>
					Ativado<input type="checkbox" name="ativado" class="form-control" value="1" style="display: inline-block;" <?php if ($ativado == 1) { ?> checked <?php } ?> ><br>
					Destaque<input type="checkbox" name="destaque" class="form-control" value="1" style="display: inline-block;"<?php if ($destaque == 1) { ?> checked <?php } ?> ><br><br>
					<button type="submit" name="alterar_promocao" class="btn btn-primary">Atualizar</button><br><br>
					<p>Apenas administradores têm acesso a esta página</p>
					<a href="painel" class="btn btn-info">Painel</a>
				</center>
			</form>
			<?php
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