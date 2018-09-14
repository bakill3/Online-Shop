<?php
include('header.php');
if (isset($_SESSION['username'])) {
	echo "<script>window.location.href = 'loja';</script>";
}
?>
<br><br>
<div style="text-align: center">
	<form method="post">
		<div class="login-block">
			<h1>Repor palavra-passe</h1>
			<?php
			if (isset($existe_email) && $existe_email == 1) {
			?>
			<span>Foi enviado um mail de confirmação para <?= $email_rec; ?></span>
			<meta http-equiv="refresh" content="5;url=loja" />
			<?php
			} else {
			?>
			<span>Insira o seu email</span>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="email" class="form-control" name="email_rec" placeholder="Email" required /></div><br>
			<span>Insira o seu username</span>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="text" class="form-control" name="username_rec" placeholder="Username" required /></div><br>
			<input name="botao_rec" class="btn btn-primary" type="submit" value="Recuperar" />
			<p><a href='login'><i class="fas fa-sign-in-alt"></i> Iniciar Sessão</a></p>
			<?php
			}
			?>
		</form>
		</div>

</div>
<?php include 'footer.php';?>