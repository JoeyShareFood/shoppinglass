 <style>
   
.btn-odetailferta:hover  { 
	
	background: <?=$INI['cores']['botao2']?>;
	background: -moz-linear-gradient(center top , <?=$INI['cores']['botao2']?> 0%, <?=$INI['cores']['botao2']?> 100%) !important; 
	background: -webkit-gradient(linear, left top, left bottom, from( <?=$INI['cores']['botao2']?>), to( <?=$INI['cores']['botao2']?>)) !important;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?=$INI['cores']['botao2']?>', endColorstr='<?=$INI['cores']['botao2']?>') !important;
	background: -o-linear-gradient(top, <?=$INI['cores']['botao2']?> 0%,<?=$INI['cores']['botao2']?> 100%) !important;
	background: -ms-linear-gradient(top, <?=$INI['cores']['botao2']?> 0%,<?=$INI['cores']['botao2']?> 100%) !important;
	background: linear-gradient(center top,<?=$INI['cores']['botao2']?> 0%, <?=$INI['cores']['botao2']?>  100%) !important;
} 
  
<? if($INI['background']['arquivo'] != "" and $INI['cores']['fixarbackground'] !="Y" and $INI['background']['statusimagembackground'] =="Y" ){
	
	$repeat = "no-repeat"; 
	if($INI['cores']['reapeathorizontal'] =="Y" and $INI['cores']['reapeatvertical'] =="Y" ){
		$repeat = "repeat";
	}
	else if($INI['cores']['reapeatvertical'] =="Y" ){
		$repeat = "repeat-y";
	}	
	else if($INI['cores']['reapeathorizontal'] =="Y" ){
		$repeat = "repeat-x";
	}
	

  } ?> 
 
 html, body {
    
   <? if($INI['cores']['corbackground'] == 'N'){?>
		background: url("<?=$PATHSKIN?>/background/<?=$INI['background']['arquivo']?>") <?=$repeat?> !important; 
 <? } else{?>
		 background: <?=$INI['cores']['coresbackground1']?>;
	<?} ?>	
}
 
<? if($INI['cores']['header']=="Y"){?>
	.page{
		   background: none  !important;
	}
<? } else { ?> 
	.page{
		  background: <?=$INI['cores']['corcabecalho']?>  !important;
	 }
<? } ?>
  
#cat > li > a > span > span{
	    font-size: <?=$INI['cores']['tamfonte']?>px  !important;
}
  
#cat > li > a > span > span {
color: <?=$INI['cores']['menu-item-background']?>  !important;
}

#cat > li:hover > a > span > span {
	color:  <?=$INI['cores']['itemhover']?>  !important;
}

div#menu ul ul a span{
	 color:  <?=$INI['cores']['submenu']?>  !important; 
}
div#menu ul ul li{
	background: <?=$INI['cores']['submenuback']?>  !important; 
}
.search-button{
	background: <?=$INI['cores']['bt1']?> url("<?=$PATHSKIN?>/images/find-zoom.png") no-repeat scroll center center  !important;
}
.search-button:hover {
    background-color: <?=$INI['cores']['bt2']?>  !important; 
}

.button-salmon {
    background:<?=$INI['cores']['bt1']?>  !important; 
}

.button-salmon:hover {
    background-color: <?=$INI['cores']['bt2']?>  !important; 
}

.btn-buy{
	 background: <?=$INI['cores']['bt1']?>  !important; 
	
}
.btn-buy:hover{
    background-color: <?=$INI['cores']['bt2']?>  !important; 
}

.link-1 b {
	 background: <?=$INI['cores']['bt1']?>  !important; 
	
}
.link-1 b:hover {
    background-color: <?=$INI['cores']['bt2']?>  !important; 
}

.btn, .noUiSlider div{
	 background-color: <?=$INI['cores']['bt1']?>  !important; 
	 border-color: <?=$INI['cores']['bt1']?>  !important; 
	
}
.btn, .noUiSlider div:hover {
    background-color: <?=$INI['cores']['bt2']?>  !important; 
    border-color: <?=$INI['cores']['bt2']?>  !important; 
}

.LinksHeader ul li a{
	
	    color:  <?=$INI['cores']['linksheader']?> ;  
}
header a{ 
	    color:  <?=$INI['cores']['linksheader']?>  !important;  
}
.conditions-product{
	background:  <?=$INI['cores']['conditionsproduct']?>  !important;
}
.preco-por{
	color:  <?=$INI['cores']['conditionsproduct']?>  !important;
}
.discount-product{
	background:  <?=$INI['cores']['conditionsproduct']?>  !important;
}
.discount-product:before{ 
	border-color: transparent  <?=$INI['cores']['conditionsproduct']?>  transparent transparent !important;
}
.newsletter.bar.hide.show-opt-in.add-shop{
	background-color:  <?=$INI['cores']['backgroundbox1']?>  !important;
}
.newsletter.bar.hide.show-opt-in{
	background-color:  <?=$INI['cores']['backgroundbox2']?>  !important;
}
.payment-sell .label, .payment-price-old > span, .payment-price-old del{
	color:  <?=$INI['cores']['payment-price-old']?>  !important;
}
.payment-price{
	color:  <?=$INI['cores']['payment-price']?>  !important;
}
.my-account-page a{
	color:  <?=$INI['cores']['corinterno']?>  !important;	
}
.my-account-page .my-account .highlight{
	color:  <?=$INI['cores']['corinterno']?>  !important;	
}
.my-account-page .orders-list .title .highlight{
	color:  <?=$INI['cores']['corinterno']?>  !important;	
}






.my-cart .dropdown-menu > li > a {
    color: <?=$INI['cores']['bt1']?>  !important;
}
.modal .btn-link {
    color: <?=$INI['cores']['bt1']?>  !important;
}
.my-cart .link, .my-cart .btn-link {
    color: <?=$INI['cores']['corinterno']?>  !important; 
}
.my-cart-product-wrapper .link-edit {
    color: <?=$INI['cores']['bt1']?>  !important; 
}
.my-cart-product-wrapper .link-trash {
    color: <?=$INI['cores']['bt1']?>  !important;
}
.my-cart-gift-box .gift-wrapper .gift-value .link-trash {
    color: <?=$INI['cores']['bt1']?>  !important;
}
				.my-cart-gift-box .icon-wm-tag {
					background-color: <?=$INI['cores']['corinterno']?>  !important;
				 
				}
				.my-cart-totals *:-moz-placeholder {
					color: <?=$INI['cores']['corinterno']?>  !important;
				}
				.my-cart-totals *::-moz-placeholder {
					color: <?=$INI['cores']['corinterno']?>  !important;
				}
.my-cart-freight-text .link-edit {
    color: <?=$INI['cores']['bt1']?>  !important;
    
}
				.label-gift-wrap {
					color: <?=$INI['cores']['corinterno']?>  !important; 
				}
				.wm-sign-in .label { 
					color: <?=$INI['cores']['corinterno']?>  !important;
				}
.wm-sign-in a {
  color: <?=$INI['cores']['bt1']?>  !important;
}
.btn, .noUiSlider div {
  background-color: <?=$INI['cores']['bt1']?>  !important;
  border-color: <?=$INI['cores']['bt1']?>  !important;
}
			.cat-title {
				color: <?=$INI['cores']['corinterno']?>  !important;
			}
.my-account-page a {
    color: <?=$INI['cores']['bt1']?>  !important;
}
 
 #my-account-container.my-account-page .nav-tabs > li.active a:before {
    background-color: <?=$INI['cores']['bt1']?>  !important;
   
}
			.my-account-page .mfp-content .order-details .highlight {
				color: <?=$INI['cores']['corinterno']?>  !important; 
			}
			.my-account-page .delivery-address-list .title .highlight {
				color: #<?=$INI['cores']['corinterno']?>  !important;
			}
			.my-account-page .mfp-content .daterangepicker-div .daterangepicker table td.available:hover span, .my-account-page .mfp-content .daterangepicker-div .daterangepicker table td.in-range span, .my-account-page .mfp-content .daterangepicker-div .daterangepicker table td.start-date span, .my-account-page .mfp-content .daterangepicker-div .daterangepicker table td.end-date span {
				background-color: <?=$INI['cores']['corinterno']?>  !important;   
			}
#btnEnviarAnswer {
  background: none repeat scroll 0 0 <?=$INI['cores']['bt1']?>  !important;
  box-shadow: 0 3px <?=$INI['cores']['bt1']?>  !important;
}

			.title-customer-review {
			  color: <?=$INI['cores']['corinterno']?>  !important; 
			}
			.AnuncioAvaliacoes, 
			.Login {
				color: <?=$INI['cores']['corinterno']?>  !important; 
			}
			.titlePage {
				background:<?=$INI['cores']['corinterno']?>  none repeat scroll 0 0;
			}

.formButton {
	background: <?=$INI['cores']['bt1']?>  !important;
}

.buyButton a {
	background: <?=$INI['cores']['bt1']?>  !important;
}	
.btn-form-search {
	background: <?=$INI['cores']['bt1']?>  !important;
	border: 1px solid <?=$INI['cores']['bt1']?>  !important;
	 
}
			#faqs dt {
				color: <?=$INI['cores']['corinterno']?>  !important;  
			}

</style> 

<? if($INI['cores']['fixarbackground'] =="Y"){?>
	<div class="page-background"><img width="100%" height="100%" src="<?=$PATHSKIN?>/background/<?=$INI['background']['arquivo']?>"></div> 
<? } ?>
	
<? if($INI['cores']['extenderheader'] =="Y"){?>
	<div class="cabecalhosub"> 
		<img width="100%" height="100%" src="<?=$PATHSKIN?>/header/<?=$INI['header']['arquivo']?>">
	</div> 
<? } ?>
	

