<?php include 'header.php';?>
<?php
$busca_prom = mysqli_query($link, "SELECT * FROM promocoes WHERE ativado=1 AND destaque=1 LIMIT 1");
if (mysqli_num_rows($busca_prom) > 0) {
	$info_prom = mysqli_fetch_assoc($busca_prom);
	$id_promocao = $info_prom['id_promocao'];
	$id_prod_prom = $info_prom['id_produto'];
	$id_cat_prom = $info_prom['categoria_id'];
	$promocao = $info_prom['promocao'];
	$ativado = $info_prom['ativado'];
	$desconto = $info_prom['desconto'];
	$tipo = $info_prom['tipo'];
	$data = $info_prom['data'];


	//$data = strtotime($data);
	$data_atual = date("Y-m-d H:i:s", strtotime('-1 hour'));


	$data_n = date($data);


	$prod_prom = mysqli_query($link, "SELECT p_name FROM products WHERE id='$id_prod_prom'");
	$prod_info = mysqli_fetch_assoc($prod_prom);
	$nome_produto_prom = $prod_info['p_name'];

	$cat_prom = mysqli_query($link, "SELECT categoria FROM categorias WHERE categoria_id='$id_cat_prom'");
	$cat_info = mysqli_fetch_assoc($cat_prom);
	$categoria_prom = $cat_info['categoria'];

	$cat_feat = mysqli_query($link, "SELECT feat FROM categorias WHERE categoria_id='$id_cat_prom' AND feat='1'");

	if (mysqli_num_rows($cat_feat) == 0 && $tipo='produto') {
	if ($data_atual > $data) {
		if ($tipo == 'produto') {
			mysqli_query($link, "UPDATE products SET price_descontado=0 WHERE id='$id_prod_prom'");
			mysqli_query($link, "DELETE FROM promocoes WHERE id_promocao='$id_promocao' LIMIT 1");


		} 
	}
?>

<div class="alert alert-warning" style="margin-bottom: 0px;">
  <strong><div style="font-size: 110%; display: inline-block;"><span style="color: green;">P</span><span style="color: blue;">r</span><span style="color: #2D383A;">o</span><span style="color: red;">m</span><span style="color: #D27D46;">o</span><span style="color: green">ç</span><span style="color: blue;">ã</span><span style="color: purple;">o</span>!</div> - <span style="display: inline-block; font-size: 110%;"> <?php echo $promocao; ?> - <a href="produto/<?php echo $id_prod_prom; ?>"><?php echo round((float)$desconto * 100 ) . '%'; ?> de Desconto no <?php echo $tipo." ".$nome_produto_prom  ?></span></strong>  </a><b><span id="demo" style="position: absolute; right: 1%;"></span></b>
</div>

<?php
//echo $data;
//echo "<br>";
//echo $data_atual;
} else { 
	if ($tipo == "categoria") {
		if ($data_atual > $data) {
			$loo = mysqli_query($link, "SELECT * FROM products");
			$loop_conta = mysqli_num_rows($loo);
			if ($loop_conta > 0) {
				while ($loop_info = mysqli_fetch_array($loo)) {
					$id_pp = $loop_info['id'];
					//$id_pro = $loop_info['id_promocao'];
					$cat_id = $loop_info['categoria_id'];
					mysqli_query($link, "UPDATE products SET price_descontado=0 WHERE categoria_id=(SELECT categoria_id FROM categorias WHERE categoria_id='$cat_id')");
					mysqli_query($link, "DELETE FROM promocoes WHERE categoria_id=(SELECT categoria_id FROM categorias WHERE categoria_id='$cat_id')");

				}
				mysqli_query($link, "UPDATE categorias SET feat='0' WHERE categoria_id='$cat_id'");
			}
		}
	
	}
?>
<div class="alert alert-warning" style="margin-bottom: 0px;">
  <strong><div style="font-size: 110%; display: inline-block;"><span style="color: green;">P</span><span style="color: blue;">r</span><span style="color: #2D383A;">o</span><span style="color: red;">m</span><span style="color: #D27D46;">o</span><span style="color: green">ç</span><span style="color: blue;">ã</span><span style="color: purple;">o</span>!</div> - <span style="display: inline-block; font-size: 110%;"><?php echo $promocao; ?> - <?php echo round((float)$desconto * 100 ) . '%'; ?> de Desconto na <?php echo $tipo." ".$categoria_prom   ?></strong></span> <b><span id="demo" style="position: absolute; right: 1%;"></span></b></a>
</div>
<?php
}
}
if (isset($data)) {
?>
<script>
var countDownDate = new Date("<?php echo $data; ?>").getTime();

var x = setInterval(function() {

    var now = new Date().getTime();
    
    var distance = countDownDate - now;
    
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    document.getElementById("demo").innerHTML = days + " Dias " + hours + " Horas "
    + minutes + " Minutos " + seconds + " Segundos ";
    
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "Expirado";
    }
}, 1000);
</script>
<?php } ?>
<div class="fundo">
	<br>
	<div class="container" style="width: 55%;height: 100%"> 
		<div style="border-left: 3px solid red;border-right: 3px solid red;border-bottom: 3px solid blue;border-top: 3px solid blue; height: 80%" id="myCarousel" class="carousel slide" data-ride="carousel">


			<div class="carousel-inner" style="height: 100%">
				<div class="item active" style="height: 100%">
					<a href="produto/2"><img data-src="imagens/slideshow/1.jpg" alt="Los Angeles" style="width:100%;height: 100%"></a>
				</div>

				<div class="item" style="height: 100%">
					<a href="produto/4"><img data-src="imagens/slideshow/2.jpg" alt="Chicago" style="width:100%;height: 100%"></a>
				</div>

				<div class="item" style="height: 100%">
					<a href="produto/5"><img data-src="imagens/slideshow/3.jpg" alt="New york" style="width:100%;height: 100%"></a>
				</div>
			</div>


			<a class="left carousel-control" href="#myCarousel" data-slide="prev" style="height: 100%">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next" style="height: 100%">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
	</div>
	<br>
</div>

<hr>
<?php
//DEFINIR VARIÁVEIS PARA O CASO DE NÃO SEREM USADAS EM BAIXO
	$ordenar_cat = "";
	
// Se clicar no botao Submeter (O da categoria) -> passa por estas condiçoes todas
	if (isset($_POST['cat'])) {
		$preco_min = mysqli_real_escape_string($link, $_POST['preco_min']);
		$preco_max = mysqli_real_escape_string($link, $_POST['preco_max']);
		$select_cat = mysqli_real_escape_string($link, $_POST['categoria']); //BUSCAR o id da categoria 
		$modo = mysqli_real_escape_string($link, $_POST['modo']);
		//SE A CATEGORIA TIVER SIDO DEFINIDA
		if (isset($select_cat) && $select_cat != "todos") {
				$query = "SELECT * FROM products WHERE categoria_id='".$select_cat."'";
				$cat_query = "SELECT categoria_id FROM products WHERE categoria_id='$select_cat';";
				$result_cat = mysqli_query($link, $cat_query);
				$row_cat = mysqli_fetch_assoc($result_cat);
				$categoria_holder_id = $row_cat['categoria_id'];
		} else {
			$query = "SELECT * FROM products WHERE 1 = '1'"; //QUERY USADA PARA CHAMAR OS PRODUTOS
		}

		if (!empty($preco_min) && !empty($preco_max)) {
			$query .= "AND price BETWEEN $preco_min AND $preco_max ";
			$_SESSION['min'] = $preco_min;
			$_SESSION['max'] = $preco_max;
		} elseif (!empty($preco_min)) {
			$query .= "AND price >= $preco_min ";
			$_SESSION['min'] = $preco_min;
		} elseif (!empty($preco_max)) {
			$query .= "AND price <= $preco_max ";
			$_SESSION['max'] = $preco_max;
		} else {
			unset($_SESSION['min']);
			unset($_SESSION['max']);
		}

		if ($modo == "preco_asc") {
			$query .= "ORDER BY price ASC";
			$_SESSION['selecionado'] = "preco_asc";
		}
		elseif ($modo == "preco_desc") {
			$query .=  "ORDER BY price DESC";
			$_SESSION['selecionado'] = "preco_desc";
		}
		elseif ($modo == "melhor_avaliados") {
			$query .=  "ORDER BY avg_rating DESC";
			$_SESSION['selecionado'] = "melhor_avaliados";
		}
		elseif ($modo == "em_promocao") {
			$query .=  "AND price_descontado!='0'";
			$_SESSION['selecionado'] = "em_promocao";
		}
		elseif ($modo == "") {
			$query .=  "ORDER BY id ASC"; 
			unset($_SESSION['selecionado']);
		}
		
		
		
	} elseif (isset($_GET['s'])) {
		$pesquisa_txt = htmlspecialchars(mysqli_real_escape_string($link, $_GET['s']));
		$query = "SELECT * FROM products WHERE p_name LIKE '%".$pesquisa_txt."%' OR price LIKE '%".$pesquisa_txt."%' OR descricao LIKE '%".$pesquisa_txt."%';";
		$mensagem = 1;
	} else { // Se não clicar no botão
		$categoria = "todos";
		$modo = "";
		$ordenar_cat = "ORDER BY id ASC";
		$query = "SELECT * FROM products ".$ordenar_cat.";"; //QUERY USADA PARA CHAMAR OS PRODUTOS
	}
?>
<div class="cat_st">
	<div class="panel panel-primary teste_cat">
      <div class="panel-heading"><center>Filtros</center></div>
      <div class="panel-body">
      		<?php /* SCRIPT QUE FUI VER AO W3 */ ?>
	<script type="text/javascript">
		if ($(window).width() > 800) {
				var fixmeTop = $('.teste_cat').offset().top;
			$(window).scroll(function() {
			    var currentScroll = $(window).scrollTop();
			    if (currentScroll >= fixmeTop) {
			    	$('.teste_cat').css({
			            position: 'fixed',
			            top: '0%',
			            left: '0',
			            width: '13%'


			        });
			        
			    	if (currentScroll >= ($(document).height() - $(window).height())*0.40) {
			        	$('.teste_cat').css({
			            position: 'fixed',
			            top: '30%',
			            left: '0'


			        });
			         } else if (currentScroll >= ($(document).height() - $(window).height())*0.35) {
			        	$('.teste_cat').css({
			            position: 'fixed',
			            top: '15%',
			            left: '0'


			        });
			        } else if (currentScroll >= ($(document).height() - $(window).height())*0.30) {
			        	$('.teste_cat').css({
			            position: 'fixed',
			            top: '5%',
			            left: '0'


			        });
			        }


			        
			    } else {
			        $('.teste_cat').css({
			            position: 'static',
			            width: '100%'
			        });
			    }
			});
		}
	</script>

      	
      	<form method="POST" data-aos="fade-right">
	<center>
		<div class="form-group">
			<select name="categoria" class="form-control" style="height: 10%;">
				<option value="todos">Categorias</option>
				<?php
				$sql = mysqli_query($link, "SELECT * FROM categorias;");
			  	$cat_loop = mysqli_num_rows($sql); 
			  	if ($cat_loop > 0) {

				    while($row = mysqli_fetch_array($sql)){
				    	$categoria_table = $row["categoria"];
				    	$categoria_id = $row["categoria_id"];
				    

				?>
				<option value="<?php echo $categoria_id; ?>" <?php if(isset($categoria_holder_id)): if($categoria_holder_id==$categoria_id): ?> selected <?php endif; endif; ?> ><?php echo $categoria_table; ?>
					<?php 
					$info_cc = mysqli_query($link, "SELECT * FROM promocoes WHERE tipo='categoria' AND categoria_id='$categoria_id'");
					if (mysqli_num_rows($info_cc) > 0) {
						$busca_desconto = mysqli_fetch_assoc($info_cc);
						$desconto_p = $busca_desconto['desconto'];
						echo "- <span class='label label-danger' style='color: red;'>".round((float)$desconto_p * 100 ) . '% de Desconto</span>';
					}
					?></option>
				<?php
				   	}
			 	}
			 	?>
			</select>
			</div>
			<div class="form-group">
				<select name="modo" class="form-control" style="height: 10%;">
					<option class="texto_option" value="" disabled>Ordenar</option>
					<option class="texto_option" value="">Relevância</option>
					<option value="em_promocao" <?php if (isset($_SESSION['selecionado']) && $_SESSION['selecionado'] == "em_promocao") { ?> selected <?php } ?> >Promoção</option>
					<option value="melhor_avaliados" <?php if (isset($_SESSION['selecionado']) && $_SESSION['selecionado'] == "melhor_avaliados") { ?> selected <?php } ?>>Melhor Avaliados</option>
					<option value="preco_asc" <?php if (isset($_SESSION['selecionado']) && $_SESSION['selecionado'] == "preco_asc") { ?> selected <?php } ?>>Preço: Ascendente</option>
					<option value="preco_desc" <?php if (isset($_SESSION['selecionado']) && $_SESSION['selecionado'] == "preco_desc") { ?> selected <?php } ?>>Preço: Descendente</option>
				</select>
			</div>
			<div class="form-group">
				<input type="number" step="0.01" class="form-control" name="preco_max" <?php if (isset($_SESSION['max'])) { ?> value="<?php echo $_SESSION['max']; ?>" <?php } ?> placeholder="Máximo">

				<input type="number" step="0.01" class="form-control" name="preco_min" <?php if (isset($_SESSION['min'])) { ?> value="<?php echo $_SESSION['min']; ?>" <?php } ?>  placeholder="Mínimo">
			</div>
			
			<button type="submit" name="cat" class="btn btn-success" ><i class="fab fa-searchengin"></i> Pesquisar</button>
		</form>




</center>
      </div>
    </div>
</div>
</form>

<div style="display: inline-block; width: 87%; float: right;">
<?php
$result = mysqli_query($link, $query); //QUERY CHAMADA DAS CATEGORIAS ( if (isset($_POST['cat'])) )
echo mysqli_error($link);
$conta_prods = mysqli_num_rows($result);
if (isset($mensagem)) {
	$pesquisa_get = htmlspecialchars(mysqli_real_escape_string($link, $_GET['s']));

	echo '
	<div style="padding-left: 1%;">
	<div class="panel panel-default">
      <div class="panel-heading">Pesquisa</div>
      <div class="panel-body"><h2>Pesquisou por: "<span style="color:red">'.$pesquisa_get.'</span>". <span style="font-size: 70%; color: blue;">Foram encontrados '.$conta_prods.' resultados.</span></h2></div>
    </div>
    </div>
	"';
}
?>
<script type="text/javascript">
	x = 0;
</script>
	<?php 
	if($conta_prods > 0)  
	{  
		?>
		<?php
		$var_x = 0;
		while($row = mysqli_fetch_array($result))  
		{  
			$max_stock = $row['stock'];
			$price = htmlspecialchars(mysqli_real_escape_string($link, $row['price']));
			$p_name = htmlspecialchars(mysqli_real_escape_string($link, $row['p_name']));
			$produto_id = htmlspecialchars(mysqli_real_escape_string($link, $row['id']));
			$image = htmlspecialchars(mysqli_real_escape_string($link, $row['image']));
			$descricao = htmlspecialchars(mysqli_real_escape_string($link, $row['descricao']));
			$price_descontado = htmlspecialchars(mysqli_real_escape_string($link, $row['price_descontado']));
			$descricao_curta = substr($descricao, 0, 20)."..";
			if ($max_stock >= 1) {
				$id_avg = $row['id'];
				$query = "SELECT avg_rating FROM products WHERE id='$id_avg';";
				$avg_query = mysqli_query($link, $query);
				if(mysqli_num_rows($avg_query) > 0)  {  
					while($rowp = mysqli_fetch_array($avg_query))  {  
						$avg_rating = $rowp['avg_rating'];
					}
				}
				//ATUALIZAR O RATING DE CADA PRODUTO
				
				$sql4 = "SELECT AVG(rate) AS rate_avg FROM products_rating WHERE product_id=(SELECT id FROM products where id='$produto_id');";
				$avg_query_2 = mysqli_query($link, $sql4);
				$data = $avg_query_2->fetch_assoc();
				$avg_rating_2 = $data['rate_avg'];
				$avg_criticas_2 = number_format((float)$avg_rating_2, 1, '.', '');
				$sql3 = "UPDATE products SET avg_rating = '$avg_criticas_2' WHERE id = '$produto_id';";
				mysqli_query($link, $sql3);
				//-----------------------------------------------------------------------------------------
				if (empty($avg_rating)) {
					$avg_rating = "N/A";
				}

        		// $avg_criticas = number_format((float)$avg_rating, 1, '.', '');
				$avg_criticas = round($avg_rating);

				if ($avg_criticas == 0) {
					$avg_criticas = "N/A";
				} 
				?>  

				<script>
					var anim_array = [
					'fade-up',
					'fade-in',
					'fade-down',
					'zoom-out',
					'zoom-out-up',
					'zoom-out-down',
					];
					var random_anim = Math.floor(Math.random()*anim_array.length);
				</script>
				<?php /* ANTIGO: loja.php?action=add&id=<?php echo $row["id"]; ?> */ ?>
				<form method="post" action="loja/add/id/<?php echo $row['id']; ?>" data-aos="zoom-in" autocomplete="off" > 
					<figure class="snip1396 green" data-aos="fade-in">
					<?php
					$promocao_prod = mysqli_query($link, "SELECT * FROM promocoes WHERE id_produto='$produto_id'");
					if (mysqli_num_rows($promocao_prod) == 1) {
						$antigo_price = $price;
						$price = $price_descontado;
						$ttt = $produto_id;
						$info_prom = mysqli_fetch_assoc($promocao_prod);
						$promocao = $info_prom['promocao'];
						$ativado = $info_prom['ativado'];
						$desconto = $info_prom['desconto'];
						$tipo = $info_prom['tipo'];
						$data = $info_prom['data'];
						//$price = $preco_descontado;
					?>
					<?php 
					//$color = dechex(rand(0x000000, 0xFFFFFF)); //RANDOM COR
					//background-color: #0066CC;
					$cor = array("#FD0E35", "#FF8833", "salmon", "#5E8C31", "#00CCCC", "#2D383A", "#00468C", "#652DC1", "#FC74FD");
					
					?>
						<div style="position: absolute; top: 0;height: 6%; width: 100%; text-align: center; background-color: <?php echo $cor[array_rand($cor)]; ?>; z-index: 10;">
							EM PROMOÇÃO! <?php if (isset($ttt) && $ttt == $produto_id) { ?><span class="label label-danger"  style="position: absolute; right: 12%;bottom: 10%;"><?php echo round((float)$desconto * 100 ) . '%'; ?></span><?php } ?>




						</div>
					<?php
					}
					?>
						<img data-src="imagens/produtos/<?php echo $image; ?>" name="imagem" width="200" height="350">
						<a href="produto/<?php echo $produto_id; ?>">
							<div class="image"><img data-src="imagens/produtos/<?php echo $image; ?>" alt="<?php echo $p_name; ?>" width="200" height="220"></div>

							<figcaption>
								<center><h3><?php echo $p_name; ?></h3></a></center>
								<p><?php echo $descricao_curta; ?></p>

								<div class="form-group">
									<input type="number" name="quantity" class="form-control" placeholder="Quantidade:" min="1" max="<?php echo $max_stock; ?>" pattern="[0-9]*" required />
								</div>
								<input type="hidden" name="stock" value="<?php echo $max_stock; ?>" />
								<input type="hidden" name="p_name" value="<?php echo $p_name; ?>" />  
								<input type="hidden" name="price" value="<?php echo $price; ?>" />
								<input type="hidden" name="product_id" value="<?php echo $produto_id; ?>" />
								<input type="hidden" name="price_descontado" value="<?php echo $price_descontado; ?>" />
							</figcaption>
							<div class="price">
								<?php echo $price; ?> €  <div style="float: right;">&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?php echo $avg_criticas; ?><span class="fa fa-star"></span></div>
							</div>

							
    <?php /*
    <input type="submit" name="add_to_cart" style="width: 20%; color: #00ff99; background-color: #F5F5DC; font-size: 50px;" class="add-to-cart" value="+" />  
*/ ?>
<button type="submit" name="add_to_cart" style="width: 20%; height: 13%; background-color: #4CAF50;
border: none;
color: white;
cursor: pointer; font-size: 20px;" class="add-to-cart" /><span class='glyphicon glyphicon-shopping-cart'></span></button>
</figure>
</form>
<?php  
$var_x++;
}
}  
} else {
	echo '<center>
	    <div class="panel panel-danger"">
      <div class="panel-heading">Erro</div>
      <div class="panel-body">Não foram encontrados produtos</div>
    </div>
	
	</center>
	';
}  
?>  
</div>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="js/index.js"></script>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div style="clear:both"></div>  
<br /> 
</div> 
<br /> 

<?php 
include 'footer.php';
?>