 <?php 
 
$status_pagamento = $_REQUEST['status_pagamento'];

if($status_pagamento == "EmAnalise"){
	$status_pagamento = "Em Análise";	
} 
 
require_once("include/head.php"); ?>
 
<body id="page1">
<div style="display:none;" class="tips"><?=__FILE__?></div>
<div class="tail-top">

    <div class="main">
       <?php  require_once(DIR_BLOCO."/header.php"); ?>
		<section id="content"> 
			<?php  require_once(DIR_BLOCO."/bannertopo.php"); ?>
            <div class="inside">
				<div class="container">
					<div class="col-1c">
						<div class="container">
						   <div class="col-6" > 
								<h2><?=$_GET['mensagem']?></h2>
								<div class="contentpage"> 
								   Sua transação foi processada pelo Moip Pagamentos S/A.
									A sua transação está <b><?=$status_pagamento?></b> e o código Moip é <b><?php echo $_GET['p']; ?></b>.
									Caso tenha alguma dúvida referente a transação, entre em contato com o Moip	
								</div>
							 </div> 
							<div class="col-2">
								<div class="indent">
									<div class="indent1" style="padding:0 0 17px;">
										<div class="box p1">
											 <div class="col-2" style="<?=$styledireita?>">
												  <div style="display:none;height:35px;" class="tips"><?=__FILE__?></div>
													<div class="box">
														<div class="indent-box" > 
														  <!-- INICIO BLOCO OFERTA NACIONAL -->
																<?php  $BlocosOfertas->coluna_direita("10"); ?>
														 <!-- FIM BLOCO OFERTA NACIONAL -->
															 <?php  
															if($BlocosOfertas->tem_outras_ofertas()){ ?>			
																<table cellpadding="0" cellspacing="0" border="0">
																<tr><td colspan="2"><div class="secaotitulo outras"><?=$INI['option']['nomeblocodireita']?><div></td></tr>
																 <!-- INICIO BLOCO OFERTAS GERAIS -->
																<?php  $BlocosOfertas->coluna_direita("4,6"); ?>
																<!-- FIM BLOCO OFERTAS GERAIS -->
															  </table>
															<? } ?> 
															<? require_once(DIR_BLOCO."/bloco_facebook.php"); ?>
															<? require_once(DIR_BLOCO."/bloco_twitter.php"); ?>
															<? require_once(DIR_BLOCO."/bloco_avisos_banner.php"); ?>
															<? require_once(DIR_BLOCO."/bloco_ranking.php");  ?>
															
														</div>     
												</div>
												 <script> 
													J(".outras").corner("round 2px");
													J(".tit_oferta_nacional").corner("round 2px");
												</script>	
										</div>
									</div>
								</div>
							</div>
						
						 </div>
					</div>
				</div>
			</div>
        </section>
    </div>
</div> 
 
 <?php require_once(DIR_BLOCO."/rodape.php"); ?>
 
</body>
</html>
 