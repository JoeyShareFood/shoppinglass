<?php  
	require_once("include/head.php"); 
	need_login();
	 if($_POST[order_id]){ 
		 $condition = array( 
			'id' => $_POST[order_id],  
			'user_id' => $login_user_id,  
		);
	 }
	 else{
		$condition = array( 
			'user_id' => $login_user_id,  
		);
	}
		
	$count = Table::Count('order', $condition); 
	$orders = DB::LimitQuery('order', array(
		 'condition' => $condition,
		'order' => 'ORDER BY id DESC',
	)); 
	
	$ordersM = $orders;
?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 

<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">

<style>
.my-account-page p {
  margin: 0;
}
</style>
<?php require_once("include/code/vendedor.php"); ?>
<body id="page1" class="webstore home">

	<!-- Responsivo -->
	<div class="containerM">
		<? require_once(DIR_BLOCO."/headerM.php"); ?>
		<div class="row">
			<? require_once(DIR_BLOCO."/minhas_comprasM.php"); ?>
		</div>
	</div>

<div class="container">
<style>
@media only screen 
and (max-width : 986px) {
	.status-time {
		margin-left: 0;
	}
}  
</style>
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
					 <h3 class="title">Você tem <span class="highlight"><?=$count?></span> pedidos feitos ;)</h3>
					 
						<form action="/index.php?page=minhaconta" method='POST'>
							 <div class="options-row row form">
							 	<h2>Minhas Compras</h2>
								<div class="search-order-id"> 
									<div class="form-control">
										<input name="order_id" value="<?=$_POST[order_id]?>" type="text" placeholder="Informe o número do pedido..." class="search-order-input"><div class="search-div-icon"><i class="icon-search"></i></div>
									</div>
								</div>
							</div> 
						</form> 
						<div data-total-orders="6" class="order-list">
							<div class="row">
								<div class="order-list-items orders-list-result">
									<div data-order-id="18477617" class="wrapper-order-item md-2">
									
									<?php if(is_array($orders)){foreach($orders AS $index=>$one) { 
											
											$teams = Table::Fetch('order_team', $one[id],'order_id'); // busca apenas um produto para servir como thumb
											$team = Table::Fetch('team', $teams[team_id]);   
											$existe_registro = true; 
											
											/* É buscado a ID do parceiro que cadastrou a oferta da página atual. */
											$sql = "select partner_id from `order` where id = " . $one[id];
											$rs = mysql_query($sql);
											$row = mysql_fetch_assoc($rs);

											/* É buscado algumas informações acerca do parceiro. */
											$sql = "select * from user where id = " . $row['partner_id'];
											$rs = mysql_query($sql);
											$partner = mysql_fetch_assoc($rs); 																																	$sql_logo = "select logo from info where id_vendedor = " . $row['partner_id'];																						$rs_logo = mysql_query($sql_logo);																						$row_logo = mysql_fetch_assoc($rs_logo);
											
											/* É verificado se o cliente já qualificou determinado negociação que efetuou no site. */
											$sql = "select count(*) from qualification where id_qualificante = " . $login_user['id'] . " and id_produto = " . $team['id'] . " and id_order = " . $one['id'];
											$rs = mysql_query($sql);
											$qualificacoes = mysql_fetch_assoc($rs);
											 
										?> 
											<div data-order-id="18477617" class="order-list-item">
												<div class="row">
													<div class="col-lg-3 row order-list-status pull-left">
														<div class="order-text-status">
															<? if($one[statuspedido]=="cancelado"){?>
																<div class="col-lg-3 icon-column pull-left">
																	<div class="icon-background status-canceled">
																		<i class="icon-remove"></i>
																	</div>
																</div>
																<div class="status-title"> Pedido cancelado </div> <div class="status-time">Em:  <?=data($one[datacancelamento])?>  </div>
															<? }  
															else if($one[statusentrega]=="Pedido entregue"){?>
																<div class="col-lg-3 icon-column pull-left">
																	<div class="icon-background status-working">
																		<i class="icon-remove"></i>
																	</div>
																</div>
																<div class="status-title"> Entregue </div> <div class="status-time">Em:  <?=data($one[dataentrega])?>
																<? if($one[codigorastreio] !=""){?><BR><B>Cód. Rastreio:</B> <?=$one[codigorastreio]; }?>
																</div>
															<? }  
															else if($one[statusentrega]!=""){?>
																<div class="col-lg-3 icon-column pull-left">
																	<div class="icon-background status-error">
																		<i class="icon-remove"></i>
																	</div>
																</div>
																<div class="status-title"> <?=utf8_decode($one[statusentrega])?> </div> <div class="status-time">Em:  <?=data($one[data_ultima_atualizacao])?></div>
															<? } 
															else if($one[state]=="pay"){?>
																<div class="col-lg-3 icon-column pull-left">
																	<div class="icon-background status-done">
																		<i class="icon-remove"></i>
																	</div>
																</div>
																<div class="status-title"> Pedido Pago </div> <div class="status-time">Em:  <?=data($one[datapagamento])?></div>
															<? }
															else if($one[state]=="unpay"){?>
																<div class="col-lg-3 icon-column pull-left">
																	<div class="icon-background status-pending">
																		<i class="icon-remove"></i>
																	</div>
																</div>
																<div class="status-title"> Aguardando pagamento </div> <div class="status-time"> </div>
															<? } ?>
														</div>
													</div>
													<div class="col-lg-6 order-middle-info pull-left">
														<div class="col-lg-6 order-list-info">
														<div class="status-title">Nº do Pedido: <b><?=$one[id]?></b> </div>
															<div class="status-time">Realizado em: <?=data($one[datapedido])?></div>
															<div class="status-title">Valor do pedido: <b>R$ <?=number_format($one[origin], 2, ',', '.') ?> </b> </div>
															<div class="status-time">Frete: <B>R$ <?=number_format($one[valorfrete], 2, ',', '.') ?></B></div>
														</div>
														<!-- 
														<div class="col-lg-6 order-list-products">
															<ul class="product-list">
																<li><a href="#order/id/18477617"><span class="picture-thumb-container"><img width="60" height="60" title="" alt="" src="//static.wmobjects.com.br/imgres/arquivos/ids/2526999-60-60"></span></a></li>
															</ul>
														</div>
														-->
													</div>
													<div class="col-lg-6 order-middle-info pull-left">
														<div class="col-lg-6 order-list-info" style="float:left;width:131px;">
															<p style="font-size: 11px;">Vendido por</p>
															<a  href="<?php echo $ROOTPATH; ?>/store/<?php echo $partner['id']; ?>/<?php echo $partner['login'];?>">																<?php																	if(empty($row_logo['logo'])) {																?>																<img src="<?php echo $PATHSKIN; ?>/images/store.png">																<?php } else { ?>																<img src="<?php echo $ROOTPATH;?>/media/<?php echo $row_logo['logo']; ?>" style="border-radius:50%;max-height: 50px;overflow:hidden;"> 																<?php } ?>															</a>
															<div style="font-size: 11px;"><?php echo utf8_decode($partner['login']); ?></div>
														 </div> 
														 <div>
														 <a style="font-size: 13px;" href="<?php echo $ROOTPATH; ?>/store/<?php echo $partner['id']; ?>/<?php echo $partner['login'];?>">ver mais produtos deste vendedor </a>
														 </div>
													</div> 
													
													<div class="col-lg-3 order-list-links">
														<div class="table-cell"> 
														<a href="<?=$ROOTPATH?>/index.php?page=minhacontadetalhes&idpedido=<?=$one[id]?>"><img alt="Visualizar detalhes do pedido" title="Visualizar detalhes do pedido" src="<?=$PATHSKIN?>/images/lupa.png"></a>  
														<!--<? if($one[state]=="unpay" and $one[statuspedido]!="cancelado"){?><a href="<?=$ROOTPATH?>/index.php?page=minhacontapagar&idpedido=<?=$one[id]?>"><img alt="Pagar pedido" title="Pagar pedido" src="<?=$PATHSKIN?>/images/pay.png"></a>  <? }?>-->
														<? if($one[statuspedido]!="cancelado" and $qualificacoes['count(*)'] <= 0){?><a onclick="InfoQualificacao(<?php echo $teams['team_id']; ?>,<?php echo $partner['id']; ?>,<?php echo $one['id']; ?>);" class="write-review wm-lightbox " href="#question-post-modal" id="#" href="#"><img alt="Qualificar vendedor" title="Qualificar vendedor" src="<?=$PATHSKIN?>/images/free-partner.png"></a>  <? }?>
														</div>
													</div>
												</div>
											</div> 
											<div class="order-item-divider"></div>
										<?php }}?>

										<? if(!$existe_registro){?>
											<p><b> Nenhum pedido encontrado ! </b></p> 
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
				<h4 class="section-title">Recebeu seu produto? Qualifique e pontue agora mesmo!</h4>
					<div class="rating-review">
					<p>Dê sua nota ao vendedor: </p>
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
						<input type="radio" class="concretion-review" name="concretion" id="concretion" value="1"> <p>Recebi o produto corretamente</p> <br><br>
						<input type="radio" class="concretion-review" name="concretion" id="concretion" value="0"> <p>Não recebi o produto corretamente</p> <br><br>
						<textarea name="text" class="comment-review" id="commentquestion" rows="4" placeholder="Escreva aqui o seu depoimento..."></textarea> 
					   <div class="button-container" style="width:403px;"><input type="button" onclick="javascript:validateFormQuestion();" value="Qualificar vendedor" class="btn btn-primary submit-review"></div>
					 </form>
				</div>
				<div class="review-footer">
					<p>
						Esta mensagem é PÚBLICA e será exibida no site. Não publicaremos termos ofensivos ou de baixo calão.
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
