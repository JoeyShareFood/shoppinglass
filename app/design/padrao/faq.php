	<?php
		require_once("include/code/contato.php");
		$pagetitle = 'Entre em contato conosco';
	?> 
	<?php  require_once("include/head.php"); ?>
	<body id="page1">
		<style>
		.formulario input#txtNome, .formulario input#txtEmail, .formulario input#dddTel, .formulario textarea#txtMsg, .formulario input#valores{
			margin: 0 0 0 0px;
		}
	</style>
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
							   <div class="col-6" style="width:914px" >  
									<?php  require_once(DIR_BLOCO."/bloco_faq.php"); ?>
								</div>
							 </div>
						</div>
					</div>
				</div>
			</section>
			<script type="text/javascript">
				J("#faqs dd").hide();
				J("#faqs dt").click(function () {
					J(this).next("#faqs dd").slideToggle(500);
					J(this).toggleClass("expanded");
				});
			</script>
	   </div>
	</div> 
	<?php require_once(DIR_BLOCO."/rodape.php"); ?>
	</body>
</html>
