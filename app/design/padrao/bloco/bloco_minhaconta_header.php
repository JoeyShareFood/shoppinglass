<div style="display:none;" class="tips"><?=__FILE__?></div> 
<div class="my-account-page" id="my-account-container">
	<div id="my-account-header">
		<div class="my-account">
			<div class="profile-top clearfix">
				<div class="profile-info pull-left">
					<div data-complete="........." data-fields="9" id="profile-completeness">
						<a class="profile-photo" href="#profile">
							<span class="profile-photo-container">
							<img width="110" height="110" src="http://static.wmobjects.com.br/selfhelp/desktop/styles/images/user-picture.jpg"></span>
						</a>
						<svg height="150" version="1.1" width="150" xmlns="http://www.w3.org/2000/svg" style="overflow: hidden; position: relative; left: -0.5px;"><desc></desc><defs/><path style="fill-opacity: 0;" fill="none" stroke="#ffffff" d="M75,21A54,54,0,1,1,74.99,21" stroke-width="6" fill-opacity="0" class=""/><path style="fill-opacity: 0;" fill="none" stroke="#f7f7f7" d="M75,3A72,72,0,1,1,74.99,3" stroke-width="15" fill-opacity="0"/><path style="fill-opacity: 0;" fill="none" stroke="#f2f2f2" d="M75,12A63,63,0,1,1,74.99,12" stroke-width="14" fill-opacity="0"/><path style="fill-opacity: 0;" fill="none" stroke="#f47b20" d="M75,12A63,63,0,1,1,74.99,12" stroke-width="14" fill-opacity="0"/></svg>
					</div> 
				</div>
				<div class="profile-summary pull-left">  
					<!--<h2 class="title"> Detalhes do Pedido: <span class="highlight"><?=$order_id?></span></h2>-->
					<ul class="link-list"><li><a href="<?=$ROOTPATH?>/index.php?page=minhaconta">Voltar para meus pedidos</a></li> </ul>
					<ul class="link-list"><li><a class="tk_alterar_dados" href="#">Alterar meus dados</a></li> </ul>
					<? if(!empty($order[data_ultima_atualizacao])){?><div style="font-size:12px;float:right;">última atualização:  <?=data($order[data_ultima_atualizacao])?></div><? } ?>
				</div>  
				
				<!--
				<div  class="profile-summary pull-left myaccountbk">   
					 <div><b>Realizado em:</b> <?=data($order[datapedido])?> </div>
					  
					<? if($order[statuspedido]=="cancelado"){?>
						<div class="highlight"><b> Cancelado em: </b><?=data($order[datacancelamento])?>  </div>
					<? } 
					else if($order[statusentrega]=="Pedido entregue"){?>
						<div class="highlight"> <b> Entregue em: </b><?=data($order[data_ultima_atualizacao])?> </div>
					<? }
					else if($order[statusentrega]!=""){?>
						<div class="highlight"><b> <?=utf8_decode($order[statusentrega])?> </b>  <?=data($order[data_ultima_atualizacao])?></div>
					<? } 
					else if($order[state]=="pay"){?>
						<div style="color:#31AA39"><b> Pago em: </b><?=data($order[datapagamento])?></div>
					<? }
					else if($order[state]=="unpay"){?> 
					<div class="highlight"><b>Aguardando pagamento </b> </div>
					<? } ?>
					<? if(!empty($order[service])){?> <div><b>Método:</b> <?=$order[service]?> </div><? } ?>
				 </div>
				
				<div  class="profile-summary pull-left myaccountbk">    
					 <div><b>Valor do pedido:</b> R$ <?=number_format($order[origin], 2, ',', '.') ?>  </div>
					 <div><b>Frete:</b> R$ <?=number_format($order[valorfrete], 2, ',', '.') ?> </div>
					 
					 <? if(!empty($order[codigorastreio])){?><div><b>Código dos correios:</b> <?=$order[codigorastreio]?></div><? } ?>
					 <? if(!empty($order[codigovalecompras])){?><div><b>Vale Compras:</b> R$ <?=number_format($order[valecompras], 2, ',', '.') ?> </div> <? } ?>
					 <? if(!empty($order[codigovalecompras])){?><div><b>Cupom:</b> <?=$order[codigovalecompras] ?> </div> <? } ?>
				</div> 
				-->
			</div>
		</div>
	</div>
</div>