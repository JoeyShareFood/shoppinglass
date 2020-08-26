<?php include template("manage_anunciante_header");?>
<style>
	#log_tools {
		float: none;
	}
	h4 {
		
		margin-top: 15px !important;
		margin-left: 0px !important;
	}
	.btn {
		margin-top:10px;
		margin-bottom:10px;
	}
</style>
<div id="partner" class="container-fluid"> 
    <div id="content" class="coupons-box clear mainwide row">
		<div class="box clear col-md-12 col-xs-12 col-sm-12"> 
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_system('index'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content"> 
                <div class="sect">
                    <form method="post" enctype="multipart/form-data">
					<div class="option_box">
						<div class="top-heading group">
							<div class="col-md-10 col-xs-12 col-sm-12">
								<h4>
									Personalize sua lojinha
								</h4>
							</div>
							<div class="col-md-2 col-xs-12 col-sm-12"> 
								<button onclick="doupdate();" id="run-button" class="btn btn-success btn-block" type="button">
									Salvar
								</button>
							</div> 
						</div> 
						<div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="form-contain group">
									<!-- =============================   coluna esquerda   =====================================-->
									<div class="starts" style="display:none;"> 
										<div style="clear:both;"class="report-head">Email do PayPal (Deve ser o mesmo utilizado para acessar a conta):</div>
										<div class="group" style="">
											<input type="text" id="pagseguro" name="pagseguro" class="form-control" value="<?php echo $info['pagseguro']; ?>" /> 
										</div>
									 	
										<div style="clear:both; margin-top:2%;"class="report-head">Dados bancários (Informe os dados completos):</div>
										<div class="group" style="">
											<textarea id="dados_bancarios" name="dados_bancarios" cols="68" rows="12"><?php echo $info['dados_bancario']; ?></textarea> 
										</div>								 
										 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends" style="display:none;">			 
										<div style="clear:both;"class="report-head">Observações (Caso queira informar algo ao dono do site) :</span></div>
										<div class="group" style="">
											<textarea id="observacoes" name="observacoes" cols="68" rows="12"><?php echo $info['observacoes']; ?></textarea>  
										</div>		
									 </div>									
									 <div class="ends col-md-6 col-xs-12 col-sm-12">											
									 	<div style="clear:both;"class="report-head">Dê um nome para a sua lojinha:</div>	
									 		<span style="font-style:italic;font-size:12px;"> Ex: Lojinha da Bia, Desapegos do Rafael, etc. </span>		
											<div class="group" style="margin-top:5px;">											
												<input type="text" id="login" name="login" maxlength="100" class="form-control" value="<?php echo $login_user['login']; ?>" /> 	
											</div>
										<div style="clear:both; margin-top:2%;" class="report-head">Escolha uma imagem de capa (não pode conter telefone, urls e nem emails, beleza?):</span></div>
										<div class="group" style="margin-top:25px;">
											<input id="banner" type="file" value="" name="banner" style="border: 1px solid #C1D0D3; color: #666666;padding-left:0px;">  
											<?php if(!(empty($info['banner']))) { ?><p class="hidden-xs hidden-sm"><?php echo $ROOTPATH . "/media/" . $info['banner']; ?></p><?php } ?>
										</div>												
										<div style="clear:both; margin-top:2%;"class="report-head">Carregue sua foto de perfil:</span></div>
										<div class="group" style="">
											<input id="logo" type="file" value="" name="logo" style="border: 1px solid #C1D0D3; color: #666666;padding-left:0px;">  
											<?php if(!(empty($info['logo']))) { ?><p class="hidden-xs hidden-sm"><?php echo $ROOTPATH . "/media/" . $info['logo']; ?></p><?php } ?>
										</div>		
									 </div>
									 <?php if($flag == 1) { ?>
									 	<input type="hidden" name="action" id="action" value="editar">
									 <?php }?>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div>
					</div> 					
                    </form>
                </div>
            </div>
            <div class="box-bottom"></div>
        </div>
	</div>

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
 
