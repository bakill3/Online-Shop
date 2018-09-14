<?php include 'header.php'; ?>
<?php
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=2";
	$results_admin = mysqli_query($link, $sql_login_admin);
	if (mysqli_num_rows($results_admin) == 1) {
		if (isset($_GET['id'])) {
			$id_user = preg_replace('#[^0-9]#i', '', $_GET['id']); 
			$sql = mysqli_query($link, "SELECT * FROM users WHERE id='$id_user'");
			$buscardados = mysqli_num_rows($sql);
			if ($buscardados > 0) {
				while($row = mysqli_fetch_array($sql)) { 
					$id_user = $row["id"];
					$foto_perfil_user = $row["foto_perfil"];
					$email = $row["email"];
					$nome = $row["nome"];
					$idade = $row["idade"];
					$username = $row["username"];
					$role = $row["role_id"];
				}
			}
			if (isset($_POST['alterar'])) {
				$nome_atualizado = mysqli_real_escape_string($link, $_POST['nome_atualizado']);
				$idade_atualizado = mysqli_real_escape_string($link, $_POST['idade_atualizado']);
				$email_atualizado = mysqli_real_escape_string($link, $_POST['email_atualizado']);
				$username_atualizado = mysqli_real_escape_string($link, $_POST['username_atualizado']);
				$role_atualizado = mysqli_real_escape_string($link, $_POST['role_atualizado']);
				$existe = "imagens/perfil/".$username."";
				if (!is_dir($existe)) {
					mkdir($existe);
				}
				$file_name = $_FILES['file']['name'];
				$file_type = $_FILES['file']['type'];
				$file_size = $_FILES['file']['size'];
				$file_tem_loc = $_FILES['file']['tmp_name'];
				$file_store = "imagens/perfil/".$username."/".$file_name;
				$imagem_local = "imagens/perfil/".$file_name.".jpg";
				if ($file_name != "") {
					move_uploaded_file($file_tem_loc, $file_store);
					mysqli_query($link, "UPDATE users SET email='$email_atualizado', nome='$nome_atualizado', idade='$idade_atualizado', username='$username_atualizado', foto_perfil = '$file_store', role_id=(SELECT role_id FROM roles WHERE role_id='$role_atualizado') WHERE username = '$username';");
				}
				else {
					mysqli_query($link, "UPDATE users SET email='$email_atualizado', nome='$nome_atualizado', idade='$idade_atualizado', username='$username_atualizado', role_id=(SELECT role_id FROM roles WHERE role_id='$role_atualizado') WHERE username = '$username';");
				}
				echo "<script>window.location.href = 'painel';</script>";
			}
			?>
			<form action="" method="POST" enctype="multipart/form-data">
				<div class="container">
				<center>
					<h1>Editar Utilizadores</h1><br>
					<font size="5%">Nome:</font><input type="text" name="nome_atualizado" class="form-control" style="width: 30%;" value="<?php echo $nome; ?>"><br><br>
					<font size="5%">Idade:</font><input type="number" name="idade_atualizado" class="form-control" style="width: 30%;" value="<?php echo $idade; ?>"><br><br>
					<font size="5%">Email:</font><input type="text" name="email_atualizado" class="form-control" style="width: 30%;" value="<?php echo $email; ?>"><br><br>
					<font size="5%">Username:</font><input type="text" name="username_atualizado" class="form-control" style="width: 30%;" value="<?php echo $username; ?>"><br><br>
					<font size="5%"></font><img src="<?php echo $foto_perfil_user; ?>" width="200" height="180"><br><br>
					<font size="5%">Foto de perfil</font><input type="file" name="file"><br><br>
					<select name="role_atualizado" class="form-control" style="width: 30%;">
							<?php
						$sql = mysqli_query($link, "SELECT * FROM roles;");
					  	$cat_loop = mysqli_num_rows($sql); 
					  	if ($cat_loop > 0) {

						    while($row = mysqli_fetch_array($sql)){
						    	$role_texto = $row["roles"];
						    	$role_id = $row['role_id'];
						    

						?>
						<option value="<?php echo $role_id; ?>" <?php if($role==$role_id): ?> selected <?php endif; ?> ><?php echo $role_texto; ?></option>
						<?php
						   	}
					 	}
					 	?>
					</select><br><br>
					<button type="submit" name="alterar" class="btn btn-primary">Atualizar</button><br><br>
					<p>Apenas administradores têm acesso a esta página</p>
					<a href="painel" class="btn btn-info">Painel</a>
				</center>
			</div>
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