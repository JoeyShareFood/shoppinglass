<?php include template("manage_header"); 
 
if($zonas_entrega['metododosistema']=="s"){
	$readonly="readonly='readonly'";
}
?>
  
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div id="content" class="clear mainwide">
        <div class="clear box"> 
            <div class="box-content">
                <div class="sect">
				<form id="nform" id="nform"  method="post" action="/vipmin/system/zonasedit.php" enctype="multipart/form-data" class="validator">
				<input type="hidden" id="id" name="id" value="<?=$zonas_entrega['id']; ?>" /> 
				<input type="hidden" name="www" id="www"  value="<?=$INI['system']['wwwprefix']?>" /> 
				<input type="hidden" name="metododosistema" id="metododosistema"  value="<?=$zonas_entrega['metododosistema']?>" /> 
				<div class="option_box">
					<div class="top-heading group">
						<div class="left_float"><h4>Método: <?=$zonas_entrega['nome']?> <? if($readonly){ echo " - Você não pode alterar o identificador, frete e prazo de um método dos correios";} ?></h4></div>
							<div class="the-button" style="width:201px;">
								<input type="hidden" value="remote" id="deliverytype" name="deliverytype">
							 
								<div style="float:left;"><button  onclick="javascript:location.href='zonas.php'"  id="run-button" class="input-btn" type="button"> <div id="spinner-text"  >Cancelar</div></button></div>
								<div style="float:left;"><button onclick="doupdate();" id="run-button" class="input-btn" type="button">
									<div name="spinner-top" id="spinner-top" style="width: 83px; display: block;"><img name="imgrec" id="imgrec" src="<?=$ROOTPATH?>/media/css/i/lendo.gif" style="display: none;"></div>
									<div id="spinner-text"  >Salvar</div>
								</button>
								</div>
							</div> 
					</div> 
					<div id="container_box">
						<div id="option_contents" class="option_contents"> 
						
							<div class="form-contain group">
								<!-- =============================   coluna esquerda   =====================================-->
								<div class="starts">
									<div class="report-head">Ativo <span class="cpanel-date-hint"></span></div>
								 
									<input style="width:20px;" type="radio" <? if($zonas_entrega['ativo']=="s" or $zonas_entrega['ativo']==""){ echo "checked=checked"; }?> value="s" name="ativo"> Sim       
									<input style="width:20px;" type="radio" <? if($zonas_entrega['ativo']=="n"){ echo "checked=checked"; }?> value="n" name="ativo"> Não    
								    
										<div class="report-head">Identificador: <span class="cpanel-date-hint">Ex: motoboy - Apenas para uso interno (não visível)</span></div>
										<div class="group">
											<input type='text' <?=$readonly?> name='identific' id='identific' value='<?=$zonas_entrega['identific']?>' />
											<img class="tTip" title="Apenas para uso interno. Sem espaços. O usuário não visualiza esta informação. Ex: motoboy" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
										</div>	
								 
									<div class="report-head">Nome: <span class="cpanel-date-hint">Ex: Transporte Expresso - (máximo de 23 caracteres) Visível ao usuário </span></div>
									<div class="group">
										<input type='text' maxlength="23" name='nome' id='nome' value='<?=$zonas_entrega['nome']?>' />
										<img class="tTip" title="Nome que será apresentado no carrinho de compra para o usuário" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									</div> 
									 
								</div>
								<!-- =============================   fim coluna esquerda   =====================================-->
								<!-- =============================   coluna direita   =====================================-->
								<div class="ends">
								 
								 	<div class="report-head">Valor do Frete: <span class="cpanel-date-hint">O cálculado do frete é automático para métodos dos correios. Ex: pac, sedex.</span></div>
									<div class="group">
										<input type='text' <?=$readonly?>  maxlength="25" name='valor_frete' id='valor_frete' value='<?=$zonas_entrega['valor_frete']?>' />
									 </div> 
									  
									<div class="report-head">Prazo de Entrega: <span class="cpanel-date-hint">O prazo é automático para métodos dos correios. Ex: pac, sedex.</span></div>
									<div class="group">
										<input type='text' <?=$readonly?>  onKeyPress="return SomenteNumero(event);"  maxlength="15" name='prazo_entrega' id='prazo_entrega' value='<?=$zonas_entrega['prazo_entrega']?>' />
									</div> 
									  
									<div class="report-head">Informações Opcionais: <span class="cpanel-date-hint">( Opcional ) Ex: A entrega por este método é feita de segunda a sexta das 09h as 13h. ( até 80 caracteres) </span></div>
									<div class="group">
										<input type='text'   maxlength="80"  name='texto' id='texto' value='<?=$zonas_entrega['texto']?>' />
										<img class="tTip" title="Descreva alguma informação útil para o usuário sobre este método. ( Opcional )" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
									 </div> 
									 
									 <div class="report-head">Ordenação: <span class="cpanel-date-hint">Os maiores aparecem em primeiro</span></div>
									<div class="group">
										<input type='text' onKeyPress="return SomenteNumero(event);"  maxlength="15" name='ordenacao' id='ordenacao' value='<?=$zonas_entrega['ordenacao']?>' />
									</div> 
									
									 
								 </div>
								<!-- =============================  fim coluna direita  =====================================-->
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
$('#valor_frete').priceFormat({
    prefix: 'R$ ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});

function validador(){
		return true;
}

function verificaperiodo(a){
	 
	    atevender  = $("input[name='atevender']:checked").val();
		if(atevender=='S'){
		   jQuery("#dias").val(60);
		   jQuery("#diaspublica").hide();
		  
		}
		else{
			jQuery("#diaspublica").show();
		   jQuery("#dias").val("");
		}
} 
</script>   