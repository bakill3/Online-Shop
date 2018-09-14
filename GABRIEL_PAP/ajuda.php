<?php include 'header.php';?>
<center><h1 style="font-size: 60px;" data-aos="flip-left">Ajuda</h1></center>
<img style="border-radius: 25px; border:3px solid #f7b131; float: right; padding:2px;" data-aos="flip-up" src="imagens\help.jpg" width="400" height="250"><br><br>
<center>
<div data-aos="zoom-in">
  <p style="font-size: 30px; padding-left: 420px;">Neste parte do website encontrará suporte para este website.</p><br><br><br><br><br>
  <br><br><br>
  <u><b><p style="font-size: 30px;">Precisa de ajuda em relação:</p></b></u><br>

  <div id="link1"><a href="ajuda#" style="font-size: 25px;">Funcionamento da loja</a></div><br>
  <div id="link2"><a href="ajuda#" style="font-size: 25px;">Funcionamento dos termos e política dos utilizadores</a></div><br>
  <div id="link5"><a href="ajuda#" style="font-size: 25px;">Como organizar os produtos por categorias?</a></div><br>
  <div id="link6"><a href="ajuda#" style="font-size: 25px;">Como pesquisar produtos?</a></div><br>
  <div id="link7"><a href="ajuda#" style="font-size: 25px;">Como comentar ou avaliar produtos?</a></div><br>
  <div id="link3"><a href="ajuda#" style="font-size: 25px;">Como se registar?</a></div><br>
  <div id="link4"><a href="ajuda#" style="font-size: 25px;">Como fazer login?</a></div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <div id="div1">
   <h4 class="texto_ajuda" style="font-size: 30px; color: green">Funcionamento da loja</h4>
   <hr>
   <h4 class="texto_ajuda">O funcionamento da loja é feito através de código PHP e JAVASCRIPT essencialmente, na parte do design é usado CSS.</h4>
   <hr>
 </div>
 <br><br><br><br><br><br>
 <div id="div2">
  <h4 class="texto_ajuda" style="font-size: 30px; color: green">Funcionamento dos termos e política dos utilizadores</h4>
  <hr>
  <h4 class="texto_ajuda">Termos e política dos utilizadores são...</h4>
  <hr>
</div>
<br><br><br><br><br><br>
<div id="div3">
  <h4 class="texto_ajuda" style="font-size: 30px; color: green">Como se registar?</h4>
  <hr>
  <h4 class="texto_ajuda">Para se registar aceda <a href="register.php" target="_blank">Aqui</a></h4>
  <hr>
</div>
<br><br><br><br><br><br>
<div id="div4">
  <h4 class="texto_ajuda" style="font-size: 30px; color: green">Como fazer login?</h4>
  <hr>
  <h4 class="texto_ajuda">
   Para fazer login pode aceder <a href="login.php" target="_blank">Aqui</a></h4>
   <hr>
 </div>
 <br><br><br><br><br><br>
 <div id="div5">
  <h4 class="texto_ajuda" style="font-size: 30px; color: green">Como organizar os produtos por categorias?</h4>
  <hr>
  <h4 class="texto_ajuda">
   Para ordernar os produtos com categorias (Ex: ratos, televisões) ou condições (Preços ASC e DESC); basta aceder á página <a href="loja.php" target="_blank">principal</a> (loja) e carregar na select box onde diz 'Categorias'.</h4>
   <hr>
 </div>
 <br><br><br><br><br><br>
 <div id="div6">
  <h4 class="texto_ajuda" style="font-size: 30px; color: green">Como pesquisar produtos?</h4>
  <hr>
  <h4 class="texto_ajuda">
    Para pesquisar produtos basta carregar no botão 'pesquisar' que se encontra no cabeçalho/header de todas as páginas. Para uma pesquisa mais avançada, deve clicar no botão 'pesquisa avançada' ou aceder <a href="pesquisar.php" target="_blank">aqui</a>.</h4>
   <hr>
 </div>
 <br><br><br><br><br><br>
 <div id="div7">
  <h4 class="texto_ajuda" style="font-size: 30px; color: green">Como comentar ou avaliar produtos?</h4>
  <hr>
  <h4 class="texto_ajuda">
    Para comentar ou avaliar produtos deve primeiro iniciar sessão (se ainda não tem conta pode <a href="register.php" target="_blank">registar-se</a>), depois de iniciar sessão (login) deve clicar/carregar num título/imagem de um produto na <a href="loja.php" target="_blank">loja principal</a>, depois irá ter á pagina do produto selecionado e no fundo da página encontrará onde pode comentar e avaliar o produto.</h4>
   <hr>
 </div>
 <br><br><br><br><br><br>
</center>
</div>
<script type="text/javascript">
	$("#link1").click(function() {
    $('html, body').animate({
      scrollTop: $("#div1").offset().top
    }, 2000);
  });
	$("#link2").click(function() {
    $('html, body').animate({
      scrollTop: $("#div2").offset().top
    }, 2000);
  });
	$("#link3").click(function() {
    $('html, body').animate({
      scrollTop: $("#div3").offset().top
    }, 2000);
  });
	$("#link4").click(function() {
    $('html, body').animate({
      scrollTop: $("#div4").offset().top
    }, 2000);
  });
  $("#link5").click(function() {
    $('html, body').animate({
      scrollTop: $("#div5").offset().top
    }, 2000);
  });
  $("#link6").click(function() {
    $('html, body').animate({
      scrollTop: $("#div6").offset().top
    }, 2000);
  });
  $("#link7").click(function() {
    $('html, body').animate({
      scrollTop: $("#div7").offset().top
    }, 2000);
  });
</script>
<?php include 'footer.php';?>