<?php  
include 'header.php';
	if (isset($_SESSION['username'])) {
	$sessao = $_SESSION['username'];
	$pp_checkout_btn = ''; 
	$product_id_array = '';
		$sql_carrinho = "SELECT * FROM carrinho INNER JOIN users ON carrinho.user_id=users.id WHERE carrinho.user_id = (SELECT id FROM users WHERE username='$sessao')";
		$sql_select_carrinho = mysqli_query($link, $sql_carrinho) or die(mysqli_error($link));
		$resultado_carrinho = mysqli_num_rows($sql_select_carrinho);

		$total_final = 0;
		$carrinho_num = 0;
		$i = 0; 
		$paypal_url = 'https://www.sandbox.paypal.com/';
		$pp_checkout_btn .= '<form action="'.$paypal_url.'/cgi-bin/webscr" name="myform" id="myform" method="post">
		<input type="hidden" name="cmd" value="_cart">
		<input type="hidden" name="upload" value="1">
		<input type="hidden" name="business" value="lifepageshop123@gmail.com">';
		if ($resultado_carrinho > 0) {
		?>
		<?php
			while ($row = mysqli_fetch_array($sql_select_carrinho)) {
				$carrinho_id = $row['carrinho_id'];
				$nome_do_produto = $row['nome_do_produto'];
				$preco_do_produto = $row['preco_do_produto'];
				$quantidade = $row['quantidade'];
				$product_id = $row['product_id'];
				$user_id = $row['user_id'];

				$carrinho_num++;
				$total = $quantidade * $preco_do_produto;

				$x = $i + 1;
				$pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $nome_do_produto . '">
				<input type="hidden" name="amount_' . $x . '" value="' . $preco_do_produto . '">
				<input type="hidden" name="quantity_' . $x . '" value="' . $quantidade . '">  
				<input type="hidden" name="item_number_' . $x . '" value="'.$x.'">';

				$product_id_array = "$product_id-".$quantidade.","; 

		?>
		  
		<?php
			$total_final = $total_final + ($quantidade * $preco_do_produto);
			$i++; 
			}
		?>
		<?php 
		$pp_checkout_btn .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
		<input type="hidden" name="notify_url" value="http://lifepage.zapto.org/sucesso.php">
		<input type="hidden" name="rm" value="2">
		<input type="hidden" name="cbt" value="Voltar para a loja">
		<input type="hidden" name="lc" value="PT">
		<input type="hidden" name="currency_code" value="EUR">

		</form>'; 
		
		?>  
		   
		<?php 
		if (isset($_SESSION['username'])) {
			echo $pp_checkout_btn;
		} else {
			?>
			<td><a href="login" class="btn btn-block btn-lg btn-info">Login para pagamento</a></td>
			<?php 
		}
// SE NAO HOUVER PRODUTOS ENTAO
	}
}
?>
<center><h1>Por favor espere enquanto o redirecionamos para o paypal...</h1></center>
<script type="text/javascript">
document.getElementById("myform").submit();
</script>
<?php include 'footer.php'; ?>
