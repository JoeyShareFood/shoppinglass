<?php include template("manage_header");?>
<?php require("ini.php");?> 
 
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div id="content" class="clear mainwide">
        <div class="clear box"> 
            <div class="box-content">
                <div class="sect">
					<form id="login-user-form" method="post" action="/vipmin/user/edit.php?id=<?php echo $user['id']; ?>" enctype="multipart/form-data" class="validator">
					<input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
					<input type="hidden" name="adminnew" value="<?php echo $_REQUEST['adminnew']; ?>" />
					<input type="hidden" name="www" id="www"  value="<?=$INI['system']['wwwprefix']?>" /> 
					<div class="option_box">
						<div class="top-heading group">
							<div class="left_float"><h4>Informações do Cliente</h4></div>
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
										<div style="clear:both;"class="report-head">Nome: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input type="text" name="realname"   id="realname" class="format_input ckeditor" value="<?php echo $user['realname'] ?>" /> 
										</div>
										
										 <div style="clear:both;"class="report-head">Login: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input type="text" name="username"    id="username" class="format_input ckeditor" value="<?php echo $user['username'] ?>" /> 
										</div>
										<? if(!$_REQUEST['adminnew']){?>	 
										<div style="clear:both;"class="report-head">CPF / CNPJ: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input type="text" name="cpf"  id="cpf" class="format_input ckeditor" value="<?php echo $user['cpf'] ?>" /> 
										</div>	
										<?}?>
										
										<div style="clear:both;"class="report-head">Telefone: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input type="text" name="mobile"   id="mobile" class="format_input ckeditor" value="<?php echo $user['mobile'] ?>" /> 
										</div>
										 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends"> 	 		 
									
										<div style="clear:both;"class="report-head">Email: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input type="text" name="email" id="email" class="format_input ckeditor" value="<?php echo $user['email'] ?>" /> 
										</div>		
										
										<div style="clear:both;"class="report-head">Senha: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input type="text" name="password" id="password" class="format_input ckeditor" value="" /> 
										</div>	 
										 										<div style="clear:both;"class="report-head">Comissão: <span class="cpanel-date-hint"></span></div>										<div class="group">											<input type="text" maxlength="2" onKeyPress="return SomenteNumero(event);"  name="comissao" class="format_input ckeditor" value="<?php echo $user['comissao']; ?>" />  &nbsp;<img class="tTip" title="Forneça o valor em porcentagem de quanto o site irá receber a cada pedido de anúncios pertencentes a este usuário." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 										</div> 	
									 
										<? if(!$_REQUEST['adminnew']){?>
										<div class="group">
											<div style="clear:both;"class="report-head">Administrador: <span class="cpanel-date-hint"></span></div>
											<input style="width:20px;" type="radio" <? if($user['manager'] =="Y" ){echo "checked='checked'";}?>  value="Y" name="manager" > Sim  &nbsp; <img class="tTip" title="Após configurar o administrador, você deve dar as permissões de acesso na consulta de administrador. Note que algumas ferramentas do sistema é acessado apenas pelo administrador master." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> </div>  
											<input style="width:20px;" type="radio" <? if($user['manager'] =="N" or $user['manager'] ==""){echo "checked='checked'";}?>   name="manager" value="N"> Não  
										 </div>
										 <?
										 } else {?>
											<input  type="hidden" value="Y" name="manager" >
										 <?}?>									  
									 </div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div> 
					
			<!-- ********************************************* ABA  endereços  --> 
				<? if(!$_REQUEST['adminnew']){?>
				<div class="option_box">
					<div class="top-heading group"> <div class="left_float"><h4>Dados de endereço </h4> </div>  </div>  
					 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group"> 
								<div class="starts"> 
								 
									<div style="clear:both;"class="report-head">Endereço completo: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="address"   id="address" class="format_input ckeditor" value="<?php echo $user['address'] ?>" /> 
									</div> 
									 		 
									<div style="clear:both;"class="report-head">Bairro <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="bairro"  id="bairro" class="format_input ckeditor" value="<?php echo $user['bairro'] ?>" /> 
									</div>	
									  
									<div style="clear:both;"class="report-head">Cep: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="zipcode" id="zipcode" class="format_input ckeditor" value="<?php echo $user['zipcode'] ?>" /> 
									</div>	
								</div>
								<!-- =============================   fim coluna esquerda   =====================================-->
								<!-- =============================   coluna direita   =====================================-->
								<div class="ends"> 	 		 
								 
									<div style="clear:both;"class="report-head">Estado: <span class="cpanel-date-hint"></span></div>
									<div class="group">
									 		<select  style="height: 27px; width: 672px;" name="estado" id="estado" onchange="$('#select_estado').text($('#estado').find('option').filter(':selected').text())"> 
													<option <? if($user['estado'] == "AC" ){ echo "selected"; }?> value="AC">AC</option>  
													<option <? if($user['estado'] == "AL" ){ echo "selected"; }?> value="AL">AL</option>  
													<option <? if($user['estado'] == "AM" ){ echo "selected"; }?> value="AM">AM</option>  
													<option <? if($user['estado'] == "AP" ){ echo "selected"; }?> value="AP">AP</option>  
													<option <? if($user['estado'] == "BA" ){ echo "selected"; }?> value="BA">BA</option>  
													<option <? if($user['estado'] == "CE" ){ echo "selected"; }?> value="CE">CE</option>  
													<option <? if($user['estado'] == "DF" ){ echo "selected"; }?> value="DF">DF</option>  
													<option <? if($user['estado'] == "ES" ){ echo "selected"; }?> value="ES">ES</option>  
													<option <? if($user['estado'] == "GO" ){ echo "selected"; }?> value="GO">GO</option>  
													<option <? if($user['estado'] == "MA" ){ echo "selected"; }?> value="MA">MA</option>  
													<option <? if($user['estado'] == "MG" ){ echo "selected"; }?> value="MG">MG</option>  
													<option <? if($user['estado'] == "MS" ){ echo "selected"; }?> value="MS">MS</option>  
													<option <? if($user['estado'] == "MT" ){ echo "selected"; }?> value="MT">MT</option>  
													<option <? if($user['estado'] == "PA" ){ echo "selected"; }?> value="PA">PA</option>  
													<option <? if($user['estado'] == "PB" ){ echo "selected"; }?> value="PB">PB</option>  
													<option <? if($user['estado'] == "PE" ){ echo "selected"; }?> value="PE">PE</option>  
													<option <? if($user['estado'] == "PI" ){ echo "selected"; }?> value="PI">PI</option>  
													<option <? if($user['estado'] == "PR" ){ echo "selected"; }?> value="PR">PR</option>  
													<option <? if($user['estado'] == "RJ" ){ echo "selected"; }?> value="RJ">RJ</option>  
													<option <? if($user['estado'] == "RN" ){ echo "selected"; }?> value="RN">RN</option>  
													<option <? if($user['estado'] == "RO" ){ echo "selected"; }?> value="RO">RO</option>  
													<option <? if($user['estado'] == "RR" ){ echo "selected"; }?> value="RR">RR</option>  
													<option <? if($user['estado'] == "RS" ){ echo "selected"; }?> value="RS">RS</option>  
													<option <? if($user['estado'] == "SC" ){ echo "selected"; }?> value="SC">SC</option>  
													<option <? if($user['estado'] == "SE" ){ echo "selected"; }?> value="SE">SE</option>  
													<option <? if($user['estado'] == "SP" ){ echo "selected"; }?> value="SP">SP</option>  
													<option <? if($user['estado'] == "TO" ){ echo "selected"; }?> value="TO">TO</option> 
											</select> 
									</div>	 
									 
									 <div style="clear:both;"class="report-head">Cidade: <span class="cpanel-date-hint"></span></div>
									<div class="group">
										<input type="text" name="cidadeusuario"  id="cidadeusuario" class="format_input ckeditor" value="<?php echo $user['cidadeusuario'] ?>" /> 
									</div> 
									<? if($user['id']!="" and !empty($user['create_time'])){?>
										<div style="clear:both;"class="report-head">Data do cadastro: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input type="text" name="create_time"  id="create_time" readonly="readonly" class="format_input ckeditor" value="<?php echo date('d/m/Y H:i', $user['create_time']); ?> " /> 
										</div> 
									<? } ?> 
								 </div>
							</div> 
						</div> 
					</div>
				</div> 
				 <!-- ********************************************* ABA local --> 
				 
				<div class="option_box">
					<div class="top-heading group"> <div class="left_float"><h4>Onde nos conheceu </h4> </div>  </div>  
					 
					<div id="container_box">
						<div id="option_contents" class="option_contents">  
							<div class="form-contain group"> 
								<div class="text_area">  
								<textarea cols="45" rows="5" name="local" style="width:100%" id="local" class="format_input ckeditor" ><?php echo htmlspecialchars($user['local']); ?></textarea>
								</div> 
							</div> 
						</div> 
					</div>
				</div>	 
				<? } ?>  				
				</form>
                </div>
            </div> 
        </div>
	</div> 
</div>
</div> 
<script>function doupdate(){	if(validador()){		$("#spinner-text").css("opacity", "0.2");		$("#spinner-text2").css("opacity", "0.2");		jQuery("#imgrec").show();		jQuery("#imgrec2").show();		document.forms[0].submit();	}}function campoobg(campo){ 	$("#"+campo).css("background", "#F9DAB7"); }
 
function validador(){
 
	limpacampos(); 

	if( jQuery("#realname").val()==""){

		campoobg("realname");
		alert("Por favor, informe o nome do cliente");
		jQuery("#realname").focus();
		return false;
	} 	
	if( jQuery("#username").val()==""){

		campoobg("username");
		alert("Por favor, informe o login do cliente");
		jQuery("#username").focus();
		return false;
	}
	if( jQuery("#email").val()==""){

		campoobg("email");
		alert("Por favor, informe o email do cliente");
		jQuery("#email").focus();
		return false;
	}
	if( jQuery("#email").val()==""){

		campoobg("email");
		alert("Por favor, informe o email do cliente");
		jQuery("#email").focus();
		return false;
	} 	
	if( jQuery("#ID").val()==""){
		if( jQuery("#password").val()==""){

			campoobg("password");
			alert("Por favor, informe a senha do cliente");
			jQuery("#password").focus();
			return false;
		} 
	}
	return true;	
}
 

</script>   