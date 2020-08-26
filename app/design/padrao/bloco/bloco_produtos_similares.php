<div style="display:none;height:36px;" class="tips"><?=__FILE__?></div> 
<?  
require_once( dirname(dirname(dirname(dirname(dirname(__FILE__))))). '/app.php');
$teams = temsimilares($_REQUEST['team_id']);

?> 

<script type="text/javascript" src="<?=$ROOTPATH?>/js/jquery-1.7.1.min.js" ></script>  
<script type="text/javascript" src="<?=$ROOTPATH?>/js/jssor/js/jssor.js"></script> 
<script type="text/javascript" src="<?=$ROOTPATH?>/js/jssor/js/jssor.slider.js"></script>  
<script type="text/javascript" src="<?=$ROOTPATH?>/js/jssor/js/ini.js"></script>  
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/vitrine.css" type="text/css" media="all"> 
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/padrao.css" type="text/css" media="all"> 
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/product.css" type="text/css" media="all">
<link rel="stylesheet" href="<?=$PATHSKIN?>/css/home.min.css" type="text/css" media="all">

<link href='http://fonts.googleapis.com/css?family=Quattrocento' rel='stylesheet' type='text/css'> 
<link href='http://fonts.googleapis.com/css?family=Russo+One|Comfortaa|Roboto|Montserrat' rel='stylesheet' type='text/css'> 
 
	<div class="home-list" style="padding:0;">
		<h2 class="menu-title">	 <a href="#" class="menu-title-link" style="text-decoration:none;">  Produtos Similares </a> </h2>
	</div> 
	
	<div style="margin-left:12px">
		<div id="slider1_container">
			<div u="loading" class="loadingv">
				<div class="filtrov"> </div>
				<div class="vitrinesub"> </div>
			</div> 
			<div u="slides" class="blocovitrine">
				<? 
				foreach ($teams as $team) {  	
					if($team['id'] == $_SESSION['team_id']){
						continue;
					}
					$link 			= getLinkOferta($team); 
					$imagem 		= getimagemoferta($team);
					$titulo 		= utf8_decode(displaySubStringWithStrip($team[title],130));
					$precopor 		= number_format($team['team_price'], 2, ',', '.'); 
					$precode		= number_format($team['market_price'], 2, ',', '.');  
					$economia 		= number_format($team['market_price'] - $team['team_price'],2, ',', '.'); 
					$porcentagem  	= round(100 - $team['team_price']/$team['market_price']*100,0);
					$avaliacaomedia = avaliacaomedia($team['id']);
					$avaliacaomediaformat1 =  number_format($avaliacaomedia, 1, '.', ''); 
					$avaliacaomediaformat = str_replace(".","_",$avaliacaomediaformat1);
				  
				?>				
				<div>		
					<article data-giftsrc="" data-gift="false" data-rule="vitrine1_1" data-component="single-product" class="single-product vitrine225 ui-draggable" style="margin-right: -3px;">
					<form action="<?=$link?>">
					<div class="productImg">
						<a class="url" title="<?=$titulo?>" href="<?=$link?>" target="_parent">
						<img class="photo lazy lazyload-ready maximagem" src="<?=$imagem?>" alt="<?=$titulo?>" style="display: inline;">
						<span class="dragPIcon"></span></a>
					</div> 
					<div class="productInfo">
						<div class="top-area-product">
							<a class="prodTitle" title="<?=$titulo?>" href="<?=$link?>" target="_parent" > <?=$titulo?></a>
							<div class="box_bv">
								<span class="review_bv">
									<div style="width:101.2%" class="review_points"> 
										<img alt="stars" src="<?=$PATHSKIN?>/rating/rating-<?=$avaliacaomediaformat?>.gif"> 
									</div>
								</span>
								<span> <span itemprop="reviewCount"> (<?=$avaliacaomediaformat1?>) </span> </span>
							</div>
						</div>
						<div class="product-info">
							<div class="price-area">
								<span class="regular price"> De<del>R$ <?=$precode?></del> </span>
								<span class="sale price"> <strong> R$ <?=$precopor?> </strong> </span>
								<!-- 
								<div class="interest">
									<span class="parcel"> Ou 10x de R$ 149,90 </span> <span class="condition"> sem juros </span>
								</div>
								-->
								<!-- <div class="mb-save"> Economize <?=$porcentagem?>% </div>-->
							</div> 			 
						</div>
					</div> 
					</form>
					</article>	
				</div>   
			<? } ?>
			<?if($teams ){?>
			</div>  
			<div u="navigator" class="jssorb03 bulletcontainer"> 
				<div u="prototype" class="bulletprotot"><NumberTemplate></NumberTemplate></div>
			</div>   
			<span u="arrowleft" class="jssora03l setaesquerda"> </span> 
			<span u="arrowright" class="jssora03r setadireita"> </span> 
		</div>
	</div>
	<? } ?>