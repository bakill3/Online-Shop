<?php 
include 'header.php';
if (!isset($_SESSION['username'])) {
  echo "<script>window.location.href = 'login';</script>";
}
?>
<!--
<div class="table-responsive" style="background-color: white;">  
 <table class="table table-bordered">  
  <tr>  
   <th width="30%">Nome do produto</th>  
   <th width="10%">Quantidade</th>  
   <th width="15%">Preço</th>  
   <th width="15%">Total</th>  
   <th width="5%">Ação</th>  
 </tr>  
-->
<?php  
$pp_checkout_btn = ''; 
$product_id_array = '';
if(!empty($_SESSION["cart"]))  
{  
  $pp_checkout_btn .= '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_blank">
  <input type="hidden" name="cmd" value="_cart">
  <input type="hidden" name="upload" value="1">
  <input type="hidden" name="business" value="lifepageshop123@gmail.com">';
  $total_final = 0;
  $i = 0; 
  ?>
  <div class="table-responsive" style="background-color: white;">  
   <table class="table table-bordered">  
    <tr>  
     <th width="30%">Nome do produto</th>  
     <th width="10%">Quantidade</th>  
     <th width="15%">Preço</th>  
     <th width="15%">Total</th>  
     <th width="5%">Ação</th>  
   </tr>  
   <?php
   foreach($_SESSION["cart"] as $keys => $values)  
   { 
    if ($values["item_quantity"] > 10) { $values["item_quantity"] = 10; }
    if ($values["item_quantity"] < 1) { $values["item_quantity"]= 1; }
    if ($values["item_quantity"] == "") { $values["item_quantity"] = 1; } 
    $id = $values['item_id'];
    $nome_do_produto = $values["item_name"];
    $quantidade = $values["item_quantity"];
    $preco = $values["item_price"];
    $total = $values["item_quantity"] * $values["item_price"];

    $x = $i + 1;
    $pp_checkout_btn .= '<input type="hidden" name="item_name_' . $x . '" value="' . $nome_do_produto . '">
    <input type="hidden" name="amount_' . $x . '" value="' . $preco . '">
    <input type="hidden" name="quantity_' . $x . '" value="' . $quantidade . '">  
    <input type="hidden" name="item_number_' . $x . '" value="'.$x.'">';
    $product_id_array = "$id-".$values['item_quantity'].","; 
    ?>  
    <tr>  
     <td><?php echo $nome_do_produto; ?></td>  
     <td><?php echo $quantidade; ?></td>  
     <td><?php echo $preco; ?> €</td>  
     <td><?php echo number_format($total, 2); ?> €</td>  
     <td><a href="loja/delete/id/<?php echo $values["item_id"]; ?>"><span class="text-danger">Remover</span></a></td>  
   </tr>  
   <?php  
   $total_final = $total_final + ($values["item_quantity"] * $values["item_price"]);
   $i++;   
 }  
 ?>  
 <tr>  
   <td colspan="3" align="right">Total</td>  
   <td align="right"><?php echo number_format($total_final, 2); ?> €</td>  
   <?php  if (isset($_SESSION['username'])) : ?>
     <td></td>
   <?php else : ?>
     <td><a href="login" class="btn btn-sm btn-info">Login para pagamento</a></td>
   <?php endif ?> 
 </tr>  
 <?php 
 $pp_checkout_btn .= '<input type="hidden" name="custom" value="' . $product_id_array . '">
 <input type="hidden" name="notify_url" value="http://lifepage.zapto.org/sucesso.php">
 <input type="hidden" name="rm" value="2">
 <input type="hidden" name="cbt" value="Return to The Store">
 <input type="hidden" name="lc" value="US">
 <input type="hidden" name="currency_code" value="EUR">
 <button type="submit" class="btn btn-block btn-lg btn-success"><span class="glyphicon glyphicon-credit-card"></span> Pagamento</button>
 </form>'; 
} else {
    echo "<script>window.location.href = 'loja/erro/carrinho';</script>";
    echo "<center><h2><font color='red'>Não existem produtos no carrinho.</font><font color='green'> Adicione na <a href='loja'>Loja</a></font></h2></center>";
}
?>  
</table>  
</div>  
 
<?php echo $pp_checkout_btn;?>
<?php 
include 'footer.php';
?>