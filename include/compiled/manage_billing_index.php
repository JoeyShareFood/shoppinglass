<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
               	<div class="option_box"> 
					<div class="top-heading group"> 
					<div class="left_float">
						<h4>Faturas</h4>
					</div>					
					</div> 				
                <div class="sect" style="clear:both;">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">					  
						<form method="get">
							<input type="hidden" class="iduser" id="iduser">
							<tr>
								<th width="60">ID <input value ="<?=$_REQUEST['id']?>" type="text"  name="id"  id="id" style="width: 90%;color:#303030;font-size:11px;"> </th>
								<th width="100">Usuário <br /> 
									<select name="usuario" id="usuario">
									<?php
										
										$sqlF = "select distinct id_user from faturas";
										$rsF = mysql_query($sqlF);
										
										while($faturas = mysql_fetch_assoc($rsF)) {
											
											$sql = "select id, realname, login from user where id = '" . $faturas['id_user'] . "'";
											$rs = mysql_query($sql);
											$user = mysql_fetch_assoc($rs);
									?>
									<option value="<?php echo $user['id']; ?>"><?php echo $user['realname'] . " - " . $user['login']; ?></option>
									<?php } ?>
									</select>
								</th>
								<th width="30">Status <br /> 
									<select name="status" id="status">
										<option value=""></option>
										<option value="pay">Pago</option>
										<option value="unpay">Não Pago</option>
										<option value="cancelled">Cancelado</option>
									</select>
								</th>
								<th width="100">Valor </th>
								<th width="30">Data da geração </th>
								<th width="30">Data do pagamento </th>					
								<th width="100">Descrição </th>
								<th width="100">Observação</th>					   				   
								<th width="190"> 
									<button style="width: 60px;" type="submit"><span>Buscar</span></button>
									<button style="width: 60px"  onclick="resetFilter()" type="button"><span>Limpar</span></button>
								</th>
							</tr>
						</form>
				   
						<?php if(is_array($bill)){foreach($bill AS $index=>$one) { $bregistro =  true; ?>
						<?php
							
							/* Para cada tipo de status, tem uma cor diferente de background. */
							if($one['status'] == "pay") {
								$status = "Pago";	
								$color = "green";
							}
							else if($one['status'] == "unpay") {
								$status = "Não pago";
								$color = "red";							
							}
							else if($one['status'] == "cancelled") {
								$status = "Cancelado";
								$color = "orange";
							}
							
							/* A data de geração e pagamento da fatura, recebem formato brasileiro. */
							$data_geracao = date("d/m/Y H:i:s", strtotime($one['data_geracao']));
							
							if(!(empty($one['data_pagamento'])) and $one['data_pagamento'] != "0000-00-00 00:00:00") {
								$data_pagamento = date("d/m/Y H:i:s", strtotime($one['data_pagamento']));
							}
							else {
								$data_pagamento = " - ";
							}
							
							/* Verifica se existe faturas não pago. Caso exista, é exibido o botão para efetuar o pagamento. */
							$sql = "SELECT * FROM faturas WHERE STATUS = 'unpay' AND id_user = '" . $one['id_user'] . "' and id = " . $one['id'];
							$rs = mysql_query($sql);
							$faturas = mysql_num_rows($rs);
							
							$user = Table::Fetch('user', $one['id_user']);
							
							/* Função retorna algumas informações de saldo de comissões do pedido. */
							$saldo = getSaldoComissao($user['id']);
							
							$SaldoComissao = explode("#", $saldo);
							$saldo = $SaldoComissao[0];
							$saldo_devedor = $SaldoComissao[1];
							$credito = $SaldoComissao[2];
							
							if(empty($saldo)) {
								$saldo = "0,00";
							}
							
							if(empty($saldo_devedor)) {
								$saldo_devedor = "0,00";
							}
							
							if(empty($credito)) {
								$credito = "0,00";
							}
						
						?>
						<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
							<td style="background:<?php echo $color; ?>"><?php echo $one['id']; ?> </td> 
							<td><?php echo $user['realname'];?></td>
							<td><?php echo $status;?></td>
							<td style="color:#333;">R$ <?php echo number_format($one['valor'], 2, ",", "."); ?></td>
							<td><?php echo $data_geracao;?></td>
							<td><?php echo $data_pagamento;?></td> 
							<td><?php echo $one['descricao'];?></td> 
							<td><?php echo $one['observacao'];?></td>  
							<td class="op">
							<a href="#" class="tk_billing" id="<?php echo $user['id']; ?>#<?php echo $one['id']?>#<?php echo $user['realname']; ?>#<?php echo number_format($saldo_devedor, 2, ",", "."); ?>"><img alt="Editar fatura" title="Editar fatura" src="/media/css/i/editar.png" style="width: 22px;"></a> 
							<?php if($faturas >= 1) { ?><a href="/ajax/manage.php?action=billing_pay&id=<?php echo $one['id']; ?>" class="ajaxlink"><img alt="Colocar como pago" title="Colocar como pago" style="width: 22px;" src="/media/css/i/pay.png"></a><?php } ?>
							<?php if($one['status'] != "cancelled") { ?><a class="ajaxlink" href="<?php echo $ROOTPATH; ?>/ajax/manage.php?action=billing_cancel&id=<?php echo $one['id']; ?>"><img src="<?php echo $ROOTPATH; ?>/media/css/i/excluir.png" style="width: 22px;" title="Cancelar fatura" alt="Cancelar fatura"></a><?php } ?>
						</tr>
					<?php }}?>
					<?if(!$bregistro){?><tr><td colspan="13" style="text-align: center;">Nenhum registro encontrado. Redefina sua pesquisa</tr><? } ?>
					<tr><td colspan="15"><?php echo $pagestring; ?></tr>
                    </table>
				</div>
            </div>
            </div>
        </div>
    </div>
</div>
<div style='display:none'>
	<div id='inline_billing' style='background:#fff; height:110px; padding:10px; width:345px !important'>
		<div id="BillForm" class="formulario span-8 last">
			<input type="hidden" class="idfatura" id="idfatura">
				<div class="span-8 last caixa-linha-ficha" id="container-nome">
					<div class="span-8 borda-bottom-1 fundosecao">
						<div class="AvisoContato">
							<img align="left" src="<?php echo $PATHSKIN; ?>/images/bill.png"> 
							<h4>Gerar e enviar fatura</h4>
							<p class="InfoUser">Nome do cliente: <span class="NameUser"></span></p>
							<p class="InfoUser">Saldo devedor: <span class="BalanceUser"></span></p>
						</div>
					</div>				 
						<div class="LabelForm">
							<label class="last size-13-bold rotulo">Descrição:</label>
						</div> 
					  <input type="text" maxlength="100" id="txtDesricao" name="descricao" class="span-6-b raio-5">
				</div>
				<div class="span-8 last caixa-linha-ficha" id="container-email" style="clear:both;">
					<div class="span-8 last margin-top-10">
						<div class="LabelForm">
							<label class="last size-13-bold rotulo">Valor:</label>
						</div>
					</div>
					<input type="text" maxlength="60" id="txtValor"  name="valor" class="span-6-b raio-5">
				</div>
				<div class="span-8 last caixa-linha-ficha" id="container-tel" style="clear: both;">
					<div class="span-8 last margin-top-10">
						<div class="LabelForm">
							<label class="last size-13-bold rotulo" >Forma de pagamento:</label>
						</div>
					</div>
					<select id="textPagamento" name="pagamento" class="span-6-b raio-5 celular">
						<option value="PagSeguro">PagSeguro</option>
						<option value="Transferencia">Transferência ou depósito bancário</option>
					</select>
				</div>				
				<div class="span-8 last caixa-linha-ficha" id="container-tel" style="clear: both;">
					<div class="span-8 last margin-top-10">
						<div class="LabelForm">
							<label class="last size-13-bold rotulo" >Status:</label>
						</div>
					</div>
					<select id="textStatus" name="status" class="span-6-b raio-5 celular">
						<option value="unpay">Não pago</option>						
						<option value="pay">Pago</option>
						<option value="cancelled">Cancelado</option>
					</select>
				</div>
				<div class="span-8 last caixa-linha-ficha"  style="text-align:left;" id="container-msg">
					<div class="span-8 last margin-top-10">
						<div class="LabelForm">
							<label class="last size-13-bold rotulo" >Observações:</label>
						</div>
					</div> 
					<textarea rows="10" style="text-align:left;" onkeyup="limite_textarea(this.value)" maxlength="1000" name="proposta" id="txtMsg" class="span-6-b last raio-5" rows=""></textarea>
				</div>
				<div class="LabelForm">
					Caracteres restantes: <label id="conttxt" for="txtMsg">1000</label>
				</div>
				<div class="span-8 last caixa-linha-ficha"  style="text-align:left;margin-top:15px;margin-bottom:15px;" id="container-msg">
					<input type="checkbox" name="SendBilli" id="txtSendBilli" checked="checked"> Enviar email com nova fatura
				</div>
				<div class="span-8 last checkboxes" style="text-align: left; clear: both; margin-left: -35px; margin-top: -10px;">
					<div class="span-5 jump-1 last captcha-cont-vendedor" style="margin-top:22px;width:243px;" >
						<div style="width: 163px;">	
						<button id="btnEnviar" class="btn btn-primary write-review" style="width:94px;" onclick="javascript:EditBilli();"  title="Enviar" data-tipo-anuncio="Usados" data-tipo-veiculo="Carro" data-id="11239890"   class="span-4 last raio-5 size-14-bold bt-verm margin-top-10">Atualizar</button>
						</div>			
					</div>
				</div>
			</div>
		</div> 
	</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->
<script>
  
jQuery(".tk_billing").colorbox({inline:true, href:"#inline_billing",width:"700px",height:"840px"});

function limite_textarea(valor) {
	quant = 1000;
	total = valor.length;
	if(total <= quant) {
		resto = quant - total;
		document.getElementById('conttxt').innerHTML = resto;
	} else {
		document.getElementById('txtMsg').value = valor.substr(0,quant);
	}
}

$('#txtValor').priceFormat({
    prefix: 'R$ ',
    centsSeparator: ',',
    thousandsSeparator: '.'
});

function mudapagina(valor){
	if(valor=="" || valor=="000"){
		return;
	}
var contadoremails  = 0; 
 var files = ''; 
	jQuery(".cinput:checked").each(function(){ 
			if(this.checked) {  
				files = files  + this.value+ ',';
				contadoremails = contadoremails + 1;
			}
		});
		if(valor!="0" & contadoremails==""){
			alert('Por favor, selecione ao menos 1 contato');
			jQuery("#acao").val("000");
			return
		}
		destinos = jQuery.base64.encode(files);
		contadoremails = jQuery.base64.encode(contadoremails);
		location.href  = 'msg.php?valor='+valor+'&recp='+contadoremails+'&chave='+destinos;
		 
}
</script>
 <script> 
 function resetFilter(){
	location.href  = '<?php echo $_SERVER["PHP_SELF"] ?>';
 }
 
 function detalhe(id){
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Buscando cliente: "+id+"</div>"});
	$.get(WEB_ROOT+"/include/compiled/manage_ajax_dialog_user.php?id="+id,
	function(data){ 
		jQuery.colorbox({html:data});
	}); 
} 
 
  function msg(){
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Atualizando...</div>"});
}
	
$("a.tk_billing").click(function(){

	var param = $(this).attr('id');
	var params = param.split("#");
	
	var id = params[0];
	var idfatura = params[1];
	var nameuser = params[2];
	var saldo = params[3];
	
	if(id == "") {		
		window.alert("Ocorreu algum erro inesperado. Tente novamente mais tarde!");
		location.href="<?php $ROOTPATH; ?>/vipmin/billing/index.php";
		return;
	}
	else {	
		$(".iduser").val(id);
	}
	
	$.ajax({
	   type: "POST",
	   cache: false,
	   async: true,
	   url: "<?php echo $ROOTPATH; ?>/ajax/manage.php",
	   data: "iduser="+id+"&idfatura="+idfatura+"&action=InfoBilli",
	   dataType: "json",
	   success: function(msg){	   
			$("#txtDesricao").val(msg.descricao);
			$("#txtValor").val(msg.valor);
			$("#textPagamento").val(msg.forma_pagamento);
			$("#textStatus").val(msg.status);
			$("#txtMsg").val(msg.observacao);
			$("#idfatura").val(msg.id);
			$("span.NameUser").html(nameuser);
			$("span.BalanceUser").html("R$" + saldo);
		}
	});
});

function EditBilli() {
	
	var id = $(".iduser").val();	
	var descricao = $("#txtDesricao").val();
	var valor = $("#txtValor").val();
	var pagamento = $("#textPagamento").val();
	var status = $("#textStatus").val();
	var observacoes = $("#txtMsg").val();
	var idfatura = $("#idfatura").val();
	var enviarfatura; 
	
	if($("#txtSendBilli").is(':checked')) {
		enviarfatura = 1;
	}
	else {
		enviarfatura = 0;
	}
	
	if(id == "") {
		window.alert("Ocorreu algum erro inesperado. Tente novamente mais tarde!");
		location.href="<?php $ROOTPATH; ?>/vipmin/billing/index.php";
		return;	
	}
	
	if(descricao == "") {
		alert("Informe o campo descrição!");
		return;
	}	
	
	if(valor == "" || valor == "R$0,00") {
		alert("Informe o campo valor!");
		return;
	}	
	
	if(pagamento == "") {
		alert("Informe a forma de pagamento!");
		return;
	}
	
	if(status == "") {
		alert("Informe o status da fatura!");
		return;
	}
	
	if(pagamento == "Transferencia" && observacoes == "") {
		alert("Informe alguma informação no campo observações!");
		return;
	}
	
	$.ajax({
		   type: "POST",
		   cache: false,
		   async: true,
		   url: "<?php echo $ROOTPATH; ?>/ajax/billing.php",
		   data: "action=editar&iduser="+id+"&valor="+valor+"&pagamento="+pagamento+"&status="+status+"&descricao="+descricao+"&observacoes="+observacoes+"&idfatura="+idfatura+"&enviarfatura="+enviarfatura,
		   success: function(msg){
		   
		   if( jQuery.trim(msg)==""){
				jQuery.colorbox({html:"<p>"+msg+"</p>"});
				location.href = "<?php echo $ROOTPATH; ?>/vipmin/billing/index.php";
			}  
		   else {
					jQuery.colorbox({html:"<p>"+msg+"</p>"});
					location.href = "<?php echo $ROOTPATH; ?>/vipmin/billing/index.php";
				}
			 }
		 });
}

</script>
