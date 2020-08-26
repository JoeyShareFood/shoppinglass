<?php include template("manage_header");?>

<div id="bdw" class="bdw">
<div id="bd" class="cf">
<div id="coupons"> 
    <div id="content" class="coupons-box clear mainwide">
		<div class="box clear"> 
            <div class="box-content"> 			
				 <div class="option_box">
				 <div class="top-heading group"> <div class="left_float"><h4>Pagamentos a combinar</h4></div> </div>					
						<div class="sect">
							<table id="orders-list" cellspacing="0" cellpadding="0" border="0" class="coupons-table">
								<tr>
									<th width="50">ID</th>
									<th width="200">Anúncio</th>
									<th width="200">Cliente</th>
									<th width="360">Conteúdo</th>
									<th width="80">Data</th>
									<th width="100">Operação</th>
								</tr>
								<?php if(is_array($asks)){foreach($asks AS $index=>$one) { 	

								$user = Table::Fetch('user', $one['user_id']);	
								$team = Table::Fetch('team', $one['team_id']);	

								?>
								<tr <?php echo $index%2?'':'class="alt"'; ?> id="team-list-id-<?php echo $one['id']; ?>">				
									<td nowrap><?php echo $one['id']; ?></td>	
									<td nowrap><?php echo $team['title']; ?></td>	
									<td nowrap><?php echo $user['realname']; ?></td>
									<td><?php echo  $one['content']; ?></td>
									<td nowrap> <?php echo date('d/m/Y H:i', strtotime($one['create_time'])); ?></td>
									<td class="op" nowrap>
										 <a href="/ajax/manage.php?action=feeddel&id=<?php echo $one['id']; ?>" class="remove-record" ask="Você tem certeza que deseja apagar este registro?" ><img alt="Excluir" title="Excluir" style="width: 22px;" src="/media/css/i/excluir.png"></a>
									</td>
								</tr>
								<?php }}?>
								<tr>
									<td colspan="6"><?php echo $pagestring; ?>
								</tr>
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
  function msg(){
	  jQuery.colorbox({html:"<div class='msgsoft'><img src='<?=$PATHSKIN?>/images/ajax-loader2.gif'> Deletando este registro...</div>"});
}
</script>