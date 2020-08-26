<? if($INI['option']['newsletterhome'] !="N"){ ?>
	<style>
		.newsletter .btn-send,
		.newsletter .btn-send:hover {
			background-color: #01aab5 !important;
			border-color: #01aab5 !important;
		}
	</style>
	<div style="display:none;height:36px;" class="tips"><?=__FILE__?></div>
	<div class="newsletter bar  hide show-opt-in add-shop" style="display: block;">  
		<div class="content"> 
			<div style="float:left;margin-right:11px;display:none;"><img src="<?=$PATHSKIN?>/images/iconeemailtrans.png"></div>
			<div class="title">
				<span style="text-transform:uppercase;font-weight:bold;color:#7d0a41;font-size:18px !important;"><b>EI, PSIU! TÁ A FIM DE VENDER AINDA MAIS?</b></span> <br /> 
			</div>
			<span style="color:#FFF;font-size:16px !important;">Você que tem um <b>Brechó</b> ou uma <b>Loja</b>, crie agora mesmo sua lojinha no <?php echo $INI['system']['sitename'];?> e comece a vender em todo o Brasil roupas, calçados, acessórios, artigos de casa, equipamentos eletrônicos, livros, bibelôs, produtos vintage e muito mais!!</span>
			<br/>
			<a class="btn btn-login-admin <?php if(!($login_user)) { ?>tk_cadastrar<?php } ?>" href="<?php if(!($login_user)) { ?>#<?php } else { ?><?php echo $ROOTPATH; ?>/adminanunciante/<?php } ?>" style="font-family: 'Arvo',serif;padding: 8px;font-family:11px;">Criar lojinha agora</a>
		</div>
	</div> 	
	<div class="newsletter bar  hide show-opt-in" style="display: block;">  
		<div class="content"> 
			<div style="float:left;margin-right:11px;display:none;"><img src="<?=$PATHSKIN?>/images/iconeemailtrans.png"></div>
			<div class="title">
				<span style="color:#7D0A41;font-weight:bold;font-family: 'Calibri',serif;font-size:18px !important;">Cadastre-se e fique por dentro.</span>
			</div>
			<!--<input placeholder="Seu nome" name="newsletterClientNome" maxlength="16" class="input-box newsletter-client-name" id="newsletterClientNome">-->
			<input  type="email" placeholder="Seu e-mail" name="newsletterClientEmail" maxlength="100" class="input-box newsletter-client-email" id="newsletterClientEmail">
			<button onclick="envianewsletter();" class="btn btn-send btn-warning btn-send-ok" id="newsletterButtonSend" style="font-family: 'Arvo',serif;padding: 8px;font-family:12px;">inscreva-se</button>
		</div>
	</div> 
<? } ?>