<?php include 'header.php';?>
<?php 
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$data_atual = date("Y-m-d H:i");
	$carrinho = '<table style="border: 1px solid black;">  
    <tr style="border: 1px solid black;">  
     <th width="30%" style="border: 1px solid black;">Nome do produto</th>  
     <th width="10%" style="border: 1px solid black;">Quantidade</th>  
     <th width="15%" style="border: 1px solid black;">Preço</th>  
     <th width="15%" style="border: 1px solid black;">Total:</th></tr>';
	$sql_user = mysqli_query($link, "SELECT * FROM users WHERE username='$sessao' LIMIT 1");
	$user_count = mysqli_num_rows($sql_user); 
	if ($user_count > 0) {
		while($row_dados = mysqli_fetch_array($sql_user)){ 
			$id = $row_dados['id'];
			$email_user = $row_dados['email'];
			$nome = $row_dados['nome'];
			$morada = $row_dados['morada'];
		}
	}
		if (isset($_GET["st"])) {
			$total_final = 0;
			$trx_id = mysqli_real_escape_string($link, $_GET["tx"]);
			$p_st = mysqli_real_escape_string($link, $_GET["st"]);
			$amt = mysqli_real_escape_string($link, $_GET["amt"]);
			$cc = mysqli_real_escape_string($link, $_GET["cc"]);
			$cm_user_id = mysqli_real_escape_string($link, $_GET["cm"]);
			if ($p_st == "Completed") { 
				$sql_carrinho = "SELECT * FROM carrinho WHERE user_id = (SELECT id FROM users WHERE id='$id')";
				$sql_select_carrinho = mysqli_query($link, $sql_carrinho) or die(mysqli_error($link));
				$resultado_carrinho = mysqli_num_rows($sql_select_carrinho);
				if ($resultado_carrinho > 0) {
				while ($row = mysqli_fetch_array($sql_select_carrinho)) {
					$id_do_produto = $row['product_id'];
				    $nome_do_produto = $row["nome_do_produto"];
				    $quantidade = $row["quantidade"];
				    $preco = $row["preco_do_produto"];
				    $total = $quantidade * $preco;
				    $total_dps = number_format($total, 2);

				    $carrinho .= '<tr style="border: 1px solid black;">  
				     <td style="border: 1px solid black;">'.$nome_do_produto.'</td>  
				     <td style="border: 1px solid black;">'.$quantidade.'</td>  
				     <td style="border: 1px solid black;">'.$preco.' €</td>  
				     <td style="border: 1px solid black;">'.$total_dps.' €</td>  
					 </tr>  ';
					$total_final = $total_final + ($quantidade * $preco);
				
					$sql = "INSERT INTO orders (user_id_paypal, product_id, quantidade, tn, status, user_id, morada, data) VALUES ('$cm_user_id', '$id_do_produto', '$quantidade','$trx_id','$p_st', (SELECT id FROM users WHERE id='$id'), (SELECT morada FROM users WHERE morada='$morada'), '$data_atual');";
					mysqli_query($link,$sql) or die(mysqli_error($link));

					$sql_produtos = mysqli_query($link, "SELECT * FROM products WHERE id='$id_do_produto'");
					$produtos_count = mysqli_num_rows($sql_produtos) or die(mysqli_error($link)); 
					if ($produtos_count > 0) {
						while($row_dados_produtos = mysqli_fetch_array($sql_produtos)){ 
							$stock = $row_dados_produtos['stock'];
						}
						$stock_final = $stock - $quantidade;
						$sql2 = "UPDATE products SET stock = $stock_final WHERE id = '".$id_do_produto."'";
						mysqli_query($link,$sql2) or die(mysqli_error($link));
					}
				}
				$total_tudo = number_format($total_final, 2);
				$carrinho .= '<tr style="border: 1px solid black;">  
			   <td colspan="3" align="right" style="border: 1px solid black;">Total</td>  
			   <td align="right" style="border: 1px solid black;">'.$total_tudo.' €</td>
			   </tr>
			</table>';
			//Enviar mail ao utilizador
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

				$bodyContent = '<h1>Pagamento com Sucesso</h1>';
				$bodyContent .= '<p>O seu pagamento foi concluído com sucesso.'.$carrinho.' <br>Aqui tem o seu ID de transação: <b>'.$trx_id.'</b><br>Os seus produtos chegaram em 7-14 dias nesta morada: '.$morada.'</p>';
				$mail->Subject = 'LifePage - Pagamento Concluido';
				$mail->Body    = $bodyContent;
				if(!$mail->send()) {

				} else {
				 
				}
			//Enviar mail ao dono do site (eu)
				$mail2 = new PHPMailer;
				$mail2->isSMTP();                            // Set mailer to use SMTP
				$mail2->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
				$mail2->SMTPAuth = true;                     // Enable SMTP authentication
				$mail2->Username = 'lifepageshop123@gmail.com'; // your email id
				$mail2->Password = 'rikoku11'; // your password
				$mail2->SMTPSecure = 'tls';                  
				$mail2->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
				$mail2->setFrom('lifepageshop123@gmail.com', 'LifePage');
				$mail2->addAddress('lifepageshop123@gmail.com');   // Add a recipient
				$mail2->isHTML(true);  // Set email format to HTML

				$bodyContent = '<h1>O utilizador '.$sessao.' com a morada ('.$morada.'), comprou itens na Loja:</h1>';
				$bodyContent .= '<p>Compras: '.$carrinho.'<br>ID de transação: <b>'.$trx_id.'</b><br>Para veres mais informações do utilizador carrega <a href="https://developer.paypal.com/developer/accounts/">aqui</a>.</p>';
				$mail2->Subject = 'LifePage - Pagamento Concluido';
				$mail2->Body    = $bodyContent;
				if(!$mail2->send()) {

				} else {
				  
				}

			}
		}
	}
?>
<center><h1 style="font-size: 60px; color: green;">Sucesso</h1>
	<p style="font-size: 30px;">A sua encomenda foi listada.</p><br><br>
	<p style="font-size: 30px;">Numero de transação: <?php echo $trx_id; ?></p>
	<p>Foi enviado um email para <?php echo $email_user; ?> com mais detalhes</p><br><br>
	<?php 
	unset($_SESSION['cart']);
	mysqli_query($link, "DELETE FROM carrinho WHERE user_id=(SELECT id FROM users WHERE id='$id')");
	include 'footer.php';
	}
	?>