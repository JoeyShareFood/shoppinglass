<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
               	<div class="option_box"> 
					<div class="top-heading group"> <div class="left_float"><h4>Vale Compras - Cupons</h4></div> 
						<div style="padding: 10px;">	
							<ul id="log_tools"> <li id="log_switch_referral"><a title="Cadastrar novo vale compra" href="/vipmin/user/valecupomedit.php">Novo</a></li> </ul>
							<ul id="log_tools"> <li id="log_switch_referral"><a  href="/vipmin/user/valecupom.php">Todos</a></li> </ul> 
						</div>	
					</div> 
             	<div class="paginacaotop" style="width:50%"><?php echo $pagestring; ?></div> 
				
                <div class="sect" style="clear:both;">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					  
					<form method="get">
					<tr> 
					 <th width="130">Cupom <input type="text"  value="<?=$_REQUEST['codigo']?>" name="codigo"  id="codigo" style="width: 30%;color:#303030;font-size:11px;"></th>
					<th width="30">Valor  </th>
					<th width="10">Qtde de uso  </th> 
					<th width="10">Usado  </th>
					<th width="30">Limitar 1 cupom por usuário </th>
					<th width="10">Status  </th> 
		  
					<th width="50"> 
					<button style="width: 60px;" type="submit"><span>Buscar</span></button>
					<button style="width: 60px"  onclick="resetFilter()" type="button"><span>Limpar</span></button>
					</th>
					</tr>
					</form>
				   
				    <?php if(is_array($valecompras)){foreach($valecompras AS $index=>$one) { $bregistro =  true; 
					
					$limiteporusuario="Não";
					if($one['limiteporusuario']=="1"){
						$limiteporusuario="Sim";
					}
					
					$order_id = " - ";
					if($one['order_id']==""){
						$order_id = $one['order_id'];
					}
					?>
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>"> 
						<td><?php echo $one['codigo'];?></td>
						<td>R$ <?php echo $one['valor'];?></td>  
						<td><?php echo $one['limite'];?></td>
						<td><?php echo $one['usado'];?></td>
						<td><?php echo $limiteporusuario;?></td> 
						<td><?php echo $one['status'];?></td>  
						 <td class="op">
						 <a href="/vipmin/user/valecupomedit.php?id=<?php echo $one['id']; ?>"><img alt="Editar" title="Editar" src="/media/css/i/editar.png" style="width: 22px;"></a> 
						<? if($one['usado'] == 0){?>						
							<a href="/ajax/manage.php?action=valecupomremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar este registro ?" ><img alt="Excluir" title="Excluir" style="width: 22px;" src="/media/css/i/excluir.png"></a>
						<? } else { echo " Cupom usado ";} ?>
						
						</tr>
					<?php }}?>
					<?if(!$bregistro){?><tr><td colspan="13" style="text-align: center;">Nenhum registro encontrado. Redefina sua pesquisa</tr><? } ?>
					<tr><td colspan="13"><?php echo $pagestring; ?></tr>
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
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Buscando registro: "+id+"</div>"});
	$.get(WEB_ROOT+"/include/compiled/manage_ajax_dialog_user.php?id="+id,
	function(data){ 
		jQuery.colorbox({html:data});
	}); 
} 
 
  function msg(){
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Deletando registro...</div>"});
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
 </script>
