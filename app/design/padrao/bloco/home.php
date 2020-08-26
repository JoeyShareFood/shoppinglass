<div style="display:none;height:36px;" class="tips"><?=__FILE__?></div>

<script>
	J('document').ready(function(){
	
		J('.menu-items').css('display', 'none');
		J(".menu-title-link").hover(function(){
			J(".menu-items").toggleClass('.menu-items-display');
			J('.menu-items').css('display', 'block');
		});
	});
</script>

<style>
	section {
		background: #FFF;
	}
</style>

<?php 
	$BlocosOfertas = new BlocosOfertas();
	$idcat = "";
	$stordenacao = "cpordenacaofx";

	if ($navegador != "firefox") {
		$stordenacao = "cpordenacaoie";
	}
	$idcategoria = trim(RemoveXSS($_REQUEST['idcategoria']));

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
		$condition[] = "posicionamento <> 5"; // pocionamento 5, oferta desativada
		$condition[] = "moderacao = 'Y'"; // Apenas produtos moderados pelo administrador				$condition[] = "max_number >= 1";
		$posicionamento = true;
	}

	if ($idcategoria) {
		$condition[] = "group_id = $idcategoria";
		$condition[] = "posicionamento <> 5";
		$condition[] = "moderacao = 'Y'"; // Apenas produtos moderados pelo administrador				$condition[] = "max_number >= 1";
		$posicionamento = true;
		unset($idcategoria);
	}

	if (!$posicionamento) {
		$condition[] = "posicionamento  <> 12 AND posicionamento <> 5"; // aparece somente na categoria
		$condition[] = "moderacao = 'Y'"; // Apenas produtos moderados pelo administrador				$condition[] = "max_number >= 1";
	}
	//$condition[] = "max_number >= 1";
	$count = Table::Count('team', $condition);
	list($pagesize, $offset, $pagestring) = pagestring($count, 15);

	$order = " order by `sort_order` DESC, `id` DESC ";

	if ($INI['option']['rand_popular'] == "Y" and $_REQUEST['pagina']) {
		$order = "order by rand()";
	}
	if (!empty($_POST['ordena'])) {
		$order = "order by " . $_POST['ordena'];
	}
	//$teams = DB::LimitQuery('team', array('condition' => $condition, 'order' => $order));

	$teams = DB::LimitQuery('team', array(
		'condition' => $condition,
		'order' => 'ORDER BY id DESC',
		'size' => $pagesize,
		'offset' => $offset,
	));
?> 
<? $ehome = true; ?>

<? if (empty($cppesquisa)) {?>
	<div class="BannerTopoHome">
		<?=$INI['bulletin']['bannermeio'] ; ?>
	</div>

	<div class="bannertopopages">  
		<? require_once(DIR_BLOCO."/bloco_banners_slide_home.php");  ?>  
	</div>
				
	<? require_once(DIR_BLOCO."/bloco_menucategorias.php");  ?>

	<div class="AnunciosLateralDireita">
		<?php //echo $INI['bulletin']['bannertopoprodutoshome']; ?>
	</div>
	<?  require_once(DIR_BLOCO."/categorias_destaque.php");  ?> 

<? } ?>

<!-- LISTA DE PRODUTOS -->
<div class="produtoslista">
	<div class="telefonia home-list clearfix hover">   
		<div class="owl-item-title" style="background:#FFF;">
			<?php if (empty($cppesquisa)) {?>
			<span style="font-size:20px;color:#038BA3;">PRODUTOS EM <span style="font-weight:bold;"> <span style="color:#BFBFBF;">DESTAQUE</span></span></span>
			<?php } else { ?>
			<span style="font-size:20px;color:#038BA3;">Você pesquisou por: <span style="font-weight:bold;"> <span style="color:#BFBFBF;"><?php echo $procura; ?></span></span></span>
			<?php } ?>
			<div class="border-right">
			</div>
		</div>
		<div class="shelf-home shelf-container shelf-horizontal  two-rows">	
			<div class="shelf-itens carousel-shelf-home arrow-big clearfix owl-carousel owl-theme" style="opacity: 1; display: block;">
				<div class="owl-wrapper-outer">
					<div class="owl-wrapper" style="width: 104%; left: 0px; display: block;">	
					<? foreach ($teams as $team) {    
							$BlocosOfertas = new BlocosOfertas();
							$BlocosOfertas->getDados($team);
							$avaliacaomedia = avaliacaomedia($team['id']);
							$avaliacaomediaformat1 =  number_format($avaliacaomedia, 1, '.', ''); 
							$avaliacaomediaformat = str_replace(".","_",$avaliacaomediaformat1);
							
							/* Apenas produtos moderados pelo administrador são exibidos. */
							if($team['moderacao'] == "Y") {
								require(DIR_BLOCO."/lista_produtos.php"); 
							}
					} 
					if($count==0){
						if(!empty($cppesquisa )){?> 
							<div style="font-size: 13px; margin-left: 18px; color:#303030;">
								A pesquisa pela palavra "<b> <?=$cppesquisa?> </b>" não retornou nenhum produto.
							</div>
						<? } 
					}
					?>
					</div>
				</div>
			</div>
		</div>			
	</div>  
</div> 
<div class="lista-depoimentos">
	<div class="owl-item-title" style="background:#FFF;padding-left:0px;">
		<div class="border-right" style="width:360px;float:left;">
		</div>		
		<span style="font-size:20px;color:#038BA3;margin-left: 20px; margin-right: 15px;"><span style="font-weight:bold;">Depoimentos de</span> quem <span style="color:#bfbfbf">usou e gostou</span></span>
		<div class="border-right" style="width:360px;">
		</div>
	</div>
	<?php
		$SqlAvaliation = "SELECT * FROM `qualification` order by rand() limit 1";
		$RsAvaliation = mysql_query($SqlAvaliation);
		$row = mysql_fetch_assoc($RsAvaliation);
		
		$sqlUser = "select realname, estado from user where id = " . $row['id_qualificante'];
		$rsUser = mysql_query($sqlUser);
		$rowUser = mysql_fetch_assoc($rsUser);
	?>
	<div class="item">
		<div class="titulo-carrousel" style="text-transform:uppercase;">
			<?php
				echo utf8_decode($row['titulo']);
			?>
		</div>				
		<div class="texto-carrousel" style="text-transform:lowercase;">
			<span class="aspas">"</span>...<?php
				echo utf8_decode($row['text']);
			?><span class="aspas">"</span>
		</div>
		<div class="info-user">
			<span class="name-user">
				<?php
					echo utf8_decode($rowUser['realname']); 
				?>
			</span>
			<span style="color:#797979;"> - </span>
			<span class="state-user">
				<?php
					echo utf8_decode($rowUser['estado'])
				?>
			</span>
		</div>
	</div>
	<div class="border-right" style="width:100%;">
	</div>
</div>
<form method="POST" id="formparceiro" name="formparceiro"></form>

<form method="POST" id="formpesquisa3" name="formpesquisa3">
	<input type="hidden" name="cppesquisagrava" id="cppesquisagrava" value="<?=$cppesquisa ?>">
</form> 