<?php  
	need_login();
	
	unset($_SESSION["loginpagepost"]);  
	require_once("include/head.php"); 
	require_once(DIR_BLOCO."/session_carrinho.php");
	
	$itens = json_decode($_SESSION['carrinhoitens'], true); 
?>

<style>
	
	.price-normal.price_47.infoItem {
		width: 175px;
	}
	
	.my-cart-content-item {
		width: 1198px;
		margin-left: -17px;
	}
	
	@media only screen 
	and (max-width : 986px) {
		.my-cart-content-item {
			width: 100%;
			margin-left: 0;
		}
	}
</style>
  
<div style="display:none;" class="tips"><?=__FILE__?></div> 
<body id="page1" class="webstore home">
<div class="cabecalhosub"></div>

<?php if(detectResolution()) { ?>
<!-- Responsivo -->
<div class="containerM">
	<? require_once(DIR_BLOCO . "/headerM.php"); ?>   
	<div class="row">
		<div class="titlePage">
			<p>Meu pedido</p>
		</div>
		<div class="formOrder">
			<? require_once(DIR_BLOCO . "/carrinhoM.php"); ?>
		</div>
		<? require_once(DIR_BLOCO . "/rodapeM.php"); ?>
	</div>
</div>
<?php } else { ?>
<div class="container">  
	<div class="page">
		<? require_once(DIR_BLOCO."/header.php"); ?>  
		<? if($itens){?> 
			<section id="content" class="content">
				<form method="post" action="<?php echo $ROOTPATH . "/index.php?page=pedido"; ?>" id="formularioCarrinho">
					<input type="hidden" readonly="readonly" name="berro" id="berro"> 
					<input type="hidden" readonly="readonly" name="temfrete" id="temfrete">
					<input type="hidden" readonly="readonly" name="existefrete" id="existefrete">
					<input type="hidden" readonly="readonly" name="codigocupom" id="codigocupom">

					<?php
						if(!(empty($options))) {
					?>
					<input type="hidden" readonly="readonly" name="id_option" id="id_option" value="<?php echo $options['id']; ?>"> 
					<?php } ?>
					
					<div class="main-content clearfix">  
						<section class="main-content my-cart">
						<div>
							<div class="page-title-car clearfix">
								<h2>Meu pedido<span class="my-cart-header-items"> <!-- (<?=$txtitens?>)--></span></h2>
								<!--<div class="header-btn-wrapper"><button onclick="TermosDeUso();" class="buy-button-cart btn btn-success" type="button" id="btncart">Finalizar compra</button></div>-->
							</div> 
							<article class="my-cart-box">
								<header>
									<ul class="my-cart-header-wrapper clearfix">
										<li class="my-cart-header-item header-items">item(s)</li><li class="my-cart-header-item header-price">preço</li><li class="my-cart-header-item header-quantity">quantidade</li><li class="my-cart-header-item header-subtotal">subtotal</li>
									</ul>
								</header>
								<ul class="my-cart-content-wrapper">
								<?php 
								
								$totalItems = 0;
								$existe_frete = false;
								$keywords ="";
								$totalitens=0;
								unset($qty, $item, $totalprice);
								
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
												<figure class="product-list-image"> <img alt="<?=$item->title?>" src="<?=$imagem?>" class="img-responsive"></figure>
												<div class="product-list-item">
													<div>
														<a class="link link-description" href="<?=$link?>">
															<p>
																<?=$item->title?>
															</p>
															<?php
																if(!(empty($options))) {
															?>
															<p style="color:#5C9E0D;margin-top:5px;font-size:14px;">
																Tamanho: <?=utf8_decode($options['size']) ?>
																<br />
																Cor: <?=utf8_decode($options['color']) ?>
															</p>
															<?php } ?>															
														</a>
														<span class="brand-text"> <div id='erro_<?=$item->id?>'></div> </span> 
													</div>
													<!-- <div class="my-cart-sub-text"><span class="sub-text-first">Entregue por Walmart</span></div>-->
													<div class="country-label"></div>
												</div>
											</li>
											<li class="my-cart-product-item my-cart-product-price"><div data-frete='<?=$item->frete?>' data-item='<?=$item->id?>' data-price='<?=$item->team_price?>' class="price-normal price_<?=$item->id?> infoItem"><?php if($team['market_price'] != "0.00" && $team['market_price'] != "0.01") { ?>De R$ <?=number_format($team[market_price],2, ',', '.')?><?php } ?></div><div class="price-low">Por R$ <?=number_format($team[team_price],2, ',', '.')?></div></li>
											<!-- <input readonly="readonly" type='hidden' name='price_<?=$item->id?>' value='<?=$item->team_price?>'>-->
											<li class="my-cart-product-item my-cart-product-quantity">
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
											<input  maxlength='3' onKeyPress='return SomenteNumero(event);' style='width:23px;background:none !important;box-shadow:none !important;' type='text' value='<?=$qty?>' class='qty_item inputsimples' data-item='<?=$item->id?>' name='qty_<?=$item->id?>'>
											
											</li>
											<li data-total-price='<?=$totalprice?>'  class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem total_<?=$item->id?>">
												<div class="price-low">R$ <?=number_format($totalprice, 2, ',', '.')?>   <a href='#' class='removeItem' data-item='<?=$item->id?>'><img src='<?=$PATHSKIN?>/images/btn_trash.gif'></a></div>
											</li>
										</ul>
									</li>
									<?  
										$totalitens	+= $qty  ; 
									} ?>
								</ul>
							<footer>
							<section class="visible-desktop my-cart-footer-wrapper clearfix"> 
								<article class="my-cart-gift-box"> 
									<header> 
										<div class="endentrega">  
											<b>Endereço de Entrega:</b><br> 
											<p>
												<?=getEnderecoClienteEntrega($login_user)?> 
											</p>
											<a class="tk_altera_endereco cboxElement linkfrete" href=""><img title="Editar endereço de entrega" alt="Editar endereço de entrega" src="<?=$PATHSKIN?>/images/file_edit.png"></a> 
										</div>  
										<!--
										<div class="valcup">
										 <div class="titcupomcart"><i class="icon-wm-tag"></i></div><div><h2  style="color:#1a75ce">Cupom de Desconto</h2></div>
											<!--<a class="link">Incluir vale desconto ou cupom</a>
											<div class="my-cart-totals-item my-cart-freight" style="float:none;"> 
												 <span id="desktopFreightConteiner" class="my-cart-freight-item my-cart-freight-contents my-cart-freight-postcode"><input style="width:214px;" type="text" value="" class="new-postcode input-box" id="valecompras" name="valecompras"><a class="btn btn-primary btn-postcode-check" href="javascript:consultavalecompras(J('#valecompras').val());">Ok</a></span>
											</div>  
										</div>
										-->
									</header>
									<ul class="list-gift-wrapper"></ul>
								</article> 
								<?php if ($existe_frete) {
										$metodos = busca_metodos_entrega($existe_frete);
								?> 
											<?php echo $metodos; ?> 
											 <!-- 
											<div id="41106"  data-titulo="Encomenda Normal" data-prazo="" data-valorfrete="">
												<input checked="checked" id="41106" value="41106"  type="radio" name="modo_envio" onclick="altera_metodo_entrega(this.value);" style="width:20px;"> PAC
												<span class='valorFrete_41106' style="left:0px;top:-10px;">  </span>  
												<span class='prazoentrega_41106' style="margin-bottom:-20px;"> </span>
											</div>
											<div id="40010" data-titulo="Sedex"  data-prazo="" data-valorfrete="" > 
												<input id="40010" value="40010" type="radio" name="modo_envio" onclick="altera_metodo_entrega(this.value);" style="width:20px;"> Sedex
												<span class='valorFrete_40010' style="left:0px;top:-10px;"> </span>  
												<span class='prazoentrega_40010' style="margin-bottom:-20px;"> </span>
											</div>  
											<div id="40215" data-titulo="Sedex 10"   data-prazo="" data-valorfrete="" >
												<input id="40215" value="40215"  type="radio" name="modo_envio" onclick="altera_metodo_entrega(this.value);" style="width:20px;"> Sedex 10
												<span class='valorFrete_40215' style="left:0px;top:-10px;">   </span> 
												<span class='prazoentrega_40215' style="margin-bottom:-20px;"> </span>
										   </div>
											<div id="motoboy" data-titulo="Motoboy"  data-prazo="1" data-valorfrete="9.00" >
												<input id="motoboy" value="motoboy" type="radio" name="modo_envio" onclick="altera_metodo_entrega(this.value);" style="width:20px;"> MotoBoy
												<span class='valorFrete_motoboy' style="left:0px;top:-10px;">Frete: R$9.00</span> 
												 <span class='prazoentrega_motoboy' style="margin-bottom:-20px;"> </span>
											</div>
											<div id="metodo_local" data-titulo="Retirar no local" data-prazo="" data-valorfrete="0.00">
												<input  id="metodo_local" value="metodo_local"  type="radio" name="modo_envio" onclick="altera_metodo_entrega(this.value);" style="width:20px;"> Retirar no local:
												<span class='valorFrete_metodo_local' style="left:0px;top:-10px;"><b>Grátis</b></span>
												 <span class='prazoentrega_metodo_local' style="margin-bottom:-20px;"> </span>
											</div>  
											-->	  
								<? } ?>
								<article class="my-cart-totals">
									<div class="my-cart-totals-item my-cart-subtotal">
										<span class="my-cart-subtotal-item my-cart-subtotal-label">Subtotal  </span>
										<span class="my-cart-subtotal-item my-cart-subtotal-text valorSubtotal" data-valor='<?php echo $totalItems; ?>'>R$ <?php echo number_format($totalItems, 2, ',', '.')  ?></span>
									</div> 
									
									<?php if ($existe_frete) { ?>								
										<div class="my-cart-totals-item my-cart-freight">
											<span class="my-cart-freight-item my-cart-freight-postal-code-label" style="display: inline;">	 Simular Frete:</span>
											 <span id="desktopFreightConteiner" class="my-cart-freight-item my-cart-freight-contents my-cart-freight-postcode"><input type="text" value="" class="new-postcode input-box" name="value" id="postcodecart"><a class="btn btn-primary btn-postcode-check" href="javascript:consultacep(J('#postcodecart').val());">Ok</a></span>
										</div> 
									<? } ?>
									  
									<div class="my-cart-totals-item my-cart-total">
									
										<?php if ($team['frete'] == 1) { ?>
											<span class="my-cart-installment-text nome_metodo" style="line-height: 31px;"> </span> <span class="my-cart-installment-text valorFrete" style="line-height: 31px;"></span>
										 <? } 
										 else if($team['frete'] == 3){?>
											<span class="my-cart-installment-text" style="line-height: 31px;"> </span> <span class="my-cart-installment-text fretegratis">Retirada no local</span>
										<? } else if($team['frete'] == 2) { ?>	
											<span class="my-cart-installment-text" style="line-height: 31px;"> </span> <span class="my-cart-installment-text fretegratis">Frete Grátis</span>
										  <? } ?>
										 
										<? if( $INI['option']['mostrarprazoentrega'] !="N") {?><div class='prazoentrega' style="line-height: 31px;"> </div>	<? } ?>
									 
										<div class="my-cart-installment-text valorvalecompra" style="line-height: 31px;"></div> 
										<br>
										<?php if ($existe_frete) { ?>
											<span class="my-cart-total-item my-cart-total-label totalpedidobk">Valor total:</span> 
										<? } 
										else{?>
											Valor total: <span class="my-cart-total-item my-cart-total-label valorSubtotal"> </span>
										<?} ?>
									</div>
								</article>
								<?php if($FlagTermos == 1) { ?><p class="termosdeuso"><input type="checkbox" name="checktermosdeuso" id="checktermosdeuso"> Concordo com tudo o que foi descrito nos <a href="#" class="tk_termosdeuso">termos de uso</a> do vendedor.</p><?php } ?>
							</section> 
						</footer>
						</article>
						<div class="buttons-wrapper clearfix">
							  <span class="back-buttons-wrapper">
								<a class="btn-link store" href="<?=$ROOTPATH?>">Voltar</a>
								<span class="or-text">ou</span>
							  </span> 
							<button id="btn-finalize-cart" onclick="TermosDeUso();" class="buy-button-cart btn btn-success btfooter" type="button" id="btncart2" >Finalizar compra</button> 
						</div> 
						<div class="visible-desktop">
							<div class="chaordic shoppingcart" style="display: none; width: 100%; height: 460px;"><iframe width="100%" height="100%" frameborder="0" scrolling="no" style="display: none;" allowtransparency="true"></iframe></div>
						</div>
					</div>
					</section> 
				</div>
				<?php
					if($team['frete'] == 3) {
				?>
				<input type="hidden" readonly="readonly" name="modo_envio" id="modo_envio" value="retirada"> 
				<?php } else if($team['frete'] == 2) { ?>
				<input type="hidden" readonly="readonly" name="modo_envio" id="modo_envio" value="gratis"> 
				<?php } else { ?>
				<input type="hidden" readonly="readonly" name="modo_envio" id="modo_envio"> 
				<?php } ?>
				</form> 
			</section> 
		<? } 
		else{?>
			<section id="content" class="content">
				<div class="empty-cart-wrapper clearfix">
					<div class="empty-cart-sign">:(</div>
					<article class="empty-cart-message">
						<div class="empty-cart-header-message">
							Ops! Seu carrinho está vazio.
						</div>
						<div class="empty-cart-content-message">
							Para inserir produtos no seu carrinho, navegue pelo shopping ou utilize a busca do site. Você  pode rever seus últimos pedidos em <span class="green-text">Meus Pedidos</span> no topo do site

						</div>
						<div class="back-shopping-buttons buttons-wrapper">
							<a href="<?=$ROOTPATH?>" class="btn btn-primary continue-button">
								Continuar comprando
							</a>
						</div>
					</article>
				</div>
			</section>
		<? } ?>
		<?php
		require_once(DIR_BLOCO."/rodape.php");
		?>
	</div>
</div>
<?php } ?>

<div style='display:none'> 
	<div class="wm-sign-in clearfix"  id="inline_termosdeuso" >
		<div class="title">Termos de uso</div>
		<div class="sign-in-wrapper"> 
			<?php echo $team['termosdeuso']; ?>
		</div>
	</div>
</div>
</body>
</html> 

<script> 
// FUNCOES COMPLEMENTARES EM JS/FUNCOES.JS
	var total;
	var cepdestino;
	var cep="";
	var diasadicionaisfrete;
	J("#postcodecart").mask("99999-999"); 
	
	diasadicionaisfrete = '<?=$INI['system']['diasadicionais']?>';
	cepdestino = "<?=getCepDestino($login_user)?>";
	 
	jQuery(document).ready(function() { 
		jQuery('.removeItem').bind('click', function(ev) {
			ev.preventDefault(); 
			removeCarrinho(jQuery(this).attr('data-item')); 
		});  
		
		jQuery('.qty_item').bind('change', function() { 
			id = jQuery(this).attr('data-item'); 
			qty = jQuery(this).val(); 
			id_option = jQuery('#id_option').val();
			alteraQty(id, qty, id_option);
			
			item = jQuery(this).attr('data-item');
			preco = jQuery('.price_'+item).attr('data-price');
			qty = jQuery(this).val(); 
			 
			if (!isNaN(qty) && qty > 0) { 
				novoValor = qty * parseFloat(preco); 
				jQuery('.total_'+item).html('<div class="price-low">R$ ' + novoValor.toFixed(2) + '<a class="removeItem" data-item="47" href="#"> <img src="<?php echo $PATHSKIN; ?>/images/btn_trash.gif"></a></div>');
				jQuery('.total_'+item).attr('data-total-price', novoValor.toFixed(2)); 
				id_modoenvio = J('input[name="modo_envio"]:checked').val(); 
				calculaTotalbyclick(id_modoenvio); 				
			} 
			novoSubtotal();
		});
		novoSubtotal();
	});
	
	
// SETA O NOME DO METODO DE ENVIO NO PRIMEIRO ACESSO DA PAGINA	
jQuery(document).ready(function() { 
	id_modoenvio = J('input[name="modo_envio"]:checked').val();
	nomemetodo = J("#"+id_modoenvio).attr('data-titulo');  
	J('.nome_metodo').html("<b>"+nomemetodo+"</b> - ");
});

<?php if($FlagTermos == 1) { ?>
		function TermosDeUso() {
			if(jQuery('#checktermosdeuso').is(':checked')) {
				fechapedido();
			} else {
				window.alert("É necessário que concorde com os termos de uso do vendedor!");
			}
		}
<?php } else { ?>
		function TermosDeUso() {
			fechapedido();
		}
<?php } ?>
 </script>
					
<? if($ERROR){?>
	<script>
		alert('<?=$ERROR?>');
		location.href  = '<?php echo $INI['system']['wwwprefix']?>/index.php';
	</script>
<? } ?>