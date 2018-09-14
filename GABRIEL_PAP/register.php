<?php
include('header.php');
if (isset($_SESSION['username'])) {
	echo "<script>window.location.href = 'loja';</script>";
}
?>
<br><br>
<center>
	<form name="registration" action="register.php" method="post">
		<div class="login-block">
			<h1>Registo</h1>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input type="email" class="form-control" name="email" placeholder="Email" required /></div><br>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="text" class="form-control" name="nome" placeholder="Nome" required /></div><br>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="number" class="form-control" name="idade" placeholder="Idade" required /></div><br>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="text" class="form-control" name="username" placeholder="Username" required /></div><br>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="text" class="form-control" name="morada" placeholder="Morada" required /></div><br>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span><input type="password" class="form-control" name="password1" placeholder="Password" required /></div><br>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span><input type="password" class="form-control" name="password2" placeholder="Repetir Password" required></div><br>
			<input type="submit" class="btn btn-success" name="botao_registo" value="Registar" />
		</form>
		<p><a href='login'><i class="fas fa-sign-in-alt"></i> Iniciar Sessão</a></p>
	</div>
</center>
<?php include 'footer.php';?>