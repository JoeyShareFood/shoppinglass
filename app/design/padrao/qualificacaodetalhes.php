<?php  

	require_once("include/head.php"); 
	need_login();
	
	$existe_registro = 0;

	$IdQualification = (int) trim(strip_tags($_GET['idqualificacao']));

	if($IdQualification){ 
	 $condition = array( 
			'id' => $IdQualification, 
			'id_qualificado' => $login_user['id'],
		);
	}
	else{
		exit;
	}
	
	$sql = "select * from qualification where id = '" . $IdQualification . "' and id_qualificado = '" . $login_user['id'] . "'";
	$rs = mysql_query($sql);
	$qualification = mysql_fetch_assoc($rs);
	
	if(!(empty($qualification))) {
		$existe_registro = 1;
	}

	if($qualification['concretion'] == 1) {
		$Concretion = "Qualificação positiva";
	} 
	else if($qualification['concretion'] == 0) {
		$Concretion = "Qualificação negativa";
	} 
	else {
		$existe_registro = 0;
	}

?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 

<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">

<body id="page1" class="webstore home">
<div class="cabecalhosub"></div>
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
										<h4>Detalhes da qualificação</h4>									
											<div data-order-id="18477617" class="order-list-item">
												<div class="row">
													<div class="col-lg-3 row order-list-status pull-left" style="width:659px;">													
														<?php if($qualification['concretion'] == 1) { ?>
														<div class="order-text-status">
															<div class="col-lg-3 icon-column pull-left">
																<div class="icon-background status-done">
																	<i class="icon-remove"></i>
																</div>
															</div>
															<div class="status-title-qualificacao"><?php echo $Concretion;?></div> <div class="status-time-text-qualificacao"><?php echo utf8_decode($qualification['text']); ?></div>
														</div>
														<?php } else if($qualification['concretion'] == 0) { ?>
														<div class="order-text-status">
															<div class="col-lg-3 icon-column pull-left">
																<div class="icon-background status-pending">
																	<i class="icon-remove"></i>
																</div>
															</div>
															<div class="status-title-qualificacao"><?php echo $Concretion;?></div> <div class="status-time-text-qualificacao"><?php echo utf8_decode($qualification['text']); ?></div>
														</div>														
														<?php } ?>
													</div>												 
												</div>
											</div> 
											<div class="order-item-divider"></div>
										<?php } else if($existe_registro == 0){?>
										<h4>Detalhes da qualificação</h4>									
											<div data-order-id="18477617" class="order-list-item">
												<div class="row">
													<div class="col-lg-3 row order-list-status pull-left" style="width:659px;">													
														<p><img src="<?php echo $PATHSKIN; ?>/images/atention.png"> Não encontramos a qualificação solicitada.</p>
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
