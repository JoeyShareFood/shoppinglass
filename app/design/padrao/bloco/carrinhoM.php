		<form method="post" action="<?php echo $ROOTPATH . "/index.php?page=pedido"; ?>" id="formularioCarrinho" class="formularioCarrinhoM">
			<input type="hidden" readonly="readonly" name="berro" id="berro"> 
			<input type="hidden" readonly="readonly" name="temfrete" id="temfrete">
			<input type="hidden" readonly="readonly" name="existefrete" id="existefrete">
			<input type="hidden" readonly="readonly" name="codigocupom" id="codigocupom"> 
			<?php
				if(!(empty($options))) {
			?>
			<input type="hidden" readonly="readonly" name="id_option" id="id_option" value="<?php echo $options['id']; ?>"> 
			<?php } ?>				
			<div class="contentOrder">
				<ul class="my-cart-content-wrapper">
				<?php 
				
					$totalItems = 0;
					$existe_frete = false;
					$keywords ="";
					$totalitens=0;
					
					foreach(json_decode($_SESSION['carrinhoitens']) as $item) {

						$itensid 	.= $item->id.",";
						if($item->seo_keyword != ""){
							$keywords 	.= "'$item->seo_keyword',";	
						}
						$item->title= utf8_decode($item->title);
						$imagem = $ROOTPATH . '/media/'.substr($item->image,0,-4)."_popular_mini.jpg";

						if ($item->frete == 1) {
							$existe_frete = true; 
						} 
			  
						$team 	= Table::Fetch('team', $item->id);
						$link = getLinkOferta($team);
						$totalItems += $totalprice;	
						$FlagTermos = 0;

						if(!(empty($team['termosdeuso']))) {
							$FlagTermos = 1;
						} 
						else {
							$FlagTermos = 0;
						}
					
					?> 
					<input type='hidden' readonly="readonly"  name='item[]' value='<?=$item->id?>'/>
					<li class="my-cart-content-item linhaItem" id='tr_<?=$item->id?>'>
						<ul class="my-cart-product-wrapper clearfix">
							<li class="my-cart-product-item my-cart-product-description ">
								<h2>Nome do produto</h2>
								<figure class="product-list-image"> <img alt="<?=$item->title?>" src="<?=$imagem?>" class="img-responsive"></figure>
								<div class="product-list-item">
									<div>
										<a class="link link-description" href="<?=$link?>">
											<?=$item->title?>
										</a>
										<?php
											if(!(empty($options))) {
										?>
										<p style="color:#5C9E0D;margin-top:5px;font-size:14px;float:left;">
											Tamanho: <?=utf8_decode($options['size']) ?>
											<br />
											Cor: <?=utf8_decode($options['color']) ?>
										</p>
										<?php } ?>	
										<span class="brand-text"> <div id='erro_<?=$item->id?>'></div> </span> 
									</div>
									<!-- <div class="my-cart-sub-text"><span class="sub-text-first">Entregue por Walmart</span></div>-->
									<div class="country-label"></div>
								</div>
							</li>
							<li class="my-cart-product-item my-cart-product-price">
							<h2>Preço</h2>
							<div data-frete='<?=$item->frete?>' data-item='<?=$item->id?>' data-price='<?=$item->team_price?>' class="price-normal price_<?=$item->id?> infoItem">De R$ <?=number_format($team[market_price],2, ',', '.')?></div><div class="price-low">Por R$ <?=number_format($team[team_price],2, ',', '.')?></div></li>
							<!-- <input readonly="readonly" type='hidden' name='price_<?=$item->id?>' value='<?=$item->team_price?>'>-->
							<li class="my-cart-product-item my-cart-product-quantity">
							<h2>Quantidade</h2>
							<?
							if ($team['id'] == $item->id && isset($_POST['new_qty'])) {
								if (!isset($_SESSION['qty_'.$item->id])){
									$qty = $_POST['new_qty'];
								}
								else{
									$qty = $_SESSION['qty_'.$item->id] + $_POST['new_qty'];
								}
								echo "<script>alteraQty({$item->id}, {$qty}, {$options['stock']});</script>";
							}
							else{
								$qty = (isset($_SESSION['qty_'.$item->id])) ? $_SESSION['qty_'.$item->id] : 1;
							}
						
							$totalprice = $qty * $item->team_price;
							
							?>
							<input  maxlength='3' onKeyPress='return SomenteNumero(event);'  type='text' value='<?=$qty?>' class='qty_item inputsimples' data-item='<?=$item->id?>' name='qty_<?=$item->id?>' readonly>
							
							</li>
							<li data-total-price='<?=$totalprice?>'  class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem total_<?=$item->id?>">
								<h2>Subtotal</h2>
								<div class="price-low">R$ <?=number_format($totalprice, 2, ',', '.')?>   <a href='#' class='removeItem' data-item='<?=$item->id?>'><img src='<?=$PATHSKIN?>/images/btn_trash.gif'></a></div>
							</li>
						</ul>
					</li>
					<?  
						$totalitens	+= $qty  ; 
					} ?>
				</ul>
			</div>
			<div class="contentOrder">
				<div class="titlePage">
					<p>1. Endereço de entrega</p>
				</div>	
				<h2>Endereço principal</h2>
				<p class="contentOrderText">
					<?=getEnderecoClienteEntrega($login_user)?>
				</p>
			</div>
			<div class="contentOrder">
				<div class="titlePage">
					<p>2. Escolha o método de entrega</p>
				</div>
				<p class="contentOrderText">
					<?php 
						if($existe_frete) {
							busca_metodos_entrega($existe_frete);
						}
						else {
						
					?>
					Nenhuma forma de frete para este produto.
					<?php
						}
					?> 
				</p>
			</div>				
			<div class="contentOrder">
				<div class="titlePage">
					<p>3. Prossiga para o pagamento</p>
				</div> 
				<span class="my-cart-total-item my-cart-total-label totalpedidobk">
					
				</span>
			</div>			
			<div class="contentOrder">
				<div class="buyButton">
					<a href="#" id="orderButton">Finalizar compra</a>  							
				</div>
			</div>	
		</form>