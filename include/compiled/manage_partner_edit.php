<?php include template("manage_header");?>
<?php require("ini.php");?> 
 
  

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div id="content" class="clear mainwide">
        <div class="clear box"> 
            <div class="box-content">
                <div class="sect">
				 <form id="login-user-form" method="post" action="/vipmin/parceiro/edit.php?id=<?php echo $partner['id']; ?>" enctype="multipart/form-data" class="validator">
				<input type="hidden" name="id" value="<?php echo $partner['id']; ?>" />
				<input type="hidden" name="www" id="www"  value="<?=$INI['system']['wwwprefix']?>" /> 
				<div class="option_box">
					<div class="top-heading group">
						<div class="left_float"><h4>Informações do Parceiro <?=$partner['id']?></h4></div>
							<div class="the-button">
								<input type="hidden" value="remote" id="deliverytype" name="deliverytype">
								<button onclick="doupdate();" id="run-button" class="input-btn" type="button">
									<div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div>
									<div id="spinner-text"  >Salvar</div>
								</button>
							</div> 
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents"> 
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts"> 
									<div style="clear:both;"class="report-head">Apelido: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="username"  maxlength="152" id="username" class="format_input ckeditor" value="<?php echo $partner['username'] ?>" />  <img style="cursor:help" class="tTip" title="Login usado pelo parceiro ao entrar na área do parceiro em http://dominio.com.br/lojista." src="<?=$ROOTPATH?>/media/css/i/info.png"> 
									</div> 	
									<div style="clear:both;"class="report-head">Senha: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="password"  maxlength="152" id="password" class="format_input ckeditor" />  <img style="cursor:help" class="tTip" title="Senha usado pelo parceiro ao entrar na área do parceiro em http://dominio.com.br/lojista. Deixe em branco para não alterar" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
									</div> 	
									<div style="clear:both;"class="report-head">Email: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="contact"  maxlength="152" id="contact" class="format_input ckeditor" value="<?php echo $partner['contact'] ?>"  />  <img style="cursor:help" class="tTip" title="Email pessoal do parceiro" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
									</div> 
									<div class="report-head">Nome do Parceiro: <span class="cpanel-date-hint"> Geralmente o nome fantasia da empresa</span></div>
									<div class="group">
										<input type="text" id="title" name="title" value="<?php echo  $partner['title'] ; ?>"> &nbsp;<img class="tTip" title="Este nome será apresentado na página de detalhes da oferta" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div>	
								   
								</div>
								<!-- =============================   fim coluna esquerda   =====================================-->
								<!-- =============================   coluna direita   =====================================-->
								<div class="ends"> 	 			 
									<div class="group">
									   <span class="report-label">Mostrar na aba tabs:</span>  
										<input style="width:20px;" type="radio" <? if($partner['display'] =="Y"  or $partner['display'] ==""){echo "checked='checked'";}?>  value="Y" name="display" > Mostrar  &nbsp;<img class="tTip" title="Se sim, será mostrado o mapa e informações do parceiro na aba 'Localidade Parceiro'. Cao não queira que mostre apenas o mapa, vá em Sistema->Configuração e desative o google maps" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">  
										<input style="width:20px;" type="radio" <? if($partner['display'] =="N"){echo "checked='checked'";}?>    name="display" value="N"> Não mostrar  
								 	</div> 
									<div class="report-head">Site: <span class="cpanel-date-hint">com http://</span></div>
									<div class="group">
										<input type="text" id="homepage" name="homepage" value="<?php echo  $partner['homepage'] ; ?>"> &nbsp;<img class="tTip" title="Endereço completo do site do parceiro com http://" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div> 
									<div class="report-head">Telefone fixo: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" id="phone" name="phone" value="<?php echo  $partner['phone'] ; ?>">   
									</div>
										<div class="report-head">Celular: <span class="cpanel-date-hint"> </span></div>
									<div class="group">
										<input type="text" id="mobile" name="mobile" value="<?php echo  $partner['mobile'] ; ?>">
									</div> 		
									<div class="report-head">Logo do parceiro: <span class="cpanel-date-hint"> Largura máxima: 300px</span></div>
									<div class="group">
										<input type="file" style="border: 1px solid #C1D0D3; color: #666666; width: 86%;" name="upload_image"  id="upload_image" class="format_input ckeditor"  /><?php if($partner['image']){?> <br><span style="clear:both;" class="cpanel-date-hint"> <?php echo team_image($partner['image']); ?> </span> <?php }?>
									</div>
									<div style="display:none;">					
										<div class="report-head">Imagem do parceiro: <span class="cpanel-date-hint"> Opcional </span></div>
										<div class="group">
											<input type="file" style="border: 1px solid #C1D0D3; color: #666666; width: 86%;" name="upload_image1"  id="upload_image1" class="format_input ckeditor"  /><?php if($partner['image1']){?> <br><span style="clear:both;" class="cpanel-date-hint"> <?php echo team_image($partner['image1']); ?> </span> <?php }?> &nbsp;<img class="tTip" title="Esta imagem fica ao lado da descrição do parceiro." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
										</div> 
									</div>
								 </div>
								<!-- =============================  fim coluna direita  =====================================-->
							</div> 
						</div>
					</div>
				</div>
				<!-- ********************************************* ABA Endereço do parceiro --> 
				<div class="option_box">
					<div class="top-heading group">
						<div class="left_float"><h4>Informações de endereço</h4></div>
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts">
								 
									<div style="clear:both;"class="report-head">Endereço: <span class="cpanel-date-hint">Ex: Rua Antônio Meireles</span></div>
									<div class="group">
										<input type="text" name="address"  id="address" class="format_input ckeditor"  value="<?php echo $partner['address'] ; ?>"   />  <img style="cursor:help" class="tTip" title="Este endereço será usado para localização do google maps automaticamente. Não informe no campo Endereço ítens como bloco, apto, sala , ou qualquer outro dado específico da localidade, não tem como o google achar sua sala ou seu apto. Informe esses dados no campo complemento." src="<?=$ROOTPATH?>/media/css/i/info.png"> 
									</div>  	
									
									<div style="clear:both;"class="report-head">Número: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="numero"  id="numero" class="format_input ckeditor"  value="<?php echo $partner['numero'] ; ?>"    /> 
									</div>  
									 	
									<div style="clear:both;"class="report-head">Complemento: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="chavesms"  id="chavesms" class="format_input ckeditor"  value="<?php echo $partner['chavesms'] ; ?>"  />  <img style="cursor:help" class="tTip" title="Informe neste campo os dados específicos da localidade. Ex: sala 401, loja 5, apto 787, etc..." src="<?=$ROOTPATH?>/media/css/i/info.png"> 
									</div> 	
									
									<div style="clear:both;"class="report-head">Bairro: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="bairro"  id="bairro" class="format_input ckeditor"  value="<?php echo $partner['bairro'] ; ?>"    />     
									</div> 	 
								</div>
								<!-- ============================= // fim coluna esquerda // =====================================-->
								<!-- ============================= // coluna direita // =====================================-->
								<div class="ends"> 
									
									<div style="clear:both;"class="report-head">Cidade: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="cidade"  id="cidade" class="format_input ckeditor"  value="<?php echo $partner['cidade'] ; ?>"   />     
									</div>  
									<div style="clear:both;"class="report-head">Cep: <span class="cpanel-date-hint">Caso o mapa não seja gerado, deixe o cep em branco.</span></div>
									<div class="group">
										<input type="text" name="cep" onKeyPress="return SomenteNumero(event);"  maxlength="8"  id="cep" class="format_input ckeditor"  value="<?php echo $partner['cep'] ; ?>"   />     
									</div>  
									<div class="group">
										<div class="report-head">Estado: <span class="cpanel-date-hint"></span></div>
										<div class="cjt-wrapped-select" id="type-select-cjt-wrapped-select">
											<select  name="estado" id="estado" onchange="$('#select_estado').text($('#estado').find('option').filter(':selected').text())"> 
													<option <? if($partner['estado'] == "AC" ){ echo "selected"; }?> value="AC">AC</option>  
													<option <? if($partner['estado'] == "AL" ){ echo "selected"; }?> value="AL">AL</option>  
													<option <? if($partner['estado'] == "AM" ){ echo "selected"; }?> value="AM">AM</option>  
													<option <? if($partner['estado'] == "AP" ){ echo "selected"; }?> value="AP">AP</option>  
													<option <? if($partner['estado'] == "BA" ){ echo "selected"; }?> value="BA">BA</option>  
													<option <? if($partner['estado'] == "CE" ){ echo "selected"; }?> value="CE">CE</option>  
													<option <? if($partner['estado'] == "DF" ){ echo "selected"; }?> value="DF">DF</option>  
													<option <? if($partner['estado'] == "ES" ){ echo "selected"; }?> value="ES">ES</option>  
													<option <? if($partner['estado'] == "GO" ){ echo "selected"; }?> value="GO">GO</option>  
													<option <? if($partner['estado'] == "MA" ){ echo "selected"; }?> value="MA">MA</option>  
													<option <? if($partner['estado'] == "MG" ){ echo "selected"; }?> value="MG">MG</option>  
													<option <? if($partner['estado'] == "MS" ){ echo "selected"; }?> value="MS">MS</option>  
													<option <? if($partner['estado'] == "MT" ){ echo "selected"; }?> value="MT">MT</option>  
													<option <? if($partner['estado'] == "PA" ){ echo "selected"; }?> value="PA">PA</option>  
													<option <? if($partner['estado'] == "PB" ){ echo "selected"; }?> value="PB">PB</option>  
													<option <? if($partner['estado'] == "PE" ){ echo "selected"; }?> value="PE">PE</option>  
													<option <? if($partner['estado'] == "PI" ){ echo "selected"; }?> value="PI">PI</option>  
													<option <? if($partner['estado'] == "PR" ){ echo "selected"; }?> value="PR">PR</option>  
													<option <? if($partner['estado'] == "RJ" ){ echo "selected"; }?> value="RJ">RJ</option>  
													<option <? if($partner['estado'] == "RN" ){ echo "selected"; }?> value="RN">RN</option>  
													<option <? if($partner['estado'] == "RO" ){ echo "selected"; }?> value="RO">RO</option>  
													<option <? if($partner['estado'] == "RR" ){ echo "selected"; }?> value="RR">RR</option>  
													<option <? if($partner['estado'] == "RS" ){ echo "selected"; }?> value="RS">RS</option>  
													<option <? if($partner['estado'] == "SC" ){ echo "selected"; }?> value="SC">SC</option>  
													<option <? if($partner['estado'] == "SE" ){ echo "selected"; }?> value="SE">SE</option>  
													<option <? if($partner['estado'] == "SP" ){ echo "selected"; }?> value="SP">SP</option>  
													<option <? if($partner['estado'] == "TO" ){ echo "selected"; }?> value="TO">TO</option> 
											</select> 
											<div name="select_estado" id="select_estado" class="cjt-wrapped-select-skin">Informe o estado parceiro</div>
											<div class="cjt-wrapped-select-icon"></div>
										</div>
									</div>
									 
										<input type="hidden" name="longlat"  id="longlat" class="format_input ckeditor"  value="<?php echo $partner['longlat'] ; ?>"   />         
									 
									
								 </div>
								</div>
								<!-- ============================= // fim coluna direita // =====================================-->
							</div> 
						</div>
					</div>
					
				 <!-- ********************************************* ABA menu navegação --> 
				<div class="option_box" id="abapagamento">
					<div class="top-heading group">
						<div class="left_float"><h4>Imagem da navegação</h4></div>
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts"> 
									<div class="group">
										<div style="clear:both;"class="report-head">Mostrar imagem na Navegação  <a href="javascript:buscafoto('parceironav.jpg');">clique para ver</a> <span class="cpanel-date-hint">  </span></div>
										<input style="width:20px;" type="radio" <? if($partner['imagemnavegacao'] =="Y"){echo "checked='checked'";}?>  value="Y" name="imagemnavegacao" > Sim  &nbsp;&nbsp;<img class="tTip" title="Assim como Categoria de Ofertas, você tambpem pode colocar este parceiro no menu de navegação. Note que existe um limite estético para a quantidade de imagens, sugerimos até 8." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">   
										<input style="width:20px;" type="radio" <? if($partner['imagemnavegacao'] =="" or $partner['imagemnavegacao'] =="N"){echo "checked='checked'";}?>   name="imagemnavegacao" value="N"> Não  &nbsp;
									 </div>	
									    <div class="txtinfo">Verifique sempre o limite estético. Dimensão: 90px largura x 39px altura.
										 </div>
								</div>
								<!-- ============================= // fim coluna esquerda // =====================================-->
								<!-- ============================= // coluna direita // =====================================-->
								<div class="ends"> 
								
								 	 <div style="clear:both;"class="report-head">Imagem da navegação: <span class="cpanel-date-hint">   <span class="cpanel-date-hint"><span id="dimensao">   </span> Dimensão: 90px largura x 39px altura  <a target="_blank" href="http://www.sistemacomprascoletivas.com.br/sistemacompracoletiva/nossos-produtos/marketing-propaganda/vipcom-arte/">Adquirir Artes</a> </span></div>
									  <div class="group"> 
											<input type="file" style="border: 1px solid #C1D0D3; color: #666666; width: 86%;" name="imagemparceiro"  id="imagemparceiro" class="format_input ckeditor"  />   
										</div>
									  <div class="txtinfo"> Note que, esta é uma área muito visível do seu site por isso, caso não tenha conhecimentos de edição de imagens, não tente criar e não coloque qualquer uma. Peça essa criação para um profissional. Para desativar este menu, vá no menu Sistema->Configurações (Ativar menu de parceiros)</div>
								 </div>
								 
								</div>
								<!-- ============================= // fim coluna direita // =====================================-->
							</div> 
						</div>
					</div>
				
				 <!-- ********************************************* ABA banner do parceiro --> 
				<div class="option_box"> 
					<div class="top-heading group"> <div class="left_float"><h4>Banner do Parceiro (953px de largura por 200px de altura)</h4> </div> &nbsp;<img class="tTip" title="Este banner irá aparecer somente quando o usuário acessar o link das ofertas do parceiro. Dimensão ideal 953px de largura por 200px de altura, você também pode colocar um código html clicando no ícone HTML." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div> 
					 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group"> 
								<div class="text_area">  
								<textarea cols="45" rows="5" name="bannerparceiro" style="width:100%" id="bannerparceiro" class="format_input ckeditor" ><?php echo htmlspecialchars($partner['bannerparceiro']); ?></textarea>
								</div> 
							</div> 
						</div> 
					</div>
				</div>	
				
					
					<!-- ********************************************* ABA Informações bancárias --> 
				<div class="option_box" id="abapagamento">
					<div class="top-heading group">
						<div class="left_float"><h4>Informações bancárias</h4></div>
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts"> 
									<div style="clear:both;"class="report-head">Nome do banco:  <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="bank_name" id="bank_name" class="format_input ckeditor" value="<?php echo  $partner['bank_name'] ; ?>" /> 
									</div>  	
									<div style="clear:both;"class="report-head">Agência:  <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="bank_user" id="bank_user" class="format_input ckeditor" value="<?php echo  $partner['bank_user'] ; ?>" /> 
									</div>  									
									<div style="clear:both;"class="report-head">Conta:  <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="bank_no" id="bank_no" class="format_input ckeditor" value="<?php echo  $partner['bank_no'] ; ?>" /> 
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
				     
					 <!-- ********************************************* ABA Descrição do parceiro --> 
					<div class="option_box">
						<div class="top-heading group"> <div class="left_float"><h4>Descrição do parceiro</h4> </div> &nbsp;<img class="tTip" title="DICA: Se você está copiando esta descrição de algum site ou documento, recomendamos primeiro copiar e colar no bloco de notas, logo em seguida, copie do bloco de notas e cole aqui no editor. Isto irá retirar todas as formatações indevidas. Uma vez que isto pode danificar o seu site." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div> 
						 
						<div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
									<div class="text_area">  
									<textarea cols="45" rows="5" name="descricao" style="width:100%" id="descricao" class="format_input ckeditor" ><?php echo htmlspecialchars($partner['descricao']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div>	 
					
					<!-- ********************************************* ABA Mais informações --> 
					<div class="option_box">
						<div class="top-heading group"> <div class="left_float"><h4>Outras Informações (opcional)</h4> </div> &nbsp;<img class="tTip" title="Informação apenas para controle interno. Não aparece no site" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div> 
						 <div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
									<div class="text_area">  
									<textarea cols="45" rows="5" name="other" style="width:100%" id="other" class="format_input ckeditor" ><?php echo htmlspecialchars($partner['other']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div> 
				</form>
                </div>
            </div> 
        </div>
	</div> 
</div>
</div> 
<script>
 
	 	
if( jQuery("#id").val() ==""){
	//$('#buyonce').val('N'); 
	//$('#select_buyonce').text("É possível comprar mais de uma oferta ou promoção")	
 
}
else{ 
	$('#select_estado').text($('#estado').find('option').filter(':selected').text());
	 
}
  
function validador(){
	
	limpacampos(); 

	if( jQuery("#username").val()==""){

		campoobg("username");
		alert("Por favor, informe o usuário do parceiro.");
		jQuery("#username").focus();
		return false;
	}
	 if( jQuery("#id").val() ==""){ 
		if( jQuery("#password").val()==""){

			campoobg("password");
			alert("Por favor, informe a senha do parceiro.");
			jQuery("#password").focus();
			return false;
		}
	}
  	if( jQuery("#contact").val()==""){

		campoobg("contact");
		alert("Por favor, informe o email do parceiro.");
		jQuery("#contact").focus();
		return false;
	}	
	if( jQuery("#title").val()==""){

		campoobg("title");
		alert("Por favor, informe o nome do parceiro.");
		jQuery("#title").focus();
		return false;
	}
  
	return true;	
}
 

</script>   
<script> 
	function buscafoto(foto){
		jQuery(document).ready(function(){
			jQuery.colorbox({
				href: WEB_ROOT + '/media/css/i/'+foto
			});
		});
		} 
 </script>