<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
				<div class="option_box">
					 <div class="top-heading group"> <div class="left_float"><h4>Avaliação dos Clientes</h4></div> 
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
						<th width="10">Id </th>
						<th width="90">Nome  </th>
						<th width="30">Email  </th>
						<th width="100">Título  </th>
						<th width="230">Mensagem  </th>
						<th width="30">Pontuação  </th> 
						<th width="230">Anúncio  </th>
						<th width="10">Data  </th>
					  
						<th width="5">    
 
						</th>
						</tr>
						</form> 
							<?php if(is_array($boates)){foreach($boates AS $index=>$one) { $bregistro=true;  
							
								$user 	= Table::Fetch('user', $one['user_id']);
								$team 	= Table::Fetch('team', $one['team_id']);
								$nomeoferta =  $team['title'];  
							
							
							?>
						<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
							<td><?php echo $one['id']; ?></td>
							<td style="text-align:left;"> <?php echo $user['realname']; ?></td>
							<td style="text-align:left;"> <?php echo $user['email']; ?></td>
							<td style="text-align:left;"> <?php echo $one['titulo']; ?></td>  
							<td style="text-align:left;"> <?php echo $one['mensagem']; ?></td>  
							<td style="text-align:left;"> <?php echo $one['pontuacao']; ?></td>  
							<td style="text-align:left;"> <?php echo $nomeoferta; ?> <a style="color:orange" href="<?php echo $ROOTPATH."/produto/".$one['id']?>/<?=$nomeoferta; ?>" target="_blank"> ver </a> </td>  
							<td style="text-align:left;"> <?php echo data($one['data']); ?></td>  
							   
							<td class="op" nowrap>
							<!-- <a href="/vipmin/parceiro/boateedit.php?id=<?php echo $one['id']; ?>"><img   src="/media/css/i/editar.png" style="width: 22px;"></a> -->  
							<a href="/ajax/manage.php?action=depoimentoremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja remover este comentário  ?" ><img alt="Excluir" title="Excluir" style="width: 22px;" src="/media/css/i/excluir.png"></a>
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