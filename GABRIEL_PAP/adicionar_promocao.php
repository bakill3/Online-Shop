<?php include 'header.php'; ?>
<?php
if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$sql_login_admin = "SELECT * FROM users WHERE username='$sessao' AND role_id=2";
	$results_admin = mysqli_query($link, $sql_login_admin);
	if (mysqli_num_rows($results_admin) == 1) {
			?>
			<form action="" method="POST">
				<div class="containter">
				<center>		
					<h1>Adicionar Promoção</h1><br>
					
					
					<script type="text/javascript">
						$(function() {
						    $('#muda').hide(); 
						    $('#muda2').hide();
						    $('#tipo').change(function(){
						        if($('#tipo').val() == 'produto') {
						            $('#muda').show(); 
						            $('#muda2').hide(); 
						        } else { 
						        	$('#muda2').show();
						            $('#muda').hide(); 
						        }

						       
						    });
						});
					</script>
					Tipo de Promoção<br>
					<select name="tipo" id="tipo">
						<option>Tipo de Promoção</option>
						<option value="categoria_p">Categoria</option>
						<option  value="produto">Produto</option>
					</select><br><br>
					Título da promoção:<input type="text" class="form-control" style="width: 20%" name="promocao_atualizado"><br><br>
					<div id="muda">
						Produto
						<select name="produto_tt" class="form-control" style="width: 20%">
							<?php 
							$select_produto = mysqli_query($link, "SELECT p_name, id FROM products");
							while ($info_prod = mysqli_fetch_array($select_produto)) {
								$id_prod_db = $info_prod['id'];
								$p_name_db = $info_prod['p_name'];
							?>
							<option value="<?php echo $id_prod_db; ?>"><?php echo $p_name_db; ?></option>
							<?php
							}
							?>
						</select><br>
					</div>
					<div id="muda2">
						<select name="categoria_tt" id="categoria_p" class="form-control" style="width: 20%">
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
					</div>
					Desconto
					<select name="desconto" class="form-control" style="width: 20%">
						<?php 
						$b = 0.00;
						for ($i=1; $i < 101; $i++) { 
							$b = $b + 0.01;
						?>
						<option value="<?php echo $b; ?>"><?php echo $i; ?>%</option>
						<?php
						}
						?>
					</select><br>
					<input id="datetime" name="data" type="datetime-local" class="form-control" style="width: 20%;"><br>
					Ativado<input type="checkbox" name="ativado" class="form-control" value="1" style="display: inline-block;"><br>
					Destaque<input type="checkbox" name="destaque" class="form-control" value="1" style="display: inline-block;"><br><br>
					<button type="submit" name="adicionar_promocao" class="btn btn-primary">Atualizar</button><br><br>
					<p>Apenas administradores têm acesso a esta página</p>
					<a href="painel" class="btn btn-info">Painel</a>
				</center>
			</form>
			<?php
	}
	else {
		no_login();
	}
}
else {
	no_login();
}
?>
<?php include 'footer.php'; ?>