<?php include template("manage_header");?>
<?php 
if($_REQUEST['state']=="pay") { 
	$selectpay="selected";
}
if($_REQUEST['state']=="unpay") { 
	$selectunpay="selected";
}
?>
<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons">
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
			 <div class="option_box">
				 <div class="top-heading group"> <div class="left_float"><h4>Pedidos</h4></div> 
						<div style="padding: 10px;">
								<ul id="log_tools"> <li id="log_switch_referral"><a title="Consultar pedidos" href="/vipmin/order/index.php">Todos os Pedidos</a></li> </ul>
						 </div>						
					</div>  
					<div class="paginacaotop"><?php echo $pagestring; ?></div>
					<div class="sect" style="clear:both;">
						<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
						<form method="get">
						<tr>
						<th width="40">Ped. <input value ="<?=$_REQUEST['id']?>" type="text"  name="id"  id="id" style="width: 43%;color:#303030;font-size:11px;"> </th>

						<th width="80">
							Dt. Ped.
							<input title="Data do Pedido" type="text"  value="<?=$_REQUEST['datapedido']?>" name="datapedido"  id="datapedido" style="width: 30%;color:#303030;font-size:11px;">
							<img  style="cursor:pointer;" onclick="javascript:displayCalendar(document.forms[0].datapedido,'dd/mm/yyyy',this);" alt="select date" src="<?=$ROOTPATH?>/media/css/i/calendar.png"> 
						</th> 
						
						<th width="60">Email <input type="text"  value="<?=$_REQUEST['uemail']?>" name="uemail"  id="uemail" style="width: 86%;color:#303030;font-size:11px;"></th>
						 <th width="50">Total Produtos </th>
						 <th width="50">Frete </th>
						 <th width="90">Total </th>
						 <th width="90">Comissão do site </th>
						 <th width="90">Valor de transferência para Vendedor</th>
						 <th width="130">Status do pagamento para vendedor </th>
						 <th width="130">Forma de pagamento </th>
						<th width="40">Status   
						<select name="state"  id="state" style="width: 95%;color:#303030;font-size:11px;height:19px;font-weight:normal;" >
						<option value=""></option>
						<option <?=$selectpay?> value="pay">Pago</option>
						<option <?=$selectunpay?> value="unpay">Pendente</option>
						</select>
						</th> 
						<th width="50">Retorno Pagseguro &nbsp;<img class="tTip" title="Baixa Automática são os pedidos atualizados e cupons enviados automaticamente pelo gateway de pagamento, ex: Moip, quando estes forem pagos. Para isso, configure o retorno do pagamento corretamente." style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"></th>
						<!-- <th width="50">Pag/Créd </th> -->
						 <th width="32">Código Rastreio</th>   
						 <th width="60">Andamento do pedido </th>   
					 <th width="50">Retorno Pagamento</th>  
						
						 
						<th width="100">  
						<button style="width: 60px;" type="submit"><span>Buscar</span></button>
						<button style="width: 60px"  onclick="resetFilter()" type="button"><span>Limpar</span></button>

						<!-- <button style="width: 60px"  onclick="gerarPDF()" type="button"><span>PDF</span></button>-->

						<!--<button style="width: 60px" onclick="gerarExcel()" type="button"><span>Excel</span></button>-->

						</th>
						</tr>
						</form>
						 
						 <?php if(is_array($orders)){foreach($orders AS $index=>$one) { 
						 
								$bregistro 		=  true;  
								$corbg 	=	"";
								$statuspedido	=	"";
								$PagamentoLiberacao = 0;
							
								if($one['statuspedido']=="cancelado"){
									$corbg ="red";
									$statuspedido="Cancelado em ".date('d/m/Y H:i', strtotime($one['datacancelamento']) );
								}
								else if($one['statusliberacao']=='Pago ao vendedor'){
									$corbg ="green";
								}	
								else if(($one['statusliberacao'] != "Pago ao vendedor" || $one['statusliberacao'] == "Valor pago direto pelo cliente") and $one['service'] != "Combinar com vendedor"){
									$corbg ="orange";
									$PagamentoLiberacao = 1;
								}								
								else if($one['statusliberacao']=='Qualificação negativa. <br /> Pagamento retido pelo site!'){
									$corbg ="red";
								}								
								else if($one['statusliberacao']=='Qualificação negativa.'){
									$corbg ="red";
								}
								else if($one['state']=='pay'){
									$corbg ="blue";
								}
						 ?>
						<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>"  >
							<td style="background:<?=$corbg?>" ><?php echo $one['id']; ?></td>
							<td><?php echo date('d/m/Y H:i', strtotime($one['datapedido']) ); ?></td> 
							<td><a style="color:#A2C92D;" href="/ajax/manage.php?action=userview&id=<?php echo $one['user_id']; ?>" class="ajaxlink_edit"><?php echo $users[$one['user_id']]['email']; ?> </a><?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">SMS</a><?php }?></td>
							<? if($one['tipo'] !="promocional"){?> 
							<?
						  	$currency  = "R$";
							$service="";
							if($one['state']=='pay'){
								$sql =  "SELECT count(id) as total FROM `coupon` where order_id = ".$one['id']; 
								$rs = mysql_query($sql);
								$linha = mysql_fetch_object($rs);
								$total = $linha->total;
							}
							
							 $team  = Table::Fetch('team',$one['team_id']);
							 
							 $codigovalecompras 	= $one[codigovalecompras];
							 $valorcupomdesconto  = $one[valecompras];
							 if(!$valorcupomdesconto){
						 		$valorcupomdesconto=0;
					 		} 
								   
							$valortotal = str2num($one['origin']) + str2num($one['valorfrete'])  - $valorcupomdesconto ;
							
							if($one['statusliberacao'] == "Aguardando Pagamento") {
								$one['statusliberacao'] = "<span style='color:orange'>Aguardando pagamento para vendedor</a>";
							}
							 
							if(  $one['state']=='unpay') { 
								$one['statusliberacao'] = "Pedido ainda não foi pago";
							}	
							else if($one['service'] == "Combinar com vendedor") {
								$one['valorvendedor'] = "valor pago direto do cliente ao vendedor";
								$service = "Combinar com vendedor<br><a target='_blank' style='color:#A2C92D;font-size:12px;' href='" . $ROOTPATH . "/vipmin/misc/feedback.php?id=" . $one['id'] . "'>ver proposta</a>";
								$currency = "";
							}
															
							?>
							<td><span class="money"><?php echo $currency; ?></span><?php echo  moneyit3($one['origin'])  ; ?></td>
							<td><span class="money"><?php echo $currency; ?></span><?php echo  moneyit3($one['valorfrete'])  ; ?></td>
							<td style="color:#333";><span class="money"><?php echo $currency; ?></span><?php echo  moneyit3($valortotal); ?></td>
							<td style="color:#333";><span class="money"><?php echo $currency; ?></span><?php echo  moneyit3($one['comissaosite']); if(!(empty($one['porcentagem']))) { echo " (" . $one['porcentagem'] . "% + 1,00)"; } ?></td>
							<td style="color:#333";><span class="money"><?php echo $currency; ?></span><?php echo  $one['valorvendedor']; ?></td>
							<td><span class="money"><?php echo $one['statusliberacao']; ?></td>
							<td><span><? if(!(empty($service))){ echo  $service; } else { echo "-"; } ?></span></td>
							<td><span class="money"> <?php  if($one['state']=="pay") { echo "<font color=#FAC899>Pago em ".date("d/m/Y H:i", $one['pay_time'])."</font>"; } else { echo "Pendente"; } ?></td>
							<td><span class="money"> </span><?php  if($one['statuspedido']=='cancelado'){echo $statuspedido; } else{  if($one['state']=='pay'){ if($one['retorno_automatico']=='sim'){?>Automática<? } else {?> Manual<?} } else { echo "Aguardando...";}}?> </td> 
							<td><span class="money"><? if($one['state']=='pay'){ if($one['codigorastreio']){?><?php echo  $one['codigorastreio'];?>
							<? } else {?> 
								<div id="informartxt"><a style="color:#8FC92E;" href="javascript:informartrack();">informar</a></div>
								<div id="informarcampo" style="display:none;"><input type="text" id="codigorastreio_<?=$one['id']?>" name="codigorastreio_<?=$one['id']?>" width="40"> <input type='button' value="ok" onclick="gravatrack('<?=$one['id']?>')";></div>
								<div id="valorcodastreio_<?=$one['id']?>"></div>
							<? }
							}  else {  echo " - "; } ?>
							</td> 
						    <td><span class="money"><?php 
							   if($one['statusentrega']){ 
									echo $one['statusentrega'].' - '.date('d/m/Y H:i', strtotime($one['data_ultima_atualizacao'])); 
								} ?>
							</td>  
							 <td><span class="money"><?php echo  $one['msg_retorno_pagamento'] ; ?></td>  
							<td class="op" nowrap> <a href="javascript:detalhepedido('<?php echo $one['id']; ?>')"><img alt="Detalhes do Pedido" title="Detalhes do Pedido" src="/media/css/i/detalhe2.png" style="width: 22px;"></a>  
						       <!--<a href="javascript:statusEntrega('<?php echo $one['id']; ?>')"><img alt="Alterar status da entrega" title="Alterar status da entrega" src="/media/css/i/entrega.png" style="width: 28px;"></a>
						       <a href="javascript:logStatusEntrega('<?php echo $one['id']; ?>')"><img alt="Ver histórico de Status de Entrega" title="Ver histórico de Status de Entrega" src="/media/css/i/log.png" style="width: 28px;"></a>   --> 
							  <? if($one['statuspedido']!='cancelado'){?><a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja cancelar esse pedido ?" ><img alt="Cancelar pedido" title="Cancelar pedido" style="width: 22px;" src="/media/css/i/cancel-icon.png"></a><? }?>
							  <? if($one['state']=='unpay'){?><a href="/ajax/manage.php?action=ordercash&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja atualizar este pedido para pago ?" ><img alt="Alterar pedido para pago. Um email de notificação será enviado para o cliente" title="Alterar pedido para pago. Um email de notificação será enviado para o cliente" style="width: 26px;" src="/media/css/i/payment-icon.png"></a><? }?>
							  <a href="/ajax/manage.php?action=orderremoveforce&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar esse pedido definitivamente ?" ><img alt="Excluir" title="Excluir" style="width: 22px;" src="/media/css/i/excluir.png"></a>
							  <a href="<?=$ROOTPATH?>/vipmin/user/qualification.php?id=&pedido=<?php echo $one['id']; ?>" ><img alt="Ver a qualificação do usuário para este pedido" title="Ver a qualificação do usuário para este pedido" style="width: 28px;" src="/media/css/i/gico.png"></a>
							  <?php if($PagamentoLiberacao == 1 and $one['state']=='pay') { ?><a href="/ajax/manage.php?action=PagoVendedor&id=<?php echo $one['id']; ?>')" class="ajaxlink"><img alt="Pagar ao vendedor" title="Pagar ao vendedor" src="/media/css/i/pay_cash.png" style="width: 28px;"></a><?php } ?>
							
							</td>
							<? }
							else{?>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
								<td>  -  </td>
						 
							<? } ?>
						</tr>
						<?php }}?>
						<?if(!$bregistro){?><tr><td colspan="17" style="text-align: center;">Nenhum registro encontrado. Redefina sua pesquisa</tr><? } ?>
						<tr><td colspan="18"><?php echo $pagestring; ?></tr>
						</table>
					</div>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>
</div> <!-- bd end -->
</div> <!-- bdw end -->

<script>
function msg_reenvia(id){ 
 
	 jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Aguarde, o cupom está sendo enviado...</div>"});
	 $.get(WEB_ROOT+"/ajax/manage.php?origem=pedido&action=reenviacupom&id="+id,
	function(data){ 
		jQuery.colorbox({html:data});
	});	 
}

function msg_pago(){
	jQuery(document).ready(function(){   
			jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Aguarde, o status deste pedido está sendo alterado para pago e cupom está sendo enviado ao cliente...</div>"});
		});
}
function detalhepedido(id){
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Buscando pedido: "+id+"</div>"});
	$.get(WEB_ROOT+"/include/compiled/manage_ajax_dialog_orderview.php?id="+id,
	function(data){ 
		jQuery.colorbox({html:data});
	}); 
} 

function statusEntrega(id){
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> abrindo tela...</div>"});
	$.get(WEB_ROOT+"/include/compiled/ajax_dialog_entrega.php?id="+id,
	function(data){ 
		jQuery.colorbox({html:data});
	}); 
} 		
</script>


 <script> 
 function resetFilter(){
	location.href  = '<?php echo $_SERVER["PHP_SELF"] ?>';
 } 

function msg(){
	//jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Deletando este pedido...</div>"});
}  
 function msg_edit(){
	//jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Buscando dados. Aguarde...</div>"});

} 
function informartrack(){
		$("#informartxt").hide();
		$("#informarcampo").show();
}

function gravatrack(id){
	
		$("#informartxt").hide();
		$("#informarcampo").hide();
		
		code = $('#codigorastreio_'+id).val();
		 
		 jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Salvando o código e avisando o cliente...</div>"});
			
		$.get(WEB_ROOT+"/include/funcoes.php?acao=gravatrack&id="+id+"&code="+code,
		function(data){  
			if(jQuery.trim(data)==""){
				$("#valorcodastreio_"+id).html(code);
				jQuery.colorbox({html:"Código de rastreio dos correios salvo com sucesso. O cliente já foi avisado."});
			}
			else{
				jQuery.colorbox({html:data});
			}
		}); 
	
}

function logStatusEntrega(id){ 
		 
		jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Buscando o histórico de status do pedido "+id+"...</div>"});
			
		$.get(WEB_ROOT+"/include/funcoes.php?acao=logStatusEntrega&id="+id,
		function(data){  
			jQuery.colorbox({html:data}); 
		});  
}

function gerarPDF(){
	var url = <?php echo "'" . $INI['system']['wwwprefix'] . "';"; ?>
	
	if($('#id').val() != ''){
		var id = $('#id').val();
	}else{
		var id = 'undefined';
	}

	if($('#datapedido').val() != ''){
		var datapedido = $('#datapedido').val();
	}else{
		var datapedido = 'undefined';
	}

	if($('#uemail').val() != ''){
		var uemail = $('#uemail').val();
	}else{
		var uemail = 'undefined';
	}

	if($('#team_id option:selected').val() != ''){
		var team_id = $('#team_id option:selected').val();
	}else{
		var team_id = 'undefined';
	}

	if($('#quantity').val() != ''){
		var quantity = $('#quantity').val();
	}else{
		var quantity = 'undefined';
	}

	if($('#origin').val() != ''){
		var origin = $('#origin').val();
	}else{
		var origin = 'undefined';
	}

	if($('#state option:selected').val() != ''){
		var state = $('#state option:selected').val();
	}else{
		var state = 'undefined';
	}

	if($('#credit').val() != ''){
		var credit = $('#credit').val();
	}else{
		var credit = 'undefined';
	}

	var params = 'id='+id+'&datapedido='+datapedido+'&uemail='+uemail+'&team_id='+team_id+'&quantity='+quantity+'&origin='+origin+'&state='+state+'&credit='+credit;
	window.open(url + '/vipmin/order/pdf.php?'+params, '_blank');
}

function gerarExcel(){
	var url = <?php echo "'" . $INI['system']['wwwprefix'] . "';"; ?>
	
	if($('#id').val() != ''){
		var id = $('#id').val();
	}else{
		var id = 'undefined';
	}

	if($('#datapedido').val() != ''){
		var datapedido = $('#datapedido').val();
	}else{
		var datapedido = 'undefined';
	}

	if($('#uemail').val() != ''){
		var uemail = $('#uemail').val();
	}else{
		var uemail = 'undefined';
	}

	if($('#team_id option:selected').val() != ''){
		var team_id = $('#team_id option:selected').val();
	}else{
		var team_id = 'undefined';
	}

	if($('#quantity').val() != ''){
		var quantity = $('#quantity').val();
	}else{
		var quantity = 'undefined';
	}

	if($('#origin').val() != ''){
		var origin = $('#origin').val();
	}else{
		var origin = 'undefined';
	}

	if($('#state option:selected').val() != ''){
		var state = $('#state option:selected').val();
	}else{
		var state = 'undefined';
	}

	if($('#credit').val() != ''){
		var credit = $('#credit').val();
	}else{
		var credit = 'undefined';
	}

	var params = 'id='+id+'&datapedido='+datapedido+'&uemail='+uemail+'&team_id='+team_id+'&quantity='+quantity+'&origin='+origin+'&state='+state+'&credit='+credit;
	window.open(url + '/vipmin/order/excel.php?'+params, '_blank');
}

 </script>