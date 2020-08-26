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
							<h4>  
								 Todos os Produtos  </h4> 
							
						</div> 
						<div> <a href="/ajax/manage.php?action=teamremoveall" class="ajaxlink" ask="Você tem certeza que deseja apagar TODOS OS ANÚNCIOS DO SITE bem como todos as referencias como faturas, depoimentos...?" ><button style="width: 200px;" type="submit"><span>APAGAR TODOS OS ANÚNCIOS </span></button> <img alt="Excluir" title="Excluir" style="width: 17px;" src="/media/css/i/excluir.png"></a>
							</div>
						<div style="padding: 10px;">
							<ul id="log_tools"> 
							
							<li id="log_switch_referral"><a title="Adicionar Anúncio" href="/vipmin/team/edit.php">Adicionar Anúncio</a></li> 
							
							</ul>   
						</div>
					</div> 
					<div class="paginacaotop"><?php echo $pagestring; ?></div>				
				
					<div class="sect" style="clear:both;">
						<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
						<form method="get">
						<tr>
						<th width="40">ID <input type="text"  name="idoferta"  id="idoferta" style="width: 50%; color:#303030;font-size:11px;"> </th>
						<th width="150">Título <input type="text"  value="<?=$_REQUEST['team_title']?>" name="team_title"  id="team_title" style="width: 75%; color:#303030;font-size:11px;"></th>
						<th width="100"> Moderação <select name="moderacao"><option value="0">Todos</option><option value="1">Publicado</option><option value="2">Não publicado</option></select> </th>
						<th width="100"> Marca </th>
						<th width="100"> Condições </th>
						<th width="100">Categoria </th>
						<th width="100" nowrap>Usuário</th>
						<th width="40">Vendidos</th> 
						<th width="40" nowrap>Preço</th>
						<th width="180">  
						<button style="width: 60px;" type="submit"><span>Buscar</span></button>
						<button style="width: 60px"  onclick="resetFilter()" type="button"><span>Limpar</span></button>
						<!-- <button style="width: 60px"  onclick="gerarPDF()" type="button"><span>PDF</span></button>-->
						<!--<button style="width: 60px" onclick="gerarExcel()" type="button"><span>Excel</span></button>-->
						</th>
						</tr>
						</form>
						<?php if(is_array($teams)){foreach($teams AS $index=>$one) { 
								$bregistro =  true; 
								$cidade = $cities[$one['city_id']]['name'];	 
								if($cities[$one['city_id']]['name']==""){
									$cidade = "Em todas as cidades - ";	
								}
								$corbg=""; 
							$esgotado 				=	false;
							$aguardando 		 	=	false;
							$oferta_ativa 		 	=	false;
							$oferta_cancelada 	 	=	false;
							$oferta_esgotada 	 	=	false;
							$finalizacao 	 		=	false;
							
							$end_time 				= 	date('YmdHis', $one['end_time']); 
							$date 					= 	date('YmdHis');
   
							if((int)$one['now_number'] >= (int)$one['max_number']){
								$oferta_esgotada=true;
								//$corbg ="blue";
							}  
							else if(((int)$one['now_number'] >= (int)$one['min_number']) and ($end_time  > $date) and (int)$one['max_number'] < (int)$one['now_number']){
								$oferta_ativa 	= true;
							}
							else if(((int)$one['now_number'] < (int)$one['min_number']) and ($end_time  > $date) and (int)$one['max_number'] > (int)$one['now_number']){
								$aguardando 	= true;
							}
							else if(((int)$one['now_number'] >= (int)$one['min_number']) and ($end_time  < $date)){
								$finalizacao 	= true; 
							 
								 
							}
							else if(((int)$one['now_number'] < (int)$one['min_number']) and $end_time  < $date){
								$oferta_cancelada=true;
							}
							 
							// teste
							if($oferta_esgotada){
									$bandeira = "Flag-red.ico";
									$title = "Produto Esgotada";
							}
							else if($oferta_cancelada){
									$bandeira = "Flag-red.ico";
									$title = "Produto cancelada. A data final do Produto foi alcançado e o mínimo de (".$one['min_number'].") compradore(s) não foi alcançado.";
							}
							else if($aguardando ){
									$bandeira = "Flag-yellow.ico";
									$title = "Aguardando ativação. Mínimo de (".$one['min_number'].") compradore(s) não alcançado. Atual (".$one['now_number'].") compradore(s).";
							}	
							else if($finalizacao ){
									$bandeira = "Flag-blue.ico";
									$title = "Data do Produto finalizada porém o mínimo de (".$one['min_number'].") compradore(s) foi alcançado. Atual (".$one['now_number'].") compradore(s).";
							}
							else  { // Produto ativa
									$bandeira = "Flag-green.ico";
									$title = "Produto ativo. Mínimo de (".$one['min_number'].") compradore(s) alcançado. Atual (".$one['now_number'].") compradore(s).";
							}
							
							if($one['team_type']=="especial" or $one['team_type']=="off" or $one['team_type']=="participe"){
								$title = "Para este tipo de Produto não existem regras para ativação";
							 } 
							$partner = Table::Fetch('user', $one['partner_id']);
							$groups = Table::Fetch('category', $one['group_id']);
							if($one['posicionamento']==5){
								$corbg ="red";
							}
							
							if($one['moderacao'] == "Y") {
								$FundoCampo = "#008B00";
								$moderacao = "Publicado";
							} else {
								$FundoCampo = "#FF0000";
								$moderacao = "Não publicado";
							}
						 ?>
						<?php $oldstate = $one['state']; ?>
						<?php $one['state'] = team_state($one); ?>
						<tr <?php echo $index%2?'class="normal"':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
							<td style="background:<?=$corbg?>" ><?php echo $one['id']; ?> <!-- <img alt="<?=$title?>" title="<?=$title?>" src="/media/css/i/<?=$bandeira?>" style="width: 22px;"> --></td>
							<td><?php echo $one['title']; ?></td> 
							<td nowrap style="background:<?php echo $FundoCampo; ?>;"><?php  echo $moderacao;   ?>  </td> 
							<td nowrap><?php echo empty($one['marca_produto']) ? "-" : $one['marca_produto']; ?></td> 
							<td nowrap style="color:#F77274;font-weight:bold;"><?php echo empty($one['condicoes_produto']) ? "-" : $one['condicoes_produto']; ?></td> 
							<td nowrap><?php  if($groups['name']){ echo $groups['name'];} else { echo "-";  }   ?>  </td> 
							<td nowrap><?php  echo empty($partner['login']) ? $partner['username'] : $partner['login']; ?></td>  
							<td nowrap><?php echo $one['now_number'] ?></td> 
							<td nowrap><span class="money">De <?php echo $currency; ?></span><?php echo moneyit3($one['market_price']); ?> <br>Por <span class="money"><?php echo $currency; ?></span><?php echo moneyit3($one['team_price']); ?></td>
							<td class="op" nowrap>
							<!--<div style="float: left; margin-right: 2px;"><a  target="_blank" href="<?=$ROOTPATH?>/produto/<?=$one['id']?>"><img alt="Visualizar Produto" title="Visualizar Produto" src="/media/css/i/Monitoring.ico" style="width: 22px;"></a></div> -->
							<div style="float: left; margin-right: 2px;"><a href="/vipmin/team/edit.php?id=<?php echo $one['id']; ?>"><img alt="Editar Produto" title="Editar Produto" src="/media/css/i/editar.png" style="width: 22px;"></a></div>
							<!--<div style="float: left; margin-right: 2px;"><a href="/vipmin/team/atributos.php?id=<?php echo $one['id']; ?>"><img alt="Gerenciar Atributos" title="Gerenciar Atributos" src="/media/css/i/atribute.png" style="width: 22px;"></a></div>-->
							<div style="float: left; margin-right: 2px;"><a href="/ajax/manage.php?action=teamremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar essa Produto?" ><img alt="Excluir" title="Excluir" style="width: 17px;" src="/media/css/i/excluir.png"></a></div>
							<div style="float: left; margin-right: 2px;"><a href="<?=$ROOTPATH?>/vipmin/user/question.php?id=&produto=<?php echo $one['id']; ?>"  ><img alt="Excluir" title="Ver todas as perguntas deste anúncio" style="width: 17px;" src="/media/css/i/question-icon.png"></a></div>
							<?php if($one['moderacao'] != "Y") { ?>
								<div style="float: left; margin-right: 2px;"><a href="/ajax/manage.php?action=teammoderar&id=<?php echo $one['id']; ?>" class="ajaxlink" ><img alt="Moderar" title="Moderar" style="width: 17px;" src="/media/css/i/Play-1-Normal-icon.png"></a></div>
							<?php } else { ?>
							<div style="float: left; margin-right: 2px;"><a href="/ajax/manage.php?action=teampausar&id=<?php echo $one['id']; ?>" class="ajaxlink" ><img alt="Pausar" title="Pausar" style="width: 17px;" src="/media/css/i/Stop-Normal-Red-icon.png"></a></div>
							<?php } ?>
							<!--<div style="float: left; margin-right: 2px;"><a target="_blank" href="/templates/newsletter_oferta_modelo3.php?idoferta=<?php echo $one['id']; ?>"><img alt="Visualizar envio de newsletter. Caso tenha conhecimentos em HTML, você pode alterar essa template de newsletter acessando o diretório Templates, através de um programa de FTP. Ou se preferir, verifique nossos planos de criação de campanhas para newsletter" title="Visualizar envio de newsletter. Caso tenha conhecimentos em HTML, você pode alterar essa template de newsletter acessando o diretório Templates, através de um programa de FTP. Ou se preferir, verifique nossos planos de criação de campanhas para newsletter" style="width: 22px;" src="/media/css/i/detalhe2.png"></a></div>
							<div style="float: left; margin-right: 2px;"><a href="/ajax/manage.php?action=teamdetail&id=<?php echo $one['id']; ?>" class="processar"><img alt="Enviar newsletter" title="Enviar newsletter" style="width: 22px;" src="/media/css/i/email.png"></a></div>-->
							
							<?php 
								$sql =  "SELECT count(id) as total FROM `coupon` where team_id = ".$one['id']; 
								$rs = mysql_query($sql);
								$linha = mysql_fetch_object($rs);
								$total = $linha->total;
							   
							   if($total  > 0 ){ 
									
								?>
							 
								<div style="float: left; margin-right: 2px;"><a href="/vipmin/team/down.php?id=<?php echo $one['id']; ?>" target="_blank"><img alt="Fazer download de <?=$total?> cupon(s) disponíveis" title="Fazer download de <?=$total?> cupon(s) disponíveis" style="width: 22px;" src="/media/css/i/cupom.png"></a></div>
							
							<?php } ?>
							<div style="float: left; margin-right: 2px;"><a href="/ajax/manage.php?action=duplicar&id=<?php echo $one['id']; ?>" class="processar"  ><img alt="Duplicar ProdutO. Após duplicar, Inlclua as imagens do produto duplicado." title="Duplicar Produto. Após duplicar, Inlclua as imagens do produto duplicado." style="width: 22px;" src="/media/css/i/icon-48-media.png"></a></div>
						 	
							</td>
						</tr>
						<?php }} ?>
						<?if(!$bregistro){?><tr><td colspan="13" style="text-align: center;">Nenhum registro encontrado. Redefina sua pesquisa</tr><? } ?>
						<tr><td colspan="12"><?php echo $pagestring; ?></tr>
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
 </script>
    <script>
  function msg(){
		//jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Deletando este Produto...</div>"});
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
	window.open(url + '/vipmin/team/pdf.php?'+params, '_blank');
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
	window.open(url + '/vipmin/team/excel.php?'+params, '_blank');
}
 </script>
 