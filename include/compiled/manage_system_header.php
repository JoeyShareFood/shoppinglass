<?php include template("manage_header"); ?>

<style>


	/* inicio ofertas recentes modelo 2*/

	.clearfix:after {
	clear: both;
		content: " ";
		display: block;
		font-size: 0;
		height: 0;
		line-height: 0;
		visibility: hidden;
		width: 0;
	}
	.deal {
		background-color: #EBEBEB;
		background-image: -moz-linear-gradient(center top , #FAFAFA 0%, #EBEBEB 100%);
		border: 1px solid #CCCCCC;
		box-shadow: 1px 2px 3px 0 #CCCCCC;
		padding: 10px;
		position: relative;
	}
	.three_up {
		float: left;
		margin-bottom: 10px;
		margin-right: 12px;
		padding: 3px 0;
		width: 197px;
	}
	.deal .image {
		border: 1px solid #EBEBEB;
		margin-bottom: 3px;
	}


	.three_up .image .inner {
		height: 108px;
	} 
	.three_up .image .innerparceiro {

	} 

	.deal .image .inner {
		border: 3px solid white;
		overflow: hidden;
	}
	.deal .image .innerparceiro {
		border: 3px solid white;

	}


	.three_up .deal .info .title {
		height: 40px;
		overflow: hidden;
		color:#303030;
		font-size:12px;
	}


	.deal .info h3.title, .deal .info .title {
		color: #949494;
		font-size: 14px;
		font-weight: bold;
	}


	.deal .info .subtitle {
		color: #665252;
		font-size: 10px;
		height: 17px;
		margin-bottom: 4px;
	}

	.deal .info .timer {
		background: none repeat scroll 0 0 #EBEBEB;
		color: #6E6E6E;

		font-size: 11px;

		z-index: 10;
	}

	.deal .info .line {
		-moz-border-bottom-colors: none;
		-moz-border-image: none;
		-moz-border-left-colors: none;
		-moz-border-right-colors: none;
		-moz-border-top-colors: none;
		border-color: -moz-use-text-color -moz-use-text-color #CCCCCC;
		border-style: none none solid;
		border-width: 0 0 1px;
		float: left;
		height: 16px;
		margin: 0 10px;
		position: absolute;
		width: 90%;
		z-index: 0;
	}

	.deal .info .timer {
		color: #6E6E6E;
		font-size: 11px;
		position:absolute;
		margin-left:193px;
	}
	.deal .info .view-deal-button {
		background: none repeat scroll 0 0 #EBEBEB;

		padding-right: 10px;

		z-index: 10;
	}

	.button.small {
		border-width: 1px !important;
		font-size: 12px;
		padding: 6px 12px;
	}
	.button.encerrado {
		border-width: 1px !important;
		font-size: 12px;
		padding: 6px 12px;
		background-color: #FF7B06;
		background-image:-moz-linear-gradient(center top , #F8B376, #FF7B06);
		cursor:not-allowed;
		border: 1px solid #FF7B06;

	}

	.button {
		background-attachment: scroll;
		background-clip: padding-box !important;
		background-color: #369EC1;
		background-image: -moz-linear-gradient(center top , #80C1D8, #369EC1);
		background-origin: padding-box;
		background-position: 0 0;
		background-repeat: repeat;
		background-size: auto auto;
		border: 1px solid #369EC1;
		border-radius: 9px 9px 9px 9px;
		box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.5);
		color: white;
		cursor: pointer;
		display: inline-block;
		font-size: 14px;
		font-weight: bold;
		line-height: 1em;
		padding: 7px 16px;
		text-decoration: none;
		text-shadow: -1px -1px 0 rgba(0, 0, 0, 0.5);
	}
	.three_up.last {
		margin-right: 0;
	}


	.one_up .deal .info .line {
		border-bottom: 1px solid #cccccc; }

	.three_up .deal .line, .two_up .deal .line {
		display: none; }

	/* fim ofertas recentes modelo 2*/

</style>
<?
$num = rand(100, 500);
?>

 
														 
<div id="bdw" class="bdw">
	<div id="bd" class="cf">
		<div id="partner">
			<div class="dashboard" id="dashboard">
				<ul><?php echo mcurrent_system_layout(); ?></ul>
			</div>
			<div id="content" class="clear mainwide">
				<div class="clear box">
					<div class="box-top1"></div>
					<div class="box-content1">  
						<form method="post">  
						<div class="sect">  
								<div class="option_box">
							
									<div class="top-heading group">
										<div class="left_float"><h4>Alteração de Cabeçalho usando Imagem</h4>
										Usar imagem no cabeçalho:
										<input style="width:20px;" type="radio"  <? if($INI['header']['statusimagemheader'] =="Y" or $INI['cores']['cor']=="N"  ){echo "checked='checked'"; $check=true;}?>   value="Y"    id="statusimagemheader"  name="header[statusimagemheader]" > Sim &nbsp;<img style="cursor:help" class="tTip" title="Ao escolher a imagem salve a página no botão Salvar ao lado  " src="<?=$ROOTPATH?>/media/css/i/info.png">
										<input style="width:20px;" type="radio" <? if(!$check ){echo "checked='checked'";}?>  value="N" id="statusimagemheader"  name="header[statusimagemheader]" > Não  &nbsp; 
										 -  Se você marcar Sim, deve obrigatoriamente escolher uma imagem abaixo para servir como background do cabeçalho do site. Se marcar como Não, o sistema irá usar os campos de cores. clique em SALVAR após escolher a imagem
										</div>
										
										<div class="the-button" style="width:257px;">  
											<button  id="run-button" onclick="javascript:location.href='cores.php'" class="input-btn" type="button">
												 <div id="spinner-text"  >Voltar </div> 
											</button>
											<button onclick="doupdate();" id="run-button" class="input-btn" type="button">
												<div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?= $ROOTPATH ?>/media/css/i/lendo.gif" style="display: none;"></div>
												<div id="spinner-text"  >Salvar</div>
											</button>
											
										</div> 
										
									</div> 
									
									<!-- <a href="/vipmin/system/cores.php"><b> << Voltar</b></a>	--> 
									<div id="container_box">
										<div id="option_contents" class="option_contents"> 
											<div class="form-contain group" id="tabela-imagens">
												<div style="clear:both;"class="report-head">Enviar o meu próprio cabeçalho - Dimensão Sugerida: 2500px largura x 175px altura (depende de campo altura cabeçalho) <span class="cpanel-date-hint"></span></div>
												<div class="group">
												<!-- 
													<form action="<?php echo $INI['system']['wwwprefix'] ?>/include/upload.php?tipo=imagemheader" target="upload_target" method="POST" enctype="multipart/form-data"   onsubmit="startUpload();" >
														<div class="wholetip clear"></div>

														<div class="field" style="width: 100%">
															<input name="myfile" type="file" />
															<input type="submit" name="submitBtn"  class="formbutton" value="Upload" />
														</div>
														<input type="hidden" value="<?php echo $INI['system']['wwwprefix'] ?>" id="local" name="local">
														<input type="hidden" value="imagemheader" id="tipo" name="tipo">
													</form> 
													<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>                 
 --> 
												<div>
												<iframe allowTransparency ="true" frameborder="0" height="80"   scrolling="no" src="/vipmin/uploadheader.php?tipo=imagemheader"  id="upload"></iframe>  
												</div>				
														

													<?php
													$dir = WWW_ROOT . "/skin/padrao/header";
													$dh = opendir($dir);

													if ($dh) {
														while ($file = readdir($dh)) {
															 $marcado = " style='background:#fff'";
															
															if ($file == "." or $file == "..") {
																continue;
															}
															if($INI['header']['arquivo'] ==$file){ 
																$marcado = " style='background:#8EBAE7'";
															}
															
															?> 
															<div class="three_up" >
																<div class="deal clearfix" <?=$marcado?>>
																	<div class="pic"> 
																		 
																	</div>
																	<div class="image">
																		<div class="inner">
																			<div> 
																				<img  style="width:169px;height:114px;"  src="<?= $ROOTPATH ?>/skin/padrao/header/<?= $file ?>"  />
																			</div>
																		</div>
																	</div>
																	<div class="info" <?=$marcado?>>
																		<div class="title">
																			<div class="price-tag"></div>
																			 <?php echo $file; ?> 
																			<a href="javascript:excluir('<?= $file ?>');"><br><font size="1">Excluir</font></a>
																		</div>
																		<div class="line"></div> 
																		<div class="view-deal-button" style="background:#fff;">
																		<input style="width:20px;" type="radio"  <? if($INI['header']['arquivo'] ==$file){echo "checked='checked'";}?>   value="<?= $file ?>"    id="arquivo"  name="header[arquivo]" >   
																		<!-- <a class="button small" href="javascript:mudarfundo('<?= $file ?>');">Quero este</a> -->
																		</div>
																	</div>
																</div>
															</div>

															<?
														}
													}
													?>
												</div> 
											</div>
										</div>
									</div>
								</div>
						</div> 
						</form>
					</div>
				</div>

				<div id="sidebar">

				</div>
			</div>
		</div> <!-- bd end -->
	</div> <!-- bdw end -->

 <script>
	function validador(){
	  opcao = $("input[id=statusimagemheader]:checked").val();
	  if(opcao == "N"){
		if(!confirm("O campo 'usar imagem no cabeçalho' não está ativado. Tem certeza disso ?")){
			return false;
		}
	  }
		return true;
	}
</script>

	<script>

	/*
		function mudarfundo(file){

		 
			jQuery(document).ready(function(){   
				jQuery.colorbox({html:"<font> Estamos alterando. Por favor, aguarde...</font>"});
			});
			 
			
			$.get("<?= $INI['system']['wwwprefix'] ?>/vipmin/update_background.php?file="+file+"&param=imagemheader",
 			
			function(data){
				if(jQuery.trim(data)==""){
					jQuery(document).ready(function(){   
						//jQuery.colorbox({html:"Header alterado com sucesso. Agora vá para a área pública e atualize a página (crtl+f5)"});
					});
		 
				}  
				else{
					jQuery(document).ready(function(){   
						jQuery.colorbox({html:data});
					});
				}
			});
		}
   */
   function excluir(file){
	jQuery.colorbox({html:"<font color=blue>O arquivo está sendo deletado...</font>"});
		$.get(WEB_ROOT+"/vipmin/delgal.php?file="+file+"&tipo=header",
					
		   function(data){
			  if(jQuery.trim(data)==""){
				//alert("Imagem apagada com sucesso");
				  location.href="/vipmin/system/header.php?acao=up";
			  }  
			  else{
				  alert(data)
			  }
		   });
	}

	</script>

	<script>

		function startUpload(){ 
			return true;
		}

		function stopUpload(success){
		 
			var result = ''; 
			if (success == 1){
				jQuery(document).ready(function(){   
				    //jQuery.colorbox({html:"<font color=blue>Enviando arquivo...</font>"});
					alert("O arquivo foi carregado com sucesso, clique em ok para atualizar a página. Após isso você poderá escolher esta imagem na lista.")
					 location.href="/vipmin/system/header.php?acao=up";
				});
				
			}   
			else if (success == 2){
 
				jQuery(document).ready(function(){   
					jQuery.colorbox({html:"<font color=red>O arquivo foi enviado com sucesso.</font>"});
				});
			} 
			else {
				jQuery(document).ready(function(){   
					jQuery.colorbox({html:"<font color=red>Não foi possível enviar o arquivo.</font>"});
				}); 
			} 
			return true;   
		}
 
	</script>
	
 
