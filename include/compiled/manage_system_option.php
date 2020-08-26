<?php include template("manage_header");?>
<?php require("ini.php");?>  

<div id="bdw" class="bdw">
<div id="bd" class="cf">
	<div id="partner"> 
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content"> 
                <div class="sect">
                    <form method="post">
					<div class="option_box">
						<div class="top-heading group">
							<div class="left_float"><h4>Configurações</h4></div>
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
									
										<!-- 
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Ativar popup ao entrar no site:</span>  
											<input style="width:20px;" type="radio" <?=$email_home_sim?> value="Y" name="option[popup_ativo]"> Sim  &nbsp;<img class="tTip" title="Se sim, no primeiro acesso de cada usuário, o popup irá abrir automaticamente. Note que, caso o usuário esteja logado no site, este popup não irá abrir. O sistema irá gravar um cookie no computador do usuário para que esta tela não abra constantemente." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$email_home_nao?> value="N" name="option[popup_ativo]" > Não  &nbsp; 
										</div> 
										-->


										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Ativar Slide de Banners (Página principal)</span>  
											<input style="width:20px;" type="radio"   <? if($INI['option']['slideshowbanners'] =="Y" or  $INI['option']['slideshowbanners'] ==""){echo "checked='checked'";}?>  value="Y" name="option[slideshowbanners]"> Sim  &nbsp;<img class="tTip" title="Se sim, iremos mostrar na página principal o slide de banners. Para gerenciar vá em Layout->Slide de Banners" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['slideshowbanners'] =="N"  ){echo "checked='checked'";}?>  value="N" name="option[slideshowbanners]" > Não  &nbsp; 
											<a href="javascript:buscafoto('slideban.jpg');">clique para ver </a>
										</div>
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Ativar bloco de Newsletter na Home</span>  
											<input style="width:20px;" type="radio"   <? if($INI['option']['newsletterhome'] =="Y" or  $INI['option']['newsletterhome'] ==""){echo "checked='checked'";}?>  value="Y" name="option[newsletterhome]"> Sim  &nbsp;<img class="tTip" title="Se sim,  iremos mostrar o bloco de newsletter na Home para os usuários cadastrarem os seus e-mails." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['newsletterhome'] =="N"  ){echo "checked='checked'";}?>  value="N" name="option[newsletterhome]" > Não  &nbsp; 
											<a href="javascript:buscafoto('newshome.jpg');">clique para ver </a> 
										</div> 											
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Ativar slide de produtos similares</span>  
											<input style="width:20px;" type="radio"   <? if($INI['option']['slidesimilares'] =="Y" or  $INI['option']['slidesimilares'] ==""){echo "checked='checked'";}?>  value="Y" name="option[slidesimilares]"> Sim  &nbsp;<img class="tTip" title="Na página de detalhe de um produto, este slide busca todos os produtos relacionados com as palavras chaves e também produtos cujo título contém  alguma palavra chave do produto principal." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['slidesimilares'] =="N"  ){echo "checked='checked'";}?>  value="N" name="option[slidesimilares]" > Não  &nbsp; 
										</div>		
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Ativar slide de produtos lançamentos</span>  
											<input style="width:20px;" type="radio"   <? if($INI['option']['slidelancamentos'] =="Y" or  $INI['option']['slidelancamentos'] ==""){echo "checked='checked'";}?>  value="Y" name="option[slidelancamentos]"> Sim  &nbsp;<img class="tTip" title="Na página principal no rodapé, é mostrado um slide com os 10 produtos mais recentes do site" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['slidelancamentos'] =="N"  ){echo "checked='checked'";}?>  value="N" name="option[slidelancamentos]" > Não  &nbsp; 
											<a href="javascript:buscafoto('lancamentoshome.jpg');">clique para ver </a> 
										</div>	
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Ativar slide de produtos mais vendidos</span>  
											<input style="width:20px;" type="radio"   <? if($INI['option']['slidemaisvendidos'] =="Y" or  $INI['option']['slidemaisvendidos'] ==""){echo "checked='checked'";}?>  value="Y" name="option[slidemaisvendidos]"> Sim  &nbsp;<img class="tTip" title="Na página principal no rodapé, é mostrado um slide com os 10 produtos mais vendidos do site" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['slidemaisvendidos'] =="N"  ){echo "checked='checked'";}?>  value="N" name="option[slidemaisvendidos]" > Não  &nbsp; 
										</div> 		
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Ativar Rodapé Institucional</span>  
											<input style="width:20px;" type="radio"   <? if($INI['option']['footer-institucional'] =="Y" or  $INI['option']['footer-institucional'] ==""){echo "checked='checked'";}?>  value="Y" name="option[footer-institucional]"> Sim  &nbsp;<img class="tTip" title="Se Não, iremos desabilitar a seção Institucional do rodapé" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['footer-institucional'] =="N"  ){echo "checked='checked'";}?>  value="N" name="option[footer-institucional]" > Não  &nbsp; 
											<a href="javascript:buscafoto('rodapeinsti.jpg');">clique para ver </a> <br> Lembre-se que você pode alterar algumas informações do rodapé em Sistema->Informações Básicas ou diretamente no código fonte como qualquer item do site.
										</div> 		
										
										
										<!-- 
										 <div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">limitar produtos na Home</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio" <? if($INI['option']['limitarprodutos'] =="Y"   ){echo "checked='checked'";}?>  value="Y" name="option[limitarprodutos]"> Sim  &nbsp;<img class="tTip" title="Se sim, o sistema irá listar uma quantidade de produtos em destaque menor na página principal, o suficiente para alinhar com as categorias. Nota( Alguns produtos em destaque podem ficar sem aparecer na p&aacute;gina principal)" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['limitarprodutos'] =="N" or $INI['option']['limitarprodutos'] =="" ){echo "checked='checked'";}?> value="N" name="option[limitarprodutos]" > Não  &nbsp; 
										</div>
										-->
										
										<!--										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<div style="clear:both;"class="report-head">Qtde. de categorias filhas na lateral esquerda <span class="cpanel-date-hint">Limite as Subcategorias da Home</span> &nbsp;<img class="tTip" title="Se o sua página principal tem 15 produtos em destaque então terá 3 colunas e 5 linhas. O interessante é ter um número de categorias e subcategorias que fique alinhado com a última linha de produtos." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"></div>
											<div class="group">
												<input type="text" name="option[nomeblocodestaque]"  maxlength="35" id="option[nomeblocodestaque]" class="format_input ckeditor" value="<?php echo htmlspecialchars($nomeblocodestaque); ?>" />    
											</div> 
										</div> 
										-->
									   
									
										<!-- 
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">CPF:</span> <span class="cpanel-date-hint">Cadastro dos Usuários</span>
											<input style="width:20px;" type="radio" <?=$cpf_sim?> value="Y" name="option[cpf]"> Sim  &nbsp;<img class="tTip" title="Se sim, será mostrado o campo CPF no cadastro do usuário" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$cpf_nao?> value="N" name="option[cpf]" > Não  &nbsp; 
										</div> 
										-->										
									
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Mostrar Produtos aleatórios na Home</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio" <?=$rand_popular_sim?> value="Y" name="option[rand_popular]"> Sim  &nbsp;<img class="tTip" title="Se sim, o sistema irá mostrar os produtos neste bloco em ordem aleatória." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$rand_popular_nao?> value="N" name="option[rand_popular]" > Não  &nbsp; 
										</div>	
										 
										<!--
									    <div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Ativar Módulo de Pontuação</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio" <?=$pontuacao_sim?> value="Y" name="option[pontuacao]"> Sim  &nbsp;<img class="tTip" title="Se sim, o sistema irá ativar uma opção de menu na barra de menu de navegação e também ativar mais uma opção de tipo de oferta: Pontuação. Todas os produtos cadastradas no tipo Pontuação, irão aparecer somente nesse menu e só podem ser compradas com pontos. Para os outros tipos de ofertas (tradicional e cupomnow), você deverá editá-las informando quantos pontos cada uma delas irão gerar ao efetuar a compra." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$pontuacao_nao?> value="N" name="option[pontuacao]" > Não  &nbsp; 
										</div>
										--> 
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Anúncios de usuários na página inicial:</span>  
											<input style="width:20px;" type="radio" <?php if($INI['option']['offer_user_home'] == "Y") { ?> checked="checked" <?php } ?> value="Y" name="option[offer_user_home]"> Sim  &nbsp;<img class="tTip" title="Se sim, todos os produtos cadastrados pelos usuários irão ser exibidos na página inicial do site de forma aleatória." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?php if($INI['option']['offer_user_home'] == "N") { ?> checked="checked" <?php } ?> value="N" name="option[offer_user_home]" > Não  &nbsp; 
										</div> 
										
										 <div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Avaliação de clientes com moderação:</span>  
											<input style="width:20px;" type="radio"   <? if($INI['option']['avaliacao'] =="Y" ){echo "checked='checked'";}?>  value="Y" name="option[avaliacao]"> Sim  &nbsp;<img class="tTip" title="Se sim, todos os comentários serão publicados automaticamente." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['avaliacao'] =="N" or  $INI['option']['avaliacao'] =="" ){echo "checked='checked'";}?>  value="N" name="option[avaliacao]" > Não  &nbsp; 
										</div> 
									 
									 <div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Tkstore Developer:</span> <span class="cpanel-date-hint">Localizador de Arquivos</span>
											<input style="width:20px;" type="radio" <?=$bloco_tkdeveloper_sim?> value="Y" name="option[bloco_tkdeveloper]"> Sim  &nbsp;<img class="tTip" title="Mostra o caminho exato dos arquivos incluídos na página corrente (ideal para mudança de layout - Apenas desenvolvedores)" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$bloco_tkdeveloper_nao?> value="N" name="option[bloco_tkdeveloper]" > Não  &nbsp; 
										</div>
										  
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends"> 	 	  
								  
										<!--
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Ativar Redirecionador</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio" <?=$redirecionador_sim?> value="Y" name="option[redirecionador]"> Sim  &nbsp;<img class="tTip" title="Se sim, ao acessar o site, o usuário será redirecionado direto para a página de detalhes da oferta com posicionamento destaque. Caso o sistema não encontre nenhuma oferta destaque, ele irá buscar a próxima oferta seguindo a ordem de posicionamento. (Super Banner será omitido)" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$redirecionador_nao?> value="N" name="option[redirecionador]" > Não  &nbsp; 
										</div>
										 -->
										<!--
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Mostrar tempo restante em Ofertas Populares</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio" <?=$temporestante_sim?> value="Y" name="option[temporestante]"> Sim  &nbsp;<img class="tTip" title="Se sim, o contador de tempo restante será mostrado no bloco Ofertas Populares. Para colocar uma oferta no bloco Ofertas Polulares, edite a oferta e altere o campo Posicionamento." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$temporestante_nao?> value="N" name="option[temporestante]" > Não  &nbsp; 
										</div>
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Mostrar ofertas finalizadas em Ofertas Populares</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio" <?=$ofertas_finalizadas_populares_sim?> value="Y" name="option[ofertas_finalizadas_populares]"> Sim  &nbsp;<img class="tTip" title="Ofertas Finalizadas são os produtos cujo data final da oferta é menor do que a data corrente." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$ofertas_finalizadas_populares_nao?> value="N" name="option[ofertas_finalizadas_populares]" > Não  &nbsp; 
										</div>	
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Mostrar ofertas finalizadas na Coluna da Direita</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio" <?=$ofertas_finalizadas_direita_sim?> value="Y" name="option[ofertas_finalizadas_direita]"> Sim  &nbsp;<img class="tTip" title="Ofertas Finalizadas são os produtos cujo data final da oferta é menor do que a data corrente." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$ofertas_finalizadas_direita_nao?> value="N" name="option[ofertas_finalizadas_direita]" > Não  &nbsp; 
										</div>	
										-->
								
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Mostrar Categorias na lateral (HOME)</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio"  <? if($INI['option']['menu-nav'] =="Y" or  $INI['option']['menu-nav'] ==""){echo "checked='checked'";}?> value="Y" name="option[menu-nav]"> Sim  &nbsp;<img class="tTip" title="Se 'Sim', o sistema irá mostrar todas as categorias na lateral do site na página principal, se 'Não', este bloco será ocultado dando espaço para mais colunas de produtos" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
											<input style="width:20px;" type="radio"  <? if($INI['option']['menu-nav'] =="N"){echo "checked='checked'";}?> value="N" name="option[menu-nav]" > Não  &nbsp; 
											<a href="javascript:buscafoto('semcat.jpg');">clique para ver </a> 
										</div>
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Mostrar prazo de entrega ?</span>  
											<input style="width:20px;" type="radio"   <? if($INI['option']['mostrarprazoentrega'] =="Y" or  $INI['option']['mostrarprazoentrega'] ==""){echo "checked='checked'";}?>  value="Y" name="option[mostrarprazoentrega]"> Sim  &nbsp;<img class="tTip" title="Se sim, ao informar o cep de destino, o prazo de entrega será mostrado conforme cálculo dos correios." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['mostrarprazoentrega'] =="N"  ){echo "checked='checked'";}?>  value="N" name="option[mostrarprazoentrega]" > Não  &nbsp; 
										</div> 
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Concordar com a política de privacidade ao se cadastrar</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio"  <? if($INI['option']['termosobrigatorio'] =="Y" ){echo "checked='checked'";}?>  value="Y" name="option[termosobrigatorio]"> Sim  
											<input style="width:20px;" type="radio" <? if($INI['option']['termosobrigatorio'] =="N" || $INI['option']['termosobrigatorio'] =="" ){echo "checked='checked'";}?>  value="N" name="option[termosobrigatorio]" > Não
										</div>
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Ativar moderação de anúncios</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio"  <? if($INI['option']['moderacao'] =="Y" ){echo "checked='checked'";}?>  value="Y" name="option[moderacao]"> Sim  
											<input style="width:20px;" type="radio" <? if($INI['option']['moderacao'] =="N" || $INI['option']['moderacao'] =="" ){echo "checked='checked'";}?>  value="N" name="option[moderacao]" > Não
										</div>
										
										 <div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Ativar Debug SQL Admin</span> <span class="cpanel-date-hint">Não execute com site em produção.</span>
											<input style="width:20px;" type="radio" <?=$debug_sql_sim?> value="Y" name="option[debug_sql]"> Sim  &nbsp;<img class="tTip" title="Atenção: Apenas programadores. Para debugar mensagens de erros na administração. Poderá inteferir no layout da área pública. Só ative se souber o que está fazendo." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <?=$debug_sql_nao?> value="N" name="option[debug_sql]" > Não  &nbsp; 
										</div>		
										
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Moderar mensagens</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio"  <? if($INI['option']['moderacao_msg'] =="Y" ){echo "checked='checked'";}?>  value="Y" name="option[moderacao_msg]"> Sim  
											<input style="width:20px;" type="radio" <? if($INI['option']['moderacao_msg'] =="N" || $INI['option']['moderacao_msg'] =="" ){echo "checked='checked'";}?>  value="N" name="option[moderacao_msg]" > Não
										</div>
											 
										<div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE;display:none;">
											<span class="report-head">Ativar menu de parceiros:</span> <span class="cpanel-date-hint"></span>
											<input style="width:20px;" type="radio" <? if($INI['option']['menuparceiros'] =="Y" or $INI['option']['menuparceiros'] =="" ){echo "checked='checked'";}?>  value="Y" name="option[menuparceiros]"> Sim  &nbsp;<img class="tTip" title="Mostra as imagens dos parceiros no menu de navegação no topo do site. OBS: É necessário fazer o upload e ativar cada parceiro no menu parceiros" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
											<input style="width:20px;" type="radio" <? if($INI['option']['menuparceiros'] =="N" ){echo "checked='checked'";}?>  value="N" name="option[menuparceiros]" > Não  &nbsp; 
											<a href="javascript:buscafoto('parceirosmenu.jpg');">clique para ver </a>
										</div>	
										
								
										<!-- 
										 <div style="float:left; width:100%; margin-top: 15px;margin-bottom:11px;border-bottom:1px solid #EBECEE">
											<span class="report-head">Auth Setup</span> <span class="cpanel-date-hint">  </span>
											<input style="width:20px;" type="radio" <?=$auth_setup_sim?> value="Y" name="option[auth_setup]"> Sim  &nbsp; 
											<input style="width:20px;" type="radio" <?=$auth_setup_nao?> value="N" name="option[auth_setup]" > Não  &nbsp; 
										</div>	
										-->
									
										
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
	
	/*
	function vercontop(){
	
		tipoconteudo_oferta_popular = $("input[@id=conteudo_oferta_popular]:checked").attr('value');
		alert(tipoconteudo_oferta_popular)
		
		if(tipoconteudo_oferta_popular=="N"){
			$("#pagina_oferta_popular").attr("disabled", true);
		}
		else{
			$("#pagina_oferta_popular").attr("disabled", false);
		}
	}
	vercontop();
	*/

</script>