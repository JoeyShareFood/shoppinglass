<div style="display:none;" class="tips"><?=__FILE__?></div>
<?php

/* É feito uma busca sobre todas as dúvidas relativas ao produto atual. */
$sql = "select * from questions where id_produto = " . $team['id'] . " order by id ASC limit 0, 15";
$rs = mysql_query($sql);	
$total = mysql_num_rows($rs);

?>		
<style>
.product-review {
	padding-top: 0;
	top: 0px;
	position: relative;
}
</style>
<section id="product-review" class="product-review" style="margin-top:-15px;"> 
	<p style="display:none;">Se você realizou alguma pergunta recentemente, por favor, aguarde a resposta do vendedor.</p>
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
					if($retorno >= 1) {
						$Flag = 1;						
					}
					
					/* Busca pelos dados do cliente que fez a pergunta. */
					$user = Table::Fetch('user', $RowQuestions['id_cliente']);
					
					$data =  $RowQuestions['data'];
			?>
			<li class="item-review clearfix">
				<div class="customer-review">
					<strong class="title-customer-review" itemprop="author">"<?=utf8_decode($RowQuestions['titulo'])?>"</strong>
					<p class="description-customer-review" itemprop="description">"<?=utf8_decode($RowQuestions['duvida'])?>"</p>
					<?php if($Flag == 1) { ?>
					<div class="AnswerSeller">
						<p>
							<?php echo utf8_decode($RowAnswer['resposta']); ?>
						</p>
					</div>
					<?php } ?>
					<p class="Login">
						<?php echo $user['login']; ?> - <?php echo datahora($data); ?>
					</p>
				</div>
			</li> 
			<? } ?>
		</ol>
	</div>
	<footer>
		<?php if($login_user) { ?>
		<div class="review-post">
			<div id="question-post-modal" class="review-post-modal">
				<h2>Quer saber mais sobre esse produto?</h2>
				<div class="ccps">				
					<input type="hidden" id="user_id"  name="user_id" value="<?=$_SESSION['user_id']?>">
					<input type="hidden" id="notaavaliacao"  name="notaavaliacao" value="0">
					<input type="hidden" id="team_id" name="team_id" value="<?=$team['id']?>">
					<input type="hidden" id="partner_id" name="partner_id" value="<?=$team['partner_id']?>">			  
					<form class="form-review" id="form-review">
						<input name="title" type="text" class="title-review" id="title-question" placeholder="Digite aqui o título da sua dúvida..." style="display:none;" value="Titulo">
						<textarea name="text" class="comment-review" id="commentquestion" rows="4" placeholder="Faça sua pergunta ao vendedor"></textarea> 
					   <div class="button-container" style="width:95%"><input type="button" onclick="javascript:validateFormQuestion();" value="Enviar" class="btn btn-primary submit-review" style="text-transform:lowercase;"></div>
					</form>
				</div>
			</div>  
		</div>
		<?php } else { ?>
			<h2>Quer saber mais sobre esse produto?</h2>
			<p>Clique <a href="<?php echo $ROOTPATH; ?>/mlogin">aqui</a> para efetuar o login e enviar sua dúvida para o vendedor.</p>
		<?php } ?>
	</footer>
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
			text: J("#commentquestion").val()
		},
		
		url = URLWEB+ "/include/funcoes.php?acao=question_product&team_id=" +  J("#team_id").val()+"&title=" +  J("#title-review").val() + "&text=" + J("#commentreview").val() + "&user_id=" + J("#user_id").val() + "&partner_id="+J("#partner_id").val();

		wm.utils.ajax({
		type: "POST",
		url: url,
		data: data,
		//dataType: "json",
		success: function() {
			alert("Dúvida enviada com sucesso");
			location.href = "<?php echo $ROOTPATH; ?>/produto/<?php echo $team['id']; ?>";
		},
		error: function() {
			alert("Ocorreu um erro no envio de sua resenha! Favor tente mais tarde!");
		}
	});
}


 function validateFormQuestion() { 
    if ( J("#title-question").val() !== "" && J("#commentquestion").val() !== "") {
      submitFormQuestion();
    } else {
      alert("Preencha os campos para enviar os comentários", "150px");
    }
  }
</script>
<?php } ?>