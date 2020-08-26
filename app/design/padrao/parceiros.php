<?php  
require_once("include/head.php"); 
require_once("include/code/recentes.php");

$titulo=$_REQUEST['nome'];
$idparceiro = $_REQUEST['idparceiro'];
 
if($idparceiro){ 
	$partner = Table::Fetch('partner', $idparceiro ); 
	$titulobreadcrumb = $partner['title'];
}
?> 
<div style="display:none;" class="tips"><?=__FILE__?></div> 
<script type="text/javascript" src="<?=$ROOTPATH?>/js/paginacao_parceiro.js" ></script>

	<body id="page1" class="webstore home">
		<div class="cabecalhosub"></div>
		<div class="container">  
			<div class="page">
				<?php  require_once(DIR_BLOCO."/header.php"); ?> 
				<div class="toptopo"></div> 
				<section id="content" class="content">
					<div class="main-content clearfix">  
						<div class="bannertopopages" style="margin-left: -9px;">
							<?php  require_once(DIR_BLOCO."/bannertopo.php"); ?> 
							<!-- <iframe frameborder="0" height="353" width="1405" scrolling="no" src="<?=$ROOTPATH."/app/design/padrao/bloco/bannertopo.php";?>" id="bannerslide"></iframe>-->
						</div> 
						
							<!-- 
							<div class="search-background" style="z-index:999;margin-left:110px;">
							   <img src="<?=$PATHSKIN?>/images/loader.gif" alt="" /> 
							</div>  
							-->
							<!-- NUMERO DAS PÁGINAS --> 
							<div id="pgofertas"> </div>
							<div style="clear:both;margin-left: 13px;">
								<? require_once("include/paginacao_parceiro_pages.php"); ?> 
							</div>   
							<br style="clear:both;" style="margin-top:10px;">
							<br style="clear:both;" style="margin-top:10px;">
					</div>
				</section> 
			<?php
				require_once(DIR_BLOCO."/rodape.php");
			?> 
			</div>
		</div>
	</body>
</html>
