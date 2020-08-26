<?php  
	require_once("include/head.php"); 
	$page = Table::Fetch('page', $idpagina );
	$pagetitle = $page['titulo'];  

	if(!$idpagina){
		$pagetitle = "Página não Encontrada ;(";
		$page['value'] = "Não achamos esta página.";
	}
?> 
<style>
	.contentpage {
		margin-top: 35px !important;
		width: 1000px;
		margin: 0 auto;
	}
</style>
<div style="display:none;" class="tips"><?=__FILE__?></div> 
	<body id="page1" class="webstore home">
		<div class="cabecalhosub"></div>		
		<?php			
			//if(detectResolution()) {		
		?>
		<!-- Responsivo -->
		<div class="containerM">
			<? require_once(DIR_BLOCO."/headerM.php"); ?>
			<div class="row">
				<div class="titlePage">
					<p><?php echo utf8_decode($pagetitle) ?></p>
				</div>
				<div class="textPage">
					<?=htmlspecialchars_decode($page['value'])?>			
				</div>
				<?php require_once(DIR_BLOCO."/rodapeM.php"); ?>
			</div>
		</div>
		<?php //} else { ?>
		<div class="container">  
			<div class="page">
				<?php  require_once(DIR_BLOCO."/header.php"); ?>
				  
				<div class="toptopo"></div>

				<section id="content" class="content">
					<div class="main-content clearfix"> 
						 
						<div class="content-page-info" > 
							<h2 style="display:none;"><?php echo utf8_decode($pagetitle) ?> </h2>
							<br>
							<div class="contentpage"> <?=utf8_decode($page['value'])?></div>
						</div> 
					</div>
				</section> 
				<?php
					require_once(DIR_BLOCO."/rodape.php");
				?>	
			</div>
		</div>
		<?php //} ?>
	</body>
</html>
