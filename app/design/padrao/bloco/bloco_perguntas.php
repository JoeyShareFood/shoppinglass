<div style="display:none;" class="tips"><?=__FILE__?></div>
<?php

/* É feito uma busca sobre todas as dúvidas relativas ao produto atual. */
$sql = "select * from questions where id_produto = " . $team['id'] . " and status = 1 order by id ASC limit 0, 15";
$rs = mysql_query($sql);	
$total = mysql_num_rows($rs);

?>		
<section id="product-review" class="product-review" > 
	<h3 class="section-title">
		<div class="message-form">
			<form class="form-review" id="form-review">
				<input type="hidden" id="user_id"  name="user_id" value="<?=$_SESSION['user_id']?>">
				<input type="hidden" id="notaavaliacao"  name="notaavaliacao" value="0">
				<input type="hidden" id="team_id" name="team_id" value="<?=$team['id']?>">
				<input type="hidden" id="partner_id" name="partner_id" value="<?=$team['partner_id']?>">
					
				<!--<input name="title" type="text" class="title-review" id="title-question" placeholder="Digite aqui o título da sua dúvida...">-->
				<textarea name="text" class="comment-review" id="commentquestion_text_area" rows="4" placeholder="Faça a sua pergunta ao vendedor" maxlength="280"></textarea>
				<p id="contador_char"></p>
				<!--
				<input type="checkbox" id="check-email-review" class="check-email-review">
				 <label for="check-email-review" class="label-email-review">Autorizo a divulgação do meu e-mail junto à resenha no site</label>
				-->		  
			</form>
			<div class="button-container" style="width: auto; margin-top: -98px; float: right; margin-right: -125px;">
				<input type="button" onclick="javascript:validateFormQuestion();" value="enviar" class="btn btn-primary submit-review">
			</div>
		</div>		
		<div class="content-review clearfix">
			<ol>
				<?php
					while($RowQuestions = mysql_fetch_assoc($rs)){
					
						$Flag = 0;

						/* Apartir deste ponto, é verificado se existe resposta para o pergunta em questão. */
						$SqlAnswer = "select * from answer where id_questions = " . $RowQuestions['id'];
						$RsAnswer = mysql_query($SqlAnswer);
						$RowAnswer = mysql_fetch_assoc($RsAnswer);
						$retorno = mysql_num_rows($RsAnswer);
						
						/* Se existir alguma resposta para a pergunta, a bandeira recebe valor 1, e a resposta
						   é exibida ao usuário.
					   */
						/* Busca pelos dados do cliente que fez a pergunta. */
						if($retorno >= 1) {
							$Flag = 1;
						}
						
						/* Busca pelos dados do cliente que fez a pergunta. */
						$user = Table::Fetch('user', $RowQuestions['id_cliente']);
						
						$sqlI = "select logo from info where id_vendedor = " . $RowQuestions['id_cliente'];
						$rsI = mysql_query($sqlI);
						$rowI = mysql_fetch_assoc($rsI);
						
						$sqlIv = "select logo from info where id_vendedor = " . $RowQuestions['id_vendedor'];
						$rsIv = mysql_query($sqlIv);
						$rowIv = mysql_fetch_assoc($rsIv);
						
						$user_seller = Table::Fetch('user', $RowQuestions['id_vendedor']);

						$data =  $RowQuestions['data'];
				?>
				<li class="item-review clearfix">
					<div class="img-user-review">
						<?php
							if(!(empty($rowI['logo']))) {
						?>
						<img src="<?php echo $ROOTPATH; ?>/media/<?php echo $rowI['logo']; ?>" class="img-salesman">
						<?php } else { ?>
						<img src="<?php echo $PATHSKIN; ?>/images/profile.png" class="img-salesman">
						<?php } ?>
					</div>
					<div class="customer-review">
						<p class="description-customer-review" itemprop="description">
							<?=utf8_decode($RowQuestions['duvida'])?>
						</p>										
						<p class="Login" style="text-transform:captalize;">						
							<?php echo utf8_decode($user['realname']); ?> <span style="color:#999;">- <?php echo dateTime($RowQuestions['data']); ?></span>
						</p>
					</div>
				</li> 
				<li class="item-review clearfix">
					<?php if($Flag == 1) { ?>
					<div class="img-user-seller">
						<?php
							if(!(empty($rowIv['logo']))) {
						?>
						<img src="<?php echo $ROOTPATH; ?>/media/<?php echo $rowIv['logo']; ?>" class="img-salesman">
						<?php } ?>
					</div>
					<div class="AnswerSeller">
						<p>
							<?php echo utf8_decode($RowAnswer['resposta']); ?>
						</p>
						<p class="Login" style="text-transform:captalize;margin-left:2px;">						
							<?php echo utf8_decode($user_seller['realname']); ?> <span style="color:#999;">- <?php echo dateTime($RowAnswer['data']); ?></span>
						</p>
					</div>
					<?php } ?>
				</li>
				<? } ?>
			</ol>
		</div>
</section> 
<?php if($login_user){ ?>
<script>
	var productId;
	var ratingValue;
  
   function submitFormQuestion() {
   
		var component = j203("#question-post-modal");
		var showEmail = J("#check-email-review").is(":checked"),
		data = {
		productId: J("#team_id").val(),
		title: J("#title-question").val(),
		text: J("#commentquestion_text_area").val()
		},
		
		url = URLWEB+ "/include/funcoes.php?acao=question_product&team_id=" +  J("#team_id").val()+"&title=" +  J("#title-review").val() + "&text=" + J("#commentreview").val() + "&user_id=" + J("#user_id").val() + "&partner_id="+J("#partner_id").val();

		wm.utils.ajax({
		type: "POST",
		url: url,
		data: data,
		//dataType: "json",
		success: function() {
			alert("Sua mensagem foi enviada com sucesso!");
			location.href = "<?php echo UrlAtual(); ?>";
			component.find(".mfp-close").click();
		},
		error: function() {
			alert("Ocorreu um erro no envio de sua resenha! Favor tente mais tarde!");
		}
		});
}


 function validateFormQuestion() { 
	if (J("#commentquestion_text_area").val() != "") {
      submitFormQuestion();
    } else {
      alert("Preencha os campos para enviar os comentários", "150px");
    }
  }
</script>
<?php } ?>
<script src="<?php echo $ROOTPATH; ?>/js/jquery.limit.js/jquery.limit.js"></script>
<script type="text/javascript">
	J(function(){
		J('#commentquestion_text_area').limit('280','#contador_char');
		
		<?php
			if(empty($login_user_id)) {
		?>
		J('#commentquestion_text_area').focus(function(){
			J('#button-login').click();
		});
		<?php } ?>
	});
</script>