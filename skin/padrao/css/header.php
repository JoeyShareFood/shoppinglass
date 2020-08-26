<div style="display:none;" class="tips"><?=__FILE__?></div>

<script>

jQuery('document').ready(function(){
	jQuery('.SendFormSearch').click(function(){
		jQuery('.topbar-search').submit();
	});
});

</script>
 		
<div class="topbar-container"> 
	<header class="site-topbar">    
		<div class="logo"><a href="<?=$ROOTPATH?>"><img class="logotipo"  border="0" src="<?=$ROOTPATH?>/include/logo/logo.png"></a></div>
		<div class="LinksTop">
			<ul>
				<?php
					$sql = "select  *  from page where status = 1 and MainTop = 1 order by titulo";
					$rs = mysql_query($sql); 
					if(!$rs){
						echo mysql_error();
						exit;
					}				
				?> 
				<?php 
				$a = 0;
				while($l = mysql_fetch_assoc($rs)) {						
								
				  if ($a==0) { ?>
						<nav class="links-column-top">
					<? } ?>
						<li>
							<a href="<?=$ROOTPATH?>/page/<?=$l['id']?>">
								<?=utf8_decode(ucwords(mb_strtolower($l['titulo'], 'UTF-8')))?>
							</a>
						</li>	
					<? 
						$a++;
					if ($a==4) { $a =0;  ?>
						</nav> 
				<? } 
				}
				?> 
				<li><a href="#">Fale Conosco</a></li>
			</ul>
		</div>
		<div class="pesquisasite">
			<form method="post"  class="topbar-search" action="index.php">
				<input id="suggestion-search" type="text" class="input-box search-new" placeholder="Buscar" name="cppesquisa">
				<select class="search-cate notranslate" id="search-dropdown-box"><option value="0">Todas as categorias</option><option value="201001900">Roupas e Acessórios Femininos</option><option value="201001892">Roupas e Acessórios Masculinos</option><option value="201001931">Casamentos e Eventos</option><option value="201000010">Esporte e Lazer</option><option value="201000219">Jóias</option><option value="201000220">Relógios</option><option value="201000215">Mamãe e Bebê</option><option value="201000054">Telefones e Celulares</option><option value="201006247">Eletrônicos</option><option value="201000008">Casa &amp; jardim</option><option value="201000020">Eletrônicos de Consumo</option><option value="201000021">Health &amp; Beauty</option><option value="201000224">Mochilas &amp; bagagem</option><option value="201000013">Brinquedos &amp; Lazer</option><option value="201003499">Novidades e Roupas de Uso Especial</option><option value="201000015">Automóveis &amp; Motocicletas</option><option value="201000006">Computer &amp; Office</option><option value="201000016">Luzes &amp; Iluminação</option><option value="201000037">Sapatos</option><option value="201005242">Indústria e Ciência</option><option value="201000011">Escritório &amp; material escolar</option><option value="201000051">Componentes eletrônicos</option><option value="201000004">Componentes elétricos</option><option value="201000005">Ferramentas para casa</option><option value="201000007">Melhorias na casa</option><option value="201000009">Presentes &amp; artesanatos</option><option value="201000001">Comida</option><option value="201000216">Móveis</option><option value="201002790">Produtos personalizados</option><option value="201006175">Viagens e Férias</option><option value="0">Em todas as categorias</option></select>
			</form>			
			<a href="#" class="SendFormSearch"><img src="<?php echo $PATHSKIN; ?>/images/zoom.jpg"></a>
				<?php if($login_user){ ?>
				<div class="MensagemHeader">
					<p>Olá!. Seja bem vindo <?php echo getnome($login_user['id']); ?>.</p>
				</div>
				<?php } else { ?>
				<div class="MensagemHeader">
					<p>Olá!. Seja bem vindo.</p>
				</div>
				<?php } ?>
				<ul class="ListSearch">
				</ul>
			<div class="loadhead" id="loadingcontatoheader"></div>
			<div class="LinksHeader">
				<?php if($login_user){ ?>
				<ul>
					<li><a href="<?php echo $ROOTPATH; ?>/pedidos"> Pedidos</a></li> 
					<li><a href="<?php echo $ROOTPATH; ?>/sair"> Sair </a></li>
				</ul> 
				<?php } else { ?>
				<ul>	
					<li><a class='tk_logar' href="#"> Entrar </a></li> 
					<li><a class='tk_cadastrar' href="#"> Cadastrar </a></li>
					<!--<li><a class='tk_faleconosco' href="#"> Fale conosco </a></li>-->
				</ul>
				<?php }?>
				</ul>
			</div>
		</div> 
		
			<!--
			<div class="wraper-right-icons" > 
				<? if($login_user){?><div class="cart"><a href="<?=$ROOTPATH."/carrinho" ?>" class="open-link cart-link"><span class="number">1</span><span class="cart-icon"></span></a></div><? } ?>
				<div class="profile"><a href="<?=$ROOTPATH?>/pedidos" class="<? if(!$login_user){?>tk_logar<? } ?> open-link topbar-buttons icon-topbar-link"><span class="number">1</span><div class="profile-img"></div></a> </div>
			</div> 
			--> 
		   <div id="self-help-footer"> 
				
			<!--
			<div class="buttop" style="display: table; width: 22%; padding-top: 50px;"> 
				<button class="btn btn-primary btn-chat" style="padding:2px 14px;float: left; margin-right: 10px;"><span class="icon icon-chat"></span>Chat</button>
				<button style="padding:2px 14px;float:left" class="btn btn-primary btn-email"><span class="icon icon-email"></span>E-mail</button> 
			</div>
			-->
			</div>
		<!-- 
		<div class="wraper-right-icons" > 
		Cart
			<? if($login_user){?><div class="cart"><a href="<?=$ROOTPATH."/carrinho" ?>" class="open-link cart-link"><span class="number">1</span><span class="cart-icon"></span></a></div><? } ?>
			<div class="profile"><a href="<?=$ROOTPATH.'/pedidos' ?>" class="<? if(!$login_user){?> tk_logar <? } ?> open-link topbar-buttons icon-topbar-link"><span class="number">1</span><div class="profile-img" style="background: url(http://static.wmobjects.com.br/webstore/images/global/profile.png) center center;"></div></a> </div>
		 </div> 
		--> 		
		 <div id="self-help-footer" class="footer-self-help" style="border-bottom:none;padding:0;"> 
	 
		 
		</div>

		
	</header>

	<? //require(DIR_BLOCO."/bloco_menucategorias.php"); ?>

	<? require(DIR_BLOCO."/bloco_afiliados_parceiros.php"); ?>

	<?  if( mostratopo()){?>
		<div class="toptopo"></div>
	<?  } ?>

	<!-- DIV OCULTA QUE IRï¿½ ABRIR QUANDO A AUTENTICACAO FOR REQUISITADA -->  
	  <?php require_once(WWW_ROOT."/app/design/padrao/bloco/autenticacao.php"); ?>
	 <!-- FIM - DIV OCULTA QUE IRï¿½ ABRIR QUANDO A AUTENTICACAO FOR REQUISITADA -->