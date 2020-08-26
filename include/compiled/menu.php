<script type="text/javascript">
$(function() {
  if ($.browser.msie && $.browser.version.substr(0,1)<7)
  {
	$('li').has('ul').mouseover(function(){
		$(this).children('ul').show();
		}).mouseout(function(){
		$(this).children('ul').hide();
		})
  }
});        
</script>

<ul id="menu">  
<li><a href="/vipmin/misc/index.php">Painel</a>  </li>  
<li><a href="/vipmin/misc/index.php">Gerenciar</a>
	 <ul>   
		<li> <a target="_blank" href="/index.php"><?=utf8_encode("Visualizar Site")?></a> </li>   
		<li> <a href="/vipmin/misc/subscribe.php"><?=utf8_encode("Inscritos")?></a> </li>      	
	</ul>
</li>
	 
<li><a href="#">Layout</a>
	 <ul>
		<li> <a href="/vipmin/system/logo.php"><?=utf8_encode("Alterar Logo")?></a> </li>   
		  <li> <a href="/vipmin/system/cores.php"><?=utf8_encode("Alterar Layout e Cores")?></a> </li> 
		<li> <a href="/vipmin/system/imagens.php"><?=utf8_encode("Gerenciar Imagens")?></a></li>  
		<li> <a href="/vipmin/system/banners.php"><?=utf8_encode("Slide de Banners")?></a> </li>
		<li> <a href="/vipmin/system/bulletin.php"><?=utf8_encode("Banners e Avisos")?></a> </li>		
		<!-- <li> <a href="/vipmin/system/produtos.php"><?=utf8_encode("Modelos Produtos")?></a> </li>		-->
	</ul>
 </li> 
<li><a href="/vipmin/team/index.php"><?=utf8_encode("Anúncios")?></a>
	<ul> 
		<li>
			<a href="/vipmin/team/edit.php"><?=utf8_encode("Cadastrar anúncios")?> </a>       
			<a href="/vipmin/team/index.php"><?=utf8_encode("Consultar anúncios")?> </a>   
			<a href="/vipmin/user/question.php"><?=utf8_encode("Perguntas")?> </a>			
			<a href="/vipmin/user/answer.php"><?=utf8_encode("Respostas")?> </a>			
		</li>
	</ul>
</li> 
<li><a href="/vipmin/order/index.php"><?=utf8_encode("Pedidos")?></a>
	<ul> 
		<li>
			<a href="/vipmin/order/index.php"><?=utf8_encode("Consultar Pedidos")?> </a>  
			<a href="/vipmin/user/qualification.php"><?=utf8_encode("Qualificações")?> </a>
		</li>
	</ul>
</li> 
<li><a href="/vipmin/user/index.php"><?=utf8_encode("Usuários")?></a>
	<ul> 
		<li>
			<a href="/vipmin/user/edit.php"><?=utf8_encode("Cadastrar Usuários")?> </a>
			<a href="/vipmin/user/index.php"><?=utf8_encode("Consultar Usuários")?> </a>

		</li>
	</ul>
</li> 

<li><a href="/vipmin/billing/index.php">Faturas</a></li>

<li><a href="/vipmin/system/page.php"><?=utf8_encode("Páginas")?></a></li>  
	<li> <a href="/vipmin/category/index.php?zone=group">Categorias</a> </li>   

<li><a href="/vipmin/system/index.php">Sistema</a>
 <ul> 

	 <li> <a href="/vipmin/system/index.php"><?=utf8_encode("Informações Básicas")?></a> </li>
	<li> <a href="/vipmin/system/option.php"><?=utf8_encode("Configurações")?></a> </li>		<li> <a href="/vipmin/system/faq.php">FAQ</a> </li>  
	<li> <a href="/vipmin/system/pay.php"><?=utf8_encode("Métodos de Pagamento")?></a> </li>
	<li> <a href="/vipmin/system/email.php"><?=utf8_encode("Configurar E-mails")?></a> </li> 
	<li> <a href="/vipmin/system/redes.php?pg=redessociais"><?=utf8_encode("Redes Sociais")?></a> </li> 
	<li> <a href="/vipmin/misc/backup.php"><?=utf8_encode("Backup dos Dados")?></a> </li> 
	<li>  <a href="/vipmin/user/manager.php">Administrador</a> </li>
	<li> <a href="/vipmin/system/page.php"><?=utf8_encode("Páginas Estáticas")?></a> </li>	 
</ul>
</li>
</ul> 
