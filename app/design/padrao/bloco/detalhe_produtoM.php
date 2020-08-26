		<div style="display:none;" class="tips"><?=__FILE__?></div>
		<style>
			.options-color {
				margin-bottom: 15px;
			}
			.end-options-message {
				margin-top: 0px;
				margin-bottom: 20px;
			}
		</style>
		<?php setUrl(); ?>
		<div class="productsPage">
			<div class="deal-page-title"> 
				<?php echo utf8_decode(mb_ucfirst(strtolower($team['title'])));  ?>
			</div>	
			<div class="contentProductPage">
				<ul class="rslides" id="slider-offer-mobile">
				<?php if($BlocosOfertas->imagemoferta) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta; ?>">
					</li>
				<?php } ?>				
				<?php if($BlocosOfertas->imagemoferta2) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta2; ?>">
					</li>
				<?php } ?>				
				<?php if($BlocosOfertas->imagemoferta3) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta3; ?>">
					</li>
				<?php } ?>				
				<?php if($BlocosOfertas->imagemoferta4) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta4; ?>">
					</li>
				<?php } ?>				
				<?php if($BlocosOfertas->imagemoferta5) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta5; ?>">
					</li>
				<?php } ?>				
				<?php if($BlocosOfertas->imagemoferta6) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta6; ?>">
					</li>
				<?php } ?>				
				<?php if($BlocosOfertas->imagemoferta7) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta7; ?>">
					</li>
				<?php } ?>				
				<?php if($BlocosOfertas->imagemoferta8) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta8; ?>">
					</li>
				<?php } ?>				
				<?php if($BlocosOfertas->imagemoferta9) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta9; ?>">
					</li>
				<?php } ?>				
				<?php if($BlocosOfertas->imagemoferta10) { ?>
					<li>
						<img src="<? echo $BlocosOfertas->imagemoferta10; ?>">
					</li>
				<?php } ?>
				</ul>
				<div class="descriptionProduct">
					<p class="bold">
						Código do produto: #<?=utf8_decode($team['id'])?>
					</p>
					<div class="priceProduct">																																				
						<?php
							if($team['market_price'] != "0.01" && $team['market_price'] != "0.00") {
						?>
						<b>
							<span class="payment-price-old" style="color:#a8d7d1 !important;">
								<span class="payment-currency" style="font-size:22px !important;">
									R$ 
								</span>
								<del style="font-size:22px !important; "><?=getpreco($team['market_price']); ?></del>
							</span>
						</b>
						<?php } ?>
						<b>
							<span class="payment-sell">
								<span class="payment-currency" style="color:#ec7562;">R$</span>
								<span class="payment-price" style="color:#ec7562;"><span class="int"><?=getpreco($team['team_price']); ?></span><span class="dec" style="display:none;">,<?=getdecimal($team['team_price']); ?></span> </span>
							</span>
						</b>
						<div style="padding: 7px;background-color: #eee;margin-top: 8px; clear:both;font-size:12px;width:298px;margin-bottom:11px;"> 
							<?php if($team['market_price'] != "0.01" && $team['market_price'] != "0.00") { ?><?=$BlocosOfertas->porcentagem ?>% off<?php } ?> em até 6x
						</div> 
						<span class="payment-price-old" style="font-size: 13px !important;color:#999 !important;display: none;">
							<?php if($team['market_price'] != "0.01" && $team['market_price'] != "0.00") { ?><?=$BlocosOfertas->porcentagem ?>% off <?php } ?> <?php if($team['observacao_preco'] != "") { ?> em até <?php echo $team['observacao_preco']; } ?>
						</span> 											
						<p class="text-product">
							Marca: <b><?php echo empty($team['marca_produto']) ? "sem marca" : utf8_decode(strtolower($team['marca_produto'])); ?></b>
						</p>												
						<p class="text-product">
							Condição: <b><?php echo empty($team['condicoes_produto']) ? "-" : strtolower($team['condicoes_produto']); ?></b>
						</p>
					</div>
					<div class="title-option">
						Opções do produto
					</div>
					<div class="options-size">
						<ul class="list-options">
						<?php
							while($options = mysql_fetch_assoc($rs_option)) {
						?>
							<li>
								<input type="radio" class="choice-product-options" name="options-product" attr-product-size="<?php echo $options['size']; ?>" attr-product-id="<?php echo $options['team_id']; ?>" value="<?php echo $options['id']; ?>"> Tamanho: <span class="color-size"><?php echo $options['size']; ?></span>
							</li>
						<?php } ?>	
						</ul>
					</div>
					<div class="options-color">
					</div>
					<div class="end-options-message">
					</div>
					<div class="borderTop">
						<?php if(!(empty($team['summary']))) { ?>
							<h2>Descrição do produto</h2>
							<p>
								<?php echo utf8_decode(mb_ucfirst(mb_strtolower($team['summary']))); ?>
							</p>
						<?php } ?>
					</div>
					<div class="buyButton">
						<? if(!$login_user_id){?> <a href="<?php echo $ROOTPATH; ?>/mlogin">Quero comprar</a><? } ?>  
						<? if($login_user_id){?>  <a href="javascript:validacao();">Quero comprar</a><? } ?>  							
					</div>					
					<div class="borderTop">
						<?php require_once("bloco_perguntasM.php"); ?>
					</div>
				</div>
				<p style="float:left;margin-top:35px;"><a  href="<?=$ROOTPATH?>/store/<?php echo $team['partner_id']; ?>"  class="link-1"><em><b style="color: rgb(255, 255, 255); padding: 6px; width: 100%; float: left; text-align: center;">Ver lojinha deste vendedor</b></em></a></p>					
				<?php require_once(DIR_BLOCO . "/lista_produtos_vendedorM.php"); ?>
			</div>
			<?php require_once(DIR_BLOCO."/rodapeM.php"); ?>
		</div>