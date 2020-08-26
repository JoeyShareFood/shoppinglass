				<div class="titlePage">
					<p>Minhas Compras</p>
				</div>
				<div class="productsPage">
					<div class="order-list-items orders-list-result">
						<div class="wrapper-order-item md-2">
							<?php 
							
								foreach($ordersM as $row) { 

									if($row['state'] == "pay") {
										$status = "Pedido pago";
									}	

									if($row['state'] == "unpay") {
										$status = "Aguardando pagamento";
									}
									
									if($row['statuspedido'] == "cancelado") {
										$status = "Pedido cancelado";
									}
							?>
							<div class="order-list-item">
								<div class="order-list-status">
									<div class="order-text-status">
										<div class="col-lg-3 icon-column pull-left">
											<div class="icon-background status-pending">
												<i class="icon-remove"></i>
											</div>
										</div>
										<h2>Status do pagamento</h2>
										<div class="status-title"><?php echo $status; ?></div> 
										<div class="status-time"> </div>
									</div>
								</div>
								<div class="order-middle-info">
									<div class="col-lg-6 order-list-info">
									<h2>Dados do pedido</h2>
									<div class="status-title "><span class=" bold">Nº do Pedido:</span> <?=$row['id']?></div>
										<div class="status-time"><span class=" bold">Realizado em:</span> <?=data($row['datapedido'])?></div>
										<div class="status-title"><span class=" bold">Valor do pedido:</span> R$ <?=number_format($row['origin'], 2, ',', '.') ?></div>
										<div class="status-time"><span class=" bold">Frete:</span> R$ <?=number_format($row['valorfrete'], 2, ',', '.') ?></div>
									</div>
								</div>	
								<?php if($row['statusentrega'] == "Pedido entregue"){?>
								<div class="order-middle-info">
									<div class="col-lg-6 order-list-info">
										<h2>Pedido entregue</h2>
										<div class="status-title "><span class=" bold">Pedido entregue em:</span> <?=data($one['dataentrega'])?></div>
									</div>
								</div>
	`							<?php } else if($row['statusentrega']!= "") { ?>								
								<div class="order-middle-info">
									<div class="col-lg-6 order-list-info">
										<h2>Pedido entregue</h2>
										<div class="status-title "><span class=" bold"><?=utf8_decode($one['statusentrega'])?></span> <?=data($one['data_ultima_atualizacao'])?></div>
									</div>
								</div>	
								<?php } ?>
								<div class="order-list-links">
									<h2>Ações</h2>
									<div class="table-cell"> 
										<?php if($row['state'] == "unpay" && $row['statuspedido'] != "cancelado") { ?>
										<a href="<?php echo $ROOTPATH; ?>/index.php?page=minhacontapagar&idpedido=<?=$row['id']?>">
											<img src="<?php echo $PATHSKIN; ?>/images/pay.png" title="Pagar pedido" alt="Pagar pedido">
										</a>  																												
										<?php } else { ?>
											Nenhuma ação a ser feita.
										<?php } ?>
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