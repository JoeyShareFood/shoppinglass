<?php include template("manage_header");
 
 ?>

 <style>
 .report-head {
	font-size: 20px;
	border-bottom:1px solid #eee;
	margin-bottom: 14px; 
}
 </style>
<div id="bdw" class="bdw">
	<div id="bd" class="cf">
		<div id="system">
			<style>
				#f1_upload_process{
					z-index:100;
					position:absolute;
					visibility:hidden;
					text-align:center;
					width:100px;
					margin:0px;
					padding:0px;
					background-color:#fff;
					border:1px solid #ccc;
				}
			</style>
			<div class="dashboard" id="dashboard">
				<ul><?php echo mcurrent_system('redes'); ?></ul>
			</div>
			<form method="post">  
			<div id="content" class="clear mainwide">
				<div class="clear box">
					<div class="box-top"></div>
					<div class="box-content">
						<div class="option_box">
							<div class="top-heading group">
								<div class="left_float"><h4>Escolha o estilo da listagem dos produtos</h4></div>
								<div class="the-button">
										<input type="hidden" value="remote" id="deliverytype" name="deliverytype">
										<button onclick="doupdate();" id="run-button" class="input-btn" type="button">
											<div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?= $ROOTPATH ?>/media/css/i/lendo.gif" style="display: none;"></div>
											<div id="spinner-text"  >Salvar</div>
										</button>
									</div> 
							</div> 
							
								<div id="container_box">
									<div id="option_contents" class="option_contents"> 

										<div class="form-contain group">
											<!-- =============================   coluna esquerda   =====================================-->
											<div class="starts"> 
												<div style="clear:both;"class="report-head">Modelo Padrão <span class="cpanel-date-hint"><input value=""  <? if($modelo_produto ==""  ){echo "checked='checked'";}?>  type="radio" name="modelo_produto"   ></span></div>
												<div class="group" style="margin-bottom:40px;">
													<img src="<?= $ROOTPATH ?>/media/css/i/modelopadrao.jpg"   />
												</div> 
												
												<div style="clear:both;"class="report-head">Modelo Fit <span class="cpanel-date-hint"><input value="fit"  <? if($modelo_produto =="fit" ){echo "checked='checked'";}?> type="radio" name="modelo_produto"  ></span></div>
												<div class="group" style="margin-bottom:40px;">
													<img src="<?= $ROOTPATH ?>/media/css/i/modelofit.jpg"   />
												</div>
												
												<div style="clear:both;"class="report-head">Modelo Clean <span class="cpanel-date-hint"><input value="clean"  <? if($modelo_produto =="clean" ){echo "checked='checked'";}?> type="radio" name="modelo_produto"  ></span></div>
												<div class="group" style="margin-bottom:40px;">
													<img src="<?= $ROOTPATH ?>/media/css/i/modeloclean.jpg"   />
												</div> 
												
											</div>
											<!-- =============================   fim coluna esquerda   =====================================-->
											<!-- =============================   coluna direita   =====================================-->
											<div class="ends">
												<div style="clear:both;"class="report-head">Modelo Buttons <span class="cpanel-date-hint"><input value="buttons"  <? if($modelo_produto =="buttons"  ){echo "checked='checked'";}?> type="radio" name="modelo_produto"  ></span></div>
												<div class="group" style="margin-bottom:40px;">
													<img src="<?= $ROOTPATH ?>/media/css/i/modelobuttons.jpg"   />
												</div>	
												
												<div style="clear:both;"class="report-head">Modelo Classic <span class="cpanel-date-hint"><input value="classic"  <? if($modelo_produto =="classic"  ){echo "checked='checked'";}?> type="radio" name="modelo_produto"  ></span></div>
												<div class="group" style="margin-bottom:40px;">
													<img src="<?= $ROOTPATH ?>/media/css/i/modeloclassic.jpg"   />
												</div> 
												
												<div style="clear:both;margin-bottom:40px;" class="report-head">Novo estilo de listagem de produtos ? <span class="cpanel-date-hint"></span></div>
												<div class="group" style="margin-bottom:40px;">
													<a target="_blank" href="http://www.vipcomsites.com.br/setor-de-orcamento"><img src="<?= $ROOTPATH ?>/media/css/i/contato.jpg"   /></a>
												</div> 
												
											</div>
											<!-- =============================  fim coluna direita  =====================================-->
										</div> 
									</div>
								</div> 
					 
							</div>
					<div class="box-bottom"></div>
				</div>
			</div>
		</form>
			<div id="sidebar">
			</div>

		</div>
	</div> <!-- bd end -->
</div> <!-- bdw end -->
 
<script>
	function validador(){
		return true;
	}
</script>
<script>
	jQuery(document).ready(function(){  
		//jQuery(".outrosplanos").colorbox({inline:true, href:"#inline_outrosplanos"}); //width:"50%",
		jQuery(".caixabox").colorbox({ width:"70%",heigth:"70%"});
	});
</script>
<?php include template("manage_footer"); ?>