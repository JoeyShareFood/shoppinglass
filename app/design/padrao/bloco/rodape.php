<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.9&appId=1139171752771007";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
 <div id="rodape">
	<div class="go-to-top-container">
		<div class="go-to-top hide"></div>
	</div> 
	<div id="self-help-email" class="self-help-email mfp-hide">
		<form name="form-email" method="post" action="">
			<div class="email-content form-horizontal"><strong class="title">Atendimento por e-mail</strong><p>Olá, selecione as opções abaixo para que possamos te ajudar:</p>
				<div class="form-group row visited">
					<label for="request-type" class="col-name">Assunto</label>
					<div class="col-value select">
						<span class="select">
							<select style="height:39px;width:545px;padding:7px 9px;" name="request-type">
							<option value="">Selecione</option>
							<option value="Entrega" data-key="entrega">Entrega</option>
							<option value="Financeiro" data-key="financeiro">Financeiro</option>
							<option value="Produtos" data-key="produtos">Produtos</option>
							<option value="Comprar" data-key="Comprar">Comprar</option> 
							<option value="Minha conta" data-key="sua-conta">Minha conta</option>
							<option value="Serviços" data-key="servicos">Serviços</option> 
							<option value="Outros" data-key="outros">Outros</option>
							<option value="Trocas e Devoluções" data-key="trocas-e-devolucoes">Trocas e Devoluções</option></select>
						</span>
					</div>
				</div>
			
				<div class="form-group row visited not-logged-in-fields ">
					<label for="order-number" class="col-name">Nome</label><div class="col-value">
						<input type="text" name="first-name"></input></div>
				</div> 
				
				<div class="form-group row visited not-logged-in-fields">
					<label for="order-number" class="col-name">E-mail</label><div class="col-value">
						<input type="text" name="email"></input></div>
				</div>
				<div class="form-group row visited not-logged-in-fields">
					<label for="order-number" class="col-name">Telefone</label><div class="col-value">
						<input type="text" name="phone"></input></div>
				</div>
					<div class="form-group row visited">
					<label for="user-comments" class="col-name">Mensagem</label><div class="col-value row">
						<textarea name="user-comment" placeholder="Digite aqui seu comentário..." rows="6"></textarea></div>
				</div>
				
				<div class="form-group row clearfix email-submit">
					<input class="btn btn-primary" type="submit" value="Enviar"></input><span>ou</span><a id="form-email-cancel" href="#">Cancelar</a></div>
			</div>
		</form>
	</div>
	<div class="footer-links clearfix"> 
		<div class="block-footer">
			<div class="title-footer">
				Sobre nós
			</div>
			<div class="content-footer">
				<p>
					<?php
						$pagina = Table::Fetch('page', 24);
						echo strip_tags($pagina['value']);
					?>
				</p>
			</div>
		</div>		
		<div class="block-footer">
			<div class="title-footer">
				Fale com a gente
			</div>
			<div class="content-footer">
				<p style="text-align:justify;">
					Nosso modelo de trabalho não suporta atendimento telefônico. 
					Oferecemos atendimento online rápido e eficiente e te ajudaremos em que for necessário, beleza?
					<?php
						if($INI['mail']['from'] != "") {
					?>
					<p style="width: 100%; color:#D95D77;font-size: 13px; margin-left: 3px; float: left; margin-top: 1px; margin-right: 5px;">
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
						<a href="<?php echo $ROOTPATH; ?>/contato">
							vem cá que vamos te ajudar
						</a>
					</p>
					<?php } ?>
				</p>
			</div>
		</div>		
		<div class="block-footer">
			<div class="title-footer">
				Siga o <?php echo $INI['system']['sitename'];?>
			</div>
			<div class="content-footer">
				<ul>
					<li>
						<a href="<?php echo $INI['other']['facebook'];?>" target="_blank">
							<img src="<?php echo $PATHSKIN; ?>/images/1495212537_fb.png" style="max-width:40px;">
						</a>
					</li>					
					<li>
						<a href="<?php echo $INI['other']['orkut'];?>" target="_blank">
							<img src="<?php echo $PATHSKIN; ?>/images/1495212558_instagram.png" style="max-width:40px;">
						</a>
					</li>					
					<li>
						<a href="<?php echo $INI['other']['youtube'];?>" target="_blank">
							<img src="<?php echo $PATHSKIN; ?>/images/1495212564_youtube.png" style="max-width:40px;">
						</a>
					</li>
				</ul>
				<div class="fb">
					<div class="fb-page" data-href="<?php echo $INI['other']['box-facebook'];?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?php echo $INI['other']['box-facebook'];?>" class="fb-xfbml-parse-ignore"><a href="<?php echo $INI['other']['box-facebook'];?>"><?php echo $INI['system']['sitename'];?></a></blockquote></div>
				</div>
			</div>
		</div>
		
		<div class="links-department"  style="display:none;"><strong class="links-department-title">Navegação</strong><nav class="links-column-department">
			<ul >
				<?php 
				$i = 0;
				while($l = mysql_fetch_assoc($rs)) {	
					$tituloseo =  removeAcentos(str_replace(" ","+",mb_strtolower($l[name])));				
					if ($i%6==0) { ?>
						<nav class="links-column-department">
					<? } ?>
						<li class="links-item"  id="<?=$l['id']?>">
							<a class="more-about-item" style="font-size:14px;" title="<?=utf8_decode($l['name'])?>" href="<?=$ROOTPATH?>/page/<?=$l['id']?>">
								<span><span class="icon" id="sp_<?=$l['id']?>"></span></span><?=utf8_decode($l['titulo'])?>
							</a>
						</li>	 
					<? 
					$i++;
					if ($i%6==0) { ?>
						</nav> 
				<? } 
				}
				?> 
			</ul>
		</div> 
	</div> 
	<!-- Até Aqui -->
	
	<?php
		$sql = "select  *  from page where status = 1 order by id limit 10";
		$rs = mysql_query($sql); 	
	?>
	 
	<div class="footer-flags clearfix">
		<p style="color:#797979;">
			&copy; <?php echo date('Y'); ?> - <?php echo $INI['system']['sitename'];?> - Todos os direitos reservados
		</p>
		<ul style="margin-top:0px;">
			<?php
				while($line = mysql_fetch_array($rs)) {
					$tituloseo =  removeAcentos(str_replace(" ","+",mb_strtolower($line[name])));				
			?>
			<li>
				<a class="more-about-item" style="font-size:14px;" title="<?=utf8_decode($line['name'])?>" href="<?=$ROOTPATH?>/page/<?=$line['id']?>">
					<span><span class="icon" id="sp_<?=$line['id']?>"></span></span><?=utf8_decode($line['titulo'])?>
				</a>
			</li>
			<?php } ?>
			<li>
				<a class="more-about-item" style="font-size:14px;" href="<?php echo $ROOTPATH; ?>/faq">
					Dúvidas frequentes
				</a>
			</li>
		</ul>		
		<ul style="margin-top:0px;">
			<li>
				<a class="more-about-item" href="<?php echo $ROOTPATH; ?>/contato">
					Fale com a gente
				</a>
			</li>						
		</ul>
	</div>
	<div>
	  <a target="_blank" href="<?=$ROOTPATH?>/index.php?page=urls"><img src="<?=$ROOTPATH?>/skin/padrao/logofooter.png"></a>
          <p class="text-xs-center">Copyright © <?=date('Y')." - ".$INI['system']['sitename']?> Todos os direitos reservados.</p>
	</div>
	<?php echo  $INI['system']['rodapetexto2'] ; ?> 
	  
	<div id="law-of-repentance-modal" class="law-of-repentance-modal mfp-hide"><strong class="modal-title">Direito de Arrependimento</strong><p>Nos termos do artigo 49 do Código de Defesa do Consumidor, "o consumidor pode desistir do contrato, no prazo de 7 dias a contar de sua assinatura ou do ato de recebimento do produto ou serviço, sempre que a contratação de fornecimento de produtos e serviços ocorrer fora do estabelecimento comercial, especialmente por telefone ou a domicílio".</p>
	</div>
	<div id="modal-message" class="modal-message mfp-hide">
		<div class="content"><strong class="title"></strong>
			<p><span class="icon"></span><span class="message"></span></p>
			<input class="btn btn-primary" type="submit"></input></div>
	</div> 	  
 </div> 	  

 <!-- DIV OCULTA QUE IR? ABRIR QUANDO A AUTENTICACAO FOR REQUISITADA -->  
  <?php require_once(WWW_ROOT."/app/design/padrao/bloco/autenticacao.php"); ?>
 <!-- FIM - DIV OCULTA QUE IR? ABRIR QUANDO A AUTENTICACAO FOR REQUISITADA -->

<script type="text/javascript" src="<?=$ROOTPATH?>/js/global.js"></script>
<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if (false !== strpos($url,'departamento')) {
?>
	<script type="text/javascript" src="<?=$ROOTPATH?>/js/department.js"></script> 
<? 
}
else if (false !== strpos($url,'produto')) {
?>  
<? 
}
else {
?>
	<script type="text/javascript" src="<?=$ROOTPATH?>/js/home.js"></script> 
<? 
}
?>
<script type="text/javascript" src="<?=$ROOTPATH?>/js/product.js"></script> 
<div style="display:none;" class="webdeveloper"><a  style="margin-left:10px;"href="#" onclick="javascript:J('.tips').css('display', 'block')">Ver local dos arquivos</a> | <a href="#" onclick="javascript:J('.tips').css('display', 'none')">Ocultar local dos arquivos</a>  | <a href="#" onclick="javascript:J('.webdeveloper').css('display', 'none')">Desligar Tkstore developer</a> <a style="float:left;" href="http://www.sistemacomprascoletivas.com.br" target="_blank"><img title="Vipcom - O seu sistema de compras coletivas definitivo - o melhor script de compra coletiva da atualidade." alt="Vipcom - O seu sistema de compras coletivas definitivo - o melhor script de compra coletiva da atualidade." src="<?=$PATHSKIN?>/images/logoweb.png" /></a></div>

			
<link rel="stylesheet" href="<?=$ROOTPATH?>/js/colorbox/colorbox.css" type="text/css"  /> 
	<script type="text/javascript" src="<?=$ROOTPATH?>/js/colorbox/jquery.colorbox-min.js"></script>

	 <script>
	J(document).ready(function(){
		  
	<?php
	$navegador = getNavegador(); 
	?> 
			
	 <? if($navegador=="IE" or $navegador=="other"){ ?>
			J(".tk_logar").colorbox({inline:true, href:"#inline_logar",width:"400px",height:"490px"}); 
			J(".tk_termosdeuso").colorbox({inline:true, href:"#inline_termosdeuso",width:"600px",height:"590px"}); 
			J(".tk_combinarcomvendedor").colorbox({inline:true, href:"#inline_combinarcomvendedor",width:"98%",height:"680px"}); 
			J(".tk_cadastrar").colorbox({inline:true, href:"#inline_cadastrar",width:"950px",height:"660px"}); 
			J(".tk_alterar_dados").colorbox({inline:true, href:"#inline_alterar_dados_minha_conta",width:"950px",height:"630px"}); 
			J(".tk_altera_endereco").colorbox({inline:true, href:"#inline_altera_endereco",width:"950px",height:"430px"}); 
			J(".tk_altera_cobranca").colorbox({inline:true, href:"#inline_altera_cobranca",width:"950px",height:"430px"}); 
			J(".tk_esquecisenha").colorbox({inline:true, href:"#inline_esquecisenha",width:"450px",height:"210px"});  
			J(".importarcontatos").colorbox();
			J(".linkyoutube").colorbox({iframe:true, innerWidth:425, innerHeight:344}); 
		 <? } 

		else {?>
		
			J(".tk_logar").colorbox({inline:true, href:"#inline_logar",width:"400px",height:"490px"}); //width:"50%",
			J(".tk_termosdeuso").colorbox({inline:true, href:"#inline_termosdeuso",width:"600px",height:"590px"}); //width:"50%",
			J(".tk_combinarcomvendedor").colorbox({inline:true, href:"#inline_combinarcomvendedor",width:"100%",height:"680px"}); 
			J(".tk_cadastrar").colorbox({inline:true, href:"#inline_cadastrar"}); //width:"80%", 
			J(".tk_alterar_dados").colorbox({inline:true, href:"#inline_alterar_dados_minha_conta"}); //width:"80%", 
			J(".tk_altera_endereco").colorbox({inline:true, href:"#inline_altera_endereco"}); //width:"80%", 
			J(".tk_altera_cobranca").colorbox({inline:true, href:"#inline_altera_cobranca"}); //width:"80%", 
			J(".tk_esquecisenha").colorbox({inline:true, href:"#inline_esquecisenha"}); //width:"35%",
			J(".importarcontatos").colorbox();
			J(".linkyoutube").colorbox({iframe:true, innerWidth:425, innerHeight:344}); 
		<? } ?>
	  
	});
	</script> 
	
	<? if($INI['option']['bloco_tkdeveloper'] == "Y"){?>
		<script>
			J('.webdeveloper').css('display', 'block')
		</script>
	<? } ?> 
	