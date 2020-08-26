	<?php  
		require_once("include/head.php"); 
		need_login();
	?> 
	<div style="display:none;" class="tips"><?=__FILE__?></div> 

	<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">

	<body id="page1" class="webstore home">
		<div class="cabecalhosub"></div>
			<div class="container">  
				<div class="page">
					<?php  require_once(DIR_BLOCO."/header.php"); ?>
						<div class="main-content clearfix"> 
							<div class="my-account-page" id="my-account-container">	
								<div id="my-account-header">			
									<?php  require_once(DIR_BLOCO."/my-account.php"); ?>		
								</div>
							</div>
							<div class="formay" style="margin-top: 75px;">	
							<?php require_once(DIR_BLOCO."/bloco_list_billi.php");  ?>
						</div>			
					</div>
				<?php
					require_once(DIR_BLOCO."/rodape.php");
					require_once(DIR_BLOCO."/alterar_dados_minha_conta.php");
				?>			
			</div>
		</div>
	</body>
</html>
