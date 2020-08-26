<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content">
               	<div class="option_box"> 
					<div class="top-heading group"> <div class="left_float"><h4>Respostas</h4></div> 
					</div> 
             	<div class="paginacaotop" style="width:50%"><?php echo $pagestring; ?></div>
				<div> 
				</div> 
				
                <div class="sect" style="clear:both;">
					<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
					  
					<form method="get">
					<tr>
					<th width="60">ID<input value ="<?=$_REQUEST['id']?>" type="text"  name="id"  id="id" style="width: 90%;color:#303030;font-size:11px;"> </th>
					 <th width="30">Produto</th>
					<th width="30">Vendedor </th>
					<th width="30">Cliente </th>					
					<th width="100">Resposta</th>
					<th width="100">Data </th>
					   
					<th width="190"> 
					<button style="width: 60px;" type="submit"><span>Buscar</span></button>
					<button style="width: 60px"  onclick="resetFilter()" type="button"><span>Limpar</span></button>
					</th>
					</tr>
					</form>
				   
				    <?php if(is_array($users)){foreach($users AS $index=>$one) { $bregistro =  true; ?>
					
					<?php
						
						$sql = "select login, realname from user where id = " . $one['id_cliente'];
						$rs = mysql_query($sql);
						$rowP = mysql_fetch_assoc($rs);
						
						$question = Table::Fetch('questions', $one['id_questions']);
						$team = Table::Fetch('team', $question['id_produto']);
						
						$sql = "select login, realname from user where id = " . $team['partner_id'];
						$rs = mysql_query($sql);
						$rowU = mysql_fetch_assoc($rs);
						
					?>
					
					<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">
						<td>#<?php echo $one['id'];?></td>
						<td><?php echo $team['title']; ?></td>
						<td><?php echo empty($rowU['login']) ? $rowU['realname'] : $rowU['login']; ?></td>
						<td><?php echo empty($rowP['login']) ? $rowP['realname'] : $rowP['login']; ?></td> 
						<td><?php echo $one['resposta'];?></td> 
						<td><?php echo $one['data']; ?></td> 
						<td class="op">
							<a href="javascript:DetalheAnswer('<?php echo $one['id']; ?>')" ><img alt="Detalhes do usuário" title="Detalhes do usuário" src="/media/css/i/detalhe2.png" style="width: 22px;"></a>
							<a href="/ajax/manage.php?action=answerProductremove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja apagar essa resposta ?" ><img alt="Excluir" title="Excluir" style="width: 22px;" src="/media/css/i/excluir.png"></a>
							<?php
								if(empty($one['status'])) {
							?>
							<a href="<?php echo $ROOTPATH; ?>/ajax/manage.php?action=answerApprove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja aprovar essa resposta ?" >
								<img alt="Aprovar mensagem" title="Aprovar mensagem" style="width: 22px;" src="/media/css/i/Play-1-Normal-icon.png">
							</a>							
							<a href="<?php echo $ROOTPATH; ?>/ajax/manage.php?action=answerDisapprove&id=<?php echo $one['id']; ?>" class="ajaxlink" ask="Você tem certeza que deseja reprovar essa resposta ?" >
								<img alt="Reprovar mensagem" title="Reprovar mensagem" style="width: 22px;" src="/media/css/i/Stop-Normal-Red-icon.png">
							</a>
							<?php } ?>
						</td>
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
function DetalheAnswer(id){
	jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Buscando informações... </div>"});
	$.get(WEB_ROOT+"/include/compiled/manage_ajax_dialog_question.php?id="+id,
	function(data){ 
		jQuery.colorbox({html:data});
	}); 
} 
</script>