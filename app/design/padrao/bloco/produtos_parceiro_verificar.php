<div style="display:none;" class="tips"><?=__FILE__?></div> 
 
<div class="telefonia home-list clearfix hover">   
	<div class="shelf-home shelf-container shelf-horizontal  two-rows">	
		<div class="shelf-itens carousel-shelf-home arrow-big clearfix owl-carousel owl-theme" style="opacity: 1; display: block;">
			<div class="owl-wrapper-outer">
				<div class="owl-wrapper" style="width: 1082px; left: 0px; display: block;">	
					<?
					$sql 		= "select * from team where posicionamento <> 5 and begin_time < '".time()."' and partner_id = ".RemoveXSS($_REQUEST['idparceiro'])." order by `begin_time` DESC , `now_number` DESC limit $start,$per_page ";
					$rsd 		= mysql_query($sql);
		
					while ($team = mysql_fetch_assoc($rsd)){  
						
						$temoferta = true; 
						$link = getLinkOferta($team);
						$titulo  = $team[title];
						$preco = number_format($team['team_price'], 2, ',', '.');
						$precoantigo = number_format($team['market_price'], 2, ',', '.');
						
						if($linha==0){
							echo "<div class='telefonia home-list clearfix'>";
						}
						?> 
						<div class="owl-item " style="width: 359px;"> 
							<div class="bordalist">
								<div class="shelf-item clearfix">
									<figure>
										<a href="<?php echo $link ?>" title="<?=$titulo?>">
											<img class="lazyOwl" alt="<?=$titulo?>" width="130" height="130" src="<?=getImagem($team,"popular")?>" style="display: block;">
										</a>
									</figure>
									<div class="right-align titulooferta">
										<a href="<?php echo $link ?>"> <span class="product-title"> <?=$titulo?> </span>
										<p class="shelf-price">
											<span> 
												<span class="payment-price-old-home"> <span class="label">De: </span> 
													<del> R$ <?=$precoantigo?> </del> 
												</span> 
												<span class="payment-sell-home" itemprop="price"> <span class="label">Por</span> <span class="payment-currency"> R$ </span> 
												<span class="payment-price-home"> <strong> <span class="int"> <?=$preco ?> </span> </strong> </span> </span> 
												 
											</span>
										</p> </a>
									</div>
								</div>
							</div> 
						</div>  
						<? 
						$linha++; 
						if($linha==3){
							$linha=0;
							echo "</div>";
						}			 
					} ?>  
					</div>
				</div>
			</div>
		</div>			
	</div> 
		 