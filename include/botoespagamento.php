<div style="display:none;" class="tips"><?=__FILE__?></div>
<?php
	$page = trim(strip_tags($_GET["page"]));
?> 
<style>
@media only screen 
and (min-width : 986px) {
	.buy-button-wrapper{ width: 355px;margin-left: -78px;}
}
.buy-button.btn-success .icon.small, .sellers-list-item:hover .buy-button .icon.small {top:17px;}
.btn, .noUiSlider div{padding:0;}
.buy-button .text{padding-left:0; font-size:17px;}
.buy-button{height:57px;width:93%;}
.my-cart-product-wrapper{border-top:1px solid #e4e4e4;}
</style>

	<div class="main-content clearfix">  
			<section class="main-content my-cart" style="min-height:0px;"><div><div class="page-title-car clearfix">
		</div> 
		<article class="my-cart-box"> 
			<header>
				<ul class="my-cart-header-wrapper clearfix">
				 <h2>ESCOLHA A FORMA DE PAGAMENTO <span class="my-cart-header-items">  </span></h2> 
				 </ul>
			</header> 
			<ul class="my-cart-content-wrapper"> 
				<li class="my-cart-content-item linhaItem" > 

				
					<?php if($INI['pagseguro']['acc'] != ""){ 
							$idform="pagseguro";
							if($INI['pagseguro']['transparente']=="1" ){
								$idform="formulario"; // se o nome for diferente, ocorre erro na tela de abertura do pagseguro trans
							}
						?>
						<ul class="my-cart-product-wrapper clearfix" style="">
							<li class="my-cart-product-item my-cart-product-description ">
								<figure class="product-list-image">  </figure>
								<div class="product-list-item">
									<div> 
										<div> <img src="<?=$PATHSKIN?>/images/pagseguro.png"   border="0" /></div>  
									</div>  
								</div>
							</li>
							<li class="my-cart-product-item my-cart-product-price hidden">  </li> 
							<li class="my-cart-product-item my-cart-product-quantity"> 
							<div class="buy-button-wrapper">
								<a class="">
								 <button type="button" class="buy-button btn btn-success"   onclick="javascript:enviapag_normal('<?=$idform?>');">
									<span class="icon small hidden"></span><span class="text">Pagar com Pagseguro</span>
								</button> 
								</a>
							</div> 						
							</li> 
							<li class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem hidden"> </li>
						</ul> 
					<? } ?>
					
					<?php if($INI['pagamentodg']['acc'] != "" and $INI['pagamentodg']['transparente']!="1"){ // TRADICIONAL ?> 
						<ul class="my-cart-product-wrapper clearfix">
						<li class="my-cart-product-item my-cart-product-description ">
							<figure class="product-list-image">  </figure>
							<div class="product-list-item">
								<div> 
								  <div> <img src="<?=$PATHSKIN?>/images/btbcash.png"   border="0" /></div>   
								</div>  
							</div>
						</li>
						<li class="my-cart-product-item my-cart-product-price hidden">  </li> 
						<li class="my-cart-product-item my-cart-product-quantity"> 
						<div class="buy-button-wrapper">
							<a class="">
							 <button type="button" class="buy-button btn btn-success"   onclick="javascript:enviapag_normal('pagamentodigital');">
								<span class="icon small hidden"></span><span class="text">Pagar com B!Cash</span>
							</button> 
							</a>
						</div> 						
						</li> 
						<li class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem hidden"> </li>
					</ul>
					<? } ?>
					
					<?php if($INI['pagamentodg']['acc'] != "" AND  $INI['pagamentodg']['transparente']=="1" ){ //TRANSPARENTE ?> 
						<ul class="my-cart-product-wrapper clearfix" >
							<li class="my-cart-product-item my-cart-product-description ">
								<figure class="product-list-image">  </figure>
								<div class="product-list-item">
									<div>  
										<div> 
											<img src="<?=$PATHSKIN?>/images/btbcash.png"   border="0" /> 
										 </div>  
									</div>  
								</div>
							</li>
							<li class="my-cart-product-item my-cart-product-price hidden">  </li> 
							<li class="my-cart-product-item my-cart-product-quantity"> 
							<div class="buy-button-wrapper">
								 
								<a id="link_payment" class="iframe_bcash" data-fancybox-type="iframe" href="<?=$ROOTPATH?>/include/form_bcash.php?idpedido=<?=$idpedido?>">
								 <button type="button" class="buy-button btn btn-success">   
									<span class="icon small hidden"></span><span class="text">Pagar com B!Cash</span>
								</button> 
								</a>
							</div> 						
							</li> 
							<li class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem hidden"> </li>
						</ul> 
					<? } ?> 
					
					<?php if($INI['moip']['mid'] != ""){ ?>
						<ul class="my-cart-product-wrapper clearfix">
							<li class="my-cart-product-item my-cart-product-description ">
								<figure class="product-list-image">  </figure>
								<div class="product-list-item">
									<div> 
									  <div> <img src="<?=$PATHSKIN?>/images/moip.png"   border="0" /></div> 
									</div>  
								</div>
							</li>
							<li class="my-cart-product-item my-cart-product-price hidden">  </li> 
							<li class="my-cart-product-item my-cart-product-quantity"> 
							<div class="buy-button-wrapper">
								<a class="">
								 <button type="button" class="buy-button btn btn-success"   onclick="javascript:enviapag_normal('moip');">
									<span class="icon small hidden"></span><span class="text">Pagar com Moip</span>
								</button> 
								</a>
							</div> 						
							</li> 
							<li class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem hidden"> </li>
						</ul> 
					<? } ?> 
					
					<?php if($INI['paypal']['mid'] != ""){ ?>
						<ul class="my-cart-product-wrapper clearfix">
							<li class="my-cart-product-item my-cart-product-description ">
								<figure class="product-list-image">  </figure>
								<div class="product-list-item">
									<div> 
									 <div> <img src="<?=$PATHSKIN?>/images/paypal.png"   border="0" /></div> 
									</div>  
								</div>
							</li>
							<li class="my-cart-product-item my-cart-product-price hidden">  </li> 
							<li class="my-cart-product-item my-cart-product-quantity"> 
							<div class="buy-button-wrapper">
								<a class="">
								 <button type="button" class="buy-button btn btn-success"   onclick="javascript:enviapag_normal('paypal');">
									<span class="icon small hidden"></span><span class="text">Pagar com Paypal</span>
								</button> 
								</a>
							</div> 						
							</li> 
							<li class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem hidden"> </li>
						</ul>
					<? } ?> 
					 
					 
					 <?php  if($INI['dinheiro']['mid'] != ""){?>
						<ul class="my-cart-product-wrapper clearfix">
							<li class="my-cart-product-item my-cart-product-description ">
								<figure class="product-list-image">  </figure>
								<div class="product-list-item">
									<div> 
										<div> <img src="<?=$PATHSKIN?>/images/dinheiro.jpg"   border="0" /></div>
									</div>  
								</div>
							</li>
							<li class="my-cart-product-item my-cart-product-price hidden">  </li>
							<li class="my-cart-product-item my-cart-product-quantity"> 
							<div class="buy-button-wrapper">
								<a class="">
								 <button type="button" class="buy-button btn btn-success"   onclick="javascript:enviapag_normal('dinheiro');">
									<span class="icon small hidden"></span><span class="text">Pagar com Dinheiro Mail</span>
								</button> 
								</a>
							</div> 						
							</li> 
							<li class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem hidden"> </li>
						</ul>
					 <? } ?> 
					
					<?php if($INI['akatus']['acc'] != ""){ ?> 
						<ul class="my-cart-product-wrapper clearfix">
							<li class="my-cart-product-item my-cart-product-description ">
								<figure class="product-list-image">  </figure>
								<div class="product-list-item">
									<div> 
										<div> <img src="<?=$PATHSKIN?>/images/akatus.jpg"   border="0" /></div>
									</div>  
								</div>
							</li>
							<li class="my-cart-product-item my-cart-product-price hidden">  </li>
							<li class="my-cart-product-item my-cart-product-quantity"> 
							<div class="buy-button-wrapper">
								<a class="">
								 <button type="button" class="buy-button btn btn-success"   onclick="javascript:enviapag_normal('akatus');">
									<span class="icon small hidden"></span><span class="text">Pagar com Akatus</span>
								</button> 
								</a>
							</div> 						
							</li> 
							<li class="my-cart-product-item my-cart-product-subtotal my-cart-product-price totalItem hidden"> </li>
						</ul> 
					 <? } ?> 
				</li> 
			</ul>
			 </article> 
		</div>
		</section> 
	</div>  
		
<? require_once('formularios_pagamento.php');?>