<?php
include 'ligar_db.php';
$output = '';
if(isset($_POST["query"]))
{
  $search = mysqli_real_escape_string($link, $_POST["query"]);
  $query = "
  SELECT * FROM products 
  WHERE p_name LIKE '%".$search."%' OR price LIKE '%".$search."%' OR descricao LIKE '%".$search."%' LIMIT 5;";
 

$result = mysqli_query($link, $query);
if (!mysqli_query($link, $query))
{
  echo("Erro: " . mysqli_error($link));
}
if(mysqli_num_rows($result) > 0)
{
  $output .= '<ul class="suggestions" style="max-height: 30%; max-width: 250%;"><li style="background-color: salmon;">Pressione ENTER para pesquisar</li>';
  while($row = mysqli_fetch_array($result))
  {
     $id_produto = $row['id'];
    $selecionar_imagem = mysqli_query($link, "SELECT image FROM products WHERE id='$id_produto'");
    $busca_img = mysqli_fetch_assoc($selecionar_imagem);
    $img = $busca_img['image'];
    $output .= '<a href="produto/'.$row["id"].'"><li><img src="imagens/produtos/'.$img.'" style="width: 13%;">'.$row["p_name"].'</li></a>';
  }
  echo $output;
}
else
{
  $output .= 'ua';
}
}
?>