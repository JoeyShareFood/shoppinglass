				<style>									.status-title {											text-transform: lowercase;										}				</style>								<div class="titlePage">
					<p>Qualifica��es <?php echo $tipo; ?></p>
				</div>
				<div class="productsPage">
					<div class="order-list-items orders-list-result">
						<div class="wrapper-order-item md-2">
							<?php 
							
								foreach($ordersM as $row) { 																	$user = Table::Fetch('user', $row['id_qualificante']);																		
									if($row['concretion'] == 1) {
										$status = "Qualifica��o positiva";
									}	
									else {
										$status = "Qualifica��o negativa";
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
										<h2>Qualifica��o do pedido #<?=$row['id_order']?></h2>
										<div class="status-title"><?php echo $status; ?></div> 
										<div class="status-time"> </div>
									</div>
								</div>
								<div class="order-middle-info">
									<div class="col-lg-6 order-list-info">
										<h2>Descri��o</h2>
										<div class="status-title "><?=utf8_decode($row['text'])?></div>
									</div>
								</div>									
								<div class="order-middle-info">
									<div class="col-lg-6 order-list-info">
										<h2>Cliente</h2>
										<div class="status-title ">																						<?=utf8_decode($user['username'])?>																						<br />																						<?=utf8_decode($user['login'])?>																					</div>
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