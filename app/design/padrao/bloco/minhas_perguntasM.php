<style>
	@media only screen 
	and (max-width : 986px) {
		.status-time {
			margin-left: 0;
		}
	}
</style>
				<div class="titlePage">
					<p>Perguntas <?php echo $tipo; ?></p>
				</div>
				<div class="productsPage">
					<div class="order-list-items orders-list-result">
						<div class="wrapper-order-item md-2">
							<?php 
							
								/* � buscado todas as perguntas referentes ao usu�rio que se encontra logado. */
								$sql = "select * from questions where " . $query . " order by id DESC";
								$rs = mysql_query($sql);
							
								while($questionsM = mysql_fetch_assoc($rs)) { 
									
									/* Neste ponto � verificado se j� existe resposta para a d�vida em quest�o. */
									$SqlAnswer = "select * from answer where id_questions = " . $questionsM['id'];
									$ExecAnswer = mysql_query($SqlAnswer);		
									$ResultAnswer = mysql_num_rows($ExecAnswer);		
									$answer = mysql_fetch_assoc($ExecAnswer);	
							?>
							<div class="order-list-item">
								<div class="order-list-status">
									<div class="order-text-status">
										<div class="col-lg-3 icon-column pull-left">
											<div class="icon-background status-pending">
												<i class="icon-remove"></i>
											</div>
										</div>
										<div class="status-title italic">"<?php echo utf8_decode($questionsM['duvida']); ?>"</div> 
										<div class="status-time" style="margin:0;"> </div>
									</div>
								</div>
								<div class="order-middle-info">
									<div class="col-lg-6 order-list-info">
									<h2>Resposta do vendedor</h2>
									<div class="status-title ">
										<?php 
											if($ResultAnswer >= 1) {
												echo utf8_decode($answer['resposta']);
										 } else { ?>
											<?php if($tipo == "recebidas") { ?>
											Voc� ainda n�o respondeu .
											<?php } else { ?>
											O vendedor ainda n�o respondeu.
											<?php } ?>
										<?php } ?>
									</div>
									</div>
								</div>							
							</div>
							<?php } ?>							
						</div>
					</div>
					<?php					
						require_once(DIR_BLOCO."/rodapeM.php");
					?>	
				</div>	