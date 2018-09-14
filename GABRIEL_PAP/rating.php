<?php
// Para obter ip => md5($_SERVER['REMOTE_ADDR']); 
header('Content-type: text/plain; charset=utf-8');
include 'header.php';
if (isset($_POST['rate_botao']) && isset($_GET['id'])) {
	$rating_estrelas = mysqli_real_escape_string($link, $_POST['rating_estrelas']);
	$comentario = mysqli_real_escape_string($link, $_POST['comentario']);
	$user_id = $_SESSION["username"];
	$sql = mysqli_query($link, "SELECT id FROM users WHERE username='$user_id'");
	$buscar_id = mysqli_num_rows($sql); 
	if ($buscar_id> 0) {
		while($row = mysqli_fetch_array($sql)){ 
		 $id = $row['id'];
		}
	}
	

	$produto_id = mysqli_real_escape_string($link, $_GET['id']);

	$len_comentario = strlen($comentario);
	if ($len_comentario < 10) {
		$_SESSION['rating'] = '<div class="alert alert-danger" id="alerta">
		  O seu comentário tem de ter mais de 10 caracteres.
		  </div>   <script>
		  myvar = setInterval(slidecima, 3000);
		  function slidecima() {
		    $("#alerta").fadeTo(2000, 500).slideUp(500, function(){
		      $("#alerta").slideUp(500);
		    });
		    window.clearInterval(myvar);
		  }
		  </script>';
		  echo "<script>window.location.href = 'produto/$produto_id';</script>";
	}
	elseif ($len_comentario > 100) {
		$_SESSION['rating'] = '<div class="alert alert-danger" id="alerta">
		  O seu comentário tem de ter menos de 100 caracteres.
		  </div>   <script>
		  myvar = setInterval(slidecima, 3000);
		  function slidecima() {
		    $("#alerta").fadeTo(2000, 500).slideUp(500, function(){
		      $("#alerta").slideUp(500);
		    });
		    window.clearInterval(myvar);
		  }
		  </script>';
		  echo "<script>window.location.href = 'produto/$produto_id';</script>";
	}
	elseif ($rating_estrelas == 0) {
		$_SESSION['rating'] = '<div class="alert alert-danger" id="alerta">
		  Preencha o número de estrelas.
		  </div>   <script>
		  myvar = setInterval(slidecima, 3000);
		  function slidecima() {
		    $("#alerta").fadeTo(2000, 500).slideUp(500, function(){
		      $("#alerta").slideUp(500);
		    });
		    window.clearInterval(myvar);
		  }
		  </script>';
		  echo "<script>window.location.href = 'produto/$produto_id';</script>";
	}
	elseif ($rating_estrelas > 5 || $rating_estrelas < 0) {
		$_SESSION['rating'] = '<div class="alert alert-danger" id="alerta">
		  Só pode dar estrelas de 1 a 5.
		  </div>   <script>
		  myvar = setInterval(slidecima, 3000);
		  function slidecima() {
		    $("#alerta").fadeTo(2000, 500).slideUp(500, function(){
		      $("#alerta").slideUp(500);
		    });
		    window.clearInterval(myvar);
		  }
		  </script>';
		  echo "<script>window.location.href = 'produto/$produto_id';</script>";
	}
	else {
		$sql2 = "INSERT INTO products_rating (rate, comentario, user_id, product_id) 
		VALUES ('$rating_estrelas', '$comentario', (SELECT id FROM users WHERE username='$user_id'), (SELECT id FROM products WHERE id='$produto_id'));
		";

		mysqli_query($link, $sql2) or die(mysqli_error($link));


		$avg_rating = "SELECT AVG(rate) AS rate_avg FROM products_rating WHERE product_id=(SELECT id FROM products WHERE id='$produto_id');";
		$avg_query = mysqli_query($link, $avg_rating);
		$data = $avg_query->fetch_assoc();
		$avg_rating = $data['rate_avg'];
		$avg_criticas = number_format((float)$avg_rating, 1, '.', '');

		$sql3 = "UPDATE products SET avg_rating = '$avg_criticas' WHERE id = '$produto_id';";
		mysqli_query($link, $sql3);

		echo '<script>window.location="produto/'.$produto_id.'"</script>';
	}
}
include 'footer.php';
?>