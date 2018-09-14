<?php
include('header.php');
if (isset($_SESSION['username'])) {
	echo "<script>window.location.href = 'loja';</script>";
}
?>
<br><br>
<center>
	<form action="login.php" method="post">
		<div class="login-block">
			<h1>Login</h1>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="text" class="form-control" name="username" placeholder="Username" required /></div><br>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span><input type="password" class="form-control" name="password" placeholder="Password" required /></div><br>
			<input name="botao_login" class="btn btn-success" type="submit" value="Login" />
		</form>
		<p><a href="recuperar_pass.php"><i class="fas fa-key"></i> Esqueceste-te da password?</a></p>
		<p><a href='registo'><i class="fas fa-user-plus"></i> Registar-se</a></p>
	</div>
</center>
<?php include 'footer.php';?>