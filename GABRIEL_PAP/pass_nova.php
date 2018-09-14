<?php
include ('header.php');
if (isset($_GET['token']) && isset($_GET['erro'])) {
    $token = mysqli_real_escape_string($link, $_GET['token']);
    $select_token = mysqli_query($link, "SELECT * FROM users WHERE token='$token'");
    $select_tk = mysqli_fetch_assoc($select_token);
    $token_db = $select_tk['token'];
    $recup_db = $select_tk['recup'];
    $id_db = $select_tk['id'];
    if ($token_db != $token || $recup_db == 0) {
        no_login();
    }
    mysqli_query($link, "UPDATE users SET recup='0' WHERE id='$id_db'") or die(mysqli_error($link));
    echo "<script>window.location.href='loja'</script>";
}
elseif (isset($_GET['token'])) {
	$token = mysqli_real_escape_string($link, $_GET['token']);
	$select_token = mysqli_query($link, "SELECT * FROM users WHERE token='$token'");
    $select_tk = mysqli_fetch_assoc($select_token);
    $token_db = $select_tk['token'];
    $recup_db = $select_tk['recup'];
    $id_db = $select_tk['id'];
    if ($token_db != $token || $recup_db == 0) {
    	no_login();
    }
    
    if (isset($_POST['pass_rec_btn'])) {
    		$digitos_token = 4;
			$token_novo = rand(pow(10, $digitos_token-1), pow(10, $digitos_token)-1);
    		$pass_rec = mysqli_real_escape_string($link, $_POST['pass_rec']);
    		$pass_hash_rec = password_hash($pass_rec, PASSWORD_DEFAULT);
	        mysqli_query($link, "UPDATE users SET password='$pass_hash_rec', token='$token_novo', recup='0' WHERE id='$id_db'") or die(mysqli_error($link));
	        echo "<script>window.location.href='login'</script>";
    }
    
?>
<br><br>
<div style="padding: 10% 0;">
<form method="post">
		<div class="login-block">
			<span>Insira a sua nova password</span>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="password" class="form-control" name="pass_rec" placeholder="Password" required /></div><br>
			<input name="pass_rec_btn" class="btn btn-primary" type="submit" value="Mudar Password" />
		</div>
</form>

</div>
<?php
}

include ('footer.php');
?>