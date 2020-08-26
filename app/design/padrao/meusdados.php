<?php  
require_once("include/code/meusdados.php");
require_once("include/head.php"); 
?> 
<body id="page1">
<div style="display:none;" class="tips"><?=__FILE__?></div>
<div class="tail-top"> 

    <div class="main">
       <?php  require_once(DIR_BLOCO."/header.php"); ?>
		<section id="content">
            <?php  require_once(DIR_BLOCO."/bannertopo.php"); ?>
            <div class="inside" style="padding:0 19px 0px 10px">
				<div class="container">
				<div class="col-1c"> 
						<div class="container">
						  <div class="col-6" style="width:96%;">
							<div class="titulosecao2"><span class="txt7">	<a style="color:#fff;" href="index.php?page=minhaconta">Meus Pedidos</a> | <a style="color:#fff;" href="index.php?page=meuscupons">Meus Cupons</a> |<a style="color:#fff;" href="index.php?page=meusconvites"> Meus Convites</a> |<a style="color:#fff;" href="index.php?page=meuscreditos"> Meus Créditos</a> | <a style="color:#fff;" href="index.php?page=minhaconta">Meus Dados</a></span></div>
							 <div class="pgavulsafundominhaconta">
								 <span style="color:#94c807;font-size:1.21em; font-family:Trebuchet MS;font-weight:bold;padding:12px;">Meus Dados</span> <a href="javascript:update();" class="link-3"><em><b>Atualizar dados</b></em></a>  
								 <div class="tail" style="margin-top:-12px;"></div>
								  <span style="color:blue;"><? if($msg){  echo $msg; } ?></span> 
								 <form id="formcadupdate" name="formcadupdate" method="post" action="">
								  <table width="629" border="0">
									  <tr>
										<td width="277"><span style="font-family:verdana;color:303030;font-size:12px;">Nome</span></td>
										<td width="33">&nbsp;&nbsp;&nbsp;&nbsp; </td>
										<td width="305"><span style="font-family:verdana;color:303030;font-size:12px;">Email</span></td>
									  </tr>
									  <tr>
										<td><label for="nomeuso"></label>
										   <input name="realname"style="width:424px;font-size:12px;color:#000;;"  type="text"   id="realname" onFocus="if(this.value =='Insira seu nome' ) this.value=''" onBlur="if(this.value=='') this.value='Insira seu nome'" value="<?php echo  utf8_decode($login_user['realname']) ; ?>"  />
									  </td>
										<td>&nbsp;</td>
										<td><label for="email"></label> 
										  <input name="email" style="width:424px;font-size:12px;color:#000;;" type="text"  id="email" onFocus="if(this.value =='Insira seu e-mail' ) this.value=''" onBlur="if(this.value=='') this.value='Insira seu e-mail'" value="<?php echo $login_user['email']; ?>"  />
										 </td>
									  </tr>
									  <!-- 
									  <tr> 
										<td width="305" colspan="3"><span style="font-family:verdana;color:303030;font-size:12px;">Cidade</span></td>
									  </tr>
									   <tr>
										 <td>
											<select name="websites3" style="width: 445px;  height:41px; font-size:13px; margin-left: 0px;padding:6px;" id="websites3">
											<option value="">Escolha sua Cidade</option>
											<?php echo utf8_decode(Utility::Option(Utility::OptionArray($hotcities, 'id', 'name'), $login_user['city_id'])); ?>
										   </select>
										 </td>
									  </tr>
									  -->
									<tr>
										<td width="277"><span style="font-family:verdana;color:303030;font-size:12px;">Senha</span></td>
										<td width="33">&nbsp; </td>
										<td width="305"><span style="font-family:verdana;color:303030;font-size:12px;">Redigite a senha</span></td>
									  </tr>
									   <tr>
										<td><label for="nomeuso"></label> 
											 
										   <input name="password" style="width:424px;font-size:12px;color:#000;;" type="password"   id="password" />
										   <div style="font-family:verdana;color:303030;font-size:10px;">Deixe a senha em branco para não atualizar</div>
										</td>
										<td>&nbsp;</td> 
										<td>
										   <input name="password2"  style="width:424px;font-size:13px;color:#000;;" type="password"   id="password2"   />
										 </td>
									  </tr>
										<tr>
										 <td colspan="4">
											 
										<div style="float: left;clear: both;" >
											<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Cep (apenas números)*</span></div>
											 <input style="width:416px;font-size:12px;color:#303030;margin-right:10px;" value="<?=$login_user['zipcode']?>" onKeyPress="return SomenteNumero(event);" name="cep_"  onblur="getEndereco();" type="text" id="cep_"    />
										 </div>
										<div>
											<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Endereço*</span></div>
											 <input style="width:438px;font-size:12px;color:#303030;"  name="endereco_" value="<?=utf8_decode($login_user['address'])?>"  type="text" id="endereco_"    />
										</div>
										
										 <div style="float: left;clear: both;" >
											<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Número*</span></div>
											 <input style="width:98px;font-size:12px;color:#303030;margin-right:10px;" value="<?=$login_user['numero']?>" name="numero_"   type="text" id="numero_"    />
										 </div> 
										 <div style="float: left;" >
											<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Complemento</span></div>
											 <input style="width:431px;font-size:12px;color:#303030;margin-right:10px;"  value="<?=utf8_decode($login_user['complemento'])?>"name="complemento_"   type="text" id="complemento_"    />
										 </div>
										<div>
											<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Bairro*</span></div>
											 <input style="width:295px;font-size:12px;color:#303030;"  name="bairro_"  value="<?=utf8_decode($login_user['bairro'])?>" type="text" id="bairro_"    />
										</div>
										<div style="float: left;clear: both;" >
											<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Cidade*</span></div>
											 <input style="width:416px;font-size:12px;color:#303030;margin-right:10px;"value="<?=utf8_decode($login_user['cidadeusuario'])?>"  name="cidadeusuario_"   type="text" id="cidadeusuario_"    />
										 </div>
										<div>
											<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Estado*</span></div>
											 <input style="width:438px;font-size:12px;color:#303030;"  name="estado_"  value="<?=utf8_decode($login_user['estado'])?>" type="text" id="estado_"    />
										</div>

										 <div style="float: left;">
												<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Telefone*</span></div>
												 <input style="width:409px;font-size:12px;color:#303030;margin-right:10px;" value="<?=$login_user['mobile']?>" name="telefone_" type="text" id="telefone_"  />
										 </div>	
										 <? if($INI['option']['pontuacao']=="Y"){?>
											  <div>
													<div style="margin-bottom: 5px;"><span style="font-family:verdana;color:303030;font-size:12px;">Meus Pontos</span></div>
													 <span style="font-family:verdana;color:303030;font-size:18px;"><?= number_format( $login_user['score'],null,"",".") ?></span>
											 </div>	
										 <? } ?>
										 
										</td> 
									   </tr>
								    </table>
									</form>
								 </div>
							</div>
						 </div> 
					</div>
				</div>
			</div>
        </section>
    </div>
</div> 
 
<?php
require_once(DIR_BLOCO."/rodape.php");
?>
  <script type="text/javascript" src="<?=$ROOTPATH?>/js/include_select_css.js"></script>

  <script>
  
	function update(){
			 
		if(J("#password").val() != "" & J("#password2").val() == ""){
			alert("Por favor, repita a senha ou deixe os campos em branco para não alterar.")
			document.getElementById("password2").focus();
			return;
		}
		if(J("#password").val() != J("#password2").val()){
			alert("As senhas não conferem. Caso não queira alterar as senhas, deixe-as em branco.")
			document.getElementById("password2").focus();
			return;
		}
		 
  // dados de enredeço
	 
	if(J("#cep_").val() == ""){

		alert("Por favor, informe seu cep.");
		jQuery("#loading").hide();
		document.getElementById("cep_").focus();
		return;
	}
	 if(J("#endereco_").val() == ""){

		alert("Por favor, informe seu endereco.");
		jQuery("#loading").hide();
		document.getElementById("endereco_").focus();
		return;
	} 
	if(J("#numero_").val() == ""){

		alert("Por favor, informe o número.");
		jQuery("#loading").hide();
		document.getElementById("numero_").focus();
		return;
	}
	if(J("#bairro_").val() == ""){

		alert("Por favor, informe seu bairro.");
		jQuery("#loading").hide();
		document.getElementById("bairro_").focus();
		return;
	}
	if(J("#cidadeusuario_").val() == ""){

		alert("Por favor, informe sua cidade.");
		jQuery("#loading").hide();
		document.getElementById("cidadeusuario_").focus();
		return;
	}
	if(J("#estado_").val() == ""){

		alert("Por favor, informe seu estado.");
		jQuery("#loading").hide();
		document.getElementById("estado_").focus();
		return;
	}	
	if(J("#telefone_").val() == ""){

		alert("Por favor, informe seu telefone.");
		jQuery("#loading").hide();
		document.getElementById("telefone_").focus();
		return;
	}
	
	  J("#formcadupdate").submit();
			 
			 
	}
	
	
function getEndereco() {
 alert(J.trim(J("#cep_").val()))
		// Se o campo CEP não estiver vazio
		if(J.trim(J("#cep_").val()) != ""){
			/* 
				Para conectar no serviço e executar o json, precisamos usar a função
				getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
				dataTypes não possibilitam esta interação entre domínios diferentes
				Estou chamando a url do serviço passando o parâmetro "formato=javascript" e o CEP digitado no formulário
				http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep").val()
			*/
			J.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep_").val(), function(){
				// o getScript dá um eval no script, então é só ler!
				//Se o resultado for igual a 1
				if(resultadoCEP["resultado"]){
					// troca o valor dos elementos
					J("#endereco_").val(unescape(resultadoCEP["tipo_logradouro"])+"  "+unescape(resultadoCEP["logradouro"]));
					J("#bairro_").val(unescape(resultadoCEP["bairro"]));
					J("#cidadeusuario_").val(unescape(resultadoCEP["cidade"]));
					J("#estado_").val(unescape(resultadoCEP["uf"]));
				}else{
					alert("Endereço não encontrado");
				}
			});				
		}			
}

 
jQuery(document).ready(function(){
  // J("#date").mask("99/99/9999");
   J("#telefone_").mask("(99)9999-9999");
   //J("#").mask("99-9999999");
   //J("#ssn").mask("999-99-9999");
   J("#cpf").mask("999999999-99");
   J("#estado_").mask("aa"); 
});


 
 </script>
  
 

</body>
</html>
