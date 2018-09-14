<!DOCTYPE html>
<html>
<head>
	<title>LifePage</title>
	<style type="text/css">
		* {
		box-sizing: border-box;
	}

	body {
		margin: 0;
		font-family: Arial;
		font-size: 17px;
		width: 100%;
		height: 100%;
	}

	#myVideo {
		position: fixed;
		right: 0;
		bottom: 0;
		min-width: 100%; 
		min-height: 100%;
	}

	.content {
		position: fixed;
		bottom: 0;
		top: 0;
		background: rgba(0, 0, 0, 0.5);
		color: #f1f1f1;
		width: 100%;
		height: 30%;
		padding: 20px;
		margin: auto;
	}
	.center_v { 
		margin: 0 auto; width: 400px; 
	}
	#logotipo {
		width: 20%;
	}
	.btn-circle {
	  width: 30px;
	  height: 30px;
	  text-align: center;
	  padding: 6px 0;
	  font-size: 12px;
	  line-height: 1.428571429;
	  border-radius: 15px;
	}
	.btn-circle.btn-xl {
	  width: 50px;
	  height: 50px;
	  padding: 10px 14px;
	  font-size: 22px;
	  line-height: 1.33;
	  border-radius: 35px;
	}

	#caixa {
		height: 300px;
	}

	@media only screen and (max-width: 750px) {
		#texto {
			font-size: 10px;
		}
		h3 {
			font-size: 10px;
		}
		#botao {
			width: 90px;
			height: 45px;
			font-size: 150%;
		}
		#logotipo {
			width: 50%;
		}

		.btn-circle {
		  width: 20px;
		  height: 20px;
		  text-align: center;
		  padding: 6px 0;
		  font-size: 12px;
		  line-height: 1.428571429;
		  border-radius: 15px;
		}
		.btn-circle.btn-xl {
		  width: 40px;
		  height: 40px;
		  padding: 8px 10px;
		  font-size: 20px;
		  line-height: 1;
		  border-radius: 25px;
		}
		#caixa {
			height: 220px;
		}

	}

	#alinka {
		color: white;
	}

	</style>

	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Work+Sans"> -->

	<!-- REFERÊNCIAS BOOTSTRAP CSS -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<link href="fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<video class="center_v" autoplay muted loop id="myVideo">
		<source src="imagens/video2.mp4" type="video/mp4">
			Your browser does not support HTML5 video.
		</video>

		<div class="content" id="caixa">
			<center>
			<div id="texto">
				<img src="imagens\logo2.png" id="logotipo">
				<p>Bem-Vindo à loja LifePage. Nesta loja encontrará vários artigos em que poderá compra-los online e provavelmente lhe poderão interessar.</p>
				<a href="loja"><button type="submit" id="botao" class="btn-lg btn-primary btn-success"><span class="glyphicon glyphicon-shopping-cart"></span> Loja</button></a><br>
				<a href="download/LifePage.apk" target="_blank" id="a_linka"><button type="button" class="btn btn-info btn-circle btn-xl"><i class="fab fa-android"></i></button><!--<h3>Para Android <i class="fab fa-android"></i></h3>--></a><br>
			</div>
			</center>
		</div>
	</body>
	</html>




	