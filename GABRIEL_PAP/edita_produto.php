<?php include 'header.php'; ?>
<?php
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=2";
	$results_admin = mysqli_query($link, $sql_login_admin);
	if (mysqli_num_rows($results_admin) == 1) {
		if (isset($_GET['id'])) {
			$id_product = preg_replace('#[^0-9]#i', '', $_GET['id']); 
			$sql = mysqli_query($link, "SELECT * FROM products WHERE id='$id_product'");
			$buscardados = mysqli_num_rows($sql);
			if ($buscardados > 0) {
				while($row = mysqli_fetch_array($sql)) { 
					$id_product = $row["id"];
					$nome_produto = $row["p_name"];
					$imagem = $row["image"];
					$preco = $row["price"];
					$descricao = nl2br($row["descricao"]);
					$categoria = $row["categoria_id"];
					$stock = $row["stock"];
					$detalhes = nl2br($row["detalhes"]);
				}
			}
			if (isset($_POST['alterar_produto'])) {
				$nome_atualizado = mysqli_real_escape_string($link, $_POST['nome_atualizado']);
				$preco_atualizado = mysqli_real_escape_string($link, $_POST['preco_atualizado']);
				$stock_atualizado = mysqli_real_escape_string($link, $_POST['stock_atualizado']);
				$categoria_atualizada = mysqli_real_escape_string($link, $_POST['categoria_atualizada']);
				$descricao_atualizada = mysqli_real_escape_string($link, $_POST['descricao_atualizada']);
				//$detalhes_atualizado = mysqli_real_escape_string($link, $_POST['detalhes_atualizado']);
				$detalhes_atualizado = nl2br($_POST['detalhes_atualizado']);

				$file_name = $_FILES['file']['name'];
				$file_type = $_FILES['file']['type'];
				$file_size = $_FILES['file']['size'];
				$file_tem_loc = $_FILES['file']['tmp_name'];
				$file_store = "imagens/produtos/".$file_name;
				if ($file_name != "") {
					move_uploaded_file($file_tem_loc, $file_store);
					mysqli_query($link, "UPDATE products SET p_name='$nome_atualizado', image='$file_name', price='$preco_atualizado', descricao='$descricao_atualizada', categoria_id=(SELECT categoria_id FROM categorias WHERE categoria_id='$categoria_atualizada'), stock = '$stock_atualizado', detalhes='$detalhes_atualizado' WHERE id = '$id_product';") or mysqli_error($link);
				}
				else {
					mysqli_query($link, "UPDATE products SET p_name='$nome_atualizado', price='$preco_atualizado', descricao='$descricao_atualizada', categoria_id=(SELECT categoria_id FROM categorias WHERE categoria_id='$categoria_atualizada'), stock = '$stock_atualizado', detalhes='$detalhes_atualizado' WHERE id = '$id_product';") or mysqli_error($link);
				}
				echo "<script>window.location.href = 'painel';</script>";
			}
			?>
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="containter">
				<center>
					<h1>Editar Produtos</h1><br>
					<font size="5%">Nome:</font><input type="text" class="form-control" style="width: 20%" name="nome_atualizado" value="<?php echo $nome_produto; ?>"><br><br>
					<font size="5%">Preço:</font><input type="number" class="form-control" style="width: 20%" step="0.01" min="0" name="preco_atualizado" value="<?php echo $preco; ?>"><br><br>
					<font size="5%">Stock:</font><input type="number" class="form-control" style="width: 20%" name="stock_atualizado" value="<?php echo $stock; ?>"><br><br>
					<font size="5%"></font><img src="imagens/produtos/<?php echo $imagem; ?>" width="200" height="180"><br><br>
					<font size="5%">Imagem do Produto</font><input type="file" name="file"><br><br>
					<select name="categoria_atualizada" class="form-control" style="width: 20%">
						<?php
					$sql = mysqli_query($link, "SELECT * FROM categorias;");
				  	$cat_loop = mysqli_num_rows($sql); 
				  	if ($cat_loop > 0) {

					    while($row = mysqli_fetch_array($sql)){
					    	$categoria_table = $row["categoria"];
					    	$categoria_id = $row['categoria_id'];
					    

					?>
					<option value="<?php echo $categoria_id; ?>" <?php if($categoria==$categoria_id): ?> selected <?php endif; ?> ><?php echo $categoria_table; ?></option>
					<?php
					   	}
				 	}
				 	?>
					</select><br><br>
					<p><font size="5%">Descrição: </font></p>
					<textarea name="descricao_atualizada" id="descricao" class="form-control" style="width: 20%" onkeypress="enter2()"></textarea><br><br>
					<p><font size="5%">Detalhes: </font></p>
					<textarea name="detalhes_atualizado" id="detalhes" class="form-control" style="width: 20%" onkeypress="enter()"></textarea>	
										<p><font size="3%">/n server para mudar de linha</font></p>
					<br>
					<?php
					$detalhes = str_replace('<br />','\n\\',nl2br($detalhes));
					$descricao = str_replace('<br />','\n\\',nl2br($descricao));
					?>
					<script type="text/javascript">
						function enter() {
						    var key = window.event.keyCode;

						    // If the user has pressed enter
						    if (key === 13) {
						        document.getElementById("descricao").value = document.getElementById("txtArea").value + "\n*";
						        return false;
						    }
						    else {
						        return true;
						    }
						}
						function enter2() {
						    var key = window.event.keyCode;

						    // If the user has pressed enter
						    if (key === 13) {
						        document.getElementById("detalhes").value = document.getElementById("txtArea").value + "\n*";
						        return false;
						    }
						    else {
						        return true;
						    }
						}
					    document.getElementById("detalhes").value = "<?php echo $detalhes; ?>";
					    document.getElementById("descricao").value = "<?php echo $descricao; ?>";
					</script>
					<button type="submit" name="alterar_produto" class="btn btn-primary">Atualizar</button><br><br>
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