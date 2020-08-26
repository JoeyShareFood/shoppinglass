<?php  

	require_once("include/head.php"); 
	need_login();
	
	$existe_registro = 0;
	
	if(isset($_GET["idbilli"]) and !(empty($_GET["idbilli"]))) {
		
		$idbilli = (int) strip_tags($_GET["idbilli"]);
	}
	else 
	{
		$existe_registro = 0;
	}
	
	$sql = "select * from faturas where id = '" . $idbilli . "' and id_user = '" . $login_user['id'] . "'";
	$rs = mysql_query($sql);
	$faturas = mysql_fetch_assoc($rs);
	
	$user = Table::Fetch('user', $faturas['id_user']);
	
	if(!(empty($faturas))) {
		$existe_registro = 1;
	}

?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 

<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">

<style>
.my-account-page .orders-list .wrapper-order-item .order-list-item {
	height: 200px;
}
</style>

<body id="page1" class="webstore home">

<div class="container">  
	<div class="page">
		<?php  require_once(DIR_BLOCO."/header.php"); ?>
			<div class="main-content clearfix"> 
				<div class="my-account-page" id="VIPCOM_my-account-container"> 
				 <div id="my-account-header"> 
					<?php  require_once(DIR_BLOCO."/my-account.php"); ?>
					 <div id="my-account-content" style="display: block;">
					 <div class="orders-list clearfix">  
						<div data-total-orders="6" class="order-list">
							<div class="row">
								<div class="order-list-items orders-list-result">
									<div data-order-id="18477617" class="wrapper-order-item md-2">
										<?php if($existe_registro == 1) { ?>
										<br />
										<h4>Detalhes da fatura</h4>									
											<div data-order-id="18477617" class="order-list-item">
												<div class="row">
													<div class="col-lg-3 row order-list-status pull-left" style="width:659px;">													
														<?php if($faturas['status'] == "pay") { ?>
														<div class="order-text-status">
															<div class="col-lg-3 icon-column pull-left">
																<div class="icon-background status-done">
																	<i class="icon-remove"></i>
																</div>
															</div>
															<div class="status-title-qualificacao">
																<p><?php echo utf8_decode($faturas['descricao']);?></p>
																<p>R$<?php echo number_format($faturas['valor'], 2, ",", "."); ?></p>
																<p>Forma de pagamento: <?php echo $faturas['forma_pagamento']; ?></p>
																<p><?php echo utf8_decode("Data da geração:"); ?> <?php echo date("d/m/Y H:i:s", strtotime($faturas['data_geracao'])); ?></p>
															</div>
															<div class="status-time-text-qualificacao">
																<?php if(!(empty($faturas['observacao']))) { ?><?php echo utf8_decode("Descrição:"); ?> <?php echo utf8_decode($faturas['observacao']); ?><?php } ?>
															</div>
														</div>
														<?php } else if($faturas['status'] == "unpay") { ?>
														<div class="order-text-status">
															<div class="col-lg-3 icon-column pull-left">
																<div class="icon-background status-pending">
																	<i class="icon-remove"></i>
																</div>
															</div>
															<div class="status-title-qualificacao">
																<p><?php echo utf8_decode($faturas['descricao']);?></p>
																<p>R$<?php echo number_format($faturas['valor'], 2, ",", "."); ?></p>
																<p>Forma de pagamento: <?php echo $faturas['forma_pagamento']; ?></p>
																<p><?php echo utf8_decode("Data da geração:"); ?> <?php echo date("d/m/Y H:i:s", strtotime($faturas['data_geracao'])); ?></p>
															</div> 
															<div class="status-time-text-qualificacao">
																<?php if(!(empty($faturas['observacao']))) { ?><?php echo utf8_decode("Descrição:"); ?> <?php echo utf8_decode($faturas['observacao']); ?><?php } ?>
															</div>
															<?php if($faturas['forma_pagamento'] == "PagSeguro") { ?>
																<form id="pagseguro" name="pagseguro"  method="post" sid="<?php echo $team_id; ?>" action="https://pagseguro.uol.com.br/checkout/checkout.jhtml">
																	<input type="hidden" readonly="readonly" name="email_cobranca" value="<?php echo $INI["pagseguro"]["acc"]; ?>">
																	<input type="hidden" readonly="readonly" name="tipo" value="CP">
																	<input type="hidden" readonly="readonly" name="moeda" value="BRL">
																	<input type="hidden" readonly="readonly" id="ref_transacao" name="ref_transacao" value="Billing<?php echo  $faturas['id']; ?>">
																	<input type="hidden" readonly="readonly" id="reference" name="reference" value="Billing<?php echo  $faturas['id']; ?>">														 
																	<input type="hidden" readonly="readonly" id="item_id_1" name="item_id_1" value="<?php echo  $faturas['id']; ?>">
																	<input type="hidden" readonly="readonly" id="item_descr_1" name="item_descr_1" value="<?=utf8_decode(displaySubStringWithStrip($faturas['descricao'], 90)) ?>">
																	<input type="hidden" readonly="readonly" id="item_quant_1" name="item_quant_1" value="1">
																	<input type="hidden" readonly="readonly" id="item_valor_1" name="item_valor_1" value="<?php echo  number_format($faturas['valor'], 2, ',', '.');	 ?>">
																	<input type="hidden" readonly="readonly" name="item_peso_1" value="1"> 																 
																	<input type="hidden" readonly="readonly" name="item_frete_1" value=""> 
																	<input type="hidden" readonly="readonly" name="tipo_frete" value="">																	 
																	<input type="hidden" name="senderName" value="<?=$user['realname']?>">  
																	<input type="hidden" name="senderEmail" value="<?=$user['email']?>">																	   
																	<input type="hidden" name="shippingType" value="1">  
																	<input type="hidden" name="shippingAddressPostalCode" value="<?=$user['zipcode']?>">  
																	<input type="hidden" name="shippingAddressStreet" value="<?=$user['address']?>">      
																	<input type="hidden" name="shippingAddressDistrict" value="<?=$user['bairro']?>">  
																	<input type="hidden" name="shippingAddressCity" value="<?=$user['cidadeusuario']?>">  
																	<input type="hidden" name="shippingAddressState" value="<?=$user['estado']?>">  
																	<input type="hidden" name="shippingAddressCountry" value="BRA"> 
																	<!-- Dados do comprador (opcionais) -->    
																	<input type="hidden" name="senderPhone" value="<?=$login_user['mobile']?>">
																	<a href="#" onclick="J('#pagseguro').submit();" class="PayBilli"><img src="<?php echo $PATHSKIN; ?>/images/pay_billi.png" alt="Pagar Fatura" title="Pagar Fatura"></a>
																</form>		
															<?php } else { ?>
																<div class="status-time-text-qualificacao">
																	<?php echo $faturas['observacao']; ?>
																</div>															
															<?php } ?>
														</div>
														<?php } ?>
													</div>												 
												</div>
											</div> 
											<div class="order-item-divider"></div>
										<?php } else if($existe_registro == 0){?>
										<h4>Detalhes da fatura</h4>									
											<div data-order-id="18477617" class="order-list-item">
												<div class="row">
													<div class="col-lg-3 row order-list-status pull-left" style="width:659px;">													
														<p><img src="<?php echo $PATHSKIN; ?>/images/atention.png"> Não encontramos a fatura solicitada.</p>
													</div>												 
												</div>
											</div> 
												</div>
											<? } ?>  
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> 				
		</div>
<?php
	require_once(DIR_BLOCO."/rodape.php");
	require_once(DIR_BLOCO."/alterar_dados_minha_conta.php");
?>
	
</div>
</div>
</body>
</html>
