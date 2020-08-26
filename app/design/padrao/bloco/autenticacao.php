<?php  
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/app.php');
?>
 <?
$showMenu = true;
?>
<div style='display:none'>
 
	<div class="wm-sign-in clearfix"  id='inline_logar' >
		<div class="title">Hellooo!!! É muito bom ter você aqui</div>
		<div id="alert-signin-error" class="alert alert-danger alert-dismissable hide">
			<span class="icon-wm-warning"></span>&nbsp;<span id="message">Usuário ou senha inválidos.</span>
		</div>
		<div class="sign-in-wrapper"> 
			<fieldset><div class="label">Faça seu login ou cadastre-se agora mesmo</div>
				<div class="client-user-name">
					<span class="icon"></span>
					<input id="email" class="input-box inputs" style="height:33px;" type="email" maxlength="50" name="email" placeholder="E-mail" autocomplete="off">
					<!-- <span class="icon-wm-ok checkmark"></span>-->
				</div>
				<div class="client-pwd">
					<span class="icon"></span>
					<input id="password" type="password" style="width:238px;height:33px;"  class="input-box login-pwd inputs" maxlength="20" name="password" placeholder="Senha" autocomplete="off">
					 
					<button onclick="entrar();" id="signinButtonSend" class="btn btn-send btn-warning" name="signinButtonSend">
						<span class="icon-submit"></span>
					</button> 
				</div>
				<!-- <p><input class="remember-me" id="stay-connected" type="checkbox" value="true" name="connected"><label for="stay-connected">Continuar conectado</label></p>-->
				<p class="forgot-password"><a href="#" class="tk_esquecisenha">Esqueci minha senha</a></p>
			</fieldset>		 
		</div>
		<div class="sign-in-footer">Ainda não tem cadastro? <p class="sign-up-link">
			<a href="#" class="tk_cadastrar" id="btn-sign-up">Crie sua conta aqui.</a></p>
		</div>
	</div>

	<!-- DIV PARA CADASTRAR -->
	<div id='inline_cadastrar' style='padding:10px; background:#fff;height:490px !important; width:670px !important'>
	
		<img style="right:-10px;position:absolute;margin-top:56px;max-width:307px;display:none;" src="<?=$ROOTPATH?>/skin/padrao/images/imagemcadastro.jpg" > 
		<div style="float: left; width: 500px; margin-bottom: 15px;">
		<h2 style="font-size:25px;color:#666;">Legal, crie agora mesmo o seu login</h2>
		</div>
		<? if($INI['other']['admin_id_login'] != "" and $INI['other']['app_id_login'] != ""){ ?>
					<div class="loginface" style="margin-left:377px;margin-top:4px;height:31px;"><a href="<?=$ROOTPATH?>/autenticacao/fb/login_facebook.php"> <img  src="<?=$PATHSKIN?>/images/fb-connect-large.png"> </a></div>
		<? } ?>
			   
		 <form style="clear: both;" id="formcad" name="formcad"  METHOD="POST" action="autenticacao/login.php">
		   
			<div id="loading" style="display:none;clear: both;color:#666;font-size:12px;">  <div style="margin-left:20px;" id="txt"></div> </div>
			 
			<div style="float: left;clear: both;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Nome Completo*</span></div>
					 <input class="inputs" style="width:240px;font-size:12px;color:#666;margin-right:10px;" name="username" type="text"  id="username" />
			</div>
			<div>
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Escolha um nome para sua lojinha* <span style="font-size:10px;font-weight:bold;">Ex: Lojinha da Bia</span></span></div>
					<input class="inputs" style="width:298px;font-size:12px;color:#666;" name="logincadastro"  type="text"  id="logincadastro" onBlur="VerificaLogin();"  />
			</div> 
			<div>
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Digite seu email*</span></div>
					<input class="inputs" style="width:238px;font-size:12px;color:#666;" name="emailcadastro"  type="text"  id="emailcadastro" />
			</div> 
			<!-- 
			 <div style="float: left;clear: both;margin-right:20px;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:11px;">Informe o CPF ou CNPJ*</span></div>
					<input style="width:20px;" type="radio"  checked value="CPF" id="tipopessoa" name="tipopessoa" > <span style="font-family:verdana;color:#666;font-size:11px;">CPF  </span>
					<input style="width:20px;" type="radio"  value="CNPJ" id="tipopessoa" name="tipopessoa"> <span style="font-family:verdana;color:#666;font-size:11px;">CNPJ     </span>
			 </div>
			 -->
			 <div style="float: left;margin-right:10px;">
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Informe seu CPF ou CNPJ*</span></div>
				 <input onkeypress='mascaraMutuario(this,cpfCnpj)' onblur='clearTimeout()'  class="inputs" style="width:315px;font-size:12px;color:#666;"  name="cpf" id="doccpfcnpj" type="text" />
			 </div> 
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Onde nos conheceu?</span></div>
			 <input class="inputs" style="width:239px;font-size:12px;color:#666;"  name="local"   type="text" id="local"    />
			 </div>
		 
			<div class="meuendereco" style="clear: both;">   <img style="" src="<?=$ROOTPATH?>/skin/padrao/images/meuendereco.jpg">  </div>
			
			<div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Cep (apenas números)*</span></div>
				 <input class="inputs" style="width:316px;font-size:12px;color:#666;margin-right:10px;"  maxlength="8" onKeyPress="return SomenteNumero(event);" name="cep"  onblur="getEndereco();" type="text" id="cep"    />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Endereço*</span></div>
				 <input class="inputs" style="width:238px;font-size:12px;color:#666;"  name="endereco"   type="text" id="endereco"    />
			</div>
			
			 <div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Número*</span></div>
				 <input class="inputs" style="width:56px;font-size:12px;color:#666;margin-right:10px;"  name="numero"   type="text" id="numero"    />
			 </div> 
			 <div style="float: left;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Complemento</span></div>
				 <input class="inputs" style="width:231px;font-size:12px;color:#666;margin-right:10px;"  name="complemento"   type="text" id="complemento"    />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Bairro*</span></div>
				 <input class="inputs" style="width:232px;font-size:12px;color:#666;"  name="bairro"   type="text" id="bairro"    />
			</div>
			
			<div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Estado*</span></div> 
				<select class="inputselect"  name="estado" id="estado">
				<option value=""></option>
				<?php
					$sql = "SELECT  uf,nome FROM estados order by nome";
					$estados = mysql_query($sql) or die(mysql_error());
					while ($row = mysql_fetch_array($estados, MYSQL_ASSOC)) {
						if (strtoupper($login_user["entrega_estado"]) == strtoupper($row['uf'])) {
							$tmp_estado = $row['uf'];
							echo "<option value='{$row['uf']}' selected>".utf8_decode($row['nome'])."</option>";
						} else {
							echo "<option value='{$row['uf']}'>".utf8_decode($row['nome'])."</option>";		
						}
					}
				?>
				</select> 
					
			</div>
			
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Cidade*</span></div> 
				 <select class="inputselect"  name="cidadeusuario" id="cidadeusuario">
				<option value=""></option>
				<?php
					$SQL = "SELECT distinct nome FROM cidades order by nome";
					$cidades = mysql_query($SQL) or die(mysql_error());
					while ($row = mysql_fetch_array($cidades, MYSQL_ASSOC)) {
						if (utf8_decode(strtoupper($login_user["entrega_cidade"])) == strtoupper($row['nome'])) {
							$tmp_cidade = $row['nome'];
							echo "<option value='{$row['nome']}' selected>{$row['nome']}</option>";
						} else {
							echo "<option value='{$row['nome']}'>{$row['nome']}</option>";
						}
					}
				?>
				</select>  
			 </div>
		

			 <div style="float: left;clear: both;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Telefone* <span style="font-size:9px;"> Com DDD ex: (xx)xxxx-xxxx </span></span></div>
					 <input class="inputs" style="width:209px;font-size:12px;color:#666;margin-right:10px;"   maxlength="15" onkeypress='mascaraTelefone(this,telDig)' name="telefone" type="text" id="telefone"  />
			 </div>
			 <div style="float: left;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Crie sua senha*</span></div>
					 <input class="inputs" style="width:158px;font-size:12px;color:#666;margin-right:10px;height:12px;" name="passwordcad" type="password" id="passwordcad"  />
			 </div>
			<div>
				  <div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Redigite a senha*</span></div>
				  <input class="inputs" style="width:160px;font-size:12px;color:#666;height:12px;" name="password2"  type="password"  id="password2"   />
			</div>
			<div style="float: left;clear: both;">
				  <div > 
					<input class="inputs" style="width:20px;" type="checkbox" class="cinput" id="receberofertas" checked name="receberofertas"/> <span style="font-family:verdana;color:#666;font-size:12px;">Quero receber novidades por email</span>
				  </div> 
			</div>
			<div>
				  <span style="font-family:verdana;color:#666;font-size:12px;">    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;    * Campos obrigatórios</span> 
			</div> 
			<div style="padding-top: 20px;margin-right:23px; ">
				<a class="link-1" style="" href="javascript:cadastropop();"><em><b>Criar conta</b></em></a>
				<a href="#" style="margin-left:14px;font-family:verdana;color:#01AAB5;font-size:12px;" class="tk_logar cboxElement">  Já tenho cadastro, quero fazer login</a>
			 </div>  
			<? if($INI['option']['termosobrigatorio']=="Y"){ ?>
				<div style="color: #666; margin-top: 20px; line-height: 20px; font-size: 12px; float: left; margin-left: -103px;">
					<input class="inputs" style="width:20px;" type="checkbox" value="1" name="aceitardb2" id="aceitardb2"> Ao criar uma conta no <?php echo $INI['system']['sitename'];?> você concorda com a nossa Pol&iacute;tica de Privacidade. <a target="_blank" href="<?=$ROOTPATH?>/page/4/Politicas%20de%20Privacidade" style="color:#01AAB5;">Clique para ler</a>
				</div>
			<? } ?>
			
	  </div>
	
	
	  
	<!-- DIV PARA ALTERAR ENDEREÇO DE ENTREGA -->
	<div id='inline_altera_endereco' style='padding:10px; background:#fff;height:290px; width:870px !important'>
		<input type="hidden" name="idusuario_entrega" id="idusuario_entrega" value="<?=$login_user["id"]?>">
		<img style="right:4px;position:absolute;margin-top:64px;" src="<?=$ROOTPATH?>/skin/padrao/images/caminhao_entrega.png"> 
		<div style="clear:both;width:300px;margin-bottom: 14px;">
			<h2 style="font-size:25px;">Endereço de Entrega</h2>
		</div>
  
		 <form style="clear: both;" id="formcad" name="formcad"  METHOD="POST" action="autenticacao/login.php">
		   
			<div id="loading" style="display:none;clear: both;color:#666;font-size:12px;">   <div style="margin-left:20px;" id="txt"></div> </div>
			   
			<div style="float: left;clear: both; " >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Cep (apenas números)* <span class="txtmenor"><a style="text-decoration:underline;color: blue;" href="http://www.buscacep.correios.com.br/" target="_blank">Consultar CEP</a></span></span></div>
				 <input class="inputs" style="width:316px;font-size:12px;color:#666;margin-right:10px;"  onKeyPress="return SomenteNumero(event);" maxlength="8" name="cep_entrega"  onblur="getEndereco_altera('entrega');" type="text" id="cep_entrega"  value="<?=$login_user["entrega_cep"]?>"  />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Endereço*</span></div>
				 <input class="inputs" style="width:238px;font-size:12px;color:#666;"  type="text" id="endereco_entrega"  value="<?=utf8_decode($login_user["entrega_endereco"])?>"  />
			</div>
			
			 <div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Número*</span></div>
				 <input class="inputs" style="width:56px;font-size:12px;color:#666;margin-right:10px;"   type="text" id="numero_entrega" value="<?=$login_user["entrega_numero"]?>"   />
			 </div> 
			 <div style="float: left;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Complemento</span></div>
				 <input class="inputs" style="width:231px;font-size:12px;color:#666;margin-right:10px;"  type="text" id="complemento_entrega" value="<?=utf8_decode($login_user["entrega_complemento"])?>"   />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Bairro*</span></div>
				 <input class="inputs" style="width:232px;font-size:12px;color:#666;" type="text" id="bairro_entrega"  value="<?=utf8_decode($login_user["entrega_bairro"])?>"  />
			</div>
			<div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Estado*</span></div> 
				<select class="inputselect"  name="estado_entrega" id="estado_entrega">
				<option value=""></option>
				<?php
					$sql = "SELECT  uf,nome FROM estados";
					$estados = mysql_query($sql) or die(mysql_error());
					while ($row = mysql_fetch_array($estados, MYSQL_ASSOC)) {
						if (strtoupper($login_user["entrega_estado"]) == strtoupper($row['uf'])) {
							$tmp_estado = $row['uf'];
							echo "<option value='{$row['uf']}' selected>".utf8_decode($row['nome'])."</option>";
						} else {
							echo "<option value='{$row['uf']}'>".utf8_decode($row['nome'])."</option>";		
						}
					}
				?>
				</select> 
			</div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Cidade*</span></div>
					<select class="inputselect"  name="cidade_entrega" id="cidade_entrega">
						<option value=""></option>	
						<?php
							$SQL = "SELECT distinct nome FROM cidades order by nome";
							$cidades = mysql_query($SQL) or die(mysql_error());
							while ($row = mysql_fetch_array($cidades, MYSQL_ASSOC)) {
								if (utf8_decode(strtoupper($login_user["entrega_cidade"])) == strtoupper($row['nome'])) {
									$tmp_cidade = $row['nome'];
									echo "<option value='{$row['nome']}' selected>{$row['nome']}</option>";
								} else {
									echo "<option value='{$row['nome']}'>{$row['nome']}</option>";
								}
							}
						?>
					</select> 
			</div>
			<!-- 
			 <div style="clear: both;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Telefone*</span></div>
					 <input class="inputs" style="width:586px;font-size:12px;color:#666;margin-right:10px;" type="text" id="telefone_entrega" value="<?=$login_user["entrega_telefone"]?>" />
			 </div>
			 --> 
			<div>
				  <span style="font-family:verdana;color:#666;font-size:12px;">    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;    * Campos obrigatórios</span> 
			</div>  
			<div style="padding-top: 20px;float: left;margin-right:23px; ">
				<a class="link-1" style="" href="javascript:altera_enderecos('entrega');"><em><b>Alterar</b></em></a>
			</div>  
	  </div>
	  <!-- DIV PARA ALTERAR ENDEREÇO DE COBRANÇA  
	<div id='inline_altera_cobranca' style='padding:10px; background:#fff;height:290px; width:870px !important'>
		<input type="hidden" name="idusuario_cobranca" id="idusuario_cobranca" value="<?=$login_user["id"]?>">
		<img style="right:-10px;position:absolute;margin-top:56px;max-width:307px;" src="<?=$ROOTPATH?>/skin/padrao/images/imagemcadastro.jpg" title="Receba por email nossas ofertas de compra coletiva de até 90% de desconto" alt="Receba por email nossas ofertas de compra coletiva de até 90% de desconto"> 
		<div style="clear:both;width:300px;">
		<h2 style="font-size:25px;">Endereço de Cobrança</h2>
		</div>
  
		 <form style="clear: both;" id="formcad" name="formcad"  METHOD="POST" action="autenticacao/login.php">
		   
			<div id="loading" style="display:none;clear: both;color:#666;font-size:12px;"><img style="margin-left:100px;float: left;" src="<?=$PATHSKIN?>/images/ajax-loader2.gif"> <div style="margin-left:20px;" id="txt"></div> </div>
			   
			<div style="float: left;clear: both; " >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Cep (apenas números)*</span></div>
				 <input class="inputs" style="width:316px;font-size:12px;color:#666;margin-right:10px;" maxlength="8" onKeyPress="return SomenteNumero(event);"   name="cep_cobranca"  onblur="getEndereco_altera('cobranca');" type="text" id="cep_cobranca"  value="<?=$login_user["cobranca_cep"]?>"  />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Endereço*</span></div>
				 <input class="inputs" style="width:238px;font-size:12px;color:#666;"  type="text" id="endereco_cobranca"  value="<?=utf8_decode($login_user["cobranca_endereco"])?>"  />
			</div>
			
			 <div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Número*</span></div>
				 <input class="inputs" style="width:56px;font-size:12px;color:#666;margin-right:10px;"   type="text" id="numero_cobranca" value="<?=$login_user["cobranca_numero"]?>"   />
			 </div> 
			 <div style="float: left;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Complemento</span></div>
				 <input class="inputs" style="width:231px;font-size:12px;color:#666;margin-right:10px;"  type="text" id="complemento_cobranca" value="<?=utf8_decode($login_user["cobranca_complemento"])?>"   />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Bairro*</span></div>
				 <input class="inputs" style="width:232px;font-size:12px;color:#666;" type="text" id="bairro_cobranca"  value="<?=utf8_decode($login_user["cobranca_bairro"])?>"  />
			</div>
			<div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Cidade*</span></div>
				 <input class="inputs" style="width:318px;font-size:12px;color:#666;margin-right:10px;"   type="text" id="cidade_cobranca"  value="<?=utf8_decode($login_user["cobranca_cidade"])?>"  />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Estado*</span></div>
				 <input class="inputs" style="width:238px;font-size:12px;color:#666;"   type="text" id="estado_cobranca" value="<?=$login_user["cobranca_estado"]?>"   />
			</div>

			 <div style="clear: both;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#666;font-size:12px;">Telefone*</span></div>
					 <input class="inputs" style="width:586px;font-size:12px;color:#666;margin-right:10px;" type="text" id="telefone_cobranca" value="<?=$login_user["cobranca_telefone"]?>" />
			 </div>
	  
			<div>
				  <span style="font-family:verdana;color:#666;font-size:12px;">    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;    * Campos obrigatórios</span> 
			</div>
			   
		
			<div style="padding-top: 20px;float: left;margin-right:23px; ">
				<a class="link-1" style="" href="javascript:altera_enderecos('cobranca');"><em><b>Alterar</b></em></a>
			</div>  
	  </div>
	  -->
	  
	  
	<!-- DIV PARA ESQUECI SENHA -->
	 
	 <div id='inline_esquecisenha' style='background:#fff; height:110px; padding:10px; width:345px !important'>
		<div>
			<form method="POST" id="formauth" style="width: 345px !important">
				<div style="float: left; width: 235px;">
						<div style="margin-bottom: 5px;"><span style="color:#666;font-size:12px;">E-mail</span></div>
						<input class="inputs" type="text" value="Insira seu e-mail" onblur="if(this.value=='') this.value='Insira seu e-mail'" onfocus="if(this.value =='Insira seu e-mail' ) this.value=''" id="email" 	style="width:200px;font-size:12px;color:#666;margin-right:10px;"	name="email">
				 </div>
				<div style="float: left; padding-top: 20px; width: 88px;">
					<a class="link-1" style="" href="javascript:enviar();"><em><b>Enviar</b></em></a>
				</div>
				<div id="loading" style="clear: both;color:#666;font-size:12px;"> </div> 
				 
				<div style="margin-top: 10px; float: left; clear: both; width: 70px;,">
					<a href="#" style="color:#666;font-size:12px;" class="tk_logar cboxElement">voltar</a>
				</div>
			</form>
		</div>
   </div> 
  
</div>

	
<script language="javascript">
// post logar
function entrar(){
		 
	if(J("#email").val() == "" ||  J("#email").val() == "Insira seu e-mail"){ 
		alert("Por favor, informe seu email.");
		jQuery("#loading").html("");
		document.getElementById("email").focus();
		return false;
	}
	 
	if(J("#password").val() == ""){ 
		alert("Por favor, informe sua senha.");
		jQuery("#loading").html("");
		document.getElementById("password").focus();
		return false;
	}
 
  // jQuery("#loading").html("<img style=margin-left:80px; src=<?=$PATHSKIN?>/images/ajax-loader2.gif> <span style=margin-top:10px;color:blue;font-size:12px;> Estamos validando seus dados...</span>");
	 	
	J.ajax({
		   type: "POST",
		   cache: false,
		   async: false,
		   url: "<?php echo $INI['system']['wwwprefix']?>/autenticacao/login.php",
		   data: "acao=logintoupup&email="+J("#email").val()+"&password="+J("#password").val(),
		   success: function(user_id){
			
		   idusuario = jQuery.trim(user_id);
		   if(jQuery.trim(idusuario)=="00"){
		     
				 alert("Não foi possível fazer o seu login. Por favor, verifique os seus dados.");
				 jQuery("#loading").html("");
			 } 
		   else { 
			   
			  if(J("#utm").val()=="1"){
				  if(J("#tipooferta").val()=="participe"){
					participar(1);
				  }else{
					 enviapag() ;
				  }
			 }
			  else{
					jQuery.colorbox({html:"<font color='black'>Autenticação realizada com sucesso."});	
					location.href  = '<?php echo UrlAtual(); ?>';
			  }	
		   }		  
		}
	});
}

//post esqueci senha
function enviar(){
	  
	if(J("#email").val() == "" ||  J("#email").val() == "Insira seu e-mail" ){
	    alert("Por favor, informe seu email.");
		jQuery("#loading").html("");
		document.getElementById("email").focus();
		return;
	}
	 
  //jQuery("#loading").html("<img style=margin-left:50px; src=<?=$PATHSKIN?>/images/ajax-loader2.gif> Estamos validando seu email...");
  
	J.ajax({
		   type: "POST",
		   cache: false,
		   async: false,
		   url: "<?php echo $INI['system']['wwwprefix']?>/autenticacao/repass.php",
		   data: "email="+J("#email").val(),
		   success: function(retorno){
		   
		   if(jQuery.trim(retorno)==""){  
				alert("Sua senha foi enviada com sucesso para o seu email")
				//jQuery("#loading").html("Sua senha foi enviada com sucesso para o seu email");
				//location.href  = '<?php echo $INI['system']['wwwprefix']?>';
			 } 
		   else {
			 
			  	alert(retorno);
				jQuery("#loading").html("");
		   }
		}
	});
}
 
 //cadastro
 var idusuario;
 var tipopessoa;
 function cadastropop(){
	 
    var cpf="";
    var cnpj="";
    var errocnpj	=	true;
    var errocpf		=	true;
 
 <? if($INI['option']['termosobrigatorio']=="Y"){ ?>
		var aceitar='';
	  
		aceitar = J("input[type=checkbox][name=aceitardb2]:checked").val()
	  
		if( aceitar != "on" & aceitar != "1") {
				alert("Você precisa aceitar a política de privacidade para realizar o seu cadastro")
				return;
		}
	<? } ?>
	
    jQuery("#loading").hide();
	 
	if(J("#username").val() == ""){
	    alert("Por favor, informe seu nome.");
		jQuery("#loading").hide();
		document.getElementById("username").focus();
		return;
	}
	
	if(J("#logincadastro").val() == ""){
	    alert("Por favor, informe seu login.");
		jQuery("#loading").hide();
		jQuery("#logincadastro").val('');
		document.getElementById("logincadastro").focus();
		return;
	} else {
		if(VerificaLogin()) {
			return;		
		}	
	}
		
	if(J("#emailcadastro").val() == ""){
	    alert("Por favor, informe seu email.");
		jQuery("#loading").hide();
		document.getElementById("emailcadastro").focus();
		return;
	} 
	cpf = J("input[name*='cpf']" ).val();
	
	if( cpf == ""){
		alert("Informe o seu CPF ou CNPJ.")
		document.getElementById("doccpfcnpj").focus();
		return;
	}	 
	
	// validação de CPF e CNPJ
	cpf_valida =  cpf.replace("-","");
	cpf_valida =  cpf_valida.replace(".","");
	cpf_valida =  cpf_valida.replace(".","");
	 

	if( !validaCPF(cpf_valida)){   
		  if(validaCNPJ( cpf )){ // é usado o mesmo campo para cpf e cnpj
				tipopessoa = "CPF";
				errocnpj = false;
		  } 
	}
	else{ 
		errocpf= false;
		tipopessoa = "CPF";
		
	}	
	
	if( errocpf==true & errocnpj==true){
		 alert("CPF ou CNPJ inválido. Por favor, verifique e tente novamente.")
		 document.getElementById("doccpfcnpj").focus();
		 return; 
	}		
 	
	  
  // dados de enredeço
	 
	if(J("#cep").val() == ""){

		alert("Por favor, informe seu cep.");
		jQuery("#loading").hide();
		document.getElementById("cep").focus();
		return;
	}
	 if(J("#endereco").val() == ""){

		alert("Por favor, informe seu endereco.");
		jQuery("#loading").hide();
		document.getElementById("endereco").focus();
		return;
	} 
	if(J("#numero").val() == ""){

		alert("Por favor, informe o número.");
		jQuery("#loading").hide();
		document.getElementById("numero").focus();
		return;
	}
	if(J("#bairro").val() == ""){

		alert("Por favor, informe seu bairro.");
		jQuery("#loading").hide();
		document.getElementById("bairro").focus();
		return;
	}
	if(J("#cidadeusuario").val() == ""){

		alert("Por favor, informe sua cidade.");
		jQuery("#loading").hide();
		document.getElementById("cidadeusuario").focus();
		return;
	}
	if(J("#estado").val() == ""){

		alert("Por favor, informe seu estado.");
		jQuery("#loading").hide();
		document.getElementById("estado").focus();
		return;
	}	
	if(J("#telefone").val() == ""){

		alert("Por favor, informe seu telefone.");
		jQuery("#loading").hide();
		document.getElementById("telefone").focus();
		return;
	}
	if(J("#passwordcad").val() == ""){
	    alert("Por favor, informe sua senha.");
		jQuery("#loading").hide();
		document.getElementById("passwordcad").focus();
		return;
	}
	
	if(J("#password2").val() == ""){

		alert("Por favor, redigite sua senha.");
		jQuery("#loading").hide();
		document.getElementById("password2").focus();
		return;
	}
	
	if(J("#password2").val() != J("#passwordcad").val() ){
	    alert("Por favor, revise suas senhas, elas não conferem.");
		jQuery("#loading").hide();
		document.getElementById("password2").focus();
		return;
	}
	
	var checkreceber="";
	J(".cinput:checked").each(function(){
 
		checkreceber = ' [' + this.value + '] ';
	});
   
	J.ajax({
		   type: "POST",
		   cache: false,
		   async: false,
		   url: "<?php echo $INI['system']['wwwprefix']?>/autenticacao/login.php",
		   data: "acao=cadastro&logincadastro="+J("#logincadastro").val()+"&tipopessoa="+tipopessoa+"&telefone="+J("#telefone").val()+"&numero="+J("#numero").val()+"&cidadeusuario="+J("#cidadeusuario").val()+"&cep="+J("#cep").val()+"&endereco="+J("#endereco").val()+"&estado="+J("#estado").val()+"&complemento="+J("#complemento").val()+"&bairro="+J("#bairro").val()+"&cpf="+cpf+"&receberofertas="+checkreceber+"&username="+J("#username").val()+"&passwordcad="+J("#passwordcad").val()+"&emailcadastro="+J("#emailcadastro").val()+"&websites3="+J("#websites3").val()+"&local="+J("#local").val()+"&password2="+J("#password2").val(),
		   success: function(user_id){
		 
		   flag =  user_id.indexOf("Falha");
		 
			if(flag!=-1){ 
				 alert(user_id);
				jQuery("#loading").hide();
			} 
			else {  
			  J("#idusuario").val(user_id);
			  idusuario = jQuery.trim(user_id);
			    if(J("#utm").val()=="1"){
					  if(J("#tipooferta").val()=="participe"){
						participar(1);
					  }else{
						 enviapag() ;
					  }
				}
				  else{
					   jQuery.colorbox({html:"Realizamos seu cadastro com sucesso. "});
					   location.href  = '<?php echo UrlAtual(); ?>';
				  }	 	
			 }
		}
	});	
}


//altera endereço entrega
 function altera_enderecos(tipo){
	   
	if(J("#cep_"+tipo).val() == ""){

		alert("Por favor, informe seu cep.");
		jQuery("#loading").hide();
		document.getElementById("cep_"+tipo).focus();
		return;
	} 
	 if(J("#endereco_"+tipo).val() == ""){

		alert("Por favor, informe seu endereco.");
		jQuery("#loading").hide();
		document.getElementById("endereco_"+tipo).focus();
		return;
	} 
	if(J("#numero_"+tipo).val() == ""){

		alert("Por favor, informe o número.");
		jQuery("#loading").hide();
		document.getElementById("numero_"+tipo).focus();
		return;
	}
	if(J("#bairro_"+tipo).val() == ""){

		alert("Por favor, informe seu bairro.");
		jQuery("#loading").hide();
		document.getElementById("bairro_"+tipo).focus();
		return;
	}
	if(J("#cidade_"+tipo).val() == ""){

		alert("Por favor, informe sua cidade.");
		jQuery("#loading").hide();
		document.getElementById("cidade_"+tipo).focus();
		return;
	}
	if(J("#estado_"+tipo).val() == ""){

		alert("Por favor, informe seu estado.");
		jQuery("#loading").hide();
		document.getElementById("estado_"+tipo).focus();
		return;
	}	
	if(J("#telefone_"+tipo).val() == ""){

		alert("Por favor, informe seu telefone.");
		jQuery("#loading").hide();
		document.getElementById("telefone_"+tipo).focus();
		return;
	}
	
	//alert('<?=$_SESSION['IDCARRINHO']?>')
 
	J.ajax({
		   type: "POST",
		   cache: false,
		   async: false,
		   url: "<?php echo $INI['system']['wwwprefix']?>/autenticacao/login.php",
		   data: "acao=altera_enderecos&idcarrinho=<?=$_SESSION['IDCARRINHO']?>&tipo="+tipo+"&idusuario="+J("#idusuario_"+tipo).val()+"&telefone="+J("#telefone_"+tipo).val()+"&numero="+J("#numero_"+tipo).val()+"&cidade="+J("#cidade_"+tipo).val()+"&cep="+J("#cep_"+tipo).val()+"&endereco="+J("#endereco_"+tipo).val()+"&estado="+J("#estado_"+tipo).val()+"&complemento="+J("#complemento_"+tipo).val()+"&bairro="+J("#bairro_"+tipo).val()+"&login="+J("#logincadastro").val(),
		   success: function(user_id){
		 
		   flag =  user_id.indexOf("Falha");
		 
			if(flag!=-1){ 
				 alert(user_id);
				jQuery("#loading").hide();
			} 
			else {   
				location.href  = '<?php echo $INI['system']['wwwprefix']?>/index.php?<?php echo $_SERVER["QUERY_STRING"] ?>';
				
			 }
		}
	});	
}

function VerificaLogin() {
		
		var login = J('#logincadastro').val(); 
		
		J.ajax({
		   type: "POST",
		   cache: false,
		   async: false,
		   url: "<?php echo $INI['system']['wwwprefix']?>/ajax/VerificaLogin.php",
		   data: "acao=verifica_login&login=" + login,
		   success: function(success){
		 		if (success >= 1) {
		 			alert("Login já pertence a outro usuário!");
					document.getElementById("logincadastro").focus();
					return;
		 		}
		}
	});	
}

function getEndereco() {
 
		// Se o campo CEP não estiver vazio
		if(J.trim(J("#cep").val()) != ""){
			/* 
				Para conectar no serviço e executar o json, precisamos usar a função
				getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
				dataTypes não possibilitam esta interação entre domínios diferentes
				Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
				http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep").val()

			J.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep").val(), function(){
				// o getScript dá um eval no script, então é só ler!
				//Se o resultado for igual a 1
				if(resultadoCEP["resultado"]){
					// troca o valor dos elementos
					J("#endereco").val(unescape(resultadoCEP["tipo_logradouro"])+"  "+unescape(resultadoCEP["logradouro"]));
					J("#bairro").val(unescape(resultadoCEP["bairro"]));
					//J("#cidadeusuario").val(unescape(resultadoCEP["cidade"]));
					//J("#estado").val(unescape(resultadoCEP["uf"])); 
					var cidade = unescape(resultadoCEP["cidade"]);
					var CidadeUsuario = removerAcentos(cidade);
					J("#cidadeusuario").val(unescape(CidadeUsuario));
					J("#estado").val(unescape(resultadoCEP["uf"]));
					
				}else{
					alert("Endereço não encontrado");
				}
			});	

			*/	
			
			var url = "https://www.tkstore.com.br/services/cep/"+J("#cep").val();	

			J.get(url, function(data, status){
				 var resultadoCEP  = JSON.parse(data);
		         //alert(resultadoCEP['resultado']);

		         if(resultadoCEP["resultado"]){
					// troca o valor dos elementos

					var tipologradouro = "";
					var logradouro = "";

					if(typeof resultadoCEP["tipo_logradouro"] != 'object'){
						var tipologradouro = resultadoCEP["tipo_logradouro"];
					}

					if(typeof resultadoCEP["logradouro"] != 'object'){
						var logradouro = resultadoCEP["logradouro"];
					}

					J("#endereco").val(unescape(tipologradouro)+"  "+unescape(logradouro));
					
					if(typeof resultadoCEP["bairro"] != 'object'){
						J("#bairro").val(unescape(resultadoCEP["bairro"]));
					}else{
						J("#bairro").val("");
					}
					
					if(typeof resultadoCEP["cidade"] != 'object'){
						var cidade = unescape(resultadoCEP["cidade"]);
						var CidadeUsuario = removerAcentos(cidade);
						J("#cidadeusuario").val(CidadeUsuario);
					}
					J("#estado").val(unescape(resultadoCEP["uf"]));
				}else{
					alert("Endereço não encontrado");
				}

		    });	
		}			
}


function getEndereco_altera(tipo) {
 
		// Se o campo CEP não estiver vazio
		if(J.trim(J("#cep_"+tipo).val()) != ""){
			/* 
				Para conectar no serviço e executar o json, precisamos usar a função
				getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
				dataTypes não possibilitam esta interação entre domínios diferentes
				Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
				http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep").val()

			J.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep_"+tipo).val(), function(){
				// o getScript dá um eval no script, então é só ler!
				//Se o resultado for igual a 1
				if(resultadoCEP["resultado"]){
					// troca o valor dos elementos
					J("#endereco_"+tipo).val(unescape(resultadoCEP["tipo_logradouro"])+"  "+unescape(resultadoCEP["logradouro"]));
					J("#bairro_"+tipo).val(unescape(resultadoCEP["bairro"]));
					//J("#cidade_"+tipo).val(unescape(resultadoCEP["cidade"]));
					//J("#estado_"+tipo).val(unescape(resultadoCEP["uf"]));
					
					var cidade = unescape(resultadoCEP["cidade"]);
					var CidadeUsuario = removerAcentos(cidade);
					
					J("#cidade_"+tipo).val(unescape(CidadeUsuario));
					J("#estado_"+tipo).val(unescape(resultadoCEP["uf"]));
					
				}else{
					alert("Endereço não encontrado");
				}
			});	
			
			*/
			var url = "https://www.tkstore.com.br/services/cep/"+J("#cep_entrega").val();	

			J.get(url, function(data, status){
				 var resultadoCEP  = JSON.parse(data);
		         //alert(resultadoCEP['resultado']);

		         if(resultadoCEP["resultado"]){
					// troca o valor dos elementos

					var tipologradouro = "";
					var logradouro = "";
					
					J("#estado_entrega").val(unescape(resultadoCEP["uf"]));

					if(typeof resultadoCEP["tipo_logradouro"] != 'object'){
						var tipologradouro = resultadoCEP["tipo_logradouro"];
					}

					if(typeof resultadoCEP["logradouro"] != 'object'){
						var logradouro = resultadoCEP["logradouro"];
					}

					J("#endereco_entrega").val(unescape(tipologradouro)+"  "+unescape(logradouro));
					
					if(typeof resultadoCEP["bairro"] != 'object'){
						J("#bairro_entrega").val(unescape(resultadoCEP["bairro"]));
					}else{
						J("#bairro_entrega").val("");
					}

					if(typeof resultadoCEP["cidade"] != 'object'){
						var cidade = unescape(resultadoCEP["cidade"]);
						var CidadeUsuario = removerAcentos(cidade);
						J("#cidade_entrega").val(CidadeUsuario);
					}
				}else{
					alert("Endereço não encontrado");
				}

		    });				
		}			
}


URL = "<?php echo $ROOTPATH; ?>/ajax/filtro_pesquisa.php";
jQuery(function() {
	jQuery('#estado').bind('change', function(ev) {
		jQuery.ajax({
			url: URL,
			type: 'POST',
			data: { filtro: 'cidades', estado: jQuery('#estado').val() },
			beforeSend: function() { 
				jQuery('#cidadeusuario').html('<option>Carregando...</option>');
			},
			success: function(r) {
				jQuery('#select_city_id').html('Selecione uma cidade');
				jQuery('#cidadeusuario').html(r);
			}
		});
	});
	
	jQuery('#estado_entrega').bind('change', function(ev) {
		jQuery.ajax({
			url: URL,
			type: 'POST',
			data: { filtro: 'cidades', estado: jQuery('#estado_entrega').val() },
			beforeSend: function() { 
				jQuery('#cidade_entrega').html('<option>Carregando...</option>');
			},
			success: function(r) {
				jQuery('#cidade_entrega').html(r);
			}
		});
	});
});  
	
jQuery(document).ready(function(){
  // J("#date").mask("99/99/9999");
   //J("#telefone").mask("(99)9999-9999");
   //J("#telefone_cobranca").mask("(99)9999-9999");
   //J("#telefone_entrega").mask("(99)9999-9999");
   //J("#").mask("99-9999999");
   //J("#ssn").mask("999-99-9999");
  // J("#cpf").mask("999999999-99");
   //J("#estado").mask("aa"); 
   //J("#estado_cobranca").mask("aa"); 
   //J("#estado_entrega").mask("aa"); 
}); 
</script> 							
	