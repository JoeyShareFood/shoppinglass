<?php  
	
	require_once("include/head.php"); 
	need_login();
	
	$existe_registro = 0;

	if(isset($_GET["tipo"]) and !(empty($_GET["tipo"]))) {
		
		/* Caso o parâmetro via GET tenha sido enviado, o valor é recuperado
		   para verificar qual será a condição da busca.	
		*/
		$tipo = strip_tags(trim($_GET["tipo"]));
		
		if($tipo == "enviadas") {
			$condition = array( 
				'id_qualificante' => $login_user['id'], 	
			);		
		} 
		else {
			$condition = array( 
				'id_qualificado' => $login_user['id'], 	
			);			
		} 
	}
	else {
		$tipo = " enviadas";
		$condition = array( 
			'id_qualificante' => $login_user_id, 	
		);
	}
	
	/* É verificado o número de linhas retornadas ao executar a query. */
	$count = Table::Count('qualification', $condition); 
	
	if($count >= 1) {
		$existe_registro = 1;
	}
	
	/* Informações das qualificações são buscadas na base de dados. */
	$orders = DB::LimitQuery('qualification', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
	)); 
	
	$ordersM = $orders;
?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 

<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">

<style>
@media only screen 
and (max-width : 986px) {
	.status-time {
		margin-left: 0;
	}
}
</style>

<body id="page1" class="webstore home">
<div class="cabecalhosub"></div>
<?php	if(detectResolution()) {?>
<!-- Responsivo -->
<div class="containerM">
	<? require_once(DIR_BLOCO."/headerM.php"); ?>
	<div class="row">
		<div class="productsPage">
		<?php
			require_once(DIR_BLOCO."/minhas_qualificoesM.php");
		?>	
		</div>				
	</div>
</div>
<?php } ?>	
<div class="container">  
	<div class="page">
		<?php  require_once(DIR_BLOCO."/header.php"); ?>
			<div class="main-content clearfix"> 
				<div class="my-account-page" id="my-account-container">
					<div id="my-account-header">
						<?php  require_once(DIR_BLOCO."/my-account.php"); ?>
					</div>
				</div>
			
			 <div class="my-account-page" id="vipcom-bruno-my-account-container"> 
				 <div id="my-account-header">
					 <div id="my-account-content" style="display: block;">
					 <div class="orders-list clearfix">
					 <h3 class="title">Você tem <span class="highlight"><?=$count?></span> pedidos ;)</h3>
					 
						<form action="/index.php?page=minhaconta" method='POST'>
							 <div class="options-row row form">
							 	<h2>Qualificações <?php echo $tipo; ?></h2>
							</div> 
						</form> 
						<div data-total-orders="6" class="order-list">
							<div class="row">
								<div class="order-list-items orders-list-result">
									<div data-order-id="18477617" class="wrapper-order-item md-2">
									
									<?php if(is_array($orders)){foreach($orders AS $index=>$one) { 	
											
											$QualificacaoVendedor = 0;
											
											/* É buscado a ID do parceiro que cadastrou a oferta da página atual. */
											$sql = "select * from `order` where id = " . $one['id_order'];
											$rs = mysql_query($sql);
											$row = mysql_fetch_assoc($rs);
											
											/* É buscado o ID da oferta relativo ao pedido. */
											$sql = "select team_id from order_team where order_id = " . $one['id_order'];
											$rsT = mysql_query($sql);
											$team = mysql_fetch_assoc($rsT);
											
											/* É verificado se determinada negociação, já foi qualificada pelo o outro usuário
											   participante da venda do produto. Este processo é feito apenas quando listado as
											   qualificações recebidas.
											*/
											if($tipo == "recebidas") {
												$sqlQ = "select count(*) from `qualification` where id_order = " . $one['id_order'];
												$rsQ = mysql_query($sqlQ);
												$dados = mysql_fetch_assoc($rsQ);
												
												/* Caso haja algum retorno, o formulário para qualificar o comprador é habilitado. */
												if($dados['count(*)'] == 1) {
													$QualificacaoVendedor = 1;
													$IdUser = $one['id_qualificante'];
												}
												else {
													$QualificacaoVendedor = 0;
													$IdUser = $one['id_qualificado'];													
												}
											}
											
											$user = Table::Fetch('user', $row['user_id']);
											$seller = Table::Fetch('user', $row['partner_id']);
											 
										?> 
											<div data-order-id="18477617" class="order-list-item">
												<div class="row">
													<?php if($tipo == "enviadas") { ?>
													<div class="col-lg-6 order-middle-info pull-left">
														<div class="col-lg-6 order-list-info">
															<p>Vendedor</p>
															<img src="<?php echo $PATHSKIN; ?>/images/store.png">
															<?php echo utf8_decode($seller['login']); ?>
															<br /><br />
															<p>Acesse a <a target="_blank" href="<?php echo $ROOTPATH; ?>/store/<?php echo $seller['id']; ?>/<?php echo $seller['login'];?>"> loja </a> deste vendedor</p>
														</div> 
													</div> 
													<?php } else if($tipo == "recebidas") { ?>
													<div class="col-lg-6 order-middle-info pull-left">
														<div class="col-lg-6 order-list-info">
															<p>Cliente</p>
															<?php echo $user['realname']; ?>
															<br />
															<?php echo $user['login']; ?>
															<br />
														</div> 
													</div> 
													<?php } ?>
													<div class="col-lg-6 order-middle-info pull-left">
														<div class="col-lg-6 order-list-info">
														<div class="status-title">Nº do Pedido: <b><?=$row[id]?></b> </div>
															<div class="status-time">Realizado em: <?=data($row[datapedido])?></div>
															<div class="status-title">Valor do pedido: <b>R$ <?=number_format($row[origin], 2, ',', '.') ?> </b> </div>
															<div class="status-time">Frete: <B>R$ <?=number_format($row[valorfrete], 2, ',', '.') ?></B></div>
														</div>
														<!-- 
														<div class="col-lg-6 order-list-products">
															<ul class="product-list">
																<li><a href="#order/id/18477617"><span class="picture-thumb-container"><img width="60" height="60" title="" alt="" src="//static.wmobjects.com.br/imgres/arquivos/ids/2526999-60-60"></span></a></li>
															</ul>
														</div>
														-->
													</div>
													<div class="col-lg-3 row order-list-status pull-left">
														<div class="order-text-status">
															<?php if($one['concretion'] == 1){?>
																<div class="col-lg-3 icon-column pull-left">
																	<div class="icon-background status-done">
																		<i class="icon-remove"></i>
																	</div>
																</div>
																<div class="status-title" style="margin-left:156px !important;"> Qualificação positiva </div> 
																<div class="status-time-text" style="text-align:center;margin-left:85px;">
																	<?php echo utf8_decode($one["text"]); ?>
																</div>
															<? }
															else if($one['concretion'] == 0){?>
																<div class="col-lg-3 icon-column pull-left">
																	<div class="icon-background status-pending">
																		<i class="icon-remove"></i>
																	</div>
																</div>
																<div class="status-title" style="margin-left:156px !important;"> Qualificação negativa </div> <div class="status-time-text" style="text-align:center;margin-left:85px;"><?php echo utf8_decode($one["text"]); ?></div>
															<? } ?>
														</div>
													</div>
													
													<div class="col-lg-3 order-list-links">
														<div class="table-cell"> 
														<a href="<?=$ROOTPATH?>/index.php?page=qualificacaodetalhes&idqualificacao=<?=$one[id]?>"><img alt="Visualizar detalhes da qualificação" title="Visualizar detalhes da qualificação" src="<?=$PATHSKIN?>/images/lupa.png" style="margin-left:100px;"></a>  
														<?php if($QualificacaoVendedor == 1 && $seller['id'] != $login_user['id']) { ?><a onclick="InfoQualificacao(<?php echo $team['team_id']; ?>,<?php echo $IdUser; ?>,<?php echo $row['id']; ?>);" class="write-review wm-lightbox " href="#question-post-modal" id="#" href="#"><img alt="Qualificar vendedor" title="Qualificar vendedor" src="<?=$PATHSKIN?>/images/free-partner.png"></a><?php } ?>
														</div>
													</div>
												</div>
											</div> 
											<div class="order-item-divider"></div>
										<?php }}?>

										<? if(!$existe_registro){?>
											
											<div data-order-id="18477617" class="order-list-item">
												<div class="row">
													<p style="text-align:center; margin-top:20px;"> Nenhuma qualificação encontrada! </p>
												</div>
												<div class="col-lg-3 order-list-links">
													<div class="table-cell"> </div>
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
	<footer>
		<div class="review-post">
			<div id="question-post-modal" class="review-post-modal mfp-hide">
				<h4 class="section-title">Qualificação</h4>
					<div class="rating-review">
					<p>Escolha a nota: </p>
					<div class="slider-rating">
						<ul class="range-label clearfix">
							<li class="label-item text"></li>
							<li class="label-item">1</li>
							<li class="label-item">2</li>
							<li class="label-item">3</li>
							<li class="label-item">4</li>
							<li class="label-item last-item">5</li>
						</ul>
						<div class="slider-range noUiSlider horizontal connect">
							<a style="left: 0%;">
							</a>
							<input type="hidden" id="notaavaliacao"  name="notaavaliacao" >
						</div>
						<div class="small-chart">
							<div class="rating small average-0 average-undefined">
								<div class="arc-mask-divisor">
									<span></span>
								</div>
								<div class="arc-mask left">
									<div class="arc-shape"></div>
								</div>
								<div class="arc-mask right">
									<div class="arc-shape"></div>
								</div>
								<div class="arc-bg"></div>
								<div class="arc-content">
									<span class="arc-content-title">Nota</span>
									<span class="arc-content-value">1</span>
									<span class="arc-content-no-rate">Sem Nota</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ccps" style="margin-left: 102px;">				
					<input type="hidden" id="user_id"  name="user_id" value="<?=$_SESSION['user_id']?>">
					<input type="hidden" id="team_id" name="team_id">			
					<input type="hidden" id="order_id" name="order_id">
					<input type="hidden" id="partner_id" name="partner_id">
						  
					<form class="form-review" id="form-review">
						<input name="title" type="text" class="title-review" id="title-question" placeholder="Digite aqui o título da sua qualificação..."> <br><br><br>
						<input type="radio" class="concretion-review" name="concretion" id="concretion" value="1"> <p>A negociação ocorreu sem problemas</p> <br><br>
						<input type="radio" class="concretion-review" name="concretion" id="concretion" value="0"> <p>Ouve problemas na negociação com o cliente</p> <br><br>
						<textarea name="text" class="comment-review" id="commentquestion" rows="4" placeholder="Digite aqui seu comentário..."></textarea> 
					   <div class="button-container" style="width:403px;"><input type="button" onclick="javascript:validateFormQuestion();" value="Qualificar" class="btn btn-primary submit-review"></div>
					 </form>
				</div>
				<div class="review-footer">
					<p>
						Este é um espaço destinado a perguntas sobre os produtos. Não publicaremos termos ofensivos ou de baixo calão.
					</p>
				</div>
			</div>  
		</div>
	</footer>
<?php
	require_once(DIR_BLOCO."/rodape.php");
	require_once(DIR_BLOCO."/alterar_dados_minha_conta.php");
?>

<script>
	var productId;
	var ratingValue;
	var IdProduto, IdVendedor;
	
	function InfoQualificacao(IdProduto, IdVendedor, IdOrder) {
		
		var id = J(this).attr('id');
		
		J("#team_id").val(IdProduto);
		J("#partner_id").val(IdVendedor);
		J("#order_id").val(IdOrder);
		return false;
	}
  
   function submitFormQuestion() {
		
		var component = j203("#question-post-modal");
		var showEmail = J("#check-email-review").is(":checked"),
		data = {
		productId: J("#team_id").val(),
		title: J("#title-question").val(),
		text: J("#commentquestion").val(),
		seller: J("#partner_id").val(),
		concretion: J("input[name=concretion]:checked").val(),
		comment: J("#commentreview").val(),
		user: J("#user_id").val(),		
		orderId: J("#order_id").val(),		
		nota: J("#notaavaliacao").val(),
		},
		
		url = URLWEB+ "/include/funcoes.php?acao=qualification_order&nota="+J("#notaavaliacao").val()+"&orderId="+J("#order_id").val()+"&team_id=" +  J("#team_id").val()+"&concretion="+J("#concretion").val()+"&title=" +  J("#title-review").val() + "&text=" + J("#commentreview").val() + "&user_id=" + J("#user_id").val() + "&partner_id="+J("#partner_id").val();

		wm.utils.ajax({
		type: "POST",
		url: url,
		data: data,
		//dataType: "json",
		success: function() {
			alert("Qualificação postada com sucesso!");
			component.find(".mfp-close").click();
			location.reload();
		},
		error: function() {
			alert("Ocorreu um erro no envio de sua resenha! Favor tente mais tarde!");
			location.reload();
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
	
</div>
</div>
</body>
</html>
