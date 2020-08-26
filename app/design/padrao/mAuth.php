<?php  
	require_once("include/head.php"); 
?> 

<div style="display:none;" class="tips"><?=__FILE__?></div> 

<!-- Responsivo -->
<div class="containerM">
	<? require_once(DIR_BLOCO . "/headerM.php"); ?>   
	<div class="row">
		<h2>Fa�a seu login ou cadastre-se agora mesmo</h2>
		<div class="titleForm">
			<p>Fa�a o seu login</p>
		</div>
		<div class="productsPage">
			<div class="formAuth">
				<form>
					<div class="formContent">
						<label>
							Email de acesso:
						</label>
						<input id="emailM" type="email" maxlength="50" name="email" placeholder="Email de acesso" autocomplete="off">
					</div>
					<div class="formContent">
						<label>
							Senha de acesso:
						</label>
						<input id="passwordM" type="password" maxlength="50" name="password" placeholder="Senha de acesso" autocomplete="off">
					</div>			
						<input type="hidden" name="referer" id="referer" value="<?=getUrl();?>">		
					<div class="formContent">
						<div class="formButton">
							 <a href="#" id="formAuthLogin">Entrar</a>  						  							
						</div>
					</div>
				</form>
			</div>
		</div>	
		<div class="titleForm">
			<p>Esqueci minha senha</p>
		</div>
		<div class="productsPage">
			<div class="formAuth">
				<form>
					<div class="formContent">
						<label>
							Email de acesso:
						</label>
						<input id="emailM_recover" type="email" maxlength="50" name="email" placeholder="Email de acesso" autocomplete="off">
					</div>				
					<div class="formContent">
						<div class="formButton">
							 <a href="#" id="formAuthRecover">Enviar</a>  						  							
						</div>
					</div>
				</form>
			</div>
		</div>		
		<div class="titleForm">
			<p>Legal, crie agora mesmo o seu login</p>
		</div>
		<div class="productsPage">
			<div class="formAuth">
				<form>
					<div class="formContent">
						<label>
							Nome completo:
						</label>
						<input id="usernameM" type="text" maxlength="80" name="username" placeholder="Nome completo" autocomplete="off">
					</div>					
					<div class="formContent">
						<label>
							Nome da lojinha:
						</label>
						<input onblur="VerificaLogin();" id="logincadastroM" type="text" maxlength="50" name="logincadastro" placeholder="Login de acesso" autocomplete="off">
					</div>					
					<div class="formContent">
						<label>
							Email de acesso:
						</label>
						<input id="emailCM" type="email" maxlength="50" name="email" placeholder="Email de acesso" autocomplete="off">
					</div>					
					<div class="formContent">
						<label>
							CPF ou CNPJ:
						</label>
						<input onkeypress="mascaraMutuario(this,cpfCnpj)" onblur="clearTimeout()" id="doccpfcnpj" type="text" name="cpf" placeholder="CPF ou CNPJ" autocomplete="off">
					</div>					
					<div class="formContent">
						<label>
							CEP:
						</label>
						<br />
						<input onblur="getEndereco();" onkeypress="return SomenteNumero(event);" id="cep" type="text" name="cep" placeholder="CEP" autocomplete="off">
					</div>					
					<div class="formContent">
						<label>
							Endere�o:
						</label>
						<input id="endereco" type="text" name="endereco" placeholder="Endere�o completo" autocomplete="off">
					</div>				
					<div class="formContent">
						<label>
							N�:
						</label>
						<br />
						<input onkeypress="return SomenteNumero(event);" id="numero" type="text" name="numero" placeholder="N�mero" autocomplete="off">
					</div>					
					<div class="formContent">
						<label>
							Complemento:
						</label>
						<input id="complemento" type="text" name="complemento" placeholder="Complemento" autocomplete="off">
					</div>					
					<div class="formContent">
						<label>
							Bairro:
						</label>
						<br />
						<input id="bairro" type="text" name="bairro" placeholder="Bairro" autocomplete="off">
					</div>					
					<div class="formContent">
						<label>
							Estado:
						</label>
						<br />
						<select name="estado" id="estado">
							<option value=""></option>
							<option value="AC">Acre</option>
							<option value="AL">Alagoas</option>
							<option value="AP">Amap�</option>
							<option value="AM">Amazonas</option>
							<option value="BA">Bahia</option>
							<option value="CE">Cear�</option>
							<option value="DF">Distrito Federal</option>
							<option value="ES">Esp�rito Santo</option>
							<option value="GO">Goi�s</option>
							<option value="MA">Maranh�o</option>
							<option value="MT">Mato Grosso</option>
							<option value="MS">Mato Grosso do Sul</option>
							<option value="MG">Minas Gerais</option>
							<option value="PA">Par�</option>
							<option value="PB">Para�ba</option>
							<option value="PR">Paran�</option>
							<option value="PE">Pernambuco</option>
							<option value="PI">Piau�</option>
							<option value="RJ">Rio de Janeiro</option>
							<option value="RN">Rio Grande do Norte</option>
							<option value="RS">Rio Grande do Sul</option>
							<option value="RO">Rond�nia</option>
							<option value="RR">Roraima</option>
							<option value="SC">Santa Catarina</option>
							<option value="SP">S�o Paulo</option>
							<option value="SE">Sergipe</option>
							<option value="TO">Tocantins</option>
						</select>
					</div>
					<div class="formContent">
						<label>
							Cidade:
						</label>
						<input id="cidadeusuario" type="text" name="cidadeusuario" placeholder="Cidade" autocomplete="off">
					</div>						
					<div class="formContent">
						<label>
							Telefone:
						</label>
						<input id="telefone" type="text" name="telefone" placeholder="Telefone" autocomplete="off">
					</div>						
					<div class="formContent">
						<label>
							Senha de acesso:
						</label>
						<input id="passwordCM" type="password" maxlength="50" name="password" placeholder="Senha de acesso" autocomplete="off">
					</div>	
					<div class="formContent">
						<label>
							Redigite a senha:
						</label>
						<input id="password2" type="password" name="password2" placeholder="Digite a senha novamente" autocomplete="off">
					</div>						
					<div class="formContent">
						Ao criar uma conta no <?php echo $INI['system']['sitename'];?> voc� concorda com a nossa Pol�tica de Privacidade. <a href="<?php echo $ROOTPATH; ?>/page/4" target="_blank" style="color:#028AA2;">Clique para ler</a>
					</div>											
					<div class="formContent">
						<div class="formButton">
							 <a href="#" id="formAuthRegister">Enviar</a>  						  							
						</div>
					</div>
				</form>
			</div>
			<? require_once(DIR_BLOCO . "/rodapeM.php"); ?>
		</div>
	</div>
</div>
<script>

function VerificaLogin() {
		
	var login = J('#logincadastroM').val(); 

	J.ajax({
		type: "POST",
		cache: false,
		async: false,
		url: "<?php echo $INI['system']['wwwprefix']?>/ajax/VerificaLogin.php",
		data: "acao=verifica_login&login=" + login,
		success: function(success){
			if (success >= 1) {
				alert("Login j� pertence a outro usu�rio!");
				document.getElementById("logincadastroM").focus();
				return;
			}
		}
	});	
}

function getEndereco() {
 
	// Se o campo CEP n�o estiver vazio
	if(J.trim(J("#cep").val()) != ""){
		/* 
			Para conectar no servi�o e executar o json, precisamos usar a fun��o
			getScript do jQuery, o getScript e o dataType:"jsonp" conseguem fazer o cross-domain, os outros
			dataTypes n�o possibilitam esta intera��o entre dom�nios diferentes
			Estou chamando a url do servi�o passando o par�metro "formato=javascript" e o CEP digitado no formul�rio
			http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep").val()
		*/
		J.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+J("#cep").val(), function(){
			// o getScript d� um eval no script, ent�o � s� ler!
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
				alert("Endere�o n�o encontrado");
			}
		});				
	}			
}
</script>