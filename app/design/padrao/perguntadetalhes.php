<?php  

require_once("include/head.php"); 
need_login();

$id = (int) strip_tags($_REQUEST['idpergunta']);
$questions = Table::Fetch('questions', $id);
  
?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 

<style>
	.questions-list-result {
	  margin-top: 1%;
	}
</style>

<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">

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
								<div class="question-list-items questions-list-result">
									<div data-question-id="18477617" class="wrapper-question-item md-2">									
										<?php 
											
											/* Bandeira responsável em permitir ou não que o usuário acesse a dúvida do cliente. */
											$FlagAnswer = 0;
											
											/* Neste ponto, é buscado algumas informações acerca da oferta que recebeu alguma pergunta. */
											$SqlProduct = "select title from team where id = " . $questions['id_produto'];
											$ExecProduct = mysql_query($SqlProduct);
											$ResultProduct = mysql_fetch_assoc($ExecProduct);
												
											/* Neste ponto é verificado se já existe resposta para a dúvida em questão. */
											$SqlAnswer = "select * from answer where id_questions = " . $questions['id'];
											$ExecAnswer = mysql_query($SqlAnswer);
											$ResultAnswer = mysql_num_rows($ExecAnswer);
												
											/* Bandeira recebe o valor 1 quando encontrado alguma resposta para a dúvida do cliente. */
											if($ResultAnswer >= 1) {
												$FlagAnswer = 1;
											}
										?> 
											<div data-question-id="18477617" class="answer-list-item">
												<div class="row">
													<div class="col-lg-3 row question-list-status pull-left" style="width:75%;">													
														<div class="question-text-status"> 
															<div class="question-status-title" > 
																<p></p>
															</div>
															<p><?php echo utf8_decode($questions['duvida']); ?></p>
															<p>Anúncio:<a href="<?php echo $ROOTPATH; ?>/index.php?idoferta=<?php echo $questions['id_produto']; ?>"><?php echo utf8_decode($ResultProduct['title']); ?></a></p>
															<p>Data: <?php echo data($questions['data']); ?></p>
															<?php if($FlagAnswer == 0) { ?>
															<p><img src="<?php echo $PATHSKIN; ?>/images/atention.png"> Seja gentil ao responder suas mensagens, responda com agilidade e lembre-se que não é permitido falar palavrão, usar termos ofensivos e trocar dados pessoais de qualquer tipo beleza?</p>
															<textarea name="RespostaVendedor" id="RespostaVendedor" rows="7"></textarea>
															<div style="width: 163px;">	
																<button id="btnEnviarAnswer" style="width:120px;text-transform:lowercase !important;" title="Enviar" data-tipo-anuncio="Usados" data-tipo-veiculo="Carro" data-id="11239890" class="buy-button btn btn-success">Responder</button>
															</div>
															<?php } else { ?>
															<br />
															<p><img src="<?php echo $PATHSKIN; ?>/images/atention.png"> Esta dúvida já foi respondida e enviada ao seu cliente.</p>
															<?php } ?>
														</div>
													</div>
												</div>													 												 
											</div>
										</div> 
										<div class="question-item-divider"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div> 				
		</div>
<?php if($FlagAnswer == 0) { ?>	
<script>

J('document').ready(function(){

	var id_answer = "<?php echo (int) strip_tags($_REQUEST['idpergunta']); ?>";
	
	J('#btnEnviarAnswer').click(function(){
		
		if(J("#RespostaVendedor").val() != "") {
			J.ajax({
				   type: "POST",
				   cache: false,
				   async: false,
				   url: "<?php echo $ROOTPATH; ?>/ajax/SubmitAnswer.php",
				   data: "acao=submit_answer&answer=" + J("#RespostaVendedor").val() + "&id_answer=" + id_answer,
				   success: function(retorno){ 
				   flag =  retorno.indexOf("Falha");
				 
					if(flag!=-1){ 
						alert("Erro ao enviar os dados! Por favor, tente novamente mais tarde.");				
					}
					else{ 
						location.href = "<?php echo $ROOTPATH; ?>/perguntas/enviadas";
						J.colorbox({html:" Dados enviados com sucesso!"});
					}			
				}
			});			
		} else {
			alert("Por favor, insira uma resposta válida.");
			return false;
		}		
	});
});

</script>
<?php } ?>
<?php
	require_once(DIR_BLOCO."/rodape.php");
	require_once(DIR_BLOCO."/alterar_dados_minha_conta.php");
?>
	
</div>
</div>
</body>
</html>
