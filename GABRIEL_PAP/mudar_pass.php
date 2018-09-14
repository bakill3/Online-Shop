<?php
include ('header.php');
if (!isset($_SESSION['username'])) {
    no_login();
}
if (isset($_GET['id'])) {
	$id_user = $_GET['id'];
	$select_token = mysqli_query($link, "SELECT * FROM users WHERE username='$sessao'");
    $select_tk = mysqli_fetch_assoc($select_token);
    $pass_db = $select_tk['password'];
    $id_db = $select_tk['id'];
    $email_user = $select_tk['email'];

    if ($id_user != $id_db) {
    	no_login();
    }
    
    if (isset($_POST['pass_rec_btn'])) {
            $pass_antiga1 = htmlspecialchars(mysqli_real_escape_string($link, $_POST['pass_antiga1']));
            $pass_antiga2 = htmlspecialchars(mysqli_real_escape_string($link, $_POST['pass_antiga2']));
            if ($pass_antiga1 != $pass_antiga2) {
                echo '<div class="alert alert-info" id="alerta">
                    <strong>As password não estão iguais!</strong>
                    </div>  <script>myvar = setInterval(slidecima, 3000);
                    function slidecima() {
                    $("#alerta").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alerta").slideUp(500);
                    });
                    window.clearInterval(myvar);

                    }
                    </script>'; 
            } else {
                if (password_verify($pass_antiga1, $pass_db)) {
                    $pass_nova = mysqli_real_escape_string($link, $_POST['pass_rec']);
                    $pass_hash_nova = password_hash($pass_nova, PASSWORD_DEFAULT);
                    mysqli_query($link, "UPDATE users SET password='$pass_hash_nova' WHERE id='$id_user'") or die(mysqli_error($link));

                    $mail = new PHPMailer;
                    $mail->isSMTP();                            // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                     // Enable SMTP authentication
                    $mail->Username = 'lifepageshop123@gmail.com'; // your email id
                    $mail->Password = 'rikoku11'; // your password
                    $mail->SMTPSecure = 'tls';                  
                    $mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
                    $mail->setFrom('lifepageshop123@gmail.com', 'LifePage');
                    $mail->addAddress($email_user);   // Add a recipient
                    $mail->isHTML(true);  // Set email format to HTML

                    $bodyContent = '<h1>Alterou a sua Password</h1>';
                    $bodyContent .= '<p>A sua password foi alterada com sucesso!</p>';
                    $mail->Subject = 'LifePage - Password';
                    $mail->Body    = $bodyContent;
                    if(!$mail->send()) {

                    } else {
                        
                    }

                    echo "<script>window.location.href='settings'</script>";
                } else {
                    echo '<div class="alert alert-danger" id="alerta">
                    <strong>Password Incorreta!</strong>
                    </div>  <script>myvar = setInterval(slidecima, 3000);
                    function slidecima() {
                    $("#alerta").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alerta").slideUp(500);
                    });
                    window.clearInterval(myvar);

                    }
                    </script>'; 
                }
            }
    }
    
?>
<br><br>
<div style="padding: 5% 0;">
<form method="post">
		<div class="login-block">
			<span>Nova Password</span>
            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="password" class="form-control" name="pass_antiga1" placeholder="Password" required /></div><br>
            <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="password" class="form-control" name="pass_antiga2" placeholder="Repetir password" required /></div><br>
			<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span><input type="password" class="form-control" name="pass_rec" placeholder="Nova Password" required /></div><br>
			<input name="pass_rec_btn" class="btn btn-primary" type="submit" value="Mudar Password" />
		</div>
</form>

</div>
<?php
}

include ('footer.php');
?>