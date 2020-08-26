<?php  
require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/app.php');
 
$showMenu = true;
$user 	= Table::Fetch('user', $login_user_id);
?>
<div style='display:none'>  
	<div id='inline_alterar_dados_minha_conta' style='padding:10px; background:#fff;height:390px; width:870px !important'> 
	  <img style="position: absolute; max-width: 187px; right: 29px; margin-top: 98px;" src="<?=$ROOTPATH?>/skin/padrao/images/user-edit-icon.png" > 
		<div style="float:left;width:300px;">
		<h2 style="font-size:25px;">Alterar dados cadastrais</h2>
		</div> 
		 <form style="clear: both;" id="formcad" name="formcad"  METHOD="POST" >
		    <div id="loading" style="display:none;clear: both;color:#303030;font-size:12px;">  <div style="margin-left:20px;" id="txt"></div> </div>
			<div style="float: left;clear: both;">
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Nome Completo*</span></div>
				<input value="<?=utf8_decode($user[realname])?>" class="inputs" style="width:590px;font-size:12px;color:#303030;margin-right:10px;" name="username_up" type="text"  id="username_up" onFocus="if(this.value =='Insira seu nome' ) this.value=''" onBlur="if(this.value=='') this.value='Insira seu nome'" value="Insira seu nome"  />
			</div>
		  
			<div class="meuendereco" style="clear: both;">   <img style="" src="<?=$ROOTPATH?>/skin/padrao/images/meuendereco.jpg">  </div>
			
			<div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Cep (apenas números)*</span></div>
				 <input value="<?=$user[zipcode]?>" class="inputs" style="width:316px;font-size:12px;color:#303030;margin-right:10px;"  maxlength="8" onKeyPress="return SomenteNumero(event);" name="cep_up"  onblur="getEndereco_da();" type="text" id="cep_up"    />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Endereço*</span></div>
				 <input value="<?=utf8_decode($user[address])?>" class="inputs" style="width:238px;font-size:12px;color:#303030;"  name="endereco_up"   type="text" id="endereco_up"    />
			</div>
			
			 <div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Número*</span></div>
				 <input value="<?=$user[numero]?>" class="inputs" style="width:56px;font-size:12px;color:#303030;margin-right:10px;"  name="numero_up"   type="text" id="numero_up"    />
			 </div> 
			 <div style="float: left;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Complemento</span></div>
				 <input value="<?=utf8_decode($user[complemento])?>"  class="inputs" style="width:231px;font-size:12px;color:#303030;margin-right:10px;"  name="complemento_up"   type="text" id="complemento_up"    />
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Bairro*</span></div>
				 <input value="<?=utf8_decode($user[bairro])?>"  class="inputs" style="width:232px;font-size:12px;color:#303030;"  name="bairro_up"   type="text" id="bairro_up"    />
			</div>
			<div style="float: left;clear: both;" >
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Cidade*</span></div> 
				 <select class="inputselect"  name="cidadeusuario_up" id="cidadeusuario_up">
				<option value=""></option>
				<?php
					$SQL = "SELECT * FROM cidades";
					$cidades = mysql_query($SQL) or die(mysql_error());
					while ($row = mysql_fetch_array($cidades, MYSQL_ASSOC)) {
						if (utf8_decode(strtoupper($login_user["cidadeusuario"])) == strtoupper($row['nome'])) {
							$tmp_cidade = $row['nome'];
							echo "<option value='{$row['nome']}' selected>{$row['nome']}</option>";
						} else {
							echo "<option value='{$row['nome']}'>{$row['nome']}</option>";
						}
					}
				?>
				</select>  
			 </div>
			<div>
				<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Estado*</span></div> 
				<select class="inputselect"  name="estado_up" id="estado_up">
				<option value=""></option>
				<?php
					$sql = "SELECT  uf,nome FROM estados";
					$estados = mysql_query($sql) or die(mysql_error());
					while ($row = mysql_fetch_array($estados, MYSQL_ASSOC)) {
						if (strtoupper($login_user["estado"]) == strtoupper($row['uf'])) {
							$tmp_estado = $row['uf'];
							echo "<option value='{$row['uf']}' selected>".utf8_decode($row['nome'])."</option>";
						} else {
							echo "<option value='{$row['uf']}'>".utf8_decode($row['nome'])."</option>";		
						}
					}
				?>
				</select> 
					
			</div>

			 <div style="float: left;clear: both;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Telefone*</span></div>
					 <input value="<?=$user[mobile]?>" class="inputs" style="width:209px;font-size:12px;color:#303030;margin-right:10px;" name="telefone_up" type="text" id="telefone_up"  />
			 </div>
			 <div style="float: left;">
					<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Nova senha*</span></div>
					 <input class="inputs" style="width:158px;font-size:12px;color:#303030;margin-right:10px;height:12px;" name="passwordcad_up" type="password" id="passwordcad_up"  />
			 </div>
			<div>
				  <div style="margin-bottom: 5px;"><span style="font-family:verdana;color:#303030;font-size:12px;">Redigite a senha*</span></div>
				  <input class="inputs" style="width:160px;font-size:12px;color:#303030;height:12px;" name="password2_up"  type="password"  id="password2_up"   />
			</div> 
			<div>
				  <span style="font-family:verdana;color:#303030;font-size:12px;">    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;    * Campos obrigatórios  ( Deixe a senha em branco para não alterar )</span> 
			</div> 
			<div style="padding-top: 20px;margin-right:23px; ">
				<a class="link-1" style="" href="javascript:cadastro_da();"><em><b>Alterar</b></em></a>
			  </div>  
	  </div> 
</div>

	
<script language="javascript">  
  
 var idusuario;
 function cadastro_da(){
	 
    var cpf="";

    jQuery("#loading").hide();
	 
	if(J("#username_up").val() == "Insira seu nome"){
	    alert("Por favor, informe seu nome.");
		jQuery("#loading").hide();
		document.getElementById("username_up").focus();
		return;
	}
		    
	if(J("#cep_up").val() == ""){

		alert("Por favor, informe seu cep.");
		jQuery("#loading").hide();
		document.getElementById("cep_up").focus();
		return;
	}
	 if(J("#endereco_up").val() == ""){

		alert("Por favor, informe seu endereco.");
		jQuery("#loading").hide();
		document.getElementById("endereco_up").focus();
		return;
	} 
	if(J("#numero_up").val() == ""){

		alert("Por favor, informe o número.");
		jQuery("#loading").hide();
		document.getElementById("numero_up").focus();
		return;
	}
	if(J("#bairro_up").val() == ""){

		alert("Por favor, informe seu bairro.");
		jQuery("#loading").hide();
		document.getElementById("bairro_up").focus();
		return;
	}
	if(J("#cidadeusuario_up").val() == ""){

		alert("Por favor, informe sua cidade.");
		jQuery("#loading").hide();
		document.getElementById("cidadeusuario_up").focus();
		return;
	}
	if(J("#estado_up").val() == ""){

		alert("Por favor, informe seu estado.");
		jQuery("#loading").hide();
		document.getElementById("estado_up").focus();
		return;
	}	
	if(J("#telefone_up").val() == ""){

		alert("Por favor, informe seu telefone.");
		jQuery("#loading").hide();
		document.getElementById("telefone_up").focus();
		return;
	}
  
	if(J("#password2_up").val() != J("#passwordcad_up").val() ){
	    alert("Por favor, revise suas senhas, elas não conferem.");
		jQuery("#loading").hide();
		document.getElementById("password2_up").focus();
		return;
	}
	//jQuery.colorbox({html:"<img src="+URLWEB+"/skin/padrao/images/ajax-loader2.gif> Aguarde enquanto alteramos os seus dados..."});
	J.ajax({
		   type: "POST",
		   cache: false,
		   async: false,
		   url: "<?php echo $INI['system']['wwwprefix']?>/autenticacao/login.php",
		   data: "acao=alterar_dados_cadastrais&telefone="+J("#telefone_up").val()+"&numero="+J("#numero_up").val()+"&cidadeusuario="+J("#cidadeusuario_up").val()+"&cep="+J("#cep_up").val()+"&endereco="+J("#endereco_up").val()+"&estado="+J("#estado_up").val()+"&complemento="+J("#complemento_up").val()+"&bairro="+J("#bairro_up").val()+"&username="+J("#username_up").val()+"&passwordcad="+J("#passwordcad_up").val()+"&emailcadastro=<?=$user[email]?>&password2="+J("#password2_up").val(),
		   success: function(retorno){ 
		   flag =  retorno.indexOf("Falha");
		 
			if(flag!=-1){ 
				alert("Erro na alteração dos dados! Por favor, tente novamente mais tarde.");
			}
			else{ 
				jQuery.colorbox({html:"Dados alterados com sucesso !"});
			}			
		}
	});	
}
 

function getEndereco_da() {
 
		// Se o campo CEP não estiver vazio
		if(J.trim(J("#cep").val()) != ""){
			/* 
				Para conectar no serviço e executar o json, precisamos usar a função
				getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
				dataTypes não possibilitam esta interação entre domínios diferentes
				Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
				http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep").val()
			*/
			J.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep").val(), function(){
				// o getScript dá um eval no script, então é só ler!
				//Se o resultado for igual a 1
				if(resultadoCEP["resultado"]){
					// troca o valor dos elementos
					J("#endereco").val(unescape(resultadoCEP["tipo_logradouro"])+"  "+unescape(resultadoCEP["logradouro"]));
					J("#bairro").val(unescape(resultadoCEP["bairro"]));
					//J("#cidadeusuario").val(unescape(resultadoCEP["cidade"]));
					//J("#estado").val(unescape(resultadoCEP["uf"])); 
					J("#cidadeusuario").val(unescape(resultadoCEP["cidade"]));
					J("#estado").val(unescape(resultadoCEP["uf"]));
					
				}else{
					alert("Endereço não encontrado");
				}
			});				
		}			
}

 
jQuery(document).ready(function(){
  // J("#date").mask("99/99/9999");
   //J("#telefone").mask("(99)9999-9999");
   //J("#telefone_cobranca").mask("(99)9999-9999");
   //J("#telefone_entrega").mask("(99)9999-9999");
   //J("#").mask("99-9999999");
   //J("#ssn").mask("999-99-9999");
   J("#cpf").mask("999999999-99");
   //J("#estado").mask("aa"); 
   //J("#estado_cobranca").mask("aa"); 
   //J("#estado_entrega").mask("aa"); 
}); 
</script> 							
	