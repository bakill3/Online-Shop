<?php include 'header.php';
if (isset($_SESSION['rating'])) {
  echo $_SESSION['rating'];
  unset($_SESSION['rating']);
}
?>
<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 

if (isset($_GET['id'])) {

  $id = preg_replace('#[^0-9]#i', '', $_GET['id']); 

  $sql = mysqli_query($link, "SELECT * FROM products WHERE id='$id' LIMIT 1") or die (mysqli_query($link));
  $productCount = mysqli_num_rows($sql); 
  if ($productCount > 0) {

    while($row = mysqli_fetch_array($sql)){ 
     $p_name = $row["p_name"];
     $image = $row["image"];
     $price = $row["price"];
     $price_descontado = $row['price_descontado'];
     $descricao = $row["descricao"];
     $max_stock = $row['stock'];
     $categoria_id = $row['categoria_id'];
     if ($max_stock == 0) {
      no_login();
     }
     $detalhes = $row["detalhes"];
   }
   
 } else {
  echo "Este produto não existe.";
  exit();
}

} else {
  echo "Aconteceu um erro.";
  exit();
}


//---------------------------------------------------------------------------------------
//Selecionar a rating atualizada da tabela produtos
$query= "SELECT avg_rating FROM products WHERE id='$id';";
$avg_query = mysqli_query($link, $query);
if(mysqli_num_rows($avg_query) > 0)  {  
  while($row = mysqli_fetch_array($avg_query))  {  
    $avg_rating = $row['avg_rating'];
  }
}
if (empty($avg_rating) || $avg_rating == 0) {
  $avg_rating = "N/A";
}
//----------------------------------------------------------------------------------------
?>
<br><br>
<div class="container">
  <div class="row product">
    <form method="post" action="">
      <div class="col-md-5 col-md-offset-0" id="imagem_js"><img class="img-responsive" src="imagens/produtos/<?php echo $image ?>" /></div>
      <div class="col-md-7">
        <?php
        $busca_prom = mysqli_query($link, "SELECT * FROM promocoes WHERE ativado=1 AND id_produto='$id'");
        if (mysqli_num_rows($busca_prom) > 0) {
          $info_prom = mysqli_fetch_assoc($busca_prom);
          $desconto = $info_prom['desconto'];
          $data = $info_prom['data'];
          $tipo = $info_prom['tipo'];
          $id_promocao = $info_prom['id_promocao'];
          //echo "<h2 style='color: red'>EM PROMOÇÃO!</h2>";
          //$preco_sem_desconto = $price / $desconto;

          $data_atual = date("Y-m-d H:i:s", strtotime('-1 hour'));


          $data_n = date($data);


          $ttt = $id;
          $price_antigo = $price;
          $price = $price_descontado;
        }
        ?>
        <h2><b><?php echo $p_name ?><?php if(isset($ttt) && $ttt == $id) { ?><sup><span class="label label-danger"><?php echo round((float)$desconto * 100 ) . '%'; ?></span></sup><?php } ?>
        <?php
        if(isset($ttt) && $ttt == $id) {
            if ($data_atual > $data) {
              if ($tipo == "produto") {
                mysqli_query($link, "UPDATE products SET price_descontado=0 WHERE id='$id'");
                mysqli_query($link, "DELETE FROM promocoes WHERE id_promocao='$id_promocao' LIMIT 1");
              } elseif ($tipo == "categoria") {
                    $loo = mysqli_query($link, "SELECT * FROM products WHERE categoria_id='$categoria_id'");
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
        <sup><span class="label label-info" id="demo"></span></sup>
        <?php
        }
        ?>
        </b></h2>
        <?php 
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
        <?php
        }
        ?>
        <p><b>Descrição:</b><br><?php echo $descricao ?>  </p>
        <h3><?php echo $price ?> € <?php if ($price_descontado != 0) { ?><sup><strike><?php echo $price_antigo; ?> €</strike></sup><?php } ?></h3>
        <input type="number" name="quantity" class="form-control" placeholder="Quantidade:" min="1" max="<?php echo $max_stock; ?>" pattern="[0-9]*" />
        <input type="hidden" name="stock" value="<?php echo $max_stock; ?>" />
        <input type="hidden" name="p_name" value="<?php echo $p_name; ?>" />  
        <input type="hidden" name="price" value="<?php echo $price; ?>" />
        <input type="hidden" name="product_id" value="<?php echo $id; ?>" />
  

        <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Adicionar ao carrinho" />  
      </div>
    </form>
  </div>
  <div class="page-header">
    <h3><b>Detalhes do produto</b></h3></div>
    <p style="font-size: 130%;"><i style="font-size: 90%;"><?php echo $detalhes; ?><br><br><span style="font-weight: bold;">Stock disponível: <span style="color: #FF8833;"><?php echo $max_stock; ?></span><br>Média de estrelas: <span style="color: #FF8833;"><?php echo $avg_rating?></span></i></p>
    <br>
    <div class="page-header">
      <h3><b>Produtos Relacionados</b></h3></div>
    <div style="display: flex;justify-content: center;align-items: center;">
    <?php
    $var_y = 0;
    $relac_ligar = mysqli_query($link, "SELECT * FROM products WHERE categoria_id='$categoria_id' AND id!='$id' LIMIT 4");
    $relac_buscar = mysqli_num_rows($relac_ligar);
    if ($relac_buscar > 0) {
      while($relac_info = mysqli_fetch_array($relac_ligar)) {
        $nome_produto_relac = $relac_info['p_name'];
        $preco_produto_relac = $relac_info['price'];
        $id_produto_relac = $relac_info['id'];
        $imagem_produto_relac = $relac_info['image'];
        $descricao_produto_relac = $relac_info['descricao'];
        $descricao_curta = substr($descricao_produto_relac, 0, 20)."..";

    ?>
    <figure class="snip1396 green" data-aos="fade-in" style="width: 50%;">
                <img data-src="imagens/produtos/<?php echo $imagem_produto_relac; ?>" name="imagem" height="350"  width="200" />
                <a href="produto/<?php echo $id_produto_relac; ?>">
                  <div class="image"><img alt='<?php echo $nome_produto_relac; ?>' data-src="imagens/produtos/<?php echo $imagem_produto_relac; ?>"></div>

                  

                  <figcaption>
                    <center><h3><?php echo $nome_produto_relac; ?></h3></a></center>
                     <p>Descrição: <?php echo $descricao_curta; ?></p>

                  </figcaption>
                  <div class="price">
                    <?php echo $preco_produto_relac; ?> €
                  </div>
                </a>
            </figure>

    <?php
    $var_y++;
      }
    }
    ?>
    </div>


    <div class="page-header">
      <h3><b>Críticas </b></h3></div>
      <div class="media">
        <div class="media-body"></div>
      </div>
      <?php
      if (isset($_SESSION['username'])) {
        $sessao = $_SESSION['username'];
        ?>
        <form action="rating.php?id=<?php echo $id; ?>" method="POST">
    <div class="container">
      <div class="row">
          <div class="well well-sm">
            
                <div class="row">
                    <div class="col-md-12">
                            <input id="ratings-hidden" name="rating" type="hidden"> 
                            <textarea class="form-control animated" cols="50" id="new-review" name="comentario" minlength="10" placeholder="Escreva a sua crítica aqui..." rows="4" required></textarea><br>
                            <fieldset class="rating" required>
                        <input type="radio" id="star5" name="rating_estrelas" value="5" /><label class = "full" for="star5" title="5 estrelas"></label>
                        <input type="radio" id="star4" name="rating_estrelas" value="4" /><label class = "full" for="star4" title="4 estrelas"></label>
                        <input type="radio" id="star3" name="rating_estrelas" value="3"  /><label class = "full" for="star3" title="3 estrelas"></label>
                        <input type="radio" id="star2" name="rating_estrelas" value="2" /><label class = "full" for="star2" title="2 estrelas"></label>
                        <input type="radio" id="star1" name="rating_estrelas" value="1" /><label class = "full" for="star1" title="1 estrela"></label>
                    </fieldset>

                        <br>
                            <div class="text-right">
                                <button class="btn btn-success btn-lg" type="submit" name="rate_botao">Comentar</button>
                            </div>
                    </div>
                </div>
            </div> 
             
      </div>
    </div>
    </form>

        <br><br><br><br>
        <?php
      } else {
        echo "<h4>Se quiser comentar, faça <a href='login.php'>Login</a> ou <a href='register.php'>Registe-se</a></h4><br>";
      }
      ?>
      <?php
// Definindo a var estrelas pa dps nao dar undefined index pois só vai aparecer mais em if's
      $estrelas = "";
//MÉDIA DAS ESTRELAS/RATING -------------------------------------------------------------------------
//      $avg_rating = "SELECT AVG(rate) AS rate_avg FROM products_rating WHERE product_id='$id';";
//      $avg_query = mysqli_query($link, $avg_rating);
//      $data = $avg_query->fetch_assoc();
//      $avg_rating = $data['rate_avg'];
//
//      $avg_criticas = number_format((float)$avg_rating, 1, '.', '');
//      if ($avg_criticas == 0) {
//        $avg_criticas = "N/A";
//      } 
// ---------------------------------------------------------------------------------------------------------
//Ir buscar todas as críticas de cada produto ---------------------------------------------------------------------------
      $buscar_criticas = "SELECT * FROM products_rating WHERE product_id=(SELECT id FROM products where id='$id') ORDER BY rate_id DESC;";
      $resultado_p = mysqli_query($link, $buscar_criticas);
      if(mysqli_num_rows($resultado_p) > 0)  
      {  
        while($row = mysqli_fetch_array($resultado_p))  
        {  
          $link->set_charset("utf8");
//Definir dados retirados da tabela products_ratings
          $rate_id = htmlspecialchars(mysqli_real_escape_string($link, $row["rate_id"]));
          $rate = htmlspecialchars(mysqli_real_escape_string($link, $row["rate"]));
          $comentario = htmlspecialchars(mysqli_real_escape_string($link, $row["comentario"]));
          $user = $row["user_id"];
          $product_id = $row["product_id"];
          $sql2 = "SELECT * FROM users WHERE id='$user';";
          $result = mysqli_query($link, $sql2);  
          if(mysqli_num_rows($result) > 0)  {
            while($row2 = mysqli_fetch_array($result))  {  
              $id_do_user = $row2['id'];
              $foto_perfil_user = $row2['foto_perfil'];
              $username_user = $row2['username'];
            }
          }

//Se o rating da bd / db for 1 a var $estrelas so é uma estrela se for 2. ETC...
          if ($rate == 1) {
            $estrelas = '<span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
          }
          elseif ($rate == 2) {
            $estrelas = '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
          }
          elseif ($rate == 3) {
            $estrelas = '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>';
          }
          elseif ($rate == 4) {
            $estrelas = '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star"></span>';
          }
          elseif ($rate == 5) {
            $estrelas = '<span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span><span class="fa fa-star checked"></span>';
          }
          else {
            $estrelas = '';
          }
          ?>
          <div class="col-sm-1">
            <div class="thumbnail">
              <img class="img-responsive user-photo" data-src="<?php echo $foto_perfil_user; ?>">
            </div>
          </div>

          <div class="col-sm-11">
            <div class="panel panel-default">
              <div class="panel-heading">
                <strong><?php echo $username_user; ?></strong> <span class="text-muted"><?php echo $estrelas; ?>
                  <?php 
                  if (isset($_SESSION['username'])) {
                   if ($username_user == $sessao) { ?>
                   <form style="display: inline;" method="POST">
                      <input type="hidden" name="rate_id" value="<?php echo $rate_id; ?>">
                      <input type="hidden" name="hidden_product_id" value="<?php echo $id; ?>">
                      <button style="position:absolute;right: 2%;top: 6%; border: outset;" type="submit" class="btn btn-sm btn-danger" name="botao_eliminar"><i class="fas fa-trash-alt"></i></button>
                  </form>
                  <?php } } ?>
                </span>

              </div>
              <div class="panel-body">
                <span><?php echo $comentario; ?></span>
              </div>
            </div>
          </div>
          <br><br><br><br><br>
          <hr>
          <?php
        }
      }
//Se não encontrar resultados da query (críticas), então {
      else {
        echo "<br><br>Não há comentários.";
      }
      ?>
    </div>
    <?php include 'footer.php';?>