<?php  

require_once("include/head.php");

$user = strip_tags($_GET["idvendedor"]);

$sql = "select * from qualification where id_qualificado = " . $user . " order by data DESC";
$rsj = mysql_query($sql);
$num = mysql_num_rows($rsj);

$user = Table::Fetch('user', $user);

$pagetitle = "Qualificações do usuário " . strtoupper($user['login']);

?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 

<body id="page1" class="webstore home">
<div class="cabecalhosub"></div>
<div class="container">  
	<div class="page">
		<?php  require_once(DIR_BLOCO."/header.php"); ?>
			<div class="main-content clearfix"> 
				 
				<div class="content-page-info" > 
				<br>
					<h2 style="text-transform:uppercase;"><?php echo utf8_decode($pagetitle) ?> </h2>
					<br>
					<div class="contentpage">	
						<div class="content-review clearfix" style="border:0;">
						<ol>
		<?
			if($num >=1 ) {			
				while($linha = mysql_fetch_object($rsj)){ 
				
					$team = Table::Fetch('team', $linha->id_produto);
					$qualificante = Table::Fetch('user', $linha->id_qualificante);
					$data = date("d/m/Y H:i", strtotime($linha->data));
		?>
			<li class="item-review clearfix">
				<article class="item-article-review clearfix" itemtype="http://schema.org/Review" itemscope="" itemprop="review">
					<div class="customer-rating" itemtype="http://schema.org/Rating" itemscope="" itemprop="reviewRating">
						<div id="rating" class="rating average-<?=$linha->nota?>0" data-rating="<?=$linha->nota?>" data-productid="<?=$linha->id_vendedor?>">
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
								<span class="arc-content-value" itemprop="ratingValue"><?=$linha->nota?></span>
								<span class="arc-content-no-rate">Sem Nota</span>
								<meta content="0" itemprop="worstRating">
								<meta content="5" itemprop="bestRating">
							</div>
						</div>
					</div>
				<div class="customer-review">
					<strong class="title-customer-review" itemprop="author">"<?=utf8_decode($linha->titulo)?>"</strong>
					<p class="description-customer-review" itemprop="description">"<?=utf8_decode($linha->text)?>"</p>
					<p class="customer-data">
						<span class="location">
							<em class="city-client" itemprop="contentLocation"></em>
							<p class="AnuncioAvaliacoes"><?php echo utf8_decode("Anúncio: "); ?><a href="<?php echo $ROOTPATH; ?>/index.php?idoferta=<?php echo $team['id']; ?>"><?php echo utf8_decode($team['title']); ?></a></p>
							<p class="Login"><?php echo $qualificante['login']; ?> - <?php echo $data; ?></p>
						</span>
						<meta content="2014-11-15T14:38:10.000+0000" itemprop="datePublished">
					</p>
				</div>
				</article>
			</li> 
			<? } } else { ?>
			<li class="item-review clearfix">
				<article class="item-article-review clearfix" itemtype="http://schema.org/Review" itemscope="" itemprop="review">
					<p><?php echo utf8_decode("Este usuário ainda não possui avaliações."); ?></p>				
				</article>
			</li>			
			<?php } ?>
		</ol>
	</div>					
					</div>
				</div> 
			</div>
	<?php
		require_once(DIR_BLOCO."/rodape.php");
	?>
	
</div>
</div>
</body>
</html>
