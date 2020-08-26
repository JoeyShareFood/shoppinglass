<?php include template("manage_header"); ?>
<link rel="stylesheet" href="/media/css/template.css" />
<div id="bdw" class="bdw">
	<div id="bd" class="cf">
		<div id="help">
			<div class="dashboard" id="dashboard">
				<ul><?php echo mcurrent_misc('index'); ?></ul>
			</div>
			<div id="content" class="coupons-box clear mainwide">
				<div class="box clear">
					<div class="box-top"></div>
					<div class="box-content">
						<!-- inicio : novo index -->
						<div class="m">
							<div class="adminform">
								<div class="cpanel-left">
									<div class="cpanel">
									

									 
										<div id="plg_quickicon_joomlaupdate" class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/system/logo.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/logo.png"><span>Alterar Logo</span></a></div>
										</div>
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/system/bulletin.php">
													<img style="width:82px;" alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/announcements-icon.png"><span>Gerenciar Banners</span></a></div>
										</div>
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/system/index.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/Sign-Info-icon.png"><span>Informações do Site</span></a></div>
										</div>
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/system/option.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/app-settings-icon.png"><span>Configurar Sistema</span></a></div>
										</div>  
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/system/pay.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/payment-card-icon.png"><span> Formas de Pagamento</span></a></div>
										</div>		 
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/user/index.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/user-group-icon.png"><span>Gerenciar Usuários</span></a></div>
										</div>
								 
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/category/index.php?zone=group">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/Actions-view-list-tree-icon.png"><span>Categorias e Menus</span></a></div>
										</div>
									 	<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/team/index.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/Bookmark-add-icon.png" ><span>Gerenciar Produtos</span></a></div>
										</div>
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/misc/feedback.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/message-already-read-icon.png"><span>Sugestões e Contatos</span></a></div>
										</div>
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/system/email.php">
													<img width="68" height="68" alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/configuration-settings-icon.png"><span>Configurar Envio <br /> de E-mails</span></a></div>
										</div>
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/order/index.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/shop-cart-add-icon.png"><span>Gerenciar Pedidos</span></a></div>
										</div> 
										<div id="plg_quickicon_extensionupdate" class="icon-wrapper" style="display:none;"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/misc/subscribe.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/Actions-news-subscribe-icon.png"><span>Inscritos em Newsletter</span></a></div>
										</div> 
										 
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/system/page.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/Document-Write-icon.png"><span>Criar Páginas</span></a></div>
										</div>
							 
										<div class="icon-wrapper" style="display:none;"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/parceiro/index.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/Office-Customer-Male-Light-icon.png"><span>Gerenciar Parceiros</span></a></div>
										</div>
										<div class="icon-wrapper"><div class="icon"><a href="<?= $ROOTPATH ?>/vipmin/misc/backup.php">
													<img alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/cd-burner-copy-icon.png"><span> Backup do Banco de Dados</span></a></div>
										</div>  
										<div class="icon-wrapper" style="display:none;"><div class="icon"><a target="_blank"  href="http://www.fazerlogomarca.com.br/pacotes-de-otimizacao-de-site-logo-banners-video-imagens-artes-personalizacao-redes-sociais-e-muito-mais-2/">
											 <img style="width:68px;" alt="" src="<?= $ROOTPATH ?>/skin/padrao/icones/mkt.png" ><span>Planos de publicidade e marketing</span></a></div>
										</div>
									</div>

								</div>
					  			
								<div class="cpanel-right"> 
									<div class="pane-sliders" id="panel-sliders"> 
											<div class="panel"><h3 id="cpanel-panel-logged" class="title pane-toggler-down"><a href="javascript:void(0);"><span style="font-size:1.5em">Pedidos não pagos</span></a></h3><div class="pane-slider content pane-down" style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden; height: auto;"><table class="adminlist">
													<tbody style="font-size:1.5em">
														<tr>
															<th scope="row">
																  Hoje: <?=$currency?> <?=number_format($rendimento_hoje,2,',','.')?>
															</th>
														     <th scope="row">
																  Mês: <?=$currency?> <?=number_format($rendimento_mes,2,',','.')?>
															</th>
															<th scope="row">
																 Ano: <?=$currency?> <?=number_format($rendimento_ano,2,',','.')?>
															</th>
														</tr>
												 
													</tbody>
												</table>
											</div></div>											
											
											<div class="panel"><h3 id="cpanel-panel-logged" class="title pane-toggler-down"><a href="javascript:void(0);"><span style="font-size:1.5em">Pedidos pagos</span></a></h3><div class="pane-slider content pane-down" style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden; height: auto;"><table class="adminlist">
													<tbody style="font-size:1.5em">
														<tr>
															<th scope="row">
																  Hoje: <?=$currency?> <?=number_format($rendimento_hoje_pago,2,',','.')?>
															</th>
														     <th scope="row">
																  Mês: <?=$currency?> <?=number_format($rendimento_mes_pago,2,',','.')?>
															</th>
															<th scope="row">
																 Ano: <?=$currency?> <?=number_format($rendimento_ano_pago,2,',','.')?>
															</th>
														</tr>
												 
													</tbody>
												</table>
											</div></div>											
											
											<div class="panel"><h3 id="cpanel-panel-logged" class="title pane-toggler-down"><a href="javascript:void(0);"><span style="font-size:1.5em">Comissões</span></a></h3><div class="pane-slider content pane-down" style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden; height: auto;"><table class="adminlist">
													<tbody style="font-size:1.5em">
														<tr>
															<th scope="row">
																  Hoje: <?=$currency?> <?=number_format($comissoes_hoje,2,',','.')?>
															</th>
														     <th scope="row">
																  Mês: <?=$currency?> <?=number_format($comissoes_mes,2,',','.')?>
															</th>
															<th scope="row">
																 Ano: <?=$currency?> <?=number_format($comissoes_ano,2,',','.')?>
															</th>
														</tr>
												 
													</tbody>
												</table>
											</div></div>
											
										<div class="panel"><h3 id="cpanel-panel-logged" class="title pane-toggler-down"><a href="javascript:void(0);"><span>Movimento</span></a></h3><div class="pane-slider content pane-down" style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden; height: auto;"><table class="adminlist">
											<tbody>
														<tr>
															<th scope="row">
																Total de Pedidos
															</th>
															<td class="valorTotal"><?=$order_count?></td>
															<th scope="row">
																Usuários Cadastrados Hoje
															</th>
															<td class="valorTotal"><?=$user_today_count?></td>
															
														 
														</tr>
														<tr>
															<th scope="row">
																Pedidos do Mês
															</th>
															<td class="valorTotal"><?=$order_month_count?></td>
															<th scope="row">

																Pedidos Hoje
															</th>

															<td class="valorTotal"><?=$order_today_count?></td>
														 
														</tr>
														<tr>
															<th scope="row"> 
																Total de Anúncios
															</th>
															<td class="valorTotal"><?=$team_count?></td> 
															<th scope="row">
																Pedidos Pagos Hoje
															</th>
															<td class="valorTotal"><?=$order_today_pay_count?></td> 
														</tr>
														<tr> 
															<th scope="row">
																Total de Usuários
															</th>
 
															<td class="valorTotal"><?=$user_count?></td>	 
															<th scope="row">
																 
															</th> 
															<td class="valorTotal"> </td>	 

														</tr>
													</tbody>
												</table> 
											</div></div>
											<div class="panel"><h3 id="cpanel-panel-logged" class="title pane-toggler-down"><a href="javascript:void(0);"><span>Últimos 10 pedidos pendentes</span></a></h3><div class="pane-slider content pane-down" style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden; height: auto;"><table class="adminlist">
													<tbody>
														<tr>
															<th scope="row">
																<b>Pedido</b>
															</th>
															<th scope="row">
																<b>Nome</b>
															</th> 
															<th scope="row">
																<b>Email</b>
															</th> 
															<th scope="row">
																<b>Valor do Pedido</b>
															</th> 
														</tr>
													<?
													$sql =  "SELECT  a.id, a.origin AS totalcompras, b.email, b.realname FROM `order` a, user b WHERE a.user_id = b.id AND a.state = 'unpay'  ORDER BY a.id DESC LIMIT 10";
													$rs = mysql_query($sql);
													while($row = mysql_fetch_object($rs)){ 	
													?>
														<tr>
															<th scope="row">
																<?=$row->id?>
															</th>
															<th scope="row">
																<?=$row->realname?>
															</th> 
															<th scope="row">
																<?=$row->email?>
															</th> 
															<th scope="row">
																<?=$currency?> <?=number_format($row->totalcompras,2,',','.')?>
															</th> 
														</tr>
													<? } ?>
													 
													</tbody>
												</table>
											</div></div>
											
											<div class="panel"><h3 id="cpanel-panel-logged" class="title pane-toggler-down"><a href="javascript:void(0);"><span>Top 10 melhores clientes</span></a></h3><div class="pane-slider content pane-down" style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden; height: auto;"><table class="adminlist">
													<tbody>
														<tr>
															<th scope="row">
																<b>Nome</b>
															</th> 
															<th scope="row">
																<b>Email</b>
															</th> 
															<th scope="row">
																<b>Total de Compras Pagas</b>
															</th> 
														</tr>
													<?
													$sql =  "SELECT sum( a.origin ) AS totalcompras, b.email, b.realname FROM `order` a, user b WHERE a.user_id = b.id AND a.state = 'pay' GROUP BY b.email, b.realname ORDER BY sum( a.origin ) DESC LIMIT 10";
													$rs = mysql_query($sql);
													while($row = mysql_fetch_object($rs)){ 	
													?>
														<tr>
															<th scope="row">
																<?=$row->realname?>
															</th> 
															<th scope="row">
																<?=$row->email?>
															</th> 
															<th scope="row">
																<?=$currency?> <?=number_format($row->totalcompras,2,',','.')?>
															</th> 
														</tr>
													<? } ?>
													 
													</tbody>
												</table>
											</div></div>
									</div>
								</div>
								<div class="clr"></div>
							</div>
							<!-- fim : novo index -->
						</div>
						<div class="box-bottom"></div>
					</div>
				</div>
			</div>
		</div> <!-- bd end -->
	</div> <!-- bdw end -->
	<?php include template("manage_footer"); ?>