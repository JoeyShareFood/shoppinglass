<?php include template("manage_header");?>
<?php require("ini.php");?> 
 
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="leader">
	<div id="content" class="clear mainwide">
        <div class="clear box"> 
            <div class="box-content">
                <div class="sect">
					<form id="login-user-form" method="post" action="/vipmin/user/valecupomedit.php?id=<?php echo $valecompras['id']; ?>" enctype="multipart/form-data" class="validator">
					<input type="hidden" name="id" value="<?php echo $valecompras['id']; ?>" />
					<input type="hidden" name="adminnew" value="<?php echo $_REQUEST['adminnew']; ?>" />
					<input type="hidden" name="www" id="www"  value="<?=$INI['system']['wwwprefix']?>" /> 
					<div class="option_box">
						<div class="top-heading group">
							<div class="left_float"><h4>Vale Compras - Cupons</h4></div>
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
									
										<div style="clear:both;"class="report-head">Código <span class="cpanel-date-hint">Clique para gerar o código automaticamente ou informe manualmente </span></div>
										<div class="group">
											<input  maxLength="10" type="text" name="codigo" style="width:40%;" <? if($valecompras['id'] != NULL) echo "readonly"?>  id="codigo" class="format_input ckeditor" value="<?php echo $valecompras['codigo']; ?>" />    
											<? if($valecompras['id'] == NULL){?> <a href='javascript:geracodigo()'><img  src="<?=$ROOTPATH?>/media/css/i/gerar.png" style="position: absolute; width: 114px;">      <img style="cursor:help" class="tTip" title="Um código de vale comprasm serve para o usuário usá-lo na pagina de carrinho, diminuindo o valor da compra. Gere o código e envie para o(s) usuário(s)" src="<?=$ROOTPATH?>/media/css/i/info.png"></a><?}?>
										</div>
											
										 <div style="clear:both;"class="report-head">Quantidade de usos: <span class="cpanel-date-hint">Ex: Este cupom pode ser usado apenas 3 vezes. Deixe em branco para não limitar.</span></div>
										<div class="group">
											<input type="text" name="limite" maxLength="5"  onKeyPress="return SomenteNumero(event);"   id="limite" class="format_input ckeditor" value="<?php echo $valecompras['limite'] ?>" /> 
										</div>	 	

										<div style="clear:both;"class="report-head">Valor do vale compras: <span class="cpanel-date-hint">Ex: Valor que será abatido do carrinho de compras. </span></div>
										<div class="group">
											<input type="text" name="valor" maxLength="11"   id="valor" class="format_input ckeditor" value="<?php echo $valecompras['valor'] ?>" />  &nbsp; <img class="tTip" title="Se o valor do carrinho de compras é de R$ 100,00 e o usuário aplicar um vale compras de R$ 10,00, o total do carrinho será de R$ 90,00. Não se aplica ao valor do frete. Se o valor do vale compras ultrapassar o valor do carrinho, o usuário não poderá usar novamente o restante." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png">
										</div>	  
										 
									</div>
									<!-- =============================   fim coluna esquerda   =====================================-->
									<!-- =============================   coluna direita   =====================================-->
									<div class="ends"> 	 		 
									
									<div class="group">
											<div style="clear:both;"class="report-head">Limitar por usuário: <span class="cpanel-date-hint">Ex: Este cupom deve ser usado 3x porém apenas 1 vez por usuário</span></div>
												<input style="width:20px;" type="radio" <? if($valecompras['limiteporusuario'] =="1" or $valecompras['limiteporusuario'] ==""){echo "checked='checked'";}?>  value="1" name="limiteporusuario"  > Sim  &nbsp; <img class="tTip" title="Você pode gerar um cupom e não limitar, e configurar para poder ser usado apenas 1 vêz por usuário." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
												<input style="width:20px;" type="radio" <? if($valecompras['limiteporusuario'] =="0"   ){echo "checked='checked'";}?>   name="limiteporusuario" value="0"> Não  
											</div>  
											
											<div class="group">
												<div style="clear:both;"class="report-head">Status: <span class="cpanel-date-hint"> Ative ou Desative este cupom para ser ou não ser usado. </span></div>
													<input style="width:20px;" type="radio" <? if($valecompras['status'] =="ativo"  or $valecompras['status'] =="" ){echo "checked='checked'";}?>  value="ativo" name="status" > Sim  &nbsp; <img class="tTip" title="Cupons desativados não poderão mais ser usados. Isto não terá efeito se algum usuário já o usou." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> 
												  <input style="width:20px;" type="radio" <? if($valecompras['status'] =="desativado" ){echo "checked='checked'";}?>   name="status" value="desativado"> Não  
											<br>
											Atenção: Se o vale compras for de R$ 100,00 e o carrinho de compras de R$ 80,00 ( não se aplica ao valor do frete ). Se o usuário usar este cupom, o seu pedido terá um valor de R$0,00, ele não irá precisar pagar o pedido e este cupom será zerado, ou seja, não existe saldo de cupons.
							
											</div>  
										 </div> 
										</div>
										  
									 </div>
									<!-- =============================  fim coluna direita  =====================================-->
								</div> 
							</div>
							</form>
						</div>    
					</div>
				</div> 
			</div>
		</div> 
	</div>
</div> 
<script>
 
 $('#valor').priceFormat({
    prefix: 'R$ ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});

function validador(){
 
	limpacampos(); 

	if( jQuery("#codigo").val()==""){

		campoobg("codigo");
		alert("Por favor, informe o código do cupom");
		jQuery("#codigo").focus();
		return false;
	} 	
	if( jQuery("#limite").val()==""){

		campoobg("limite");
		alert("Por favor, informe o limite de uso");
		jQuery("#limite").focus();
		return false;
	}
	if( jQuery("#valor").val()==""){

		campoobg("valor");
		alert("Por favor, informe o valor do desconto");
		jQuery("#valor").focus();
		return false;
	} 
	return true;	
}
 function geracodigo(){

	$.get(WEB_ROOT+"/vipmin/geracodigo.php",
				
	   function(data){
		  if(jQuery.trim(data)==""){
			alert("Houve um erro ao gerar o código");
		  }  
		  else{
			  jQuery("#codigo").val(data);
		  }
	   });
	}
		

</script>   