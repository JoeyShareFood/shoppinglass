<?php  
	require_once("include/head.php"); 
	$home="sim";
?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 

	<body id="page1" class="webstore home">
		<?php
			if(detectResolution()) {
		?>
		<!-- Responsivo -->
		<div class="containerM">
			<? require_once(DIR_BLOCO."/headerM.php"); ?>
			<div class="row">
				<script type="text/javascript" src="<?=$ROOTPATH?>/js/slides-slides-js/jquery.slides.min.js"></script>

				<script>
					J(function(){
						J("#slides").slidesjs({
							start: 2,
							play: {
							  active: true,
								// [boolean] Generate the play and stop buttons.
								// You cannot use your own buttons. Sorry.
							  effect: "slide",
								// [string] Can be either "slide" or "fade".
							  interval: 5000,
								// [number] Time spent on each slide in milliseconds.
							  auto: true,
								// [boolean] Start playing the slideshow on load.
							  swap: true,
								// [boolean] show/hide stop and play buttons
							  pauseOnHover: false,
								// [boolean] pause a playing slideshow on hover
							  restartDelay: 2500
								// [number] restart delay on inactive slideshow
							},
							pagination: {
							  active: false,
								// [boolean] Create pagination items.
								// You cannot use your own pagination. Sorry.
							  effect: "slide"
								// [string] Can be either "slide" or "fade".
							},
							navigation: {
							  active: false,
								// [boolean] Generates next and previous buttons.
								// You can set to false and use your own buttons.
								// User defined buttons must have the following:
								// previous button: class="slidesjs-previous slidesjs-navigation"
								// next button: class="slidesjs-next slidesjs-navigation"
							  effect: "slide"
								// [string] Can be either "slide" or "fade".
							}
						});
					});
				</script>
				<style>
					#slides {
						display: none;
						width: 100% !important;
						margin-bottom: -80px !important;
					}
					#slides img {
						max-width: 100% !important;
					}
					.slidesjs-stop.slidesjs-navigation {
						display: none !important;
					}
				</style>				  
				<div id="slides">
					<?=getbannerslideshow()?>	
				</div> 
				<div class="titlePage">
					<?php
						if((isset($_GET['q']) && !(empty($_GET['q']))) || (isset($_GET['categories']) && !(empty($_GET['categories'])))) {
					?>
					<p>Resultados da pesquisa</p>
					<?php } else { ?>
					<p>Produtos que voam alto</p>
					<?php } ?>
				</div>
				<div class="productsPage">
				<?php									
					$BlocosOfertas = new BlocosOfertas();
					$idcat = "";
					$stordenacao = "cpordenacaofx";

					if ($navegador != "firefox") {
						$stordenacao = "cpordenacaoie";
					}
					$idcategoria = trim(RemoveXSS($_REQUEST['categories']));
					/*
					if (!empty($_POST['cppesquisa'])) {
						$cppesquisa = trim($_POST['cppesquisa']);
					} else if (!empty($_POST['cppesquisagrava'])) {
						$cppesquisa = trim($_POST['cppesquisagrava']);
					}

					if ($cppesquisa == "O que está procurando ?") {
						unset($cppesquisa);
					}

					if (!empty($cppesquisa)) {
						$procura = retira_acentos($cppesquisa);
						$condition[] = "title like '%" . $procura . "%' or summary like '%" . $procura . "%' or seo_keyword like '%" . $procura . "%'";
						$condition[] = "posicionamento <> 5"; 
						// pocionamento 5, oferta desativada
						$condition[] = "moderacao = 'Y'"; 
						// Apenas produtos moderados pelo administrador				
						$condition[] = "max_number >= 1";
						$posicionamento = true;
					}

					if ($idcategoria) {
						$condition[] = "group_id = $idcategoria";
						$condition[] = "posicionamento <> 5";
						$condition[] = "moderacao = 'Y'"; 
						// Apenas produtos moderados pelo administrador				
						$condition[] = "max_number >= 1";
						$posicionamento = true;
						unset($idcategoria);
					}
	
					
					if (!$posicionamento) {
						if(!(isset($_GET['categories']))) {
							$condition[] = "posicionamento  <> 12"; 
							// aparece somente na categoria
						}
						$condition[] = "moderacao = 'Y'"; 
						// Apenas produtos moderados pelo administrador				
						$condition[] = "max_number >= 1";
					}
					*/
					
					//$condition[] = "max_number >= 1";
					
					$count = Table::Count('team', $condition);
					
					if(!(empty($_GET['q'])) || !(empty($_GET['categories']))) {
						list($pagesize, $offset, $pagestring) = pagestring($count, 100);
					}
					else {
						list($pagesize, $offset, $pagestring) = pagestring($count, 15);
					}

					$order = " order by `sort_order` DESC, `id` DESC ";

					if ($INI['option']['rand_popular'] == "Y" and $_REQUEST['pagina']) {
						$order = "order by rand()";
					}
					if (!empty($_POST['ordena'])) {
						$order = "order by " . $_POST['ordena'];
					}
					
					if(isset($_GET['q']) && !(empty($_GET['q']))) {
						
						$q = urldecode(strip_tags($_GET['q']));
						$condition[] = "title LIKE '%" . utf8_encode($q) . "%'";
					}					
					
					if(isset($_GET['categories']) && !(empty($_GET['categories']))) {
						
						$category = (int) urldecode(strip_tags($_GET['categories']));
						
						getcategoriafilhas($category);   
						$idcategorias.= $categoriasfilhasprod . "'" . $idcategoria . "'"; 
						
						$condition[] = "group_id in( " . $idcategorias . " )";
					}
					
					//$teams = DB::LimitQuery('team', array('condition' => $condition, 'order' => $order));

					$teams = DB::LimitQuery('team', array(
						'condition' => $condition,
						'order' => 'ORDER BY id DESC',
						'size' => $pagesize,
						'offset' => $offset,
					));
					
					foreach($teams as $team) { 
						
						$BlocosOfertas->getDados($team);
						require(DIR_BLOCO."/lista_produtos.php");
					}
										
					require_once(DIR_BLOCO."/rodapeM.php");
				?>	
				</div>				
			</div>
		</div>
		<?php } else { ?>
		<div class="container">  
			<div class="page">
				<?php  require_once(DIR_BLOCO."/header.php"); ?>			  
				<div class="toptopo"></div>
				<section id="content" class="content">
					<div class="main-content clearfix"> 
						<? $BlocosOfertas->getBlocoPrincipal(); ?>  
					</div>
				</section> 
			<?php
				require_once(DIR_BLOCO."/bloco_newsletter.php");
				require_once(DIR_BLOCO."/rodape.php");
			?>	
			</div>
		</div>
		<?php } ?>
	</body>
</html>
