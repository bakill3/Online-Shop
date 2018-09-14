<!--
TRABALHO PAP
LOJA - ONLINE
FEITO POR GABRIEL BRANDÃO
2017/2018
-->
<?php
$titulo_pagina = ucfirst(pathinfo($_SERVER['SCRIPT_FILENAME'], PATHINFO_FILENAME)); // NOME DA PAGINA ATUAL ABERTA PARA SER CHAMADA NO TITULO 
include_once 'phpmailer/PHPMailerAutoload.php'; //LIVRARIA PHPMAILER
header('Content-type: text/plain; charset=utf-8'); //UTF8
include('trabalho.php'); // INCLUSÃO DA PROGRAMÇÃO DE UMA GRANDE PARTE DO SITE
$output = ''; //VAR CHAMADA LINHA 288
$query = "SELECT * FROM products"; //VAR CHAMADA LINHA 301

$result = mysqli_query($link, $query);
if (!mysqli_query($link, $query)) {
	echo("Error description: " . mysqli_error($link));
}
function no_login() { //FUNÇÃO PARA REDIRECIONAR PARA A LOJA
	echo "<script>window.location.href = 'loja';</script>";
}
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
}
?>
<!DOCTYPE html>
<html>

<head>
	<base href="<?php echo $url; ?>">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="favicon.ico">
	<title><?php
	if ($titulo_pagina == "Product") {
		$id_prod = mysqli_real_escape_string($link, $_GET['id']);
		$busca_titulo = mysqli_query($link, "SELECT p_name FROM products WHERE id='$id_prod'");
		$busca_titulo_info = mysqli_fetch_assoc($busca_titulo);
		$nome_do_produto_titulo = $busca_titulo_info['p_name'];
		echo "Produto - ". $nome_do_produto_titulo;
	} elseif ($titulo_pagina == "Register") {
		echo "LifePage - Registo";
	} elseif ($titulo_pagina == "Settings") {
		echo "LifePage - Definições";
	} elseif ($titulo_pagina == "Mudar_pass") {
		echo "LifePage - Alterar Password";
	} else {
		echo "LifePage - ". $titulo_pagina; 
	}
	 
	 ?></title>
	<link rel="stylesheet" href="dist/aos.css" /> <!-- INCLUIR LIVRARIA AOS PARA ANIMAÇÕES -->
	<script src="jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css"> <!-- INCLUIR LIVRARIA BOOTSTRAP 3.0 PARA MELHORAR O DESEMPENHO E DESIGN -->
	<link rel="stylesheet" type="text/css" href="assets/css/user.css"> <!-- HEADER E FOOTER / BOOTSTRAP -->
	<link rel="stylesheet" type="text/css" href="css/style.css"> <!-- CSS Geral  -->
	<link rel="stylesheet" type="text/css" href="assets/bootstrap/fonts/font-awesome.min.css"> <!-- FONTE -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie"> <!-- FONTE -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,400i,500i,700i,900i" rel="stylesheet"> <!-- FONTE -->
	<link href="https://fonts.googleapis.com/css?family=Work+Sans" rel="stylesheet"> <!-- FONTE -->
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'> <!-- FONTE -->
	<link href="fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">

	

</head>

<body style="background-color: white;">
	<div id="pesquia_modelo">
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">

				<?php /* Conteudo */ ?>
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Carrinho</h4>
					</div>
					<div class="modal-body">



						<?php  
						if (isset($sessao)) {
						$pp_checkout_btn = ''; 
						$product_id_array = '';
							$sql_carrinho = "SELECT * FROM carrinho INNER JOIN users ON carrinho.user_id=users.id WHERE carrinho.user_id = (SELECT id FROM users WHERE username='$sessao')";
							$sql_select_carrinho = mysqli_query($link, $sql_carrinho) or die(mysqli_error($link));
							$resultado_carrinho = mysqli_num_rows($sql_select_carrinho);

							$total_final = 0;
							$carrinho_num = 0;
							$i = 0; 
							if ($resultado_carrinho > 0) {
							?>
							<div class="table-responsive" style="background-color: white;">  
									<table class="table table-bordered">  
										<tr> 
											<th width="30%">Nome do produto</th>  
											<th width="10%">Quantidade</th>  
											<th width="15%">Preço</th>  
											<th width="14%">Total</th>   
											<th width="5%">Remover</th>  
										</tr>  
							<?php
								while ($row = mysqli_fetch_array($sql_select_carrinho)) {
									$carrinho_id = $row['carrinho_id'];
									$nome_do_produto = $row['nome_do_produto'];
									$preco_do_produto = $row['preco_do_produto'];
									$quantidade = $row['quantidade'];
									$product_id = $row['product_id'];
									$user_id = $row['user_id'];
									$busca_stock = mysqli_query($link, "SELECT stock FROM products WHERE id='$product_id'");
									$info_stock = mysqli_fetch_assoc($busca_stock);
									$stock = $info_stock['stock'];

									$carrinho_num++;
									$total = $quantidade * $preco_do_produto;

									$x = $i + 1;
									//SE QUISER EDITAR QUANTIDADE
									if (isset($_POST['alterar_quanti'])) {
										$sessao = $_SESSION['username'];
										$quanti = htmlspecialchars(mysqli_real_escape_string($link, $_POST['quantidade_atualizada']));
									  	$prod_id = htmlspecialchars(mysqli_real_escape_string($link, $_POST['id_do_prod']));

									  	if ($quanti < 1 || $quanti > $stock) {
									  		$quanti = 1;
									  	}

									  	mysqli_query($link, "UPDATE carrinho SET quantidade='$quanti' WHERE product_id=(SELECT id FROM products WHERE id='$prod_id') AND user_id=(SELECT id FROM users WHERE username='$sessao')") or die(mysqli_error($link));
									  	no_login();
									}

							?>
							<tr>  
								<td><?php echo $nome_do_produto; ?></td>  
								<td>
									<form method="POST">
										<div class="input-group">
											<input type="hidden" name="id_do_prod" value="<?php echo $product_id; ?>">
											<input type="number" name="quantidade_atualizada" min="1" max="<?php echo $stock; ?>" style="width: 90%;" class="form-control" value="<?php echo $quantidade; ?>">
											
											<div class="input-group-btn">
												<button type="submit" name="alterar_quanti" style="width: 100%;" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
											</div>
										</div>
										
									</form>
								</td>  
								<td><?php echo $preco_do_produto; ?> €</td>  
								<td><?php echo number_format($total, 2); ?> €</td>  
								<td style="text-align: center; vertical-align: middle;"><a href="loja/delete/id/<?php echo $product_id; ?>"><button class="btn btn-danger btn-lg"><i class="fas fa-trash"></i></button></a>
								</td>


							</tr>  
							<?php
								$total_final = $total_final + ($quantidade * $preco_do_produto);
								$i++; 
								}
							?>
							<tr>  
								<td colspan="3" align="right">Total:</td>  
								<td align="right" colspan="3"><?php echo number_format($total_final, 2); ?> €</td>  
							</tr>

							<?php 

							?>  
								</table>  
							</div>   
							<?php 
							if (isset($_SESSION['username'])) {

							?>
							<?php
								echo '<a href="pagamento_final.php"><button type="submit" class="btn btn-block btn-lg btn-success"><span class="glyphicon glyphicon-credit-card"></span> Pagamento</button>
							</form></a>';
							} else {
								?>
								<td><a href="login" class="btn btn-block btn-lg btn-info">Login para pagamento</a></td>
								<?php 
							}
	// SE NAO HOUVER PRODUTOS ENTAO
						} else {
							echo "<center><h3>Não tem produtos no carrinho</h3></center>";
						}
					} else { //SE NAO TIVER LOGIN VAI PARA UM CARRINHO COM SESSOES
					?>
		               <?php   
		               if(!empty($_SESSION["cart"]))  
		               {  
		               	$carrinho_num = 0;
		               	?>

			               	<div class="table-responsive">  
			               <table class="table table-bordered">  
			                <tr>  
			                 <th width="30%">Nome do produto</th>  
			                 <th width="10%">Quantidade</th>  
			                 <th width="15%">Preço</th>  
			                 <th width="15%">Total</th>  
			                 <th width="5%">Ação</th>  
			               </tr>  
		               	 <?php
		                 $total = 0;  
		                 foreach($_SESSION["cart"] as $keys => $values)  
		                 { 
		                  $carrinho_num++;
		                  if ($values["item_quantity"] > $values["max_stock"]) { $values["item_quantity"] = $values["max_stock"]; }
		                  if ($values["item_quantity"] < 1) { $values["item_quantity"]= 1; }
		                  if ($values["item_quantity"] == "") { $values["item_quantity"] = 1; } 
		                  ?>  
		                  <tr>  
		                   <td><?php echo $values["item_name"]; ?></td>  
		                   <td><?php echo $values["item_quantity"]; ?></td>  
		                   <td><?php echo $values["item_price"]; ?> €</td>  
		                   <td><?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?> €</td>  
		                   <td><a href="loja.php?action=delete&id=<?php echo $values["item_id"]; ?>"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a></td>  
		                 </tr>  
		                 <?php  
		                 $total = $total + ($values["item_quantity"] * $values["item_price"]);  
		               }  
		               ?>  
		               <tr>  
		                 <td colspan="3" align="right">Total</td>  
		                 <td align="right" colspan="2"><?php echo number_format($total, 2); ?> €</td>
		                </tr>
		              </table>  
		        	 </div>  
		                   <td><a href="login" class="btn btn-block btn-lg btn-info">Login para continuar</a></td> 
		               <?php  
		             } else {
		             	echo "<center><h3>Não tem produtos no carrinho</h3></center>";
		             }  
		             ?>    
 
		     <?php
					}
					?>

				</tr>  
			</table>
		</div>








		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
		</div>
	</div>

</div>
</div> </div>


<nav class="navbar navbar-default custom-header">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand navbar-link" href="loja"> <img src="imagens\logo2.png" width="180" height="50" ></a>
		</div>
		<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav links">
				<li role="presentation"><a href="loja" style="font-size: 130%;">Loja <i class="fas fa-home"></i></a></li>
				<li role="presentation"><a href="ajuda" style="font-size: 130%;"> Ajuda <i class="far fa-question-circle"></i></a></li>
				<li role="presentation"><a href="sobre" style="font-size: 130%;"> Sobre <i class="fas fa-info"></i></a></li>
				<li role="presentation" style="padding: 2% 0%;">
				<script>
				function pesquisar() {
					    document.onkeydown=function(evt){
					        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
					        if(keyCode == 13)
					        {
					            document.pesquisa_form.submit();
					        }
					    }
				}
				</script>
				<form name="pesquisa_form" method="POST" autocomplete="off">
					<div class="search">
						<span class="fa fa-search"></span>
						<input id="search_text" placeholder="Pesquisar..." name="pesquisa_txt" onblur="pesquisar(this);">
					</div>
				</form>
					<div style="position: absolute; z-index: 2;" id="result"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						load_data();
						function load_data(query)
						{
							$.ajax({
								url:"fetch2.php",
								method:"post",
								data:{query:query},
								success:function(data)
								{
									$('#result').html(data);
								}
							});
						}

						$('#search_text').keyup(function(){
							var search = $(this).val();
							if(search != '')
							{
								load_data(search);
							}
							else
							{
								load_data();            
							}
						});
					});
				</script>
				</ul>
			</li>
		</ul>
		<ul class="nav navbar-nav navbar-right" style="position: absolute; top: 25%; right: 3%;">


			<ul class="nav navbar-nav links">
				<li role="presentation">
					<div class="dropdown">
						<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Carrinho <span class='glyphicon glyphicon-shopping-cart'></span><sup><span class="label label-danger"><?php if(isset($carrinho_num) && $carrinho_num != 0) { echo $carrinho_num; } ?></span></sup></button>
						</button>
						<div id="myDropdown" class="dropdown-content">
							<input type="text" placeholder="Pesquisar.." id="myInput" onkeyup="filterFunction()">
							


						</div>
					</div>


				</li>
			</ul>




			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span>
					<?php  
					if (isset($sessao)) {
						$sql2 = "SELECT foto_perfil FROM users WHERE username='$sessao';";
						$result = mysqli_query($link, $sql2);  
						if(mysqli_num_rows($result) > 0)  {
							while($row = mysqli_fetch_array($result))  {  
								$foto_perfil = $row['foto_perfil'];
							}
						}
						?>
						<img src="<?php echo $foto_perfil; ?>" class="dropdown-image">
						<?php
					} else {
						?>
						<img src="assets/img/avatar.jpg" class="dropdown-image">
						<?php
					}
					?>

				</a>
				<ul class="dropdown-menu dropdown-menu-right" role="menu">
					<?php  if (isset($sessao)) : ?>
						<li><a href='settings'><i class="fas fa-cog"></i> Definições</a></li>
						<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
						<?php 
						$sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=2";
						$results_admin = mysqli_query($link, $sql_login_admin);
						if (mysqli_num_rows($results_admin) == 1) { ?>
						<li><a href="painel"><i class="fas fa-wrench"></i> Admin</a></li>
						<?php } ?>
					<?php else : ?>
						<li><a href='login'><i class="fas fa-sign-in-alt"></i> Login</a></li>
						<li><a href="registo"><i class="fas fa-user-plus"></i></i> Registo </a></li>
					<?php endif ?>


				</ul>
			</li>
		</ul>
	</div>
</div>
</nav>
<?php if ($titulo_pagina != "Loja") { ?>
<a href="loja" style="position: fixed; z-index: 30; left: 1%; top: 14%;" class="btn btn-primary"><i class="far fa-arrow-alt-circle-left"></i> Voltar á Loja</a>
<?php } ?>
<?php echo $alerta; ?>