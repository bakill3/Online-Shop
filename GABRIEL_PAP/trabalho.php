<?php
/*
PÁGINA TRABALHO.PHP: Esta página contem maior parte da programação por detrás dos formulários do site e muito mais...
*/
//INCLUIR LIGAÇÃO À BASE DE DADOS
include('ligar_db.php');
//DEFINIR QUAL É O MEU URL E O NOME DA MINHA PAGINA
$url = "http://$_SERVER[HTTP_HOST]";
$pagina = basename($_SERVER['PHP_SELF']);
//----
$alerta = "";
session_start();
$erros = array();
$_SESSION['success'] = "";

if (isset($_GET['logout'])) {
	unset($_SESSION['username']);
	header("location: loja");
}

//REGISTO
if (isset($_POST['botao_registo'])) {
	$email = mysqli_real_escape_string($link, $_POST['email']);
	$nome = mysqli_real_escape_string($link, $_POST['nome']);
	$idade = mysqli_real_escape_string($link, $_POST['idade']);
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$morada = mysqli_real_escape_string($link, $_POST['morada']);
	$pass1 = mysqli_real_escape_string($link, $_POST['password1']);
	$pass2 = mysqli_real_escape_string($link, $_POST['password2']);
	$erro = "";

	$sql_select="SELECT * FROM users";
	$resultado= mysqli_query($link, $sql_select);
	$registo=mysqli_fetch_assoc($resultado);
	$email_db = $registo['email'];
	$nome_db = $registo['nome'];
	$idade_db = $registo['idade'];
	$username_db = $registo['username'];
	$morada_db = $registo['morada'];
	$pass_db = $registo['password'];
	$len_pass = mb_strlen($pass1, 'Utf-8');
	$len_nome = mb_strlen($nome, 'Utf-8');


	if (empty($email) OR empty($nome) OR empty($idade) OR empty($username) OR empty($pass1) OR empty($pass2) OR empty($morada)) {
		array_push($erros, "Tem de preencher todos os dados!");
	}
	elseif ($idade < 18) {
		array_push($erros, "Tem de ser maior de idade para se registar.<br>") ;
	}
	elseif ($email == $email_db) {
		array_push($erros, "Esse email já está em uso!");
	}
	elseif ($username == $username_db) {
		array_push($erros, "Esse username já está em uso!");
	} 
	elseif ($morada == $morada_db) {
		array_push($erros, "Essa morada já existe");
	}
	elseif ($len_pass <= 5) {
		array_push($erros, "A sua password deve ter mais de 5 carateres");
	}
	elseif ($len_nome < 3) {
		array_push($erros, "O seu nome tem de ter mais de 3 carateres");
	}
	elseif ($pass1 != $pass2) {
		array_push($erros, "As suas passwords não sao iguais");
	}
	if (count($erros) == 0) {
		/*
		$sql2 = "INSERT INTO users (role_id, email, nome, idade, username, password) 
		VALUES ((SELECT role_id FROM roles WHERE role_id=1), '$email', '$nome', '$idade', '$username', '$pass1');
		";

		mysqli_query($link, $sql2) or die(mysqli_error($link));
		header('location: login');
		*/
		$pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
		$digitos = 4;
		$token = rand(pow(10, $digitos-1), pow(10, $digitos)-1);
		$sql2 = "INSERT INTO users (role_id, email, nome, idade, username, password, morada, token)
		VALUES ((SELECT role_id FROM roles WHERE role_id=1), '$email', '$nome', '$idade', '$username', '$pass_hash', '$morada', '$token');";

		mysqli_query($link, $sql2) or die(mysqli_error($link));

		$mail = new PHPMailer;
		$mail->isSMTP();                            // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                     // Enable SMTP authentication
		$mail->Username = 'lifepageshop123@gmail.com'; // your email id
		$mail->Password = 'rikoku11'; // your password
		$mail->SMTPSecure = 'tls';                  
		$mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
		$mail->setFrom('lifepageshop123@gmail.com', 'LifePage');
		$mail->addAddress($email);   // Add a recipient
		$mail->isHTML(true);  // Set email format to HTML

		$bodyContent = '<h1>Registo com Sucesso</h1>';
		$bodyContent .= '<p>O seu registo foi completo. Ative agora a sua <a href="http://lifepage.zapto.org/ativar.php?token='.$token.'">Conta</a>';
		$mail->Subject = 'LifePage - Registo Concluido';
		$mail->Body    = $bodyContent;
		if(!$mail->send()) {

		} else {
			
		}
		$alerta = '<div class="alert alert-info" id="alerta">
		<strong>Ative a sua conta através do mail enviado</strong>
		</div>  <script>myvar = setInterval(slidecima, 3000);
		function slidecima() {
		$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
		$("#alerta").slideUp(500);
		});
		window.clearInterval(myvar);

		}
		</script>'; 
	} else {
		foreach ($erros as $error) {
			$alerta = '<div class="alert alert-warning" id="alerta">
				<strong>'.$error.'</strong>
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



//LOGIN
if (isset($_POST['botao_login'])) {
	$username = mysqli_real_escape_string($link, $_POST['username']);
	$pass = mysqli_real_escape_string($link, $_POST['password']);



		$sql_login = "SELECT * FROM users WHERE username='$username'";
		$results = mysqli_query($link, $sql_login);
		$buscap = mysqli_fetch_assoc($results);
		$pass_db = $buscap['password'];

		if (mysqli_num_rows($results) == 1 && password_verify($pass, $pass_db)) {
			$ativado_resultados = mysqli_query($link, "SELECT * FROM users WHERE username='$username' AND activate = 1");
			if (mysqli_num_rows($ativado_resultados) == 1) {
				if (isset($_SESSION['cart'])) {
					$count = count($_SESSION["cart"]);
					if ($count > 0) {
						foreach($_SESSION["cart"] as $keys => $values)  { 
							$id_do_produto = $values['item_id'];
							$nome_do_produto = $values["item_name"];
							$quantidade = $values["item_quantity"];
							$preco = $values["item_price"];
							$stock = $values["max_stock"];
							$sql = "SELECT * FROM carrinho WHERE product_id=(SELECT id FROM products WHERE id='$id_do_produto') AND user_id=(SELECT id FROM users WHERE username='$username');";
							$sql_carrinho_login = mysqli_query($link, $sql);
							if (mysqli_num_rows($sql_carrinho_login) == 1) {
								$sql_el = "DELETE FROM carrinho WHERE product_id=(SELECT id FROM products WHERE id='$id_do_produto') AND user_id=(SELECT id FROM users WHERE username='$username');";
								mysqli_query($link, $sql_el) or die(mysqli_error($link));
							} 
							$sql_inserir_carr = "INSERT INTO carrinho (nome_do_produto, preco_do_produto, quantidade, product_id, user_id) VALUES ('$nome_do_produto', '$preco', '$quantidade', (SELECT id FROM products WHERE id='$id_do_produto'), (SELECT id FROM users WHERE username='$username'))";
							mysqli_query($link, $sql_inserir_carr) or die(mysqli_error($link));

							unset($_SESSION['cart']);
							$_SESSION['username'] = $username;
							echo "<script>window.location.href='loja'</script>";
						}
					} else {
						unset($_SESSION['cart']);
						$_SESSION['username'] = $username;
						header('location: loja');
					}
				}
				else {
					$_SESSION['username'] = $username;
					$_SESSION['success'] = "Já deu login!";
					header('location: loja');
				}
			} else {
				$alerta = '<div class="alert alert-info" id="alerta">
					<strong>Ative a sua conta através do mail enviado</strong>
					</div>  <script>myvar = setInterval(slidecima, 3000);
					function slidecima() {
					$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
					$("#alerta").slideUp(500);
					});
					window.clearInterval(myvar);

					}
					</script>'; 
			}
		} else {
			$alerta = '<div class="alert alert-warning" id="alerta">
					<strong>Email/Password Incorretos</strong>
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



//------------------------------------------------------------------------------------------------------------------------------------------------------------
//LOJA - SE ADICIONAR
if(isset($_POST["add_to_cart"]))  {   
	if (isset($_SESSION['username'])) { //ACABA 235
		//SESSAO
		$sessao = $_SESSION['username'];
		//FORM POSTS:
		$product_id = mysqli_real_escape_string($link, $_POST['product_id']);

		$p_name = mysqli_real_escape_string($link, $_POST['p_name']);
		$price = mysqli_real_escape_string($link, $_POST['price']);
		if (isset($_POST['price_descontado'])) {
			$price_descontado = mysqli_real_escape_string($link, $_POST['price_descontado']);
		}
		$quantidade = mysqli_real_escape_string($link, $_POST['quantity']);
		$stock = mysqli_real_escape_string($link, $_POST['stock']);

		if ($quantidade < 1) {
			$quantidade = 1;
		}

		// VALIDAÇÃO/SEGURANÇA
		$sql = "SELECT * FROM products WHERE id='$product_id';";
		$sql_products = mysqli_query($link, $sql);
		$products_loop = mysqli_num_rows($sql_products);
		if ($products_loop > 0) { //ACABA LINHA 222
			while($row = mysqli_fetch_array($sql_products)) {
				$p_name_v = $row['p_name'];
				$price_v = $row['price'];
				$price_v_d = $row['price_descontado'];
				$stock_v = $row['stock'];
				$price_descontado_v = $row['price_descontado'];
		}
		if (isset($price_descontado)) {
			if ($price == $price_descontado && $price_descontado == $price_descontado_v) {
				$price_v = $price_descontado;
			}
		}
			//--------------------------------------------
			if ($p_name_v != $p_name || $price_v != $price || $stock_v != $stock || $quantidade > $stock) {
				$alerta = '<div class="alert alert-warning" id="alerta">
				<strong>Continua a tentar, script kiddie!</strong>
				</div>  <script>myvar = setInterval(slidecima, 3000);
				function slidecima() {
				$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
				$("#alerta").slideUp(500);
				});
				window.clearInterval(myvar);

				}
				</script>'; 
			} else {
				//DATA
				date_default_timezone_set('Europe/Lisbon');
				$date = date('Y-m-d H:i:s');
				//SE HOUVER USER:
				$sql_usrs = "SELECT * FROM users WHERE username='$sessao';";
				$sql_users = mysqli_query($link, $sql_usrs);
				$users_loop = mysqli_num_rows($sql_users);
				if ($users_loop > 0) {
					while($row = mysqli_fetch_array($sql_users)) {
						$user_id = $row['id'];
						$role_id = $row['role_id'];
						$email = $row['email'];
						$nome = $row['nome'];
						$idade = $row['idade'];
						$username = $row['username'];
						$password = $row['password'];
						$foto_perfil = $row['foto_perfil'];
					}
					// SELECIONAR
					$sql_carro = "SELECT * FROM carrinho WHERE user_id = (SELECT id FROM users WHERE username='$sessao')";
					$sql_select_carro = mysqli_query($link, $sql_carro) or die(mysqli_error($link));
					$conta_carro = mysqli_num_rows($sql_select_carro);
					if ($conta_carro > 0) {
						while ($dados_carro = mysqli_fetch_array($sql_select_carro)) {
							$product_id_v = $dados_carro['product_id'];
							$quantidade_v = $dados_carro['quantidade'];
						}
					} else {
						$product_id_v = "";
					}
					$dados_carro = mysqli_fetch_assoc($sql_select_carro);
					if ($product_id_v == $product_id) {
						$nova_quant = $quantidade_v + $quantidade;
						$sql = "UPDATE carrinho SET quantidade='$nova_quant' WHERE product_id='$product_id' AND user_id=(SELECT id FROM users WHERE username='$sessao')";
						$sql_query = mysqli_query($link, $sql) or die(mysqli_error($link));
						$alerta = '<div class="alert alert-warning" id="alerta">
						<strong>Quantidade atualizada!</strong>
						</div>  <script>myvar = setInterval(slidecima, 3000);
							function slidecima() {
			    				$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
								$("#alerta").slideUp(500);
								});
								window.clearInterval(myvar);

							}
							</script>'; 
					} else {
						$sql = "INSERT INTO carrinho (nome_do_produto, preco_do_produto, quantidade, product_id, user_id) 
						VALUES ('$p_name', '$price', '$quantidade', (SELECT id FROM products WHERE id='$product_id'), (SELECT id FROM users WHERE id='$user_id'));";
						$sql_query = mysqli_query($link, $sql) or die(mysqli_error($link));
						$alerta = '<div class="alert alert-success" id="alerta">   
						<strong>Successo!</strong> O produto foi adicionado ao carrinho
						</div><script>myvar = setInterval(slidecima, 3000);
						function slidecima() {
						$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
						$("#alerta").slideUp(500);
						});
						window.clearInterval(myvar);
						}
						</script>
						'; 
					}

				} else { //SENAO ENCONTRAR USER (ERRO)
					$alerta = '<div class="alert alert-warning" id="alerta">
					<strong>Occoreu um erro</strong>
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
		} else { //SE NÃO ENCONTRAR O ID DO PRODUTO SELECIONADO
				$alerta = '<div class="alert alert-warning" id="alerta">
				<strong>Continua a tentar, script kiddie!</strong>
				</div>  <script>myvar = setInterval(slidecima, 3000);
				function slidecima() {
				$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
				$("#alerta").slideUp(500);
				});
				window.clearInterval(myvar);

				}
				</script>'; 
			}
		} else { //SENAO ENCONTRAR ESSE USER 
					if(isset($_SESSION["cart"]))  {  
						$item_array_id = array_column($_SESSION["cart"], "item_id");
						if(!in_array($_GET["id"], $item_array_id))  
						{  
									$id_do_produto_sess = mysqli_real_escape_string($link, $_GET["id"]);
									$nome_do_produto_sess = mysqli_real_escape_string($link, $_POST["p_name"]);
									$preco_do_produto_sess = mysqli_real_escape_string($link, $_POST["price"]);
									$quantidade_do_produto_sess = mysqli_real_escape_string($link, $_POST["quantity"]);
									$stock_do_produto_sess = mysqli_real_escape_string($link, $_POST["stock"]);
									if (isset($_POST['price_descontado'])) {
										$price_descontado = mysqli_real_escape_string($link, $_POST['price_descontado']);
									}
									// VALIDAÇÃO/SEGURANÇA
									$sql = "SELECT * FROM products WHERE id='$id_do_produto_sess';";
									$sql_products = mysqli_query($link, $sql);
									$products_loop = mysqli_num_rows($sql_products);
									if ($products_loop > 0) { 
										while($row = mysqli_fetch_array($sql_products)) {
											$p_name_v = $row['p_name'];
											$price_v = $row['price'];
											$stock_v = $row['stock'];
											$price_descontado_v = $row['price_descontado'];
									}
									
									if (isset($price_descontado)) {
										if ($price == $price_descontado && $price_descontado == $price_descontado_v) {
											$price_v = $price_descontado;
										}
									}
		
										//--------------------------------------------
										if ($p_name_v != $nome_do_produto_sess || $price_v != $preco_do_produto_sess || $stock_v != $stock_do_produto_sess) {
											$alerta = '<div class="alert alert-warning" id="alerta">
											<strong>Continua a tentar, script kiddie!</strong>
											</div>  <script>myvar = setInterval(slidecima, 3000);
											function slidecima() {
											$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
											$("#alerta").slideUp(500);
											});
											window.clearInterval(myvar);

											}
											</script>'; 
										} else {
									
											$count = count($_SESSION["cart"]);  
											$item_array = array(  
												'item_id'               =>     $id_do_produto_sess,  
												'item_name'               =>     $nome_do_produto_sess,    
												'item_price'          =>     $preco_do_produto_sess,  
												'item_quantity'          =>     $quantidade_do_produto_sess,  
												'max_stock'          =>     $stock_do_produto_sess 
											);  
											$_SESSION["cart"][$count] = $item_array;


											$alerta = '<div class="alert alert-success" id="alerta">   
											<strong>Successo!</strong> O produto foi adicionado ao carrinho
											</div><script>myvar = setInterval(slidecima, 3000);
												function slidecima() {
								    				$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
													$("#alerta").slideUp(500);
													});
													window.clearInterval(myvar);
												}
												</script>
												'; 
										}
									}
							
						} else {  
							$alerta = '<div class="alert alert-warning" id="alerta">
							<strong>O produto já foi adicionado!</strong>
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
					else  
					{  
									$id_do_produto_sess = mysqli_real_escape_string($link, $_GET["id"]);
									$nome_do_produto_sess = mysqli_real_escape_string($link, $_POST["p_name"]);
									$preco_do_produto_sess = mysqli_real_escape_string($link, $_POST["price"]);
									$quantidade_do_produto_sess = mysqli_real_escape_string($link, $_POST["quantity"]);
									$stock_do_produto_sess = mysqli_real_escape_string($link, $_POST["stock"]);
									// VALIDAÇÃO/SEGURANÇA
									$sql = "SELECT * FROM products WHERE id='$id_do_produto_sess';";
									$sql_products = mysqli_query($link, $sql);
									$products_loop = mysqli_num_rows($sql_products);
									if ($products_loop > 0) { 
										while($row = mysqli_fetch_array($sql_products)) {
											$p_name_v = $row['p_name'];
											$price_v = $row['price'];
											$stock_v = $row['stock'];
									}
										//--------------------------------------------
										if ($p_name_v != $nome_do_produto_sess || $price_v != $preco_do_produto_sess || $stock_v != $stock_do_produto_sess) {
											$alerta = '<div class="alert alert-warning" id="alerta">
											<strong>Continua a tentar, script kiddie!</strong>
											</div>  <script>myvar = setInterval(slidecima, 3000);
											function slidecima() {
											$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
											$("#alerta").slideUp(500);
											});
											window.clearInterval(myvar);

											}
											</script>'; 
										} else {
											$item_array = array(  
												'item_id'               =>     $id_do_produto_sess,  
												'item_name'               =>     $nome_do_produto_sess,    
												'item_price'          =>     $preco_do_produto_sess,  
												'item_quantity'          =>     $quantidade_do_produto_sess,  
												'max_stock'          =>     $stock_do_produto_sess 
											);  
											$_SESSION["cart"][0] = $item_array;  
										}
									}
					}  


				}
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------


//APAGAR PRODUTO
if(isset($_GET["action"]))  {  
	if($_GET["action"] == "delete")  {
		if (isset($_SESSION['username'])) {
			$product_id = mysqli_real_escape_string($link, $_GET['id']);
			$sessao = $_SESSION['username'];
			$sql_carrinho = "SELECT * FROM carrinho INNER JOIN users ON carrinho.user_id=users.id WHERE carrinho.user_id = (SELECT id FROM users WHERE username='$sessao')";
			$sql_select_carrinho = mysqli_query($link, $sql_carrinho) or die(mysqli_error($link));
			$resultado_carrinho = mysqli_num_rows($sql_select_carrinho);
			if ($resultado_carrinho > 0) {
				while ($row = mysqli_fetch_array($sql_select_carrinho)) {
					$user_id = $row['user_id'];
				}
				$sql_apagar = "DELETE FROM carrinho WHERE product_id=$product_id AND user_id=$user_id;";
				mysqli_query($link, $sql_apagar);
				$alerta = '<div class="alert alert-danger" id="alerta">
				O produto foi removido do carrinho
				</div>   <script>
				myvar = setInterval(slidecima, 3000);
				function slidecima() {
    				$("#alerta").fadeTo(2000, 500).slideUp(500, function(){
					$("#alerta").slideUp(500);
					});
					window.clearInterval(myvar);
				}				
				</script>'; 
			}
		} else {
			foreach($_SESSION["cart"] as $keys => $values)  {  
			if($values["item_id"] == $_GET["id"])  
			{  
				unset($_SESSION["cart"][$keys]);  
				$alerta = '<div class="alert alert-danger" id="alerta">
				O produto foi removido do carrinho
				</div>   <script>
				myvar = setInterval(slidecima, 3000);
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
	}
}

//SE RECUPERAR PASS
if (isset($_POST['botao_rec'])) {
		$email_rec = mysqli_real_escape_string($link, $_POST['email_rec']);
		$username_rec = mysqli_real_escape_string($link, $_POST['username_rec']);
		$query_rec = mysqli_query($link, "SELECT * FROM users WHERE email='$email_rec' AND username='$username_rec'");
		if (mysqli_num_rows($query_rec) == 1) {
			$busca_rec = mysqli_fetch_assoc($query_rec);
			$id_user_rec = $busca_rec['id'];
			//RANDOMIZAR O TOKEN OUTRA VEZ---------------------------------------
			$digitos_token = 4;
			$token = rand(pow(10, $digitos_token-1), pow(10, $digitos_token)-1);
			//-------------------------------------------------------------------
			//$_SESSION['last_time'] = time();
	        mysqli_query($link, "UPDATE users SET token='$token', recup='1' WHERE id='$id_user_rec'") or die(mysqli_error($link));
			$existe_email = 1;

			$mail = new PHPMailer;
			$mail->isSMTP();                            // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';              // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                     // Enable SMTP authentication
			$mail->Username = 'lifepageshop123@gmail.com'; // your email id
			$mail->Password = 'rikoku11'; // your password
			$mail->SMTPSecure = 'tls';                  
			$mail->Port = 587;     //587 is used for Outgoing Mail (SMTP) Server.
			$mail->setFrom('lifepageshop123@gmail.com', 'LifePage');
			$mail->addAddress($email_rec);   // Add a recipient
			$mail->isHTML(true);  // Set email format to HTML

			$bodyContent = '<h1>Recuperação de Password</h1>';
			$bodyContent .= '<p>Foi enviado um pedido para mudar a password. Pode alterar a sua password <a href="http://lifepage.zapto.org/pass_nova.php?token='.$token.'">aqui</a>.<br>Se isto foi engano aceda <a href="http://lifepage.zapto.org/pass_nova.php?token='.$token.'&erro=1">aqui</a>';
			$mail->Subject = 'LifePage - Recuperacao de Password';
			$mail->Body    = $bodyContent;
			if(!$mail->send()) {

			} else {
				
			}
		} else {
			$alerta = '<div class="alert alert-warning" id="alerta">
					<strong>Email/Password Incorretos</strong>
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

if (isset($_POST['pedido_resolvido'])) {

	$id_pedido_escondido = mysqli_real_escape_string($link, $_POST['pedido_id']);
	mysqli_query($link, "DELETE FROM orders WHERE order_id='$id_pedido_escondido'") or die($link);
	echo "<script>window.location.href='painel'</script>";
} 


//ELIMINAR COMENTÁRIOS
if (isset($_POST['botao_eliminar'])) {
	$sessao = $_SESSION['username'];
	$rate_id = mysqli_real_escape_string($link, $_POST['rate_id']);
	$produto_id = mysqli_real_escape_string($link, $_POST['hidden_product_id']);


	// BUSCAR O USER ID DAS RATINGS -- VERIFICAÇÂO/SEGURANÇA
	$user_busca_v = mysqli_query($link, "SELECT user_id FROM products_rating WHERE rate_id='$rate_id'");
	$info_busca_v = mysqli_fetch_assoc($user_busca_v);
	$id_user_v = $info_busca_v['user_id'];

	// BUSCAR O USER ID DOS USERS (ESTE É VALIDO PARA DEPOIS COMPARAR COM O RECEBIDO)
	$user = mysqli_query($link, "SELECT id FROM users WHERE username='$sessao'");
	$info_busca = mysqli_fetch_assoc($user);
	$id_user = $info_busca['id'];

	if ($id_user_v == $id_user) { //SE O UTILIZADOR NAO ANDOU A FAZER PORCARIA
		$apagar = "DELETE from products_rating where rate_id='$rate_id'";
		mysqli_query($link, $apagar);


		$avg_rating = "SELECT AVG(rate) AS rate_avg FROM products_rating WHERE product_id='$produto_id';";
		$avg_query = mysqli_query($link, $avg_rating);
		$data = $avg_query->fetch_assoc();
		$avg_rating = $data['rate_avg'];
		$avg_criticas = number_format((float)$avg_rating, 1, '.', '');

		$sql3 = "UPDATE products SET avg_rating = '$avg_criticas' WHERE id = '$produto_id';";
		mysqli_query($link, $sql3);


		//echo '<script>window.location="'.$produto_id.'"</script>';
	} else {
		
	}

}

//PESQUISA
if (isset($_POST['pesquisa_txt'])) {
	$pesquisa_txt = mysqli_real_escape_string($link, $_POST['pesquisa_txt']);
	echo "<script>window.location.href='/loja?s=".$pesquisa_txt."'</script>";
}

//PROMOÇÃO
			if (isset($_POST['adicionar_promocao'])) {
				$desconto_atualizado = mysqli_real_escape_string($link, $_POST['desconto']);
				$promocao_atualizado = mysqli_real_escape_string($link, $_POST['promocao_atualizado']);
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

				$data_atual = date("Y-m-d H:i");
				$data = strtotime($_POST['data']);

				$nova_data = date('Y-m-d H:i', $data);



				$promocao_len = strlen($promocao_atualizado);
				$tipo = mysqli_real_escape_string($link, $_POST['tipo']);

				if ($tipo == "produto") {
				
					$produto_atualizado = mysqli_real_escape_string($link, $_POST['produto_tt']);
					$query = "SELECT * FROM promocoes WHERE id_produto=(SELECT id FROM products WHERE id='$produto_atualizado')";
					$verfica_prod = mysqli_query($link, $query);
			

					if ($promocao_len < 50 && $promocao_len > 5 && mysqli_num_rows($verfica_prod) == 0) {
						if ($destaque_atualizado == 1) {
							mysqli_query($link, "UPDATE promocoes SET destaque='0' WHERE destaque='1'");
						}

						$verfica_prod_p = mysqli_query($link, "SELECT * FROM products WHERE id=(SELECT id FROM products WHERE id='$produto_atualizado')");

						while ($verfica_prod_info = mysqli_fetch_array($verfica_prod_p)) {
							$id_atual = $verfica_prod_info['id'];
							$categoria_id = $verfica_prod_info['categoria_id'];
							mysqli_query($link, "INSERT INTO promocoes (id_produto, promocao, ativado, destaque, desconto, categoria_id, tipo, data) VALUES ((SELECT id FROM products WHERE id='$produto_atualizado'), '$promocao_atualizado', '$ativado_atualizado', '$destaque_atualizado', '$desconto_atualizado', (SELECT categoria_id FROM categorias   WHERE categoria_id='$categoria_id'), 'produto', '$nova_data');") or die(mysqli_error($link));
						


							$preco = $verfica_prod_info['price'];

							$preco_descontado = $preco * $desconto_atualizado;

							$preco_total = $preco - $preco_descontado;

							mysqli_query($link, "UPDATE products SET price_descontado='$preco_total' WHERE id='$id_atual'");
						}
					}

				} elseif ($tipo == "categoria_p") {
					$categoria = mysqli_real_escape_string($link, $_POST['categoria_tt']);
					$verfica_cat = mysqli_query($link, "SELECT * FROM promocoes WHERE categoria_id=(SELECT categoria_id FROM categorias WHERE categoria_id='$categoria')");

					if ($promocao_len < 50 && $promocao_len > 5 && mysqli_num_rows($verfica_cat) == 0) {
						if ($destaque_atualizado == 1) {
							mysqli_query($link, "UPDATE promocoes SET destaque='0' WHERE destaque='1'");
						}

						$verfica_cat_p = mysqli_query($link, "SELECT * FROM products WHERE categoria_id=(SELECT categoria_id FROM categorias WHERE categoria_id='$categoria')");

						while ($verfica_cat_info = mysqli_fetch_array($verfica_cat_p)) {
							$id_prod_v = $verfica_cat_info['id'];
							mysqli_query($link, "INSERT INTO promocoes(categoria_id, promocao, ativado, destaque, desconto, id_produto, tipo, data) VALUES((SELECT categoria_id FROM categorias WHERE categoria_id='$categoria'), '$promocao_atualizado', '$ativado_atualizado', '$destaque_atualizado', '$desconto_atualizado', (SELECT id FROM products WHERE id='$id_prod_v'), 'categoria', '$nova_data')") or die(mysqli_error($link));
						
								$preco = $verfica_cat_info['price'];

								$preco_descontado = $preco * $desconto_atualizado;

								$preco_total = $preco - $preco_descontado;
								//echo "<pre>";
								//echo "ID: ". $id_prod_v;
								//echo "COM DESCONTO:". $preco_total;
								//echo "</pre>";
								//cho $preco_descontado;
								mysqli_query($link, "UPDATE products SET price_descontado='$preco_total' WHERE id='$id_prod_v'");
								mysqli_query($link, "UPDATE categorias SET feat='1' WHERE categoria_id='$categoria'");
						


						}

						
					}
				}

				echo "<script>window.location.href = '/painel';</script>";
			}
?>