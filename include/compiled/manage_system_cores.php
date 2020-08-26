<?php include template("manage_header"); ?>

<?
if ($INI['cores']['coresbackground1'] == "") {
	$INI['cores']['coresbackground1'] = "#9ebedc";
} 

if ($INI['cores']['corcabecalho'] == "") {
	$INI['cores']['corcabecalho'] = "#fff";
}

 if ($INI['cores']['corcabecalho'] == "") {
	$INI['cores']['corcabecalho'] = "#fff";
}  

if ($INI['cores']['menu-item-background'] == "") {
	$INI['cores']['menu-item-background'] = "#666";
}

 if ($INI['cores']['menu-item-background'] == "") {
	$INI['cores']['menu-item-background'] = "#666";
}  

if ($INI['cores']['itemhover'] == "") {
	$INI['cores']['itemhover'] = "#ee1b1d";
}

 if ($INI['cores']['submenu'] == "") {
	$INI['cores']['submenu'] = "#666";
} 

if ($INI['cores']['submenuback'] == "") {
	$INI['cores']['submenuback'] = "#efebeb";
} 

if ($INI['cores']['tamfonte'] == "") {
	$INI['cores']['tamfonte'] = "16";
} 

if ($INI['cores']['tamfonte'] == "") {
	$INI['cores']['tamfonte'] = "16";
}

 if ($INI['cores']['conditionsproduct'] == "") {
	$INI['cores']['conditionsproduct'] = "#f64c98";
}  

if ($INI['cores']['backgroundbox1'] == "") {
	$INI['cores']['backgroundbox1'] = "#f49495";
} 

if ($INI['cores']['backgroundbox2'] == "") {
	$INI['cores']['backgroundbox2'] = "#f6e6b6";
} 

if ($INI['cores']['linksheader'] == "") {
	$INI['cores']['linksheader'] = "#666";
}

 if ($INI['cores']['bt1'] == "") {
	$INI['cores']['bt1'] = "#d3100d";
}

 if ($INI['cores']['bt2'] == "") {
	$INI['cores']['bt2'] = "#d89295";
} 

 if ($INI['cores']['payment-price-old'] == "") {
	$INI['cores']['payment-price-old'] = "#ccc";
} 
?>

<style type="text/css" media="screen">
	.colorwell {
		border: 2px solid #fff;
		width: 6em;
		text-align: center;
		cursor: pointer;
	}
	body .colorwell-selected {
		border: 2px solid #000;
		font-weight: bold;
	}
</style>

<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		$('#demo').hide();
		var f = $.farbtastic('#picker');
		var p = $('#picker').css('opacity', 0.25);
		var selected;
		$('.colorwell')
		.each(function () { f.linkTo(this); $(this).css('opacity', 0.75); })
		.focus(function() {
			if (selected) {
				$(selected).css('opacity', 0.75).removeClass('colorwell-selected');
			}
			f.linkTo(this);
			p.css('opacity', 1);
			$(selected = this).css('opacity', 1).addClass('colorwell-selected');
		});
	});
</script>


<div id="bdw" class="bdw">
	<div id="bd" class="cf">
		<div id="partner"> 
			<div id="content" class="clear mainwide">
				<div class="clear box"> 
					<div class="box-content">   
						<div class="sect">
							<form method="post">  
								<div class="option_box">
									<div class="top-heading group">
										<div class="left_float"><h4>Alteração de cores do site - Após alterar, clique em salvar e atualize a área pública com ctrl + f5</h4></div>
										<div class="the-button" style="width:257px;">
										 	<button onclick="javascript:location='cores.php?template=08'" id="run-button" class="input-btn" type="button">
												 <div id="spinner-text"  >Restaurar Cores</div>
											</button>
											
											<button onclick="doupdate();" id="run-button" class="input-btn" type="button">
												<div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?= $ROOTPATH ?>/media/css/i/lendo.gif" style="display: none;"></div>
												<div id="spinner-text"  >Salvar</div>
											</button>
										</div> 
									</div>  
										
									<div id="container_box">
										<div id="option_contents" class="option_contents"> 
											<div class="form-contain group" id="tabela-imagens">
											 <span class="cpanel-date-hint">Note que se o componente ou elemento que você está tentando alterar a cor, e não conseguiu alterar por aqui, então possivelmente este componente não é um elemento de cor, e sim uma imagem. Para alterar imagens   <a href="/vipmin/system/imagens.php">Clique aqui</a></span>
											  
												<div id="picker"  style="opacity: 1; right: 50px; position: absolute; top: 322px;" ></div>	
												  
											<!-- ********************************************* BACKGROUND  --> 
												<div class="option_box">
													<div class="top-heading group">
														<div class="left_float"><h4>Background</h4></div>
													</div> 
													<div id="container_box">
														<div id="option_contents" class="option_contents">  
															<div class="form-contain group">
																<!-- =============================   coluna esquerda   =====================================-->
																<div class="starts"> 
																	<h1 style="font-size: 22px;">Escolha uma imagem para o seu Background </h1>
																	<!-- 
																	<div class="group">
																		<input style="width:20px;" type="radio"  <? if($INI['cores']['statusimagembackground'] =="Y" ){echo "checked='checked'";}?>   value="Y"    id="statusimagembackground" name="cores[statusimagembackground]"  > Sim  &nbsp;<img style="cursor:help" class="tTip" title="Se você marcar Sim, deve obrigatoriamente enviar uma imagem do seu computador para servir como background do fundo do site. Se marcar como Não, o sistema irá usar os campos de cores ao lado" src="<?=$ROOTPATH?>/media/css/i/info.png">
																		<input style="width:20px;" type="radio" <? if($INI['cores']['statusimagembackground'] =="N" or $INI['cores']['statusimagembackground'] ==""){echo "checked='checked'";}?>  value="N" id="statusimagembackground"  name="cores[statusimagembackground]"   > Não  &nbsp; 
																	 </div>	
																	-->
																	<div style="clear:both;"class="report-head">Usar uma imagem como background  <span class="cpanel-date-hint"><a href="javascript:buscafoto('fundobackgroundimagem.jpg');">Clique aqui </a> para ver </span>  </div>
																 	<div style="float:left;margin-right:5px;"><a href="/vipmin/system/background.php"> <img src="<?=$ROOTPATH?>/media/css/i/background.png"></a></div><div> <a href="/vipmin/system/background.php">Clique aqui</a> para usar nossos backgrounds prontos ou fazer upload de suas próprias imagens.    </div>
																	<br>  <br> 
																 	<div class="group">
																		<input style="width:20px;" type="checkbox"  <? if($INI['cores']['reapeathorizontal'] =="Y" ){echo "checked='checked'";}?>   value="Y"    id="reapeathorizontal" name="cores[reapeathorizontal]"  > Repetir na horizontal  &nbsp; 
																		<input style="width:20px;" type="checkbox" <? if($INI['cores']['reapeatvertical'] =="Y"){echo "checked='checked'";}?>  value="Y" id="reapeatvertical"  name="cores[reapeatvertical]"   > Você pode querer que a sua IMAGEM do background se repita na vertical (dependendo da sua altura), na horizontal ou em ambos até preencher toda a tela do computador. Geralmente usado para imagens pequenas  &nbsp; 
																	 </div>	
																	 
																 	<br> <br>   
														
																	<h1 style="font-size: 22px;clear: both;" >Ou escolha uma cor para o seu <b>Background</b> </h1>
																	<br> 
																	Usar cor no <B>Background</B>:
																	<input style="width:20px;" type="radio"  <? if($INI['background']['statusimagembackground'] =="N"  and $INI['cores']['corbackground'] =="Y"  ){echo "checked='checked'"; $check=true;}?>   id="corsimback" value="Y" name="cores[corbackground]" > Sim
																	<input style="width:20px;" type="radio" <? if( !$check){ echo "checked='checked'";}?> id="cornaoback"  value="N"  name="cores[corbackground]" > Não  &nbsp; 
																	 <!-- muda automaticamente-->
																	 <input type="hidden" value="<?=$INI['background']['statusimagembackground'] ?>" id="statusimagembackground"  name="background[statusimagembackground]" >
																	<input  type="hidden"  value="<?=$INI['background']['arquivo'] ?>" id="arquivo"  name="background[arquivo]" >   
																					
																	<script>
																	$(function(){
																		$("#corsimback").click(function(){      
																			 $('#statusimagembackground').val("N") ;
																		});
																		$("#cornaoback").click(function(){      
																		 $('#statusimagembackground').val("Y") ;
																		});
																	 });
																	</script>
																	<br> <br>  
														
																	<div style="clear:both;"class="report-head">Cor do Background <span class="cpanel-date-hint"><a href="javascript:buscafoto('fundobackgroundcor.jpg');">Clique aqui  </a>para ver </span></div>
																	 <div class="group">
																		 <div class="imgcores" style="margin-left:0px;"> 
																				<div style="float:left;"><input style="margin-left:19px; width: 80px;" type="text"  name="cores[coresbackground1]"  class="colorwell" value="<?php echo $INI['cores']['coresbackground1']; ?>"  /> cor 1  </div>
																		  </div>
																		 <br>
																	 </div>	
																	  
																	 
																	<br> 
																 </div>
																<!-- ============================= // fim coluna esquerda // =====================================-->
																<!-- ============================= // coluna direita // =====================================-->
																<div class="ends">  
															
																	 <div style="clear:both;"class="report-head">Extender 100% o Background <span class="cpanel-date-hint">Apenas para imagem   </span></div>
																	
																	 <div class="group">
																		<input style="width:20px;" type="radio"  <? if($INI['cores']['fixarbackground'] =="Y" ){ echo "checked='checked'";}?>   value="Y"    id="fixarbackground"  name="cores[fixarbackground]" > Sim  
																		<input style="width:20px;" type="radio" <? if($INI['cores']['fixarbackground'] =="N" or $INI['cores']['fixarbackground'] =="" ){echo "checked='checked'";}?>  value="N" id="fixarbackground"  name="cores[fixarbackground]" > Não  &nbsp; 
																	 </div>
																	
																	<br><br>
																	<h3>Fundo do Cabeçalho</h3>
																    
																   <div style="clear:both;"class="report-head">Cor do cabeçalho <span class="cpanel-date-hint"><a href="javascript:buscafoto('corcabecalho.jpg');">Clique aqui  </a>para ver </span></div>
																	 <div class="group">
																		 <div class="imgcores" style="margin-left:0px;"> 
																				<div style="float:left;"><input style="margin-left:19px; width: 80px;" type="text"  name="cores[corcabecalho]"  class="colorwell" value="<?php echo $INI['cores']['corcabecalho']; ?>"  /> cor 1  </div>
																		  </div>
																		 <br>
																	 </div>	
																	
																	<div style="clear:both;"class="report-head">Remover a cor do cabeçalho<span class="cpanel-date-hint">isso irá fazer a cor do fundo do cabeçalho usar a imagem do background  <a href="javascript:buscafoto('removecabeca.jpg');">Clique aqui  </a>para ver  </span></div>
																	
																	 <div class="group">
																		<input style="width:20px;" type="radio"  <? if($INI['cores']['header'] =="Y" ){ echo "checked='checked'";}?>   value="Y"    id="header"  name="cores[header]" > Sim   
																		<input style="width:20px;" type="radio" <? if($INI['cores']['header'] =="N" or $INI['cores']['header'] =="" ){echo "checked='checked'";}?>  value="N" id="header"  name="cores[header]" > Não  &nbsp; 
																	 </div>
																	 <br>
																	 
																	  
																	 <br>
																	 Para todas as opções que envolva imagem, a opção <b>Usar uma cor no background</b> deve estar desativada, caso contrário, será ignorado
																	<br>   
																</div>
																</div>
																<!-- ============================= // fim coluna direita // =====================================-->
															</div> 
														</div>
													</div>
													
													<!-- ======================== MENU  ====================-->
													
												<!-- ********************************************* MENU  --> 
												<div class="option_box">
													<div class="top-heading group">
														<div class="left_float"><h4>MENU</h4></div>
													</div> 
													<div id="container_box">
														<div id="option_contents" class="option_contents">  
															<div class="form-contain group" style="height:125px;">
																<!-- =============================   coluna esquerda   =====================================-->
																<div class="starts"> 
																 
															 		  <div class="blococores">
																		Menu Principal - Background <a href="javascript:buscafoto('menu-item-background.jpg');">clique aqui para ver</a>   
																	</div>
																	<div class="imgcores"> 
																		<div><input style="margin-left:19px; width: 80px;" type="text"  name="cores[menu-item-background]"  class="colorwell" value="<?php echo $INI['cores']['menu-item-background']; ?>"  />  </div>
																	</div> 
																 		
																	<div class="blococores">
																		 Menu Principal - Ao passar o mouse<a href="javascript:buscafoto('itemhover.jpg');">clique aqui para ver</a>  
																	</div>
																	<div class="imgcores"> 
																		<div><input style="margin-left:19px; width: 80px;" type="text"  name="cores[itemhover]"  class="colorwell" value="<?php echo $INI['cores']['itemhover']; ?>"  />  </div>
																	</div> 		
																	
																	<div class="blococores">
																		Sub Menu  <a href="javascript:buscafoto('submenu.jpg');">clique aqui para ver</a>  
																	</div>
																	<div class="imgcores"> 
																		<div><input style="margin-left:19px; width: 80px;" type="text"  name="cores[submenu]"  class="colorwell" value="<?php echo $INI['cores']['submenu']; ?>"  />  </div>
																	</div> 
																	
																	<div class="blococores">
																		Sub Menu - Backgroung  <a href="javascript:buscafoto('submenuback.jpg');">clique aqui para ver</a>  
																	</div>
																	<div class="imgcores"> 
																		<div><input style="margin-left:19px; width: 80px;" type="text"  name="cores[submenuback]"  class="colorwell" value="<?php echo $INI['cores']['submenuback']; ?>"  />  </div>
																	</div> 
																	
																	  <div class="blococores">
																		Tamanho da fonte - Menu Principal  <a href="javascript:buscafoto('tamfonte.jpg');">clique aqui para ver</a>    
																	</div>
																	<div class="imgcores"> 
																		<div><input style="margin-left:19px; width: 80px;" type="text"  name="cores[tamfonte]"  class="colorwell" value="<?php echo $INI['cores']['tamfonte']; ?>"  /> Diminua o número caso queira mais itens no menu  </div>
																	</div> 
																 
																  </div>
																<!-- ============================= // fim coluna esquerda // =====================================-->
																<!-- ============================= // coluna direita // =====================================-->
																<div class="ends">  
																 		
															
														 
															   
																</div>
																</div>
																<!-- ============================= // fim coluna direita // =====================================-->
															</div> 
														</div>
													</div>
													 
												  
													
												<!-- ********************************************* OURTOS   -->
												<div class="option_box">
													<div class="top-heading group">
														<div class="left_float"><h4>Outras Cores </h4></div>
													</div> 
													<div id="container_box">
														<div id="option_contents" class="option_contents">  
															<div class="form-contain group" style="height:228px;"> 
																<div class="starts"> 
																 
																	 <div class="blococores">
																	 Condições do Produto <a href="javascript:buscafoto('conditionsproduct.jpg');">Clique aqui para ver</a>  	 
																	</div>
																	<div class="imgcores">	<input style="margin-left:19px; width: 80px;" type="text"  name="cores[conditionsproduct]"  class="colorwell" value="<?php echo $INI['cores']['conditionsproduct']; ?>"  /> </div>
																	
																	<div class="blococores">
																		Background box esquerda home: <a href="javascript:buscafoto('backgroundbox1.jpg');">Clique aqui para ver</a>  	 
																	</div>
																	<div class="imgcores">	<input style="margin-left:19px; width: 80px;" type="text"  name="cores[backgroundbox1]"  class="colorwell" value="<?php echo $INI['cores']['backgroundbox1']; ?>"  /> </div>
																				
																	<div class="blococores">
																		Background box direta home: <a href="javascript:buscafoto('backgroundbox2.jpg');">Clique aqui para ver</a>  	 
																	</div>
																	<div class="imgcores">	<input style="margin-left:19px; width: 80px;" type="text"  name="cores[backgroundbox2]"  class="colorwell" value="<?php echo $INI['cores']['backgroundbox2']; ?>"  /> </div>
																	  
																	
															 
																  </div> 
																	<div class="ends">  
																	 
																	 <div class="blococores">
																		 Textos do Cabeçalho : <a href="javascript:buscafoto('linksheader.jpg');">Clique aqui para ver</a>  	 
																	</div>
																	<div class="imgcores">	<input style="margin-left:19px; width: 80px;" type="text"  name="cores[linksheader]"  class="colorwell" value="<?php echo $INI['cores']['linksheader']; ?>"  /> </div>
																			
																 					
																	<div class="blococores">
																		Botões: <a href="javascript:buscafoto('bt1.jpg');">Clique aqui para ver</a>   
																	</div>
																	<div class="imgcores">	
																		<input style="margin-left:19px; width: 80px;" type="text"  name="cores[bt1]"  class="colorwell" value="<?php echo $INI['cores']['bt1']; ?>"  /> 
																		ao passar o mouse: <input style="margin-left:19px; width: 80px;" type="text"  name="cores[bt2]"  class="colorwell" value="<?php echo $INI['cores']['bt2']; ?>"  /> 
																	</div>
																  
																     <div class="blococores">
																		Preço antigo:   
																	</div>
																	<div class="imgcores">	<input style="margin-left:19px; width: 80px;" type="text"  name="cores[payment-price-old]"  class="colorwell" value="<?php echo $INI['cores']['payment-price-old']; ?>"  /> </div>
																   
																   <div class="blococores">
																		Cor dos textos internos:   
																	</div>
																	<div class="imgcores">	<input style="margin-left:19px; width: 80px;" type="text"  name="cores[corinterno]"  class="colorwell" value="<?php echo $INI['cores']['corinterno']; ?>"  /> </div>
																 
															 	 
																	<div style="margin-top: 46px;">
																			Note que se o componente ou elemento que você está tentando alterar a cor, e não conseguiu alterar por aqui, então possivelmente este componente não é um elemento de cor, e sim uma imagem
																			Para alterar imagens <a href="/vipmin/system/imagens.php">Clique aqui</a>.
																			Opcionalmente você pode alterar qualquer elemento seja cor ou imagem via código fonte utilizando códigos html ou css acessando o seu FTP diretamente no servidor  <a target="_blank" href="http://www.youtube.com/watch?feature=player_embedded&v=sWmklZh5dqc">Veja nosso vídeo</a> 
																	</div> 
															   
																</div>
																</div> 
															</div> 
														</div>
													</div> 
													 
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
 
 <script>   
		function stopUpload(file,param){
		 
			var result = '';
			if (file != ""){
				jQuery(document).ready(function(){    
					$.get("<?= $INI['system']['wwwprefix'] ?>/vipmin/update_background.php?file="+file+"&param="+param,
					function(data){
						if(jQuery.trim(data)==""){
							jQuery(document).ready(function(){ 
								if(param=="imagemheader"){
									jQuery.colorbox({html:"<font color=blue>O arquivo foi carregado com sucesso. Agora vá para a área pública e atualize a página (crtl+f5)</font>"});
								 }
								else{
									jQuery.colorbox({html:"<font color=blue>O arquivo foi carregado com sucesso. Agora vá para a área pública e atualize a página (crtl+f5)</font>"});
								}
							}); 
						}  
						else{
							jQuery(document).ready(function(){   
								 
							});
						}
					});
					//location.href="/vipmin/system/cores.php";
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
 