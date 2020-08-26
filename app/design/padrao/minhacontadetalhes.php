<?php  
require_once("include/head.php"); 
need_login();
$order_id = $_REQUEST['idpedido'];
$order = Table::Fetch('order', $order_id ); 
$order_op = Table::Fetch('order', $order_id );  

if($order_id){ 
 $condition = array( 
	'order_id' => $order_id,   
	);
}
else{
	exit;
}
  
$count = Table::Count('order_team', $condition); 
$orders = DB::LimitQuery('order_team', array(
	 'condition' => $condition,
	 'order' => 'ORDER BY team_id DESC',
)); 
?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 

<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">
<style>
	.my-account-page .orders-list .wrapper-order-item .order-list-item {
		height: 325px;
		margin-top: 6%;
	}
</style>
<body id="page1" class="webstore home">
<div class="cabecalhosub"></div>
<div class="container">  
	<div class="page">
		<?php  require_once(DIR_BLOCO."/header.php"); ?>
			<div class="main-content clearfix"> 
				<div class="my-account-page" id="my-account-container">
					<div id="my-account-header">
						<?php  require_once(DIR_BLOCO."/my-account.php"); ?>
					</div>
				</div>
				
				<div class="my-account-page" id="VIPCOM_my-account-container"> 
				 <div id="my-account-header"> 
					 <div id="my-account-content" style="display: block;">
					 <div class="orders-list clearfix">  
						<div data-total-orders="6" class="order-list">
							<div class="row">
								<div class="order-list-items orders-list-result">
									<div data-order-id="18477617" class="wrapper-order-item md-2">
									
									<?php if(is_array($orders)){foreach($orders AS $index=>$order) { 
											
											$team = Table::Fetch('team', $order[team_id]);   
											$existe_registro = true;  
											 
										?> 
											<div data-order-id="18477617" class="order-list-item">
												<div class="row">
													<div class="col-lg-3 row order-list-status pull-left" style="width:659px;">
													
														<div class="order-text-status" style="margin-left: 88px;"> 
															<div class="status-title" > 
																<b>
																	<?=utf8_decode($team[title]);?>
																</b>
															</div> 
															<?php
																if(!(empty($order_op['id_option']))) {
															?>
															<div class="option-product">
																<?php
																	$options = Table::Fetch('options', $order_op['id_option']);
																?>
																<p style="color:#5C9E0D;margin-top:5px;font-size:14px;">
																	Tamanho: <?=$options['size'] ?>
																	<br />
																	Cor: <?=$options['color'] ?>
																</p>
															</div>
															<?php } ?>															
															<div class="status-time" style="line-height:27px;"><b>Quantidade:</b>  <?=$order[team_qty]?> 
															<? if($order[condbuy]){ echo "<br>".utf8_decode($order[condbuy]); } ?>
															<? if($order[condbuy2]){ echo " - ".utf8_decode($order[condbuy2]); } ?>
															
															</div>
														</div>
													</div>
													<div class="col-lg-6 order-middle-info pull-left" style="width:521px;margin-top:5px;">
															<span class="picture-thumb-container" style="margin-left:25px;"><img width="60" height="60" title="" alt="" src="<?php echo $ROOTPATH; ?>/media/<?php echo $team['image']; ?>" ></span> 
														<div class="col-lg-6 order-list-info" style="margin-top:20px;"><div class="status-title" style="margin-left:0px;">Total: <b>R$ <?=number_format($order[team_total], 2, ',', '.') ?> </b> </div>
															<div class="status-time"><? if($order[codreferencia]){?><b>Código:</b> <?=$order[codreferencia]; }?></div>
															<div style="font-size:12px;">
															<b>Endereço de Entrega:</b><br> <? getEnderecoEntregaPedidoAdmin( $order_id ,$order[user_id])?> 
															</div>
														</div> 
													 
													</div>
													 
													<div class="col-lg-3 order-list-links" style="width:590px;margin-top: -102px;height:250px;float: right;text-align: left !important;">
														<?php 				
															$order = Table::Fetch('order', $order_id );  
															if($order['state'] == "pay") { ?>
														<div class="order-text-status" style="margin-left: 88px;"> 
															<b>Status de pagamento:</b><br><br>
															<p>Confirmação de pagamento recebido.</p>
														</div>
														<?php } else { ?>
														<div class="order-text-status" style="margin-left: 88px;"> 
															<b>Status de pagamento:</b><br><br>
															<p>Aguardando pagamento.</p>
														</div>
														<?php } ?>
														<?php if(!(empty($order['codigorastreio']))) { ?>
														<div class="order-text-status" style="margin-left: 88px;margin-top:10px;"> 
															<br><b>Status de entrega:</b><br><br>
															<?php if(!(empty($order['modo_envio']))) { ?><p>Forma de envio: <?php echo $order['modo_envio']?></p><?php } ?>
															<?php if(!(empty($order['codigorastreio']))) { ?><p>Código de rastreio: <?php echo $order['codigorastreio']?></p><?php } ?>
														</div>
														<?php } else { ?>
														<div class="order-text-status" style="margin-left: 88px;"> 
															<br><b>Status de entrega:</b><br><br>
															<p>Aguardando envio do produto.</p>
														</div>														
													</div>
													<?php } ?> 
												</div>
											</div> 
											<div class="order-item-divider"></div>
										<?php }}?>

										<? if(!$existe_registro){?>
											
											<div data-order-id="18477617" class="order-list-item">
												<div class="row">
													<div class="col-lg-3 row order-list-status pull-left">
														<div class="order-text-status"> </div>
													</div>
													<div class="col-lg-6 order-middle-info pull-left">
														<div class="col-lg-6 order-list-info"> </div>
															<div class="status-time"><b> Nenhum item encontrado ! </b></div>
														</div> 
													</div>
													<div class="col-lg-3 order-list-links">
														<div class="table-cell"> </div>
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
