<?php  
	require_once("include/code/pedido.php");
	require_once("include/head.php");
?>
<style>
.my-cart-product-wrapper{ padding:6px;}
.my-cart {  margin: 0 auto; }
.my-cart-product-wrapper .my-cart-product-item { float: left; }

@media only screen 
and (max-width : 986px) {
	
	.buy-button-wrapper {
		margin-left: 0;
		width: 100%;
		text-align: center;
	}
}
</style>

<div style="display:none;" class="tips"><?=__FILE__?></div>  

<body id="page1" class="webstore home"> 
<?php	if(detectResolution()) {?>
<!-- Responsivo -->
<div class="containerM">
	<? require_once(DIR_BLOCO."/headerM.php"); ?>
	<div class="row">
		<div class="productsPage">		
			<div class="titlePage">
				<p>Dados do pedido #<?php echo $order_id; ?></p>
			</div>	
			<p>O seu pedido nº <b><?php echo $order_id; ?></b> foi recebido com sucesso. Agora basta realizar o pagamento.</p> 
			<br />
			<h2>Dados do vendedor</h2>
			<p><span class="bold">Email:</span> <?php echo $vendedor['email']; ?></p>
			<?php if(!(empty($vendedor['mobile']))) { ?>
			<p><span class="bold">Telefone:</span> <?php echo $vendedor['mobile']; ?></p>
			<?php } ?>
			<?php
				if(detectResolution()) {
					require_once('include/botoespagamento.php');
				}
				require_once(DIR_BLOCO."/rodapeM.php");
			?>			
		</div>
	</div>
</div>
<?php } ?>		
<div class="container"> 
	<div class="page">
		<? require_once(DIR_BLOCO."/header.php"); ?> 
			<style>
			@media only screen 
			and (max-width : 986px) {
				
				.buy-button-wrapper {
					margin-left: 0;
					width: 100%;
					text-align: center;
				}
			}
			</style>
			<div class="main-content clearfix">  
				 	<section class="main-content my-cart"><div>
					<div class="page-title-order clearfix">
						<h2>O seu pedido nº <b><?php echo $order_id; ?></b> foi recebido com sucesso. Agora basta realizar o pagamento.  </h2> 
						<div class="my-cart-header-items" style="color: rgb(124, 124, 124);font-size: 17px;margin-top: 13px;text-align: right;width: 1040px;">Após clicar em pagar, você será redirecionado afim de realizar este pagamento em um ambiente totalmente seguro.  </div>
					</div> 
				<?php
					require_once('include/botoespagamento.php');
				?>  
					<div class="main-content clearfix">  
						</div> 
						<article class="my-cart-box"> 
							<header>
								<ul class="my-cart-header-wrapper clearfix">
								 <h2>Endereço de Entrega <span class="my-cart-header-items">  </span></h2> 
								 </ul>
							</header> 
							<ul class="my-cart-content-wrapper"> 
								<li class="my-cart-content-item linhaItem" > 
									<ul class="my-cart-product-wrapper clearfix">
										<li class="my-cart-product-item my-cart-product-description "> 
											<div class="product-list-item">
											<? echo utf8_decode($endereco)." ".$numero. " ".utf8_decode($complemento). " - ".utf8_decode($bairro);  ?>
											<? echo "<br>".utf8_decode($cidade)." - ".utf8_decode($estado)  ?>
											<? echo "<br>Cep: ".$cep ?> 
											</div>
										</li> 
									</ul> 
								</li> 
									  
							</ul>
							 </article> 
						</div>
					</div>  
				<div><h2>Resumo da Compra <span class="my-cart-header-items">  </span></h2> </div>
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
					$class = "border-top:0;";
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
						?> 
						<input type='hidden' readonly="readonly"  name='item[]' value='<?=$item->id?>'/>
						<li class="my-cart-content-item linhaItem" id='tr_<?=$item->id?>'>
							<ul class="my-cart-product-wrapper clearfix" style="<?=$class?>">
								<li class="my-cart-product-item my-cart-product-description ">
									<figure class="product-list-image"> <img alt="<?=$item->title?>" src="<?=$imagem?>" class="img-responsive"></figure>
									<div class="product-list-item">
										<div>
											<?=$item->title?> 
											<?php
												if(!(empty($options))) {
											?>
											<p style="color:#5C9E0D;margin-top:5px;font-size:14px;">
												Tamanho: <?=$options['size'] ?>
												<br />
												Cor: <?=$options['color'] ?>
											</p>
											<?php } ?>
											<span class="brand-text"> <div id='erro_<?=$item->id?>'></div> </span> 
										</div>
										<!-- <div class="my-cart-sub-text"><span class="sub-text-first">Entregue por Walmart</span></div>-->
										<div class="country-label"></div>
									</div>
								</li>
								<li class="my-cart-product-item my-cart-product-price"><div data-frete='<?=$item->frete?>' data-item='<?=$item->id?>' data-price='<?=$item->team_price?>' class="price-normal price_<?=$item->id?> infoItem">De R$ <?=number_format($team[market_price],2, ',', '.')?></div><div class="price-low">Por R$ <?=number_format($team[team_price],2, ',', '.')?></div></li>
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
								$subtotal = $subtotal + $totalprice ;
							
								?>
								 <?=$qty?> 
								
								</li>
								
								<li data-total-price='<?=$totalprice?>'  class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem total_<?=$item->id?>">
									<div class="price-low">R$ <?=number_format($totalprice, 2, ',', '.')?>    </div>
								</li>
							</ul>
						</li>
						<? } 
							$class="";
							$total = $subtotal + $valorfrete ;
						?>
					</ul>
					<footer>							 
						<article class="my-cart-totals">
							<div class="my-cart-totals-item my-cart-subtotal">
								<span class="my-cart-subtotal-item my-cart-subtotal-label">Subtotal:</span>
								<span class="my-cart-subtotal-item my-cart-subtotal-text valorSubtotal" data-valor='<?php echo $totalItems; ?>'>R$ <?php echo number_format($subtotal, 2, ',', '.')  ?></span>
							</div>  
						 
							<div class="my-cart-totals-item my-cart-total">
								<?php if (!empty($valorfrete) and  $valorfrete!=0) { ?>
									<span class="my-cart-installment-text" style="line-height: 31px;"><?=$nome_metodo?> - Frete: R$ <?=$valorfrete?></span> 
								<? } ?>
								 <? if( $INI['option']['mostrarprazoentrega'] !="N") {?><div   style="line-height: 31px;">Prazo de entrega:  <?=$prazofrete?> dia(s)</div>	<? } ?>
								 
								<? if($cupomdesconto){?><div class="my-cart-installment-text valorvalecompra" style="line-height: 31px;"><b>Cupom de desconto:</b> R$ <?=number_format($valorcupomdesconto, 2, ',', '.') ?></div> <? } ?>
							    <br>
								<span class="my-cart-total-item my-cart-total-label totalpedidobk">Valor total: R$ <?=number_format($total - $valorcupomdesconto, 2, ',', '.') ?></span> 
							</div>
						</article> 
				</footer></article> 
				</div>
			</div> 
		</section> 
		<div style='display:none'>
			<div id='inline_combinarcomvendedor' style='background:#fff; height:110px; padding:10px; width:80% !important'>
				<div id="divContato" class="formulario span-8 last">
						<div class="span-8 last caixa-linha-ficha" id="container-nome">
							<div class="span-8 borda-bottom-1 fundosecao">
								<div class="AvisoContato">
									<img align="left" src="<?php echo $PATHSKIN; ?>/images/customer-support.png"> 
									<h4 class="branco-padrao size-20-bold jump-1" style="margin-left:65px;">Após entrar em contato com vendedor, fique tranquilo e aguarde o retorno.</h4>
								</div>
								<div class="alturasecao"><h4 class="branco-padrao size-20-bold jump-1">Combinar com vendedor</h4></div>
							</div>
						 
								<div class="span-7 jump-1 last"  style="text-align:left;">
									<label class="last size-13-bold rotulo">Seu nome</label>
								</div> 
							  <input type="text" readonly maxlength="100" id="txtNome" value="<?php echo $login_user['realname']; ?>" name="nome" class="span-6-b raio-5">
						</div>
						<div class="span-8 last caixa-linha-ficha" id="container-email" style="clear:both;">
							<div class="span-8 last margin-top-10">
								<div class="span-7 jump-1 last"  style="text-align:left;">
									<label class="last size-13-bold rotulo">Seu e-mail</label>
								</div>
							</div>
							<input type="text" readonly maxlength="60" value="<?php echo $login_user['email']; ?>" id="txtEmail"  name="email" class="span-6-b raio-5">
						</div>
						<div class="span-8 last caixa-linha-ficha" id="container-tel" style="clear: both;">
							<div class="span-8 last margin-top-10">
								<div class="span-7 jump-1 last"  style="text-align:left;">
									<label class="last size-13-bold rotulo"  >Telefone</label>
								</div>
							</div>
							<input type="text" readonly value="<?php echo $login_user['mobile']; ?>" id="txtTel"  maxlength="13"  onKeyPress="return SomenteNumero(event);" name="telefone" class="span-4 raio-5 celular" style="">
						</div>
						<div class="span-8 last caixa-linha-ficha"  style="text-align:left;" id="container-msg">
							<div class="span-8 last margin-top-10">
								<div class="span-7 jump-1 last">
									<label class="last size-13-bold rotulo"  >Mensagem</label>
								</div>
							</div> 
							<textarea rows="6" onkeyup="limite_textarea(this.value)" maxlength="500" name="proposta" id="txtMsg" class="span-6-b last raio-5" rows=""></textarea>
						</div>
						<div class="jump-1 last caixa-linha-ficha size-12"  style="text-align:left;clear: both;">
							Caracteres restantes: <label id="conttxt" for="txtMsg">500</label>
						</div>
						<div class="span-8 last checkboxes" style="text-align:left;clear:both;margin-top:19px;">
							<div class="span-5 jump-1 last captcha-cont-vendedor" style="margin-top:22px;width:243px;" >
								<div style="width: 163px;">	
								<button id="btnEnviar" class="btn btn-primary write-review" style="width:94px;" onclick="javascript:MsgVendedor();"  title="Enviar" data-tipo-anuncio="Usados" data-tipo-veiculo="Carro" data-id="11239890"   class="span-4 last raio-5 size-14-bold bt-verm margin-top-10">Enviar</button>
								</div>
								<DIV><BR><BR></DIV>				
							</div>
						</div>
					</div>
		   </div> 
	<?php
		require_once(DIR_BLOCO."/rodape.php");
	?>
</div>
</div>
</body>
</html>
   
<script language="javascript"> 
	J(".secaotitulo").corner("round 2px");
	
	function limite_textarea(valor) {
		quant = 500;
		total = valor.length;
		if(total <= quant) {
			resto = quant - total;
			document.getElementById('conttxt').innerHTML = resto;
		} else {
			document.getElementById('txtMsg').value = valor.substr(0,quant);
		}
	}
	
function MsgVendedor(){
	  
	var idpedido = '<?php echo $order_id; ?>';
	var nome = J("#txtNome").val();
	var email  = J("#txtEmail").val();
	var telefone = J("#txtTel").val();
	var proposta = J("#txtMsg").val(); 
	
	if(idpedido == ""){

		alert("Ocorreu um erro inesperado. Por favor, volte mais tarde.")
		return;
	} 

	if(proposta == ""){

		alert("Informe alguma mensagem !")
		document.getElementById("proposta").focus();
		return;
	}  
	//jQuery.colorbox({html:"<img src="+URLWEB+"/skin/padrao/images/ajax-loader2.gif> <font color='black' size='10'>Enviando sua proposta, por favor, aguarde...</font>"});
	
	J.ajax({
		   type: "POST",
		   cache: false,
		   async: true,
		   url: URLWEB+"/combinarvendedor.php",
		   data: "idpedido="+idpedido+"&nome="+nome+"&email="+email+"&telefone="+telefone+"&proposta="+proposta ,
		   success: function(msg){
		   
		   if( jQuery.trim(msg)==""){
		    	jQuery.colorbox({html:"<p>Mensagem enviada com sucesso! </p>"});
				location.href = "<?php echo $ROOTPATH; ?>";
			}  
		   else {
					jQuery.colorbox({html:"<p>"+msg+"</p>"});
					location.href = "<?php echo $ROOTPATH; ?>";
				}
			 }
		 });
}
</script>
		
<? if($ERROR){?>
	<script>
		alert('<?=$ERROR?>');
		location.href  = '<?php echo $INI['system']['wwwprefix']?>/index.php';
	</script>
<? } ?>

<?
unset($_SESSION['carrinhoitens']);
?>
	 