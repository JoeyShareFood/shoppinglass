<?php  

$SqlProduct = "select * from team where id = " . $idoferta . " and moderacao = 'Y'";
$QueryProduct = mysql_query($SqlProduct);
$team = mysql_fetch_assoc($QueryProduct);

/* Caso não exista oferta, usuário e redirecionado para a página inicial. */
if(empty($team['id'])) {
	header("Location: " . $ROOTPATH);
}

$BlocosOfertas->getDados($team,"destaque.jpg"); 

$avaliacaomedia = avaliacaomedia($team['id']);
$avaliacaomediaformat1 =  number_format($avaliacaomedia, 1, '.', ''); 
$avaliacaomediaformat = str_replace(".","_",$avaliacaomediaformat1);

$total_avaliacao = get_total_avaliacao_oferta($team['id']);

/* É buscado a ID do parceiro que cadastrou a oferta da página atual. */
$sql = "select partner_id from team where id = " . $idoferta . " and moderacao = 'Y'";
$rs = mysql_query($sql);
$row = mysql_fetch_assoc($rs);

/* É buscado algumas informações acerca do parceiro. */
$sql = "select * from user where id = " . $row['partner_id'];
$rs = mysql_query($sql);
$user = mysql_fetch_assoc($rs);

$login = empty($user['login']) ? utf8_decode($user['username']) : utf8_decode($user['login']);

/* É buscado o numero de pedidos que determinado vendedor recebeu. */
$SqlOrder = "SELECT * FROM `order` WHERE partner_id = " . $row['partner_id'];
$RsOrder = mysql_query($SqlOrder);
$NumOrder = mysql_num_rows($RsOrder);

/* O numero de pontos, é multiplicado pelo valor unitário de pontuação. */
if($user['pontuacao'] > 1) {
	$pontuacao = $INI['system']['pontuacao'] * $user['pontuacao'];
}

/* É buscado o numero de qualificações que determinado produto recebeu. */
$SqlAvaliation = "SELECT * FROM `qualification` WHERE id_qualificado = " . $row['partner_id'];
$RsAvaliation = mysql_query($SqlAvaliation);
$NumAvaliation = mysql_num_rows($RsAvaliation);

/* Os valores sao somados, e depois dividos pela quantidade para gerar a media das avaliaçoes. */
while($RowAvaliation = mysql_fetch_assoc($RsAvaliation)) {
	
	$Media += $RowAvaliation['pontuacao'];
}

$Media = $Media / $NumAvaliation;

/* É buscado o numero de Qualificações que determinado produto recebeu. */
$SqlQuestions = "SELECT * FROM `questions` WHERE id_vendedor = " . $row['partner_id'];
$RsQuestions = mysql_query($SqlQuestions);
$NumQuestions = mysql_num_rows($RsQuestions);

$sql_option = "select id, size, team_id from options where team_id = " . $team['id'] . " and size <> '' and color <> '' and stock >= 1 group by size";
$rs_option = mysql_query($sql_option);
$number_options = mysql_num_rows($rs_option);
unset($sql_option, $rs_option, $number_option);

require_once("include/head.php");	
	 
?>  
<div style="display:none;" class="tips"><?=__FILE__?></div> 

<body id="page1" class="webstore home">
<div class="cabecalhosub"></div>
<?php
	//if(detectResolution()) {
?>
<!-- Responsivo -->
<div class="containerM">
	<? require_once(DIR_BLOCO . "/headerM.php"); ?>   
	<div class="row">
		<? require_once(DIR_BLOCO . "/detalhe_produtoM.php"); ?> 	
	</div>
</div>
<?php //} else { ?>	
<div class="container"> 
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-551bf27e38c8eda6" async="async"></script>

	<div class="page">
		<? require_once(DIR_BLOCO."/header.php"); ?>   
		<div class="toptopo"></div> 
		<section id="content" class="content">
			<div class="main-content clearfix">  
			 <?php  
				$navegador = getNavegador(); 
				
				unset($SqlProduct, $QueryProduct, $team, $BlocosOfertas);
				
				$BlocosOfertas = new BlocosOfertas();
				
				$SqlProduct = "select * from team where id = " . $idoferta . " and moderacao = 'Y'";
				$QueryProduct = mysql_query($SqlProduct);
				$team = mysql_fetch_assoc($QueryProduct);

				/* Caso não exista oferta, usuário e redirecionado para a página inicial. */
				if(empty($team['id'])) {
					header("Location: " . $ROOTPATH);
				}

				$BlocosOfertas->getDados($team,"destaque.jpg"); 
				
				if($team){ 				
					$_SESSION['team_id']=$team[id];
				  } ?> 
					<script type="text/javascript" src="<?=$ROOTPATH?>/js/jssorslider/jssor.core.js"></script>
					<script type="text/javascript" src="<?=$ROOTPATH?>/js/jssorslider/jssor.utils.js"></script>
					<script type="text/javascript" src="<?=$ROOTPATH?>/js/jssorslider/jssor.slider.js"></script> 
					<script type="text/javascript" src="<?=$ROOTPATH?>/js/jssorslider/ini.js" ></script>
					<link rel="stylesheet" href="<?=$PATHSKIN?>/css/slidedetailproduto.css" type="text/css" media="all">
				 
					<script>
						function validacao(){

							<?php
								if($number_options >= 1) {
							?>
							var checked = [];
							var result = "";
							
							/* Verifica se o tamanho foi escolhido; */
							J('.choice-product-options').each(function(){							
								if(J(this).is(':checked')) {	
									checked.push(1);
								}
								else {
									checked.push(0);
								}
							});
							
							var option_checked = !(J.inArray(1, checked) !== -1) ? true : false;
							
							if(option_checked) {
								window.alert("Você deve selecionar o tamanho do produto!");
								return;									
							}
							
							checked = [];
							result = "";
							
							/* Verifica se a cor foi escolhida. */
							J('.choice-product-color').each(function(){							
								if(J(this).is(':checked')) {	
									checked.push(1);
								}
								else {
									checked.push(0);
								}
							});
							
							var option_checked = !(J.inArray(1, checked) !== -1) ? true : false;
							
							if(option_checked) {
								window.alert("Você deve selecionar a cor do produto!");
								return;									
							}
							<?php } ?>
								
							
							<? if(!empty($team['uploadarquivo'])){ ?>							
							if(J('#file_upload').val()==""){
								alert('Por favor, você deve enviar o arquivo.')
								J('#file_upload').focus()
								return;
							}   
							<? } ?>
							 
							J('#dadospedido').submit();
						}   
					</script> 
				<div class="detalhe_principal_op" >
				 <div style="display:none;height:36px;" class="tips"><?=__FILE__?></div>
				 <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#FFFFFF" > 
				 <tr>
					<td colspan="3" width="100%" valign="top"> 
					<!-- 
					<div class="product-title-header">  
						<div class="linhatab"></div>
					
					</div>
					-->
					 <div class="destaque_box" >
						<div class="border_box">
							<div class="deal-page-title"> 
								<?php echo mb_ucfirst(strtolower(utf8_decode($team['title'])));  ?>
							</div>						
							<aside class="product-info-right">
								<div id="buy-box" class="buy-box clearfix">  					 
									<div class="content content-Walmart" style="">
										<div class="content-wrapper">
											<div data-sellerid="1" data-sellprice="1999" class="product-price">
												<p style="color:#999;">
													Código do produto: #<?php echo $team['id']; ?>
												</p>
												<?php
													if($team['market_price'] != "0.01" && $team['market_price'] != "0.00") {
												?>
												<b>
													<span class="payment-price-old" >
														<span class="payment-currency " style="font-size:22px !important;">
															R$ 
														</span>
														<del style="font-size:22px !important;"><?=getpreco($team['market_price']); ?></del>
													</span>
												</b>
												<?php } ?>
												<b>
													<span class="payment-sell">
														<span class="payment-currency cifrao">R$</span>
														<span class="payment-price"><span class="int"><?=getpreco($team['team_price']); ?></span><span class="dec" style="display:none;">,<?=getdecimal($team['team_price']); ?></span> </span>
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
												<div class="title-option">
													Opções do produto
												</div>
												<div class="options-size">
													<ul class="list-options">
													<?php
														$sql_option = "select id, size, team_id from options where team_id = " . $team['id'] . " and size <> '' and color <> '' and stock >= 1 group by size";
														$rs_option = mysql_query($sql_option);
														
														while($options = mysql_fetch_assoc($rs_option)) {
													?>
														<li>
															<input type="radio" class="choice-product-options" name="options-product" attr-product-size="<?php echo $options['size']; ?>" attr-product-id="<?php echo $options['team_id']; ?>" value="<?php echo $options['id']; ?>"> 
															Tamanho: 
															<span class="color-size">
																<?php echo $options['size']; ?>
															</span>
														</li>
													<?php } ?>	
													</ul>
												</div>
												<div class="options-color">
												</div>
												<div class="end-options-message">
												</div>												
												<p class="text-product">
													Condição: <b><?php echo empty($team['condicoes_produto']) ? "-" : strtolower($team['condicoes_produto']); ?></b>
												</p>
												<p class="text-product">
													<?php 
														echo ucfirst(mb_strtolower(strip_tags($team['summary'])));
													?>
												</p>
											</div>  
											<!-- 
											<div class="product-quantity-range" style="display:none;"> 
											   <? if($condbuy=nanooption(utf8_decode($team['condbuy']))){?>
													<div class="product-sku-selector" style=" padding-left: 10px; ">          
														<div class="product-sku-selector-item"> 
															<span class="old">
																<div class="opcaocompra" style="margin-top:0px;"> 
																	<select id="condbuy" name="condbuy" class="select1"><option value=""><?=utf8_decode($team['titulo_opcao1'])?></option><?php echo Utility::Option(array_combine($condbuy, $condbuy), 'condbuy','') ; ?></select>
																</div>
															</span>
														</div>          
													</div>
											<?php } ?> 
												 <? if($condbuy2=nanooption(utf8_decode($team['condbuy2']))){?>
														<div class="product-sku-selector" style=" padding-left: 10px; ">          
															<div class="product-sku-selector-item"> 
																<span class="old">
																	<div class="opcaocompra" style="margin-top:0px;"> 
																		<select id="condbuy2" name="condbuy2" class="select1"><option value=""><?=utf8_decode($team['titulo_opcao2'])?></option><?php echo   Utility::Option(array_combine($condbuy2, $condbuy2), 'condbuy2','') ; ?></select>
																	</div>
																</span>
															</div>          
														</div>
												<?php } ?>  							
												</div>  
												-->
												<form enctype="multipart/form-data" method="POST" id="dadospedido" name="dadospedido" action="<?=$ROOTPATH?>/addcarrinho/<?=$team['id']?>">
													<div style="margin-top: 12px;">
														<? if(!empty($team['uploadarquivo'])){?>   
															<div class="custom_file_upload">
																<?=utf8_decode($team['titulo_upload'])?>
																<input type="text" class="file"  readonly="readonly" id="file_info"  name="file_info" style="width:71%">
																<div class="file_upload">
																	<input type="file" value="procurar" id="file_upload" name="file_upload">
																</div>
															</div> 
														<? } ?>
													
														<input type="hidden" name="idoferta" id="idoferta" value="<?=$team['id']?>">   
														<input type="hidden" name="utm" id="utm" value="">
													</div>
												</form> 
													
											</div> 
										</div>  
										<div class="linha4"></div>  
											<div class="txtdetaildispo" style=" font-size: 13px; color: #666; margin-top: 10px; margin-bottom: 10px;clear:both;"> 
											<?php
												if(checkStock($team['id'])>0){
											?>
											<span style="color: #5C9E0D;">
												<div class="dispo">
													<?php echo strip_tags($BlocosOfertas->disponibilidade); ?> <?php echo stock($team['id']); ?> unidade(s)
												</div>
											</span>
											<?php
												}else{
											?>
											<span style="color: #5C9E0D;">
												<div class="dispo">
													<?=strip_tags($BlocosOfertas->disponibilidade)?>
												</div>
											</span>
											<?php
												}
											?>
											<div class="codigoref" style="color: #666;">Cód de referência: 
												<span style="color: #5C9E0D;"><?=$team['id']?></b> 
											</div>
										</div>	
										<div style="display:none;">
										<?php
											if(!(empty($team['observacao_preco']))) {
										?>
										<div style="padding: 7px;background-color: #eee;margin-top: 8px; clear:both;font-size:12px;width:298px;margin-bottom:11px;"> 
											 em até <?=utf8_decode($team['observacao_preco'])?>
										</div> 
										<?php } ?>
										</div>
										<? if(!$BlocosOfertas->oferta_esgotada){ ?> 
											<div style="margin-top: 35px;">
											
												<? if(!$login_user_id ){ ?> <a href="#" class="tk_logar btn-buy">Quero comprar</a><? } ?>  
												<? if($login_user_id ){?>  <a href="javascript:validacao();" class="btn-buy">Quero comprar</a><? } ?>  
											
											</div>
										<? } ?> 
										<div class="RedesSocais">
											<p style="font-size:14px;line-height:23px;">
												Gostou desse produto? <b>Compartilhe</b> com seus amigos!
											</p>
											<div class="addthis_toolbox addthis_default_style" style="float:left; width: 306px;margin-top: 9px;">
												<!-- Go to www.addthis.com/dashboard to customize your tools -->
												<!-- Go to www.addthis.com/dashboard to generate a new set of sharing buttons -->
												<a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php echo $BlocosOfertas->linkoferta; ?>" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/></a>
												<!--
												<a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo urlencode($BlocosOfertas->linkoferta); ?>&related=" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/></a>
												<a href="//plus.google.com/u/0/117034123745664853830?prsrc=3" rel="publisher" target="_blank" style="text-decoration:none;"><img src="http://ssl.gstatic.com/images/icons/gplus-32.png" alt="Google+" style="border:0;width:32px;height:32px;"/></a>
												-->
											</div>
										</div>
										<!--										
										<div id="buy-banner">
											<div class="bp-horizontal-banner ">
												<span class="bp-icon"></span>
												<div class="buy-protection-info">
													<img align="left" style="margin-right:10px;margin-top:-10px;" src="<?php echo $PATHSKIN; ?>/images/escudo_politica.jpg"><h3>Proteção ao consumidor</h3>
													<ul class="buy-protection-info-list util-clearfix">
														<li class="bp-info-item">Reembolso completo se você não receber o pedido</li>
														<li class="bp-info-item">Reembolso ou manter os seus itens que são diferentes da descrição</li>
													</ul>
													<div class="buy-protection-more">
														<a href="<?php echo $ROOTPATH; ?>/page/2" target="_blank" rel="nofollow" data-spm-anchor-id="0.0.0.0">Saiba mais</a>
													</div>                              
												</div>
											</div>
										</div>
										-->
									 </div>
								</aside>
							 <div id="slider1_container">
				 
								<div u="loading" style="position: absolute; top: 0px; left: 0px;">
									<div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
										background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
									</div>
									<div style="position: absolute; display: block; background: url(<?=$PATHSKIN?>/images/loading.gif) no-repeat center center;
										top: 0px; left: 0px;width: 100%;height:100%;">
									</div>
								</div> 
								<div u="slides" style="cursor: pointer; position: absolute; left: 220px; top: 14px; width: 350px; height: 406px; overflow: hidden;">
									 <div>
									<img  style="max-width:500px;" alt="<?=$BlocosOfertas->tituloferta ?>"  u="image" id="linkimg" src="<?=$BlocosOfertas->imagemoferta?>" /> 
									<input type="hidden" id="linkimg_foto" value="<?=$BlocosOfertas->imagemoferta10?>">
									<img   u="thumb" src="<?=$BlocosOfertas->imagemofertathumb?>" />
									</div> 
								 
									<? if(!empty($BlocosOfertas->imagemoferta2)){?>
									<div>
										<img alt="<?=$BlocosOfertas->tituloferta ?>" u="image" id="linkimg2" src="<?=$BlocosOfertas->imagemoferta2?>" />
										<input type="hidden" id="linkimg2_foto" value="<?=$INI['system']['wwwprefix']."/media/".$team['image1']; ?>">
										<img   u="thumb" src="<?=$BlocosOfertas->imagemoferta2thumb?>" />
									</div> 		 
									<? } ?>
									<? if(!empty($BlocosOfertas->imagemoferta3)){?>
									<div>
										<img  alt="<?=$BlocosOfertas->tituloferta ?>"  u="image" id="linkimg3" src="<?=$BlocosOfertas->imagemoferta3?>" />
										<input type="hidden" id="linkimg3_foto" value="<?=$INI['system']['wwwprefix']."/media/".$team['image2']; ?>">
										<img  u="thumb" src="<?=$BlocosOfertas->imagemoferta3thumb?>" />
									</div> 
									<? } ?>
									<? if(!empty($BlocosOfertas->imagemoferta4)){?>
									<div>
										<img  alt="<?=$BlocosOfertas->tituloferta ?>" u="image" id="linkimg4" src="<?=$BlocosOfertas->imagemoferta4?>" />
										<input type="hidden" id="linkimg4_foto" value="<?=$INI['system']['wwwprefix']."/media/".$team['gal_image1']; ?>">
										<img u="thumb" src="<?=$BlocosOfertas->imagemoferta4thumb?>" />
									</div> 
									<? } ?>
									<? if(!empty($BlocosOfertas->imagemoferta5)){?>									
									<div>
										<img  alt="<?=$BlocosOfertas->tituloferta ?>" u="image" id="linkimg5" src="<?=$BlocosOfertas->imagemoferta5?>" />
										<input type="hidden" id="linkimg5_foto" value="<?=$INI['system']['wwwprefix']."/media/".$team['gal_image2']; ?>">
										<img u="thumb" src="<?=$BlocosOfertas->imagemoferta5thumb?>" />
									</div> 
									<? } ?>
									<? if(!empty($BlocosOfertas->imagemoferta6)){?>
									<div>
										<img  alt="<?=$BlocosOfertas->tituloferta ?>" u="image" id="linkimg6" src="<?=$BlocosOfertas->imagemoferta6?>" />
										<input type="hidden" id="linkimg6_foto" value="<?=$INI['system']['wwwprefix']."/media/".$team['gal_image3']; ?>">
										<img u="thumb" src="<?=$BlocosOfertas->imagemoferta6thumb?>" />
									</div> 
									<? } ?>
									<? if(!empty($BlocosOfertas->imagemoferta7)){?>
									<div>
										<img  alt="<?=$BlocosOfertas->tituloferta ?>" u="image" id="linkimg7" src="<?=$BlocosOfertas->imagemoferta7?>" />
										<input type="hidden" id="linkimg7_foto" value="<?=$INI['system']['wwwprefix']."/media/".$team['gal_image4']; ?>">
										<img u="thumb" src="<?=$BlocosOfertas->imagemoferta7thumb?>" />
									</div> 
									<? } ?>
									<? if(!empty($BlocosOfertas->imagemoferta8)){?>									
									<div>
										<img  alt="<?=$BlocosOfertas->tituloferta ?>" u="image" id="linkimg8" src="<?=$BlocosOfertas->imagemoferta8?>" />
										<input type="hidden" id="linkimg8_foto" value="<?=$INI['system']['wwwprefix']."/media/".$team['gal_image5']; ?>">
										<img u="thumb" src="<?=$BlocosOfertas->imagemoferta8thumb?>" />
									</div> 
									<? } ?>				
									<? if(!empty($BlocosOfertas->imagemoferta9)){?>									
									<div>
										<img  alt="<?=$BlocosOfertas->tituloferta ?>" u="image" id="linkimg9" src="<?=$BlocosOfertas->imagemoferta9?>" />
										<input type="hidden" id="linkimg9_foto" value="<?=$INI['system']['wwwprefix']."/media/".$team['gal_image6']; ?>">
										<img u="thumb" src="<?=$BlocosOfertas->imagemoferta9thumb?>" />
									</div> 
									<? } ?>									
									<? if(!empty($BlocosOfertas->imagemoferta10)){?>
									<div>
										<img  alt="<?=$BlocosOfertas->tituloferta ?>" u="image" id="linkimg10" src="<?=$BlocosOfertas->imagemoferta10?>" />
										<input type="hidden" id="linkimg10_foto" value="<?=$INI['system']['wwwprefix']."/media/".$team['gal_image7']; ?>">
										<img u="thumb" src="<?=$BlocosOfertas->imagemoferta10thumb?>" />
									</div>   
									<? } ?>
								</div>  
								<!-- Arrow Left -->
								<span u="arrowleft" class="jssora05l" style="width: 40px; height: 40px; top: 195px; left: 235px;">
								</span>
								<!-- Arrow Right -->
								<span u="arrowright" class="jssora05r" style="width: 40px; height: 40px; top: 195px; left: 515px;">
								</span>
								<script>
									jssor_slider1_starter('slider1_container');
								</script>
								</div> 
							</div>							
							</div>
							<div class="BlocoVendedor">
								<div class="InformacoesVendedor">
									<?php
										$sql_logo = "select logo from info where id_vendedor = " . $row['partner_id'];
										$rs_logo = mysql_query($sql_logo);
										$row_logo = mysql_fetch_assoc($rs_logo);
									?>
									
									<div>
										<div>
											<p class="NomeVendedor" style="font-size:15px;text-align:center;">
												Vendedor <br /> <br /><br /> <br />
												<b style="font-size:15px;color:#797979;line-height: 1.5em;text-transform: uppercase;">
													<?php echo $login; ?>
												</b>
											</p> 
										</div>
										<div style="margin-top: 11px; margin-bottom: 10px; text-align: center; float: left; margin-left: 100px;">
											<?php
												if($row_logo['logo'] != "") {
											?>
											<img src="<?php echo $ROOTPATH;?>/media/<?php echo $row_logo['logo']; ?>" style="max-width: 80px;"> 
											<?php } else { ?>
											<img src="<?php echo $PATHSKIN;?>/images/store.png" style="max-width: 80px;"> 
											<?php } ?>
										</div>
										<div style="margin-top:18px;float: left;width: 100%;">
											<?php if($NumOrder >= 1) { ?><p><b style="font-size:18px;font-family:georgia;"><?php echo $NumOrder; ?></b> pedidos recebidos</p><?php } ?>
											<?php if($NumOrderPay >= 1) { ?><p><b style="font-size:18px;font-family:georgia;"><?php echo $NumOrderPay; ?></b> compras finalizadas</p><?php } ?>
											<?php if($NumAvaliation >= 1) { ?><p><b style="font-size:18px;font-family:georgia;"><?php echo $NumAvaliation; ?></b> Qualificações recebidas</p><?php } ?>
											<?php if($Media >= 1) { ?><p><b style="font-size:18px;font-family:georgia;"><?php echo $Media; ?> é a media das qualificações</p><?php } ?>
											<?php if($NumQuestions >= 1) { ?><p><b style="font-size:18px;font-family:georgia;"><?php echo $NumQuestions; ?></b> perguntas recebidas</p><?php } ?><br /> 
										</div>
									</div>	 
									<br />
									<br />
									<p><a  href="<?=$ROOTPATH?>/avaliation/<?php echo $user['id']; ?>"  class="link-1"><em><b style="color: rgb(255, 255, 255); padding: 6px; width: 250px; text-align: center;">Ver qualificações recebidas</b></em></a></p>
									<p><a  href="<?=$ROOTPATH?>/store/<?php echo $row['partner_id']; ?>"  class="link-1"><em><b style="color: rgb(255, 255, 255); padding: 6px; width: 250px; text-align: center;">Ver lojinha deste vendedor</b></em></a></p>
								</div>
							</div>	
							<div class="BannersDireita">
								<?php echo $INI['bulletin']['bannerpageproduct']; ?>
							</div>
						</div>
						<div style="clear:both;">	   
							<?php 
								//require_once(DIR_BLOCO."/bloco_tabs.php");    
							?>
							<div class="owl-item-title">
								<b>Quer saber mais sobre este produto?</b>
							</div>
							<? require_once(DIR_BLOCO."/bloco_perguntas.php");  ?>
					   </div>
						<?php
							require_once(DIR_BLOCO . "/lista_produtos_vendedor.php");
						?>
					</td> 
				 </tr>
				</table>
				</div>  
				 <form method="POST" id="formparceiro" action="/index.php" name="formparceiro"></form>
				 <? 
					if($result=="sim"){?> 
						<script>
						jQuery(document).ready(function(){ 
							jQuery.colorbox({html:"<font color=#1F4574;font-size:11px;>O arquivo foi enviado com sucesso. Você pode continuar com a finalização de seu pedido.</font>"});		
							});
						</script> 
					<? } else if($result=="nao"){ ?> 
						<script>
						jQuery(document).ready(function(){ 
							jQuery.colorbox({html:"<font color=red;font-size:11px;>Não foi possível enviar o arquivo.</font>"});
							});
						</script> 
					<? } ?> 
					</div>
				</section> 
				<?php require_once(DIR_BLOCO."/rodape.php"); ?>
			</div>
			<?php //} ?>
		</div>
	</body>
</html>
  
<script> 
function verifica_logado(){
  if(J("#idusuario").val()=="" || J("#idusuario").val()=="0"){
		location.href  = '<?php echo $INI['system']['wwwprefix']?>/index.php?<?php echo $_SERVER["QUERY_STRING"] ?>';
	} 
}  
function envia_url_comprar(url_comprar){  
	location.href  = url_comprar;
} 
</script>
  <script>
	J(document).ready(function() {
		J("#file_upload").change(function() {    
			//alert(J("#file_upload").val())
			J("#file_info").val(J("#file_upload").val())  
		});
		
		
		J("#linkimg").click(function() {    
		 J.colorbox({
				href:J('#linkimg').attr('src')  
			}); 
		});
		J("#linkimg2").click(function() { 
			J.colorbox({
				href:J('#linkimg2').attr('src')  
			
			}); 
		});	
		J("#linkimg3").click(function() { 
			J.colorbox({
				href:J('#linkimg3').attr('src')  
			}); 
		});
		J("#linkimg4").click(function() { 
			J.colorbox({
				href:J('#linkimg4').attr('src')  
			});  
		});
		J("#linkimg5").click(function() { 
			J.colorbox({
				href:J('#linkimg5').attr('src')  
			}); 
		});
		J("#linkimg6").click(function() { 
			J.colorbox({
				href:J('#linkimg6').attr('src')  
			});  
		});	
		J("#linkimg7").click(function() { 
			J.colorbox({
				href:J('#linkimg7').attr('src')  
			}); 
		});
		J("#linkimg8").click(function() { 
			J.colorbox({
				href:J('#linkimg8').attr('src')  
			}); 
		});
		J("#linkimg9").click(function() { 
			J.colorbox({
				href:J('#linkimg9').attr('src')  
			}); 
		});
		J("#linkimg10").click(function() { 
			J.colorbox({
				href:J('#linkimg10').attr('src')  
			}); 
		});	 
	});
	
function enviaproposta(){
 
	valoranuncio = '<?=$team['team_price']?>'
	  
	var idoferta = <?php echo $idoferta; ?>;
	var nome_proposta = J("#txtNome").val();
	var email_proposta  = J("#txtEmail").val();
	var ddd_proposta = J("#dddTel").val();
	var telefone_proposta = J("#txtTel").val();
	var captcha = J('#captcha').val();
	var proposta = J('#txtMsg').val();
	 
	if(idoferta == ""){

		alert("Ocorreu um erro inesperado. Por favor, volte mais tarde.")
		return;
	} 
	if(nome_proposta == ""){

		alert("Você esqueceu de informar o seu nome")
		document.getElementById("nome_proposta").focus();
		return;
	} 
	if(email_proposta == ""){

		alert("Você esqueceu de informar o seu email")
		document.getElementById("email_proposta").focus();
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
		   url: URLWEB+"/enviaproposta.php",
		   data: "captcha="+captcha+"&idoferta="+idoferta+"&nome_proposta="+nome_proposta+"&email_proposta="+email_proposta+"&ddd_proposta="+ddd_proposta+"&telefone_proposta="+telefone_proposta+"&proposta="+proposta,
		   success: function(msg){
		   
		   if(jQuery.trim(msg)==""){
		    	jQuery.colorbox({html:"<font color='black' size='10'>Contato enviado com sucesso! </font>", width:"450px",height:"210px"});
				location.reload();
			}  
		   else {
					jQuery.colorbox({html:"<font color='black' style='font-size:15px;font-weight:600;'>"+msg+"</font>", width:"350px",height:"150px"});
					location.reload();
				}
			 }
		 });
}
	
</script>
<script>
	J('document').ready(function(){
		
		J('.end-options-message').hide();
		
		J('.choice-product-options').click(function(){
			
			var product_id = J(this).attr('attr-product-id');
			var size_id = J(this).attr('attr-product-size');
			
			if((product_id != "" && product_id != undefined) && (size_id != "" && size_id != undefined)) {
				
				J.ajax({
					type: "GET",
					cache: false,
					async: true,
					url: "<?php echo $ROOTPATH; ?>/ajax/filtro_pesquisa.php",
					data: "filtro=options_product&product_id=" + product_id + "&size_id=" + size_id,
					success: function(data) {
						
						J('.end-options-message').hide("slow");
						J('.options-color').html(data);
					}
				});				
			}
		});
	});
</script>