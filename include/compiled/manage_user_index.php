<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
               	<div class="option_box"> 
					<div class="top-heading group"> <div class="left_float"><h4>Usuários</h4></div> 
						<div style="padding: 10px;">	
							<ul id="log_tools"> <li id="log_switch_referral"><a title="Cadastrar novo cliente" href="/vipmin/user/edit.php">Novo usuário</a></li> </ul> 
						</div>	
					</div> 
             	<div class="paginacaotop" style="width:50%"><?php echo $pagestring; ?></div>
				<div> 
					  
					<ul id="log_tools" >
					<select name="acao"  onchange="mudapagina(this.value);" id="acao" style="padding:3px;width: 237px;color:#303030;font-size:11px;font-weight:normal;height:21px;" >
					<option value="000">Escolha uma ação</option>
					<option value="00">Enviar nova mensagem para selecionado</option>  
					<!-- 
					<option <?=$select_sim?> value="">------------------ Modelos Salvos --------------------</option> 
						<?
						$sql =  "select * from modelos_email";
						$rs = mysql_query($sql);
						while($row = mysql_fetch_assoc($rs)){
							$assunto  = $row['assunto'] ;
							$id  = $row['id'] ;
							?>
							<option value="<?=$id?>"><?=$assunto?></option> 
						<? } ?>
						-->

					</select>
					  </ul>  
				</div> 
				
                <div class="sect" style="clear:both;">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					  
					<form method="get">
					<tr>
					<th width="60">ID <input value ="<?=$_REQUEST['id']?>" type="text"  name="id"  id="id" style="width: 90%;color:#303030;font-size:11px;"> </th>
					 <th width="30">Nome <input type="text"  value="<?=$_REQUEST['realname']?>" name="realname"  id="realname" style="width: 100%;color:#303030;font-size:11px;"></th>
					<th width="30">Email <input type="text"  value="<?=$_REQUEST['email']?>" name="email"  id="email" style="width: 100%;color:#303030;font-size:11px;"></th>
					<th width="30">Telefone <input type="text"  value="<?=$_REQUEST['mobile']?>" name="mobile"  id="mobile" style="width: 100%;color:#303030;font-size:11px;"></th>
					
					<th width="100">Endereço <input type="text"  value="<?=$_REQUEST['address']?>" name="address"  id="address" style="width: 100%;color:#303030;font-size:11px;"></th>
					<th width="100">Bairro <input type="text"  value="<?=$_REQUEST['bairro']?>" name="bairro"  id="bairro" style="width: 100%;color:#303030;font-size:11px;"></th>
					<th width="100">Cidade <input type="text"  value="<?=$_REQUEST['cidadeusuario']?>" name="cidadeusuario"  id="cidadeusuario" style="width: 100%;color:#303030;font-size:11px;"></th>
					<th width="100">UF <input type="text"  value="<?=$_REQUEST['estado']?>" name="estado"  id="estado" style="width: 100%;color:#303030;font-size:11px;"></th>
					<th width="100">CPF/CNPJ </th>
					<th width="30">Comissões geradas para o site </th>
					<th width="30">Comissões paga ao site </th>
					<th width="30">Saldo devedor</th>
					 
					<!-- <th width="100">Onde? <input type="text"  value="<?=$_REQUEST['local']?>" name="local"  id="local" style="width: 100%;color:#303030;font-size:11px;"></th> -->
					<th width="100">Data cadastro </th>
					   
					<th width="190"> 
					<button style="width: 60px;" type="submit"><span>Buscar</span></button>
					<button style="width: 60px"  onclick="resetFilter()" type="button"><span>Limpar</span></button>
					</th>
					</tr>
					</form>
				   
				    <?php if(is_array($users)){foreach($users AS $index=>$one) { $bregistro =  true; ?>
					<?php
					
						/* Função retorna algumas informações de saldo de comissões do pedido. */
						$Comissao = getSaldoComissao($one['id']);
						
						$SaldoComissao = explode("#", $Comissao);
						$saldo_devedor = $SaldoComissao[0];
						$credito = $SaldoComissao[1];
						
						$saldo = getSaldo($one['id']);
						
						$color_devedor = "#FFA500";
						$color_credito = "#32CD32";
						$color_saldo = "#DC5755";
						$color_status = "#fff";
						
						if(empty($saldo)) {
							$saldo = "0,00";
							$color_saldo = "#333";
						}
						
						if(empty($saldo_devedor)) {
							$saldo_devedor = "0,00";
							$color_devedor = "#333";
						}
						
						if(empty($credito)) {
							$credito = "0,00";
							$color_credito = "#333";
						}
						
						/* Caso o número retornado seja negativo, quer dizer que o cliente tem saldo. */
						if($saldo < 0) {
							$color_saldo = "#32CD32";
						}
						
						if($one['status'] == "desativado") {
							$color_status = "red";
						}
						
						
					?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td style="background:<?php echo $color_status; ?>"><input class='cinput' style='width:20px;' id='mail' value='<?php echo $one['email'];?>' type='checkbox' name='emailmarcado'>  <?php echo $one['id']; ?> </td> 
						<td><?php echo $one['realname'];?></td>
						<td><?php echo $one['email'];?></td>  
						<td><?php echo $one['mobile'];?></td>  
						<td><?php echo $one['address'];?></td>  
						<td><?php echo $one['bairro'];?></td>  
						<td><?php echo $one['cidadeusuario'];?></td>  
						<td><?php echo $one['estado'];?></td>  
						<td><!-- <?php echo $one['recode']?> --><?php echo $one['cpf'];?></td> 
						<td width="140" style="color:<?php echo $color_devedor; ?>;">R$ <?php echo number_format($saldo_devedor, 2, ",", "."); ?></td> 
						<td width="140" style="color:<?php echo $color_credito; ?>;">R$ <?php echo number_format($credito, 2, ",", "."); ?></td> 
						<td width="100" style="color:<?php echo $color_saldo; ?>;">R$ <?php echo number_format($saldo, 2, ",", ".");?></td> 
						<td><?php if($one['id'] != "1") { echo date('d-m-Y H:i', $one['create_time']); } ?></td> 
						 <td class="op">
						<!--  <a href="javascript:detalhe('<?php echo $one['id']; ?>')" ><img alt="Detalhes do usuário" title="Detalhes do usuário" src="/media/css/i/detalhe2.png" style="width: 22px;"></a> -->
						 <a href="/vipmin/user/edit.php?id=<?php echo $one['id']; ?>"><img alt="Editar usuário" title="Editar usuário" src="/media/css/i/editar.png" style="width: 22px;"></a> 
						<?php if($one['id'] != "1") {?> 
							<a href="<?php echo $ROOTPATH; ?>/vipmin/user/billing.php?iduser=<?php echo $one['id']; ?>"><img style="width: 22px;" src="<?php echo $ROOTPATH; ?>/media/css/i/detalhe2.png" title="Ver faturas" alt="Ver faturas"></a>
							<?php if(!($one['status'] == "desativado")) { ?><a href="/ajax/manage.php?action=userdeactivate&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja desativar esse usuário ?" ><img alt="Desativar" title="Desativar" style="width: 22px;" src="/media/css/i/excluir.png"></a><?php } ?>
							<?php if($one['status'] == "desativado") { ?><a href="/ajax/manage.php?action=useractivate&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja ativar esse usuário ?" ><img alt="Ativar" title="Ativar" style="width: 22px;" src="/media/css/i/Accept-icon.png"></a><?php } ?>
							<a href="#" class="tk_billing" id="<?php echo $one['id']?>#<?php echo $one['realname']?>#<?php echo $one['email']?>#<?php echo number_format($saldo, 2, ",", "."); ?>"><img alt="Gerar fatura" title="Gerar fatura" style="width: 22px;" src="/media/css/i/billing.png"></a>
							<a  href="<?=$ROOTPATH?>/store/<?php echo $one['id']; ?>"  target="_blank" class="link-1"><img alt="Loja" title="Loja" style="width: 22px;" src="/skin/padrao/images/store.png"></a>
						<? } ?>
						</tr>
					<?php }}?>
					<?if(!$bregistro){?><tr><td colspan="13" style="text-align: center;">Nenhum registro encontrado. Redefina sua pesquisa</tr><? } ?>
					<tr><td colspan="15"><?php echo $pagestring; ?></tr>
                    </table>
				</div>
            </div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
<div style='display:none'>
	<div id='inline_billing' style='background:#fff; height:110px; padding:10px; width:345px !important'>
		<div id="BillForm" class="formulario span-8 last">
			<input type="hidden" class="iduser" id="iduser">
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
						<option value="Pagseguro">Pagseguro</option>
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
						<button id="btnEnviar" class="btn btn-primary write-review" style="width:94px;" onclick="javascript:GenerateBilli();"  title="Enviar" data-tipo-anuncio="Usados" data-tipo-veiculo="Carro" data-id="11239890"   class="span-4 last raio-5 size-14-bold bt-verm margin-top-10">Gerar</button>
						</div>
						<DIV><BR><BR></DIV>				
					</div>
				</div>
			</div>
		</div> 
	</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->
<script>
  
jQuery(".tk_billing").colorbox({inline:true, href:"#inline_billing",width:"700px",height:"870px"});

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
function gerarExcel(){
	var url = <?php echo "'" . $INI['system']['wwwprefix'] . "';"; ?>

	if($('#id').val() != ''){
		var id = $('#id').val();
	}else{
		var id = 'undefined';
	}

	if($('#realname').val() != ''){
		var realname = $('#realname').val();
	}else{
		var realname = 'undefined';
	}

	if($('#email').val() != ''){
		var email = $('#email').val();
	}else{
		var email = 'undefined';
	}

	if($('#mobile').val() != ''){
		var mobile = $('#mobile').val();
	}else{
		var mobile = 'undefined';
	}

	if($('#cpf').val() != ''){
		var cpf = $('#cpf').val();
	}else{
		var cpf = 'undefined';
	}

	if($('#address').val() != ''){
		var address = $('#address').val();
	}else{
		var address = 'undefined';
	}

	if($('#bairro').val() != ''){
		var bairro = $('#bairro').val();
	}else{
		var bairro = 'undefined';
	}

	if($('#cidadeusuario').val() != ''){
		var cidadeusuario = $('#cidadeusuario').val();
	}else{
		var cidadeusuario = 'undefined';
	}

	if($('#estado').val() != ''){
		var estado = $('#estado').val();
	}else{
		var estado = 'undefined';
	}

	if($('#money').val() != ''){
		var money = $('#money').val();
	}else{
		var money = 'undefined';
	}

	if($('#local').val() != ''){
		var local = $('#local').val();
	}else{
		var local = 'undefined';
	}

	var params = 'id='+id+'&realname='+realname+'&email='+email+'&mobile='+mobile+'&cpf='+cpf+'&address='+address+'&bairro='+bairro+'&cidadeusuario='+cidadeusuario+'&estado='+estado+'&money='+money+'&local='+local;
	window.open(url + '/vipmin/user/excel.php?'+params, '_blank');
}

	
$(".tk_billing").click(function(){

	var param = $(this).attr('id');
	var params = param.split("#");
	
	var id = params[0];
	var nome = params[1];
	var email = params[2];
	var saldo = params[3];
	
	if(id == "" || nome == "" || email == "" || saldo == "" ) {		
		window.alert("Ocorreu algum erro inesperado. Tente novamente mais tarde!");
		location.href="<?php $ROOTPATH; ?>/vipmin/user/index.php";
		return;
	}
	else {	
		$(".NameUser").html(nome);
		$(".BalanceUser").html("R$ " + saldo);
		$(".iduser").val(id);
	}
});

function GenerateBilli() {
	
	var id = $(".iduser").val();	
	var descricao = $("#txtDesricao").val();
	var valor = $("#txtValor").val();
	var pagamento = $("#textPagamento").val();
	var status = $("#textStatus").val();
	var observacoes = $("#txtMsg").val();
	
	if($("#txtSendBilli").is(':checked')) {
		enviarfatura = 1;
	}
	else {
		enviarfatura = 0;
	}
	
	if(id == "") {
		window.alert("Ocorreu algum erro inesperado. Tente novamente mais tarde!");
		location.href="<?php $ROOTPATH; ?>/vipmin/user/index.php";
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
		   data: "action=criar&iduser="+id+"&valor="+valor+"&pagamento="+pagamento+"&status="+status+"&descricao="+descricao+"&observacoes="+observacoes+"&enviarfatura="+enviarfatura,
		   success: function(msg){
		   
		   if( jQuery.trim(msg)==""){
				jQuery.colorbox({html:"<p>"+msg+"</p>"});
				location.href = "<?php echo $ROOTPATH; ?>/vipmin/user/index.php";
			}  
		   else {
					jQuery.colorbox({html:"<p>"+msg+"</p>"});
					location.href = "<?php echo $ROOTPATH; ?>/vipmin/user/index.php";
				}
			 }
		 });
}

</script>
