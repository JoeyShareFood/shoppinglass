<?php include template("manage_anunciante_header"); ?>
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
							<?php if($selector=='failure'){?>
								 Anúncios Finalizados ou Reprovados 
							<?php } else if($selector=='success') { ?>
								 Anúncios válidos, com período finalizado 
							<?php } else if($_REQUEST['acao']=='site') { ?>
								  Anúncios atuais no site  
							<?php } else { ?>
								 Todos os Anúncios 
							<?php }?>
							</h4> 						
						</div> 
						<div class="col-md-2 col-xs-12 col-sm-12" style="padding: 10px;">
							<ul id="log_tools">
								<button style="border:none;"   onclick="javascript:location.href='<?=$ROOTPATH?>/adminanunciante/team/edit.php'"  id="run-button" class="btn btn-success" type="button">Adicionar Anúncio</button>							
							</ul>
						 </div>
					</div>  
				 
					<div class="paginacaotop"><?php echo $pagestring; ?></div>				
				
					<div class="sect" style="clear:both;">
						<div class="table-responsive">
							<table id="orders-list" class="table table-inverse">
								<thead class="thead-inverse">
									<form method="get">
										<tr style="background: #038BA3;color: #FFF;">
										<th width="40">ID <input type="text"  name="idoferta"  id="idoferta" style="width: 50%; color:#303030;font-size:11px;" class="hidden-xs hidden-sm"> </th>
										<th width="150">Nome </th>
										<th width="100"> Marca </th>
										<th width="100"> Condições </th>
										<th width="100">Categoria </th>
										<th width="40">Vendidos</th> 
										<th width="40" nowrap>Preço</th>
										<th width="180">  
											<button type="submit" class="btn btn-warning" style="text-transform:uppercase;font-weight: bold;">
												Buscar
											</button>
											<button onclick="resetFilter()" type="button" class="btn btn-primary" style="text-transform:uppercase;font-weight: bold;">
												Limpar
											</button>
										</th>
										</tr>
									</form>
									<?php 
										
										if(is_array($teams)){foreach($teams AS $index=>$one) { 
											$bregistro =  true; 
											$cidade = $cities[$one['city_id']]['nome'];	 					
											$groups = Table::Fetch('category', $one['group_id']);
									 ?>
									<?php $oldstate = $one['state']; ?>
									<?php $one['state'] = team_state($one); ?>
									<tr <?php echo $index%2?'class="normal"':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>" style="background: #A8D7D1;color: #FFF;">
										<td ><?php echo $one['id']; ?> <!-- <img alt="<?=$title?>" title="<?=$title?>" src="/media/css/i/<?=$bandeira?>" style="width: 22px;"> --></td>
										<td><?php echo $one['title']; ?></td> 
										<td nowrap><?php echo $one['marca_produto']; ?></td> 
										<td nowrap style="color:#F77274;font-weight:bold;"><?php echo $one['condicoes_produto']; ?></td> 
										<td nowrap><?php  if($groups['name']){ echo $groups['name'];} else { echo "-";  }   ?>  </td> 
										<td nowrap><?php echo $one['now_number'] ?></td> 
										<td nowrap><span class="money">De <?php echo $currency; ?></span><?php echo moneyit3($one['market_price']); ?> <br>Por <span class="money"><?php echo $currency; ?></span><?php echo moneyit3($one['team_price']); ?></td>
										<td class="op" nowrap>
										<div style="float: left; margin-right: 2px;"><a  target="_blank" href="<?=$ROOTPATH?>/produto/<?=$one['id']?>"><img alt="Visualizar Produto" title="Visualizar Produto" src="/media/css/i/Monitoring.ico" style="width: 22px;"></a></div> 
										<div style="float: left; margin-right: 2px;"><a href="/adminanunciante/team/edit.php?id=<?php echo $one['id']; ?>"><img alt="Editar Produto" title="Editar Produto" src="/media/css/i/editar.png" style="width: 22px;"></a></div>
										<!--
										<div style="float: left; margin-right: 2px;"><a href="/adminanunciante/team/atributos.php?id=<?php echo $one['id']; ?>"><img alt="Gerenciar Atributos" title="Gerenciar Atributos" src="/media/css/i/atribute.png" style="width: 22px;"></a></div>
										-->
										<div style="float: left; margin-right: 2px;"><a href="/ajax/manage.php?action=teamremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar essa Produto?" ><img alt="Excluir" title="Excluir" style="width: 17px;" src="/media/css/i/excluir.png"></a></div>
										<?php 
											$sql =  "SELECT count(id) as total FROM `coupon` where team_id = ".$one['id']; 
											$rs = mysql_query($sql);
											$linha = mysql_fetch_object($rs);
											$total = $linha->total;
										   
										   if($total  > 0 ){ 
												
											?>
										 
											<div style="float: left; margin-right: 2px;"><a href="/adminanunciante/team/down.php?id=<?php echo $one['id']; ?>" target="_blank"><img alt="Fazer download de <?=$total?> cupon(s) disponíveis" title="Fazer download de <?=$total?> cupon(s) disponíveis" style="width: 22px;" src="/media/css/i/cupom.png"></a></div>
										
										<?php } ?>
										<div style="float: left; margin-right: 2px;"><a href="/ajax/manage.php?action=duplicar&id=<?php echo $one['id']; ?>" class="processar"  ><img alt="Duplicar ProdutO. Após duplicar, Inlclua as imagens do produto duplicado." title="Duplicar Produto. Após duplicar, Inlclua as imagens do produto duplicado." style="width: 22px;" src="/media/css/i/icon-48-media.png"></a></div>
										
										</td>
									</tr>
									<?php }} ?>
									<?if(!$bregistro){?><tr><td colspan="15" style="text-align: center;">Nenhum registro encontrado.</tr><? } ?>
									<tr class="hide"><td colspan="15"><?php echo $pagestring; ?></tr>
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
 function resetFilter(){
	location.href  = '<?php echo $_SERVER["PHP_SELF"] ?>';
 }
 </script>
    <script>
  function msg(){
		jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Deletando este Anúncio...</div>"});
	}  
  function processar(){
		jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Processando, aguarde...</div>"});
	}
	
	
function gerarPDF(){
	var url = <?php echo "'" . $INI['system']['wwwprefix'] . "';"; ?>

	if($('#idoferta').val() != ''){
		var idoferta = $('#idoferta').val();
	}else{
		var idoferta = 'undefined';
	}

	if($('#team_title').val() != ''){
		var team_title = $('#team_title').val();
	}else{
		var team_title = 'undefined';
	}

	if($('#team_type option:selected').val() != ''){
		var team_type = $('#team_type option:selected').val();
	}else{
		var team_type = 'undefined';
	}

	if($('#city_id option:selected').val() != ''){
		var city_id = $('#city_id option:selected').val();
	}else{
		var city_id = 'undefined';
	}

	if($('#partner_id option:selected').val() != ''){
		var partner_id = $('#partner_id option:selected').val();
	}else{
		var partner_id = 'undefined';
	}

	var params = 'team_type='+team_type+'&team_title='+team_title+'&city_id='+city_id+'&partner_id='+partner_id;
	window.open(url + '/adminanunciante/team/pdf.php?'+params, '_blank');
}

function gerarExcel(){
	var url = <?php echo "'" . $INI['system']['wwwprefix'] . "';"; ?>

	if($('#idoferta').val() != ''){
		var idoferta = $('#idoferta').val();
	}else{
		var idoferta = 'undefined';
	}

	if($('#team_title').val() != ''){
		var team_title = $('#team_title').val();
	}else{
		var team_title = 'undefined';
	}

	if($('#team_type option:selected').val() != ''){
		var team_type = $('#team_type option:selected').val();
	}else{
		var team_type = 'undefined';
	}

	if($('#city_id option:selected').val() != ''){
		var city_id = $('#city_id option:selected').val();
	}else{
		var city_id = 'undefined';
	}

	if($('#partner_id option:selected').val() != ''){
		var partner_id = $('#partner_id option:selected').val();
	}else{
		var partner_id = 'undefined';
	}

	var params = 'team_type='+team_type+'&team_title='+team_title+'&city_id='+city_id+'&partner_id='+partner_id;
	window.open(url + '/adminanunciante/team/excel.php?'+params, '_blank');
}

function renovaranuncio(id){ 
 
	 //jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Aguarde, estamos renovando este anúncio</div>"});
	 $.get(WEB_ROOT+"/ajax/manage.php?action=renovaranuncio&id="+id,
	function(data){ 
	//	jQuery.colorbox({html:data});
		location.href  = '<?php echo $_SERVER["PHP_SELF"] ?>';
	});	 
}
function republicaranuncio(id){ 
 
	// jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Aguarde, estamos renovando este anúncio</div>"});
	 $.get(WEB_ROOT+"/ajax/manage.php?action=republica&id="+id,
	function(data){ 
		//jQuery.colorbox({html:data});
		location.href  = '<?php echo $_SERVER["PHP_SELF"] ?>';
	});	 
}
function pausar(id){ 
 
	// jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Aguarde, estamos pausando este anúncio</div>"});
	 $.get(WEB_ROOT+"/ajax/manage.php?action=pausar&id="+id,
	function(data){ 
		//jQuery.colorbox({html:data});
		location.href  = '<?php echo $_SERVER["PHP_SELF"] ?>';
	});	 
}
function resumo(id){ 
 
	// jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Aguarde, estamos pausando este anúncio</div>"});
	 $.get(WEB_ROOT+"/ajax/manage.php?action=resumo&id="+id,
	function(data){ 
		//jQuery.colorbox({html:data});
		location.href  = '<?php echo $_SERVER["PHP_SELF"] ?>';
	});	 
}

 </script>
 