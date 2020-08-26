<div style="display:none;" class="tips"><?=__FILE__?></div> 
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">
<style>
	.questions-list-result {
		margin-top: -3%;
	}
	.link-list.list-right {
		margin-top: -31% !important;
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
									<h2>Perguntas <?php echo $tipo; ?></h2>
									<div data-question-id="18477617" class="wrapper-question-item md-2">					
									<?php 
 
										/* É buscado todas as perguntas referentes ao usuário que se encontra logado. */
										$sql = "select * from questions where " . $query . " and status = 1 order by id DESC";
										$rs = mysql_query($sql);
										
										/* É efetuado um loop imprimindo as dúvidas que o usuário recebeu acerca dos produtos. */
										while($questions = mysql_fetch_assoc($rs)) { 
											/* Bandeira responsável em permitir ou não que o usuário acesse a dúvida do cliente. */
											$FlagAnswer = 0;	
											
											/* Neste ponto, é buscado algumas informações acerca da oferta que recebeu alguma pergunta. */
											$SqlProduct = "select title from team where id = " . $questions['id_produto'];
											$ExecProduct = mysql_query($SqlProduct);
											$ResultProduct = mysql_fetch_assoc($ExecProduct);	
											
											/* Neste ponto é verificado se já existe resposta para a dúvida em questão. */
											$SqlAnswer = "select * from answer where id_questions = " . $questions['id'] . " and status = 1";
											$ExecAnswer = mysql_query($SqlAnswer);		
											$ResultAnswer = mysql_num_rows($ExecAnswer);		
											$answer = mysql_fetch_assoc($ExecAnswer);	
											
											/* É feito uma busca no banco de dados para buscar algumas informações do usuário. */
											$user = Table::Fetch('user', $questions['id_cliente']);
											$data = date("d/m/Y H:i:s", strtotime($questions['data']));
											
											/* Bandeira recebe o valor 1 quando encontrado alguma resposta para a dúvida do cliente. */
											if($ResultAnswer >= 1) {
												$FlagAnswer = 1;
											}
									?> 
											<div data-question-id="18477617" class="question-list-item">
												<div class="row">
													<div class="col-lg-3 row question-list-status pull-left" style="width:75%;">			
														<div class="question-text-status"> 
															<div class="question-status-title" > 
																<p></p>	
															</div>
															<p><?php echo utf8_decode($questions['duvida']); ?></p>	
															<?php if($FlagAnswer == 1) { ?>
															<div class="AnswerClass">			
																<p class="AnswerQuestion"><?php echo utf8_decode($answer['resposta']); ?></p>
															</div>	
															<?php } ?>															
															<p><?php echo utf8_decode("Anúncio: "); ?> <a href="<?php echo $ROOTPATH; ?>/index.php?idoferta=<?php echo $questions['id_produto']; ?>"><?php echo utf8_decode($ResultProduct['title']); ?></a></p>
															<p class="Login">
																<span style="color:#F77274;"><?php echo empty($user['realname']) ? "-" : utf8_decode($user['realname']); ?></span> - <?php echo $data; ?>
															</p>
														</div>
													</div>
														<div class="col-lg-3 order-list-links">
															<div class="table-cell-questions"> 
															<?php if($FlagAnswer == 0 and $tipo == "recebidas") { ?>
															<a class="btn btn-primary write-review" href="<?=$ROOTPATH?>/index.php?page=perguntadetalhes&idpergunta=<?=$questions['id']?>">
																Responder
															</a> 
															<?php } else if($FlagAnswer == 1) {?>
															<img src="<?=$PATHSKIN?>/images/correct.png">
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
