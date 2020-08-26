<?php  
	
	require_once("include/head.php"); 
	need_login();
	
	
	$existe_registro = 0;
 
	/* É buscado todas as perguntas referentes ao usuário que se encontra logado. */
	$sql = "select * from faturas where id_user = '" . $login_user['id'] . "' order by data_geracao DESC";
	$rs = mysql_query($sql);
?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">
<style>
.questions-list-result {
  margin-top: -3%;
}
</style>
<body id="page1" class="webstore home">
<div class="container">  
	<div class="page">
		<?php  require_once(DIR_BLOCO."/header.php"); ?>		
			<div class="main-content clearfix"> 
				<div class="my-account-page" id="VIPCOM_my-account-container">
				 <div id="my-account-header"> 
					 <div id="my-account-content" style="display: block;">
					 <div class="questions-list clearfix" style="margin-top:5%;"> 
						<div data-total-questions="6" class="question-list">
							<div class="row">
								<div class="question-list-items questions-list-result">
									<h2><?php echo utf8_decode("Minhas faturas"); ?></h2>
									<div data-question-id="18477617" class="wrapper-question-item md-2">					
									<?php 
											/* É efetuado um loop imprimindo as dúvidas que o usuário recebeu acerca dos produtos. */
											while($billi = mysql_fetch_assoc($rs)) { 
											
											$data = date("d/m/Y H:i:s", strtotime($billi['data_geracao']));
											
											if($billi['status'] == "pay") {
												$status = utf8_decode("Pago");
												$color = "blue";
											}
											else if($billi['status'] == "unpay") {
												$status = utf8_decode("Não pago");
												$color = "red";
											}
											else if($billi['status'] == "cancelled") {
												$status = utf8_decode("Cancelado");
												$color = "orange";
											}
											
											if($billi['forma_pagamento'] == "PagSeguro") {
												$pagamento = utf8_decode("PagSeguro");
											}
											else if($billi['forma_pagamento'] == "Transferencia") {
												$pagamento = utf8_decode("Transferência ou depósito bancário");
											}
									?> 
											<div data-question-id="18477617" class="question-list-item">
												<div class="row">
													<div class="col-lg-3 row question-list-status pull-left" style="width:75%;">
														<div class="icon-background status-pending">
															<i class="icon-remove"></i>
														</div>													
														<div class="question-text-status"> 
															<div class="bill-status-title" > 
																<p><?php echo utf8_decode($billi['descricao']); ?></p>	
															</div>	
															<p><?php echo utf8_decode("Status: ");?><span style="color:<?php echo $color; ?>;"><?php echo $status; ?></span></p>
															<p><?php echo utf8_decode("Valor: "); ?> R$ <?php echo number_format($billi['valor'], 2, ",", "."); ?></p>
															<p><?php echo utf8_decode("Forma de pagamento: "); ?> <?php echo $pagamento; ?></p>
															<p class="Login">
																<?php echo utf8_decode("Data de geração: "); ?> <?php echo $data; ?>
															</p>
														</div>
													</div>
													<div class="col-lg-3 order-list-links">
														<div class="table-cell-questions"> 
														<?php if($billi['status'] == "unpay") { ?>
														<a href="<?=$ROOTPATH?>/index.php?page=billing&idbilli=<?=$billi['id']?>"><img src="<?=$PATHSKIN?>/images/lupa.png"></a> 
														<?php } else if($billi['status'] == "pay") {?>
														<img src="<?=$PATHSKIN?>/images/correct.png" alt="Fatura paga" title="Fatura paga">
														<?php } else if($billi['status'] == "cancelled") { ?>
														<img src="<?=$PATHSKIN?>/images/cancelled.png" alt="Fatura cancelada" title="Fatura cancelada">
														<?php } ?>
														</div>
													</div>
													</div>										 												 
												</div>
											</div>											
											<div class="question-item-divider"></div>
										<?php } ?>
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
