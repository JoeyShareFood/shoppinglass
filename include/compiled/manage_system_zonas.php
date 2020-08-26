<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
				<div class="option_box">
					 <div class="top-heading group"> <div class="left_float"><h4>Métodos de Entrega</h4></div> 
					 	<div style="padding: 10px;">
							<ul id="log_tools"> <li id="log_switch_referral"><a title="Adicionar método de entrega" href="/vipmin/system/zonasedit.php">Adicionar método de entrega</a></li> </ul>   
						</div>
						 <!--
						<div style="padding: 10px;">
							<ul id="log_tools"> <li id="log_switch_referral"><a title="Consultar pedidos pagos com saldo de crédito" href="/vipmin/parceiro/boateedit.php">Cadastrar</a></li> </ul> 
						</div>
						-->
							
					</div> 
							 
					<div class="paginacaotop"><?php echo $pagestring; ?></div>
				 
					<div class="sect" style="clear:both;">
						<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
						
						<form method="get">
						<tr>
						<th width="10">Identificador </th>
						<th width="90">Nome</th>
						<th width="30">Prazo de entrega  </th>
						<th width="30">Valor do frete  </th>
						<th width="30">Ativo  </th>  
						<th width="30">Método dos Correios  </th>  
					  
						<th width="5">    
							Operação
						</th>
						</tr>
						</form> 
							<?php if(is_array($zonas_entrega)){foreach($zonas_entrega AS $index=>$one) { $bregistro=true;
							
							$ativo = "Sim"; 
							if($one['ativo']=="n"){
								$ativo= "Não";
							}
							$metododoscorreios = "Não"; 
							if($one['metododosistema']=="s"){
								$metododoscorreios= "Sim";
							}
							if($one['metododosistema']!="s" and !empty($one['valor_frete'])){
									$valor_frete  = "R$ ".$one['valor_frete'];
							} 
							
							$valor_frete = "R$ ".$one['valor_frete'];
							$prazo  	=  $one['prazo_entrega']. " dia(s)";
							 
							if(empty($one['valor_frete'])){
								$valor_frete=" - ";
							}
							if(empty($one['prazo_entrega'])){
								$prazo=" - ";
							} 
							if($one['metododosistema']== "s"){
									$prazo = "Calculo automático";
									$valor_frete = "Calculo automático";
							 }
							 $texto = ""; 
							if($one['metododosistema']=="s"){
								//$texto = "( Dependendo do cep, este método não será mostrado )";
							}
							
							
							?>
						<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
							<td><?php echo $one['identific']; ?></td>
							<td style="text-align:left;"> <?php echo $one['nome']; ?> <?=$texto?></td>
							<td style="text-align:left;"> <?php echo $prazo; ?></td>
							<td style="text-align:left;"> <?php echo $valor_frete; ?></td>  
							<td style="text-align:left;"> <?php echo $ativo; ?></td>   
							<td style="text-align:left;"> <?php echo $metododoscorreios; ?></td>   
							   
							<td class="op" nowrap>
							 <a href="/vipmin/system/zonasedit.php?id=<?php echo $one['id']; ?>"><img   src="/media/css/i/editar.png" style="width: 22px;"></a>    
							<? if($one['metododosistema']!="s"){?><a href="/ajax/manage.php?action=zonasremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja remover ?" ><img alt="Excluir" title="Excluir" style="width: 22px;" src="/media/css/i/excluir.png"></a><? } else {?> <img class="tTip" title="Você pode desativar qualquer método dos correios mas não pode excluir" style="cursor:help" id="Search_ToolTip" src="<?=$ROOTPATH?>/media/css/i/info.png"> <?}?>
							</td>
						</tr>
						<?php }}?>
						<?if(!$bregistro){?><tr><td colspan="13" style="text-align: center;">Nenhum registro encontrado. Redefina sua pesquisa</tr><? } ?>
						<tr><td colspan="10"><?php echo $pagestring; ?></td></tr>
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
 function resetFilter(){
	location.href  = '<?php echo $_SERVER["PHP_SELF"] ?>';
 }
function gerarExcel(){
	var url = <?php echo "'" . $INI['system']['wwwprefix'] . "';"; ?>

	if($('#title').val() != ''){
		var title = $('#title').val();
	}else{
		var title = 'undefined';
	}

	if($('#username').val() != ''){
		var username = $('#username').val();
	}else{
		var username = 'undefined';
	}

	if($('#contact').val() != ''){
		var contact = $('#contact').val();
	}else{
		var contact = 'undefined';
	}

	if($('#cidade').val() != ''){
		var cidade = $('#cidade').val();
	}else{
		var cidade = 'undefined';
	}

	if($('#homepage').val() != ''){
		var homepage = $('#homepage').val();
	}else{
		var homepage = 'undefined';
	}

	if($('#mobile').val() != ''){
		var mobile = $('#mobile').val();
	}else{
		var mobile = 'undefined';
	}

	if($('#bank_name').val() != ''){
		var bank_name = $('#bank_name').val();
	}else{
		var bank_name = 'undefined';
	}

	var params = 'title='+title+'&username='+username+'&contact='+contact+'&cidade='+cidade+'&homepage='+homepage+'&mobile='+mobile+'&bank_name='+bank_name;
	window.open(url + '/vipmin/parceiro/excel.php?'+params, '_blank');
}

  function msg(){
	//jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Deletando este registro...</div>"});
}  

 </script>