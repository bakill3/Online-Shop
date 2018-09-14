<?php include ('header.php') ?>
<?php
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=2";
	$results_admin = mysqli_query($link, $sql_login_admin);
	if (mysqli_num_rows($results_admin) == 1) {
		$sessao = $_SESSION['username'];
		$sql = mysqli_query($link, "SELECT * FROM users");
		$buscardados = mysqli_num_rows($sql);

		$sql_product = mysqli_query($link, "SELECT * FROM products");
		$buscardados_products = mysqli_num_rows($sql_product);

		//Se adicionar produto
		if (isset($_POST['adicionar_produto'])) {
			$nome = mysqli_real_escape_string($link, $_POST['nome_do_produto']);
			$preco = mysqli_real_escape_string($link, $_POST['preco_do_produto']);
			$descricao = mysqli_real_escape_string($link, $_POST['descricao_do_produto']);
			$categoria_id = mysqli_real_escape_string($link, $_POST['categoria']);
			$stock = mysqli_real_escape_string($link, $_POST['stock_do_produto']);
			$detalhes = mysqli_real_escape_string($link, $_POST['detalhes_do_produto']);

		  //IMAGEM DO PRODUTO
			$file_name = $_FILES['imagem_do_produto']['name'];
			$file_type = $_FILES['imagem_do_produto']['type'];
			$file_size = $_FILES['imagem_do_produto']['size'];
			$file_tem_loc = $_FILES['imagem_do_produto']['tmp_name'];
			$file_store = "imagens/produtos/".$file_name;

			if (empty($nome) || empty($preco) || empty($descricao) || empty($stock) || empty($file_name) || empty($detalhes)) 
			{
				echo "<center><h2 style='color: red;'>Algo correu errado!</font></center>";
			}
			else {
				move_uploaded_file($file_tem_loc, $file_store);
				mysqli_query($link, "INSERT INTO products(p_name, image, price, descricao, categoria_id, stock, detalhes) VALUES ('$nome', '$file_name', '$preco', '$descricao', (SELECT categoria_id FROM categorias WHERE categoria_id='$categoria_id'), '$stock', '$detalhes')");
			}
			echo "<script>window.location.href='painel'</script>";
		}
		?>

		<script src="jquery.min.js"></script>


		<di>
			<div class="container">
				<center>
					<center><h1>Painel de Administração</h1></center><br>
					<div class="col-lg-12">
						<div style="display: inline-block; padding: 2%;" data-toggle="collapse" data-target="#utilizadores" data-parent="#closeall">
							<p>
								<a class="btn btn-sq-lg btn-primary">
									<i class="fa fa-user fa-5x"></i><br/>
									Administração<br> de utilizadores
								</a>
							</p>
						</div>
						<div style="display: inline-block; padding: 1%; position: relative;" data-toggle="collapse" data-target="#produtos" data-parent="#closeall">
							<p>
								<a class="btn btn-sq-lg btn-success">
									<i class="fas fa-cart-arrow-down fa-5x"></i><br/>
									Administração<br> de produtos
								</a>
							</p>
						</div>
						<div data-toggle="collapse" data-target="#add_produtos" style="margin-left: 33.3%; position: absolute; top: 89%; " data-parent="#closeall">
							<p>
								<a class="btn btn-danger" style="font-size: 12px;">
									Adicionar Produtos<i class="fas fa-cart-arrow-down"></i>
								</a>
							</p>
						</div>
						<div data-toggle="collapse" data-target="#proms" style="display: inline-block; padding: 2%;position: relative;" data-parent="#closeall">
							<p>
								<a class="btn btn-sq-lg btn-info">
									<i class="far fa-money-bill-alt fa-5x"></i><br/>
									Promoções
								</a>
							</p>
						</div>
						<div style="margin-left: 49.1%; position: absolute; top: 88.9%; ">
							<p>
								<a href="adicionar/promocao" class="btn btn-primary" style="font-size: 12px;">
									Adicionar Promoções <i class="far fa-money-bill-alt"></i>
								</a>
							</p>
						</div>
						<div data-toggle="collapse" data-target="#pedidos" style="display: inline-block; padding: 2%;" data-parent="#closeall">
							<p>
								<a class="btn btn-sq-lg btn-warning">
									<i class="fas fa-credit-card fa-5x"></i></i><br/>
									Pedidos <br>de compra
								</a>
							</p>
						</div>
					</div>
				</center>
			</div>
			<br><br><br>
			<center>
				<div style="width: 90%; height: auto; background-color: white; border: 1px solid black;">
					<!-- UTILIZADORES -->

					<div id="utilizadores" class="collapse">
						<h4>Paginação de Utilizadores</h4>
						<div class="form-group">
							<select name="state" id="maxRows_users" class="form-control" style="width:150px;">
								<option value="999999">Todos</option>
								<option value="3">3</option>
								<option value="5">5</option>
								<option value="10">10</option>
								<option value="15">15</option>
							</select>
						</div>
						<div class="table-responsive">
							<table id="users" class="table table-responsive table-bordered" style="width: 60%;">
								<thead>
									<tr>
										<th width="2%">ID</th>
										<th>Nome</th>
										<th>Idade</th>
										<th>Email</th>
										<th>Username</th>
										<th>Foto de perfil</th>
										<th>Estatuto</th>
										<th>Editar</th>
										<th>Eliminar</th>
									</tr>
								</thead>
								<?php
								if ($buscardados > 0) {
									while($row = mysqli_fetch_array($sql)){ 
										$id_user = $row["id"];
										$foto_perfil_user = $row["foto_perfil"];
										$email = $row["email"];
										$nome = $row["nome"];
										$idade = $row["idade"];
										$username = $row["username"];
										$role_id = $row["role_id"];
										if ($role_id == 1) {
											$role = "Cliente";
										} else {
											$role = "Admin";
										}
										echo "<tbody>";
										echo "<tr>";
										echo "<td>$id_user</td>";
										echo "<td>$nome</td>";
										echo "<td>$idade</td>";
										echo "<td>$email</td>";
										echo "<td>$username</td>";
										echo "<td><img data-src='$foto_perfil_user' width='100px'></td>";
										echo "<td>$role</td>";
										echo '<td>
										<a href="editar/user/'.$id_user.'" type="submit" class="btn btn-info"><i class="fas fa-edit"></i></button>
										</td>';
										echo '<td>
										<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#'.$username.'"><i class="fas fa-trash-alt"></i></button>
										</td>';
										echo "</tr>";
										echo "</tbody>";

										echo '<div class="modal fade" id="'.$username.'" role="dialog">
										<div class="modal-dialog modal-dialog-centered">
										
										<div class="modal-content">
										<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Aviso</h4>
										</div>
										<div class="modal-body">
										<p>Tem a certeza que quer eliminar o utilizador '.$username.'?</p>
										</div>
										<div class="modal-footer">
										<a href="apagar/user/'.$id_user.'"><button type="submit" class="btn btn-danger" name="apagar_conta">Sim</button></a>
										<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
										</form>
										</div>
										</div>
										
										</div>
										</div>';
									}
								} 
								?>
							</table>
						</div>

						<div class="pagination-container">
							<nav>
								<ul class="pagination_users"></ul>
							</nav>
						</div>

						<script>
							var table_x = '#users'
							$('#maxRows_users').on('change', function(){
								$('.pagination_users').html('')
								var trnum_x = 0
								var maxRows_x = parseInt($(this).val())
								var totalRows_x = $(table_x+' tbody tr').length
								$(table_x+' tr:gt(0)').each(function(){
									trnum_x++
									if(trnum_x > maxRows_x){
										$(this).hide()
									}
									if(trnum_x <= maxRows_x){
										$(this).show()
									}
								})
								if(totalRows_x > maxRows_x){
									var pagenum_x = Math.ceil(totalRows/maxRows)
									for(var i=1;i<=pagenum_x;){
										$('.pagination').append('<li data-page="'+i+'">\<span>'+ i++ +'<span class="sr-only">(current)</span></span>\</li>').show()
									}
								}
								$('.pagination_users li:first-child').addClass('active')
								$('.pagination_users li').on('click',function(){
									var pageNum_x = $(this).attr('data-page')
									var trIndex_x = 0;
									$('.pagination_users li').removeClass('active')
									$(this).addClass('active')
									$(table_x+' tr:gt(0)').each(function(){
										trIndex_x++
										if(trIndex_x > (maxRows_x*pageNum_x) || trIndex_x <= ((maxRows_x*pageNum_x)-maxRows_x)){
											$(this).hide()
										} else{
											$(this).show()
										}
									})
								})
							})
						</script>
					</div>

					<!-- FIM DOS UTILIZADORES / INICIO DOS PRODUTOS -->


					<div class="collapse" id="produtos">
						<h4>Paginação de Produtos</h4>
						<div class="form-group">
							<select name="state" id="maxRows" class="form-control" style="width:150px;">
								<option value="999999">Todos</option>
								<option value="3">3</option>
								<option value="5">5</option>
								<option value="10">10</option>
								<option value="15">15</option>
							</select>
						</div>
						<div class="table-responsive">
							<table id="mytable" class="table table-responsive table-bordered" style="width: 60%;">
								<thead>
									<tr>
										<th width="2%">ID</th>
										<th>Nome do Produto</th>
										<th>Imagem</th>
										<th>Preço</th>
										<th>Descrição</th>
										<th>Categoria</th>
										<th>Stock</th>
										<th>Detalhes</th>
										<th>Média de Rating</th>
										<th>Editar</th>
										<th>Eliminar</th>
									</tr>
								</thead>
								<?php
								if ($buscardados_products > 0) {
									while($row = mysqli_fetch_array($sql_product)){ 
										$id_product = $row["id"];
										$nome_produto = $row["p_name"];
										$imagem = $row["image"];
										$preco = $row["price"];
										$descricao = $row["descricao"];
										$categoria_id = $row["categoria_id"];
										$stock = $row["stock"];
										$detalhes = $row["detalhes"];
										$rating = $row["avg_rating"]; 
										$sql = "SELECT categoria FROM categorias WHERE categoria_id='$categoria_id' LIMIT 1";
										$ligar = mysqli_query($link, $sql);
										$ligar_rows = mysqli_num_rows($ligar);
										if ($ligar_rows > 0) {
											while($row = mysqli_fetch_array($ligar)) {
												$categoria = $row['categoria'];
											}
										} 

										echo "<tbody>";
										echo "<tr>";
										echo "<td>$id_product</td>";
										echo "<td>$nome_produto</td>";
										echo "<td><img data-src='imagens/produtos/$imagem' width='100px'></td>";
										echo "<td>$preco</td>";
										echo "<td>$descricao</td>";
										echo "<td>$categoria</td>";
										echo "<td>$stock</td>";
										echo "<td>$detalhes</td>";
										echo "<td>$rating</td>";
										echo '<td>
										<a href="editar/produto/'.$id_product.'" type="submit" class="btn btn-info"><i class="fas fa-edit"></i></button>
										</td>';
										echo '<td>
										<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#'.$id_product.'"><i class="fas fa-trash"></i></button>
										</td>';
										echo "</tr>";
										echo "</tbody>";

										echo '<div class="modal fade" id="'.$id_product.'" role="dialog">
										<div class="modal-dialog modal-dialog-centered">
										
										<div class="modal-content">
										<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Aviso</h4>
										</div>
										<div class="modal-body">
										<p>Tem a certeza que quer eliminar o produto '.$nome_produto.'?</p>
										</div>
										<div class="modal-footer">
										<a href="apagar/produto/'.$id_product.'"><button type="submit" class="btn btn-danger" name="apagar_conta">Sim</button></a>
										<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
										</form>
										</div>
										</div>
										
										</div>
										</div>';
									}
								} 
								?>
							</table>
						</div>
						<div class="pagination-container">
							<nav>
								<ul class="pagination"></ul>
							</nav>
						</div>
					</div>
					<!-- Paginação de Produtos -->
					<script>
						var table = '#mytable'
						$('#maxRows').on('change', function(){
							$('.pagination').html('')
							var trnum = 0
							var maxRows = parseInt($(this).val())
							var totalRows = $(table+' tbody tr').length
							$(table+' tr:gt(0)').each(function(){
								trnum++
								if(trnum > maxRows){
									$(this).hide()
								}
								if(trnum <= maxRows){
									$(this).show()
								}
							})
							if(totalRows > maxRows){
								var pagenum = Math.ceil(totalRows/maxRows)
								for(var i=1;i<=pagenum;){
									$('.pagination').append('<li data-page="'+i+'">\<span>'+ i++ +'<span class="sr-only">(current)</span></span>\</li>').show()
								}
							}
							$('.pagination li:first-child').addClass('active')
							$('.pagination li').on('click',function(){
								var pageNum = $(this).attr('data-page')
								var trIndex = 0;
								$('.pagination li').removeClass('active')
								$(this).addClass('active')
								$(table+' tr:gt(0)').each(function(){
									trIndex++
									if(trIndex > (maxRows*pageNum) || trIndex <= ((maxRows*pageNum)-maxRows)){
										$(this).hide()
									} else{
										$(this).show()
									}
								})
							})
						})
					</script>
					

					<!-- FIM DOS PRODUTOS/ INICIO DO ADICIONAR PRODUTOS -->
					<div class="collapse" id="add_produtos">
						<form action="" method="POST" enctype="multipart/form-data">

							<input type="text" name="nome_do_produto" placeholder="Nome do Produto" class="form-control" style="width: 18%"><br>
							<input type="number" name="preco_do_produto" step="0.01" placeholder="Preço do Produto" class="form-control" style="width: 18%"><br>
							<textarea rows="4" name="descricao_do_produto" placeholder="Descrição do Produto" class="form-control" style="width: 18%"></textarea><br>
							<input type="number" name="stock_do_produto" placeholder="Stock disponível do Produto" class="form-control" style="width: 18%"><br>
							<textarea rows="5" name="detalhes_do_produto" placeholder="Detalhes do Produto" class="form-control" style="width: 18%"></textarea><br>
							<h3>Categoria:</h3> <select name="categoria">
								<?php
								$sql = mysqli_query($link, "SELECT * FROM categorias;");
								$cat_loop = mysqli_num_rows($sql); 
								if ($cat_loop > 0) {

									while($row = mysqli_fetch_array($sql)){
										$categoria_table = $row["categoria"];
										$categoria_id = $row['categoria_id'];
										

										?>
										<option value="<?php echo $categoria_id; ?>"><?php echo $categoria_table; ?></option>
										<?php
									}
								}
								?>
							</select>
							<h3>Imagem do Produto</h3><input type="file" name="imagem_do_produto"><br><br>
							<input class="btn-lg btn-primary btn-success" style="width: 10%;" type="submit" name="adicionar_produto"><br><br>

						</form>
					</div>
					<!-- FIM DO ADICIONAR PRODUTOS/ INICIO DAS PROMOÇÕES -->
					<div class="collapse" id="proms">
						<h2>Promoções de produtos</h2>
						<!-- PROMS PRODUTOS -->
						<table class="table table-bordered" style="width: 50%;">
							<thead>
								<tr>
									<th>ID</th>
									<th>Tipo</th>
									<th>Promoção</th>
									<th>Produto</th>
									<th>Ativado</th>
									<th>Destaque</th>
									<th>Desconto</th>
									<th>Editar</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$busca_proms = mysqli_query($link, "SELECT * FROM promocoes WHERE tipo='produto'");
								if (mysqli_num_rows($busca_proms) > 0) {
									while ($proms_info = mysqli_fetch_array($busca_proms)) {
										$id_promocao = $proms_info['id_promocao'];
										$promocao_txt = $proms_info['promocao'];
										$prod_prom = $proms_info['id_produto'];
										$ativado = $proms_info['ativado'];
										$destaque = $proms_info['destaque'];
										$desconto = $proms_info['desconto'];
										$tipo = $proms_info['tipo'];
										$data = $proms_info['data'];
										$categoria_id = $proms_info['categoria_id'];

										if ($tipo == 'produto') {
											?>
											<tr>
												<td><?php echo $id_promocao; ?></td>
												<td><?php echo $tipo; ?></td>
												<td><?php echo $promocao_txt; ?></td>
												<td><?php echo $prod_prom; ?></td>
												<td><?php echo $ativado; ?></td>
												<td><?php echo $destaque; ?></td>
												<td><?php echo round((float)$desconto * 100 ) . '%'; ?></td>
												<td><a href="editar/promocao/<?php echo $id_promocao; ?>" type="submit" class="btn btn-info"><i class="fas fa-edit"></i></button></a></td>
												<td><a href="apaga_promocao.php?id=<?php echo $id_promocao; ?>&desconto=<?php echo $desconto; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></button></a></td>
											</tr>
											<?php
										}
										?>
										<?php
									}
								}
								?>
							</tbody>
						</table>

						<!-- PROMS CATEGORIAS -->
						<br><br>
						<h2>Promoções de categorias</h2>

						<table class="table table-bordered" style="width: 50%;">
							<thead>
								<tr>
									<th>ID</th>
									<th>Tipo</th>
									<th>Promoção</th>
									<th>Categoria</th>
									<th>Ativado</th>
									<th>Destaque</th>
									<th>Desconto</th>
									<th>Eliminar</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$q = "SELECT * FROM promocoes WHERE tipo='categoria' LIMIT 1";
								$busca_proms = mysqli_query($link, $q);
								if (mysqli_num_rows($busca_proms) > 0) {
									while ($proms_info_2 = mysqli_fetch_assoc($busca_proms)) {
										$id_promocao = $proms_info_2['id_promocao'];
										$promocao_txt = $proms_info_2['promocao'];
										$prod_prom = $proms_info_2['id_produto'];
										$ativado = $proms_info_2['ativado'];
										$destaque = $proms_info_2['destaque'];
										$desconto = $proms_info_2['desconto'];
										$tipo = $proms_info_2['tipo'];
										$data = $proms_info_2['data'];
										$categoria_id = $proms_info_2['categoria_id'];

										$busca_cat = mysqli_query($link, "SELECT * FROM categorias WHERE categoria_id='$categoria_id'");
										$info_cat = mysqli_fetch_assoc($busca_cat);
										$categoria_txt = $info_cat['categoria'];

										?>
										<tr>
											<td><?php echo $id_promocao; ?></td>
											<td><?php echo $tipo; ?></td>
											<td><?php echo $promocao_txt; ?></td>
											<td><?php echo $categoria_txt; ?></td>
											<td><?php echo $ativado; ?></td>
											<td><?php echo $destaque; ?></td>
											<td><?php echo round((float)$desconto * 100 ) . '%'; ?></td>
											<td><a href="apaga_promocao.php?id=<?php echo $id_promocao; ?>&desconto=<?php echo $desconto; ?>&tipo=categoria&cat=<?php echo $categoria_id; ?>" class="btn btn-danger"><i class="fas fa-trash"></i></button></a></td>
										</tr>
										<?php
										?>
										<?php
									}
								}
								?>
								<tr>

								</tr>
							</tbody>
						</table>
					</div>
					<!-- FIM DAS CATEGORIAS/ INICIO DOS PEDIDOS -->

					<div class="collapse" id="pedidos">
						<h2>Pedidos de Compra</h2>
						<table class="table table-bordered" style="width: 50%;">
							<thead>
								<th>ID do pedido</th>
								<th>Utilizador</th>
								<th>Produto</th>
								<th>Data Criado</th>
								<th>Concluído</th>
							</thead>
							<tbody>
								<?php
								$sql_ord = mysqli_query($link, "SELECT * FROM orders");
								$conta_ord = mysqli_num_rows($sql_ord);
								if ($conta_ord > 0) {
									while ($info_ord = mysqli_fetch_array($sql_ord)) {
										$id_pedido = $info_ord['order_id'];
										$id_user_ord = $info_ord['user_id'];
										$id_do_prod = $info_ord['product_id'];
										$data_prod = $info_ord['data'];

										$busca_user = mysqli_query($link, "SELECT username FROM users WHERE id='$id_user_ord'");
										$busca_info_user = mysqli_fetch_assoc($busca_user);
										$username_do_user = $busca_info_user['username'];
										$busca_produto_sql = mysqli_query($link, "SELECT * FROM products WHERE id=(SELECT id FROM products WHERE id='$id_do_prod')");
										$busca_info_prod = mysqli_fetch_assoc($busca_produto_sql);
										$nome_do_produto = $busca_info_prod['p_name']; 
										?>
										<tr>
											<td><?php echo $id_pedido; ?></td>
											<td><?php echo $username_do_user; ?></td>
											<td><?php echo $nome_do_produto; ?></td>
											<td><?php echo $data_prod; ?></td>
											<td><form method="POST">
												<input type="hidden" name="pedido_id" value="<?php echo $id_pedido; ?>">
												<button type="submit" class="btn btn-success" name="pedido_resolvido"><i class="fas fa-check-circle"></i></button></form>
											</td>
										</tr>
										<?php
									}
								}
								?>
							</tbody>
						</table>


					</div>
					<!-- FIM DOS PEDIDOS -->
				</div>
			</div>
		</center>
	</div>
			<script type="text/javascript">
			$('#closeall').on('show.bs.collapse', function () {
				console.log("ARRANCA");
			    $('#closeall .in').collapse('hide');
			});
		</script>
		<br><br><br>
	<?php
		} else {
			no_login();
		}
	} else {
		no_login();
	}
include 'footer.php';
?>