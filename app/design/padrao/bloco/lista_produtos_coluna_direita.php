<div class="owl-item-coluna-direita"> 
	<div class="">
		<div class="shelf-item clearfix">
			<figure>
				<a  title="<?=$BlocosOfertas->tituloferta?>" href="<?php echo $BlocosOfertas->linkoferta ?>" title="<?=$BlocosOfertas->tituloferta?>">
					<img class="lazyOwl" alt="<?=$BlocosOfertas->tituloferta?>" src="<?=getImagem($team,"fit")?>" style="display: block;">
				</a>
			</figure>
			<div class="right-align titulooferta">
				<div class="titulo_resumido_modelo_padrao"><a  title="<?=$BlocosOfertas->tituloferta?>" href="<?php echo $BlocosOfertas->linkoferta ?>"> <span class="product-title"> <?=$BlocosOfertas->titulofertaresumido?> </span></a></div>
				<div class="titulo_resumido_modelo_classic" style="display:none;"> <a  title="<?=$BlocosOfertas->tituloferta?>" href="<?php echo $BlocosOfertas->linkoferta ?>"> <span class="product-title">  <?=displaySubStringWithStrip($BlocosOfertas->tituloferta,85)?> </span></a></div>
			 
				<p class="shelf-price">
					<span>
						<span class="payment-sell-home" itemprop="price"><span class="payment-currency"> R$ </span> 
						<span class="payment-price-home"> <strong> <span class="int"> <?=$BlocosOfertas->preco?> </span> </strong> </span> </span> 
						<span class="payment-price-old-home"> 
							<del> R$ <?=$BlocosOfertas->preco_antigo?> </del> 
						</span> 
					</span>
					<? if($BlocosOfertas->observacao_preco != ""){?>
					<div class="observacao_preco" style="display:none;">
						<span class="payment-price-old-home descontop"> <span class="label"> </span> 
							<del style="margin-top:16px;color:#1a75ce;width:85%;text-align:center;"> <?=$BlocosOfertas->observacao_preco?></del> 
						</span> 
					</div>
					<? }?>
				</p> 
				<div class="modelo_fit" style="display:none;">
					<div class="bar-status">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody><tr>
								<td class="valorboxca">
									<div> <span class="corcifrao">R$</span> <span class="item-por"><?=$BlocosOfertas->preco?> </span></div>
									<div class="setde">R$ <span class="item-de"><?=$BlocosOfertas->preco_antigo?></span></div>
								</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>  
			</div>
		</div>
	</div> 
</div>  