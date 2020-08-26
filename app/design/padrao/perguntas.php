<?php  
	
	require_once("include/head.php"); 
	need_login();
	
	
	$existe_registro = 0;

	if(isset($_GET["tipo"]) and !(empty($_GET["tipo"]))) {
		
		/* Caso o parâmetro via GET tenha sido enviado, o valor é recuperado
		   para verificar qual será a condição da busca.	
		*/
		$tipo = strip_tags(trim($_GET["tipo"]));
		
		if($tipo == "enviadas") {
			$tipo = "enviadas";
			$query = " id_cliente = " . $login_user['id'];
		} 
		else {		
			$tipo = "recebidas";
			$query = " id_vendedor = " . $login_user['id'];
		} 
	}
	else {
		$tipo = "enviadas";
		$query = " id_cliente = " . $login_user['id'];
	}
?> 
	<div style="display:none;" class="tips"><?=__FILE__?></div> 

	<link rel="stylesheet" href="<?=$PATHSKIN?>/css/myaccount.css" type="text/css" media="all">

	<body id="page1" class="webstore home">
		<div class="cabecalhosub"></div>
			<?php				
				if(detectResolution()) {			
			?>		
			<!-- Responsivo -->
			<div class="containerM">
				<? require_once(DIR_BLOCO."/headerM.php"); ?>
				<div class="row">
					<div class="productsPage">
					<?php
						require_once(DIR_BLOCO."/minhas_perguntasM.php");
					?>	
					</div>				
				</div>
			</div>
			<?php } ?>
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
							<? require_once(DIR_BLOCO."/bloco_questions_partner.php");  ?>
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
