<div style="display:none;" class="tips"><?=__FILE__?></div>
<?php

	$avaliacaomedia = avaliacaomedia($team[id]);
	$avaliacaomediaformat =  number_format($avaliacaomedia, 1, '.', '');
	$avaliacaomedia = number_format($avaliacaomedia, 1, '', '');
	$sql = "select * from qualification where id_produto = " . $team['id'] . " order by data limit 15";
	$rs = mysql_query($sql);	
	$total = mysql_num_rows($rs);
?>		
<section id="product-review" class="product-review" > 
	<p>Se você realizou uma qualificação recentemente, por favor, aguarde para que ela seja exibida.</p>
	<div class="content-review clearfix">
		<ol>
		<?php
			while($RowQualification = mysql_fetch_assoc($rs)){ 
			
				/* Busca pelos dados do cliente que fez a pergunta. */
				$user = Table::Fetch('user', $RowQualification['id_qualificante']);
				$data =  $RowQualification['data'];
		?>
			<li class="item-review clearfix">
				<article class="item-article-review clearfix" itemtype="http://schema.org/Review" itemscope="" itemprop="review">
					<div class="customer-rating" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
						<div id="rating" class="rating average-<?=$RowQualification['nota']?>0" data-rating="<?=$RowQualification['nota']?>" data-productid="<?=$RowQualification['id_vendedor']?>">
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
								<span class="arc-content-value" itemprop="ratingValue"><?=$RowQualification['nota']?></span>
								<span class="arc-content-no-rate">Sem Nota</span>
								<meta content="0" itemprop="worstRating">
								<meta content="5" itemprop="bestRating">
							</div>
						</div>
					</div>
					<div class="customer-review">
					<strong class="title-customer-review" itemprop="author">"<?=utf8_decode($RowQualification['titulo'])?>"</strong>
					<p class="description-customer-review" itemprop="description">"<?=utf8_decode($RowQualification['text'])?>"</p>
					<p class="customer-data">
						<span class="location">
							<em class="city-client" itemprop="contentLocation"></em>
							<p class="Login"><?php echo $user['login']; ?> - <?php echo datahora($data); ?></p>
						</span>
						<meta content="2014-11-15T14:38:10.000+0000" itemprop="datePublished">
					</p>
				</div>
				</article>
			</li> 
		<?php } ?>
		</ol>
	</div>
</section>