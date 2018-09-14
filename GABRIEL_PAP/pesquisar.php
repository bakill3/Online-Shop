<?php include "header.php" ?>
<div class="container">
	<br />
	<br />
	<br />
	<h2 align="center">Pesquisa avançada de produtos</h2><br />
	<h4 align="center">Aqui poderá procurar produtos pelo nome, pelo preço, pela descrição e muito mais...</h2><br />
		<div class="form-group">
			<div class="input-group">
				<input type="text" id="search_text_2" maxlength="50" placeholder="Pesquisar por produtos." class="form-control" />
				<span class="input-group-addon"><i class="fas fa-search"></i></span>
			</div>
		</div>
		<br />
		<div id="result_mlg"></div>
	</div>
	<div style="clear:both"></div>
	<br />
	
	<br />
	<br />
	<br />
	<script>
		$(document).ready(function(){
			load_data();
			function load_data(query)
			{
				$.ajax({
					url:"fetch.php",
					method:"post",
					data:{query:query},
					success:function(data)
					{
						$('#result_mlg').html(data);
					}
				});
			}
			
			$('#search_text_2').keyup(function(){
				var search = $(this).val();
				if(search != '')
				{
					load_data(search);
				}
				else
				{
					load_data();			
				}
			});
		});
	</script>
	<?php include "footer.php" ?>







