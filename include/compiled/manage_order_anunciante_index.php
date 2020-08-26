<?php include template("manage_anunciante_header"); ?>
<?php 
if($_REQUEST['state']=="pay") { 
	$selectpay="selected";
}
if($_REQUEST['state']=="unpay") { 
	$selectunpay="selected";
}
?>
<style>
	#log_tools {
		float: none;
	}
	h4 {
		
		margin-top: 15px !important;
		margin-left: 0px !important;
	}
</style>
<div id="coupons" class="container-fluid"> 
    <div id="content" class="coupons-box clear mainwide row">
		<div class="box clear col-md-12 col-xs-12 col-sm-12"> 
            <div class="box-content">
				<div class="option_box">
					<div class="top-heading group"> 
						<div class="col-md-10 col-xs-12 col-sm-12">
							<h4>
								Pedidos
							</h4>
						</div> 					 						
					</div>  
					<div class="paginacaotop"><?php echo $pagestring; ?></div>
					<div class="sect" style="clear:both;">
						<div class="table-responsive">
							<table id="orders-list" class="table table-inverse">
								<thead class="thead-inverse">
									<form method="get">
									<tr style="background: #038BA3;color: #FFF;">
									<th width="40">Ped. <input value ="<?=$_REQUEST['id']?>" type="text"  name="id"  id="id" style="width: 43%;color:#303030;font-size:11px;" class="hidden-xs hidden-sm"> </th>

									<th width="80">
										Dt. Ped.
										<input title="Data do Pedido" type="text"  value="<?=$_REQUEST['datapedido']?>" name="datapedido"  id="datapedido" style="width: 30%;color:#303030;font-size:11px;" class="hidden-xs hidden-sm">
										<img  style="cursor:pointer;" onclick="javascript:displayCalendar(document.forms[0].datapedido,'dd/mm/yyyy',this);" alt="select date" src="<?=$ROOTPATH?>/media/css/i/calendar.png"> 
									</th> 
									
									<th width="60">Nome do usuário</th>
									 <th width="50">Total Produtos </th>
									 <th width="50">Frete </th>
									 <th width="50">Total a pagar </th>
									 <th width="90">Comissão do site </th>
									 <th width="90">Valor a receber do site </th>
									 <th width="130">Status liberação do dinheiro </th>
									<th width="40">Status   
									<select name="state"  id="state" style="width: 95%;color:#303030;font-size:11px;height:19px;font-weight:normal;"  class="hidden-xs hidden-sm">
									<option value=""></option>
									<option <?=$selectpay?> value="pay">Pago</option>
									<option <?=$selectunpay?> value="unpay">Pendente</option>
									</select>
									</th> 
									 <!-- <th width="50">Pag/Créd </th> -->
									 <th width="32">Código Rastreio</th>   
									 <th width="60">Andamento do pedido </th>   
									 <th width="50">Retorno Pagamento</th>  
									
									 
									<th width="100">  
										<button type="submit" class="btn btn-warning" style="text-transform:uppercase;font-weight: bold;">
											Buscar
										</button>
										<button onclick="resetFilter()" type="button" class="btn btn-primary" style="text-transform:uppercase;font-weight: bold;">
											Limpar
										</button>
									</th>
									</tr>
									</form>
									 
									 <?php if(is_array($orders)){foreach($orders AS $index=>$one) { 
									 
											$bregistro 		=  true;  
											$corbg 	=	"";
											$statuspedido	=	"";
										
											if($one['statuspedido']=="cancelado"){
												$corbg ="red";
												$statuspedido="Cancelado em ".date('d/m/Y H:i', strtotime($one['datacancelamento']) );
											}
											else if($one['statusliberacao']=='Pago ao vendedor'){
												$corbg ="green";
											}
											else if($one['statusliberacao']=='Pagamento retido pelo site!'){
												$corbg ="red";
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
									<tr <?php echo $index%2?'':'class="alt"'; ?> id="order-list-id-<?php echo $one['id']; ?>"  style="background: #A8D7D1;color: #FFF;">
										<td style="background:<?=$corbg?>" ><?php echo $one['id']; ?></td>
										<td><?php echo date('d/m/Y H:i', strtotime($one['datapedido']) ); ?></td> 
										<td><?php echo $users[$one['user_id']]['realname']; ?> <?php if(Utility::IsMobile($users[$one['user_id']]['mobile'])){?>&nbsp;&raquo;&nbsp;<a href="/ajax/misc.php?action=sms&v=<?php echo $users[$one['user_id']]['mobile']; ?>" class="ajaxlink">SMS</a><?php }?></td>
										<? if($one['tipo'] !="promocional"){?> 
										<?
										 
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
											$one['statusliberacao'] = "Aguardando pagamento.";
										}
																		
										?>
										<td><span class="money"><?php echo $currency; ?></span><?php echo  moneyit3($one['origin'])  ; ?></td>
										<td><span class="money"><?php echo $currency; ?></span><?php echo  moneyit3($one['valorfrete'])  ; ?></td>
										<td style="color:#333";><span class="money"><?php echo $currency; ?></span><?php echo  moneyit3($valortotal); ?></td>
										<td style="color:#333";><span class="money"><?php echo $currency; ?></span><?php echo  moneyit3($one['comissaosite']); if(!(empty($one['porcentagem']))) { echo " (" . $one['porcentagem'] . "% + 1,00)"; } ?></td>
										<td style="color:#333";><span class="money"><?php echo $currency; ?></span><?php echo  moneyit3($one['valorvendedor']); ?></td>
										<td><span class="money"></span><?php echo  $one['statusliberacao']; ?></td>
										<td><span class="money"> <?php  if($one['state']=="pay") { echo "<font color=#FAC899>Pago em ".date('d/m/Y H:i', strtotime($one['datapagamento']) )."</font>"; } else { echo "Pendente"; } ?></td>
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
										   
										   <!--<a href="javascript:statusEntrega('<?php echo $one['id']; ?>')"><img alt="Alterar status do pedido" title="Alterar status da pedido" src="/media/css/i/entrega.png" style="width: 28px;"></a>  -->
										   <!--<a href="javascript:logStatusEntrega('<?php echo $one['id']; ?>')"><img alt="Ver histórico de Status de Entrega" title="Ver histórico de Status de Entrega" src="/media/css/i/log.png" style="width: 28px;"></a>  -->
										  <? if($one['statuspedido']!='cancelado'){?><a href="/ajax/manage.php?action=ordercancel&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja cancelar esse pedido ?" ><img alt="Cancelar pedido" title="Cancelar pedido" style="width: 22px;" src="/media/css/i/cancel-icon.png"></a><? }?>
										
										
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
								</thead>
						</table>
					</div>
				</div>
            </div>
            <div class="box-bottom"></div>
        </div>
    </div>
</div>

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