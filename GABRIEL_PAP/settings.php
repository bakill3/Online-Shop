<?php include 'header.php';?>

<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
if (isset($_SESSION['username'])) {
  $sessao = $_SESSION['username'];
  $sql = mysqli_query($link, "SELECT * FROM users WHERE username='$sessao' LIMIT 1");
  $buscardados = mysqli_num_rows($sql);
  if ($buscardados > 0) {
    while($row = mysqli_fetch_array($sql)){ 
     $user_id = $row["id"];
     $email = $row["email"];
     $nome = $row["nome"];
     $idade = $row["idade"];
     $username = $row["username"];
     $role_id = $row["role_id"];
     $morada = $row['morada'];
     $token = $row['token'];
   }
 }
 if (isset($_POST['foto_perfil'])) {
  $existe = "imagens/perfil/".$sessao."";
  if (!is_dir($existe)) {
    mkdir($existe);
  }
  $file_name = $_FILES['file']['name'];
  $file_type = $_FILES['file']['type'];
  $file_size = $_FILES['file']['size'];
  $file_tem_loc = $_FILES['file']['tmp_name'];
  $file_store = "imagens/perfil/".$sessao."/".$file_name;
  $imagem_local = "imagens/perfil/".$file_name.".jpg";

  move_uploaded_file($file_tem_loc, $file_store);

  mysqli_query($link, "UPDATE users SET foto_perfil = '$file_store' WHERE username = '$sessao';");

  echo "<script>window.location.href = 'settings';</script>";
}
$query = "SELECT roles FROM roles WHERE role_id='$role_id';";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);
$role = $row['roles'];

if(isset($_POST['alterar'])) {
  $nome_atualizado = htmlspecialchars(mysqli_real_escape_string($link, $_POST['nome_atualizado']));
  $idade_atualizado = htmlspecialchars(mysqli_real_escape_string($link, $_POST['idade_atualizado']));
  $email_atualizado = htmlspecialchars(mysqli_real_escape_string($link, $_POST['email_atualizado']));
  // $username_atualizado = mysqli_real_escape_string($link, $_POST['username_atualizado']); É melhor não mudar
  $morada_atualizado = htmlspecialchars(mysqli_real_escape_string($link, $_POST['morada_atualizado']));

  mysqli_query($link, "UPDATE users SET email='$email_atualizado', nome='$nome_atualizado', idade='$idade_atualizado', morada='$morada_atualizado' WHERE id = '$user_id';");
  echo "<script>window.location.href='settings'</script>";
}
?>
<center>
  <h2>Definições</h2> 
  <br>
  <hr>
     <h2><b>Informações sobre o utilizador <?php echo $nome; ?> :</b></h2>   
     <br>     
     <div class="container">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Idade</th>
            <th>Email</th>
            <th>Username</th>
            <th>Estatuto</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $nome; ?></td>
            <td><?php echo $idade; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $username; ?></td>
            <td><?php echo $role; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <hr>
    <h2><b>Alterações na conta: </b></h2><br>
    <form action="" method="POST" enctype="multipart/form-data">
      <h3><i>- Foto de perfil:</i></h3> <br />
        <?php  
  if (isset($sessao)) {
    if ($foto_perfil == "") {
     ?>
     <center><img src="assets/img/avatar.jpg" width="200" height="180"></center>
     <?php
    } else {
    ?>
    <img src="<?php echo $foto_perfil; ?>" width="200" height="180">
    <?php
    }
  }
    ?>
    <br><br>
      <input type="file" name="file">
      <input type="submit" name="foto_perfil" value="Upload" />
    </form>
    <br><br>
    <h3><i>Alterar Dados:</i></h3><br>
    

<form action="" method="POST" enctype="multipart/form-data">
				<div class="container" style="width: 20%;">
					<div class="input-group">
						<span class="input-group-addon">Nome</span>
						<input type="text" class="form-control" name="nome_atualizado" value="<?php echo $nome; ?>">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon">Idade</span>
						<input type="number" class="form-control" name="idade_atualizado" value="<?php echo $idade; ?>">
					</div><br>
					<div class="input-group">
						<span class="input-group-addon">Email</span>
						<input type="text" class="form-control" name="email_atualizado" value="<?php echo $email; ?>">
					</div><br>
		  <div class="input-group">
						<span class="input-group-addon">Morada</span>
          				<input type="text" class="form-control" name="morada_atualizado" value="<?php echo $morada; ?>">
      	  </div><br>
          <a href="mudar_pass.php?id=<?php echo $user_id; ?>"><i class="fas fa-key"></i> Alterar Password</a><br>
					
         
          <br>
					<button type="submit" name="alterar" class="btn btn-primary">Atualizar</button><br><br>
          </div>
    </form>
    <br><br>
    <h3><i>- Eliminar Conta:</i></h3> <br />
    <button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#eliminar"><i class="fas fa-ban"></i> Eliminar Conta</button>



    <div class="modal fade" id="eliminar" role="dialog">
      <div class="modal-dialog">
      
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Aviso</h4>
          </div>
          <div class="modal-body">
            <p>Tem a certeza que quer eliminar a sua conta?</p>
          </div>
          <div class="modal-footer">
            <form action="" method="POST">
              <button type="submit" class="btn btn-danger" name="apagar_conta">Sim</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
            </form>
          </div>
        </div>
        
      </div>
    </div>

    <hr>
    <h2><b>Outros: </b></h2><br>
    <a href="logout.php"><button type="submit" class="btn btn-info">Terminar Sessão/Logout</button></a>

    <?php
    $sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=2";
    $results_admin = mysqli_query($link, $sql_login_admin);

    if (mysqli_num_rows($results_admin) == 1) {
    ?>
    <hr>
    <h2><b>Ferramentas de administrador: </b></h2><p>Apenas administradores têm acesso a estas opções:</p><br>
    <a href="painel"><button type="submit" class="btn btn-primary">Painel de Administração</button></a><br><br>
    <?php
    }
    ?>

  </center>
  <?php 
  if (isset($_POST['apagar_conta'])) {
    mysqli_query($link, "DELETE FROM carrinho WHERE user_id='$user_id'") or die(mysqli_error($link));
    mysqli_query($link, "DELETE FROM products_rating WHERE user_id='$user_id' LIMIT 1");
   mysqli_query($link, "DELETE FROM users WHERE username='$sessao' LIMIT 1");
   session_destroy();
   no_login();
  }
  } else {
    no_login();
  }
?>
<?php include 'footer.php';?>