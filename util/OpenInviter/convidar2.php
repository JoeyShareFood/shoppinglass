<? 
require_once(dirname(dirname(dirname(__FILE__))) . '/app.php'); 
?>
<html>
<head>
 
<body>
<div style="padding:5px;  text-align:center;">

	<div style="text-align:left; float:left;display:none;" id="conteudo">
	  
			<ul class="intro_message">
			
			  <li><?=utf8_encode("<h2> Ganhe créditos para comprar ofertas</h2> ")?></li>     
			  <li><?=utf8_encode("<p style=font-size: 14px;font-weight: normal;color:#272727;padding-top:10px>Digite o seu e-mail e senha do Msn/Hotmail, Yahoo, Gmail, Facebook, Orkut ou Twitter para importar de forma fácil e prática todos os seus contatos e tenha mais chances de ganhar créditos a cada cadastro bem sucedido . <b>Este processo pode demorar alguns minutos</font></b>")?></li>     
			 </ul>
		  
			<br/>  
			<div style="text-align:left; margin:10px; font-size:14px">
			<label for="email"> Email</label> 
			 <input style="width:324px;font-size:13px;color:#000;margin-left:16px;" name="emailshare" type="text" id="emailshare"  />
			<br>			 
			<label for="email"> Senha</label>
			 <input style="width:324px;font-size:13px;color:#000;margin-left:10px;" name="passwordshare" type="password" id="passwordshare"   />
			  
			 <br><br> 
			 <a  id="btnimportar" style="margin-left:200px;" href="#" onClick="importarcontatos(document.getElementById('emailshare').value,document.getElementById('passwordshare').value );" class="link-1"><em><b>Importar contatos</b></em></a>
			<div id="loadingcontato">
           </div>
			
			<br style="clear:both"/><BR>
			
			 <li> <?=utf8_encode("<h4> O ".$INI['system']['sitename']." não armazena a senha do seu e-mail e nem dispara e-mails sem a sua autorização prévia. </h4>")?></li>
			<img style="margin-left:120px;" src="<?=$ROOTPATH?>/skin/padrao/images/icones_redes_sociais.jpg" title="<?=utf8_encode("Você pode enviar convites para os emails ou divulgar em redes sociais como orkut, facebook, twitter, msn, hotmail. Você tabém pode fazer a importação dos seus contatos de forma fácil e prática usando nosso sistema de importação")?>" alt="<?=utf8_encode("Você pode enviar convites para os emails ou divulgar em redes sociais como orkut, facebook, twitter, msn, hotmail. Você tabém pode fazer a importação dos seus contatos de forma fácil e prática usando nosso sistema de importação")?>">
	</div>
 
 </div>
 
 <div style="text-align:left; float:left;display:none;" id="naologado"  >
	  
	         <ul class="intro_message">
			
			  <li><?=utf8_encode("<h2>Faça seu login ou <a href='javascript:cadastropop();'>cadastre</a> para convidar e ganhar créditos</h2> ")?></li>     
			  <li><?=utf8_encode("<p style=font-size: 14px;font-weight: normal;color:#272727;padding-top:10px> Para você convidar os seus amigos e ganhar créditos, é nescessário que você seja cadastrado conosco. Caso já tenha login, informe os seus dados abaixo.</font></b>")?></li>     
			 </ul>
		   
	  		 <div style="text-align:left; margin:10px; font-size:14px">
			<label for="email"> Email</label> 
			 <input style="width:324px;font-size:13px;color:#000;margin-left:16px;" name="email" type="text" id="email"  />
			<br>			 
			<label for="email"> Senha</label>
			 <input style="width:324px;font-size:13px;color:#000;margin-left:10px;" name="password" type="password" id="password"   />
			  
			 <br><br> 
			 <a  id="btnimportar" style="margin-left:200px;" href="#" href="javascript:loginajax(document.getElementById('email').value,document.getElementById('password').value );" class="link-1"><em><b>Importar contatos</b></em></a>
			 <div id="loading">  </div>
			
			 <br style="clear:both"/><BR>
			
		  </div>
 
 </div>
 

</body>
 
 <? if($login_user_id){?>
	<script>
	alert(1)
		document.getElementById("conteudo").style.display="block";
		document.getElementById("naologado").style.display="none";
	</script>
	
 <? }
 else{?>
 
	 <script>
	 alert(2)
		document.getElementById("conteudo").style.display="none";
		document.getElementById("naologado").style.display="block";
	</script>
		
 <? } ?>
 
</html>
		