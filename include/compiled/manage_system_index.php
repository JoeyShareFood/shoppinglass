<?php include template("manage_header");?>

 

<?
$option_layout= array(
	""=>"Layout Padrão",
	"multi"=>"Layout Multiofertas"
);

if($INI['system']['currency']==""){
	$INI['system']['currency'] = "R$";	
}
?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="partner">
	<div class="dashboard" id="dashboard">
		<ul><?php echo mcurrent_system('index'); ?></ul>
	</div>
	<div id="content" class="clear mainwide">
        <div class="clear box">
            <div class="box-top"></div>
            <div class="box-content"> 
                <div class="sect">
                    <form method="post">
					<div class="option_box">
						<div class="top-heading group">
							<div class="left_float"><h4>Informações Básicas</h4></div>
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
										<div style="clear:both;"class="report-head">Título do seu site ( Máximo de 63 caracteres ): <span class="cpanel-date-hint">Ex: Vip Eletros</span></div>
										<div class="group">
											<input type="text" name="system[sitename]" class="format_input ckeditor" value="<?php echo $INI['system']['sitename']; ?>" /> 
										</div>
										<!-- 
										<div style="clear:both;"class="report-head">Subtítulo: <span class="cpanel-date-hint">Ex: Compra Coletiva</span></div>
										<div class="group">
											<input type="text" name="system[sitetitle]" class="format_input ckeditor" value="<?php echo $INI['system']['sitetitle']; ?>" /> 
										</div>	
										--> 
						
										<div style="clear:both;"class="report-head">Google Analítics: <span class="cpanel-date-hint">Ex: UI-762HFDJDS <a href="http://www.google.com/analytics/" target="_blank">clique aqui</a> para se cadastrar</span></div>
										<div class="group">
											<input type="text" name="system[googleanalitics]" class="format_input ckeditor" value="<?php echo $INI['system']['googleanalitics']; ?>" />  &nbsp;<img class="tTip" title="Caso não tenha uma conta, cadastre grátis em http://www.google.com/analytics." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
										</div>
									 
										<div style="clear:both;"class="report-head">Pontuação: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input type="text" maxlength="3" onKeyPress="return SomenteNumero(event);"  name="system[pontuacao]" class="format_input ckeditor" value="<?php echo $INI['system']['pontuacao']; ?>" />  &nbsp;<img class="tTip" title="O numero de vendas concretizadas, multiplicado por este valor, será o valor total da pontuação do vendedor." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
										</div> 
										
										<div style="clear:both;"class="report-head">Rotina de verificação:</span></div>
										<div class="group">
											<input maxlength="2" onKeyPress="return SomenteNumero(event);" type="text" name="system[bill_check]" class="format_input ckeditor" value="<?php echo $INI['system']['bill_check']; ?>" />   &nbsp;<img class="tTip" title="Forneça o valor em dias. O sistema irá utilizar os dias como intervalo. Ao finalizar o intervalo, todos os clientes com faturas em aberto, recebem um email notificando sobre o mesmo." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
										</div>	
										
										 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends"> 	 			 
								  
										<div style="clear:both;"class="report-head">Seo - Palavras chaves do site: ( Motores de Busca )<span class="cpanel-date-hint">separados por vírgula. Ex: eletrodomésticos, eletrônicos</span></div>
										<div class="group">
											<input type="text" name="system[seochaves]" class="format_input ckeditor" value="<?php echo $INI['system']['seochaves']; ?>" /> 
										</div>		
										<div style="clear:both;"class="report-head">Seo - Descrição do site: ( Motores de Busca ). Máximo de 152 caracteres. <span class="cpanel-date-hint"> </span></div>
										<div class="group">
											<input type="text" name="system[seodescricao]" class="format_input ckeditor" value="<?php echo $INI['system']['seodescricao']; ?>" />  &nbsp;<img class="tTip" title="Esse é o campo mais importante para os motores de busca. Informe uma breve descrição do seu site. Seja objetivo." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
										</div>	
										<div style="clear:both;"class="report-head">Fanpage: <span class="cpanel-date-hint">Note que fanpage não é o seu profile.</span></div>
										<div class="group">
											<input type="text" name="system[fanpagefacebook]" class="format_input ckeditor" value="<?php echo $INI['system']['fanpagefacebook']; ?>" />  &nbsp;<img class="tTip" title="Se você não tem uma fanpage você deve obrigatoriamente criá-la" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
										</div>
										
										<!--
										<div style="clear:both;"class="report-head">Dias adicionais ao prazo dos correios: <span class="cpanel-date-hint"> O campo "Mostrar prazo de entrega" deve estar ativado</span> </div>
										<div class="group">
											<input type="text"  onKeyPress="return SomenteNumero(event);"  maxlength="3" name="system[diasadicionais]" class="format_input ckeditor" value="<?php echo $INI['system']['diasadicionais']; ?>" /> &nbsp;<img class="tTip" title="Se você informar 10 e o prazo dos correios for 3, o prazo que irá aparecer para o cliente será de 13 dias. No entanto, o campo 'mostrar prazo de entrega no cadastro do produto deve estar ativado.' " style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
										 </div>	
										-->
								
										<div style="clear:both;"class="report-head">Comissão: <span class="cpanel-date-hint"></span></div>
										<div class="group">
											<input type="text" maxlength="2" onKeyPress="return SomenteNumero(event);"  name="system[comissao]" class="format_input ckeditor" value="<?php echo $INI['system']['comissao']; ?>" />  &nbsp;<img class="tTip" title="Forneça o valor em porcentagem de quanto o site irá receber a cada pedido." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
										</div> 
										 
								
										
										<input type="hidden" name="system[currency]" class="format_input ckeditor" value="R$" /> 
									 </div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
						</div>
					</div> 
					 
					 <!-- ********************************************* ABA  COLUNA 1 --> 
					<div class="option_box"> 
						 <div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
									<div class="text_area">  
									<textarea cols="45" rows="5" name="system[rodapetexto1]" style="width:100%"   class="format_input ckeditor" ><?php echo htmlspecialchars($INI['system']['rodapetexto1']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div> 			
					
					<div class="option_box"> 
						 <div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
									<div class="text_area">  
									<textarea cols="45" rows="5" name="system[rodapetexto2]" style="width:100%"   class="format_input ckeditor" ><?php echo htmlspecialchars($INI['system']['rodapetexto2']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div> 						
					
					<div class="option_box"> 
						 <div id="container_box">
							<div id="option_contents" class="option_contents">  
								<div class="form-contain group"> 
									<div class="text_area">  
									<textarea cols="45" rows="5" name="system[termosdeusosite]" style="width:100%"   class="format_input ckeditor" ><?php echo htmlspecialchars($INI['system']['termosdeusosite']); ?></textarea>
									</div> 
								</div> 
							</div> 
						</div>
					</div> 	
					
					<!-- ********************************************* ABA  COLUNA 2  --> 
			 
					<!-- 
					<div id="container_box">
							<div id="option_contents" class="option_contents"> 
								<div class="form-contain group"> 
									<div class="starts"> 
										<div style="clear:both;"class="report-head">Opções do Estado: <span class="cpanel-date-hint">Página de Parceria</span></div>
										<div class="group">
											<input type="text" style="height:30px;"  name="system[estados]" class="format_input ckeditor" value="<?php echo htmlspecialchars($INI['system']['estados']); ?>" /> 
										</div> 
									</div> 
									<div class="ends"> 	 	 
									 </div> 
								</div> 
							</div>
						</div>
						--> 
					<input type="text"  style="display:none;" name="system[currencyname]" class="number" value="BRL"/> 
					<input type="text" style="display:none;"  name="system[timezone]" class="texto-time-zone" value="<?php echo $INI['system']['timezone']; ?>"/> 
					<input type="text" style="display:none;" name="system[partnerdown]" class="number" value="<?php echo abs(intval($INI['system']['partnerdown'])); ?>"/> 
					<input type="text" style="display:none;" name="system[conduser]" class="number" value="<?php echo abs(intval($INI['system']['conduser'])); ?>"/> 
						 
				
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
 
