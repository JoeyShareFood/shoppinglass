<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner"> 
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content"> 
                <div class="sect">
                    <form method="post">
					<!-- ********************************************* ABA PAGSEGURO --> 
					<div class="option_box">
						<div class="top-heading group">
							<div class="left_float"><h4>Pagseguro</h4></div>
								<div class="the-button"> 
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
										<div id="url_botao_comprar">									
											<div class="report-head">Email: <span class="cpanel-date-hint">Email do Pagseguro</span></div>
											<div class="group">
												<input type="text"  name="pagseguro[acc]" value="<?php echo  $INI['pagseguro']['acc'] ; ?>"> &nbsp;<img class="tTip" title="Este é o email de cadastro no www.pagseguro.com.br" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											</div>		
											<div class="report-head">Token: <span class="cpanel-date-hint">Caso não tenha, gere um token no pagseguro</span></div>
											<div class="group">
												<input type="text"  name="pagseguro[mid]" value="<?php echo  $INI['pagseguro']['mid'] ; ?>"> &nbsp;<img class="tTip" title="Este token é obrigatório para retorno automático do pagseguro. Você precisa entrar no site do pagseguro e gerar um token. Caso tenha dúvidas, veja nossos vídeos." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											</div>
											<!--  
											<div class="report-head">CHECKOUT LIGHTBOX TRANSPARENTE<span class="cpanel-date-hint"></span></div>
											<div class="group">
											<?
											if($INI['pagseguro']['transparente']==""){
												$INI['pagseguro']['transparente'] = "0";	
											}
											?>
											  <input type="text" size="30" name="pagseguro[transparente]" class="f-input" value="<?php echo $INI['pagseguro']['transparente']; ?>" style="width:50px;"/><span class="inputtip">1 para Ativar - 0 para Desativar</span>
												<span class="inputtip infotxt">  
												O Checkout Lightbox permite que todo o processo de pagamento seja feito em uma janela que se sobrepõe ao site do vendedor. Dessa forma o comprador não é redirecionado para outro site.
												 <B style="color:red">Observação: Para utilizar o Checkout Lightbox, é necessário  autorização do serviço junto ao Pagseguro, não ative sem o contato com o suporte do pagseguro para a autorização. </B>
												</span>
											</div>	
											--> 
											 		  
										
											
											
										</div>	 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends infotxt"> 	 			 
										 Agora entre no <a target="_blank" href="http://www.pagseguro.com.br"> http://www.pagseguro.com.br</a> e informe a url nos campos <b><br>1-retorno automático de dados <br>2-página de redirecionamento  <br>3-notificação de transações </b> 
										 <br>URL a ser infomada. <b><?=$INI['system']['wwwprefix']?>/pedido/pagseguro/retorno.php</b> <img class="tTip" title="Atenção. Sempre informe a url no formato http://www.seudominio.com.br. Atente-se para o http://  e o www." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
										 <br> Não esqueça de ativar todos os campos.
										 <br> Precisa de ajuda? <a target="_blank" href="http://www.sistemacomprascoletivas.com.br/configurando-o-retorno-automatico-do-pagseguro-para-o-sistema-de-compra-coletiva">Clique aqui</a> e veja nosso vídeo tutorial
										<br> 
										<!--
										 <div class="report-head">API DE PAGAMENTO<span class="cpanel-date-hint">Ative também esta opção no seu pagseguro</span></div>
											<div class="group">
											<?
											if($INI['pagseguro']['novaapi']==""){
												$INI['pagseguro']['novaapi'] = "0";	
											}
											?>
											  <input type="text" size="30" name="pagseguro[novaapi]" class="f-input" value="<?php echo $INI['pagseguro']['novaapi']; ?>" style="width:50px;"/><span class="inputtip">1 para Ativar - 0 para Desativar</span>
												<span class="inputtip infotxt">  Ative <b>se e somente se </b> você ativou também esta opção em seu pagseguro em "Integrações", caso contrário, irá dar erro.
												 
												</span>
											</div>	
										-->

									</div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div>
					</div> 
					 
					<!-- ********************************************* ABA MOIP --> 
					<div class="option_box" style="display:none;">
						<div class="top-heading group">
							<div class="left_float"><h4>Moip</h4></div>
						</div> 
						<div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="form-contain group">
									<!-- =============================   coluna esquerda   =====================================-->
									<div class="starts"> 
										<div id="url_botao_comprar">									
											<div class="report-head">Email: <span class="cpanel-date-hint">Email do Moip</div>
											<div class="group">
												<input type="text"  name="moip[mid]" value="<?php echo  $INI['moip']['mid'] ; ?>"> &nbsp;<img class="tTip" title="Este é o email de cadastro no www.moip.com.br" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											</div>	 	
										</div>	 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends infotxt" > 	
									 Após entrar no endereço <a target="_blank" href="http://www.moip.com.br">http://www.moip.com.br</a> com os dados de sua conta moip, acesse esta url.  <a target="_blank" href="https://www.moip.com.br/AdmMainMenuMyData.do?method=transactionnotification">https://www.moip.com.br/AdmMainMenuMyData.do?method=transactionnotification</a>
									 Ná página aque se abre, marque o campo  "Receber notificação instantânea de transação" e informe esta url no campo URL de notificação  <b><?=$INI['system']['wwwprefix']?>/pedido/moip/retorno.php</b> e Confirme a alteração. <img class="tTip" title="Atenção. Sempre informe a url no formato http://www.seudominio.com.br. Atente-se para o http://  e o www." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
								    </div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div> 
					</div>	
					
					<!-- ********************************************* AKATUS --> 
					<div class="option_box" style="display:none;">
						<div class="top-heading group">
							<div class="left_float"><h4>Akatus</h4></div>
						</div> 
						<div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="form-contain group">
									<!-- =============================   coluna esquerda   =====================================-->
									<div class="starts"> 
										<div id="url_botao_comprar">									
											<div class="report-head">Email: <span class="cpanel-date-hint">Email do Akatus</div>
											<div class="group">
												<input type="text"  name="akatus[acc]" value="<?php echo  $INI['akatus']['acc'] ; ?>"> &nbsp;<img class="tTip" title="Este é o email de cadastro no www.akatus.com.br" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											</div>	 	
										</div>	 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends infotxt"> 	
										É necessário que você tenha um cadastro no site  <a target="_blank" href="http://www.akatus.com.br">http://www.akatus.com.br</a>
										<br> Esse gateway de pagamento não oferece retorno automático.
								   </div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div> 
					</div>	
					
					
					<!-- ********************************************* ABA MOIP TRANSPARENTE --> 
					<div class="option_box" style="display:none;">
						<div class="top-heading group">
							<div class="left_float"><h4>Moip Checkout Transparente</h4></div>
						</div> 
						<div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="form-contain group">
									<!-- =============================   coluna esquerda   =====================================-->
										<div class="starts"> 
										<div id="url_botao_comprar">									
											<div class="report-head">Email: <span class="cpanel-date-hint">Email do Moip</span></div>
											<div class="group">
												<input type="text"  name="moip[midtrans]" value="<?php echo  $INI['moip']['midtrans'] ; ?>"> &nbsp;<img class="tTip" title="Este é o email de cadastro no www.moip.com.br" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											</div>	
											<div style="display:none;">
												<div class="report-head">Token: <span class="cpanel-date-hint"> Algo como: HKRVWRR66AFSJ9HCHDJCALDZCRM4Y7KM</span></div>
												<div class="group">
													<input type="text"  name="moip[tokentrans]" value="<?= $INI['moip']['tokentrans']?>">   
												</div>	
												<div class="report-head">Chave: <span class="cpanel-date-hint">Algo como: 8FJNJ6JWT7G3XJWSZCLQVMFFBHS4LOAGJVRHVEPS</span></div>
												<div class="group">
													<input type="text"  name="moip[chavetrans]" value="<?= $INI['moip']['chavetrans']?>">   
												</div>
												 <input type="text" readonly="readonly" name="moip[urlmoip]" value="https://www.moip.com.br/ws/alpha/EnviarInstrucao/Unica">  
												 
												<!--
												<div class="report-head">URL: <span class="cpanel-date-hint">Apenas desenvolvedores</span></div>
												<div class="group">
													
													<span class="cpanel-date-hint">url sandbox: https://desenvolvedor.moip.com.br/sandbox/ws/alpha/EnviarInstrucao/Unica</span>  
													<span class="cpanel-date-hint">url producao: https://www.moip.com.br/ws/alpha/EnviarInstrucao/Unica </span>  
													
												</div>
												-->												
											</div>	
											 
											
										</div>	 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends infotxt"> 	
									 Para usar o Moip Checkout Transparente, você precisa primeiro criar uma conta no <a target="_blank" href="http://www.moip.com.br">http://www.moip.com.br</a> depois disso ou caso já tenha uma conta no moip, por motivos de segurança, você precisa entrar em contato com o moip e solicitar a ativação do Moip Checkout Transparente em sua conta. Sem isso, não irá funcionar. 
									 <br> O processo é simples, apenas informe que você é parceiro da Vipcom para ganhar taxas promocionais. Você também precisa informar a url de retorno.  Ainda no site do Moip <a target="_blank" href="http://www.moip.com.br">http://www.moip.com.br</a> Vá em:  Meus Dados > Preferências > Notificação das Transações. Marque a opção Receber notificação instantânea de venda e digite o endereço abaixo
									  <?=$INI['system']['wwwprefix']?>/include/moip/retorno.php</b> e Confirme a alteração. <img class="tTip" title="Atenção. Sempre informe a url no formato http://www.seudominio.com.br. Atente-se para o http://  e o www." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
								    <b>De acordo com as regras do Moip, a quantidade de parcelas que irá aparecer para o usuário poder escolher está relacionado diretamente com o valor da oferta. Todas as parcelas devem ser maiores do que R$ 5,00 e o combo de opções será gerado automaticamente.</b>
									</div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div> 
					</div>
					
						<!-- ********************************************* ABA DINHEIRO MAIL --> 
					<div class="option_box" style="display:none;">
						<div class="top-heading group">
							<div class="left_float"><h4>Dinheiro Mail</h4></div>
						</div> 
						<div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="form-contain group">
									<!-- =============================   coluna esquerda   =====================================-->
									<div class="starts"> 
										<div id="url_botao_comprar">									
											<div class="report-head">Email: <span class="cpanel-date-hint">Email do Dinheiro Mail</div>
											<div class="group">
												<input type="text"  name="dinheiro[mid]" value="<?php echo  $INI['dinheiro']['mid'] ; ?>"> &nbsp;<img class="tTip" title="Este é o email de cadastro no http://br.dineromail.com" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											</div>	 	
										</div>	 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends infotxt"> 	
										É necessário que você tenha um cadastro no site  <a target="_blank" href="http://www.dinheiromail.com">http://www.dinheiromail.com</a>
										<br> Esse gateway de pagamento não oferece retorno automático.
									</div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div> 
					</div>	
					
				  <!-- ********************************************* ABA Bcash --> 
					<div class="option_box" style="display:none;">
						<div class="top-heading group">
							<div class="left_float"><h4>Bcash</h4></div>
						</div> 
						<div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="form-contain group">
									<!-- =============================   coluna esquerda   =====================================-->
									<div class="starts">  									
										<div class="report-head">Email: <span class="cpanel-date-hint">Email do Bcash</div>
										<div class="group">
											<input type="text"  name="pagamentodg[acc]" value="<?php echo  $INI['pagamentodg']['acc'] ; ?>"> &nbsp;<img class="tTip" title="Este é o email de cadastro no www.pagamentodigital.com.br" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											
										</div>
										<div class="report-head">Token: <span class="cpanel-date-hint">Token do Bcash</div>
										<div class="group">
											<input type="text"  name="pagamentodg[mid]" value="<?php echo  $INI['pagamentodg']['mid'] ; ?>"> &nbsp;<img class="tTip" title="Este é o token de sua conta no www.pagamentodigital.com.br" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											
										</div>

										<div class="report-head">BCASH LIGHTBOX TRANSPARENTE<span class="cpanel-date-hint"></span></div>
											<div class="group">
											<?
											if($INI['pagamentodg']['transparente']==""){
												$INI['pagamentodg']['transparente'] = "0";	
											}
											?>
											  <input type="text" size="30" name="pagamentodg[transparente]" class="f-input" value="<?php echo $INI['pagamentodg']['transparente']; ?>" style="width:50px;"/><span class="inputtip">1 para Ativar - 0 para Desativar</span>
												<span class="inputtip">
												O Checkout Lightbox permite que todo o processo de pagamento seja feito em uma janela que se sobrepõe ao site do vendedor. Dessa forma o comprador não é redirecionado para outro site.
												 <B> </B>
												</span>
											</div>	
											
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends infotxt"> 	
									<br> Para este gateway de pagamento não damos suporte a retorno automático.
									</div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div> 
					</div>	
					 	

					<!-- ********************************************* ABA PAYPAL --> 
					<div class="option_box" style="display:none;">
						<div class="top-heading group">
							<div class="left_float"><h4>Paypal</h4></div>
						</div> 
						<div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="form-contain group">
									<!-- =============================   coluna esquerda   =====================================-->
									<div class="starts">  									
										<div class="report-head">Email: <span class="cpanel-date-hint">Email do Paypal</div>
										<div class="group">
											<input type="text"  name="paypal[mid]" value="<?php echo  $INI['paypal']['mid'] ; ?>"> &nbsp;<img class="tTip" title="Este é o email de cadastro em www.paypal.com.br" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
										 </div>	
										 <div class="report-head">Localização: <span class="cpanel-date-hint">Código da moeda do País. Ex: BRL </div>
										<div class="group">
											<input type="text"  name="paypal[loc]" value="<?php echo  $INI['paypal']['loc'] ; ?>"> &nbsp;<img class="tTip" title="Código da moeda como: USD (Dólar Americano),BRL (Real), EUR (Euro)" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
										 </div>
									 	 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends infotxt"> 
									<a target="_blank" href="http://pt.wikipedia.org/wiki/ISO_4217">Veja aqui a lista dos códigos</a>									
									<br> Esse gateway de pagamento não oferece retorno automático.
									</div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div> 
					</div>		
					
					<!-- ********************************************* ABA CARTAO DE CRÉDITO --> 
					<div class="option_box" style="display:none;">
						<div class="top-heading group">
							<div class="left_float"><h4>Cartão de Crédito</h4></div>
						</div> 
						<div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="form-contain group">
									<!-- =============================   coluna esquerda   =====================================-->
									<div class="starts">  									
								      <input type="text" size="30" name="credito[pay]" class="f-input" value="<?php echo $INI['credito']['pay']; ?>" style="width:50px;"/><span class="inputtip">1 para ativar</span>
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends infotxt"> 
									
									 Todos os dados do cartão serão enviados para o seu email e você será responsável por estar realizando a cobrança manualmente.
									 Você será responsável por solicitar o certificado de segurança SSL para maior segurança e criptografia dos dados de cartão. (Opcional) 
									 Note que, se você não tem um sistema de cobrança já integrado com as operadoras sem a necessidade de cartão de crédito, então deixe esse campo desativado.
									  
									</div>
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