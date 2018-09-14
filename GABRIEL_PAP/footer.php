<!--
TRABALHO PAP
FEITO POR GABRIEL BRANDÃO
2017/2018
RODAPÉ
-->
<footer>
        <div class="row">
            <div class="col-md-4 col-sm-6 footer-navigation">
                <h3><a href="https://www.aemtg.pt/" target="_blank"><img style="border-radius: 50px;" data-src="imagens\esmtg.png" width="250" height="70"></a></h3>
                <p class="links"><a href="loja">Loja </a><strong> · <a href="ajuda">Ajuda </a><strong> · </strong><a href="sobre">Sobre </a></p>
                <p class="company-name">LifePage © 2017-<?php echo date("Y");?> </p>
            </div>
            <div class="col-md-4 col-sm-6 footer-contacts">
                <div><span class="fa fa-map-marker footer-contacts-icon"> </span>
                    <p><span class="new-line-span">Cidade: </span>Portimão</p>
                </div>
                <div><span class="fa fa-phone footer-contacts-icon"></span>
                    <p class="footer-center-info email text-left"> +351 968937031</p>
                </div>
                <div><span class="fa fa-envelope footer-contacts-icon"></span>
                    <p>deostulti2@gmail.com </p>
                </div>
            </div>
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-4 footer-about">
                <h4>Sobre a "empresa":</h4>
                <p>Isto é uma simulação de uma loja online. Trabalho para PAP (Gabriel Brandão) 2017/<?php echo date("Y");?></p>
                <?php /*
                <div class="social-links social-icons"><a href="#"><span class="fa fa-facebook"></span></a><a href="#"><span class="fa fa-twitter"></span></a><a href="#"><span class="fa fa-linkedin"></span></a><a href="#"><span class="fa fa-github"></span></a></div> */ ?>
            </div>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/aos.js"></script>
    <script src="lazyload/lazyload.min.js"></script>
        <script>
        new LazyLoad();
    </script>
    <script>
      AOS.init({
        easing: 'ease-in-out-sine'
      });
    </script>
</body>

</html>